<?php

namespace App\Http\Controllers;

use App\Models\Pendanaan_KabKota;
use App\Models\Setting_Time;
use App\Models\Trans_Pendanaan_kabkota;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Pendanaan_Kabkota_Controller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        $pendanaan_kabkota = Pendanaan_KabKota::where('id_survey', $session_date)->get();
        $answer_doc = Trans_Pendanaan_kabkota::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();
        $schedule = Setting_Time::where('id_group', $user->id_group)->first();
        $sent = [
            'pendanaan_kabkota' => $pendanaan_kabkota,
            'answer_doc' => $answer_doc,
            'schedule' => $schedule
        ];
        return view('operator_kabkota.pendanaan.index', $sent);
    }

    public function store(Request $request, $docId)
    {
        $request->validate([
            'id_survey' => 'required',
            'path' => 'required|mimes:pdf|max:10480',
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
        // $file->move(public_path('uploads/doc_pendanaan/'), $fileName);
        $file->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pendanaan/', $fileName);

        try {
            $uploadPdf = new Trans_Pendanaan_kabkota();
            $uploadPdf->id_survey = $request->id_survey;
            $uploadPdf->id_zona = $idZona;
            $uploadPdf->id_pendanaan_kabkota = intval($docId);
            $uploadPdf->path = $fileName;
            $uploadPdf->created_by = $user->id;
            $uploadPdf->save();
            return redirect()->back()->with('success', 'Berhasil mengubah dokumen pendanaan');
            
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen pendanaan. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $doc = Trans_Pendanaan_kabkota::find($id);
        if($doc){
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pendanaan/' .$doc->path;
            if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
            }
        }
        // if (file_exists(public_path('uploads/doc_pendanaan/'.$doc->path))) {
        //     unlink(public_path('uploads/doc_pendanaan/'.$doc->path));
        // }
        $doc->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus dokumen pendanaan');
    }
}
