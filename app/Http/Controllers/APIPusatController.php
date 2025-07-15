<?php

namespace App\Http\Controllers;

use App\Models\Doc_Question;
use App\Models\M_District;
use App\Models\M_Q_Kelembagaan_New;
use App\Models\M_Questions;
use App\Models\Trans_Doc_Kelembagaan;
use App\Models\Trans_Kelembagaan_V2;
use App\Models\Trans_Survey_D_Answer;
use App\Models\Trans_Upload_KabKota;
use Http;
use Illuminate\Http\Request;

class APIPusatController extends Controller
{
    public function index(){
        $includedIdsKabKota = [59, 61, 62, 63, 64, 65, 66, 68, 70, 72, 74, 75];
        $districts = M_District::where('province_id', 13)
            ->whereIn('kabupaten_id', $includedIdsKabKota)
            ->orderBy('kabupaten_id', 'asc')
            ->get();
        // $districts = M_District::where('province_id', 13)
        //     ->orderBy('kabupaten_id', 'asc')->get();

        return view('admin.api.index', compact('districts'));
    }

    public function viewTatananPerkabkota2024(Request $request){
        $id = $request->id;
        // $findKota = M_District::find($id);
        // return $findKota;
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

        $district = M_District::where('province_id',13)
            ->where('id', $id)
            ->select('id', 'province_id', 'name', 'provinsi_id', 'kabupaten_id')
            ->first();
        
        $questions = M_Questions::where('id_survey', 5)
            ->select('id', 'pertanyaan_id', 'name', 'category_id', 'id_survey')
            ->orderBy('pertanyaan_id','asc')
            ->get();

        $questionResults = [];
        $sendResults = [];
        $totalJawaban = 0;


        foreach ($questions as $q) {
            $answer = Trans_Survey_D_Answer::where('id_survey', 5)
                ->where('id_zona', $district->id)
                ->where('id_question', $q->id)
                ->first();

            if (!$answer) {
                continue;
            }

            $totalJawaban++;

            $docs = Doc_Question::where('id_survey', 5)
                ->where('id_question', $q->id)
                ->select('id', 'id_question', 'name')
                ->get();
            
            $dokumen = [];
            
            foreach($docs as $doc){
                $uploadDoc = Trans_Upload_KabKota::where('id_zona',$district->id)
                    ->where('id_survey', 5)
                    ->where('id_doc_question', $doc->id)
                    ->first();

                $dokumen[] = [
                    'id' => $doc->id,
                    'id_question' => $doc->id_question,
                    'name' => $doc->name,
                    'upload' => $uploadDoc ? [
                        'id' => $uploadDoc->id,
                        'url' => $uploadDoc->file_path
                            ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_pendukung/' . $uploadDoc->file_path
                            : null,
                    ] : null
                ];
                
            }

            $sendPayload = [
                'indikator_id' => $q->pertanyaan_id,
                'pertanyaan' => $q->name,
                'capaian' => $answer?->achievement ?? '',
                'file_capaian' => $dokumen[1]['upload']['url'] ?? $dokumen[0]['upload']['url'] ?? '',
                'penjelasan_kabupaten' => $answer?->comment ?? '',
                'penjelasan_provinsi' => $answer?->comment_prov ?? '',
                'nilai_mandiri' => $answer?->_q_option?->score ?? 0,
                'nilai_provinsi' => $answer?->_q_option_prov?->score ?? 0,
                'status' => 4,
                'tahun' => 2024,
                'kabupaten_id' => $district->kabupaten_id
            ];

            $sendResults[] = [
                'indikator_id' => $q->pertanyaan_id,
                'sendPayload' => $sendPayload
            ];
            
        }
        

        return response()->json([
            'status' => 'done',
            'token' => $token,
            'total_jawaban' => $totalJawaban,
            'results' => $district,
            'data' => $sendResults,
        ]);

    }

