<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Bouncer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (! Auth::guard($guard)->check()) {
            return redirect()->route('admin.session.index');
        }

        $this->checkIfAuthorized($request);

        return $next($request);
    }

    public function checkIfAuthorized($request)
    {
        //pending: 有待完善角色和权限的功能
    }
}
