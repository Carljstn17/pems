<?php

namespace App\Http\Middleware;

use Closure;

class CustomVerificationMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && ! $request->user()->hasVerifiedEmail()) {
            return redirect('/verify-email');
        }

        return $next($request);
    }
}

