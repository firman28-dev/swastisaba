<?php

namespace App\Http\Controllers;

use App\Models\M_General_Data;
use App\Models\M_Zona;
use Illuminate\Http\Request;

class M_General_Data_Controller extends Controller
{
    public function index()
    {
        $g_data = M_General_Data::all();
        $zona = M_Zona::all();
        return view('admin.general_data.index', compact('zona'));
    }

    public function showGData($id)
    {
        $zona = M_Zona::find($id);
        $g_data = M_General_Data::select('m_general_data.*','m_zona.name as name_zona')
            ->leftJoin('m_zona', 'm_general_data.id_zona', '=', 'm_zona.id')
            ->where('m_general_data.id_zona',$id)
            ->first();

        $sent = [
            'zona' => $zona,
            'g_data' => $g_data
        ];

        return view("admin.general_data.index_v2", $sent);

    }

    
    public function create($id)
    {
        $zona = M_Zona::find($id);
        return view('admin.general_data.create', compact('zona'));
    }

    public function store(Request $request)
    {

    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {

    }

   
    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        
    }
}
