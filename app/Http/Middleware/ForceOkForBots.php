<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to ensure Google bots and crawlers always receive HTTP 200.
 * 
 * Some hosting providers (Apache + ModSecurity/WAF) override the response 
 * status code to 403 for non-browser requests. This middleware intercepts
 * the response AFTER it's generated and forces 200 if the original 
 * response was successful content but got stamped with 403.
 */
class ForceOkForBots
{
    /**
     * Known bot user-agent patterns that should always receive 200.
     */
    protected array $botPatterns = [
        'AdsBot-Google',
        'Googlebot',
        'Google-Extended',
        'Mediapartners-Google',
        'APIs-Google',
        'bingbot',
        'Baiduspider',
        'YandexBot',
        'facebookexternalhit',
        'Twitterbot',
        'LinkedInBot',
        'WhatsApp',
        'TelegramBot',
        'curl',
        'wget',
        'python-requests',
        'PostmanRuntime',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // If response is 403 but has HTML content, it's likely WAF interference
        // Force it back to 200 for all requests
        if ($response->getStatusCode() === 403) {
            $contentType = $response->headers->get('Content-Type', '');

            if (str_contains($contentType, 'text/html')) {
                $response->setStatusCode(200);
            }
        }

        return $response;
    }
}
