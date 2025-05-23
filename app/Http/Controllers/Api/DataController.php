<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\M_Category;
use App\Models\M_District;
use App\Models\M_Questions;
use App\Models\Trans_ODF_New;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function kabkota()
    {
        $data = M_District::where('province_id',13)
        ->select('id','name','kabupaten_id', 'province_id')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function getProvince(){
        $provinsi = M_District::where('provinsi_id',3)->get();
        return response()->json([
            'status' => 'success',
            'data' => $provinsi,
        ], 200);
    }

    public function getIndikatorTatanan(){
        $kategori = M_Category::where('id_survey', 5)
        ->with(['_question' => function ($query) {
            $query->where('id_survey', 5)
                ->orderBy('pertanyaan_id', 'asc')
                ->select('m_questions.id','m_questions.id_survey','m_questions.id_category','m_questions.name', 'm_questions.category_id', 'm_questions.pertanyaan_id');
        }])
        ->orderBy('tatanan_id', 'asc')
        ->get();
        // $question = M_Questions::where('id_survey',5)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kategori,
        ], 200);
    }


    //ODF
    public function getOdf(){
        $districtodf = M_District::where('province_id',13)
            ->select('id', 'province_id','provinsi_id', 'kabupaten_id','name')
            ->with(['_odf' => function($query) {
                $query->where('id_survey', 5);
            }])
            ->orderBy('kabupaten_id', 'asc')
            ->get();

        $odf = Trans_ODF_New::where('id_survey',5)->get();
        // $question = M_Questions::where('id_survey',5)->get();
        return response()->json([
            'status' => 'success',
            'data' => $districtodf,
        ], 200);
    }

    public function sendodfperkabkota(){
        $loginResponse = Http::asForm()->post('https://sipantas.kemkes.go.id/AP_Data/token', [
            'username' => 'kotapayakumbuh',
            'password' => 'Payakumbuh123!@#',
            'grant_type' => 'password',
            'client_secret' => '503416c9-70e9-43e2-a12f-7fd78323eb83',
            'client_id' => 'da7b4cc8-fd90-4626-9ff1-dbe58d2516a2'
        ]);

        if (!$loginResponse->successful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login gagal ke API Pusat',
                'error' => $loginResponse->json()
            ], 401);
        }

        $token = $loginResponse['access_token'];

        $data = M_District::where('kabupaten_id', 70)
            ->with(['_odf' => function($query) {
                $query->where('id_survey', 5);
            }])
            ->first();


        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data ODF tidak ditemukan'
            ], 404);
        }

        // $sendResponse = Http::withToken($token)
        //     ->asForm()
        //     ->post('https://sipantas.kemkes.go.id/AP_Data/sendDataODF', [
        //             'jumlah_kecamatan' => $data->_odf[0]->sum_subdistricts,
        //             'jumlah_desa_kelurahan' => $data->_odf[0]->sum_villages,
        //             'jumlah_desa_stop_babs' => $data->_odf[0]->s_villages_stop_babs,
        //             'persentase_desa_stop_babs' => (int) $data->_odf[0]->p_villages_stop_babs,
        //             'tahun' => 2024,
        //             'status' => 4,

        //     ]);

        // if ($sendResponse->successful()) {
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Data berhasil dikirim',
        //         'response' => $sendResponse->json()
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Gagal kirim data ke API pusat',
        //         'response' => $sendResponse->json()
        //     ], 500);
        // }

        return response()->json([
            'status' => 'done',
            'token' => $token,
            'results' => $data
        ]);


    }

    public function sendodfAllKabkota(){
        $loginResponse = Http::asForm()->post('https://sipantas.kemkes.go.id/AP_Data/token', [
            'username' => 'kotapayakumbuh',
            'password' => 'Payakumbuh123!@#',
            'grant_type' => 'password',
            'client_secret' => '503416c9-70e9-43e2-a12f-7fd78323eb83',
            'client_id' => 'da7b4cc8-fd90-4626-9ff1-dbe58d2516a2'
        ]);

        if (!$loginResponse->successful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login gagal ke API Pusat',
                'error' => $loginResponse->json()
            ], 401);
        }

        $token = $loginResponse['access_token'];

        $districts = M_District::where('province_id',13)->with(['_odf' => function($query) {
            $query->where('id_survey', 5);
        }])->get();

        $results = [];

        foreach ($districts as $district) {
            $odf = $district->_odf->first();
            if (!$odf) {
                $results[] = [
                    'kabupaten_id' => $district->kabupaten_id,
                    'nama kabkota' => $district->name,
                    'status' => 'skipped',
                    'message' => 'Data ODF tidak tersedia'
                ];
                continue;
            }

            if (!$district->kabupaten_id) {
                $results[] = [
                    'kabupaten_id' => null,
                    'status' => 'skipped',
                    'message' => 'kabupaten_id tidak tersedia'
                ];
                continue;
            }
            $sendResponse = Http::withToken($token)
                ->asForm()
                ->post('https://sipantas.kemkes.go.id/AP_Data/sendDataODFByKabupaten', [
                    'jumlah_kecamatan' => $odf->sum_subdistricts,
                    'jumlah_desa_kelurahan' => $odf->sum_villages,
                    'jumlah_desa_stop_babs' => $odf->s_villages_stop_babs,
                    'persentase_desa_stop_babs' => (int) $odf->p_villages_stop_babs,
                    'tahun' => 2024,
                    'status' => 4,
                    'kabupaten_id' => $district->kabupaten_id,
                ]);

            $results[] = [
                'kabupaten_id' => $district->kabupaten_id,
                'nama kabkota' => $district->name,
                'status' => $sendResponse->successful() ? 'success' : 'error',
                'message' => $sendResponse->successful() ? 'Data berhasil dikirim' : 'Gagal mengirim data',
                'response' => $sendResponse->json()
            ];
        }

        
        return response()->json([
            'status' => 'done',
            'token' => $token,
            'results' => $results,
        ]);
        
    }

    //KELEMBAGAAN
    


}
