<?php

namespace App\Http\Middleware;

use App\Http\Controllers\TwoFactorAuthenticationController;
use Auth;
use Closure;
use Illuminate\Http\Response;


class DuoTwoFactorAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        } elseif ($request->session()->get(TwoFactorAuthenticationController::SESSION_KEY) == Auth::guard($guard)->user()->getAuthIdentifier()) {
            return $next($request);
        } else {
            return redirect()->guest('/2fa');
        }
    }

}
