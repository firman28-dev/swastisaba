<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_Question_Option;
use App\Models\M_Questions;
use App\Models\Trans_Survey;
use App\Models\Trans_Survey_D_Answer;
use Illuminate\Http\Request;
use Session;

class M_Category_Controller extends Controller
{
    public function index(){
        $session_date = Session::get('selected_year');
        $category = M_Category::where('id_survey', $session_date)->get();
        return view('admin.category.index', compact('category'));
    }
    
    public function create()
    {
        
        return view("admin.category.create", );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
        ], [
            'name.required' => 'Nama tatanan wajib diisi',
            'id_survey.required' => 'Tahun wajib diisi',

        ]);

        $names = $request->name;
        $id_survey = $request->id_survey;

        $result = [];
        foreach ($names as $key => $name) {
            $result[] = [
                'name' => $name,
                'id_survey' => $id_survey,
            ];
        }
        try{
            foreach ($result as $data) {
                $category = new M_Category();
                $category->id_survey = $data['id_survey'];
                $category->name = $data['name'];
                $category->save();
            }
            
            return redirect()->route('category.index')->with('success', 'Berhasil Menambahkan data tatanan');
        }
        catch(\Exception $e){
            return redirect()->route('category.create')->with('error', 'Gagal menambahkan data tatanan. Silahkan coba lagi');

        }
    }

    public function edit($id){
        $category = M_Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try{
            $category = M_Category::find($id);
            $category->name = $request->name;
            $category->save();
            return redirect()->route('category.index')->with('success', 'Berhasil mengubah data tatanan');
        }
        catch(\Exception $e){
            return redirect()->route('category.create')->with('error', 'Gagal mengubah data tatanan. Silahkan coba lagi');

        }
    }

    public function destroy($id)
    {
        $category = M_Category::find($id);
        $question = M_Questions::where( 'id_category', $category->id)->get();
        $q_opt = M_Question_Option::whereIn('id_question', $question->pluck('id'))->get();
        $trans_answer = Trans_Survey_D_Answer::whereIn('id_option', $q_opt->pluck('id'))->get();

        if($category){
            if($trans_answer->isNotEmpty()){
                $trans_answer->each->delete();
            }

            if($q_opt->isNotEmpty()){
                $q_opt->each->delete();
            }

            if($question->isNotEmpty()){
                $question->each->delete();
            }

            $category->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus data tatanan beserta relasi ke bawahnya');

        } else{
            return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan data pertanyaan');
        }

        // if(!$question && $category){
        //     $category->delete();
        //     return redirect()->back()->with('success', 'Berhasil menghapus data tatanan');
        // }
        // else{
        //     return redirect()->back()->with('error', 'Gagal menghapus data karena berelasi dengan data pertanyaan');
        // }
    }

    public function onlyTrashed(){
        $trashedData = M_Category::onlyTrashed()->get();
        return view('admin.trashed.category.trash',compact('trashedData'));
    }

    public function restore($id){
        $category = M_Category::withTrashed()->find($id);
        if($category){
            $category->restore();
            $questions = M_Questions::withTrashed()->where('id_category', $id)->get();
            if ($questions->isNotEmpty()) {
                $questions->each(function ($question) {
                    // Restore each question
                    $question->restore();
    
                    // Restore related question options
                    M_Question_Option::withTrashed()
                        ->where('id_question', $question->id)
                        ->restore();
                });
            }
            return redirect()->back()->with('success', 'Berhasil merestore data. Silahkan lihat di data tatanan');
        }
        else{
            return redirect()->back()->with('error', 'Gagal merestore data tatanan');
        }
    }

    public function forceDelete($id){
        $category = M_Category::withTrashed()->find($id);
        if ($category) {
            // Ambil semua pertanyaan terkait kategori
            $questions = M_Questions::withTrashed()->where('id_category', $id)->get();
    
            if ($questions->isNotEmpty()) {
                // Loop melalui setiap pertanyaan
                $questions->each(function ($question) {
                    // Hapus secara permanen setiap opsi jawaban terkait pertanyaan
                    M_Question_Option::withTrashed()
                        ->where('id_question', $question->id)
                        ->forceDelete();
    
                    // Hapus secara permanen pertanyaan
                    $question->forceDelete();
                });
            }
    
            // Hapus kategori secara permanen
            $category->forceDelete();
    
            return redirect()->back()->with('success', 'Berhasil menghapus secara permanen data tatanan beserta relasi-relasinya.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data tatanan, kategori tidak ditemukan.');
        }
        // if($category){
        //     $category->forceDelete();
        //     return redirect()->back()->with('success', 'Berhasil menghapus permanen data tatanan');
        // }
        // else{
        //     return redirect()->back()->with('error', 'Gagal menghapus permanen data tatanan');
        // }
    }


}
