<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{

    public function handle($request, Closure $next)
    {
        if (!\Auth::check()) {
            return redirect('signin');
        }

        return $next($request);
    }

}
