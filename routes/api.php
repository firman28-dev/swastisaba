<?php

use App\Http\Controllers\Api\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/district', [DataController::class, 'index']);
Route::get('/districts', [DataController::class, 'getProvince']);
Route::get('/indikator', [DataController::class, 'getIndikatorTatanan']);
Route::get('/odf', [DataController::class, 'getOdf']);

//odf
Route::get('/sendodfAllKabkota', [DataController::class, 'sendodfAllKabkota']);
Route::get('/sendodfperkabkota', [DataController::class, 'sendodfperkabkota']);

//list kabkota
Route::get('/kabkota', [DataController::class, 'kabkota']);

//kelembagaan
Route::get('/viewCapaiankelembagaan2024', [DataController::class, 'viewCapaiankelembagaan2024']);
Route::get('/viewCapaiankelembagaanMarged', [DataController::class, 'viewCapaiankelembagaanMarged']);


//indikator tatanan
Route::get('/viewTatanan', [DataController::class, 'viewTatanan']);
Route::get('/viewTatananPerkabkota2024', [DataController::class, 'viewTatananPerkabkota2024']);
Route::get('/viewTatananAllKabkota', [DataController::class, 'viewTatananAllKabkota']);
Route::get('/viewTatananPerkabkotaMerged', [DataController::class, 'viewTatananPerkabkotaMerged']);

