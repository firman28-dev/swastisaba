<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\M_Group;
use App\Models\M_Level;
use App\Models\M_Zona;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function show()
    {
        $group = M_Group::all();
        $level = M_Level::all();
        $zona = M_Zona::all();

        $sent = [
            'group' => $group,
            'level' => $level,
            'zona' => $zona,
        ];
        return view('auth.register', $sent);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
