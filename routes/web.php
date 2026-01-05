<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackRecordController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HabitLogController;
// Import dari branch journaling
use App\Http\Controllers\JournalController;
// Import dari branch main (Auth)
use App\Http\Controllers\auth\login as LoginController;
use App\Http\Controllers\auth\register as RegisterController;
use App\Http\Controllers\HealingPlanController;
use App\Http\Controllers\MoodTrackController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Hanya untuk Guest/Tamu yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// Logout (Hanya untuk user yang sudah login)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Hanya untuk user yang SUDAH LOGIN)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
    Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/track-record/cetak-pdf', [App\Http\Controllers\TrackRecordController::class, 'cetakPdf'])->name('track-record.cetak');

    Route::get('/habit-log', [HabitLogController::class, 'index'])->name('habit-log');
    Route::post('/habit-log/toggle', [HabitLogController::class, 'toggle'])->name('habit-log.toggle');
    Route::post('/habit-log/store', [HabitLogController::class, 'store'])->name('habit-log.store');
    Route::get('/healing-plan', [HealingPlanController::class, 'index'])->name('healing-plan');
    Route::post('/healing-pilih', [HealingPlanController::class, 'pilih'])->name('healing.pilih');
    Route::post('/healing-plan/toggle', [HealingPlanController::class, 'toggleActivity'])->name('healing.toggle');
    Route::post('/healing-plan/save-progress', [App\Http\Controllers\HealingPlanController::class, 'saveProgress'])->name('healing.save');
    // Route Tampilan (GET)
    Route::get('/mood-tracker', [MoodTrackController::class, 'index'])->name('mood-tracker');

    // Route Simpan Data (POST) - Tambahkan ini!
    Route::post('/mood-tracker', [MoodTrackController::class, 'store'])->name('mood.store');

    Route::get('/journaling', [JournalController::class, 'index'])->name('journaling.index');
    Route::post('/journaling', [JournalController::class, 'store'])->name('journaling.store');
});