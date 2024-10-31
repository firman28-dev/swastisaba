<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function index(){
        $test = M_Category::with('_question._q_option')->find(1);
        // return $test;
        return view('admin.test',compact('test'));
    }
}
