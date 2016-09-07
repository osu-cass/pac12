<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateSuperadmin
{

    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            return redirect('admin-signin');
        } else if (!Session::get('superadmin')) {
            return redirect('admin-signin')->withErrors('You must be logged in as a super administrator to view that page');
        }

        return $next($request);
    }

}

?>
