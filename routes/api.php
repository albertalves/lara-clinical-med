<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CityController,
    DoctorController,
    PatientController,
    AuthController
};

Route::get('cities', [CityController::class, 'index']);
Route::get('doctors', [DoctorController::class, 'index']);
Route::get('patients', [PatientController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('doctors', [DoctorController::class, 'store']);
    Route::post('doctors/consultation', [DoctorController::class, 'scheduleConsultation']);
    Route::get('doctors/{doctorId}/patients', [DoctorController::class, 'patients']);

    Route::post('patients', [PatientController::class, 'store']);
    Route::put('patients/{patientId}', [PatientController::class, 'update']);

    Route::get('cities/{cityId}/doctors', [CityController::class, 'doctors']);
});

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});