<?php

namespace App\Http\Controllers;

use App\Models\M_Category_Kelembagaan;
use App\Models\M_Question_Kelembagaan;
use App\Models\Trans_Kelembagaan_H;
use Illuminate\Http\Request;
use Session;

class M_Question_Kelembagaan_Controller extends Controller
{
    public function index()
    {
        $session_date = Session::get('selected_year');
        $c_kelembagaan = M_Category_Kelembagaan::where('id_survey', $session_date)->get();
        return view('admin.q_kelembagaan.index', compact('c_kelembagaan'));
    }

    public function showQKelembagaan($id){
        $session_date = Session::get('selected_year');
        $c_kelembagaan = M_Category_Kelembagaan::find($id);
        $q_kelembagaan = M_Question_Kelembagaan::select('m_question_kelembagaan.*','m_category_kelembagaan.name as name_c_kelembagaan')
            ->leftJoin('m_category_kelembagaan', 'm_question_kelembagaan.id_c_kelembagaan', '=', 'm_category_kelembagaan.id')
            ->where('m_question_kelembagaan.id_c_kelembagaan',$id)
            ->where('m_question_kelembagaan.id_survey',$session_date)
            ->get();
        $sent = [
            'c_kelembagaan' => $c_kelembagaan,
            'q_kelembagaan' => $q_kelembagaan
        ];
        return view("admin.q_kelembagaan.index_v2", $sent);
    }

    
    public function create($id)
    {
        $c_kelembagaan = M_Category_Kelembagaan::find($id);
        return view('admin.q_kelembagaan.create', compact('c_kelembagaan'));   

    }

    public function store(Request $request)
    {
        $request->validate([
            'id_c_kelembagaan' => 'required',
            'question.*' => 'required',
            'opsi.*' => 'required',
            'question' => 'required|array',
            'opsi' => 'required|array',
        ]);

        $question = $request->question;
        // return $name;
        $opsi = $request->opsi;
        $id_c_kelembagaan = $request->id_c_kelembagaan;

        $result = [];
        foreach ($question as $key => $name_option) {
            $result[] = [
                'question' => $name_option,
                'opsi' => $opsi[$key],
                'id_c_kelembagaan' => $id_c_kelembagaan,
            ];
        }

        // return $result;



        try {
            foreach ($result as $data) {
                $q_kelembagaan = new M_Question_Kelembagaan();
                $q_kelembagaan->id_c_kelembagaan = $data['id_c_kelembagaan'];
                $q_kelembagaan->question = $data['question'];
                $q_kelembagaan->opsi = $data['opsi'];
                $q_kelembagaan->save();
            }
            

            return redirect()->route('showQKelembagaan', $id_c_kelembagaan)->with('success', 'Berhasil Menambahkan data pertanyaan kelembagaan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data pertanyaan kelembagaan. Silahkan coba lagi')->withInput();
        }
        // return $result;
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $q_kelembagaan = M_Question_Kelembagaan::find($id);
        // return $q_kelembagaan;
        return view('admin.q_kelembagaan.edit', compact('q_kelembagaan'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_c_kelembagaan' => 'required',
            'question' => 'required',
            'opsi' => 'required',

        ]);

        try{
            $q_kelembagaan = M_Question_Kelembagaan::find($id);
            $q_kelembagaan->id_c_kelembagaan = $request->id_c_kelembagaan;
            $q_kelembagaan->question = $request->question;
            $q_kelembagaan->opsi = $request->opsi;

            $q_kelembagaan->save();
            return redirect()->route('showQKelembagaan',$q_kelembagaan->id_c_kelembagaan)->with('success', 'Berhasil mengubah data pertanyaan kelembagaan');
        }
        catch(\Exception $e){
            return back()->with('error', 'Gagal mengubah data Pertanyaan Kelembagaan. Silahkan coba lagi')->withInput();

        }
    }

    public function destroy($id)
    {
        $q_kelembagaan = M_Question_Kelembagaan::find($id);
        $ans_kelembagaan = Trans_Kelembagaan_H::where('id_q_kelembagaan', $q_kelembagaan->id)->get();
        
        if($q_kelembagaan && $ans_kelembagaan->isEmpty()){
            $q_kelembagaan->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data pertanyaan kelembagaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan jawaban kab/kota');
        }
    }

    public function onlyTrashed(){
        $trashedData = M_Question_Kelembagaan::onlyTrashed()->get();
        return view('admin.trashed.q_kelembagaan.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Question_Kelembagaan::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data pertanyaan kelembagaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data pertanyaan kelembagaan');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Question_Kelembagaan::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data pertanyaan kelembagaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data pertanyaan kelembagaan');
        }
    }
}
