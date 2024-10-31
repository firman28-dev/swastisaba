<?php

namespace App\Http\Controllers;

use App\Models\M_Level;
use App\Models\M_Zona;
use Illuminate\Http\Request;

class M_Zona_Controller extends Controller
{
  
    public function index()
    {
        $zona = M_Zona::all();
        return view('admin.zona.index', compact('zona'));
    }

   
    public function create()
    {
        // $level = M_Level::all();
        return view('admin.zona.create', );
    }

   
    public function store(Request $request)
    {
        $request->validate([
            // 'id_level' => 'required',
            'name' => 'required',
        ]);

        try{
            $zona = new M_Zona();
            // $zona->id_level = $request->id_level;
            $zona->name = $request->name;
            $zona->save();
            return redirect()->route('zona.index')->with('success', 'Berhasil menambahkan data zona');
        }
        catch(\Exception $e){
            return redirect()->route('zona.create')->with('error', 'Gagal menambahkan data zona. Silahkan coba lagi');

        }   
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $zona = M_Zona::find($id);
        // $level = M_Level::all();
        return view('admin.zona.edit', compact('zona'));
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_level' => 'required',
            'name' => 'required',
        ]);

        try{
            $zona = M_Zona::find($id);
            $zona->id_level = $request->id_level;
            $zona->name = $request->name;
            $zona->save();
            return redirect()->route('zona.index')->with('success', 'Berhasil menguba data zona');
        }
        catch(\Exception $e){
            return redirect()->route('zona.create')->with('error', 'Gagal mengubah data zona. Silahkan coba lagi');

        }   
    }

    public function destroy($id)
    {
        $zona = M_Zona::find($id);
        if($zona){
            $zona->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data zona');

        }
    }

    public function onlyTrashed(){
        $trashedData = M_Zona::onlyTrashed()->get();
        return view('admin.trashed.zona.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Zona::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data zona');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data zona');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Zona::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data zona');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data zona');
        }
    }
    
}
