<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== 'warga') {
            abort(403, 'Halaman ini hanya dapat diakses oleh pelanggan.');
        }

        return $next($request);
    }
}
