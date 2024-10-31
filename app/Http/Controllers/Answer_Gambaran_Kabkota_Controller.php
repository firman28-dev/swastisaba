<?php

namespace App\Http\Controllers;

use App\Models\Gambaran_KabKota;
use App\Models\Setting_Time;
use App\Models\Trans_Gambaran_Kabkota;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Gambaran_Kabkota_Controller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        $gambaran_kabkota = Gambaran_KabKota::where('id_survey', $session_date)->get();
        $answer_doc = Trans_Gambaran_Kabkota::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();
        $schedule = Setting_Time::where('id_group', $user->id_group)->first();
        $sent = [
            'gambaran_kabkota' => $gambaran_kabkota,
            'answer_doc' => $answer_doc,
            'schedule' => $schedule
        ];
        return view('operator_kabkota.gambaran.index', $sent);
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
        $file->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_g_umum_kabkota/', $fileName);
        // $file->move(public_path('uploads/doc_g_umum_kabkota/'), $fileName);

        try {
            $uploadPdf = new Trans_Gambaran_Kabkota();
            $uploadPdf->id_survey = $request->id_survey;
            $uploadPdf->id_zona = $idZona;
            $uploadPdf->id_gambaran_kabkota = intval($docId);
            $uploadPdf->path = $fileName;
            $uploadPdf->created_by = $user->id;

            $uploadPdf->save();
            return redirect()->back()->with('success', 'Berhasil mengubah dokumen gambaran umum');
            
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen gambaran umum. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $doc = Trans_Gambaran_Kabkota::find($id);
        // return $doc;
        if($doc){
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_g_umum_kabkota/' .$doc->path;
            if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
            }
        }
        
        // if (file_exists(public_path('uploads/doc_g_umum_kabkota/'.$doc->path))) {
        //     unlink(public_path('uploads/doc_g_umum_kabkota/'.$doc->path));
        // }
        $doc->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus dokumen data umum');
    }
}
