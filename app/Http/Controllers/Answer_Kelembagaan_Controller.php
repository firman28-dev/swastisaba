<?php

namespace App\Http\Controllers;

use App\Models\M_Category_Kelembagaan;
use App\Models\M_Question_Kelembagaan;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Kelembagaan_H;
use Auth;
use Illuminate\Http\Request;
use Session;

class Answer_Kelembagaan_Controller extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $idZona = $user->id_zona;
        $session_date = Session::get('selected_year');

        $category = M_Category_Kelembagaan::find($id);
        $q_kelembagaan = M_Question_Kelembagaan::where('id_c_kelembagaan',$category->id)->get();
        $answer = Trans_Kelembagaan_H::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();
        $doc = Trans_Doc_Kelembagaan::where('id_zona', $idZona)
            ->where('id_survey', $session_date)
            ->get();

        $sent =[
            'category' => $category,
            'q_kelembagaan' => $q_kelembagaan,
            'answer' => $answer,
            'doc' => $doc
        ];
        // return $q_kelembagaan;
        return view('operator_kabkota.kelembagaan.index', $sent);
    }

    public function storeDoc(Request $request, $idQKelembagaan)
    {
        $request->validate([
            'id_survey' => 'required',
            'path' => 'required|mimes:pdf|max:2048',
        ],[
            'id_survey.required' => 'Tahun wajib disetting',
            'path.required' => 'Field wajib diisi',
            'path.mimes' => 'Dokumen wajib berupa pdf',
            'path.max' => 'Dokumen maksimal berukuran 2 MB'
        ]);

        $user = Auth::user();
        $idZona = $user->id_zona;
        // return $docId;
        $file = $request->file('path'); 
        $fileName = $idZona. '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/doc_kelembagaan/'), $fileName);

        try {
            $uploadPdf = new Trans_Doc_Kelembagaan();
            $uploadPdf->id_survey = $request->id_survey;
            $uploadPdf->id_zona = $idZona;
            $uploadPdf->id_q_kelembagaan = intval($idQKelembagaan);
            $uploadPdf->path = $fileName;
            $uploadPdf->save();
            return redirect()->back()->with('success', 'Berhasil mengubah dokumen kelembagaan');
            
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with('error', 'Gagal menambahkan dokumen kelembagaan. Silahkan coba lagi');
        }
    }

    public function destroyDoc($id)
    {
        $doc = Trans_Doc_Kelembagaan::find($id);
        if (file_exists(public_path('uploads/doc_kelembagaan/'.$doc->path))) {
            unlink(public_path('uploads/doc_kelembagaan/'.$doc->path));
        }
        $doc->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus dokumen kelembagaan');
    }

    public function store(Request $request, $idQKelembagaan)
    {
        $request->validate([
            'answer' => 'required',
            'id_survey' => 'required'
        ],[
            'answer.required' => 'Option wajib diisi',
            'id_survey.required' => 'Tahun wajib disetting'
        ]);

        $user = Auth::user();
        $idZona = $user->id_zona;
        // return $idZona;

        try {
            $answer = new Trans_Kelembagaan_H();
            $answer->id_survey = $request->input('id_survey');
            $answer->answer = $request->input('answer');
            $answer->id_zona = $idZona;
            // return $answer;

            $answer->id_q_kelembagaan = intval($idQKelembagaan);
            $answer->save();
            return redirect()->back()->with('success', 'Berhasil menjawab pertanyaan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required',
        ],[
            'answer.required' => 'Option wajib diisi',
        ]);

        $user = Auth::user();
        $idZona = $user->id_zona;
        // return $idZona;

        try {
            $answer = Trans_Kelembagaan_H::findOrFail($id);
            $answer->answer = $request->input('answer');
            $answer->save();
            return redirect()->back()->with('success', 'Berhasil memperbarui jawaban');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
