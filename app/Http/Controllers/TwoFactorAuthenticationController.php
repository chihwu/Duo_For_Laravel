<?php

namespace App\Http\Controllers;

use Auth;
use Duo\Web;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TwoFactorAuthenticationController extends Controller
{
    const SESSION_KEY = 'auth.duo';
 
    public function get()
    {
        return view('duo.2fa', [
            'host'        => config('services.duo.host'),
            'sig_request' => Web::signRequest(
                config('services.duo.integration_key'),
                config('services.duo.secret_key'),
                config('services.duo.application_key'),
                Auth::user()->getAuthIdentifier()
            ),
            'post_action' => url('2fa'),
        ]);
    }
 
    public function post(Request $request)
    {
        $user_id = Web::verifyResponse(
            config('services.duo.integration_key'),
            config('services.duo.secret_key'),
            config('services.duo.application_key'),
            $request->input('sig_response')
        );
 
        if ($user_id == Auth::user()->getAuthIdentifier()) {
            $request->session()->put(self::SESSION_KEY, $user_id);
 
            return redirect()->intended('/duo');
        } else {
            abort(Response::HTTP_UNAUTHORIZED);
        }
    }

}
