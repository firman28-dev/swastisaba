<?php

namespace App\Http\Controllers;

use App\Models\Doc_Question;
use App\Models\M_Category;
use App\Models\M_Questions;
use App\Models\Trans_Upload_KabKota;
use Illuminate\Http\Request;
use Session;

class Doc_Question_Controller extends Controller
{
    public function index($id)
    {
        $session_date = Session::get('selected_year');
        $question = M_Questions::find($id);
        $doc_question = Doc_Question::select('doc_question.*','m_questions.name as name_question')
        ->leftJoin('m_questions', 'doc_question.id_question', '=', 'm_questions.id')
        ->where('doc_question.id_question',$id)
        ->where('doc_question.id_survey', $session_date)
        ->get();

        $sent = [
            'question' => $question,
            'doc_question' => $doc_question
        ];

        return view("admin.doc_question.index", $sent);

    }

    public function create($id)
    {
        $questions = M_Questions::find($id);
        return view('admin.doc_question.create', compact('questions'));   
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_question' => 'required',
            'name.*' => 'required',
            'name' => 'required|array',
            'ket.*' => 'required',
            'ket' => 'required|array',
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'id_question.required' => 'Pertanyaan tidak boleh kosong',
            'name.required' => 'Nama data dukung tidak boleh kosong',
            'ket.required' => 'Keteranagn data dukung tidak boleh kosong'
        ]);

        $name = $request->name;
        $id_survey = $request->id_survey;
        $id_question = $request->id_question;

        $result = [];
        foreach ($name as $key=>$name_option) {
            $result[] = [
                'name' => $name_option,
                'ket' => $name_option,
                'id_question' => $id_question,
                'id_survey' => $id_survey
            ];
        }

        try {
            foreach ($result as $data) {
                $q_opt = new Doc_Question();
                $q_opt->id_survey = $data['id_survey'];
                $q_opt->id_question = $data['id_question'];
                $q_opt->name = $data['name'];
                $q_opt->save();
            }
            

            return redirect()->route('doc-question.index', $id_question)->with('success', 'Berhasil Menambahkan data dukung pertanyaan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data dukung pertanyaan. Silahkan coba lagi')->withInput();
        }

    }

    public function edit($id)
    {
        $doc = Doc_Question::find($id);

        return view('admin.doc_question.edit' , compact('doc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_question' => 'required',
            'name' => 'required',
            'ket' => 'required',
        ],[
            'name.required' => 'Data dukung tidak boleh kosong',
            'ket.required' => 'Keterangan data dukung tidak boleh kosong',
            'id_question' => 'Pertanyaan tidak boleh kosong'
        ]);

        try{
            $doc = Doc_Question::find($id);
            $doc->id_question = $request->id_question;
            $doc->name = $request->name;
            $doc->ket = $request->ket;

            // return $doc;

            $doc->save();
            return redirect()->route('doc-question.index', $doc->id_question)->with('success', 'Berhasil mengubah data dukung pertanyaan');
        }
        catch(\Exception $e){
            return back()->with('error', 'Gagal mengubah data dukung pertanyaan. Silahkan coba lagi')->withInput();

        }
    }

    public function destroy($id)
    {
        $doc = Doc_Question::find($id);
        $trans_doc = Trans_Upload_KabKota::where('id_doc_question', $doc->id)->get();

        if($doc){
            if($trans_doc->isNotEmpty()){
                $trans_doc->each->delete();
            }
            $doc->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data dukung pertanyaan dan transaksinya');
        }
        else {
            return redirect()->back()->with('error', 'Gagal menghapus data. Dokumen tidak ditemukan');
        }
    }

    public function onlyTrashed(){
        $trashedData = Doc_Question::onlyTrashed()->get();
        return view('admin.trashed.doc_question.trash',compact('trashedData'));
    }

    public function restore($id){
        $category = Doc_Question::withTrashed()->find($id);
        if($category){
            $category->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data dokumen pendukung pertanyaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data');
        }
    }

    public function forceDelete($id){
        $category = Doc_Question::withTrashed()->find($id);
        if($category){
            $category->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data');
        }
    }

    public function import($id)
    {
        $category = M_Category::find($id);
        return view('admin.doc_question.import', compact('category'));
    }

    public function importDocQ(Request $request, $id)
    {
        $request->validate([
            'id_survey' => 'required',
            'file' => 'required',
        ], [
            'id_survey.required' => 'Tahun wajib diisi',
            'file.required' => 'File wajib diisi',
        ]);

        $file = $request->file('file');
        $id_survey = $request->input('id_survey');

        try {
            if($file){
                $ldate = date("YmdHis");
                $filename = $ldate . "_" . $file->getClientOriginalName();
                $location = "uploads";
                $file->move($location, $filename);
                $filepath = public_path($location . "/" . $filename);
                $filepath2 = public_path($location . "/" . $filename);
                $file = fopen($filepath, "r");
                $file2 = fopen($filepath2, "r");
                $fileContents = fread($file2, filesize($filepath2));
                $importData_arr = array();
                $i = 0;
    
                if (strpos($fileContents, ";") !== false) {
                    $delimiter = ";";
                } else {
                    $delimiter = ",";
                }
    
                while (($filedata = fgetcsv($file, 1000, $delimiter)) !== FALSE) {
                    $num = count($filedata);
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
    
                $d = [];
                foreach ($importData_arr as $importData) {
                    $data = $importData;
                    $d[] = $data;
                }
    
                for ($i = 1; $i < count($d); $i++) {
                    
                    $u = new Doc_Question();
                    $u->id_question = $d[$i][0];
                    $u->name = $d[$i][1];
                    $u->ket = $d[$i][2];
                    $u->id_survey = $id_survey;

                    $u->save();
                }
                return redirect()->route('showQuestionV2', $id)->with('success', 'Berhasil Menambahkan data pertanyaan');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

}
