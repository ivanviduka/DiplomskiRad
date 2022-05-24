<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $parameter = isset($request->route()->parameters()['file']) ?
            $request->route()->parameters()['file'] :
            $request->route()->parameters()['comment'];

        if (($parameter->user_id != auth()->user()->id) && !auth()->user()->is_admin) {
            abort(403, 'Forbidden access');
        }
        return $next($request);
    }
}
