<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserRole;

class CheckOrganizer
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 