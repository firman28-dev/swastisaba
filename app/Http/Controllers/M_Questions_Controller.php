<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_Question_Option;
use App\Models\M_Questions;
use Cache;
use DB;
use Illuminate\Http\Request;
use Session;

class M_Questions_Controller extends Controller
{
    
   
    public function index()
    {
        $session_date = Session::get('selected_year');
        $category = M_Category::where('id_survey', $session_date)->get();
        return view('admin.questions.index', compact('category'));
        // return view('admin.questions.index', compact('category'));
    }

    public function showQuestion($id){
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
        return view("admin.questions.index_v2_q", $sent);
    }

    public function showQuestion2($id){
        $session_date = Session::get('selected_year');
        $category = Cache::remember("category_{$id}_{$session_date}", 600, function () use ($id) {
            return M_Category::find($id);
        });
    
        // Cache questions data for the given category ID and session date
        $questions = Cache::remember("questions_{$id}_{$session_date}", 600, function () use ($id, $session_date) {
            return M_Questions::select('m_questions.*', 'm_category.name as name_category')
                ->leftJoin('m_category', 'm_questions.id_category', '=', 'm_category.id')
                ->where('m_questions.id_category', $id)
                ->where('m_questions.id_survey', $session_date)
                ->get();
        });
    
        $sent = [
            'category' => $category,
            'questions' => $questions,
        ];
        return view("admin.questions.index_v2_q", $sent);
    }
    

   
    public function createbyid($id)
    {
        $category = M_Category::find(id: $id);
        return view('admin.questions.create', compact('category'));
    }

    public function import($id)
    {
        $category = M_Category::find($id);
        return view('admin.questions.import', compact('category'));
    }

    public function importQuestion(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'file' => 'required',
            'id_category' => 'required',
        ], [
            'id_survey.required' => 'Tahun wajib diisi',
            'file.required' => 'File wajib diisi',
            // 'file.mimetypes' => 'Ekstensi harus .csv'
        ]);

        $file = $request->file('file');
        $category = $request->input('id_category');
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
                    $u = new M_Questions();
                    $u->name = $d[$i][0];
                    $u->s_data = $d[$i][1];
                    $u->d_operational = $d[$i][2];
                    $u->id_category = $category;
                    $u->id_survey = $id_survey;

                    $u->save();
                }
                return redirect()->route('showQuestionV1', $category)->with('success', 'Berhasil Menambahkan data pertanyaan');
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor file: ');
        }
        


        // $file = $request->file('file');
        // $category = $request->input('id_category');
        // $filePath = $file->getRealPath();

        // if (($handle = fopen($filePath, 'r')) !== false) {
        //     fgetcsv($handle);

        //     while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        //         DB::table('m_question')->insert([
        //             'name' => $data[0],  // ganti sesuai kolom CSV Anda
        //             's_data' => $data[1],  // ganti sesuai kolom CSV Anda
        //             'd_operational' => $data[2],
        //             'id_category' => $category,
        //         ]);
        //     }

        //     fclose($handle);
        // }
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'id_category' => 'required',
            'name' => 'required',
            's_data' => 'required',
            'd_operational' => 'required',

        ],[
            'id_survey.required' => 'Tahun tidak boleh kosong',
            'id_category.required' => 'Tatanan tidak boleh kosong',
            's_data.required' => 'Data Pendukung tidak boleh kosong',
            'd_operational.required' => 'Data Operasional tidak boleh kosong',
            'name.required' => 'Opsi pertanyaan tidak boleh kosong'
        ]);

        try{
            $questions = new M_Questions();
            $questions->id_survey = $request->id_survey;
            $questions->id_category = $request->id_category;
            $questions->name = $request->name;
            $questions->s_data = $request->s_data;
            $questions->d_operational = $request->d_operational;

            $questions->save();
            return redirect()->route('showQuestionV1', $questions->id_category)->with('success', 'Berhasil Menambahkan data kategori');
        }
        catch(\Exception $e){
            return back()->with('error', 'Gagal menambahkan data Pertanyaan. Silahkan coba lagi')->withInput();

        }
    }

    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $questions = M_Questions::find($id);
        // return $questions;
        return view('admin.questions.edit', compact('questions'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_category' => 'required',
            'name' => 'required',
            's_data' => 'required',
            'd_operational' => 'required',

        ]);

        try{
            $questions = M_Questions::find($id);
            $questions->id_category = $request->id_category;
            $questions->name = $request->name;
            $questions->s_data = $request->s_data;
            $questions->d_operational = $request->d_operational;

            $questions->save();
            return redirect()->route('showQuestionV1',$questions->id_category)->with('success', 'Berhasil mengubah data pertanyaan');
        }
        catch(\Exception $e){
            return back()->with('error', 'Gagal mengubah data Pertanyaan. Silahkan coba lagi')->withInput();

        }
    }

    
    public function destroy($id)
    {
        $question = M_Questions::find($id);
        $q_opt = M_Question_Option::where('id_question', $question->id)->first();

        if(!$q_opt && $question){
            $question->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data pertanyaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan data opsi pertanyaan');
        }

       
    }

    public function onlyTrashed(){
        $trashedData = M_Questions::onlyTrashed()->get();
        // return $trashedData
        return view('admin.trashed.questions.trash',compact('trashedData'));
    }

    public function restore($id){
        $restore = M_Questions::withTrashed()->find($id);
        if($restore){
            $restore->restore();
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data pertanyaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data pertanyaan');
        }
    }

    public function forceDelete($id){
        $forcedelete = M_Questions::withTrashed()->find($id);
        if($forcedelete){
            $forcedelete->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus permanen data pertanyaan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal menghapus permanen data pertanyaan');
        }
    }

}
