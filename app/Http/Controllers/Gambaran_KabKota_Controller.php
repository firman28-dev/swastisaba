<?php

namespace App\Http\Controllers;

use App\Models\Gambaran_KabKota;
use Illuminate\Http\Request;
use Session;

class Gambaran_KabKota_Controller extends Controller
{
    public function index()
    {
        $session_date = Session::get('selected_year');
        $gambaran_kabkota = Gambaran_KabKota::where('id_survey', $session_date)->get();
        return view('admin.gambaran_kabkota.index', compact('gambaran_kabkota'));
    }

    public function create()
    {
        return view('admin.gambaran_kabkota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name.*' => 'required',
            'ket.*' => 'required',
            'name' => 'required|array',
            'ket' => 'required|array',
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'ket.required' => 'Keterangan tidak boleh kosong',
            'name.required' => 'Nama gambaran tidak boleh kosong'
        ]);

        $name = $request->name;
        $id_survey = $request->id_survey;
        $ket = $request->ket;

        $result = [];
        foreach ($name as $key => $name_gambaran) {
            $result[] = [
                'name' => $name_gambaran,
                'ket' => $ket[$key],
                'id_survey' => $id_survey
            ];
        }


        try {
            foreach ($result as $data) {
                $q_opt = new Gambaran_KabKota();
                $q_opt->id_survey = $data['id_survey'];
                $q_opt->name = $data['name'];
                $q_opt->ket = $data['ket'];
                $q_opt->save();
            }

            return redirect()->route('gambaran-kabkota.index')->with('success', 'Berhasil Menambahkan data gambaran umum kabkota');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data gambaran umum kabkota. Silahkan coba lagi')->withInput();
        }
        // return $result;

    }

    public function edit($id)
    {
        $gambaran_kabkota = Gambaran_KabKota::find($id);
        return view('admin.gambaran_kabkota.edit', compact('gambaran_kabkota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
            'ket' => 'required',
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'ket.required' => 'Keterangan tidak boleh kosong',
            'name.required' => 'Nama gambaran tidak boleh kosong'
        ]);

     


        try{
            $gambaran_kabkota = Gambaran_KabKota::find($id);
            $gambaran_kabkota->name = $request->name;
            $gambaran_kabkota->ket = $request->ket;

            $gambaran_kabkota->save();
            return redirect()->route('gambaran-kabkota.index', )->with('success', 'Berhasil mengubah data gambaran umum kabkota');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah data gambaran umum kabkota. Silahkan coba lagi')->withInput();
        }
        // return $result;

    }

}
