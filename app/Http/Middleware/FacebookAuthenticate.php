<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class FacebookAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user.id') || Session::get('user.role') != 'ADMINISTER') {
            return redirect('/');
        }
        return $next($request);
    }
}