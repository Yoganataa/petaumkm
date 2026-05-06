<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('user_id') || session('role') !== 'admin') {
            return redirect('/login')->with('error', 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
