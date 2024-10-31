<?php

namespace App\Http\Controllers;

use App\Models\M_Doc_General_Data;
use App\Models\Trans_Doc_G_Data;
use Illuminate\Http\Request;
use Session;

class M_Doc_General_Data_Controller extends Controller
{
    public function index()
    {
        $session_date = Session::get('selected_year');
        $doc_data = M_Doc_General_Data::where('id_survey', $session_date)->get();
        return view('admin.doc_g_data.index', compact('doc_data'));
    }

    public function create()
    {
        $session_date = Session::get('selected_year');
        $sent = [
            'session_date' => $session_date
        ];
        return view('admin.doc_g_data.create', );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
            'note' => 'required',

        ]);

        try{
            $doc = new M_Doc_General_Data();
            $doc->name = $request->name;
            $doc->note = $request->note;
            $doc->save();
            return redirect()->route('doc-g-data.index')->with('success', 'Berhasil menambahkan dokumen data umum');
        }
        catch(\Exception $e){
            return redirect()->route('doc-g-data.create')->with('error', 'Gagal menambahkan data. Silahkan coba lagi');

        }   
    }

    public function edit($id)
    {
        $doc = M_Doc_General_Data::find($id);
        return view('admin.doc_g_data.edit', compact('doc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'note' => 'required',
        ]);

        try{
            $doc = M_Doc_General_Data::find($id);
            $doc->name = $request->name;
            $doc->note = $request->note;
            $doc->save();
            return redirect()->route('doc-g-data.index')->with('success', 'Berhasil mengubah dokumen data umum');
        }
        catch(\Exception $e){
            return redirect()->route('doc-g-data.edit',$id )->with('error', 'Gagal mengubah data. Silahkan coba lagi');

        }
    }

    public function destroy($id)
    {
        $doc = M_Doc_General_Data::find($id);
        $answer_doc = Trans_Doc_G_Data::where('id_doc_g_data',$id)->get();

        if (!$answer_doc->isEmpty() && $doc) {
            // Delete related documents in Trans_Doc_G_Data
            foreach ($answer_doc as $related_doc) {
                $related_doc->delete();
            }
        }
       
        if($doc){
            // return $doc;
            $doc->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus dokumen data umum');
        }
        else{
            return redirect()->back()->with('error', 'Gagal hapus data karena berelasi data kab/kota');
        }
    }

    public function onlyTrashed(){
        $trashedData = M_Doc_General_Data::onlyTrashed()->get();
        return view('admin.trashed.doc_g_data.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Doc_General_Data::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di dokumen data umum');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore dokumen data umum');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Doc_General_Data::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen dokumen data umum');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen dokumen data umum');
        }
    }
}
