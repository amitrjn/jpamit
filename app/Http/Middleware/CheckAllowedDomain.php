<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAllowedDomain
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $userDomain = explode('@', auth()->user()->email)[1];
            $allowedDomains = explode(',', config('auth.allowed_domains'));

            if (!in_array($userDomain, $allowedDomains)) {
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Your email domain is not authorized.');
            }
        }

        return $next($request);
    }
} 