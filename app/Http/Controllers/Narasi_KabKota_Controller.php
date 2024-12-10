<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\Setting_Time;
use App\Models\Trans_Narasi;
use Auth;
use Illuminate\Http\Request;
use Session;

class Narasi_KabKota_Controller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');
        $category = M_Category::where('id_survey', $session_date)->get();
        $answer_narasi = Trans_Narasi::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->get();
        $schedule = Setting_Time::where('id_group', $user->id_group)->first();
        $sent =[
            'category' => $category,
            'answer_narasi' => $answer_narasi,
            'schedule' => $schedule
        ];
        return view('operator_kabkota.narasi.index', $sent);
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
            'path.max' => 'Dokumen maksimal berukuran 10 MB'
        ]);

        $user = Auth::user();
        $idZona = $user->id_zona;
        // return $docId;
        $file = $request->file('path'); 
        $fileName = $user->id. '_' . $file->getClientOriginalName();
        // $file->move(public_path('uploads/doc_narasi/'), $fileName);
        $file->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_narasi/', $fileName);

        try {
            $uploadPdf = new Trans_Narasi();
            $uploadPdf->id_survey = $request->id_survey;
            $uploadPdf->id_zona = $idZona;
            $uploadPdf->id_category = $docId;
            $uploadPdf->path = $fileName;
            $uploadPdf->created_by = $user->id;
            $uploadPdf->updated_by = $user->id;

            $uploadPdf->save();
            return redirect()->back()->with('success', 'Berhasil mengubah dokumen narasi tatanan');
            
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen narasi tatanan. Silahkan coba lagi');
        }
    }

    public function destroy($id)
    {
        $doc = Trans_Narasi::find($id);
        if($doc){
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. 'uploads/doc_narasi/' .$doc->path;
            if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
            }
        }
        // if (file_exists(public_path('uploads/doc_narasi/'.$doc->path))) {
        //     unlink(public_path('uploads/doc_narasi/'.$doc->path));
        // }
        $doc->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus dokumen narasi tatanan');
    }

}
