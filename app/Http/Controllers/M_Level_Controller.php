<?php

namespace App\Http\Controllers;

use App\Models\M_Level;
use App\Models\M_Zona;
use Illuminate\Http\Request;

class M_Level_Controller extends Controller
{
    
    public function index()
    {
        $level = M_Level::all();
        return view('admin.level.index', compact('level'));
    }

   
    public function create()
    {
        return view('admin.level.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try{
            $level = new M_Level();
            $level->name = $request->name;
            $level->save();
            return redirect()->route('level.index')->with('success', 'Berhasil menambahkan data level');
        }
        catch(\Exception $e){
            return redirect()->route('level.create')->with('error', 'Gagal menambahkan data level. Silahkan coba lagi');

        }   
    }

   
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $level = M_Level::find($id);
        return view('admin.level.edit', compact('level'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try{
            $level = M_Level::find($id);
            $level->name = $request->name;
            $level->save();
            return redirect()->route('level.index')->with('success', 'Berhasil mengubah data level');
        }
        catch(\Exception $e){
            return redirect()->route('level.create')->with('error', 'Gagal mengubah data level. Silahkan coba lagi');

        }
    }

   
    public function destroy($id)
    {
        $level = M_Level::find($id);
        $zona = M_Zona::where('id_level', $level->id)->first();

        if(!$zona && $level){
            $level->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data level');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus data level karena berelasi dengan data zona');
        }
    }

    public function onlyTrashed(){
        $trashedData = M_Level::onlyTrashed()->get();
        return view('admin.trashed.level.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Level::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data level user');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data level user');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Level::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data level user');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data level user');
        }
    }
}
