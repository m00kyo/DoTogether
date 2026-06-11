<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'ADMIN') {
            return $next($request);
        }

        abort(403, 'Brak dostępu. Ta sekcja jest przeznaczona tylko dla administratorów.');
    }
}
