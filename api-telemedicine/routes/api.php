<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/user', function (Request $request) {
    return $request->user();
  });

  Route::get('/doctors', [App\Http\Controllers\DoctorController::class, 'index']);
  Route::get('/doctors/{id}', [App\Http\Controllers\DoctorController::class, 'show']);
  // Route Appointment
  Route::get('/appointments', [App\Http\Controllers\AppointmentController::class, 'index']);
  Route::post('/appointments', [App\Http\Controllers\AppointmentController::class, 'store']);
  // Route Medical Record
  Route::post('/medical-records', [App\Http\Controllers\MedicalRecordController::class, 'store']);
  // Route Medicine
  Route::apiResource('medicines', App\Http\Controllers\MedicineController::class);
});
