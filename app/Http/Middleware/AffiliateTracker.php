<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AffiliateTracker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->has('ref')) {
            // Check if the affiliate exists with this affiliate code
            $affiliate = \App\Models\Affiliate::where('affiliate_code', $request->query('ref'))->first();
            
            if ($affiliate) {
                // Set cookie for 30 days (43200 minutes)
                return $response->cookie('affiliate_ref', $affiliate->affiliate_code, 43200);
            }
        }

        return $response;
    }
}
