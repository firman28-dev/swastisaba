<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Session;

class LogoutController extends Controller
{
    public function perform()
    {
        $user = Auth::user();

        
        if ($user) {
            $user->session = null; // Hapus token
            $user->save(); // Simpan perubahan
        }

        Session::flush();
        Session::put('selected_year', '');
    

        Auth::logout();
        return redirect('login');
    }
}
