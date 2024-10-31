<?php

namespace App\Http\Controllers;

use App\Models\Pendanaan_KabKota;
use Illuminate\Http\Request;
use Session;

class Pendanaan_KabKota_Controller extends Controller
{
    public function index()
    {
        $session_date = Session::get('selected_year');
        $pendanaan_kabkota = Pendanaan_KabKota::where('id_survey', $session_date)->get();
        return view('admin.pendanaan_kabkota.index', compact('pendanaan_kabkota'));
    }

    public function create()
    {
        return view('admin.pendanaan_kabkota.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'id_survey' => 'required'
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'name.required' => 'Nama Pendanaan tidak boleh kosong'
        ]);

        try{
            $pendanaan_kabkota = new Pendanaan_KabKota();
            $pendanaan_kabkota->name = $request->name;
            $pendanaan_kabkota->id_survey = $request->id_survey;
            $pendanaan_kabkota->save();
            return redirect()->route('pendanaan.index')->with('success', 'Berhasil menambahkan data pendanaan kabkota');
        }
        catch(\Exception $e){
            return redirect()->route('pendanaan.create')->with('error', 'Gagal menambahkan data pendanaan kabkota. Silahkan coba lagi');

        }   
        // return $result;

    }

    public function edit($id)
    {
        $pendanaan_kabkota = Pendanaan_KabKota::find($id);
        return view('admin.pendanaan_kabkota.edit', compact('pendanaan_kabkota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'name.required' => 'Nama pendanaan tidak boleh kosong'
        ]);

        try{
            $pendanaan_kabkota = Pendanaan_KabKota::find($id);
            $pendanaan_kabkota->name = $request->name;
            $pendanaan_kabkota->save();
            
            return redirect()->route('pendanaan.index', )->with('success', 'Berhasil mengubah data pendanaan kabkota');
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('error', 'Gagal mengubah data pendanaan kabkota. Silahkan coba lagi')->withInput();
        }
        // return $result;

    }
}
