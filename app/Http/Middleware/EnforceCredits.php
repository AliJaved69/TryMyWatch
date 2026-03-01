<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnforceCredits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->credits <= 0) {
                return back()->with('error', 'Insufficient credits. Please contact support to top up.');
            }
        } else {
            // For guest, we track via session. If not set, they have 1 credit.
            $guestCredits = session('guest_credits', 1);
            if ($guestCredits <= 0) {
                return back()->with('error', 'Guest credits exhausted. Please sign up for more!');
            }
        }

        return $next($request);
    }
}
