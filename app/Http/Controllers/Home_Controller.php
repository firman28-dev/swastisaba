<?php

namespace App\Http\Controllers;

use App\Models\M_Category;
use App\Models\M_District;
use App\Models\M_Questions;
use App\Models\M_Zona;
use App\Models\Trans_Survey;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use App\Models\User;
use Auth;
use Cache;
use DB;
use Illuminate\Http\Request;
use Log;
use Session;

class Home_Controller extends Controller
{
    public function index(){
        $user = Auth::user();
        $idZona = $user->id_zona;
        $idGroup = $user->id_group;
        $searchDistrict = Cache::remember('searchDistrict', 60, function () {
            return M_District::where('province_id', 13)->get();
        });
        // return $searchDistrict;
        // $searchDistrict = M_District::where('province_id',13)->get();

        $session_date = Session::get('selected_year');
        $category = M_Category::select('id')
            ->where('id_survey', $session_date)
            ->count();
        $questions = M_Questions::select('id')
            ->where('id_survey', $session_date)
            ->count();
        $user = User::select('id')->count();
        $zona = M_District::where('province_id', 13)->get();
        $pluckZona =  M_District::where('province_id', 13)->pluck('name');

        $answers = M_District::where('province_id', 13)
            ->leftJoin('trans_survey_d_answer', function($join) use ($session_date) {
            $join->on('district.id', '=', 'trans_survey_d_answer.id_zona')
                ->where('trans_survey_d_answer.id_survey', $session_date);
            })
            ->leftJoin('m_question_options as opt_kabkota', 'trans_survey_d_answer.id_option','=', 'opt_kabkota.id')
            ->leftJoin('m_question_options as opt_prov', 'trans_survey_d_answer.id_option_prov', '=', 'opt_prov.id')
            ->select(
                'district.name as district_name',
                DB::raw('COUNT(trans_survey_d_answer.id) as total_jawaban'),
                DB::raw('SUM(opt_kabkota.score) as total_nilai'),
                DB::raw('SUM(opt_prov.score) as total_nilai_prov')
            )
            ->groupBy('district.name')
            ->orderBy('total_jawaban', 'desc')
            ->get();
        
        $districtNames = $answers->pluck('district_name');
        $totalAnswers = $answers->pluck('total_jawaban');
        $totalScore = $answers->pluck('total_nilai');
        $totalScoreProv = $answers->pluck('total_nilai_prov');


        $chart = M_Category::where('id_survey', $session_date)
            ->withCount([
                '_transDAnswer as total_jawaban' => function ($query) use ($session_date, $idZona) {
                    $query->where('id_survey', $session_date)->where('id_zona', $idZona);
                }, 
                '_question as total_pertanyaan',
                '_transDAnswer as total_verifprov' => function ($query) use ($session_date, $idZona) {
                    $query->where('id_survey', $session_date)
                        ->where('id_zona', $idZona)
                        ->whereNotNull('id_option_prov');
                }
            ])
            ->with(['_transDAnswer' => function ($query) use ($session_date, $idZona) {
                $query->where('id_survey', $session_date)
                      ->where('id_zona', $idZona)
                      ->with('_q_option','_q_option_prov'); 
            }])
            ->get();

        $chartData = $chart->map(function ($category) {
            $totalScore = $category->_transDAnswer->sum(function ($answer) {
                return $answer->_q_option ? $answer->_q_option->score : 0;
            });
            $totalScoreProv = $category->_transDAnswer->sum(function ($answer) {
                return $answer->_q_option_prov ? $answer->_q_option_prov->score : 0;
            });

            return [
                'kategori' => $category->name,  // atau gunakan field yang sesuai untuk nama kategori
                'total_jawaban' => $category->total_jawaban,
                'total_jawabanprov' => $category->total_verifprov,
                'total_pertanyaan' => $category->total_pertanyaan,
                'total_score' => $totalScore,
                'total_score_prov' => $totalScoreProv,
                
            ];
        });

        // return $chartData;

        $categoryV2 = M_Category::where('id_survey', $session_date)->get();


        $sent = [
            'category' => $category,
            'questions' => $questions,
            'user' => $user,
            'zona' => $zona,
            'pluckZona' => $pluckZona,
            'districtNames' => $districtNames,
            'totalAnswers' => $totalAnswers,
            'totalScore' => $totalScore,
            'totalScoreProv' => $totalScoreProv,
            'categoryV2' => $categoryV2,
            'chartData' => $chartData,
            'idGroup' => $idGroup,
            'searchDistrict' => $searchDistrict
            // 'categoryLabels' => $categoryLabels,
            // 'categoryData' =>$categoryData

        ];
        // return $totalScoreProv;
        return view('home.index', $sent);
    }

