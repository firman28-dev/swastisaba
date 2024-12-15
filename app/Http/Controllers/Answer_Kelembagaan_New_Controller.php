<?php

namespace App\Http\Controllers;

use App\Models\M_C_Kelembagaan_New;
use App\Models\M_District;
use App\Models\M_Q_Kelembagaan_New;
use App\Models\M_SubDistrict;
use App\Models\M_Village;
use App\Models\Setting_Time;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Forum_KabKota;
use App\Models\Trans_Forum_Kec;
use App\Models\Trans_Forum_Kel;
use App\Models\Trans_Kegiatan;
use App\Models\Trans_Kelembagaan_V2;
use App\Models\Trans_Pembina_KabKota;
use App\Models\Trans_Sekre_Kec;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Kelembagaan_New_Controller extends Controller
{
    
    public function show($id)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        $category = M_C_Kelembagaan_New::find($id);
        $q_kelembagaan = M_Q_Kelembagaan_New::where('id_c_kelembagaan_v2', $id)
            ->where('id_survey', $session_date)    
            ->get();
        // return $q_kelembagaan;

        $subdistrict = M_SubDistrict::where('district_id', $idZona)
        ->where('is_active',1)
        ->get();
        // return $subdistrict;
        
        
        $answer = Trans_Kelembagaan_V2::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();

        $uploadedFiles = Trans_Doc_Kelembagaan::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->get();

        $activity = Trans_Kegiatan::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $id)
            ->get();

        $forumKec = Trans_Forum_Kec::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $id)
            ->get();

        $forumKel = Trans_Forum_Kel::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $id)
            ->get();
        
        $pembina = Trans_Pembina_KabKota::where('id_survey', $session_date)
            ->where('id_zona', $idZona)
            ->first();

        $forum_kabkota = Trans_Forum_KabKota::where('id_survey', $session_date)
            ->where('id_zona', $idZona)
            ->first();


       
        // return $forumKec;
        $schedule = Setting_Time::where('id_group', $user->id_group)->first();
        
        $sent =[
            'category' => $category,
            'q_kelembagaan' => $q_kelembagaan,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'activity' => $activity,
            'forumKec' => $forumKec,
            'forumKel' => $forumKel,
            'subdistrict' => $subdistrict,
            'schedule' => $schedule,
            'pembina' => $pembina,
            'forum_kabkota' => $forum_kabkota
        ];
        // return $q_kelembagaan;
        return view('operator_kabkota.kelembagaan_v2.index', $sent);

    }


    public function store(Request $request, $questionId)
    {   
        $request->validate([
            'id_survey' => 'required',
            'id_option' => 'required',
            'file_path' => 'nullable|mimes:pdf|max:2048',
        ],[
            'id_option.required' => 'Option wajib diisi',
            'id_survey' => 'Tahun wajib dipilih',
            'file_path.mimes' => 'Wajib Pdf',
            'file_path.max' => 'Ukuran Maksimal 25MB',
        ]);

        $files = $request->file('file_path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;

        $question = M_Q_Kelembagaan_New::find($questionId);
        // return $question;
        $session_date = Session::get('selected_year');

        try {
            $relatedAnswer = Trans_Kelembagaan_V2::where('id_q_kelembagaan', $questionId)
                ->where('id_survey', $session_date)
                ->where('id_zona',$idZona)
                ->first();

            if ($relatedAnswer) {
                $relatedAnswer->update([
                    'id_opt_kelembagaan' => $request->id_option,
                ]);
            }

            else {
                $relatedAnswer = Trans_Kelembagaan_V2::create([
                    'id_survey' => $session_date,
                    'id_zona' => $idZona,
                    'id_opt_kelembagaan' => $request->id_option,
                    'id_q_kelembagaan' => $question->id,
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);
            }

            if($files){
                // $file = $request->file('path'); 
                $fileName = $idZona. '_' . $files->getClientOriginalName();
                $files->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_kelembagaan/', $fileName);
                // $files->move(public_path('uploads/doc_kelembagaan/'), $fileName);

                $uploadPdf = new Trans_Doc_Kelembagaan();
                $uploadPdf->id_survey = $request->id_survey;
                $uploadPdf->id_zona = $idZona;
                $uploadPdf->id_q_kelembagaan = intval($question->id);
                $uploadPdf->path = $fileName;
                $uploadPdf->created_by = $user->id;
                $uploadPdf->updated_by = $user->id;

                $uploadPdf->save();

            }



            return redirect()->back()->with('success', 'Berhasil memverifikasi data kelmabagaan');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroyDoc($id)
    {
        $file = Trans_Doc_Kelembagaan::findOrFail($id);
        if($file){
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_kelembagaan/' .$file->path;
            if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
            }
        }
        // if (file_exists(public_path('uploads/doc_kelembagaan/'.$file->path))) {
        //     unlink(public_path('uploads/doc_kelembagaan/'.$file->path));
        // }
        $file->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);

    }

    //activity

    public function createActivityKec($idCategory, $idSubdistrict)
    {
        $subdistrict = M_SubDistrict::find($idSubdistrict);
        $category = M_C_Kelembagaan_New::find($idCategory);

        // return $category;
        $sent = [
            'subdistrict' => $subdistrict,
            'category' => $category
        ];
        // return $subdistrict;
        return view('operator_kabkota.kelembagaan_v2.create_activity_kec', $sent);

    }

    public function storeActivityKec(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'id_kode' => 'required',
            'time' => 'required',
            'participant' => 'required',
            'result' => 'required',
            'note' => 'required',
            'path' => 'nullable|mimes:pdf|max:2048',
        ],[
            'name.required' => 'Option wajib diisi',
            'id_kode.required' => 'Kode Kecamatan wajib diisi',
            'time.required' => 'Waktu wajib dipilih',
            'result.required' => 'Hasil wajib dipilih',
            'note.required' => 'Keterangan wajib dipilih',
            'path.mimes' => 'File Wajib Pdf',
            'path.max' => 'FIle Ukuran Maksimal 2MB',
        ]);

        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
            if($path){
                // $file = $request->file('path'); 
                $fileName = $idZona. '_' . $path->getClientOriginalName();
                $path->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/', $fileName);

                $activity = new Trans_Kegiatan();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->id_kode = $request->id_kode;

                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->path = $fileName;

                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();

                // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');
                return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah data');

            }

            else
            {
                $activity = new Trans_Kegiatan();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->id_kode = $request->id_kode;

                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah data');

                // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');

            }


        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan kegiatan');

        }

    }

    //umum

    public function storeActivity(Request $request, $id)
    {

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

        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
            if($path){
                // $file = $request->file('path'); 
                $fileName = $idZona. '_' . $path->getClientOriginalName();
                // $path->move(public_path('uploads/doc_activity/'), $fileName);
                $path->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/', $fileName);

                $activity = new Trans_Kegiatan();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->path = $fileName;

                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();

                return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');


            }

            else
            {
                $activity = new Trans_Kegiatan();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');

            }


        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan kegiatan');

        }

    }

    public function editActivity($id)
    {
        $activity = Trans_Kegiatan::findOrFail($id);
        // return $activity;
        return view('operator_kabkota.kelembagaan_v2.edit_activity', compact('activity'));
    }

    public function updateActivity(Request $request, $id)
    {
        $activity = Trans_Kegiatan::findOrFail($id);
        // return $activity;
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

        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
            if($path){
                // $file = $request->file('path'); 
                
                $fileName = $idZona. '_' . $path->getClientOriginalName();
                // $path->move(public_path('uploads/doc_activity/'), $fileName);
                $path->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/', $fileName);

                $activity = Trans_Kegiatan::find($id);
                if ($activity->path) {
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/' .$activity->path;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                    // $oldPath = public_path('uploads/doc_activity/' . $activity->path);
                    // if (file_exists($oldPath)) {
                    //     unlink($oldPath);
                    // }
                }
                // $activity->id_survey = $session_date;
                // $activity->id_zona = $idZona;

                // $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->path = $fileName;
                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah kegiatan');


                // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');


            }

            else
            {
                $activity = Trans_Kegiatan::find($id);
                // $activity->id_survey = $session_date;
                // $activity->id_zona = $idZona;

                // $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah kegiatan');

            }


        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan kegiatan');

        }

    }

    public function destroyActivity($id)
    {
        $activity = Trans_Kegiatan::findOrFail($id);
        // return $activity;
        try {
            
            $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/' .$activity->path;
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

    //forum kec
    public function createForumKec($idCategory, $idSubdistrict){
        $subdistrict = M_SubDistrict::find($idSubdistrict);
        $category = M_C_Kelembagaan_New::find($idCategory);

        // return $category;
        $sent = [
            'subdistrict' => $subdistrict,
            'category' => $category
        ];
        return view('operator_kabkota.kelembagaan_v2.create_forum_kec', $sent);

    }

    public function storeForumKec(Request $request, $id)
    {

        $request->validate([
            'id_subdistrict' => 'required|unique:trans_forum_kec',
            'f_district' => 'required',
            'no_sk' => 'required',
            'expired_sk' => 'required',
            'f_budget' => 'required',
            's_address' => 'required',

            'path_sk_f' => 'nullable|mimes:pdf|max:2048',
            'path_plan_f' => 'nullable|mimes:pdf|max:2048',
            'path_s' => 'nullable|mimes:pdf|max:2048',
            'path_budget' => 'nullable|mimes:pdf|max:2048',

        ],[
            'id_subdistrict.required' => 'Nama Kecamatan wajib diisi',
            'f_district.required' => 'Forum Kecamatan wajib diisi',
            'no_sk.required' => 'No SK wajib dipilih',
            'expired_sk.required' => 'Masa Berlaku SK wajib diisi',
            'f_budget.required' => 'Anggaran wajib diisi',
            's_address.required' => 'Alamat Sekretariat Forum wajib diisi',

            'path_sk_f.mimes' => 'File Wajib Pdf',
            'path_sk_f.max' => 'Ukuran file tidak boleh melebihi 2MB.',

            'path_plan_f.mimes' => 'File Wajib Pdf',
            'path_plan_f.max' => 'Ukuran file tidak boleh melebihi 2MB.',

            'path_s.mimes' => 'File Wajib Pdf',
            'path_s.max' => 'Ukuran file tidak boleh melebihi 2MB.',

            'path_budget.mimes' => 'File Wajib Pdf',
            'path_budget.max' => 'Ukuran file tidak boleh melebihi 2MB.',
        ]);

        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
           
                $activity = new Trans_Forum_Kec();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->id_subdistrict = $request->id_subdistrict;
                $activity->f_district = $request->f_district;
                $activity->no_sk = $request->no_sk;
                $activity->expired_sk = $request->expired_sk;

                // $activity->f_budget = $request->f_budget;
                $activity->f_budget = floatval(str_replace('.', '', $request->f_budget));
                // return $activity->f_budget;
                $activity->s_address = $request->s_address;


                if ($request->hasFile('path_sk_f')) {
                    $path1 = $request->file('path_sk_f');
                    $fileName = $idZona . '_' . $path1->getClientOriginalName();
                    $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName);
                    // $path1->move(public_path('uploads/doc_forum_kec/'), $fileName);
                    $activity->path_sk_f = $fileName; // Simpan jika tidak null
                }
                
                // Cek dan proses file Renja
                if ($request->hasFile('path_plan_f')) {
                    $path2 = $request->file('path_plan_f');
                    $fileName2 = $idZona . '_' . $path2->getClientOriginalName();
                    $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName2);
                    // $path2->move(public_path('uploads/doc_forum_kec/'), $fileName2);
                    $activity->path_plan_f = $fileName2; // Simpan jika tidak null
                }
                
                // Cek dan proses file Sekre
                if ($request->hasFile('path_s')) {
                    $path3 = $request->file('path_s');
                    $fileName3 = $idZona . '_' . $path3->getClientOriginalName();
                    $path3->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName3);
                    // $path3->move(public_path('uploads/doc_forum_kec/'), $fileName3);
                    $activity->path_s = $fileName3; // Simpan jika tidak null
                }
                
                // Cek dan proses file Budget/Anggaran
                if ($request->hasFile('path_budget')) {
                    $path4 = $request->file('path_budget');
                    $fileName4 = $idZona . '_' . $path4->getClientOriginalName();
                    $path4->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName4);
                    // $path4->move(public_path('uploads/doc_forum_kec/'), $fileName4);
                    $activity->path_budget = $fileName4; // Simpan jika tidak null
                }

                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah data');


        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }

    }

    public function editForumKec($id)
    {
        $subdistrict = M_SubDistrict::find($id);
        $activity = Trans_Forum_Kec::where('id_subdistrict',$id)->first();

        $sent = [
            'subdistrict' => $subdistrict,
            'activity' => $activity
        ];
        // return $activity;
        return view('operator_kabkota.kelembagaan_v2.edit_forum_kec', $sent);
    }

    public function updateForumKec(Request $request, $id)
    {
        // $activity = Trans_Forum_Kec::findOrFail($id);
        // return $activity;
        $request->validate([
            'f_district' => 'required',
            'no_sk' => 'required',
            'expired_sk' => 'required',
            'f_budget' => 'required',
            's_address' => 'required',

            'path_sk_f' => 'nullable|mimes:pdf|max:2048',
            'path_plan_f' => 'nullable|mimes:pdf|max:2048',
            'path_s' => 'nullable|mimes:pdf|max:2048',
            'path_budget' => 'nullable|mimes:pdf|max:2048',

        ],[
            'f_district.required' => 'Forum Kecamatan wajib diisi',
            'no_sk.required' => 'No SK wajib dipilih',
            'expired_sk.required' => 'Masa Berlaku SK wajib diisi',
            'f_budget.required' => 'Anggaran wajib diisi',
            's_address.required' => 'Alamat Sekretariat Forum wajib diisi',

            'path_sk_f' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
            'path_plan_f' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
            'path_s' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
            'path_budget' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
        ]);

        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try 
        {
           
            $activity = Trans_Forum_Kec::find($id);
            $activity->f_district = $request->f_district;
            $activity->no_sk = $request->no_sk;
            $activity->expired_sk = $request->expired_sk;

            $activity->f_budget = floatval(str_replace('.', '', $request->f_budget));
            $activity->s_address = $request->s_address;

            if ($request->hasFile('path_sk_f')) {
                $path1 = $request->file('path_sk_f');
                $fileName = $idZona . '_' . $path1->getClientOriginalName();
                $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName);
                // $path1->move(public_path('uploads/doc_forum_kec/'), $fileName);
                if($activity->path_sk_f){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/' .$activity->path_sk_f;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $activity->path_sk_f = $fileName; // Simpan jika tidak null
            }
            
            // Cek dan proses file Renja
            if ($request->hasFile('path_plan_f')) {
                $path2 = $request->file('path_plan_f');
                $fileName2 = $idZona . '_' . $path2->getClientOriginalName();
                // $path2->move(public_path('uploads/doc_forum_kec/'), $fileName2);
                $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName2);
                if($activity->path_plan_f){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/' .$activity->path_plan_f;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $activity->path_plan_f = $fileName2; 
            }
            
            // Cek dan proses file Sekre
            if ($request->hasFile('path_s')) {
                $path3 = $request->file('path_s');
                $fileName3 = $idZona . '_' . $path3->getClientOriginalName();
                // $path3->move(public_path('uploads/doc_forum_kec/'), $fileName3);
                $path3->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName3);
                if($activity->path_s){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/' .$activity->path_s;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                
                $activity->path_s = $fileName3; // Simpan jika tidak null
            }
            
            // Cek dan proses file Budget/Anggaran
            if ($request->hasFile('path_budget')) {
                $path4 = $request->file('path_budget');
                $fileName4 = $idZona . '_' . $path4->getClientOriginalName();
                // $path4->move(public_path('uploads/doc_forum_kec/'), $fileName4);
                $path4->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/', $fileName4);
                
                if($activity->path_budget){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_forum_kec/' .$activity->path_budget;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $activity->path_budget = $fileName4; // Simpan jika tidak null

            }

            $activity->updated_by = $user->id;
            $activity->save();
            return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah data');


        } 
        catch (\Throwable $th) 
        {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal mengubah data');

        }

    }

    public function destroyForumKec($id)
    {
        $activity = Trans_Forum_Kec::find($id);
        // return $activity;
        
        try {
            
            $paths = [
                $activity->path_sk_f,
                $activity->path_plan_f,
                $activity->path_s,
                $activity->path_budget
            ];
            
            
            foreach ($paths as $path) {
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/doc_forum_kec/' . $path;
                if (!is_null($path) && file_exists($fullPath)) {
                    // Hapus file di /uploads/doc_forum_kec
                    unlink($fullPath);
                }
                // if (!is_null($path) && file_exists(public_path('uploads/doc_forum_kec/' . $path))) {
                    
                //     unlink(public_path('uploads/doc_forum_kec/' . $path));
                // }
            }
            
            

            $activity->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Gagal menghapus data');

        }
        

       
    }

    //sekre kec

    public function storeForumDesa(Request $request, $id)
    {

        $request->validate([
            'district' => 'required',
            'subdistrict' => 'required',
            'f_subdistrict' => 'required',
            'no_sk' => 'required',
            'expired_sk' => 'required',
            'f_budget' => 'required',
            's_address' => 'required',

            'path_sk_f' => 'nullable|mimes:pdf|max:2048',
            'path_plan_f' => 'nullable|mimes:pdf|max:2048',
            'path_s' => 'nullable|mimes:pdf|max:2048',
            'path_budget' => 'nullable|mimes:pdf|max:2048',

        ],[
            'district.required' => 'Nama Kecamatan wajib diisi',
            'subdistrict.required' => 'Nama Kelurahan wajib diisi',
            'f_district.required' => 'Nama Pokja wajib diisi',
            'no_sk.required' => 'No SK wajib dipilih',
            'expired_sk.required' => 'Masa Berlaku SK wajib diisi',
            'f_budget.required' => 'Anggaran wajib diisi',
            's_address.required' => 'Alamat Sekretariat Pokja wajib diisi',

            'path_sk_f.mimes' => 'File Wajib Pdf',
            'path_sk_f.max' => 'Ukuran file tidak boleh melebihi 2MB.',

            'path_plan_f.mimes' => 'File Wajib Pdf',
            'path_plan_f.max' => 'Ukuran file tidak boleh melebihi 2MB.',

            'path_s.mimes' => 'File Wajib Pdf',
            'path_s.max' => 'Ukuran file tidak boleh melebihi 2MB.',

            'path_budget.mimes' => 'File Wajib Pdf',
            'path_budget.max' => 'Ukuran file tidak boleh melebihi 2MB.',
            
        ]);

        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        $path = $request->file('path'); 
        // $budget = $request->input('f_budget'); 
        // return $budget

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
            // if($path){
                // $file = $request->file('path'); 

                // $fileName = $idZona. '_' . $path->getClientOriginalName();
                // $path->move(public_path('uploads/doc_forum_kec/'), $fileName);

                $activity = new Trans_Forum_Kel();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->district = $request->district;
                $activity->subdistrict = $request->subdistrict;

                $activity->f_subdistrict = $request->f_subdistrict;
                $activity->no_sk = $request->no_sk;
                $activity->expired_sk = $request->expired_sk;

                // $activity->f_budget = $request->f_budget;
                $activity->f_budget = floatval(str_replace('.', '', $request->f_budget));
                $activity->s_address = $request->s_address;


                if ($request->hasFile('path_sk_f')) {
                    $path1 = $request->file('path_sk_f');
                    $fileName = time() . '_SK_Pokja' . $path1->getClientOriginalName();
                    // $path1->move(public_path('uploads/doc_pokja_desa'), $fileName);
                    $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName);
                    $activity->path_sk_f = $fileName; // Simpan jika tidak null
                }
                
                // Cek dan proses file Renja
                if ($request->hasFile('path_plan_f')) {
                    $path2 = $request->file('path_plan_f');
                    $fileName2 = time() . '_Renja_' . $path2->getClientOriginalName();
                    // $path2->move(public_path('uploads/doc_pokja_desa/'), $fileName2);
                    $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName2);
                    $activity->path_plan_f = $fileName2; // Simpan jika tidak null
                }
                
                // Cek dan proses file Sekre
                if ($request->hasFile('path_s')) {
                    $path3 = $request->file('path_s');
                    $fileName3 = time() . '_Sekre_' . $path3->getClientOriginalName();
                    // $path3->move(public_path('uploads/doc_pokja_desa/'), $fileName3);
                    $path3->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName3);
                    $activity->path_s = $fileName3; // Simpan jika tidak null
                }
                
                // Cek dan proses file Budget/Anggaran
                if ($request->hasFile('path_budget')) {
                    $path4 = $request->file('path_budget');
                    $fileName4 = time() . '_Anggaran_' . $path4->getClientOriginalName();
                    // $path4->move(public_path('uploads/doc_pokja_desa/'), $fileName4);
                    $path4->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName4);
                    $activity->path_budget = $fileName4; // Simpan jika tidak null
                }

                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();

                return redirect()->back()->with('success', 'Berhasil menambahkan data');


            
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }

    }

    public function editForumDesa($id)
    {
        $activity = Trans_Forum_Kel::findOrFail($id);
        // return $activity;
        return view('operator_kabkota.kelembagaan_v2.edit_forum_kel', compact('activity'));
    }

    public function updateForumDesa(Request $request, $id)
    {
        // $activity = Trans_Forum_Kec::findOrFail($id);
        // return $activity;
        $request->validate([
            'district' => 'required',
            'subdistrict' => 'required',
            'f_subdistrict' => 'required',
            'no_sk' => 'required',
            'expired_sk' => 'required',
            'f_budget' => 'required',
            's_address' => 'required',

            'path_sk_f' => 'nullable|mimes:pdf|max:2048',
            'path_plan_f' => 'nullable|mimes:pdf|max:2048',
            'path_s' => 'nullable|mimes:pdf|max:2048',
            'path_budget' => 'nullable|mimes:pdf|max:2048',

        ],[
            'district.required' => 'Nama Kecamatan wajib diisi',
            'subdistrict.required' => 'Nama Kelurahan wajib diisi',
            'f_subdistrict.required' => 'Pokja Desa wajib diisi',
            'no_sk.required' => 'No SK wajib dipilih',
            'expired_sk.required' => 'Masa Berlaku SK wajib diisi',
            'f_budget.required' => 'Anggaran wajib diisi',
            's_address.required' => 'Alamat Sekretariat Pokja Desa wajib diisi',

            'path_sk_f' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
            'path_plan_f' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
            'path_s' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
            'path_budget' => ['mimes' => 'File Wajib Pdf', 'max' => 'File Ukuran Maksimal 2MB'],
        ]);

        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try 
        {
           
            $activity = Trans_Forum_Kel::find($id);
            $activity->district = $request->district;
            $activity->subdistrict = $request->subdistrict;
            $activity->f_subdistrict = $request->f_subdistrict;
            $activity->no_sk = $request->no_sk;
            $activity->expired_sk = $request->expired_sk;

            $activity->f_budget = floatval(str_replace('.', '', $request->f_budget));
            $activity->s_address = $request->s_address;

            if ($request->hasFile('path_sk_f')) {
                $path1 = $request->file('path_sk_f');
                $fileName = $idZona . '_' . $path1->getClientOriginalName();
                // $path1->move(public_path('uploads/doc_pokja_desa/'), $fileName);
                $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName);
                if($activity->path_sk_f){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_sk_f;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                    // $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_sk_f);
                    // if (file_exists($oldPath)) {
                    //     unlink($oldPath);
                    // }
                }
                $activity->path_sk_f = $fileName; // Simpan jika tidak null
            }
            
            // Cek dan proses file Renja
            if ($request->hasFile('path_plan_f')) {
                $path2 = $request->file('path_plan_f');
                $fileName2 = $idZona . '_' . $path2->getClientOriginalName();
                // $path2->move(public_path('uploads/doc_pokja_desa/'), $fileName2);
                $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName2);
                if($activity->path_plan_f){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_plan_f;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                    // $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_plan_f);
                    // if (file_exists($oldPath)) {
                    //     unlink($oldPath);
                    // }
                }
                $activity->path_plan_f = $fileName2; // Simpan jika tidak null
            }
            
            // Cek dan proses file Sekre
            if ($request->hasFile('path_s')) {
                $path3 = $request->file('path_s');
                $fileName3 = $idZona . '_' . $path3->getClientOriginalName();
                // $path3->move(public_path('uploads/doc_pokja_desa/'), $fileName3);
                $path3->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName3);
                if($activity->path_s){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_s;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                    // $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_s);
                    // if (file_exists($oldPath)) {
                    //     unlink($oldPath);
                    // }
                }
                
                $activity->path_s = $fileName3; // Simpan jika tidak null
            }
            
            // Cek dan proses file Budget/Anggaran
            if ($request->hasFile('path_budget')) {
                $path4 = $request->file('path_budget');
                $fileName4 = $idZona . '_' . $path4->getClientOriginalName();
                // $path4->move(public_path('uploads/doc_pokja_desa/'), $fileName4);
                $path4->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName4);
                if($activity->path_budget){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_budget;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                    // $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_budget);
                    // if (file_exists($oldPath)) {
                    //     unlink($oldPath);
                    // }
                }
                $activity->path_budget = $fileName4; // Simpan jika tidak null

            }
            $activity->updated_by = $user->id;
            $activity->save();
            return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah data');


        } 
        catch (\Throwable $th) 
        {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal mengubah data');

        }

    }

    public function destroyForumDesa($id)
    {
        $activity = Trans_Forum_Kel::find($id);
        // return $activity;

        try {
            $paths = [
                $activity->path_sk_f,
                $activity->path_plan_f,
                $activity->path_s,
                $activity->path_budget
            ];
            
            
            foreach ($paths as $path) {
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/doc_pokja_desa/' . $path;
                if (!is_null($path) && file_exists($fullPath)) {
                    // Hapus file di /uploads/doc_forum_kec
                    unlink($fullPath);
                }
                // if (!is_null($path) && file_exists(public_path('uploads/doc_forum_kec/' . $path))) {
                    
                //     unlink(public_path('uploads/doc_forum_kec/' . $path));
                // }
            }
            
           
            
            
    
            $activity->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Gagal menghapus data');

        }
        
    }

    //NEW POKJA
    public function showPokjaDesa($idCKelembagaan, $idSubdistrict)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        $category = M_C_Kelembagaan_New::find($idCKelembagaan);

        $subdistrict = M_SubDistrict::find($idSubdistrict);
        $village = M_Village::where('subdistrict_id', $idSubdistrict)
        ->where('is_active',1)
        ->get();

        $forumKel = Trans_Forum_Kel::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $category->id)
            ->get();

        $activity = Trans_Kegiatan::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $category->id)
            ->get();

        $schedule = Setting_Time::where('id_group', $user->id_group)->first();

        $sent = [
            'subdistrict' => $subdistrict,
            'village' => $village,
            'forumKel' => $forumKel,
            'category' => $category,
            'activity' => $activity,
            'schedule' => $schedule
        ];
        return view('operator_kabkota.kelembagaan_v2.pokja.index', $sent);
        // return $subdistrict;
    }

    public function createSkPokjaDesa($idCategory, $idVillage){
        $village = M_Village::find($idVillage);
        $category = M_C_Kelembagaan_New::find($idCategory);
        $sent = [
            'village' => $village,
            'category' => $category
        ];
        return view('operator_kabkota.kelembagaan_v2.pokja.create_sk', $sent);

    }

    public function storeSKPokjaDesa(Request $request, $id)
    {

        $request->validate([
            'id_village' => 'required',
            'f_village' => 'required',
            'no_sk' => 'required',
            'expired_sk' => 'required',
            'f_budget' => 'required',
            's_address' => 'required',

            'path_sk_f' => 'nullable|mimes:pdf|max:2048',
            'path_plan_f' => 'nullable|mimes:pdf|max:2048',
            'path_s' => 'nullable|mimes:pdf|max:2048',
            'path_budget' => 'nullable|mimes:pdf|max:2048',

        ],[
            'id_village.required' => 'Nama Kelurahan wajib diisi',
            'f_village.required' => 'Nama Pokja wajib diisi',
            'no_sk.required' => 'No SK wajib dipilih',
            'expired_sk.required' => 'Masa Berlaku SK wajib diisi',
            'f_budget.required' => 'Anggaran wajib diisi',
            's_address.required' => 'Alamat Sekretariat Pokja wajib diisi',

            'path_sk_f.mimes' => 'File SK Pokja Desa Wajib Pdf',
            'path_sk_f.max' => 'Ukuran file SK Pokja Desa tidak boleh melebihi 2MB.',

            'path_plan_f.mimes' => 'File Renja Wajib Pdf',
            'path_plan_f.max' => 'Ukuran file Renja tidak boleh melebihi 2MB.',

            'path_s.mimes' => 'File Sekretariat Pokja Wajib Pdf',
            'path_s.max' => 'Ukuran file Sekretariat Pokja tidak boleh melebihi 2MB.',

            'path_budget.mimes' => 'File Anggaran Pokja Wajib Pdf',
            'path_budget.max' => 'Ukuran file Anggaran Pokja tidak boleh melebihi 2MB.',
            
        ]);

        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        $village = M_Village::find($request->id_village);

        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {

                $activity = new Trans_Forum_Kel();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->id_village = $request->id_village;

                $activity->f_village = $request->f_village;
                $activity->no_sk = $request->no_sk;
                $activity->expired_sk = $request->expired_sk;

                $activity->f_budget = floatval(str_replace('.', '', $request->f_budget));
                $activity->s_address = $request->s_address;


                if ($request->hasFile('path_sk_f')) {
                    $path1 = $request->file('path_sk_f');
                    
                    // $fileName = $user->id . '_SK_Pokja' . $path1->getClientOriginalName();
                    // $path1->move(public_path('uploads/doc_pokja_desa'), $fileName);
                    // $activity->path_sk_f = $fileName; 

                    $fileName = $user->id . '_SK_POKJA' . $path1->getClientOriginalName();
                    $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName);
                    $activity->path_sk_f = $fileName;
                }
                
                // Cek dan proses file Renja
                if ($request->hasFile('path_plan_f')) {
                    $path2 = $request->file('path_plan_f');
                    // $fileName2 = time() . '_Renja_' . $path2->getClientOriginalName();
                    // $path2->move(public_path('uploads/doc_pokja_desa/'), $fileName2);
                    // $activity->path_plan_f = $fileName2; 

                    $fileName2 = $user->id . '_Renja_' . $path2->getClientOriginalName();
                    $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName2);
                    $activity->path_sk_f = $fileName2;
                }
                
                // Cek dan proses file Sekre
                if ($request->hasFile('path_s')) {
                    $path3 = $request->file('path_s');
                    // $fileName3 = time() . '_Sekre_' . $path3->getClientOriginalName();
                    // $path3->move(public_path('uploads/doc_pokja_desa/'), $fileName3);
                    // $activity->path_s = $fileName3; // Simpan jika tidak null

                    $fileName3 = $user->id . '_Sekretariat_' . $path3->getClientOriginalName();
                    $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName3);
                    $activity->path_sk_f = $fileName3;
                }
                
                // Cek dan proses file Budget/Anggaran
                if ($request->hasFile('path_budget')) {
                    $path4 = $request->file('path_budget');
                    // $fileName4 = time() . '_Anggaran_' . $path4->getClientOriginalName();
                    // $path4->move(public_path('uploads/doc_pokja_desa/'), $fileName4);
                    // $activity->path_budget = $fileName4; // Simpan jika tidak null

                    $fileName4 = $user->id . '_Anggaran_' . $path4->getClientOriginalName();
                    $path4->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName4);
                    $activity->path_budget = $fileName4;
                    
                }

                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('pokja-desa.showPokjaDesa', [$id, $village->subdistrict_id])->with('success', 'Berhasil mengubah data');

                // return redirect()->back()->with('success', 'Berhasil menambahkan data');


            
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }

    }

    public function editSkPokjaDesa($idValue, $idVillage)
    {
        $village = M_Village::find($idVillage);
        $activity = Trans_Forum_Kel::find($idValue);
        $sent = [
            'village' => $village,
            'activity' => $activity
        ];
        return view('operator_kabkota.kelembagaan_v2.pokja.edit_sk', $sent);
    }

    public function updateSKPokjaDesa(Request $request, $id)
    {
        // $activity = Trans_Forum_Kec::findOrFail($id);
        // return $activity;
        $request->validate([
            'f_village' => 'required',
            'no_sk' => 'required',
            'expired_sk' => 'required',
            'f_budget' => 'required',
            's_address' => 'required',

            'path_sk_f' => 'nullable|mimes:pdf|max:2048',
            'path_plan_f' => 'nullable|mimes:pdf|max:2048',
            'path_s' => 'nullable|mimes:pdf|max:2048',
            'path_budget' => 'nullable|mimes:pdf|max:2048',

        ],[
            'f_village.required' => 'Pokja Desa wajib diisi',
            'no_sk.required' => 'No SK wajib dipilih',
            'expired_sk.required' => 'Masa Berlaku SK wajib diisi',
            'f_budget.required' => 'Anggaran wajib diisi',
            's_address.required' => 'Alamat Sekretariat Pokja Desa wajib diisi',

            'path_sk_f.mimes' => 'File SK Pokja Desa Wajib Pdf',
            'path_sk_f.max' => 'Ukuran file SK Pokja Desa tidak boleh melebihi 2MB.',

            'path_plan_f.mimes' => 'File Renja Wajib Pdf',
            'path_plan_f.max' => 'Ukuran file Renja tidak boleh melebihi 2MB.',

            'path_s.mimes' => 'File Sekretariat Pokja Wajib Pdf',
            'path_s.max' => 'Ukuran file Sekretariat Pokja tidak boleh melebihi 2MB.',

            'path_budget.mimes' => 'File Anggaran Pokja Wajib Pdf',
            'path_budget.max' => 'Ukuran file Anggaran Pokja tidak boleh melebihi 2MB.',
        ]);

        $path = $request->file('path'); 
        $village = M_Village::find($request->id_village); 


        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try 
        {
           
            $activity = Trans_Forum_Kel::find($id);
            $activity->f_village = $request->f_village;
            $activity->no_sk = $request->no_sk;
            $activity->expired_sk = $request->expired_sk;

            $activity->f_budget = floatval(str_replace('.', '', $request->f_budget));
            $activity->s_address = $request->s_address;

            if ($request->hasFile('path_sk_f')) {
                $path1 = $request->file('path_sk_f');
                
                $fileName = $user->id . '_SK_' . $path1->getClientOriginalName();
                $path1->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName);
                // $path1->move(public_path('uploads/doc_forum_kec/'), $fileName);
                if($activity->path_sk_f){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_sk_f;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $activity->path_sk_f = $fileName; // Simpan jika tidak null
            }
            
            // Cek dan proses file Renja
            if ($request->hasFile('path_plan_f')) {
                $path2 = $request->file('path_plan_f');
                $fileName2 = $user->id . '_Renja_' . $path2->getClientOriginalName();
                // $path2->move(public_path('uploads/doc_forum_kec/'), $fileName2);
                $path2->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName2);
                if($activity->path_plan_f){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_plan_f;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $activity->path_plan_f = $fileName2; 
            }
            
            // Cek dan proses file Sekre
            if ($request->hasFile('path_s')) {
                $path3 = $request->file('path_s');
                $fileName3 = $user->id . '_Sekretariat_' . $path3->getClientOriginalName();
                // $path3->move(public_path('uploads/doc_forum_kec/'), $fileName3);
                $path3->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName3);
                if($activity->path_s){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_s;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                
                $activity->path_s = $fileName3; // Simpan jika tidak null
            }
            
            // Cek dan proses file Budget/Anggaran
            if ($request->hasFile('path_budget')) {
                $path4 = $request->file('path_budget');
                $fileName4 = $user->id . '_Anggaran_' . $path4->getClientOriginalName();
                // $path4->move(public_path('uploads/doc_forum_kec/'), $fileName4);
                $path4->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/', $fileName4);
                
                if($activity->path_budget){
                    $oldPhotoPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pokja_desa/' .$activity->path_budget;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                   
                }
                $activity->path_budget = $fileName4; // Simpan jika tidak null

            }



            // if ($request->hasFile('path_sk_f')) {
            //     $path1 = $request->file('path_sk_f');
            //     $fileName = $idZona . '_' . $path1->getClientOriginalName();
            //     $path1->move(public_path('uploads/doc_pokja_desa/'), $fileName);
            //     if($activity->path_sk_f){
            //         $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_sk_f);
            //         if (file_exists($oldPath)) {
            //             unlink($oldPath);
            //         }
            //     }
            //     $activity->path_sk_f = $fileName; // Simpan jika tidak null
            // }
            
            // // Cek dan proses file Renja
            // if ($request->hasFile('path_plan_f')) {
            //     $path2 = $request->file('path_plan_f');
            //     $fileName2 = $idZona . '_' . $path2->getClientOriginalName();
            //     $path2->move(public_path('uploads/doc_pokja_desa/'), $fileName2);
            //     if($activity->path_plan_f){
            //         $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_plan_f);
            //         if (file_exists($oldPath)) {
            //             unlink($oldPath);
            //         }
            //     }
            //     $activity->path_plan_f = $fileName2; // Simpan jika tidak null
            // }
            
            // // Cek dan proses file Sekre
            // if ($request->hasFile('path_s')) {
            //     $path3 = $request->file('path_s');
            //     $fileName3 = $idZona . '_' . $path3->getClientOriginalName();
            //     $path3->move(public_path('uploads/doc_pokja_desa/'), $fileName3);
            //     if($activity->path_s){
            //         $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_s);
            //         if (file_exists($oldPath)) {
            //             unlink($oldPath);
            //         }
            //     }
                
            //     $activity->path_s = $fileName3; // Simpan jika tidak null
            // }
            
            // // Cek dan proses file Budget/Anggaran
            // if ($request->hasFile('path_budget')) {
            //     $path4 = $request->file('path_budget');
            //     $fileName4 = $idZona . '_' . $path4->getClientOriginalName();
            //     $path4->move(public_path('uploads/doc_pokja_desa/'), $fileName4);

            //     if($activity->path_budget){
            //         $oldPath = public_path('uploads/doc_pokja_desa/' . $activity->path_budget);
            //         if (file_exists($oldPath)) {
            //             unlink($oldPath);
            //         }
            //     }
            //     $activity->path_budget = $fileName4; // Simpan jika tidak null

            // }

            $activity->updated_by = $user->id;
            $activity->save();
            return redirect()->route('pokja-desa.showPokjaDesa', [$activity->id_c_kelembagaan, $village->subdistrict_id])->with('success', 'Berhasil mengubah data');


        } 
        catch (\Throwable $th) 
        {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal mengubah data');

        }

    }

    public function destroyPokjaDesa($id)
    {
        $activity = Trans_Forum_Kel::find($id);
        // return $activity;
        

        try {
            // if (!is_null($activity->path_sk_f) && file_exists(public_path('uploads/doc_pokja_desa/'.$activity->path_sk_f))) {
            //     // Hapus file di public/uploads/doc_kelembagaan
            //     unlink(public_path('uploads/doc_pokja_desa/'.$activity->path_sk_f));
            // }
    
            // if (!is_null($activity->path_plan_f) && file_exists(public_path('uploads/doc_pokja_desa/'.$activity->path_plan_f))) {
            //     // Hapus file di public/uploads/doc_kelembagaan
            //     unlink(public_path('uploads/doc_pokja_desa/'.$activity->path_plan_f));
            // }
            // if (!is_null($activity->path_s) && file_exists(public_path('uploads/doc_pokja_desa/'.$activity->path_s))) {
            //     // Hapus file di public/uploads/doc_kelembagaan
            //     unlink(public_path('uploads/doc_pokja_desa/'.$activity->path_s));
            // }
            // if (!is_null($activity->path_budget) && file_exists(public_path('uploads/doc_pokja_desa/'.$activity->path_budget))) {
            //     // Hapus file di public/uploads/doc_kelembagaan
            //     unlink(public_path('uploads/doc_pokja_desa/'.$activity->path_budget));
            // }

            $paths = [
                $activity->path_sk_f,
                $activity->path_plan_f,
                $activity->path_s,
                $activity->path_budget
            ];
            
            
            foreach ($paths as $path) {
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/doc_pokja_desa/' . $path;
                if (!is_null($path) && file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            
            
    
            $activity->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Gagal menghapus data');

        }
        
    }

    //act-desa
    public function createActivityPokja($idCategory, $idVillage)
    {
        $village = M_Village::find($idVillage);
        $category = M_C_Kelembagaan_New::find($idCategory);

        // return $category;
        $sent = [
            'village' => $village,
            'category' => $category
        ];
        // return $subdistrict;
        return view('operator_kabkota.kelembagaan_v2.pokja.create_activity', $sent);

    }

    public function storeActivityPokja(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'id_kode' => 'required',
            'time' => 'required',
            'participant' => 'required',
            'result' => 'required',
            'note' => 'required',
            'path' => 'nullable|mimes:pdf|max:2048',
        ],[
            'name.required' => 'Option wajib diisi',
            'id_kode.required' => 'Kode Kecamatan wajib diisi',
            'time.required' => 'Waktu wajib dipilih',
            'result.required' => 'Hasil wajib dipilih',
            'note.required' => 'Keterangan wajib dipilih',
            'path.mimes' => 'File Wajib Pdf',
            'path.max' => 'FIle Ukuran Maksimal 2MB',
        ]);

        $c_kelembagaan = M_C_Kelembagaan_New::find($id);
        $village = M_Village::find($request->id_kode);
        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
            if($path){
                // $file = $request->file('path'); 
                $fileName = $user->id . '_Kegiatan_Pokja_' . $path->getClientOriginalName();
                    $path->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/', $fileName);
                // $fileName = $idZona. '_' . $path->getClientOriginalName();
                // $path->move(public_path('uploads/doc_activity/'), $fileName);

                $activity = new Trans_Kegiatan();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->id_kode = $request->id_kode;

                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->path = $fileName;

                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();

                return redirect()->route('pokja-desa.showPokjaDesa', [$activity->id_c_kelembagaan, $village->subdistrict_id])->with('success', 'Berhasil menambah data');

                // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');


            }

            else
            {
                $activity = new Trans_Kegiatan();
                $activity->id_survey = $session_date;
                $activity->id_zona = $idZona;

                $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->id_kode = $request->id_kode;

                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('pokja-desa.showPokjaDesa', [$activity->id_c_kelembagaan, $village->subdistrict_id])->with('success', 'Berhasil menambah data');

                // return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah data');

                // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');

            }


        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan kegiatan');

        }

    }


    public function editActivityPokja($idValue, $idVillage)
    {
        $village = M_Village::find($idVillage);
        $activity = Trans_Kegiatan::find($idValue);
        $sent = [
            'village' => $village,
            'activity' => $activity
        ];
        // return $subdistrict;
        return view('operator_kabkota.kelembagaan_v2.pokja.edit_activity', $sent);

    }

    
    public function updateActivityPokjaDesa(Request $request, $id)
    {
        // $activity = Trans_Kegiatan::findOrFail($id);
        // return $activity;
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

        $village = M_Village::find($request->id_kode);

        $path = $request->file('path'); 

        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        try {
            if($path){
                // $file = $request->file('path'); 
                $fileName = $user->id . '_Kegiatan_Pokja_' . $path->getClientOriginalName();
                $path->move($_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/', $fileName);
                    
                // $fileName = $idZona. '_' . $path->getClientOriginalName();
                // $path->move(public_path('uploads/doc_activity/'), $fileName);

                $activity = Trans_Kegiatan::find($id);
                if ($activity->path) {
                    $oldPath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_activity/' .$activity->path;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }

                    // $oldPath = public_path('uploads/doc_activity/' . $activity->path);
                    // if (file_exists($oldPath)) {
                    //     unlink($oldPath);
                    // }
                }
                // $activity->id_survey = $session_date;
                // $activity->id_zona = $idZona;

                // $activity->id_c_kelembagaan = $id;
                $activity->name = $request->name;
                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->path = $fileName;
                $activity->created_by = $user->id;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('pokja-desa.showPokjaDesa', [$activity->id_c_kelembagaan, $village->subdistrict_id])->with('success', 'Berhasil mengubah data');

                // return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah kegiatan');

                // return redirect()->back()->with('success', 'Berhasil menambahkan kegiatan');


            }

            else
            {
                $activity = Trans_Kegiatan::find($id);
                $activity->name = $request->name;
                $activity->time = $request->time;
                $activity->participant = $request->participant;
                $activity->result = $request->result;
                $activity->note = $request->note;
                $activity->updated_by = $user->id;

                $activity->save();
                return redirect()->route('pokja-desa.showPokjaDesa', [$activity->id_c_kelembagaan, $village->subdistrict_id])->with('success', 'Berhasil mengubah data');

                // return redirect()->route('kelembagaan-v2.show', $activity->id_c_kelembagaan)->with('success', 'Berhasil mengubah kegiatan');

            }


        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal menambahkan kegiatan');

        }

    }
}
