<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsTechnician
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isTechnician()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh teknisi.');
        }

        return $next($request);
    }
}
