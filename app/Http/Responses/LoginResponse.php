<?php

namespace App\Http\Responses;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $link = str_replace(['http://','https://'], ["",""], session()->get('link')) ;
        if($link != $_SERVER['HTTP_HOST'] && $link != $_SERVER['HTTP_HOST']."/login"){
            return redirect(session()->get('link'));
        }

        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended(Fortify::redirects('login'));
    }
}
