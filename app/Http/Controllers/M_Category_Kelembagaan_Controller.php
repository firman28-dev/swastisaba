<?php

namespace App\Http\Controllers;

use App\Models\M_Category_Kelembagaan;
use App\Models\M_Level;
use App\Models\M_Question_Kelembagaan;
use Illuminate\Http\Request;
use Session;

class M_Category_Kelembagaan_Controller extends Controller
{
    
    public function index()
    {
        $session_date = Session::get('selected_year');
        $c_kelembagaan = M_Category_Kelembagaan::where('id_survey', $session_date)->get();
        return view('admin.c_kelembagaan.index', compact('c_kelembagaan'));
    }

    
    public function create()
    {
        $level = M_Level::all();
        return view('admin.c_kelembagaan.create', compact('level'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
        ]);

        try{
            $c_kelembagaan = new M_Category_Kelembagaan();
            $c_kelembagaan->id_survey = $request->id_survey;
            $c_kelembagaan->name = $request->name;
            $c_kelembagaan->save();
            return redirect()->route('c-kelembagaan.index')->with('success', 'Berhasil menambahkan data kategori kelembagaan');
        }
        catch(\Exception $e){
            return redirect()->route('c-kelembagaan.create')->with('error', 'Gagal menambahkan data kategori kelembagaan. Silahkan coba lagi');

        }   
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $c_kelembagaan = M_Category_Kelembagaan::find($id);
        // $level = M_Level::all();
        return view('admin.c_kelembagaan.edit', compact('c_kelembagaan',));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'id_level' => 'required',
            'name' => 'required',
        ]);

        try{
            $c_kelembagaan = M_Category_Kelembagaan::find($id);
            // $c_kelembagaan->id_level = $request->id_level;
            $c_kelembagaan->name = $request->name;
            $c_kelembagaan->save();
            return redirect()->route('c-kelembagaan.index')->with('success', 'Berhasil mengubah data kategori kelembagaan');
        }
        catch(\Exception $e){
            return redirect()->route('c-kelembagaan.create')->with('error', 'Gagal mengubah data kategori kelembagaan. Silahkan coba lagi');

        }   
    }

    public function destroy($id)
    {
        $c_kelembagaan = M_Category_Kelembagaan::find($id);
        $q_kelembagaan = M_Question_Kelembagaan::where('id_c_kelembagaan', $id)->get();

        if(  $c_kelembagaan && $q_kelembagaan->isEmpty()){
            $c_kelembagaan->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data kategori kelembagaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan data pertanyaan');
        }
    }

    public function onlyTrashed(){
        $trashedData = M_Category_Kelembagaan::onlyTrashed()->get();
        return view('admin.trashed.c_kelembagaan.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Category_Kelembagaan::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data kategori kelembagaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data kategori kelembagaan');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Category_Kelembagaan::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data kategori kelembagaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data kategori kelembagaan');
        }
    }

}
