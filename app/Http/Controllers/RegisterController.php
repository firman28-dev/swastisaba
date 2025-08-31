<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\M_District;
use App\Models\M_Group;
use App\Models\M_Level;
use App\Models\M_Zona;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function show()
    {
        $district = M_District::where('province_id',13)->get();
        $group = M_Group::where('registered_id',1)->get();

        $sent = [
            'zona' => $district,
            'group' => $group,
        ];
        return view('auth.register', $sent);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
