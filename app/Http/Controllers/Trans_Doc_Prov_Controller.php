<?php

namespace App\Http\Controllers;

use App\Models\Category_Doc_Provinsi;
use App\Models\M_Category;
use App\Models\M_District;
use App\Models\M_Questions;
use App\Models\Sub_Doc_Provinsi;
use App\Models\Trans_Doc_Prov;
use App\Models\Trans_Forum_KabKota;
use App\Models\Trans_Kegiatan_Prov;
use App\Models\Trans_ODF;
use App\Models\Trans_Pembina_KabKota;
use App\Models\Trans_Survey_D_Answer;
use Auth;
use Illuminate\Http\Request;
use Session;

class Trans_Doc_Prov_Controller extends Controller
{
    public function show($id)
    {
        $session_date = Session::get('selected_year');
        $user = Auth::user();
        $idZona = $user->id_zona;

        $doc = Category_Doc_Provinsi::find($id);
        $sub_doc = Sub_Doc_Provinsi::where('id_c_doc_prov', $id)->get();
        $answer_doc = Trans_Doc_Prov::all();

        //TATANAN
        $category = M_Category::where('id_survey', $session_date)->get();
        
        $district = M_District::where('province_id',13)->get();
        $odf = Trans_ODF::where('id_survey', $session_date)->get();
        $answer = Trans_Survey_D_Answer::where('id_survey', $session_date)->get();
        $question = M_Questions::where('id_survey', $session_date)->get();

        $pembina = Trans_Pembina_KabKota::where('id_survey', $session_date)
            ->get();

        $forum_kabkota = Trans_Forum_KabKota::where('id_survey', $session_date)
            ->get();

        $activity = Trans_Kegiatan_Prov::where('id_survey', $session_date)->get();

        $sent = [
            'doc' => $doc,
            'sub_doc' => $sub_doc,
            'answer_doc' => $answer_doc,
            'district' => $district,
            'category' => $category,
            'odf' => $odf,
            'answer' => $answer,
            'question' => $question,
            'pembina' => $pembina,
            'forum_kabkota' => $forum_kabkota,
            'activity' => $activity
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

    public function storeActivity(Request $request){
        $request->validate([
            'name' => 'required',
            'time' => 'required',
            'participant' => 'required',
            'result' => 'required',
            'note' => 'required',
            'path' => 'nullable|mimes:pdf|max:2048',
        ],[
            'name.required' => 'Option wajib diisi',
            'time.required' => 'Waktu wajib dipilih',
            'result.required' => 'Hasil wajib dipilih',
            'note.required' => 'Keterangan wajib dipilih',
            'path.mimes' => 'File Wajib Pdf',
            'path.max' => 'FIle Ukuran Maksimal 2MB',
        ]);

        $user = Auth::user();
        $session_date = Session::get('selected_year');
        $files = $request->file('path'); 


        try {
            //code...
            $activity = new Trans_Kegiatan_Prov();
            $activity->id_survey = $session_date;
            $activity->name = $request->name;
            $activity->time = $request->time;
            $activity->participant = $request->participant;
            $activity->result = $request->result;
            $activity->note = $request->note;

            if($files){
                $fileName = $user->id. '_ODF_' . $files->getClientOriginalName();
                $files->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity_prov/', $fileName);
                $activity->path = $fileName;
            }
            else{
                $activity->path = null;
            }

            $activity->save();

            return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroyActivity($id){
        $activity = Trans_Kegiatan_Prov::findOrFail($id);
        try {
            
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity_prov/' .$activity->path;
            if (!is_null($activity->path) && file_exists($oldPhotoPath)) {
                // Hapus file di public/uploads/doc_kelembagaan
                unlink($oldPhotoPath);
                // unlink(public_path('uploads/doc_activity/'.$activity->path));
            }
    
            $activity->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus kegiatan');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Gagal menghapus data');

        }
    }

    public function editActivity($id, $idCategory)
    {
        $activity = Trans_Kegiatan_Prov::findOrFail($id);
        $category = Category_Doc_Provinsi::findOrFail($idCategory);

        // return $activity;
        return view('operator_provinsi.doc_prov.edit_activity', compact('activity', 'category'));
    }

    public function updateActivity(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'time' => 'required',
            'participant' => 'required',
            'result' => 'required',
            'note' => 'required',
            'path' => 'nullable|mimes:pdf|max:2048',
        ],[
            'name.required' => 'Option wajib diisi',
            'time.required' => 'Waktu wajib dipilih',
            'result.required' => 'Hasil wajib dipilih',
            'note.required' => 'Keterangan wajib dipilih',
            'path.mimes' => 'File Wajib Pdf',
            'path.max' => 'FIle Ukuran Maksimal 2MB',
        ]);

        $user = Auth::user();
        $session_date = Session::get('selected_year');
        $files = $request->file('path'); 
        $c = $request->id_category;

        // return $c;


        try {
            //code...
            $activity = Trans_Kegiatan_Prov::find($id);
            $activity->name = $request->name;
            $activity->time = $request->time;
            $activity->participant = $request->participant;
            $activity->result = $request->result;
            $activity->note = $request->note;

            // if($files){
            //     $fileName = $user->id. '_ODF_' . $files->getClientOriginalName();
            //     $files->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity_prov/', $fileName);
            //     $activity->path = $fileName;
            // }
            // else{
            //     $activity->path = null;
            // }

            if ($request->hasFile('path')) {
                $path1 = $request->file('path');
                
                $fileName = $user->id . '_Activity_' . $path1->getClientOriginalName();
                $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity_prov/', $fileName);
                // $path1->move(public_path('uploads/doc_forum_kec/'), $fileName);
                if($activity->path){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity_prov/' .$activity->path;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                $activity->path = $fileName; // Simpan jika tidak null
            }
            $activity->updated_by = $user->id;
            $activity->save();

            return redirect()->route('doc-prov.show', $c)->with('success', 'Berhasil mengubah kegiatan');

            // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
