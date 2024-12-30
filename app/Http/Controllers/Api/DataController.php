<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\M_District;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $data = M_District::where('province_id',13)->get();
        $count = M_District::where('province_id',13)->count();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'total' => $count
        ], 200);
    }
}
