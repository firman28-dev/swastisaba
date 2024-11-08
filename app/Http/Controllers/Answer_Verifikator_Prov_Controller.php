<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_Category_Kelembagaan;
use App\Models\M_District;
use App\Models\M_Doc_General_Data;
use App\Models\M_Question_Kelembagaan;
use App\Models\M_Questions;
use App\Models\M_Zona;
use App\Models\Trans_Doc_G_Data;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Kelembagaan_H;
use App\Models\Trans_Survey;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Verifikator_Prov_Controller extends Controller
{
    public function index($id)
    {
        $session_date = Session::get('selected_year');
        // $zona = M_Zona::find($id);
        $zona = M_District::find($id);

        $category = M_Category::where('id_survey', $session_date)->get();
        // return $zona;
        $sent = [
            'zona' => $zona,
            'category' => $category
        ];
        return view('verifikator_provinsi.question.index', $sent);
    }

    public function indexKelembagaan($id)
    {
        $session_date = Session::get('selected_year');
        $zona = M_Zona::find($id);
        
        $category = M_Category_Kelembagaan::where('id_survey', $session_date)->get();

        $sent = [
            'zona' => $zona,
            'category' => $category
        ];
        return view('verifikator_provinsi.kelembagaan.index', $sent);

    }

    public function indexGData($id)
    {
        $session_date = Session::get('selected_year');
        $zona = M_Zona::find($id);
        $category = M_Doc_General_Data::where('id_survey', $session_date)->get();
        $doc = Trans_Doc_G_Data::where('id_zona', $zona->id)
            ->where('id_survey', $session_date)
            ->get();

        $sent = [
            'zona' => $zona,
            'category' => $category,
            'doc' => $doc
        ];
        return view('verifikator_provinsi.g_data.index', $sent);
    }

    public function showCategory($id_zona, $id)
    {
        $session_date = Session::get('selected_year');
        $zona = M_District::find($id_zona);

        $dates = Trans_Survey::all();
        $date = Trans_Survey::find($session_date);

        $category = M_Category::find($id);
        $questions = M_Questions::where('id_category', $id)
            ->where('id_survey', $session_date)
            ->get();
        $answer = Trans_Survey_D_Answer::where('id_zona',$id_zona)  
            ->where('id_survey', $session_date)
            ->get();
        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$id_zona)
            ->where('id_survey', $session_date)
            ->get();
        // return $answer;
        $sent = [
            'zona' => $zona,
            'category' => $category,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'date' => $date,
            'dates' => $dates, 

        ];

        return view('verifikator_provinsi.question.show', $sent);
    }

    public function showKelembagaan($id_zona, $id )
    {
        $session_date = Session::get('selected_year');
        $zona = M_Zona::find($id_zona);
        $category = M_Category_Kelembagaan::find($id);
        $questions = M_Question_Kelembagaan::where('id_c_kelembagaan', $id)
            ->where('id_survey', $session_date)
            ->get();
        $answer = Trans_Kelembagaan_H::where('id_zona',$id_zona)
            ->where('id_survey', $session_date)
            ->get();
        $uploadedFiles = Trans_Doc_Kelembagaan::where('id_zona',$id_zona)
            ->where('id_survey', $session_date)
            ->get();
        // return $answer;
        $sent = [
            'zona' => $zona,
            'category' => $category,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles

        ];

        return view('verifikator_provinsi.kelembagaan.show', $sent);
    }



    public function store(Request $request,$id_zona, $questionId)
    {
        $request->validate([
            'id_option_prov' => 'required',
            'comment_prov' => 'required',
        ],[
            'id_option_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',
        ]);

        $user = Auth::user();


        try {
            $session_date = Session::get('selected_year');

            $relatedAnswer = Trans_Survey_D_Answer::where('id_question', $questionId)
                ->where('id_zona',$id_zona)
                ->where('id_survey',$session_date)
                ->first();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'id_option_prov' => $request->id_option_prov,
                    'comment_prov' => $request->comment_prov,
                    'updated_by_prov' => $user->id
                ]);
            }
            return redirect()->back()->with('success', 'Berhasil memverifikasi pertanyaan');

        } catch (\Throwable $th) {
            //throw $th;
        }


    }

    public function storeKelembagaan(Request $request, $id_zona, $id)
    {
        $request->validate([
            'answer_prov' => 'required',
            'comment_prov' => 'required',
        ],[
            'answer_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',
        ]);

        // return $request->answer_prov;
        // return $request->comment_prov;


        try {
            $relatedAnswer = Trans_Kelembagaan_H::where('id_q_kelembagaan', $id)
                ->where('id_zona',$id_zona)
                ->first();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'answer_prov' => $request->answer_prov,
                    'comment_prov' => $request->comment_prov,
                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi kelembagaan');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function storeGdata(Request $request, $id_zona, $id)
    {
        $request->validate([
            'is_prov' => 'required',
        ],[
            'is_prov.required' => 'Option wajib diisi',
        ]);

        try {
            $relatedAnswer = Trans_Doc_G_Data::where('id_doc_g_data', $id)
                ->where('id_zona',$id_zona)
                ->first();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'is_prov' => $request->is_prov,
                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi kelembagaan');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
