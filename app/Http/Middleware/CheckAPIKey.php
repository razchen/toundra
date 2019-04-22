<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckAPIKey
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
        $user = User::where('api_key',request()->input('api_key'))->first();
        if (!$user) {
            return response()->JSON('User not found');
        }
        Auth::loginUsingId($user->id);
        return $next($request);
    }
}
