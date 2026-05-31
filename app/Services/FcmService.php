<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FcmService
{
    private ?string $projectId = null;
    private ?array $serviceAccount = null;

    public function __construct()
    {
        $this->loadServiceAccount();
    }

    /**
     * Load the Firebase service account credentials.
     */
    private function loadServiceAccount(): void
    {
        $path = storage_path('app/firebase-service-account.json');

        if (!file_exists($path)) {
            Log::warning('FCM: Firebase service account JSON not found at: ' . $path);
            return;
        }

        $json = json_decode(file_get_contents($path), true);
        if (!$json || !isset($json['project_id'])) {
            Log::error('FCM: Invalid Firebase service account JSON.');
            return;
        }

        $this->serviceAccount = $json;
        $this->projectId = $json['project_id'];
    }

    /**
     * Get an OAuth2 access token for FCM v1 API.
     */
    private function getAccessToken(): ?string
    {
        if (!$this->serviceAccount) {
            return null;
        }

        // Cache the token for 55 minutes (tokens expire in 60 min)
        return Cache::remember('fcm_access_token', 55 * 60, function () {
            $now = time();
            $header = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $payload = base64_encode(json_encode([
                'iss' => $this->serviceAccount['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ]));

            // URL-safe base64
            $header = str_replace(['+', '/', '='], ['-', '_', ''], $header);
            $payload = str_replace(['+', '/', '='], ['-', '_', ''], $payload);

            $unsigned = $header . '.' . $payload;

            $privateKey = openssl_pkey_get_private($this->serviceAccount['private_key']);
            if (!$privateKey) {
                Log::error('FCM: Failed to parse private key.');
                return null;
            }

            openssl_sign($unsigned, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

            $jwt = $unsigned . '.' . $signature;

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('FCM: Failed to get access token.', ['response' => $response->body()]);
            return null;
        });
    }

    /**
     * Send a push notification to a specific user.
     */
    public function sendToUser(User $user, string $title, string $body, array $data = []): bool
    {
        if (empty($user->fcm_token)) {
            Log::info("FCM: No FCM token for user #{$user->id}, skipping push.");
            return false;
        }

        return $this->sendToToken($user->fcm_token, $title, $body, $data);
    }

    /**
     * Send a push notification to a specific device token.
     */
    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        if (!$this->projectId) {
            Log::warning('FCM: Service account not configured, skipping push notification.');
            return false;
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            Log::error('FCM: Cannot send push, no valid access token.');
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        // Ensure all data values are strings (FCM requirement)
        $stringData = [];
        foreach ($data as $key => $value) {
            $stringData[$key] = (string) $value;
        }

        $message = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'channel_id' => 'homiq_notifications',
                        'sound' => 'default',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                            'badge' => 1,
                        ],
                    ],
                ],
            ],
        ];

        if (!empty($stringData)) {
            $message['message']['data'] = $stringData;
        }

        try {
            $response = Http::withToken($accessToken)
                ->post($url, $message);

            if ($response->successful()) {
                Log::info("FCM: Push sent successfully to token: " . substr($token, 0, 20) . '...');
                return true;
            }

            Log::error('FCM: Push failed.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // Clear cached token if unauthorized (expired)
            if ($response->status() === 401) {
                Cache::forget('fcm_access_token');
            }

            return false;
        } catch (\Exception $e) {
            Log::error('FCM: Exception sending push.', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
