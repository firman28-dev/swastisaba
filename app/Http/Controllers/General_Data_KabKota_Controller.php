<?php

namespace App\Http\Controllers;

use App\Models\M_General_Data;
use App\Models\M_Zona;
use Auth;
use Illuminate\Http\Request;
use Session;

class General_Data_KabKota_Controller extends Controller
{
    public function index(){
        $user = Auth::user();
        $idZona = $user->id_zona;
        // $selectedYear = Session::get('selected_year'); 
        $g_data = M_General_Data::where('id_zona', $idZona)->first();
        return view('operator_kabkota.general_data.index', compact('g_data'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;

        $name_zona = M_Zona::where('id', $idZona)->first();
        $g_data = M_General_Data::find($id);
        $sent = [
            'idZona' => $idZona,
            'nameZona' =>  $name_zona,
            'generalData' => $g_data
        ];

        return view('operator_kabkota.general_data.edit', $sent);
    }

    public function create(){
        $user = Auth::user();
        $idZona = $user->id_zona;
        $name_zona = M_Zona::where('id', $idZona)->first();

        $sent = [
            'idZona' => $idZona,
            'nameZona' =>  $name_zona
        ];

        return view('operator_kabkota.general_data.create', $sent);
    }

    public function store(Request $request){
        $request->validate([
            'provinsi' => 'required',
            'id_zona' => 'required',
            'nama_wako_bup' => 'required',
            'alamat_kantor' => 'required',
            'nama_pembina' => 'required',
            'nama_forum' => 'required',
            'nama_ketua_forum' => 'required',
            'alamat_kantor_forum' => 'required'
        ]);

        try{
            $g_data = new M_General_Data();
            $g_data->provinsi = $request->provinsi;
            $g_data->id_zona = $request->id_zona;
            $g_data->nama_wako_bup = $request->nama_wako_bup;
            $g_data->alamat_kantor = $request->alamat_kantor;
            $g_data->nama_pembina = $request->nama_pembina;
            $g_data->nama_forum = $request->nama_forum;
            $g_data->nama_ketua_forum = $request->nama_ketua_forum;
            $g_data->alamat_kantor_forum = $request->alamat_kantor_forum;

            $g_data->save();
            return redirect()->route('g-data.indexKabKota')->with('success', 'Berhasil mengubah data umum');
        }
        catch(\Exception $e){
            return redirect()->back('g-data.createKabKota')->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');

        }   
    }

    public function update(Request $request, $id){
        $request->validate([
            'provinsi' => 'required',
            'id_zona' => 'required',
            'nama_wako_bup' => 'required',
            'alamat_kantor' => 'required',
            'nama_pembina' => 'required',
            'nama_forum' => 'required',
            'nama_ketua_forum' => 'required',
            'alamat_kantor_forum' => 'required'
        ],[
            'provinsi.required' => 'Field Wajib diisi',
            'id_zona.required' => 'Field Wajib diisi',
            'nama_wako_bup.required' => 'Field Wajib diisi',
            'nama_pembina.required' => 'Field Wajib diisi',
            'nama_forum.required' => 'Field Wajib diisi',
            'nama_ketua_forum.required' => 'Field Wajib diisi',
            'alamat_kantor_forum.required' => 'Field Wajib diisi',
            'alamat_kantor.required' => 'Field Wajib diisi',

        ]);

        try{
            $g_data = M_General_Data::find($id);
            $g_data->provinsi = $request->provinsi;
            $g_data->id_zona = $request->id_zona;
            $g_data->nama_wako_bup = $request->nama_wako_bup;
            $g_data->alamat_kantor = $request->alamat_kantor;
            $g_data->nama_pembina = $request->nama_pembina;
            $g_data->nama_forum = $request->nama_forum;
            $g_data->nama_ketua_forum = $request->nama_ketua_forum;
            $g_data->alamat_kantor_forum = $request->alamat_kantor_forum;

            $g_data->save();
            return redirect()->route('g-data.indexKabKota')->with('success', 'Berhasil mengubah data umum');
        }
        catch(\Exception $e){
            return redirect()->back('g-data.editKabKota', $id)->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');

        }   
    }
}
