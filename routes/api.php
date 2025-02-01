<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CityController,
    ConsultationController,
    DoctorController,
    PatientController
};

Route::apiResource('cities', CityController::class);
Route::apiResource('doctors', DoctorController::class);
Route::apiResource('patients', PatientController::class);
Route::apiResource('consultations', ConsultationController::class);