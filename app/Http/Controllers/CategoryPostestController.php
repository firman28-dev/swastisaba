<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostest;
use App\Models\QuestionPostest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Str;

class CategoryPostestController extends Controller
{
    public function index(){
        $session_date = Session::get('selected_year');

        $categories = CategoryPostest::where('id_survey', $session_date)->get();
        return view('admin.category_postest.index', compact('categories'));
    }

    public function create()
    {
        return view("admin.category_postest.create");
    }

    public function createQuestion($id)
    {
        $category = CategoryPostest::find($id);
        return view("admin.category_postest.create_question", compact('category'));
    }

   

    public function show($id)
    {
        $session_date = Session::get('selected_year');
        $category = CategoryPostest::find($id);
        $questions = QuestionPostest::where('category_id', $id)
            ->where('id_survey', $session_date)
            ->get();
        return view("admin.category_postest.show_question", compact('category', 'questions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
        ],);

        // return $request->all();

        try{
            $category = new CategoryPostest();
            $category->id_survey = $request->id_survey;
            $category->name = $request->name;

            $category->save();
            return redirect()->route('category-postest.index')->with('success', 'Berhasil Menambahkan Data');
        }
        catch(\Exception $e){
            return redirect()
                ->route('category-postest.create')
                ->with('error', 'Gagal menambahkan Data: '.$e->getMessage());
        }

    }

    public function storeQuestion(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id_survey'   => 'required|integer',
            'id_category' => 'required|integer',
            'question'    => 'required|string',
            'option_a'    => 'required|string',
            'option_b'    => 'required|string',
            'option_c'    => 'required|string',
            'option_d'    => 'required|string',
            'opt_correct' => 'required|in:A,B,C,D',
        ], [
            'id_survey.required'   => 'Tahun tidak boleh kosong',
            'id_category.required' => 'Kategori tidak boleh kosong',
            'question.required'    => 'Pertanyaan tidak boleh kosong',
            'option_a.required'    => 'Opsi A wajib diisi',
            'option_b.required'    => 'Opsi B wajib diisi',
            'option_c.required'    => 'Opsi C wajib diisi',
            'option_d.required'    => 'Opsi D wajib diisi',
            'opt_correct.required' => 'Jawaban benar wajib dipilih',
        ]);

        // return $request->all();

        try{
            $question = new QuestionPostest();
            $question->category_id = $request->id_category;
            $question->id_survey = $request->id_survey;
            $question->question = $request->question;
            $question->opt_a = $request->option_a;
            $question->opt_b = $request->option_b;
            $question->opt_c = $request->option_c;
            $question->opt_d = $request->option_d;
            $question->opt_correct = $request->opt_correct;
            $question->created_by = $user->id;
            $question->updated_by = $user->id;

            $question->save();
            return redirect()->route('category-postest.show', $request->id_category)->with('success', 'Berhasil Menambahkan Data');
        }
        catch(\Exception $e){
            return redirect()
                ->route('category-postest.createQuestion', $request->id_category)
                ->with('error', 'Gagal menambahkan Data: '.$e->getMessage());
        }

    }

    public function edit($id)
    {
        $category = CategoryPostest::find($id);
        return view("admin.category_postest.edit", compact('category'));
    }

    public function editQuestion($id)
    {
        $question = QuestionPostest::find($id);
        $category = CategoryPostest::find($question->category_id);
        return view("admin.category_postest.edit_question", compact('question', 'category'));
    }

    public function uploadFileEditor(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $originalName = Str::slug($originalName); // hasil: "surat-pernyataan-non-pkp"
            $extension = $file->getClientOriginalExtension();

            $filename = $originalName . '_' . Str::random(8) . '.' . $extension;

            // $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $destination = $_SERVER['DOCUMENT_ROOT'] .  '/uploads/question/file';
            $file->move($destination, $filename);
            $url = asset('/uploads/question/file/' . $filename);
            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function updateQuestion(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'id_survey'   => 'required|integer',
            'id_category' => 'required|integer',
            'question'    => 'required|string',
            'option_a'    => 'required|string',
            'option_b'    => 'required|string',
            'option_c'    => 'required|string',
            'option_d'    => 'required|string',
            'opt_correct' => 'required|in:A,B,C,D',
        ], [
            'id_survey.required'   => 'Tahun tidak boleh kosong',
            'id_category.required' => 'Kategori tidak boleh kosong',
            'question.required'    => 'Pertanyaan tidak boleh kosong',
            'option_a.required'    => 'Opsi A wajib diisi',
            'option_b.required'    => 'Opsi B wajib diisi',
            'option_c.required'    => 'Opsi C wajib diisi',
            'option_d.required'    => 'Opsi D wajib diisi',
            'opt_correct.required' => 'Jawaban benar wajib dipilih',
        ]);

        // return $request->all();

        try{
            $question = QuestionPostest::find($id);
            $question->category_id = $request->id_category;
            $question->id_survey = $request->id_survey;
            $question->question = $request->question;
            $question->opt_a = $request->option_a;
            $question->opt_b = $request->option_b;
            $question->opt_c = $request->option_c;
            $question->opt_d = $request->option_d;
            $question->opt_correct = $request->opt_correct;
            $question->updated_by = $user->id;

            $question->save();
            return redirect()->route('category-postest.show', $request->id_category)->with('success', 'Berhasil Mengubah Data');
        }
        catch(\Exception $e){
            return redirect()
                ->route('category-postest.editQuestion', [$id])
                ->with('error', 'Gagal mengubah Data: '.$e->getMessage());
        }
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try{
            $category = CategoryPostest::find($id);
            $category->name = $request->name;
            $category->save();
            return redirect()->route('category-postest.index')->with('success', 'Berhasil mengubah data');
        }
        catch(\Exception $e){
            return redirect()->route('category-postest.create')->with('error', 'Gagal menambahkan Data: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = CategoryPostest::find($id);
            $category->delete();
            return redirect()->route('category-postest.index')->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return redirect()->route('category-postest.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function destroyQuestion($id)
    {
        try{
            $question = QuestionPostest::find($id);
            $category_id = $question->category_id;
            $question->delete();
            return redirect()->route('category-postest.show', $category_id)->with('success', 'Berhasil menghapus data');
        }
        catch(\Exception $e){
            return redirect()->route('category-postest.index')->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }
}
