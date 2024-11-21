<?php

use App\Http\Controllers\Answer_Doc_G_Data_Controller;
use App\Http\Controllers\Answer_Gambaran_Kabkota_Controller;
use App\Http\Controllers\Answer_KabKota_Controller;
use App\Http\Controllers\Answer_Kelembagaan_Controller;
use App\Http\Controllers\Answer_Kelembagaan_New_Controller;
use App\Http\Controllers\Answer_Pendanaan_Kabkota_Controller;
use App\Http\Controllers\Answer_Verifikator_Prov_Controller;
use App\Http\Controllers\Answer_Verifikator_Pusat_Controller;
use App\Http\Controllers\Category_Doc_Provinsi_Controller;
use App\Http\Controllers\Doc_Question_Controller;
use App\Http\Controllers\Gambaran_KabKota_Controller;
use App\Http\Controllers\General_Data_KabKota_Controller;
use App\Http\Controllers\Home_Controller;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\M_C_Kelembagaan_New_Controller;
use App\Http\Controllers\M_Category_Controller;
use App\Http\Controllers\M_Category_Kelembagaan_Controller;
use App\Http\Controllers\M_Doc_General_Data_Controller;
use App\Http\Controllers\M_General_Data_Controller;
use App\Http\Controllers\M_Group_Controller;
use App\Http\Controllers\M_Level_Controller;
use App\Http\Controllers\M_Q_Kelembagaan_New_Controller;
use App\Http\Controllers\M_Q_O_Kelembagaan_New_Controller;
use App\Http\Controllers\M_Question_Kelembagaan_Controller;
use App\Http\Controllers\M_Question_Option_Controller;
use App\Http\Controllers\M_Questions_Controller;
use App\Http\Controllers\M_Zona_Controller;
use App\Http\Controllers\Narasi_KabKota_Controller;
use App\Http\Controllers\Pendanaan_KabKota_Controller;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Set_Date_Controller;
use App\Http\Controllers\Setting_Time_Controller;
use App\Http\Controllers\Sub_Doc_Provinsi_Controller;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\Trans_Doc_Prov_Controller;
use App\Http\Controllers\Trans_Survey_H_Controller;
use App\Http\Controllers\User_Controller;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['middleware' => ['guest']], function () {
    /**
     * Register Routes
     */
    // Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    // Route::post('/register/perform', [RegisterController::class, 'register'])->name('register.perform');

    /**
     * Login Routes
     */
    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/unauthorized', function () {
        return view('errors.unauthorized');
    })->name('unauthorized');

    Route::get('/', [Home_Controller::class, 'showYear'])->name('home.showYear');
    Route::post('/set-year', [Home_Controller::class, 'sessionYear'])->name('home.store');
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');

    Route::group(['middleware' => ['checkSelectedYear']], function () {
        // Route::get('/dashboard', [Home_Controller::class, 'index2'])->name('home.index');
        Route::get('/dashboard', [Home_Controller::class, 'index'])->name('home.index');


        Route::get('/profile', [User_Controller::class, 'profile'])->name('user.profile');
        Route::get('/profile/update', [User_Controller::class, 'editProfile'])->name('user.editProfile');
        Route::put('/profile/update-profile', [User_Controller::class, 'updateProfile'])->name('user.updateProfile');
        Route::put('/profile/update-password', [User_Controller::class, 'updatePassword'])->name('user.updatePassword');
        Route::get('/profile/change-photo', [User_Controller::class, 'editPhoto'])->name('user.editPhoto');
        Route::post('/user/update-photo', [User_Controller::class, 'updatedPhoto'])->name('user.updatePhoto');
        Route::post('/user/reset-photo', [User_Controller::class, 'resetPhoto'])->name('user.resetPhoto');
        
        //set data
        Route::get('/set-date', [Set_Date_Controller::class, 'index'])->name('set-date.index');
        Route::post('/set-date/store', [Set_Date_Controller::class, 'store'])->name('set-date.store');

        Route::group(['middleware' => 'check.roles'], function () {
            Route::post('/dashboard/show-kabkota', [Home_Controller::class, 'showDistrict'])->name('home.showDistrict');
            Route::post('/dashboard/{id}/show-category', [Home_Controller::class, 'showCategory'])->name('home.showCategory');
            Route::get('/dashboard/show-kabkota/{id}', [Home_Controller::class, 'getDistrict'])->name('home.getDistrict');
        });

        Route::group(['middleware' => ['superadmin']], function () {

            Route::get('/category/trashed', [M_Category_Controller::class, 'onlyTrashed'])->name('category.onlyTrashed');
            Route::get('/category/restore/{id}', [M_Category_Controller::class, 'restore'])->name('category.restore');
            Route::get('/category/forcedelete/{id}', [M_Category_Controller::class, 'forceDelete'])->name('category.forceDelete');
            Route::resource('category', M_Category_Controller::class);

            //question
            Route::get('/questions/trashed', [M_Questions_Controller::class, 'onlyTrashed'])->name('questions.onlyTrashed');
            Route::get('/questions/restore/{id}', [M_Questions_Controller::class, 'restore'])->name('questions.restore');
            Route::get('/questions/forcedelete/{id}', [M_Questions_Controller::class, 'forceDelete'])->name('questions.forceDelete');
            Route::get('/questions/show-question/{id}', [M_Questions_Controller::class, 'showQuestion'])->name('showQuestionV1');
            // Route::get('/questions/show-question/{id}', [M_Questions_Controller::class, 'showQuestion2'])->name('showQuestionV1');

            Route::get('/questions/import/{id}', [M_Questions_Controller::class, 'import'])->name('questions.import');
            Route::post('/question/import', [M_Questions_Controller::class, 'importQuestion'])->name('questions.importQuestion');
            Route::resource('questions', M_Questions_Controller::class);
            Route::get('/questions/create/{id}', [M_Questions_Controller::class, 'create'])->name('questions.create');



            //option
            Route::get('/q-option/trashed', [M_Question_Option_Controller::class, 'onlyTrashed'])->name('q-option.onlyTrashed');
            Route::get('/q-option/restore/{id}', [M_Question_Option_Controller::class, 'restore'])->name('q-option.restore');
            Route::get('/q-option/forcedelete/{id}', [M_Question_Option_Controller::class, 'forceDelete'])->name('q-option.forceDelete');
            Route::get('/q-option/show-question-v2/{id}', [M_Question_Option_Controller::class, 'showQuestion'])->name('showQuestionV2');
            Route::get('/q-option/show-question-opt/{id}', [M_Question_Option_Controller::class, 'showQuestionOpt'])->name('showQuestionOpt');
            Route::get('/q-option/import/{id}', [M_Question_Option_Controller::class, 'import'])->name('q-option.import');
            Route::post('/q-option/import/{id}', [M_Question_Option_Controller::class, 'importQOption'])->name('q-option.importQOption');
            Route::resource('q-option', M_Question_Option_Controller::class);
            Route::get('/q-option/create/{id}', [M_Question_Option_Controller::class, 'create'])->name('q-option.create');


            //level
            Route::get('/level/trashed', [M_Level_Controller::class, 'onlyTrashed'])->name('level.onlyTrashed');
            Route::get('/level/restore/{id}', [M_Level_Controller::class, 'restore'])->name('level.restore');
            Route::get('/level/forcedelete/{id}', [M_Level_Controller::class, 'forceDelete'])->name('level.forceDelete');
            Route::resource('level', M_Level_Controller::class);

            //zona
            Route::get('/zona/trashed', [M_Zona_Controller::class, 'onlyTrashed'])->name('zona.onlyTrashed');
            Route::get('/zona/restore/{id}', [M_Zona_Controller::class, 'restore'])->name('zona.restore');
            Route::get('/zona/forcedelete/{id}', [M_Zona_Controller::class, 'forceDelete'])->name('zona.forceDelete');
            Route::resource('zona', M_Zona_Controller::class);

            //categori kelembagaan
            Route::get('/c-kelembagaan/trashed', [M_Category_Kelembagaan_Controller::class, 'onlyTrashed'])->name('c-kelembagaan.onlyTrashed');
            Route::get('/c-kelembagaan/restore/{id}', [M_Category_Kelembagaan_Controller::class, 'restore'])->name('c-kelembagaan.restore');
            Route::get('/c-kelembagaan/forcedelete/{id}', [M_Category_Kelembagaan_Controller::class, 'forceDelete'])->name('c-kelembagaan.forceDelete');
            Route::resource('c-kelembagaan', M_Category_Kelembagaan_Controller::class);


            //question kelembagaan
            Route::get('/q-kelembagaan/trashed', [M_Question_Kelembagaan_Controller::class, 'onlyTrashed'])->name('q-kelembagaan.onlyTrashed');
            Route::get('/q-kelembagaan/restore/{id}', [M_Question_Kelembagaan_Controller::class, 'restore'])->name('q-kelembagaan.restore');
            Route::get('/q-kelembagaan/forcedelete/{id}', [M_Question_Kelembagaan_Controller::class, 'forceDelete'])->name('q-kelembagaan.forceDelete');
            Route::get('/q-kelembagaan/show-q-kelembagaan/{id}', [M_Question_Kelembagaan_Controller::class, 'showQKelembagaan'])->name('showQKelembagaan');
            Route::resource('q-kelembagaan', M_Question_Kelembagaan_Controller::class);
            Route::get('/q-kelembagaan/create/{id}', [M_Question_Kelembagaan_Controller::class, 'create'])->name('q-kelembagaan.create');


            //general data
            Route::get('/g-data/show-g-data/{id}', [M_General_Data_Controller::class, 'showGData'])->name('showGData');
            Route::resource('g-data', M_General_Data_Controller::class);
            Route::get('/g-data/create/{id}', [M_General_Data_Controller::class, 'create'])->name('g-data.create');


            //group
            Route::get('/group/trashed', [M_Group_Controller::class, 'onlyTrashed'])->name('group.onlyTrashed');
            Route::get('/group/restore/{id}', [M_Group_Controller::class, 'restore'])->name('group.restore');
            Route::get('/group/forcedelete/{id}', [M_Group_Controller::class, 'forceDelete'])->name('group.forceDelete');
            Route::resource('group', M_Group_Controller::class);

            //periode data
            // Route::get('/trans-date/trashed', [Trans_Survey_H_Controller::class, 'onlyTrashed'])->name('trans-date.onlyTrashed');
            // Route::get('/trans-date/restore/{id}', [Trans_Survey_H_Controller::class, 'restore'])->name('trans-date.restore');
            // Route::get('/trans-date/forcedelete/{id}', [Trans_Survey_H_Controller::class, 'forceDelete'])->name('trans-date.forceDelete');
            Route::resource('trans-date', Trans_Survey_H_Controller::class);

            
            //users
            Route::get('/user/trashed', [User_Controller::class, 'onlyTrashed'])->name('user.onlyTrashed');
            Route::get('/user/restore/{id}', [User_Controller::class, 'restore'])->name('user.restore');
            Route::get('/user/forcedelete/{id}', [User_Controller::class, 'forceDelete'])->name('user.forceDelete');
            Route::post('/check-username', [User_Controller::class, 'checkUsername'])->name('user.checkUsername');
            Route::patch('/user/{id}/reset-password', [User_Controller::class, 'resetPassword'])->name('user.resetPassword');
            Route::get('/user/reset-session/{id}', [User_Controller::class, 'resetSession'])->name('user.resetSession');
            Route::resource('user', User_Controller::class);

            //document general data
            Route::get('/doc-g-data/trashed', [M_Doc_General_Data_Controller::class, 'onlyTrashed'])->name('doc-g-data.onlyTrashed');
            Route::get('/doc-g-data/restore/{id}', [M_Doc_General_Data_Controller::class, 'restore'])->name('doc-g-data.restore');
            Route::get('/doc-g-data/forcedelete/{id}', [M_Doc_General_Data_Controller::class, 'forceDelete'])->name('doc-g-data.forceDelete');
            Route::resource('doc-g-data', M_Doc_General_Data_Controller::class);

            //doc_prov
            Route::get('/c-doc-prov/trashed', [Category_Doc_Provinsi_Controller::class, 'onlyTrashed'])->name('c-doc-prov.onlyTrashed');
            Route::get('/c-doc-prov/restore/{id}', [Category_Doc_Provinsi_Controller::class, 'restore'])->name('c-doc-prov.restore');
            Route::get('/c-doc-prov/forcedelete/{id}', [Category_Doc_Provinsi_Controller::class, 'forceDelete'])->name('c-doc-prov.forceDelete');
            Route::resource('c-doc-prov', Category_Doc_Provinsi_Controller::class);
            
            
            //sub doc prov
            Route::get('/sub-doc-prov/trashed', [Sub_Doc_Provinsi_Controller::class, 'onlyTrashed'])->name('sub-doc-prov.onlyTrashed');
            Route::get('/sub-doc-prov/restore/{id}', [Sub_Doc_Provinsi_Controller::class, 'restore'])->name('sub-doc-prov.restore');
            Route::get('/sub-doc-prov/forcedelete/{id}', [Sub_Doc_Provinsi_Controller::class, 'forceDelete'])->name('sub-doc-prov.forceDelete');
            Route::get('/sub-doc-prov/show-sub-doc/{id}', [Sub_Doc_Provinsi_Controller::class, 'showSubDoc'])->name('showSubDoc');
            Route::resource('sub-doc-prov', Sub_Doc_Provinsi_Controller::class);
            Route::get('/sub-doc-prov/create/{id}', [Sub_Doc_Provinsi_Controller::class, 'create'])->name('sub-doc-prov.create');


            //doc question
            Route::get('/doc-question/trashed', [Doc_Question_Controller::class, 'onlyTrashed'])->name('doc-question.onlyTrashed');
            Route::get('/doc-question/restore/{id}', [Doc_Question_Controller::class, 'restore'])->name('doc-question.restore');
            Route::get('/doc-question/forcedelete/{id}', [Doc_Question_Controller::class, 'forceDelete'])->name('doc-question.forceDelete');
            Route::get('/doc-question/{id}', [Doc_Question_Controller::class, 'index'])->name('doc-question.index');
            Route::get('/doc-question/create/{id}', [Doc_Question_Controller::class, 'create'])->name('doc-question.create');
            Route::post('/doc-question/store', [Doc_Question_Controller::class, 'store'])->name('doc-question.store');
            Route::get('/doc-question/edit/{id}', [Doc_Question_Controller::class, 'edit'])->name('doc-question.edit');
            Route::patch('/doc-question/update/{id}', [Doc_Question_Controller::class, 'update'])->name('doc-question.update');
            Route::delete('/doc-question/delete/{id}', [Doc_Question_Controller::class, 'destroy'])->name('doc-question.destroy');
            Route::get('/doc-question/import/{id}', [Doc_Question_Controller::class, 'import'])->name('doc-question.import');
            Route::post('/doc-question/import/{id}', [Doc_Question_Controller::class, 'importDocQ'])->name('doc-question.importDocQ');
        
            
            //gambaran_kabkota
            Route::resource('gambaran-kabkota', Gambaran_KabKota_Controller::class);

            //pendanaan_kabkota
            Route::resource('pendanaan', Pendanaan_KabKota_Controller::class);

            //kelembagaan new
            Route::get('/c-kelembagaan-v2/trashed', [M_C_Kelembagaan_New_Controller::class, 'onlyTrashed'])->name('c-kelembagaan-v2.onlyTrashed');
            Route::get('/c-kelembagaan-v2/restore/{id}', [M_C_Kelembagaan_New_Controller::class, 'restore'])->name('c-kelembagaan-v2.restore');
            Route::get('/c-kelembagaan-v2/forcedelete/{id}', [M_C_Kelembagaan_New_Controller::class, 'forceDelete'])->name('c-kelembagaan-v2.forceDelete');
            Route::resource('c-kelembagaan-v2', M_C_Kelembagaan_New_Controller::class);


            //q kelembagaan new
            //kelembagaan new
            Route::get('/q-kelembagaan-v2/trashed', [M_Q_Kelembagaan_New_Controller::class, 'onlyTrashed'])->name('q-kelembagaan-v2.onlyTrashed');
            Route::get('/q-kelembagaan-v2/restore/{id}', [M_Q_Kelembagaan_New_Controller::class, 'restore'])->name('q-kelembagaan-v2.restore');
            Route::get('/q-kelembagaan-v2/forcedelete/{id}', [M_Q_Kelembagaan_New_Controller::class, 'forceDelete'])->name('q-kelembagaan-v2.forceDelete');
            Route::get('/q-kelembagaan-v2/show-q-kelembagaan-v2/{id}', [M_Q_Kelembagaan_New_Controller::class, 'showQKelembagaanNew'])->name('showQKelembagaanNew');
            Route::resource('q-kelembagaan-v2', M_Q_Kelembagaan_New_Controller::class);
            Route::get('/q-kelembagaan-v2/create/{id}', [M_Q_Kelembagaan_New_Controller::class, 'create'])->name('q-kelembagaan-v2.create');


            //option kelembagaan
            Route::get('/q-opt-kelembagaan/{id}', [M_Q_O_Kelembagaan_New_Controller::class, 'index'])->name('q-opt-kelembagaan.index');
            Route::get('/q-opt-kelembagaan/create/{id}', [M_Q_O_Kelembagaan_New_Controller::class, 'create'])->name('q-opt-kelembagaan.create');
            Route::post('/q-opt-kelembagaan/store', [M_Q_O_Kelembagaan_New_Controller::class, 'store'])->name('q-opt-kelembagaan.store');
            Route::get('/q-opt-kelembagaan/edit/{id}', [M_Q_O_Kelembagaan_New_Controller::class, 'edit'])->name('q-opt-kelembagaan.edit');
            Route::delete('/q-opt-kelembagaan/destroy/{id}', [M_Q_O_Kelembagaan_New_Controller::class,'destroy'])->name('q-opt-kelembagaan.destroy');
            Route::patch('/q-opt-kelembagaan/update/{id}', [M_Q_O_Kelembagaan_New_Controller::class, 'update'])->name('q-opt-kelembagaan.update');
            
            // Route::resource('q-opt-kelembagaan', M_Q_O_Kelembagaan_New_Controller::class);
            
            Route::resource('schedule', Setting_Time_Controller::class);
            Route::get('/schedule/create/{id}', [Setting_Time_Controller::class, 'create'])->name('schedule.create');
        });

        Route::group(['middleware' => ['operator_kab_kota']], function () {
            // Route::get('testing-data', [TestingController::class,'index'])->name('testing.index');
            Route::get('kabkota/answer-data', [Answer_KabKota_Controller::class,'index'])->name('answer-data.index');
            Route::get('kabkota/answer-data/show-ans-data/{id}', [Answer_KabKota_Controller::class, 'show'])->name('answer-data.show');
            // Route::post('kabkota/answer-data/create/{id}', [Answer_KabKota_Controller::class,'store'])->name('answer-data.store');
            Route::post('kabkota/answer-data/create/{id}', [Answer_KabKota_Controller::class,'store2'])->name('answer-data.store');
            Route::delete('kabkota/answer-data/destroydoc/{id}', [Answer_KabKota_Controller::class, 'destroyDoc'])->name('answer-data.destroyDoc');

            //data umum
            Route::get('kabkota/g-data', [General_Data_KabKota_Controller::class,'index'])->name('g-data.indexKabKota');
            Route::get('kabkota/g-data/edit/{id}', [General_Data_KabKota_Controller::class,'edit'])->name('g-data.editKabKota');
            Route::get('kabkota/g-data/create', [General_Data_KabKota_Controller::class,'create'])->name('g-data.createKabKota');
            Route::post('kabkota/g-data/store', [General_Data_KabKota_Controller::class,'store'])->name('g-data.storeKabKota');
            Route::put('kabkota/g-data/update/{id}', [General_Data_KabKota_Controller::class,'update'])->name('g-data.updateKabKota');

            //doc data umum
            Route::get('kabkota/doc-g-data', [Answer_Doc_G_Data_Controller::class,'index'])->name('doc-g-data.indexKabKota');
            Route::post('kabkota/doc-g-data/store/{id}', [Answer_Doc_G_Data_Controller::class,'store'])->name('doc-g-data.storeKabKota');
            Route::delete('kabkota/doc-g-data/destroy/{id}', [Answer_Doc_G_Data_Controller::class,'destroy'])->name('doc-g-data.destroyKabKota');


            //data kelembagaan
            // Route::get('kabkota/kelembagaan', [Answer_KabKota_Controller::class,'index'])->name('answer-data.index');
            Route::get('kabkota/kelembagaan/show-k-data/{id}', [Answer_Kelembagaan_Controller::class, 'show'])->name('kelembagaan.showKabKota');
            Route::post('kabkota/kelembagaan/storedoc/{id}', [Answer_Kelembagaan_Controller::class, 'storeDoc'])->name('kelembagaan.storeDoc');
            Route::delete('kabkota/kelembagaan/destroydoc/{id}', [Answer_Kelembagaan_Controller::class,'destroyDoc'])->name('kelembagaan.destroyDoc');
            Route::post('kabkota/kelembagaan/store/{id}', [Answer_Kelembagaan_Controller::class,'store'])->name('kelembagaan.store');
            Route::put('kabkota/kelembagaan/update/{id}', [Answer_Kelembagaan_Controller::class,'update'])->name('kelembagaan.update');
            
            //gambaran umum
            Route::get('kabkota/doc-g-umum', [Answer_Gambaran_Kabkota_Controller::class,'index'])->name('doc-g-umum.index');
            Route::post('kabkota/doc-g-umum/storedoc/{id}', [Answer_Gambaran_Kabkota_Controller::class, 'store'])->name('doc-g-umum.store');
            Route::delete('kabkota/doc-g-umum/destroy/{id}', [Answer_Gambaran_Kabkota_Controller::class,'destroy'])->name('doc-g-umum.destroy');


            //pendanaan
            Route::get('kabkota/pendanaan-kabkota', [Answer_Pendanaan_Kabkota_Controller::class,'index'])->name('pendanaan-kabkota.index');
            Route::post('kabkota/pendanaan-kabkota/storedoc/{id}', [Answer_Pendanaan_Kabkota_Controller::class, 'store'])->name('pendanaan-kabkota.store');
            Route::delete('kabkota/pendanaan-kabkota/destroy/{id}', [Answer_Pendanaan_Kabkota_Controller::class,'destroy'])->name('pendanaan-kabkota.destroy');


            //kelembagaan
            Route::get('kabkota/kelembagaan-v2/show-k-data/{id}', [Answer_Kelembagaan_New_Controller::class, 'show'])->name('kelembagaan-v2.show');
            Route::post('kabkota/kelembagaan-v2/create/{id}', [Answer_Kelembagaan_New_Controller::class,'store'])->name('kelembagaan-v2.store');
            Route::delete('kabkota/kelembagaan-v2/destroydoc/{id}', [Answer_Kelembagaan_New_Controller::class, 'destroyDoc'])->name('answer-data.destroyDoc');
            

            //activity
            Route::post('kabkota/kelembagaan-v2/activity/create/{id}', [Answer_Kelembagaan_New_Controller::class,'storeActivity'])->name('kelembagaan-v2.storeActivity');
            Route::delete('kabkota/kelembagaan-v2/activity/destroy/{id}', [Answer_Kelembagaan_New_Controller::class, 'destroyActivity'])->name('kelembagaan-v2.destroyActivity');
            Route::get('kabkota/kelembagaan-v2/activity/edit/{id}', [Answer_Kelembagaan_New_Controller::class, 'editActivity'])->name('kelembagaan-v2.editActivity');
            Route::put('kabkota/kelembagaan-v2/activity/update/{id}', [Answer_Kelembagaan_New_Controller::class,'updateActivity'])->name('kelembagaan-v2.updateActivity');

            //forum kec
            Route::post('kabkota/kelembagaan-v2/forum-kec/create/{id}', [Answer_Kelembagaan_New_Controller::class,'storeForumKec'])->name('kelembagaan-v2.storeForumKec');
            Route::delete('kabkota/kelembagaan-v2/forum-kec/destroy/{id}', [Answer_Kelembagaan_New_Controller::class, 'destroyForumKec'])->name('kelembagaan-v2.destroyForumKec');
            Route::get('kabkota/kelembagaan-v2/forum-kec/edit/{id}', [Answer_Kelembagaan_New_Controller::class, 'editForumKec'])->name('kelembagaan-v2.editForumKec');
            Route::get('kabkota/kelembagaan-v2/{id}/forum-kec/create-v2/{id_sub}', [Answer_Kelembagaan_New_Controller::class, 'createForumKec'])->name('kelembagaan-v2.createForumKec');
            
            Route::put('kabkota/kelembagaan-v2/forum-kec/update/{id}', [Answer_Kelembagaan_New_Controller::class,'updateForumKec'])->name('kelembagaan-v2.updateForumKec');
            
            //forum kel
            Route::post('kabkota/kelembagaan-v2/pokja-desa/create/{id}', [Answer_Kelembagaan_New_Controller::class,'storeForumDesa'])->name('kelembagaan-v2.storeForumDesa');
            Route::delete('kabkota/kelembagaan-v2/pokja-desa/destroy/{id}', [Answer_Kelembagaan_New_Controller::class, 'destroyForumDesa'])->name('kelembagaan-v2.destroyForumDesa');
            Route::get('kabkota/kelembagaan-v2/pokja-desa/edit/{id}', [Answer_Kelembagaan_New_Controller::class, 'editForumDesa'])->name('kelembagaan-v2.editForumDesa');
            Route::put('kabkota/kelembagaan-v2/pokja-desa/update/{id}', [Answer_Kelembagaan_New_Controller::class,'updateForumDesa'])->name('kelembagaan-v2.updateForumDesa');
        
            //narasi tatanan
            Route::get('kabkota/narasi-tatanan/', [Narasi_KabKota_Controller::class, 'index'])->name('narasi-tatanan.index');
            Route::post('kabkota/narasi-tatanan/create/{id}', [Narasi_KabKota_Controller::class,'store'])->name('narasi-tatanan.store');
            Route::delete('kabkota/narasi-tatanan/destroy/{id}', [Narasi_KabKota_Controller::class, 'destroy'])->name('narasi-tatanan.destroy');

            //act kec
            Route::get('kabkota/act-kec/{id}/{id_sub}', [Answer_Kelembagaan_New_Controller::class, 'createActivityKec'])->name('act-kec.createActivityKec');
            Route::post('kabkota/act-kec/create/{id}', [Answer_Kelembagaan_New_Controller::class,'storeActivityKec'])->name('act-kec.storeActivityKec');

            //pokja desa
            Route::get('kabkota/pokja-desa/{id_c_kelembagaan}/{id_subdistrict}', [Answer_Kelembagaan_New_Controller::class, 'showPokjaDesa'])->name('pokja-desa.showPokjaDesa');
            Route::get('kabkota/pokja-desa/create-sk/{id_c_kelembagaan}/{id_village}', [Answer_Kelembagaan_New_Controller::class, 'createSkPokjaDesa'])->name('pokja-desa.createSkPokjaDesa');
            Route::get('kabkota/pokja-desa/edit-sk/{id_value}/{id_village}', [Answer_Kelembagaan_New_Controller::class, 'editSkPokjaDesa'])->name('pokja-desa.editSkPokjaDesa');
            Route::post('kabkota/pokja-desa/store-sk/{id}',  [Answer_Kelembagaan_New_Controller::class,'storeSKPokjaDesa'])->name('pokja-desa.storeSKPokjaDesa');
            Route::put('kabkota/pokja-desa/update-sk/{id}', [Answer_Kelembagaan_New_Controller::class,'updateSKPokjaDesa'])->name('pokja-desa.updateSKPokjaDesa');
            Route::delete('kabkota/pokja-desa/delete-sk/{id}', [Answer_Kelembagaan_New_Controller::class, 'destroyPokjaDesa'])->name('pokja-desa.destroyPokjaDesa');
            
            //act pokja
            Route::get('kabkota/pokja-desa/create-act/{id_c_kelembagaan}/{id_village}', [Answer_Kelembagaan_New_Controller::class, 'createActivityPokja'])->name('pokja-desa.createActivityPokja');
            Route::post('kabkota/pokja-desa/store-act/{id}', [Answer_Kelembagaan_New_Controller::class,'storeActivityPokja'])->name('pokja-desa.storeActivityPokja');
            Route::get('kabkota/pokja-desa/edit-act/{id_value}/{id_village}', [Answer_Kelembagaan_New_Controller::class, 'editActivityPokja'])->name('pokja-desa.editActivityPokja');
            Route::put('kabkota/pokja-desa/update-act/{id}', [Answer_Kelembagaan_New_Controller::class,'updateActivityPokjaDesa'])->name('pokja-desa.updateActivityPokjaDesa');

            // Route::get('kabkota/pokja-desa/create-act/{id_c_kelembagaan}/{id_village}', [Answer_Kelembagaan_New_Controller::class, 'createActivityPokja'])->name('act-pokja.createActivityPokja');
            
            //export pdf
            Route::get('/export-tatanan-pdf/{id}', [Answer_KabKota_Controller::class,'exportPDF'])->name('answer.exportPDF');
            Route::get('/export-all-tatanan-pdf', [Answer_KabKota_Controller::class,'exportAllCategory'])->name('answer.exportAllCategory');


        });

        Route::group(['middleware' => ['operator_provinsi']], function (){
            Route::get('/o-prov/doc-prov/get/{id}', [Trans_Doc_Prov_Controller::class, 'show'])->name('doc-prov.show');
            Route::post('/o-prov/doc-prov/store/{id}', [Trans_Doc_Prov_Controller::class,'store'])->name('doc-prov.store');
            Route::delete('/o-prov/doc-prov/destroydoc/{id}', [Trans_Doc_Prov_Controller::class,'destroy'])->name('doc-prov.destroy');

        });

        Route::group(['middleware' => ['v_provinsi']], function (){
            Route::get('/v-prov/kabkota/{id}/answer-data', [Answer_Verifikator_Prov_Controller::class, 'index'])->name('v-prov.index');
            Route::get('/v-prov/kabkota/{id_zona}/category/{id}', [Answer_Verifikator_Prov_Controller::class, 'showCategory'])->name('v-prov.showCategory');
            Route::post('v-prov/kabkota/{id_zona}/store-answer/{id}',[Answer_Verifikator_Prov_Controller::class, 'store'])->name('v-prov.store');

            //data_kelembagaan
            Route::get('/v-prov/kabkota/{id}/c-kelembagaan', [Answer_Verifikator_Prov_Controller::class, 'indexKelembagaan'])->name('v-prov.indexKelembagaan');
            Route::get('/v-prov/kabkota/{id_zona}/c-kelembagaan/{id}', [Answer_Verifikator_Prov_Controller::class, 'showKelembagaan'])->name('v-prov.showKelembagaan');
            Route::post('/v-prov/kabkota/{id_zona}/store-kelembagaan/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeKelembagaan'])->name('v-prov.storeKelembagaan');


            //data_umum
            Route::get('/v-prov/kabkota/{id}/general-data', [Answer_Verifikator_Prov_Controller::class, 'indexGData'])->name('v-prov.indexGData');
            Route::post('/v-prov/kabkota/{id_zona}/store-gdata/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeGdata'])->name('v-prov.storeGdata');
            
            //gambaran umum
            Route::get('/v-prov/kabkota/{id}/general-data', [Answer_Verifikator_Prov_Controller::class, 'indexGData'])->name('v-prov.indexGData');
            Route::post('/v-prov/kabkota/store-gdata/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeGData'])->name('v-prov.storeGData');


            //pendanaan
            Route::get('/v-prov/kabkota/{id}/pendanaan', [Answer_Verifikator_Prov_Controller::class, 'indexPendanaan'])->name('v-prov.indexPendanaan');
            Route::post('/v-prov/kabkota/pendanaan/{id}',[Answer_Verifikator_Prov_Controller::class, 'storePendanaan'])->name('v-prov.storePendanaan');

            //narasi tatanan
            Route::get('/v-prov/kabkota/{id}/narasi-tatanan', [Answer_Verifikator_Prov_Controller::class, 'indexNarasi'])->name('v-prov.indexNarasi');
            Route::post('/v-prov/kabkota/narasi-tatanan/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeNarasi'])->name('v-prov.storeNarasi');

            //activity
            Route::post('/v-prov/kabkota/store-activity/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeActivity'])->name('v-prov.storeActivity');

            //sk kec
            Route::post('/v-prov/kabkota/store-skkec/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeSKKec'])->name('v-prov.storeSKKec');

            //pokja
            Route::get('/v-prov/pokja-desa/{id_c_kelembagaan}/{id_subdistrict}', [Answer_Verifikator_Prov_Controller::class, 'showPokjaDesa'])->name('v-prov.showPokjaDesa');
            Route::post('/v-prov/kabkota/store-skpokja/{id}',[Answer_Verifikator_Prov_Controller::class, 'storeSKPokja'])->name('v-prov.storeSKPokja');

            // Route::get('/v-prov/kabkota/{id}/general-data', [Answer_Verifikator_Prov_Controller::class, 'indexGData'])->name('v-prov.indexGData');

        });

        Route::group(['middleware' => ['v_pusat']], function (){
            Route::get('/v-pusat/kabkota/{id}/answer-data', [Answer_Verifikator_Pusat_Controller::class, 'indexQuestion'])->name('v-pusat.indexQuestion');
            Route::get('/v-pusat/kabkota/{id_zona}/category/{id}', [Answer_Verifikator_Pusat_Controller::class, 'showCategory'])->name('v-pusat.showCategory');
            Route::post('/v-pusat/kabkota/{id_zona}/store-answer/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeQuestion'])->name('v-pusat.storeQuestion');


            //kelembagaan
            // Route::get('/v-pusat/kabkota/{id}/c-kelembagaan', [Answer_Verifikator_Pusat_Controller::class, 'indexKelembagaan'])->name('v-pusat.indexKelembagaan');
            // Route::get('/v-pusat/kabkota/{id_zona}/c-kelembagaan/{id}', [Answer_Verifikator_Pusat_Controller::class, 'showKelembagaan'])->name('v-pusat.showKelembagaan');
            // Route::post('/v-pusat/kabkota/{id_zona}/store-kelembagaan/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeKelembagaan'])->name('v-pusat.storeKelembagaan');
            
            //new kelambagaan
            Route::get('/v-pusat/kabkota/{id}/c-kelembagaan', [Answer_Verifikator_Pusat_Controller::class, 'indexKelembagaan'])->name('v-pusat.indexKelembagaan');
            Route::get('/v-pusat/kabkota/{id_zona}/c-kelembagaan/{id}', [Answer_Verifikator_Pusat_Controller::class, 'showKelembagaan'])->name('v-pusat.showKelembagaan');
            Route::post('/v-pusat/kabkota/{id_zona}/store-kelembagaan/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeKelembagaan'])->name('v-pusat.storeKelembagaan');
            Route::get('/v-pusat/pokja-desa/{id_c_kelembagaan}/{id_subdistrict}', [Answer_Verifikator_Pusat_Controller::class, 'showPokjaDesa'])->name('v-pusat.showPokjaDesa');


            //activity
            Route::post('/v-pusat/kabkota/store-activity/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeActivity'])->name('v-pusat.storeActivity');

            //SK Desa/Kel
            Route::post('/v-pusat/kabkota/store-skpokja/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeSKPokja'])->name('v-pusat.storeSKPokja');

            //SK Kec
            Route::post('/v-pusat/kabkota/store-skkec/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeSKKec'])->name('v-pusat.storeSKKec');


            //gambaran umum
            Route::get('/v-pusat/kabkota/{id}/general-data', [Answer_Verifikator_Pusat_Controller::class, 'indexGData'])->name('v-pusat.indexGData');
            Route::post('/v-pusat/kabkota/store-gdata/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeGData'])->name('v-pusat.storeGData');

            //pendanaan
            Route::get('/v-pusat/kabkota/{id}/pendanaan', [Answer_Verifikator_Pusat_Controller::class, 'indexPendanaan'])->name('v-pusat.indexPendanaan');
            Route::post('/v-pusat/kabkota/pendanaan/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storePendanaan'])->name('v-pusat.storePendanaan');

            //narasi tatanan
            Route::get('/v-pusat/kabkota/{id}/narasi-tatanan', [Answer_Verifikator_Pusat_Controller::class, 'indexNarasi'])->name('v-pusat.indexNarasi');
            Route::post('/v-pusat/kabkota/narasi-tatanan/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeNarasi'])->name('v-pusat.storeNarasi');


            //doc prov
            Route::get('/v-pusat/doc-prov/{id}/data', [Answer_Verifikator_Pusat_Controller::class, 'showDocProv'])->name('v-pusat.showDocProv');
            Route::post('/v-pusat/doc-prov/store-dataprov/{id}',[Answer_Verifikator_Pusat_Controller::class, 'storeDataProv'])->name('v-pusat.storeDataProv');


            // Route::get('/o-prov/doc-prov/get/{id}', [Trans_Doc_Prov_Controller::class, 'show'])->name('doc-prov.show');

        });

        


    });
        
    
    //testing

    // Route::prefix('home')->group(function () {

    // });
});

//home

