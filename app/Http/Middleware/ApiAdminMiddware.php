<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAdminMiddware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(auth()->user()->tokenCan('server:admin')){

            }else{
                return response()->json([
                    'message' => 'Access Denied.! You are not Admin.',
                ], 403);
            }
        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Please login first',
            ]);
        }

        return $next($request);
    }
}
