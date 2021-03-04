<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;

class RegistrationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->has('token')) {
            return abort(404);
        }

        $validToken = Shop::where('registration_token', $request->token)->exists();

        if(!$validToken) {
            return redirect(route('home'))->with('error', __('Invalid token'));
        }

        return $next($request);
    }
}
