<?php

namespace App\Http\Controllers;

use App\Models\Category_Doc_Provinsi;
use App\Models\Sub_Doc_Provinsi;
use App\Models\Trans_Doc_Prov;
use Auth;
use Illuminate\Http\Request;

class Trans_Doc_Prov_Controller extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;

        $doc = Category_Doc_Provinsi::find($id);
        $sub_doc = Sub_Doc_Provinsi::where('id_c_doc_prov', $id)->get();
        $answer_doc = Trans_Doc_Prov::all();
        $sent = [
            'doc' => $doc,
            'sub_doc' => $sub_doc,
            'answer_doc' => $answer_doc
        ];
        return view('operator_provinsi.doc_prov.index', $sent);
    }

    public function store(Request $request, $docId)
    {
        $request->validate([
            'path' => 'required|mimes:pdf|max:2048',
        ],[
            'path.required' => 'Field wajib diisi',
            'path.mimes' => 'Dokumen wajib berupa pdf',
            'path.max' => 'Dokumen maksimal berukuran 2 MB'
        ]);   

        $user = Auth::user();
        // $idZona = $user->id_zona;
        // return $user->name;
        $file = $request->file('path'); 
        $fileName = time(). '_' . $file->getClientOriginalName();
        

        try {
            $uploadPdf = new Trans_Doc_Prov();
            $uploadPdf->id_sub_doc_prov = $docId;
            $uploadPdf->path = $fileName;
            $uploadPdf->save();
            return redirect()->back()->with('success', 'Berhasil mengubah dokumen provinsi');
            
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen provinsi. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $doc = Trans_Doc_Prov::find($id);
        if (file_exists(public_path('uploads/doc_prov/'.$doc->path))) {
            unlink(public_path('uploads/doc_prov/'.$doc->path));
        }
        $doc->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus dokumen data umum');
    }
}