    //send API CAPAIAN TATANAN
    public function viewTatananPerkabkotaMerged(Request $request){
        $id = $request->id;

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

        $district = M_District::where('province_id',13)
            ->where('id', $id)
            ->select('id', 'province_id', 'name', 'provinsi_id', 'kabupaten_id')
            ->first();
        
        $questions = M_Questions::where('id_survey', 5)
            ->select('id', 'pertanyaan_id', 'name', 'category_id', 'id_survey')
            ->orderBy('pertanyaan_id','asc')
            ->get();
        
        //2023
        $previousSurvey = 7;

        $questionResults = [];

        $sendResults = [];
        $totalJawaban = 0;


        foreach ($questions as $q) {
            $answer = Trans_Survey_D_Answer::where('id_survey', 5)
                ->where('id_zona', $district->id)
                ->where('id_question', $q->id)
                ->first();
            
            

            if (!$answer) {
                continue;
            }

            $prevQuestion = M_Questions::where('name', $q->name)
                ->where('id_survey', $previousSurvey)
                ->first();

            $answerPrev = null;
            $dokumenPrev = [];

            if ($prevQuestion) {
                $answerPrev = Trans_Survey_D_Answer::where('id_question', $prevQuestion->id)
                    ->where('id_zona', $district->id)
                    ->where('id_survey', $previousSurvey)
                    ->first();
                
                $docsPrev = Doc_Question::where('id_survey', $previousSurvey)
                    ->where('id_question', $prevQuestion->id)
                    ->select('id', 'id_question', 'name')
                    ->get();

                foreach ($docsPrev as $docPrev) {
                    $uploadDocPrev = Trans_Upload_KabKota::where('id_zona', $district->id)
                        ->where('id_survey', $previousSurvey)
                        ->where('id_doc_question', $docPrev->id)
                        ->first();

                    $dokumenPrev[] = [
                        'id' => $docPrev->id,
                        'id_question' => $docPrev->id_question,
                        'name' => $docPrev->name,
                        'upload' => $uploadDocPrev ? [
                            'id' => $uploadDocPrev->id,
                            'url' => $uploadDocPrev->file_path
                                ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_pendukung/' . $uploadDocPrev->file_path
                                : null,
                        ] : null
                    ];
                }
            }

            $totalJawaban++;

            $docs = Doc_Question::where('id_survey', 5)
                ->where('id_question', $q->id)
                ->select('id', 'id_question', 'name')
                ->get();
            
            $dokumen = [];
            
            foreach($docs as $doc){
                $uploadDoc = Trans_Upload_KabKota::where('id_zona',$district->id)
                    ->where('id_survey', 5)
                    ->where('id_doc_question', $doc->id)
                    ->first();

                $dokumen[] = [
                    'id' => $doc->id,
                    'id_question' => $doc->id_question,
                    'name' => $doc->name,
                    'upload' => $uploadDoc ? [
                        'id' => $uploadDoc->id,
                        'url' => $uploadDoc->file_path
                            ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_pendukung/' . $uploadDoc->file_path
                            : null,
                    ] : null
                ];
                
            }

            $sendPayload = Http::withToken($token)
                ->asForm()
                ->post('https://sipantas.kemkes.go.id/AP_Data/sendDataCapaiaanTatananByKabupaten', [
                    'indikator_id' => $q->pertanyaan_id,
                    'capaian' => $answer?->achievement ?? '',
                    'capaian_sebelumnya' => $answerPrev?->achievement ?? '-',
                    'file_capaian' => $dokumen[1]['upload']['url'] ?? $dokumen[0]['upload']['url'] ?? '',
                    'file_sebelumnya' => $dokumenPrev[1]['upload']['url'] ?? $dokumenPrev[0]['upload']['url'] ?? '',
                    'penjelasan_kabupaten' => $answer?->comment ?? '-',
                    'penjelasan_provinsi' => $answer?->comment_prov ?? '-',
                    'nilai_mandiri' => $answer?->_q_option?->score ?? 0,
                    'nilai_provinsi' => $answer?->_q_option_prov?->score ?? 0,
                    'status' => 4,
                    'tahun' => 2024,
                    'kabupaten_id' => $district->kabupaten_id
                ]);

          

            $sendResults[] = [
                'indikator_id' => $q->pertanyaan_id,
                'status' => $sendPayload->successful() ? 'success' : 'error',
                'message' => $sendPayload->successful() ? 'Data berhasil dikirim' : 'Gagal mengirim data',
                'response' => $sendPayload->json()
            ];
            
        }
        

        return response()->json([
            'status' => 'done',
            'token' => $token,
            'total_jawaban' => $totalJawaban,
            'results' => $district,
            'data' => $sendResults,
        ]);

    }

    //send API ODF
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

