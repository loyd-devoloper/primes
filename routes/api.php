<?php

use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\RSAController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->prefix('recruitment')->group(function(){
    Route::get('jobs',[RecruitmentController::class,'getJobs']);
    Route::get('job',[RecruitmentController::class,'getJob']);
    Route::post('submit/application',[RecruitmentController::class,'storeApplication']);
    Route::post('update/application/{applicant_id}',[RecruitmentController::class,'updateApplication']);
    Route::post('my_application/{application_code}',[RecruitmentController::class,'viewApplicantApplication']);
});
