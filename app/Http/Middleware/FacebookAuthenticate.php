<?php
namespace App\Http\Middleware;

use Closure;
use Facebook\Facebook;
use Facebook\Helpers\FacebookCanvasHelper;
use Illuminate\Support\Facades\Config;

class FacebookAuthenticate
{
    public function handle($request, Closure $next)
    {
        $fb = new Facebook(Config::get('facebook'));

        return $next($request);
    }
}