<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Jenssegers\Date\Date;

class App
{
    public function handle($request, Closure $next)
    {
        Date::setLocale(Config::get('app.locale'));
        return $next($request);
    }
}