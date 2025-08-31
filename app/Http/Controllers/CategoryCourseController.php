<?php

namespace App\Http\Controllers;

use App\Models\CategoryCourse;
use App\Models\SessionCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryCourseController extends Controller
{
    public function index(){
        $session_date = Session::get('selected_year');

        $categories = CategoryCourse::where('id_survey', $session_date)->get();
        return view('admin.category_course.index', compact('categories'));
    }

    public function create()
    {
        return view("admin.category_course.create");
    }

    public function createSession($id)
    {
        $category = CategoryCourse::find($id);
        return view("admin.category_course.create_session", compact('category'));
    }

    public function show($id)
    {
        $session_date = Session::get('selected_year');
        $category = CategoryCourse::find($id);
        $session_course = SessionCourse::where('id_survey', $session_date)
            ->where('course_id', $id)    
            ->get();
        return view("admin.category_course.show_session", compact('category', 'session_course'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_survey' => 'required',
            'name' => 'required',
        ],);

        // return $request->all();

        try{
            $category = new CategoryCourse();
            $category->id_survey = $request->id_survey;
            $category->name = $request->name;

            $category->save();
            return redirect()->route('category-course.index')->with('success', 'Berhasil Menambahkan Data');
        }
        catch(\Exception $e){
            return redirect()
                ->route('category-course.create')
                ->with('error', 'Gagal menambahkan Data: '.$e->getMessage());
        }

    }

    public function storeSession(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'required|array',
            'description.*' => 'required|string',
            'is_active' => 'required|array',
            'is_active.*' => 'required|in:0,1',
        ],);

        // return $request->all();
        $session_date = Session::get('selected_year');
        $name = $request->name;
        $description = $request->description;
        $is_active = $request->is_active;

        
        $result = [];
        foreach ($name as $key => $name_option) {
            $result[] = [
                'name' => $name_option,
                'description' => $description[$key],
                'is_active' => $is_active[$key],
            ];
        }

        try{
            foreach ($result as $data) {
                $session_course = new SessionCourse();
                $session_course->id_survey = $session_date;
                $session_course->course_id = $id;
                $session_course->name = $data['name'];
                $session_course->description = $data['description'];
                $session_course->is_active = $data['is_active'];
                $session_course->save();
            }

            return redirect()->route('category-course.show', $id)->with('success', 'Berhasil Menambahkan Data');
        }
        catch(\Exception $e){
            return redirect()
                ->route('category-course.createSession', $id)
                ->with('error', 'Gagal menambahkan Data: '.$e->getMessage());
        }

    }

    public function edit($id)
    {
        $category = CategoryCourse::find($id);
        return view("admin.category_course.edit", compact('category'));
    }

    public function editSession($id)
    {
        $session_course = SessionCourse::find($id);
        $category = CategoryCourse::find($session_course->course_id);
        return view("admin.category_course.edit_session", compact('session_course', 'category'));
    }

    public function updateSession(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'is_active' => 'required|in:0,1',
        ]);

        try{
            $session_course = SessionCourse::find($id);
            $session_course->name = $request->name;
            $session_course->description = $request->description;
            $session_course->is_active = $request->is_active;
            $session_course->save();
            return redirect()->route('category-course.show', $session_course->course_id)->with('success', 'Berhasil mengubah data');
        }
        catch(\Exception $e){
            return redirect()->route('category-course.editSession', $id)->with('error', 'Gagal mengubah data: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try{
            $category = CategoryCourse::find($id);
            $category->name = $request->name;
            $category->save();
            return redirect()->route('category-course.index')->with('success', 'Berhasil mengubah data');
        }
        catch(\Exception $e){
            return redirect()->route('category-course.create')->with('error', 'Gagal menambahkan Data: '.$e->getMessage());
        }
    }
    public function destroy($id)
    {
        try{
            $category = CategoryCourse::find($id);
            $category->delete();
            return redirect()->route('category-course.index')->with('success', 'Berhasil menghapus data');
        }
        catch(\Exception $e){
            return redirect()->route('category-course.index')->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }
}
