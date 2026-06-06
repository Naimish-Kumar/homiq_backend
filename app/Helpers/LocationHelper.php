<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationHelper
{
    /**
     * Detect the country name from an IP address.
     * Caches geolocations for 24 hours.
     *
     * @param string $ip
     * @return string|null
     */
    public static function detectCountryFromIp(string $ip): ?string
    {
        // Don't geolocate local/private IPs
        if (in_array($ip, ['127.0.0.1', '::1']) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return null;
        }

        return Cache::remember("geoip:country:{$ip}", 86400, function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,country");
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['status']) && $data['status'] === 'success') {
                        return $data['country']; // Returns e.g. "India", "United States"
                    }
                }
            } catch (\Exception $e) {
                Log::error("GeoIP lookup failed for IP {$ip}: " . $e->getMessage());
            }

            return null;
        });
    }
}
