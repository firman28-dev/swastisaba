<?php

namespace App\Http\Controllers;

use App\Models\Trans_Survey;
use Illuminate\Http\Request;

class Set_Year_controller extends Controller
{
    public function index()
    {
        $t_date = Trans_Survey::all();
        $sent = [
            't_date' => $t_date,
        ];
        return view('set_date.index', $sent);
    }
}
