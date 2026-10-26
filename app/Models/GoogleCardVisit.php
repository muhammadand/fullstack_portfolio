<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GoogleCardVisit extends Model
{
    protected $fillable = [
        'visited_at',
        'session_id',
        'ip_address',
        'source_type',
        'source_name',
        'referer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'device_type',
        'user_agent',
    ];

    protected $casts = [
        'visited_at' => 'date',
    ];

    /**
     * Track a visit from incoming HTTP request with intelligent attribution.
     * Deduplicates multiple rapid reloads from the same session/IP within 15 minutes.
     */
    public static function track(Request $request): ?self
    {
        try {
            $today = now()->toDateString();
            $ip = $request->ip();
            $sessionId = $request->hasSession() ? $request->session()->getId() : null;

            // Debounce: Hindari spam reload F5 (jika sudah terekam dalam 15 menit terakhir)
            $recent = static::where('visited_at', $today)
                ->where(function ($q) use ($ip, $sessionId) {
                    if ($sessionId) {
                        $q->where('session_id', $sessionId);
                    }
                    if ($ip) {
                        $q->orWhere('ip_address', $ip);
                    }
                })
                ->where('created_at', '>=', now()->subMinutes(15))
                ->first();

            if ($recent) {
                return $recent;
            }

            // Klasifikasi Sumber Trafik
            $classification = static::classifySource($request);

            // Klasifikasi Perangkat
            $ua = $request->header('User-Agent', '');
            $deviceType = 'desktop';
            if (preg_match('/Mobile|Android|iPhone|iPod|webOS|BlackBerry|IEMobile|Opera Mini/i', $ua)) {
                $deviceType = 'mobile';
            } elseif (preg_match('/Tablet|iPad/i', $ua)) {
                $deviceType = 'tablet';
            }

            return static::create([
                'visited_at'    => $today,
                'session_id'    => $sessionId,
                'ip_address'    => $ip,
                'source_type'   => $classification['type'],
                'source_name'   => $classification['name'],
                'referer'       => substr($request->header('Referer', ''), 0, 500) ?: null,
                'utm_source'    => substr($request->query('utm_source', $request->query('src', $request->query('ref', ''))), 0, 100) ?: null,
                'utm_medium'    => substr($request->query('utm_medium', ''), 0, 100) ?: null,
                'utm_campaign'  => substr($request->query('utm_campaign', ''), 0, 100) ?: null,
                'device_type'   => $deviceType,
                'user_agent'    => substr($ua, 0, 500) ?: null,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('GoogleCardVisit tracking failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Klasifikasikan sumber trafik menjadi 4 kanal utama:
     * 1. 'seo'     : Google, Bing, Yahoo, Yandex, DuckDuckGo, AI Search (ChatGPT, Perplexity)
     * 2. 'social'  : Threads, Instagram, Facebook, TikTok, X/Twitter, LinkedIn, YouTube
     * 3. 'shared'  : WhatsApp, Telegram, Salin Link / Share buttons
     * 4. 'direct'  : Direct URL, Bookmark, atau sumber tanpa referer
     */
    public static function classifySource(Request $request): array
    {
        $rawSrc = strtolower(trim($request->query('src', $request->query('ref', $request->query('utm_source', '')))));
        $referer = strtolower(trim($request->header('Referer', '')));
        $refererHost = '';

        if (!empty($referer)) {
            $parsed = parse_url($referer);
            $refererHost = $parsed['host'] ?? '';
        }

        // 1. Prioritas Pertama: Parameter Query Eksplisit (?src=... atau ?ref=... atau ?utm_source=...)
        if (!empty($rawSrc)) {
            // Yang Dibagikan (WhatsApp / Share link)
            if (in_array($rawSrc, ['wa', 'whatsapp'])) {
                return ['type' => 'shared', 'name' => 'WhatsApp'];
            }
            if (in_array($rawSrc, ['share', 'salin', 'copy', 'bagikan'])) {
                return ['type' => 'shared', 'name' => 'Link Dibagikan'];
            }
            if (in_array($rawSrc, ['telegram', 'tele', 'tg'])) {
                return ['type' => 'shared', 'name' => 'Telegram'];
            }

            // Media Sosial
            if (in_array($rawSrc, ['threads', 'thread'])) {
                return ['type' => 'social', 'name' => 'Threads'];
            }
            if (in_array($rawSrc, ['ig', 'instagram'])) {
                return ['type' => 'social', 'name' => 'Instagram'];
            }
            if (in_array($rawSrc, ['fb', 'facebook'])) {
                return ['type' => 'social', 'name' => 'Facebook'];
            }
            if (in_array($rawSrc, ['tiktok', 'tt'])) {
                return ['type' => 'social', 'name' => 'TikTok'];
            }
            if (in_array($rawSrc, ['twitter', 'x'])) {
                return ['type' => 'social', 'name' => 'X (Twitter)'];
            }
            if (in_array($rawSrc, ['youtube', 'yt'])) {
                return ['type' => 'social', 'name' => 'YouTube'];
            }
            if (in_array($rawSrc, ['linkedin'])) {
                return ['type' => 'social', 'name' => 'LinkedIn'];
            }

            // SEO / Search
            if (in_array($rawSrc, ['google', 'organic', 'seo', 'gsearch'])) {
                return ['type' => 'seo', 'name' => 'Google Search'];
            }
            if (in_array($rawSrc, ['bing'])) {
                return ['type' => 'seo', 'name' => 'Bing Search'];
            }
        }

        // 2. Prioritas Kedua: HTTP Referer Header
        if (!empty($refererHost)) {
            // Search Engines (SEO)
            if (str_contains($refererHost, 'google.')) {
                return ['type' => 'seo', 'name' => 'Google Search'];
            }
            if (str_contains($refererHost, 'bing.com')) {
                return ['type' => 'seo', 'name' => 'Bing Search'];
            }
            if (str_contains($refererHost, 'yahoo.')) {
                return ['type' => 'seo', 'name' => 'Yahoo Search'];
            }
            if (str_contains($refererHost, 'duckduckgo.com')) {
                return ['type' => 'seo', 'name' => 'DuckDuckGo'];
            }
            if (str_contains($refererHost, 'yandex.')) {
                return ['type' => 'seo', 'name' => 'Yandex'];
            }
            if (str_contains($refererHost, 'ecosia.org')) {
                return ['type' => 'seo', 'name' => 'Ecosia'];
            }
            if (str_contains($refererHost, 'chatgpt.com') || str_contains($refererHost, 'perplexity.ai')) {
                return ['type' => 'seo', 'name' => 'AI Search (ChatGPT/Perplexity)'];
            }

            // Social Media Networks
            if (str_contains($refererHost, 'threads.net')) {
                return ['type' => 'social', 'name' => 'Threads'];
            }
            if (str_contains($refererHost, 'instagram.com')) {
                return ['type' => 'social', 'name' => 'Instagram'];
            }
            if (str_contains($refererHost, 'facebook.com') || str_contains($refererHost, 'fb.com') || str_contains($refererHost, 'messenger.com')) {
                return ['type' => 'social', 'name' => 'Facebook'];
            }
            if (str_contains($refererHost, 'tiktok.com')) {
                return ['type' => 'social', 'name' => 'TikTok'];
            }
            if (str_contains($refererHost, 'twitter.com') || str_contains($refererHost, 't.co') || str_contains($refererHost, 'x.com')) {
                return ['type' => 'social', 'name' => 'X (Twitter)'];
            }
            if (str_contains($refererHost, 'linkedin.com')) {
                return ['type' => 'social', 'name' => 'LinkedIn'];
            }
            if (str_contains($refererHost, 'pinterest.com')) {
                return ['type' => 'social', 'name' => 'Pinterest'];
            }
            if (str_contains($refererHost, 'youtube.com') || str_contains($refererHost, 'youtu.be')) {
                return ['type' => 'social', 'name' => 'YouTube'];
            }

            // Chat & Messaging (Yang Dibagikan)
            if (str_contains($refererHost, 'whatsapp.com') || str_contains($refererHost, 'wa.me')) {
                return ['type' => 'shared', 'name' => 'WhatsApp'];
            }
            if (str_contains($refererHost, 'telegram.org') || str_contains($refererHost, 't.me')) {
                return ['type' => 'shared', 'name' => 'Telegram'];
            }

            // Referral dari domain sendiri
            $appHost = parse_url(config('app.url'), PHP_URL_HOST);
            if ($appHost && str_contains($refererHost, $appHost)) {
                return ['type' => 'direct', 'name' => 'Internal Link'];
            }

            // Referral dari website lain
            return ['type' => 'shared', 'name' => 'Website Referral (' . $refererHost . ')'];
        }

        // 3. Fallback: Direct Traffic (Bookmark, direct URL, atau buka langsung)
        return ['type' => 'direct', 'name' => 'Direct / Bookmark'];
    }
}
