<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeoHelper
{
    /**
     * Non-canonical query parameters that should be stripped to avoid duplicate content penalties.
     */
    protected static array $stripParameters = [
        'sort',
        'page',
        'search',
        'bedrooms',
        'max_price',
        'min_price',
        'max_deposit',
        'search_type',
        'furnished',
        'is_furnished',
        'near_metro',
        'available_now',
        'listed_by',
        'collection',
        'purpose',
        'ref',
        'source',
        'fbclid',
        'gclid',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    /**
     * Generate a clean canonical URL for the current or given URL by stripping filter query params.
     */
    public static function canonicalUrl(?string $url = null): string
    {
        $url = $url ?: url()->current();

        $parsed = parse_url($url);
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? request()->getHost();
        $port = isset($parsed['port']) && !in_array($parsed['port'], [80, 443]) ? ':' . $parsed['port'] : '';
        $path = $parsed['path'] ?? '';
        if ($path !== '') {
            $path = rtrim($path, '/');
        }

        return $scheme . '://' . $host . $port . $path;
    }

    /**
     * Check if a location landing page has enough inventory to be indexable.
     */
    public static function isIndexableLocation(int $propertyCount): bool
    {
        return $propertyCount >= 1;
    }
}
