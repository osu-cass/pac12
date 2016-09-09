<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin
{

    public function handle($request, Closure $next)
    {
        if (\Auth::guest()) {
            return redirect('admin-signin');
        } else if (!\Session::get('admin')) {
            return redirect('admin-signin')->withErrors('You must be logged in as an administrator to view that page');
        }

        return $next($request);
    }

}
