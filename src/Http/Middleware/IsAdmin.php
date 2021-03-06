<?php

namespace Mvd81\LaravelIsAdmin\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::user()) {
            return redirect(route('login'));
        }

        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
