<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_District;
use App\Models\M_Questions;
use App\Models\M_Zona;
use App\Models\Setting_Time;
use App\Models\Trans_Survey;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use PDF;
use DB;



class Answer_KabKota_Controller extends Controller
{
    public function index()
    {
        $category = M_Category::all();
        return view('operator_kabkota.index', compact('category'));
    }

    public function indexRekap(){
        $user = Auth::user();
        $idZona = $user->id_zona;

        $session_date = Session::get('selected_year');
        $answers = M_District::where('district.id', $idZona)
            ->leftJoin('trans_survey_d_answer', function($join) use ($session_date) {
                $join->on('district.id', '=', 'trans_survey_d_answer.id_zona')
                    ->where('trans_survey_d_answer.id_survey', $session_date);
            })
            ->leftJoin('m_question_options as opt_kabkota', 'trans_survey_d_answer.id_option','=', 'opt_kabkota.id')
            ->leftJoin('m_question_options as opt_prov', 'trans_survey_d_answer.id_option_prov', '=', 'opt_prov.id')
            ->select(
                'district.id as district_id',
                'district.name as district_name',
                DB::raw('COUNT(trans_survey_d_answer.id) as total_jawaban'),
                DB::raw('SUM(opt_kabkota.score) as total_nilai_kabkota'),
                DB::raw('SUM(opt_prov.score) as total_nilai_provinsi')
            )
            ->groupBy('district.id', 'district.name')
            ->orderBy('total_jawaban', 'desc')
            ->first();

        $sent = [
            'zona' => $answers,
        ];

        // return $sent;
        return view('operator_kabkota.rekap.index', $sent);

        // return $sent;
    }


