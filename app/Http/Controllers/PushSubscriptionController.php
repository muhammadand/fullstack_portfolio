<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PushSubscriptionController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
            'keys.auth' => 'required|string',
            'keys.p256dh' => 'required|string'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];

        // Get the authenticated affiliate
        /** @var \App\Models\Affiliate $affiliate */
        $affiliate = auth()->guard('affiliate')->user();

        if (!$affiliate) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $affiliate->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }
}
