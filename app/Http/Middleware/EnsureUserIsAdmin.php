<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->can('access-admin')) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }

        return $next($request);
    }
}
