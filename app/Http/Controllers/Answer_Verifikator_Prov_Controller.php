<?php

namespace App\Http\Controllers;

use App\Models\Gambaran_KabKota;
use App\Models\M_C_Kelembagaan_New;
use App\Models\M_Category;
use App\Models\M_Category_Kelembagaan;
use App\Models\M_District;
use App\Models\M_Doc_General_Data;
use App\Models\M_Q_Kelembagaan_New;
use App\Models\M_Question_Kelembagaan;
use App\Models\M_Questions;
use App\Models\M_SubDistrict;
use App\Models\M_Village;
use App\Models\M_Zona;
use App\Models\Pendanaan_KabKota;
use App\Models\Trans_Doc_G_Data;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Forum_Kec;
use App\Models\Trans_Forum_Kel;
use App\Models\Trans_Gambaran_Kabkota;
use App\Models\Trans_Kegiatan;
use App\Models\Trans_Kelembagaan_H;
use App\Models\Trans_Kelembagaan_V2;
use App\Models\Trans_Narasi;
use App\Models\Trans_ODF_New;
use App\Models\Trans_Pendanaan_kabkota;
use App\Models\Trans_Survey;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use Auth;
use Illuminate\Http\Request;
use Session;
use DB;
use PDF;



class Answer_Verifikator_Prov_Controller extends Controller
{
    public function index($id)
    {
        $session_date = Session::get('selected_year');
        $date = Trans_Survey::where('id', $session_date)->first();
        $zona = M_District::find($id);

        $category = M_Category::where('id_survey', $session_date)->get();
        // return $zona;
        $sent = [
            'zona' => $zona,
            'category' => $category,
            'tahun' => $date,
        ];
        return view('verifikator_provinsi.question.index', $sent);
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
        $zona = M_District::find($id);
        $date = Trans_Survey::where('id', $session_date)->first();
        
        $category = M_C_Kelembagaan_New::where('id_survey', $session_date)->get();

        $sent = [
            'zona' => $zona,
            'category' => $category,
            'tahun' => $date,

        ];
        return view('verifikator_provinsi.kelembagaan.index', $sent);

    }

    public function showKelembagaan($id_zona, $id )
    {
        $session_date = Session::get('selected_year');
        $date = Trans_Survey::find($session_date);

        $zona = M_District::find($id_zona);
        $category = M_C_Kelembagaan_New::find($id);
        $questions = M_Q_Kelembagaan_New::where('id_c_kelembagaan_v2', $id)
            ->where('id_survey', $session_date)
            ->get();
        $answer = Trans_Kelembagaan_V2::where('id_zona',$id_zona)
            ->where('id_survey', $session_date)
            ->get();
        $uploadedFiles = Trans_Doc_Kelembagaan::where('id_zona',$id_zona)
            ->where('id_survey', $session_date)
            ->get();

        $subdistrict = M_SubDistrict::where('district_id', $id_zona)->get();
        
        $forumKec = Trans_Forum_Kec::where('id_zona', $id_zona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $id)
            ->get();
        
        $activity = Trans_Kegiatan::where('id_zona', $id_zona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $id)
            ->get();

        $forumKel = Trans_Forum_Kel::where('id_zona', $id_zona)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $id)
            ->get();

        $sum_subdistrict = M_SubDistrict::where('district_id',$id_zona)
            ->where('is_active', 1)
            ->count();
        $distirctId = M_SubDistrict::where('district_id',$id_zona)
            ->where('is_active', 1)
            ->pluck('id');

        $sum_village = M_Village::whereIn('subdistrict_id',$distirctId)
            ->where('is_active', 1)
            ->count();

        // return $answer;
        $sent = [
            'zona' => $zona,
            'category' => $category,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'subdistrict' => $subdistrict,
            'forumKec' => $forumKec,
            'activity' => $activity,
            'forumKel' => $forumKel,
            'date' => $date,
            'sum_village' => $sum_village,
            'sum_subdistrict' => $sum_subdistrict,

        ];

