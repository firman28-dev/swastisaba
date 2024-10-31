<?php

namespace App\Http\Controllers;

use App\Models\M_C_Kelembagaan_New;
use App\Models\M_Category_Kelembagaan;
use App\Models\M_Q_Kelembagaan_New;
use App\Models\M_Q_O_Kelembagaan_New;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Kelembagaan_V2;
use Illuminate\Http\Request;
use Session;

class M_Q_Kelembagaan_New_Controller extends Controller
{
    public function index()
    {
        $session_date = Session::get('selected_year');
        $c_kelembagaan_v2 = M_C_Kelembagaan_New::where('id_survey', $session_date)->get();
        // return $c_kelembagaan_v2;
        return view('admin.q_kelembagaan_v2.index', compact('c_kelembagaan_v2'));
    }

    public function showQKelembagaanNew($id){
        $session_date = Session::get('selected_year');
        $c_kelembagaan_v2 = M_C_Kelembagaan_New::find($id);
        $q_kelembagaan_v2 = M_Q_Kelembagaan_New::select('m_question_kelembagaan_new.*','m_category_kelembagaan_new.name as name_c_kelembagaan')
            ->leftJoin('m_category_kelembagaan_new', 'm_question_kelembagaan_new.id_c_kelembagaan_v2', '=', 'm_category_kelembagaan_new.id')
            ->where('m_question_kelembagaan_new.id_c_kelembagaan_v2',$id)
            ->where('m_question_kelembagaan_new.id_survey',$session_date)
            ->get();
        $sent = [
            'c_kelembagaan_v2' => $c_kelembagaan_v2,
            'q_kelembagaan_v2' => $q_kelembagaan_v2
        ];
        // return $sent;
        return view("admin.q_kelembagaan_v2.index_v2", $sent);
    }

    public function create($id)
    {
        $c_kelembagaan_v2 = M_C_Kelembagaan_New::find($id);
        return view('admin.q_kelembagaan_v2.create', compact('c_kelembagaan_v2'));   

    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_c_kelembagaan_v2' => 'required',
            'indikator.*' => 'required',
            'd_operational.*' => 'required',
            's_data.*' => 'required',
            'data_dukung.*' => 'required',

            'indikator' => 'required|array', 
            'd_operational' => 'required|array',
            's_data' => 'required|array', 
            'data_dukung' => 'required|array',
        ]);

        $indikator = $request->indikator;
        $d_operational = $request->d_operational;
        $s_data = $request->s_data;
        $data_dukung = $request->data_dukung;
        $id_survey = $request->id_survey;


        $id_c_kelembagaan_v2 = $request->id_c_kelembagaan_v2;

        $result = [];
        foreach ($indikator as $key => $indikator_name) {
            $result[] = [
                'indikator' => $indikator_name,
                'd_operational' => $d_operational[$key],
                's_data' => $s_data[$key],
                'data_dukung' => $data_dukung[$key],
                'id_c_kelembagaan_v2' => $id_c_kelembagaan_v2,
            ];
        }

        // return $result;



        try {
            foreach ($result as $data) {
                $q_kelembagaan = new M_Q_Kelembagaan_New();
                $q_kelembagaan->id_c_kelembagaan_v2 = $data['id_c_kelembagaan_v2'];
                $q_kelembagaan->id_survey = $id_survey;
                $q_kelembagaan->indikator = $data['indikator'];
                $q_kelembagaan->d_operational = $data['d_operational'];
                $q_kelembagaan->s_data = $data['s_data'];
                $q_kelembagaan->data_dukung = $data['data_dukung'];
                $q_kelembagaan->save();
            }
            

            return redirect()->route('showQKelembagaanNew', $id_c_kelembagaan_v2)->with('success', 'Berhasil Menambahkan data pertanyaan kelembagaan');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Gagal menambahkan data pertanyaan kelembagaan. Silahkan coba lagi')->withInput();
        }
        // return $result;
    }

    public function destroy($id)
    {
            $q_kelembagaan = M_Q_Kelembagaan_New::find($id);
            // return $q_kelembagaan;
            $q_opt = M_Q_O_Kelembagaan_New::whereIn('id_q_kelembagaan', $q_kelembagaan->pluck('id'))->get();
            $trans_doc = Trans_Doc_Kelembagaan::whereIn('id_q_kelembagaan', $q_kelembagaan->pluck('id'))->get();
            $trans_answer = Trans_Kelembagaan_V2::whereIn('id_opt_kelembagaan', $q_opt->pluck('id'))->get();
            
            if($q_kelembagaan){
                if($trans_answer->isNotEmpty()){
                    $trans_answer->each->delete();
                }
    
                if($trans_doc->isNotEmpty()){
                    $trans_doc->each->delete();
                }
    
                if($q_opt->isNotEmpty()){
                    $q_opt->each->delete();
                }
    
                
                $q_kelembagaan->delete();
    
                return redirect()->back()->with('success', 'Berhasil menghapus data beserta relasi ke bawahnya');
            }
            else{
                return redirect()->back()->with('error', 'Gagal menghapus data');
            }
    
    }
    
}
