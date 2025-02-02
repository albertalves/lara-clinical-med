<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CityController,
    ConsultationController,
    DoctorController,
    PatientController,
    AuthController
};

Route::get('cities', [CityController::class, 'index']);
Route::get('doctors', [DoctorController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('doctors', [DoctorController::class, 'store']);
    Route::post('doctors/consultation', [DoctorController::class, 'scheduleConsultation']);

    Route::get('patients', [PatientController::class, 'index']);
    Route::post('patients', [PatientController::class, 'store']);
    Route::put('patients', [PatientController::class, 'update']);

    Route::get('consultations', [ConsultationController::class, 'index']);
    Route::post('consultations', [ConsultationController::class, 'store']);

    Route::get('cities/{city_id}/doctors', [CityController::class, 'doctors']);
});

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});