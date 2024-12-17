<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\M_District;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        // Ambil data dari model
        $data = M_District::where('province_id',13)->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }
}
