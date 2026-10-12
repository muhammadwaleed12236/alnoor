<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicClinicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| Public Patient Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicClinicController::class, 'index'])->name('home');
Route::post('/book-appointment', [PublicClinicController::class, 'bookAppointment'])->name('public.book');
Route::get('/search-report', [PublicClinicController::class, 'searchReport'])->name('public.report.search');
Route::post('/quick-token', [PublicClinicController::class, 'quickToken'])->name('public.token.quick');

/*
|--------------------------------------------------------------------------
| Admin & Staff Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin & Staff Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Appointments & Token Slips
    Route::resource('appointments', AppointmentController::class)->except(['edit', 'update', 'show']);
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::get('/appointments/{appointment}/slip', [AppointmentController::class, 'printSlip'])->name('appointments.slip');

    // Live Reception OPD Queue Desk
    Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
    Route::post('/queue', [QueueController::class, 'store'])->name('queue.store');
    Route::patch('/queue/{tokenQueue}/cycle', [QueueController::class, 'cycleStatus'])->name('queue.cycle');
    Route::delete('/queue/{tokenQueue}', [QueueController::class, 'destroy'])->name('queue.destroy');

    // Diagnostic Reports (Lab, Ultrasound, ECG)
    Route::resource('diagnostics', DiagnosticController::class);

    // Pharmacy / Medical Store Stock
    Route::resource('pharmacy', PharmacyController::class)->only(['index', 'store', 'update', 'destroy']);

    // Doctors Roster & Timings
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::patch('/doctors/{doctor}/toggle', [DoctorController::class, 'toggle'])->name('doctors.toggle');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

    // Patients Registry
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
});
