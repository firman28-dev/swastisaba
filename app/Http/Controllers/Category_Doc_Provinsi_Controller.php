<?php

namespace App\Http\Controllers;

use App\Models\Category_Doc_Provinsi;
use App\Models\Sub_Doc_Provinsi;
use App\Models\Trans_Doc_Prov;
use Illuminate\Http\Request;
use Session;

class Category_Doc_Provinsi_Controller extends Controller
{
   
    public function index()
    {
        $session_date = Session::get('selected_year');
        $category = Category_Doc_Provinsi::where('id_survey', $session_date)->get();
        return view('admin.c_doc_prov.index', compact('category'));

    }

   
    public function create()
    {
        return view("admin.c_doc_prov.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
            'status_activity' => 'required',
            'status_kelembagaan' => 'required'
        ],[
            'name.required' => 'Tidak boleh kosong',
            'status_activity.required' => 'Tidak boleh kosong',
            'status_kelembagaan.required' => 'Tidak boleh kosong'
        ]);

        try{
            $category = new Category_Doc_Provinsi();
            $category->id_survey = $request->id_survey;
            $category->name = $request->name;
            $category->status_activity = $request->status_activity;
            $category->status_kelembagaan = $request->status_kelembagaan;

            $category->save();
            return redirect()->route('c-doc-prov.index')->with('success', 'Berhasil Menambahkan kategori dokumen provinsi');
        }
        catch(\Exception $e){
            return redirect()->route('c-doc-prov.create')->with('error', 'Gagal menambahkan kategori dokumen provinsi. Silahkan coba lagi');

        }
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $category = Category_Doc_Provinsi::find($id);
        return view('admin.c_doc_prov.edit', compact('category'));
    }

   
    public function update(Request $request, $id)
    {
        $session_date = Session::get('selected_year');

        $request->validate([
            'name' => 'required',
            'status_activity' => 'required',
            'status_kelembagaan' => 'required'
        ],[
            'name.required' => 'Tidak boleh kosong',
            'status_activity.required' => 'Tidak boleh kosong',
            'status_kelembagaan.required' => 'Tidak boleh kosong'
        ]);

        try{
            $category = Category_Doc_Provinsi::find($id);
            $category->name = $request->name;
            $category->status_activity = $request->status_activity;
            $category->status_kelembagaan = $request->status_kelembagaan;
            $category->save();
            return redirect()->route('c-doc-prov.index')->with('success', 'Berhasil mengubah data kategori dokumen provinsi');
        }
        catch(\Exception $e){
            return redirect()->route('c-doc-prov.create')->with('error', 'Gagal mengubah data kategori dokumen provinsi. Silahkan coba lagi');

        }
    }

    public function destroy($id)
    {
        $doc = Category_Doc_Provinsi::find($id);
        $sub = Sub_Doc_Provinsi::where('id_c_doc_prov' ,$id)->get();
        $trans_doc = Trans_Doc_Prov::whereIn('id_sub_doc_prov', $sub->pluck('id'))->get();
        

        if ($doc) {
            if ($trans_doc->isNotEmpty()) {
                $trans_doc->each->delete();
            }
    
            // Then, delete all related sub-documents
            if ($sub->isNotEmpty()) {
                $sub->each->delete();
            }
    
            $doc->delete();
    
            return redirect()->back()->with('success', 'Berhasil menghapus data kategori dokumen provinsi beserta sub kategorinya dan transaksinya');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data, kategori dokumen tidak ditemukan');
        }
    }

    public function onlyTrashed(){
        $trashedData = Category_Doc_Provinsi::onlyTrashed()->get();
        return view('admin.trashed.c_doc_prov.trash',compact('trashedData'));
    }

    public function restore($id){
        $category = Category_Doc_Provinsi::withTrashed()->find($id);
        if($category){
            $category->restore();
            Sub_Doc_Provinsi::withTrashed()
            ->where('id_c_doc_prov', $id)
            ->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data kategori dokumen provinsi');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data');
        }
    }

    public function forceDelete($id){
        $category = Category_Doc_Provinsi::withTrashed()->find($id);
        if($category){
            Sub_Doc_Provinsi::withTrashed()->where('id_c_doc_prov', $id)->forceDelete();
            $category->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data');
        }
    }
}
