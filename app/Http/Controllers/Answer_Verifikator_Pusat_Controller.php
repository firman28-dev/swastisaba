<?php

namespace App\Http\Controllers;

use App\Models\Category_Doc_Provinsi;
use App\Models\M_Category;
use App\Models\M_Category_Kelembagaan;
use App\Models\M_District;
use App\Models\M_Doc_General_Data;
use App\Models\M_Question_Kelembagaan;
use App\Models\M_Questions;
use App\Models\M_Zona;
use App\Models\Sub_Doc_Provinsi;
use App\Models\Trans_Doc_G_Data;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Doc_Prov;
use App\Models\Trans_Kelembagaan_H;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use Illuminate\Http\Request;
use Session;

class Answer_Verifikator_Pusat_Controller extends Controller
{
    public function indexQuestion($id)
    {
        $session_date = Session::get('selected_year');
        // $zona = M_Zona::find($id);
        $zona = M_District::find($id);

        $category = M_Category::where('id_survey', $session_date)->get();
        $sent = [
            'zona' => $zona,
            'category' => $category
        ];

        return view('verifikator_pusat.question.index', $sent);


    }

    public function showCategory($id_zona, $id)
    {
        $session_date = Session::get('selected_year');
        // $zona = M_Zona::find($id_zona);
        $zona = M_District::find($id_zona);
        // return $zona;


        $category = M_Category::find($id);
        $questions = M_Questions::where('id_category', $id)
            ->where('id_survey', $session_date)
            ->get();
        $answer = Trans_Survey_D_Answer::where('id_zona',$id_zona)->where('id_survey', $session_date)->get();
        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$id_zona)->where('id_survey', $session_date)->get();
        // return $answer;
        $sent = [
            'zona' => $zona,
            'category' => $category,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles

        ];

        return view('verifikator_pusat.question.show', $sent);
    }

    public function storeQuestion(Request $request,$id_zona, $questionId)
    {
        $request->validate([
            'id_option_pusat' => 'required',
            'comment_pusat' => 'required',
        ],[
            'id_option_pusat.required' => 'Option wajib diisi',
            'comment_pusat.required' => 'Komentar wajib diisi',
        ]);


        try {
            $session_date = Session::get('selected_year');

            $relatedAnswer = Trans_Survey_D_Answer::where('id_question', $questionId)
                ->where('id_zona',$id_zona)
                ->where('id_survey',$session_date)
                ->first();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'id_option_pusat' => $request->id_option_pusat,
                    'comment_pusat' => $request->comment_pusat,
                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi pertanyaan');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kab/kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }


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
        return view('verifikator_pusat.kelembagaan.index', $sent);

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

        return view('verifikator_pusat.kelembagaan.show', $sent);
    }

    public function storeKelembagaan(Request $request, $id_zona, $id)
    {
        $request->validate([
            'answer_pusat' => 'required',
            'comment_pusat' => 'required',
        ],[
            'answer_pusat.required' => 'Option wajib diisi',
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
                    'answer_pusat' => $request->answer_pusat,
                    'comment_pusat' => $request->comment_pusat,
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
        return view('verifikator_pusat.g_data.index', $sent);
    }

    public function storeGdata(Request $request, $id_zona, $id)
    {
        $request->validate([
            'comment_pusat' => 'required',
            'is_pusat' => 'required',
        ],[
            'is_pusat.required' => 'Option wajib diisi',
            'comment_pusat.required' => 'Komentar wajib diisi',

        ]);

        try {
            $relatedAnswer = Trans_Doc_G_Data::where('id_doc_g_data', $id)
                ->where('id_zona',$id_zona)
                ->first();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'is_pusat' => $request->is_pusat,
                    'comment_pusat' => $request->comment_pusat,

                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi data umum');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function showDocProv($id)
    {
        $doc = Category_Doc_Provinsi::find($id);
        $sub_doc = Sub_Doc_Provinsi::where('id_c_doc_prov', $id)->get();
        $answer_doc = Trans_Doc_Prov::all();
        $sent = [
            'doc' => $doc,
            'sub_doc' => $sub_doc,
            'answer_doc' => $answer_doc
        ];
        return view('verifikator_pusat.doc_prov.index', $sent);
    }

    public function storeDataProv(Request $request, $id)
    {
        $request->validate([
            'comment_pusat' => 'required',
            'is_pusat' => 'required',
        ],[
            'is_pusat.required' => 'Option wajib diisi',
            'comment_pusat.required' => 'Komentar wajib diisi',
        ]);

        // return $request->is_pusat;

        try {
            $relatedAnswer = Trans_Doc_Prov::where('id_sub_doc_prov', $id)
                // ->where('id_zona',$id_zona)
                ->first();
            // return $relatedAnswer;

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'comment_pusat' => $request->comment_pusat,
                    'is_pusat' => $request->is_pusat,
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
