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
        // HTTP Basic Authentication
        if (Auth::guard($guard)->guest()) {
            // Basic authentication is not set.
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        } elseif ($request->session()->get(TwoFactorAuthenticationController::SESSION_KEY) == Auth::guard($guard)->user()->getAuthIdentifier()) {
            return $next($request);
        } else {
            // Duo Authentication
            // Basic authentication is set, but the duo middleware is not set.
            return redirect()->guest('/2fa');
        }
    }

}
