<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Auth;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        
        if ($user->session !== null) {
        // token sudah ada, pengguna tidak dapat login dari perangkat lain
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        }
        
        $session = Str::random(32);
        
        $user->session = $session;
        $user->save();

        Auth::login($user);
        Session::put('selected_year', '');

        return $this->authenticated($request, $user)->with('success', "Account successfully login.");
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
