<?php

namespace App\Http\Controllers;

use App\Models\M_District;
use App\Models\Setting_Time;
use App\Models\Trans_ODF_New;
use Auth;
use Illuminate\Http\Request;
use Session;

class Trans_ODF_New_Controller extends Controller
{
    public function index(){
        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $id_zona = $user->id_zona;
        $schedule = Setting_Time::where('id_group', $user->id_group)->first();


        $zona = M_District::find($id_zona);
        $odf = Trans_ODF_New::where('id_survey',$session_date)
            ->where('id_zona', $id_zona)
            ->first();

        return view('operator_kabkota.odf_v2.index', compact('odf','schedule'));
    }

    public function create(){
        $user = Auth::user();
        $idZona = $user->id_zona;

        $name_zona = M_District::where('id', $idZona)->first();
        $sent = [
            'idZona' => $idZona,
            'nameZona' =>  $name_zona,
        ];

        return view('operator_kabkota.odf_v2.create', $sent);
    }

    public function store(Request $request){

        $request->validate([
            'sum_subdistricts' => 'required',
            'sum_villages' => 'required',
            's_villages_stop_babs' => 'required',
            'p_villages_stop_babs' => 'required',
        ],[
            'sum_subdistricts.required' => 'Jumlah Kecamatan wajib diisi',
            'sum_villages.required' => 'Jumlah Kelurahan wajib dipilih',
            's_villages_stop_babs.required' => 'Jumlah Keluran Stop BABS wajib dipilih',
            'p_villages_stop_babs.required' => 'Persentase ODF wajib diisi',

        ]);

        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;

        try{
            
            $odf = new Trans_ODF_New();
            $odf->id_survey = $session_date;
            $odf->id_zona = $idZona;
            $odf->sum_subdistricts = $request->sum_subdistricts;
            $odf->sum_villages = $request->sum_villages;
            $odf->s_villages_stop_babs = $request->s_villages_stop_babs;
            $odf->p_villages_stop_babs = $request->p_villages_stop_babs;

            
            $odf->created_by = $user->id;
            $odf->updated_by = $user->id;

            $odf->save();
            return redirect()->route('data-odf.index')->with('success', 'Berhasil mengubah data ODF');

        }
        catch(\Throwable $e){
            throw $e;
            // return redirect()->back('g-data.createKabKota')->with('error', 'Gagal memperbaiki data umum. Silahkan coba lagi');
        }   
    }

    public function edit($id)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;

        $name_zona = M_District::where('id', $idZona)->first();
        $trans_odf = Trans_ODF_New::find($id);
        $sent = [
            'idZona' => $idZona,
            'nameZona' =>  $name_zona,
            'transOdf' => $trans_odf,
        ];

        return view('operator_kabkota.odf.edit', $sent);
    }

}
