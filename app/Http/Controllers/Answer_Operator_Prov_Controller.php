<?php

namespace App\Http\Controllers;

use App\Models\Gambaran_Prov;
use App\Models\M_Category;
use App\Models\M_District;
use App\Models\M_Questions;
use App\Models\Pendanaan_Prov;
use App\Models\Trans_Forum_KabKota;
use App\Models\Trans_Gambaran_Prov;
use App\Models\Trans_ODF;
use App\Models\Trans_Pembina_KabKota;
use App\Models\Trans_Survey_D_Answer;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Operator_Prov_Controller extends Controller
{
    public function indexGambaran(){
        $session_date = Session::get('selected_year');
        $gambaran = Gambaran_Prov::where('id_survey', $session_date)->get();
        $answer_doc = Trans_Gambaran_Prov::where('id_survey', $session_date)->get();

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

        $sent = [
            'gambaran' => $gambaran,
            'answer_doc' => $answer_doc,
            'district' => $district,
            'category' => $category,
            'odf' => $odf,
            'answer' => $answer,
            'question' => $question,
            'pembina' => $pembina,
            'forum_kabkota' => $forum_kabkota
        ];

        return view('operator_provinsi.gambaran.index', $sent);
    }   

    public function storeGambaran(Request $request, $id){
        $session_date = Session::get('selected_year');
        $gambaran = Gambaran_Prov::find($id);
        $user = Auth::user();

        $request->validate([
            'path' => 'required|mimes:pdf|max:2048',
        ],[
            'path.required' => 'Field wajib diisi',
            'path.mimes' => 'Dokumen wajib berupa pdf',
            'path.max' => 'Dokumen maksimal berukuran 2 MB'
        ]);   

        $file = $request->file('path'); 
        try {
            $fileName = $user->id. '_Gambaran_' . $file->getClientOriginalName();
            $file->move($_SERVER['DOCUMENT_ROOT'].'/uploads/doc_prov/', $fileName);
            $uploadedFile = new Trans_Gambaran_Prov();

            $uploadedFile->id_survey = $session_date;
            $uploadedFile->id_gambaran_prov = $id;
            $uploadedFile->path = $fileName;
            $uploadedFile->created_by = $user->id;
            $uploadedFile->save();
            return redirect()->back()->with('success', 'Berhasil menambahkan dokumen');



        } catch (\Throwable $th) {
            throw $th;
        }
        




    }

    public function destroyGambaran($id){
        $file = Trans_Gambaran_Prov::findOrFail($id);
        $oldFilePath = $_SERVER['DOCUMENT_ROOT']. '/uploads/docProv/' .$file->path;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $file->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus dokumen');

    }

    public function indexPendanaan()
    {
        $session_date = Session::get('selected_year');
        $pendanaan = Pendanaan_Prov::where('id_survey', $session_date)->get();

        // $answer_doc = ::where('id_survey', $session_date)->get();


    }
}
