<?php

namespace App\Http\Controllers;

use App\Models\M_Q_Kelembagaan_New;
use App\Models\M_Q_O_Kelembagaan_New;
use Illuminate\Http\Request;
use Session;

class M_Q_O_Kelembagaan_New_Controller extends Controller
{
    public function index($id)
    {
        $session_date = Session::get('selected_year');
        $question_kelembagaan = M_Q_Kelembagaan_New::find($id);
        $q_option_kelembagaan = M_Q_O_Kelembagaan_New::select('m_q_option_kelembagaan.*','m_question_kelembagaan_new.indikator as name_indikator')
            ->leftJoin('m_question_kelembagaan_new', 'm_q_option_kelembagaan.id_q_kelembagaan', '=', 'm_question_kelembagaan_new.id')
            ->where('m_q_option_kelembagaan.id_q_kelembagaan',$id)
            ->where('m_q_option_kelembagaan.id_survey', $session_date)
            ->get();
        $sent = [
            'question_kelembagaan' => $question_kelembagaan,
            'q_option_kelembagaan' => $q_option_kelembagaan
        ];
        return view("admin.q_option_kelembagaan.index", $sent);
    }

    public function create($id)
    {
        $question_kelembagaan = M_Q_Kelembagaan_New::find($id);
        // return $question_kelembagaan;
        return view("admin.q_option_kelembagaan.create",  compact('question_kelembagaan'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_q_kelembagaan' => 'required',
            'name.*' => 'required',
            'score.*' => 'required',
            'name' => 'required|array',
            'score' => 'required|array',
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'id_q_kelembagaan.required' => 'Indikator tidak boleh kosong',
            'score.required' => 'Nilai tidak boleh kosong',
            'name.required' => 'Opsi jawaban tidak boleh kosong'
        ]);

        $name = $request->name;
        $id_survey = $request->id_survey;
        // return $name;
        $score = $request->score;
        $id_q_kelembagaan = $request->id_q_kelembagaan;

        $result = [];
        foreach ($name as $key => $name_option) {
            $result[] = [
                'name' => $name_option,
                'score' => $score[$key],
                'id_q_kelembagaan' => $id_q_kelembagaan,
                'id_survey' => $id_survey
            ];
        }


        try {
            foreach ($result as $data) {
                $q_opt = new M_Q_O_Kelembagaan_New();
                $q_opt->id_survey = $data['id_survey'];
                $q_opt->id_q_kelembagaan = $data['id_q_kelembagaan'];
                $q_opt->name = $data['name'];
                $q_opt->score = $data['score'];
                $q_opt->save();
            }
            

            return redirect()->route('q-opt-kelembagaan.index', $id_q_kelembagaan)->with('success', 'Berhasil Menambahkan data opsi jawaban');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Gagal menambahkan data opsi jawaban. Silahkan coba lagi')->withInput();
        }
        // return $result;

    }

    public function edit($id)
    {
        $q_option_kelembagaan = M_Q_O_Kelembagaan_New::find($id);
        // return $q_option;
        return view('admin.q_option_kelembagaan.edit', compact('q_option_kelembagaan'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'id_question' => 'required',
            'name' => 'required',
            'score' => 'required',
        ]);

        try{
            $q_option = M_Q_O_Kelembagaan_New::find($id);
            // $q_option->id_q_kelembagaan = $request->id_q_kelembagaan;
            $q_option->name = $request->name;
            $q_option->score = $request->score;

            $q_option->save();
            return redirect()->route('q-opt-kelembagaan.index', $q_option->id_q_kelembagaan)->with('success', 'Berhasil mengubah data opsi jawaban');
        }
        catch(\Exception $e){
            return back()->with('error', 'Gagal mengubah data opsi jawaban. Silahkan coba lagi')->withInput();

        }
    }

    public function destroy($id){

    }
}
