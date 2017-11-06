<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if(Auth::check() && Auth::user()->level_user_id == 1)
        {
            return $next($request);
        }
        else{
            Auth::logout();
            $message = ['flash_level'=>'warning message-custom','flash_message'=>'You not have permission!!!'];
            return redirect()->Route('getLogin')->with($message);
        }
    }
}
