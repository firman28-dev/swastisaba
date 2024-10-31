<?php

namespace App\Http\Controllers;

use App\Models\M_Doc_General_Data;
use App\Models\Trans_Doc_G_Data;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Doc_G_Data_Controller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        $doc = M_Doc_General_Data::where('id_survey', $session_date)->get();
        $answer_doc = Trans_Doc_G_Data::where('id_zona',$idZona)->where('id_survey', $session_date)->get();

        $sent = [
            'doc' => $doc,
            'answer_doc' => $answer_doc
        ];
        return view('operator_kabkota.doc_general_data.index', $sent);
    }

    public function store(Request $request, $docId)
    {
        $request->validate([
            'id_survey' => 'required',
            'path' => 'required|mimes:pdf|max:2048',
        ],[
            'id_survey' => 'Tahun wajib disetting',
            'path.required' => 'Field wajib diisi',
            'path.mimes' => 'Dokumen wajib berupa pdf',
            'path.max' => 'Dokumen maksimal berukuran 2 MB'
        ]);
        
        $user = Auth::user();
        $idZona = $user->id_zona;
        // return $docId;
        $file = $request->file('path'); 
        $fileName = $idZona. '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/doc_general_data/'), $fileName);

        try {
            $uploadPdf = new Trans_Doc_G_Data();
            $uploadPdf->id_survey = $request->id_survey;
            $uploadPdf->id_zona = $idZona;
            $uploadPdf->id_doc_g_data = intval($docId);
            $uploadPdf->path = $fileName;
            $uploadPdf->save();
            return redirect()->back()->with('success', 'Berhasil mengubah dokumen data umum');
            
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen data umum. Silahkan coba lagi');
        }

    }

    public function destroy($id)
    {
        $doc = Trans_Doc_G_Data::find($id);
        if (file_exists(public_path('uploads/doc_general_data/'.$doc->path))) {
            unlink(public_path('uploads/doc_general_data/'.$doc->path));
        }
        $doc->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus dokumen data umum');

        // if($doc)
        // {
        //     $doc->delete();
        //     return redirect()->back()->with('success', 'Berhasil menghapus dokumen data umum');
        // }
    }
}
