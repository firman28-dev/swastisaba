<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\Trans_Survey;
use Illuminate\Http\Request;

class Trans_Survey_H_Controller extends Controller
{
   
    public function index()
    {
        $transdate = Trans_Survey::all();
        return view('admin.trans_date.index', compact('transdate'));
    }

    public function create()
    {
        return view('admin.trans_date.create');
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'trans_date' => 'required|unique:trans_survey_h,trans_date',
        ], [
            'trans_date.required' => 'Tahun wajib diisi',
            'trans_date.unique' => 'Tahun tidak boleh sama dengan tahun yang telah ada'
        ]);

        try{
            $transdate = new Trans_Survey();
            $transdate->trans_date = $request->trans_date;
            $transdate->save();
            return redirect()->route('trans-date.index')->with('success', 'Berhasil menambahkan data periode');
        }
        catch(\Exception $e){
            return redirect()->route('trans-date.create')->with('error', 'Gagal menambahkan periode. Silahkan coba lagi')->withInput();

        }   
    }

    
    public function show($id)
    {
        
    }

   
    public function edit($id)
    {
        $transdate = Trans_Survey::find($id);
        return view('admin.trans_date.edit', compact('transdate'));
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'trans_date' => 'required',
        ]);

        try{
            $transdate = Trans_Survey::find($id);
            $transdate->trans_date = $request->trans_date;
            $transdate->save();
            return redirect()->route('trans-date.index')->with('success', 'Berhasil mengubah data level');
        }
        catch(\Exception $e){
            return redirect()->route('trans-date.create')->with('error', 'Gagal mengubah data level. Silahkan coba lagi');

        }
    }

  
    public function destroy($id)
    {
        $transdate = Trans_Survey::find($id);
        // return $transdate;
        $category = M_Category::where('id_survey', $transdate->id)->get();
        if($transdate && $category->isEmpty())
        {
            $transdate->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data periode tahun');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus data, periode tahun masih digunakan');
        }
    }

    public function onlyTrashed(){
        $trashedData = Trans_Survey::onlyTrashed()->get();
        return view('admin.trashed.trans_date.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = Trans_Survey::withTrashed()->find($id);
        if($restore){
            $restore->restore();
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data');
        }
    }

    public function forceDelete($id){
        $category = Trans_Survey::withTrashed()->find($id);
        if($category){
            $category->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data');
        }
    }
}
