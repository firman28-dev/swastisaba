<?php

namespace App\Http\Controllers;

use App\Models\M_Group;
use App\Models\User;
use Illuminate\Http\Request;

class M_Group_Controller extends Controller
{
    public function index()
    {
        $group = M_Group::all();
        return view('admin.group.index', compact('group'));
    }

    public function create()
    {
        return view('admin.group.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        

        try{
            $group = new M_Group();
            $group->name = $request->name;
            $group->save();
            return redirect()->route('group.index')->with('success', 'Berhasil menambahkan data role akses');
        }
        catch(\Exception $e){
            return redirect()->route('group.create')->with('error', 'Gagal menambahkan data role akses. Silahkan coba lagi');

        }   
    }

    public function edit($id)
    {
        $group = M_Group::find($id);
        return view('admin.group.edit', compact('group'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try{
            $level = M_Group::find($id);
            $level->name = $request->name;
            $level->save();
            return redirect()->route('group.index')->with('success', 'Berhasil mengubah data role akses');
        }
        catch(\Exception $e){
            return redirect()->route('group.create')->with('error', 'Gagal mengubah data role akses. Silahkan coba lagi');

        }
    }

   
    public function destroy($id)
    {
        $group = M_Group::find($id);
        $user  = User::where('id_group', $group->id)->get();

        if($group && !$user){
            $group->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data role akses');
        }
        else{
            return redirect()->back()->with('error', 'Gagal hapus data karena berelasi dengan data user');
        }
    }

    public function onlyTrashed(){
        $trashedData = M_Group::onlyTrashed()->get();
        return view('admin.trashed.group.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Group::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data role user');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data role user');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Group::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data role user');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data role user');
        }
    }

    
}
