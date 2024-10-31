<?php

namespace App\Http\Controllers;

use App\Models\M_C_Kelembagaan_New;
use App\Models\M_Category_Kelembagaan;
use App\Models\M_Q_Kelembagaan_New;
use App\Models\M_Q_O_Kelembagaan_New;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Kelembagaan_V2;
use Illuminate\Http\Request;
use Session;

class M_C_Kelembagaan_New_Controller extends Controller
{
    public function index()
    {
        $session_date = Session::get('selected_year');
        $c_kelembagaan_v2 = M_C_Kelembagaan_New::where('id_survey', $session_date)->get();
        return view('admin.c_kelembagaan_v2.index', compact('c_kelembagaan_v2'));
    }

    public function create()
    {
        return view('admin.c_kelembagaan_v2.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
            'is_status' => 'required'
        ],[
            'id_survey.required' => 'Tahun wajib diisi',
            'name.required' => 'Kategori Kelembagaan wajib diisi',
            'is_status.required' => 'Status wajib diisi'
        ]);

        try{
            $c_kelembagaan_v2 = new M_C_Kelembagaan_New();
            $c_kelembagaan_v2->id_survey = $request->id_survey;
            $c_kelembagaan_v2->name = $request->name;
            $c_kelembagaan_v2->is_status = $request->is_status;
            $c_kelembagaan_v2->save();
            return redirect()->route('c-kelembagaan-v2.index')->with('success', 'Berhasil menambahkan data kategori kelembagaan');
        }
        catch(\Exception $e){
            return redirect()->route('c-kelembagaan-v2.create')->with('error', 'Gagal menambahkan data kategori kelembagaan. Silahkan coba lagi');

        }   
    }

    public function edit($id)
    {
        $c_kelembagaan_v2 = M_C_Kelembagaan_New::find($id);
        // $level = M_Level::all();
        return view('admin.c_kelembagaan_v2.edit', compact('c_kelembagaan_v2',));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'is_status' => 'required',

        ],[
            'name.required' => 'Kategori Kelembagaan wajib diisi',
            'is_status.required' => 'Status wajib diisi'
        ]);

        try{
            $c_kelembagaan_v2 = M_C_Kelembagaan_New::find($id);
            // $c_kelembagaan->id_level = $request->id_level;
            $c_kelembagaan_v2->name = $request->name;
            $c_kelembagaan_v2->is_status = $request->is_status;

            $c_kelembagaan_v2->save();
            return redirect()->route('c-kelembagaan-v2.index')->with('success', 'Berhasil mengubah data kategori kelembagaan');
        }
        catch(\Exception $e){
            return redirect()->route('c-kelembagaan-v2.create')->with('error', 'Gagal mengubah data kategori kelembagaan. Silahkan coba lagi');

        }   
    }

    public function destroy($id)
    {
        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        // return $c_kelembagaan;
        $q_kelembagaan = M_Q_Kelembagaan_New::where('id_c_kelembagaan_v2', $id)->get();
        $q_opt = M_Q_O_Kelembagaan_New::whereIn('id_q_kelembagaan', $q_kelembagaan->pluck('id'))->get();
        $trans_doc = Trans_Doc_Kelembagaan::whereIn('id_q_kelembagaan', $q_kelembagaan->pluck('id'))->get();
        $trans_answer = Trans_Kelembagaan_V2::whereIn('id_opt_kelembagaan', $q_opt->pluck('id'))->get();
        
        if($c_kelembagaan){
            if($trans_answer->isNotEmpty()){
                $trans_answer->each->delete();
            }

            if($trans_doc->isNotEmpty()){
                $trans_doc->each->delete();
            }

            if($q_opt->isNotEmpty()){
                $q_opt->each->delete();
            }

            if($q_kelembagaan->isNotEmpty()){
                $q_kelembagaan->each->delete();
            }

            $c_kelembagaan->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus data beserta relasi ke bawahnya');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }

        // if(  $c_kelembagaan && $q_kelembagaan->isEmpty()){
        //     $c_kelembagaan->delete();
        //     return redirect()->back()->with('success', 'Berhasil menghapus data kategori kelembagaan');
        // }
        // else{
        //     return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan data pertanyaan');
        // }
    }
}
