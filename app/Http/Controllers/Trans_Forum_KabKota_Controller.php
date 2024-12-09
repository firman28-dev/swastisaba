<?php

namespace App\Http\Controllers;

use App\Models\Trans_Forum_KabKota;
use Auth;
use Illuminate\Http\Request;
use Session;

class Trans_Forum_KabKota_Controller extends Controller
{
    public function store(Request $request){
        $request->validate([
            'sk_forum_kabkota' => 'required',
            'renja_forum_kabkota' => 'required',
        ],[
            'sk_forum_kabkota.required' => 'SK Forum Kab/Kota wajib diisi',
            'renja_forum_kabkota.required' => 'Renja wajib dipilih',
        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;

        try{
            
            $pembina = new Trans_Forum_KabKota();
            $pembina->id_survey = $session_date;
            $pembina->id_zona = $idZona;
            $pembina->sk_forum_kabkota = $request->sk_forum_kabkota;
            $pembina->renja_forum_kabkota = $request->renja_forum_kabkota;

            $pembina->created_by = $user->id;
            $pembina->updated_by = $user->id;

            $pembina->save();
            return redirect()->back()->with('success', 'Berhasil mengubah data');

        }
        catch(\Throwable $e){
            throw $e;
            // return redirect()->back('g-data.createKabKota')->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');
        }   
    }

    public function update(Request $request, $id){
        $request->validate([
            'sk_forum_kabkota' => 'required',
            'renja_forum_kabkota' => 'required',
        ],[
            'sk_forum_kabkota.required' => 'SK Forum Kab/kota wajib diisi',
            'renja_forum_kabkota.required' => 'Renja wajib dipilih',
        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;

        try{
            
            $pembina = Trans_Forum_KabKota::find($id);
            $pembina->sk_forum_kabkota = $request->sk_forum_kabkota;
            $pembina->renja_forum_kabkota = $request->renja_forum_kabkota;

            $pembina->updated_by = $user->id;

            $pembina->save();
            return redirect()->back()->with('success', 'Berhasil mengubah data');

        }
        catch(\Throwable $e){
            throw $e;
            // return redirect()->back('g-data.createKabKota')->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');
        }   
    }
}
