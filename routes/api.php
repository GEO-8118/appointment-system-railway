<?php

use App\Http\Controllers\Api\AppointmentApiController;
use Illuminate\Support\Facades\Route;

// Decoupled Functional RESTful Architecture Pipelines
Route::get('/appointments', [AppointmentApiController::class, 'index']);
Route::post('/appointments', [AppointmentApiController::class, 'store']);
Route::put('/appointments/{id}', [AppointmentApiController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentApiController::class, 'destroy']);