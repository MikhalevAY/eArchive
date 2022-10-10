<?php

namespace App\Http\Middleware;

use App\Models\MenuItem;
use Closure;
use Illuminate\Http\Request;

class CheckUserPermission
{
    public function handle(Request $request, Closure $next)
    {
        $menuItems = getUserAccess(auth()->user()->role);
        $pageUrlId = MenuItem::where('url', request()->segment(1))->first();

        if ($pageUrlId && in_array($pageUrlId->id, $menuItems)) {
            return $next($request);
        }

        abort(404);
    }
}