    public function index2()
    {
        $user = Auth::user();
    $idZona = $user->id_zona;
    $idGroup = $user->id_group;

    // Cache searchDistrict data
    $searchDistrict = Cache::remember('searchDistrict', 60, function () {
        return M_District::where('province_id', 13)->get();
    });

    $session_date = Session::get('selected_year');

    // Cache category count
    $category = Cache::remember("category_count_{$session_date}", 60, function () use ($session_date) {
        return M_Category::where('id_survey', $session_date)->count();
    });

    // Cache questions count
    $questions = Cache::remember("questions_count_{$session_date}", 60, function () use ($session_date) {
        return M_Questions::where('id_survey', $session_date)->count();
    });

    // Cache user count
    $userCount = Cache::remember('user_count', 60, function () {
        return User::count();
    });

    // Cache zona data
    $zona = Cache::remember('zona', 60, function () {
        return M_District::where('province_id', 13)->get();
    });

    // Cache pluckZona data
    $pluckZona = Cache::remember('pluckZona', 60, function () {
        return M_District::where('province_id', 13)->pluck('name');
    });

    // Cache answers data
    $answers = Cache::remember("answers_{$session_date}", 60, function () use ($session_date) {
        return M_District::where('province_id', 13)
            ->leftJoin('trans_survey_d_answer', function($join) use ($session_date) {
                $join->on('district.id', '=', 'trans_survey_d_answer.id_zona')
                    ->where('trans_survey_d_answer.id_survey', $session_date);
            })
            ->leftJoin('m_question_options', 'trans_survey_d_answer.id_option','=', 'm_question_options.id')
            ->select('district.name as district_name', DB::raw('COUNT(trans_survey_d_answer.id) as total_jawaban'), DB::raw('SUM(m_question_options.score) as total_nilai'))
            ->groupBy('district.name')
            ->orderBy('total_jawaban', 'desc')
            ->get();
    });

    // Prepare district names, total answers, and total score
    $districtNames = $answers->pluck('district_name');
    $totalAnswers = $answers->pluck('total_jawaban');
    $totalScore = $answers->pluck('total_nilai');

    // Cache chart data
    $chart = Cache::remember("chart_data_{$session_date}_{$idZona}", 60, function () use ($session_date, $idZona) {
        return M_Category::where('id_survey', $session_date)
            ->withCount(['_transDAnswer as total_jawaban' => function ($query) use ($session_date, $idZona) {
                $query->where('id_survey', $session_date)->where('id_zona', $idZona);
            }, '_question as total_pertanyaan'])
            ->with(['_transDAnswer' => function ($query) use ($session_date, $idZona) {
                $query->where('id_survey', $session_date)
                    ->where('id_zona', $idZona)
                    ->with('_q_option'); 
            }])
            ->get();
    });

    // Process chart data
    $chartData = Cache::remember("chartDataProcessed_{$session_date}_{$idZona}", 60, function () use ($chart) {
        return $chart->map(function ($category) {
            $totalScore = $category->_transDAnswer->sum(function ($answer) {
                return $answer->_q_option ? $answer->_q_option->score : 0;
            });

            return [
                'kategori' => $category->name, 
                'total_jawaban' => $category->total_jawaban,
                'total_pertanyaan' => $category->total_pertanyaan,
                'total_score' => $totalScore
            ];
        });
    });

    // Cache categoryV2 data
    $categoryV2 = Cache::remember("categoryV2_{$session_date}", 60, function () use ($session_date) {
        return M_Category::where('id_survey', $session_date)->get();
    });

    $sent = [
        'category' => $category,
        'questions' => $questions,
        'user' => $userCount,
        'zona' => $zona,
        'pluckZona' => $pluckZona,
        'districtNames' => $districtNames,
        'totalAnswers' => $totalAnswers,
        'totalScore' => $totalScore,
        'categoryV2' => $categoryV2,
        'chartData' => $chartData,
        'idGroup' => $idGroup,
        'searchDistrict' => $searchDistrict
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

    public function showDistrict(Request $request)
    {
        $session_date = Session::get('selected_year');

        $request->validate([
            'id_district' => 'required',
        ],);
        $category = M_Category::where('id_survey', $session_date)->get();
        $district= $request->id_district;
        $districtv2 = M_District::find($request->id_district);
        
        $chart = M_Category::where('id_survey', $session_date)
            ->withCount(['_transDAnswer as total_jawaban' => function ($query) use ($session_date, $district) {
                $query->where('id_survey', $session_date)->where('id_zona', $district);
            }, '_question as total_pertanyaan'])
            ->with(['_transDAnswer' => function ($query) use ($session_date, $district) {
                $query->where('id_survey', $session_date)
                      ->where('id_zona', $district)
                      ->with('_q_option','_q_option_prov'); 
            }])
            ->get();

        $chartData = $chart->map(function ($category) {
            $totalScore = $category->_transDAnswer->sum(function ($answer) {
                return $answer->_q_option ? $answer->_q_option->score : 0;
            });
            $totalScoreProv = $category->_transDAnswer->sum(function ($answer) {
                return $answer->_q_option_prov ? $answer->_q_option_prov->score : 0;
            });

            return [
                'kategori' => $category->name,  // atau gunakan field yang sesuai untuk nama kategori
                'total_jawaban' => $category->total_jawaban,
                'total_pertanyaan' => $category->total_pertanyaan,
                'total_score' => $totalScore,
                'total_score_prov' => $totalScoreProv
            ];
        });

        $sent = [
            'chartData' => $chartData,
            'districtv2' => $districtv2,
            'category' => $category
        ];
        return view('home.show_kabkota',$sent);
    }

    public function getDistrict($idDistirct)
    {
        $session_date = Session::get('selected_year');

       
        $category = M_Category::where('id_survey', $session_date)->get();
        $district= $idDistirct;
        $districtv2 = M_District::find($idDistirct);
        
        $chart = M_Category::where('id_survey', $session_date)
            ->withCount(['_transDAnswer as total_jawaban' => function ($query) use ($session_date, $district) {
                $query->where('id_survey', $session_date)->where('id_zona', $district);
            }, '_question as total_pertanyaan'])
            ->with(['_transDAnswer' => function ($query) use ($session_date, $district) {
                $query->where('id_survey', $session_date)
                      ->where('id_zona', $district)
                      ->with('_q_option'); 
            }])
            ->get();

        $chartData = $chart->map(function ($category) {
            $totalScore = $category->_transDAnswer->sum(function ($answer) {
                return $answer->_q_option ? $answer->_q_option->score : 0;
            });

            return [
                'kategori' => $category->name,  // atau gunakan field yang sesuai untuk nama kategori
                'total_jawaban' => $category->total_jawaban,
                'total_pertanyaan' => $category->total_pertanyaan,
                'total_score' => $totalScore
            ];
        });

        $sent = [
            'chartData' => $chartData,
            'districtv2' => $districtv2,
            'category' => $category
        ];
        return view('home.show_kabkota',$sent);
    }

    public function showCategory(Request $request,$idZona)
    {
        $session_date = Session::get('selected_year');

        $request->validate([
            'id_category' => 'required',
        ],);
        $district = M_District::find($idZona);
        $id_category = $request->id_category;

        $category = M_Category::find($id_category);
        $questions = M_Questions::where('id_category', $category->id)
            ->get();

        $answer = Trans_Survey_D_Answer::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();
        
        $uploadedFiles = Trans_Upload_KabKota::where('id_zona',$idZona)
            ->where('id_survey', $session_date)
            ->get();
        
        $sent = [
            'district' => $district,
            'questions' => $questions,
            'answer' => $answer,
            'uploadedFiles' => $uploadedFiles,
            'category' => $category,
            'session_date' =>$session_date,

        ];
        return view('home.show_category',$sent);

    }

}
