<?php

namespace App\Http\Controllers;

use App\Models\Category_Doc_Provinsi;
use App\Models\Sub_Doc_Provinsi;
use App\Models\Trans_Doc_Prov;
use Illuminate\Http\Request;
use Session;

class Sub_Doc_Provinsi_Controller extends Controller
{
    
    public function index()
    {
        $session_date = Session::get('selected_year');
        $category = Category_Doc_Provinsi::where('id_survey', $session_date)->get();
        return view('admin.sub_doc_prov.index', compact('category'));
    }

    public function showSubDoc($id)
    {
        $session_date = Session::get('selected_year');
        $category = Category_Doc_Provinsi::find($id);
        $sub_doc = Sub_Doc_Provinsi::select('sub_doc_prov.*','category_doc_prov.name as name_category')
            ->leftJoin('category_doc_prov', 'sub_doc_prov.id_c_doc_prov', '=', 'category_doc_prov.id')
            ->where('sub_doc_prov.id_c_doc_prov',$id)
            ->where('sub_doc_prov.id_survey',$session_date)
            ->get();
        $sent = [
            'category' => $category,
            'sub_doc' => $sub_doc
        ];
        return view("admin.sub_doc_prov.index_v2", $sent);
    }
    
    public function create($id)
    {
        $category = Category_Doc_Provinsi::find($id);
        return view('admin.sub_doc_prov.create', compact('category'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_c_doc_prov' => 'required',
            'name.*' => 'required',
            'name' => 'required|array',
        ], [
            'id_survey.required' => 'Tahun wajib diisi',
            'id_c_doc_prov.required' => 'Kategori wajib diisi',
            'name.required' => 'nama wajib diisi',
        ]);

        $names = $request->name;
        $id_c_doc_prov = $request->id_c_doc_prov;
        $id_survey = $request->id_survey;

        
        try {
            foreach ($names as $name) {
                Sub_Doc_Provinsi::create([
                    'id_survey' => $id_survey,
                    'name' => $name,
                    'id_c_doc_prov' => $id_c_doc_prov,
                ]);
            }
            return redirect()->route('showSubDoc', $id_c_doc_prov)->with('success', 'Berhasil menambahkan data sub dokumen provinsi');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal menambahkan data sub dokumen provinsi . Silahkan coba lagi')->withInput();
        }
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $sub = Sub_Doc_Provinsi::find($id);
        return view('admin.sub_doc_prov.edit', compact('sub'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Sub kategori wajib diisi',
        ]);

        try{
            $sub = Sub_Doc_Provinsi::find($id);
            $sub->name = $request->name;
            $sub->save();
            return redirect()->route('showSubDoc', $sub->id_c_doc_prov)->with('success', 'Berhasil mengubah data sub kategori');
        }
        catch(\Exception $e){
            return redirect()->route('sub-doc-prov.create')->with('error', 'Gagal mengubah data sub kategori. Silahkan coba lagi');

        }
    }

   
    public function destroy($id)
    {
        $sub = Sub_Doc_Provinsi::find($id);
        $trans_doc = Trans_Doc_Prov::where('id_sub_doc_prov', $sub->id)->get();
        if ($sub) {
            if ($trans_doc->isNotEmpty()) {
                $trans_doc->each->delete();
            }
    
            $sub->delete();
    
            return redirect()->back()->with('success', 'Berhasil menghapus data  sub kategori dokumen provinsi dan transaksinya');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data sub kategori dokumen tidak ditemukan');
        }
    }

    public function onlyTrashed(){
        $trashedData = Sub_Doc_Provinsi::onlyTrashed()->get();
        return view('admin.trashed.sub_doc_prov.trash',compact('trashedData'));
    }

    public function restore($id){
        $category = Sub_Doc_Provinsi::withTrashed()->find($id);
        if($category){
            $category->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data sub kategori dokumen provinsi');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data');
        }
    }

    public function forceDelete($id){
        $category = Sub_Doc_Provinsi::withTrashed()->find($id);
        if($category){
            $category->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data');
        }
    }

    
}
