<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'owner') {
            return $next($request);
        }

        // Check subscription_active boolean flag first
        if ($user->subscription_active === false) {
            return redirect()->route('login')->with('error', 'Your subscription is not active. Please contact support.');
        }

        // Check if subscription has expired
        if ($user->subscription_valid_until) {
            $expiresAt = \Carbon\Carbon::parse($user->subscription_valid_until);
            if ($expiresAt->isPast()) {
                $user->update(['subscription_active' => false, 'subscription_status' => 'inactive']);
                return redirect()->route('login')->with('error', 'Your subscription has expired. Please renew to continue using our services.');
            }
        }

        return $next($request);
    }
}
