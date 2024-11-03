<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_Questions;
use App\Models\M_Zona;
use App\Models\Setting_Time;
use App\Models\Trans_Survey;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use Auth;
use File;
use Illuminate\Http\Request;
use Session;

class Answer_KabKota_Controller extends Controller
{
    public function index()
    {
        $category = M_Category::all();
        return view('operator_kabkota.index', compact('category'));
    }


    public function show($id)
    {
        $session_date = Session::get('selected_year');
        $dates = Trans_Survey::all();
        $date = Trans_Survey::find($session_date);
        // return $session_date;
        $user = Auth::user();
        $idZona = $user->id_zona;
        $category = M_Category::find($id);
        $questions = M_Questions::where('id_category', $id)
            ->where('id_survey', $session_date)    
            ->get();
        $answer = Trans_Survey_D_Answer::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();

        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();
        $schedule = Setting_Time::where('id_group', $user->id_group)->first();
        $sent = [
            'category' => $category,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'idZona' => $idZona,
            'session_date' =>$session_date,
            'date' => $date,
            'dates' => $dates, 
            'schedule' => $schedule
        ];
        return view('operator_kabkota.answer.index', $sent);
    }


    public function store(Request $request, $questionId, $docQuestionId)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_option' => 'required',
            'comment' => 'required',
            'achievement' => 'required',
            'nama_data.*' => 'nullable',
            'file_path.*' => 'nullable|mimes:pdf|max:25000',
            'nama_data' => 'nullable|array',
            'file_path' => 'nullable|array',
        ],[
            'id_option.required' => 'Option wajib diisi',
            'id_survey.required' => 'Tahun wajib dipilih',
            'comment.required' => 'Penjelasan wajib diisi',
            'achievement.required' => 'Capaian wajib diisi',
            // 'nama_data.*.required' => 'Nama Dokumen wajib diisi',
            'file_path.*.mimes' => 'File wajib pdf',
            'file_path.*.max' => 'Ukuran file maksimal 25 MB',
        ]);

        $files = $request->file_path; 
        $namaData = $request->nama_data;

        $user = Auth::user();
        $idZona = $user->id_zona;
        $question = M_Questions::find($questionId);
        $session_date = Session::get('selected_year');

        try {
            $relatedAnswer = Trans_Survey_D_Answer::where('id_question', $questionId)
                ->where('id_survey', $session_date)
                ->where('id_zona',$idZona)
                ->first();

            if ($relatedAnswer) {
                $relatedAnswer->update([
                    'id_option' => $request->id_option,
                ]);
            }

            else {
                $relatedAnswer = Trans_Survey_D_Answer::create([
                    'id_survey' => $session_date,
                    'id_option' => $request->id_option,
                    'comment' => $request->comment,
                    'achievement' => $request->achievement,
                    'id_zona' => $idZona,
                    'id_question' => $question->id,
                    'id_category' => $question->id_category,
                ]);
            }

            $uploadedFiles = [];

            if ($request->hasFile('file_path') &&  $request->has('nama_data')){
                foreach ($files as $index => $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName);
                    $uploadedFiles[] = [
                        'nama_data' => $namaData[$index],
                        'file_path' => 'uploads/' . $fileName,
                    ];
                }
        
                foreach ($uploadedFiles as $data) {
                    $uploadPdf = new Trans_Upload_KabKota();
                    $uploadPdf->id_survey = $session_date;
                    $uploadPdf->id_zona = $idZona;
                    $uploadPdf->id_category = $question->id_category;
                    $uploadPdf->id_question = $question->id;
                    $uploadPdf->nama_data = $data['nama_data'];
                    $uploadPdf->file_path = $data['file_path'];
                    $uploadPdf->save();
                }

            }


            if ($request->replace_file) {
                foreach ($request->replace_file as $index => $fileId) {
                    if ($request->hasFile('new_file_path.' . $index)) {
                        $file = $request->file('new_file_path.' . $index);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads'), $fileName);
            
                        $existingFile = Trans_Upload_KabKota::find($fileId);
                        if ($existingFile) {
                            $newNamaData = $request->new_nama_data[$index] ?? $existingFile->nama_data;
                            if (File::exists(public_path($existingFile->file_path))) {
                                File::delete(public_path($existingFile->file_path));
                            }
                            $existingFile->update([
                                'nama_data' => $newNamaData, 
                                'file_path' => 'uploads/' . $fileName,
                            ]);
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'Berhasil memverifikasi pertanyaan');

        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Gagal memverifikasi pertanyaan');

        }

    }

    public function store2(Request $request, $questionId)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_option' => 'required',
            'comment' => 'required',
            'achievement' => 'required',
            'file_path' => 'nullabel|mimes:pdf|max:2048',
        ],[
            'id_option.required' => 'Option wajib diisi',
            'id_survey.required' => 'Tahun wajib dipilih',
            'comment.required' => 'Penjelasan wajib diisi',
            'achievement.required' => 'Capaian wajib diisi',
            'file_path.mimes' => 'Wajib Pdf',
            'file_path.max' => 'Ukuran Maksimal 2 MB',

        ]);

        $files = $request->file_path; 

        $user = Auth::user();
        $idZona = $user->id_zona;

        $question = M_Questions::find($questionId);
        $session_date = Session::get('selected_year');

        // $file = $request->file('file_path'); 
        // $fileName = $idZona. '_' . $file->getClientOriginalName();
        // $file->move(public_path('uploads/doc_pendukung/'), $fileName);

        try {
            $relatedAnswer = Trans_Survey_D_Answer::where('id_question', $questionId)
                ->where('id_survey', $session_date)
                ->where('id_zona',$idZona)
                ->first();

            if ($relatedAnswer) {
                $relatedAnswer->update([
                    'id_option' => $request->id_option,
                    'comment' => $request->comment,
                    'achievement' => $request->achievement,
                ]);
            }

            else {
                $relatedAnswer = Trans_Survey_D_Answer::create([
                    'id_survey' => $session_date,
                    'id_option' => $request->id_option,
                    'comment' => $request->comment,
                    'achievement' => $request->achievement,

                    'id_zona' => $idZona,
                    'id_question' => $question->id,
                    'id_category' => $question->id_category,
                ]);
            }

            foreach ($request->file() as $key => $file) {
                if (strpos($key, 'file_') !== false) {
                    $this->validate($request, [
                        $key => 'required|mimes:pdf|max:2048',
                    ], [
                        $key . '.required' => 'File ' . $key . ' harus diisi.',
                        $key . '.mimes' => 'File ' . $key . ' harus berformat PDF.',
                        $key . '.max' => 'File ' . $key . ' tidak boleh lebih besar dari 2 MB.',
                    ]);

                    $ids = str_replace('file_', '', $key);
                    $fileId = $request->input('file_id_' . $ids);
                    if ($fileId) {
                        // Update file
                        $uploadedFile = Trans_Upload_KabKota::find($fileId);
                        $uploadedFile->filename = $file->getClientOriginalName();
                        $uploadedFile->save();
                    } else {
                        // Create file
                        $fileName = $idZona. '_' . $file->getClientOriginalName();
                        // $file->move(public_path('uploads/doc_pendukung/'), $fileName);
                        $file->move($_SERVER['DOCUMENT_ROOT'].'/uploads/doc_pendukung/', $fileName);

                        $uploadedFile = new Trans_Upload_KabKota();
                        
                        $uploadedFile->file_path = $fileName;
                        $uploadedFile->id_zona = $idZona;
                        $uploadedFile->id_survey = $session_date;
                        $uploadedFile->id_category = $question->id_category;
                        $uploadedFile->id_question = $question->id;
                        $uploadedFile->id_doc_question = $ids;
                        $uploadedFile->save();
                    }
                }
            }
            // $relatedUploaded = Trans_Upload_KabKota::where('id_question', $questionId)
            //     ->where('id_survey', $session_date)
            //     ->where('id_zona',$idZona)
            //     ->first();

            // if($relatedUploaded)
            // {
            //     $relatedUploaded->update([
            //         'id_option' => $request->id_option,
            //     ]);
            // }
            // else
            // {
            //     $relatedUploaded = Trans_Upload_KabKota::create([
            //         'id_survey' => $session_date,
            //         'id_zona' => $idZona,
            //         'id_question' => $question->id,
            //         'id_category' => $question->id_category,
            //         'id_doc_question' => $docQuestionId,
            //         'file_path' => 'uploads/doc_pendukung/' . $fileName,
                    
            //     ]);
            // }
            

            return redirect()->back()->with('success', 'Berhasil memverifikasi pertanyaan');

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function destroyDoc($id)
    {
        $file = Trans_Upload_KabKota::findOrFail($id);
        $oldFilePath = $_SERVER['DOCUMENT_ROOT']. '/uploads/doc_pendukung/' .$file->file_path;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        // if (file_exists(public_path($file->file_path))) {
        //     unlink(public_path($file->file_path));
        // }
        $file->delete();
        return response()->json(['message' => 'File deleted successfully'], 200);

    }

}
