<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_Question_Option;
use App\Models\M_Questions;
use App\Models\Trans_Survey_D_Answer;
use Illuminate\Http\Request;
use Session;

class M_Question_Option_Controller extends Controller
{
   
    public function index()
    {
        $session_date = Session::get('selected_year');
        $category = M_Category::where('id_survey', $session_date)->get();
        return view('admin.q_option.index', compact('category'));
    }

    public function showQuestion($id)
    {   
        $session_date = Session::get('selected_year');
        $category = M_Category::find($id);
        $questions = M_Questions::select('m_questions.*','m_category.name as name_category')
            ->leftJoin('m_category', 'm_questions.id_category', '=', 'm_category.id')
            ->where('m_questions.id_category',$id)
            ->where('m_questions.id_survey', $session_date)
            ->get();
        $sent = [
            'category' => $category,
            'questions' => $questions
        ];
        return view("admin.q_option.index_v2_q_option", $sent);
    }

    public function showQuestionOpt($id)
    {   
        $session_date = Session::get('selected_year');
        $question = M_Questions::find($id);
        $q_option = M_Question_Option::select('m_question_options.*','m_questions.name as name_question')
            ->leftJoin('m_questions', 'm_question_options.id_question', '=', 'm_questions.id')
            ->where('m_question_options.id_question',$id)
            ->where('m_question_options.id_survey', $session_date)
            ->get();
        $sent = [
            'question' => $question,
            'q_option' => $q_option
        ];
        return view("admin.q_option.index_v3_q_option", $sent);
    }
    // public function index()
    // {
    //     $q_option = M_Question_Option::all();
    //     return view('admin.q_option.index', compact('q_option'));
    // }

    
    public function create($id)
    {
        $questions = M_Questions::find($id);
        return view('admin.q_option.create', compact('questions'));   
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_question' => 'required',
            'name.*' => 'required',
            'score.*' => 'required',
            'name' => 'required|array',
            'score' => 'required|array',
        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'id_question.required' => 'Pertanyaan tidak boleh kosong',
            'score.required' => 'Nilai tidak boleh kosong',
            'name.required' => 'Opsi pertanyaan tidak boleh kosong'
        ]);

        $name = $request->name;
        $id_survey = $request->id_survey;
        // return $name;
        $score = $request->score;
        $id_question = $request->id_question;

        $nameArray = explode(',', $name[0]);
        $scoreArray = explode(',', $request->score[0]);


        $result = [];
        foreach ($name as $key => $name_option) {
            $result[] = [
                'name' => $name_option,
                'score' => $score[$key],
                'id_question' => $id_question,
                'id_survey' => $id_survey
            ];
        }


        try {
            foreach ($result as $data) {
                $q_opt = new M_Question_Option();
                $q_opt->id_survey = $data['id_survey'];
                $q_opt->id_question = $data['id_question'];
                $q_opt->name = $data['name'];
                $q_opt->score = $data['score'];
                $q_opt->save();
            }
            

            return redirect()->route('showQuestionOpt', $id_question)->with('success', 'Berhasil Menambahkan data opsi pertanyaan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data opsi pertanyaan. Silahkan coba lagi')->withInput();
        }
        // return $result;

    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $q_option = M_Question_Option::find($id);
        // return $q_option;
        return view('admin.q_option.edit', compact('q_option'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_question' => 'required',
            'name' => 'required',
            'score' => 'required',
        ]);

        try{
            $q_option = M_Question_Option::find($id);
            $q_option->id_question = $request->id_question;
            $q_option->name = $request->name;
            $q_option->score = $request->score;

            $q_option->save();
            return redirect()->route('showQuestionOpt', $q_option->id_question)->with('success', 'Berhasil mengubah data opsi pertanyaan');
        }
        catch(\Exception $e){
            return back()->with('error', 'Gagal mengubah data opsi Pertanyaan. Silahkan coba lagi')->withInput();

        }
    }

   
    public function destroy($id)
    {
        $q_opt = M_Question_Option::find($id);
        $trans_q_option = Trans_Survey_D_Answer::where('id_option', $q_opt->id)->get();
        if($q_opt){
            if ($trans_q_option->isNotEmpty()) {
                $trans_q_option->each->delete();
            }
            $q_opt->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data opsi pertanyaan');

        }
        else {
            return redirect()->back()->with('error', 'Gagal menghapus data opsi pertanyaan');
        }
        

        // return $trans_q_option;
        // if($q_opt && !$trans_q_option){
        //     $q_opt->delete();
        //     return redirect()->back()->with('success', 'Berhasil menghapus data opsi pertanyaan');
        // }
        // else{
        //     return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan jawaban kab/kota');
        // }
    }

    public function onlyTrashed(){
        $trashedData = M_Question_Option::onlyTrashed()->get();
        return view('admin.trashed.q_option.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Question_Option::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data opsi pertanyaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data opsi pertanyaan');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Question_Option::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data opsi pertanyaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data opsi pertanyaan');
        }
    }

    public function import($id)
    {
        $category = M_Category::find($id);
        return view('admin.q_option.import', compact('category'));
    }

    public function importQOption(Request $request, $id)
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
                    
                    $u = new M_Question_Option();
                    $u->id_question = $d[$i][0];
                    $u->name = $d[$i][2];
                    $u->score = $d[$i][3];
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