    // send API KELEMBAGAAN
    public function viewCapaiankelembagaan2024(){
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

        $districts = M_District::where('province_id',13)
            // ->where('kabupaten_id','66')
            ->orderBy('kabupaten_id')
            ->get();

        $questions = M_Q_Kelembagaan_New::where('id_survey', 5)
            ->orderBy('id_pusat','asc')
            ->get();

        $results = [];
        $sendResultsResponse = [];
      
        
        foreach ($districts as $district) {

            
            $answers = Trans_Kelembagaan_V2::where('id_survey', 5)
                ->where('id_zona', $district->id)
                ->get();

            $docs = Trans_Doc_Kelembagaan::where('id_survey', 5)
                ->where('id_zona', $district->id)
                ->get();
           
            
            $questionResults = [];
            $totalJawabanKabupaten = 0;
            $previousSurvey = 7;

            foreach ($questions as $q) {
                $jawaban = $answers->firstWhere('id_q_kelembagaan', $q->id);
                $dokumen = $docs->firstWhere('id_q_kelembagaan', $q->id);

                $question2023 = M_Q_Kelembagaan_New::where('indikator', $q->indikator) // cocokkan dengan nama indikator
                    ->where('id_survey', 7)
                    ->where('id_pusat', $q->id_pusat)
                    ->first();
                $answer2023 = null;
                $doc2023 = null;

                if ($question2023) {
                    $answer2023 = Trans_Kelembagaan_V2::where('id_survey', 7)
                        ->where('id_zona', $district->id)
                        ->where('id_q_kelembagaan', $question2023->id)
                        ->first();

                    $doc2023 = Trans_Doc_Kelembagaan::where('id_survey', 7)
                        ->where('id_zona', $district->id)
                        ->where('id_q_kelembagaan', $question2023->id)
                        ->first();
                }

                if ($jawaban) {
                    $totalJawabanKabupaten++;

                    // $questionResults[] = [
                      
                    //     'indikator_id' => $q->id_pusat,
                    //     'jumlah_kecamatan' => $jawaban?->sum_subdistrict,
                    //     'jumlah_kelurahan' => $jawaban?->sum_village,
                    //     'file_capaian' => $dokumen?->path ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_kelembagaan/' . $dokumen->path : null,
                    //     'capaian' => $jawaban?->achievement,
                    //     'capaian_sebelumnya' => $answer2023?->achievement ?? null,
                    //     'file_sebelumnya' => $doc2023?->path
                    //         ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_kelembagaan/' . $doc2023->path
                    //         : null,
                    //     'nilai_mandiri' => $jawaban?->_q_option?->score,
                    //     'nilai_provinsi' => $jawaban?->_q_option_prov?->score,
                    //     'penjelasan_kabupaten' => $jawaban?->note,
                    //     'penjelasan_provinsi' => $jawaban?->comment_prov,
                    //     'status' => 4,
                    //     'tahun' => 2024,
                    //     'kabupaten_id' => $district->kabupaten_id
                        
                    // ];
                    $sendPayload = Http::withToken($token)
                        ->asForm()
                        ->post('https://sipantas.kemkes.go.id/AP_Data/sendDataCapaianKelembagaanByKabupaten', [
                            'indikator_id' => $q->id_pusat,
                            'jumlah_kecamatan' => $jawaban?->sum_subdistrict ?? '-',
                            'jumlah_desa_kelurahan' => $jawaban?->sum_village ?? '-',
                            'file_capaian' => $dokumen?->path ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_kelembagaan/' . $dokumen->path : '-',
                            'capaian' => $jawaban?->achievement,
                            'capaian_sebelumnya' => $answer2023?->achievement ?? '-',
                            'file_sebelumnya' => $doc2023?->path
                                ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_kelembagaan/' . $doc2023->path
                                : '-',
                            'nilai_mandiri' => $jawaban?->_q_option?->score ?? 0,
                            'nilai_provinsi' => $jawaban?->_q_option_prov?->score ?? 0,
                            'penjelasan_provinsi' => $jawaban?->comment_prov ?? '-',
                            'penjelasan_kabupaten' => $jawaban?->note ?? '-',
                            'status' => 4,
                            'tahun' => 2024,
                            'kabupaten_id' => $district->kabupaten_id
                    ]);

                    $sendResultsResponse[] = [
                        'indikator_id' => $q->id_pusat,
                        'status' => $sendPayload->successful() ? 'success' : 'error',
                        'message' => $sendPayload->successful() ? 'Data berhasil dikirim' : 'Gagal mengirim data',
                        'response' => $sendPayload->json()
                    ];

                } 
               
                // else {
                //     $questionResults[] = [
                //         'id' => $q->id,
                //         'indikator_id' => $q->id_pusat,
                //         'pertanyaan' => $q->indikator,
                //         'nilai_mandiri' => null,
                //         'nilai_provinsi' => null,
                //         'penjelasan_kabupaten' => null,
                //         'penjelasan_provinsi' => null,
                //         'jumlah_kecamatan' => null,
                //         'jumlah_kelurahan' => null,
                //         'capaian' => null,
                //         'file_capaian' => null,
                //         'capaian_2023' => $answer2023?->achievement ?? null,
                //         'file_capaian_2023' => $doc2023?->path
                //             ? 'https://swastisaba.sumbarprov.go.id/uploads/doc_kelembagaan/' . $doc2023->path
                //             : null,
                //     ];
                // }
            }

            $results[] = [
                'id' => $district->id,
                'kabupaten_id' => $district->kabupaten_id,
                'nama_kabkota' => $district->name,
                'total_jawaban' => $totalJawabanKabupaten,
                'data' => $sendResultsResponse
            ];
        }
        return response()->json([
            'status' => 'done',
            'token' => $token,
            'results' => $results
        ]);

    }
}