    public function show($id)
    {
        try {
            $session_date = Session::get('selected_year');
            $dates = Trans_Survey::all();
            $date = Trans_Survey::find($session_date);

            $user = Auth::user();
            $idZona = $user->id_zona;

            $category = M_Category::where('id_survey', $session_date)
                ->where('id', $id)
                ->first();

            if (!$category) {
                return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
            }

            $questions = M_Questions::where('id_category', $id)
                ->where('id_survey', $session_date)
                ->get();

            $answer = Trans_Survey_D_Answer::where('id_zona', $idZona)
                ->where('id_survey', $session_date)
                ->get();

            $uploadedFiles = Trans_Upload_KabKota::where('id_zona', $idZona)
                ->where('id_survey', $session_date)
                ->get();

            $schedule = Setting_Time::where('id_group', $user->id_group)->first();

            return view('operator_kabkota.answer.index', [
                'category' => $category,
                'questions' => $questions,
                'answer' => $answer,
                'uploadedFiles' => $uploadedFiles,
                'idZona' => $idZona,
                'session_date' => $session_date,
                'date' => $date,
                'dates' => $dates,
                'schedule' => $schedule
            ]);

        } catch (\Exception $e) {
            // Log error detail untuk debugging
            Log::error('Gagal menampilkan halaman jawaban kab/kota', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    }


    public function store2(Request $request, $questionId)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_option' => 'required',
            'comment' => 'required',
            'achievement' => 'required',
            // 'file_path' => 'nullable|mimes:pdf|max:4096',
            'file_path' => 'nullable|mimes:pdf|max:8192',
        ],[
            'id_option.required' => 'Option wajib diisi',
            'id_survey.required' => 'Tahun wajib dipilih',
            'comment.required' => 'Penjelasan wajib diisi',
            'achievement.required' => 'Capaian wajib diisi',
            'file_path.mimes' => 'Wajib Pdf',
            'file_path.max' => 'Ukuran Maksimal 8 MB',

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
                    'status_verifikasi' => $request->status_verifikasi,
                    'updated_by' => $user->id,
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
                    
                    'created_by' => $user->id,
                    'updated_by' => $user->id,

                ]);
            }

            foreach ($request->file() as $key => $file) {
                if (strpos($key, 'file_') !== false) {
                    $ids = str_replace('file_', '', $key);
                    $fileId = $request->input('file_id_' . $ids);

                    $this->validate($request, [
                        $key => 'required|mimes:pdf|max:8192',
                    ], [
                        $key . '.required' => 'File ' . $key . ' harus diisi.',
                        $key . '.mimes' => 'File ' . $key . ' harus berformat PDF.',
                        $key . '.max' => 'File ' . $key . ' tidak boleh lebih besar dari 8 MB.',
                    ]);

                    $timestamp = now()->format('YmdHis');
                    $unique = uniqid();
                    $fileName = $idZona . '_' . $timestamp . '_' . $unique . '_' . $file->getClientOriginalName();
                    $file->move($_SERVER['DOCUMENT_ROOT'].'/uploads/doc_pendukung/', $fileName);
                    
                    if ($fileId) {
                        // Update file
                        $uploadedFile = Trans_Upload_KabKota::find($fileId);
                        $uploadedFile->filename = $file->getClientOriginalName();
                        $uploadedFile->save();
                    } else {
                        // $timestamp = now()->format('YmdHis'); 
                        // $unique = uniqid();
                        // $fileName = $idZona . '_' . $timestamp . '_' . $unique . '_' . $file->getClientOriginalName();
                        // $file->move($_SERVER['DOCUMENT_ROOT'].'/uploads/doc_pendukung/', $fileName);

                        $uploadedFile = new Trans_Upload_KabKota();
                        
                        $uploadedFile->file_path = $fileName;
                        $uploadedFile->id_zona = $idZona;
                        $uploadedFile->id_survey = $session_date;
                        $uploadedFile->id_category = $question->id_category;
                        $uploadedFile->id_question = $question->id;
                        $uploadedFile->id_doc_question = $ids;
                        $uploadedFile->created_by = $user->id;

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
            // throw $th;
            \Log::error('Gagal store2: '.$th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
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


    public function exportPDF($id)
    {
        $session_date = Session::get('selected_year');
        $dates = Trans_Survey::all();
        $date = Trans_Survey::find($session_date);
        // return $session_date;
        $user = Auth::user();
        $idZona = $user->id_zona;
        $district = M_District::find($idZona);
        // $category = M_Category::find($id);
        $category = M_Category::where('id_survey',$session_date)->where('id',$id)->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }
        // return $category;
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
            'schedule' => $schedule,
            'district' => $district
        ];

        return view('operator_kabkota.export.export_pertatanan', $sent);


        // $htmlContent = view('operator_kabkota.export.export_pertatanan', $sent)->render();

        // $pdf = PDF::loadHTML($htmlContent)
        //    ->setPaper([0, 0, 595, 1000], 'landscape')  
        //    ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
       
        
        // return $pdf->download("{$district->name} - {$category->name}.pdf");
    }

    public function exportAllCategory(){
        $session_date = Session::get('selected_year');
        $trans_survey = Trans_Survey::find($session_date);
        // return $trans_survey;
        $user = Auth::user();
        $idZona = $user->id_zona;

        $district = M_District::find($idZona);
        $categories = M_Category::where('id_survey',$session_date)->get();

        $questions = M_Questions::where('id_survey', $session_date)    
            ->get();
        $answer = Trans_Survey_D_Answer::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();

        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();

        $sent = [
            'categories' => $categories,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'idZona' => $idZona,
            'session_date' =>$session_date,
            'district' => $district,
            'trans_survey' => $trans_survey
        ];

        return view('operator_kabkota.export.export_all_tatanan', $sent);
        
        // $htmlContent = view('operator_kabkota.export.export_all_tatanan', $sent)->render();

        // $pdf = PDF::loadHTML($htmlContent)
        //    ->setPaper([0, 0, 595, 1000], 'landscape')  
        //    ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
       
        
        // return $pdf->download("Tatanan {$district->name} Tahun {$trans_survey->trans_date}.pdf");
        // return $questions;
    }

}
