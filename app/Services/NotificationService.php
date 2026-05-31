<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Services\FcmService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected FcmService $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    /**
     * Store notification in database, send FCM push notification, and optionally send email.
     */
    public function notify(
        User $user,
        string $title,
        string $message,
        string $type,
        bool $sendEmail = false,
        ?string $mailableClass = null,
        array $mailableParams = []
    ): Notification {
        // 1. Create in-app notification record
        $notification = Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
        ]);

        // 2. Dispatch FCM push notification
        try {
            $this->fcmService->sendToUser($user, $title, $message, [
                'type' => $type,
                'notification_id' => (string) $notification->id,
            ]);
        } catch (\Exception $e) {
            Log::error('NotificationService: Failed to send FCM push to user #' . $user->id . ': ' . $e->getMessage());
        }

        // 3. Send email if requested
        if ($sendEmail && $mailableClass && class_exists($mailableClass)) {
            try {
                Mail::to($user->email)->send(new $mailableClass(...$mailableParams));
            } catch (\Exception $e) {
                Log::error('NotificationService: Failed to send email to ' . $user->email . ': ' . $e->getMessage());
            }
        }

        return $notification;
    }
}
