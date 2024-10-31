<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_Questions;
use App\Models\M_Zona;
use App\Models\Trans_Survey;
use App\Models\User;
use Illuminate\Http\Request;
use Log;
use Session;

class Home_Controller extends Controller
{
    public function index(){
        $session_date = Session::get('selected_year');

        $category = M_Category::select('id')
            ->where('id_survey', $session_date)
            ->count();
        $questions = M_Questions::select('id')
            ->where('id_survey', $session_date)
            ->count();
        $user = User::select('id')->count();
        $zona = M_Zona::select('id')->count();
        $sent = [
            'category' => $category,
            'questions' => $questions,
            'user' => $user,
            'zona' => $zona

        ];
        return view('home.index', $sent);
    }

    public function showYear()
    {
        $t_date = Trans_Survey::orderBy('trans_date', 'asc')->get();
        $sent = [
            't_date' => $t_date,
        ];
        // return $sent;
        return view('home.show_date', $sent);
    }

    public function sessionYear(Request $request)
    {
        $idSurvey = $request->input('id_survey');
        
        Session::put('selected_year', $idSurvey);

        return response()->json(['success' => true, 'id_survey' => $idSurvey]);
    }

}
