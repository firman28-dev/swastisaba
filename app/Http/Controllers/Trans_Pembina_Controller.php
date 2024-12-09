<?php

namespace App\Http\Controllers;

use App\Models\Trans_Pembina_KabKota;
use Auth;
use Illuminate\Http\Request;
use Session;

class Trans_Pembina_Controller extends Controller
{
    public function store(Request $request){
        $request->validate([
            'sk_pembina' => 'required',
            'renja' => 'required',
        ],[
            'sk_pembina.required' => 'SK Pembina wajib diisi',
            'renja.required' => 'Renja wajib dipilih',
        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;

        try{
            
            $pembina = new Trans_Pembina_KabKota();
            $pembina->id_survey = $session_date;
            $pembina->id_zona = $idZona;
            $pembina->sk_pembina = $request->sk_pembina;
            $pembina->renja = $request->renja;

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
            'sk_pembina' => 'required',
            'renja' => 'required',
        ],[
            'sk_pembina.required' => 'SK Pembina wajib diisi',
            'renja.required' => 'Renja wajib dipilih',
        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;

        try{
            
            $pembina = Trans_Pembina_KabKota::find($id);
            $pembina->sk_pembina = $request->sk_pembina;
            $pembina->renja = $request->renja;

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
