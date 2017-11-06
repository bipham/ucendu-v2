<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckClient
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
//        dd(Auth::check());
        if(Auth::check())
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