        return view('verifikator_provinsi.kelembagaan.show', $sent);
    }

    public function storeKelembagaan(Request $request, $id_zona, $id)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_option' => 'required',
            'comment_prov' => 'required',
        ],[
            'id_option.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',
        ]);

        // return $request->answer_prov;
        // return $request->comment_prov;


        try {
            $relatedAnswer = Trans_Kelembagaan_V2::where('id_q_kelembagaan', $id)
                // ->where('id_zona',$id_zona)
                // ->first();
                ->where('id_zona',$id_zona)
                ->where('id_survey', $request->id_survey)
                ->first();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'id_opt_kelembagaan_prov' => $request->id_option,
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

    public function storeActivity(Request $request, $id)
    {

        $request->validate([
            'comment_prov' => 'required',
            'answer_prov' => 'required',
        ],[
            'answer_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',

        ]);

        try {
            $relatedAnswer = Trans_Kegiatan::find($id);
            // return $relatedAnswer;
            $user = Auth::user();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'answer_prov' => $request->answer_prov,
                    'comment_prov' => $request->comment_prov,
                    'updated_by_prov' => $user->id

                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi data');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function storeSKKec(Request $request, $id)
    {

        $request->validate([
            'comment_prov' => 'required',
            'answer_prov' => 'required',
        ],[
            'comment_prov.required' => 'Option wajib diisi',
            'answer_prov.required' => 'Komentar wajib diisi',

        ]);

        try {
            $relatedAnswer = Trans_Forum_Kec::find($id);
            $user = Auth::user();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'comment_prov' => $request->comment_prov,
                    'answer_prov' => $request->answer_prov,
                    'updated_by_prov' => $user->id

                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi data');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //pokja

    public function showPokjaDesa($idCKelembagaan, $idSubdistrict)
    {
        $session_date = Session::get('selected_year');
        $category = M_C_Kelembagaan_New::find($idCKelembagaan);
        $subdistrict = M_SubDistrict::find($idSubdistrict);
        $village = M_Village::where('subdistrict_id', $idSubdistrict)
        ->where('is_active',1)
        ->get();


        $forumKel = Trans_Forum_Kel::where('id_zona', $subdistrict->district_id)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $category->id)
            ->get();

        $activity = Trans_Kegiatan::where('id_zona', $subdistrict->district_id)
            ->where('id_survey', $session_date)
            ->where('id_c_kelembagaan', $category->id)
            ->get();
        $sent = [
            'category' => $category,
            'subdistrict' => $subdistrict,
            'village' => $village,
            'forumKel' => $forumKel,
            'activity' => $activity
        ];


        // return $sent;
        return view('verifikator_provinsi.kelembagaan.show_pokja', $sent);

    }

    public function storeSKPokja(Request $request, $id)
    {

        $request->validate([
            'comment_prov' => 'required',
            'answer_prov' => 'required',
        ],[
            'answer_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',

        ]);

        try {
            $relatedAnswer = Trans_Forum_Kel::find($id);
            // return $relatedAnswer;
            $user = Auth::user();

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'answer_prov' => $request->answer_prov,
                    'comment_prov' => $request->comment_prov,
                    'updated_by_prov' => $user->id

                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi data');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    //new

    public function indexGData($id){
        $session_date = Session::get('selected_year');
        $zona = M_District::find($id);
        // return $zona;
        $category = Gambaran_KabKota::where('id_survey', $session_date)->get();
        $doc = Trans_Gambaran_Kabkota::where('id_zona', $zona->id)
            ->where('id_survey', $session_date)
            ->get();

        $sent = [
            'zona' => $zona,
            'category' => $category,
            'doc' => $doc
        ];
        return view('verifikator_provinsi.g_data.index', $sent);
    }

    public function storeGData(Request $request, $id)
    {
        $request->validate([
            'comment_prov' => 'required',
            'is_prov' => 'required',
        ],[
            'is_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',
        ]);

        $user = Auth::user();

        try {
            $relatedAnswer = Trans_Gambaran_Kabkota::find($id);
            // return $relatedAnswer;

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'is_prov' => $request->is_prov,
                    'comment_prov' => $request->comment_prov,
                    'updated_by_prov' => $user->id

                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi gambaran umum');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //pendanaan
    public function indexPendanaan($id)
    {
        $session_date = Session::get('selected_year');
        $zona = M_District::find($id);
        // return $zona;
        $category = Pendanaan_KabKota::where('id_survey', $session_date)->get();
        $doc = Trans_Pendanaan_kabkota::where('id_zona', $zona->id)
            ->where('id_survey', $session_date)
            ->get();

        $sent = [
            'zona' => $zona,
            'category' => $category,
            'doc' => $doc
        ];
        return view('verifikator_provinsi.pendanaan.index', $sent);
    }

    public function storePendanaan(Request $request, $id)
    {
        $request->validate([
            'comment_prov' => 'required',
            'is_prov' => 'required',
        ],[
            'is_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',
        ]);

        $user = Auth::user();
        // return $user;

        try {
            $relatedAnswer = Trans_Pendanaan_kabkota::find($id);
            // return $relatedAnswer;

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'is_prov' => $request->is_prov,
                    'comment_prov' => $request->comment_prov,
                    'updated_by_prov' => $user->id
                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi pendanaan kabkota');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    //narasi tatanan
    public function indexNarasi($id)
    {
        $session_date = Session::get('selected_year');
        $zona = M_District::find($id);
        // return $zona;
        $category = M_Category::where('id_survey', $session_date)->get();
        $doc = Trans_Narasi::where('id_zona', $zona->id)
            ->where('id_survey', $session_date)
            ->get();

        $sent = [
            'zona' => $zona,
            'category' => $category,
            'doc' => $doc
        ];
        return view('verifikator_provinsi.narasi.index', $sent);
    }

    public function storeNarasi(Request $request, $id)
    {
        $request->validate([
            'comment_prov' => 'required',
            'is_prov' => 'required',
        ],[
            'is_prov.required' => 'Option wajib diisi',
            'comment_prov.required' => 'Komentar wajib diisi',
        ]);

        $user = Auth::user();

        try {
            $relatedAnswer = Trans_Narasi::find($id);
            // return $relatedAnswer;

            if($relatedAnswer)
            {
                $relatedAnswer->update([
                    'is_prov' => $request->is_prov,
                    'comment_prov' => $request->comment_prov,
                    'updated_by_prov' => $user->id
                ]);
                return redirect()->back()->with('success', 'Berhasil memverifikasi pendanaan kabkota');

            }
            else{
                return redirect()->back()->with('error', 'Data belum diinputkan kabupaten kota');
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function indexOdf(){
        $session_date = Session::get('selected_year');
        $zona = M_District::where('province_id',13)->get();
        $odf = Trans_ODF_New::where('id_survey',$session_date)
            ->get();
        $sent = [
            'zona' => $zona,
            'odf' => $odf
        ];
        return view('verifikator_provinsi.odf.index', $sent);


    }

    public function indexRekap(){
        $session_date = Session::get('selected_year');
        $answers = M_District::where('province_id', 13)
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
            ->get();

        $sent = [
            'zona' => $answers,
        ];
        return view('verifikator_provinsi.rekap.index', $sent);

        // return $sent;
    }

    public function indexRekapv2(){
        $session_date = Session::get('selected_year');
        $answers = M_District::where('province_id', 13)
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
            ->get();

        $sent = [
            'zona' => $answers,
        ];
        return view('admin.rekap.index', $sent);

        // return $sent;
    }

    public function printAllCategory(Request $request){
        $request->validate([
            'pembahas' => 'required',
            'jabatan' => 'required',
            'operator' => 'required',
            'tahun' => 'required',
            'kota' => 'required'
        ]);

        $pembahas = $request->pembahas;
        $operator = $request->operator;
        $jabatan = $request->jabatan;


        $trans_survey = Trans_Survey::find($request->tahun);

        $district = M_District::find($request->kota);
        $categories = M_Category::where('id_survey',$request->tahun)->get();
        $questions = M_Questions::where('id_survey', $request->tahun)    
            ->get();
        $answer = Trans_Survey_D_Answer::where('id_zona',$request->kota)
            ->where('id_survey', $request->tahun)
            ->get();

        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$request->kota)
            ->where('id_survey', $request->tahun)
            ->get();
        
        $sent = [
            'categories' => $categories,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'idZona' => $request->kota,
            'session_date' =>$request->tahun,
            'district' => $district,
            'trans_survey' => $trans_survey,
            'pembahas' => $pembahas,
            'operator' => $operator,
            'jabatan' => $jabatan

        ];
        return view('verifikator_provinsi.export.export_all_tatanan', $sent);

        // $htmlContent = view('verifikator_provinsi.export.export_all_tatanan', $sent)->render();

        // $pdf = PDF::loadHTML($htmlContent)
        //     ->setPaper('a4', 'landscape')
        //     ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
       
        
        // return $pdf->download("Tatanan {$district->name} Tahun {$trans_survey->trans_date}.pdf");
        
    }

    public function printPerCategory(Request $request){
        $request->validate([
            'pembahas' => 'required',
            'jabatan' => 'required',
            'operator' => 'required',
            'tahun' => 'required',
            'kota' => 'required'
        ]);

        $pembahas = $request->pembahas;
        $operator = $request->operator;
        $jabatan = $request->jabatan;
        $tahun = $request->tahun;
        $kota = $request->kota;
        $id_category = $request->idCategory;

        $date = Trans_Survey::find($tahun);
        $category = M_Category::find($id_category);
        $district = M_District::find($kota);

        $questions = M_Questions::where('id_category', $id_category)
            ->where('id_survey', $tahun)    
            ->get();

        $answer = Trans_Survey_D_Answer::where('id_zona',$kota)
            ->where('id_survey', $tahun)
            ->get();

        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$kota)
            ->where('id_survey', $tahun)
            ->get();
        
        $sent = [
            
            'pembahas' => $pembahas,
            'operator' => $operator,
            'jabatan' => $jabatan,
            'date' => $date,
            'idZona' => $kota,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'category' => $category,
            'district' => $district
        ];
        return view('verifikator_provinsi.export.export_pertatanan', $sent);

        // $htmlContent = view('verifikator_provinsi.export.export_all_tatanan', $sent)->render();

        // $pdf = PDF::loadHTML($htmlContent)
        //     ->setPaper('a4', 'landscape')
        //     ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
       
        
        // return $pdf->download("Tatanan {$district->name} Tahun {$trans_survey->trans_date}.pdf");
        
    }

    public function printAllKelembagaan(Request $request){
        $request->validate([
            'pembahas' => 'required',
            'jabatan' => 'required',
            'operator' => 'required',
            'tahun' => 'required',
            'kota' => 'required'
        ]);

        $pembahas = $request->pembahas;
        $operator = $request->operator;
        $jabatan = $request->jabatan;
        $kota = $request->kota;
        $tahun = $request->tahun;


        $district = M_District::find($kota);
        $date = Trans_Survey::find($tahun);
        $categories = M_C_Kelembagaan_New::where('id_survey', $tahun)->get();
        $questions = M_Q_Kelembagaan_New::where('id_survey', $tahun)
            ->get();
        $answer = Trans_Kelembagaan_V2::where('id_zona',$kota)
            ->where('id_survey', $tahun)
            ->get();
        $uploadedFiles = Trans_Doc_Kelembagaan::where('id_zona',$kota)
            ->where('id_survey', $tahun)
            ->get();
        // return $uploadedFiles;
       
        
        $sent = [
           
            'pembahas' => $pembahas,
            'operator' => $operator,
            'jabatan' => $jabatan,
            'district' => $district,
            'date' => $date,
            'categories' => $categories,
            'questions' => $questions,
            'answer'=> $answer,
            'uploadedFiles' => $uploadedFiles


        ];
        return view('verifikator_provinsi.export.export_kelembagaan', $sent);

        // $htmlContent = view('verifikator_provinsi.export.export_all_tatanan', $sent)->render();

        // $pdf = PDF::loadHTML($htmlContent)
        //     ->setPaper('a4', 'landscape')
        //     ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
       
        
        // return $pdf->download("Tatanan {$district->name} Tahun {$trans_survey->trans_date}.pdf");
        
    }



}
