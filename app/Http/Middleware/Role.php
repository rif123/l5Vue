<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = \Auth::user()->userroles->role_name;
        if ($role == 'super' || 'admin' || 'developer' ) {
          return $next($request);
        }
        
        return response('Tidak bisa diakses', 403);
    }
}
