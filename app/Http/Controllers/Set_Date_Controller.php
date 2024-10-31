<?php

namespace App\Http\Controllers;

use App\Models\Trans_Survey;
use Illuminate\Http\Request;
use Session;

class Set_Date_Controller extends Controller
{
    public function index()
    {
        $t_date = Trans_Survey::all();
        $sent = [
            't_date' => $t_date,
        ];
        return view('set_date.index', $sent);
    }

    public function store(Request $request)
    {
        $request->validate([
            'trans_date' => 'required',
        ]);
        $selectedYear = $request->input('trans_date');
        session(['selected_year' => $selectedYear]);
        // dd(session()->all());
        // return redirect('')
        return redirect()->route('home.index')->with('success', 'Berhasil mengubah setting data');
        // return redirect()->back()->with('success', 'Berhasil mengubah setting data');

    }
}
