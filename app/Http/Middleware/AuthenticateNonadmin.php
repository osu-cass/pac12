<?php

namespace App\Http\Middleware;

use Closure;

class AutnenticateNonadmin
{

    public function handle($request, Closure $next)
    {
        if (Auth::check() && Session::get('admin')) {
            return redirect('admin');
        }

        return $next($request);
    }

}

?>
