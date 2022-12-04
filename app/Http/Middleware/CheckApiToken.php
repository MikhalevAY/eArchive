<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
{
    public const TOKEN = '4b6e5f80-25bc-11ed-9a97-51b27ed58952';

    public function handle(Request $request, Closure $next)
    {
        abort_if($request->header('token') != self::TOKEN, 404);
        return $next($request);
    }
}
