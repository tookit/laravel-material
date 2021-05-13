<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AccessControll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission, $guard = 'api')
    {
        if(self::getUser($guard)->isRoot()) {
            //skip acl
            return $next($request);
        } else {
            if (Auth::guard($guard)->guest()) {
                throw UnauthorizedException::notLoggedIn();
            }
    
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
    
    
            if (! self::getUser($guard)->hasAnyPermission($permissions) ) {
                throw UnauthorizedException::forPermissions($permissions);
            }
    
        }
 
        return $next($request);
    }


    /**
     * @return \App\Models\User
     */
    public static function getUser($guard = 'api')
    {
        return Auth::guard('api')->user();
    }
}
