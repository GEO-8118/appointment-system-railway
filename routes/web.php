<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');

    Route::get('/admin/calendar', [AdminController::class, 'calendar'])->name('admin.calendar');

    Route::get('/appointments/book', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::get('/appointments/export/json', [AppointmentController::class, 'exportJson'])->name('reports.exportJson');

    Route::post('/services/import/csv', [AppointmentController::class, 'importCsv'])->name('services.importCsv');

    Route::post('/services/add', [AppointmentController::class, 'addService'])->name('services.add');
});