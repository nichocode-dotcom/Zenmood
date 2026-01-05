<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackRecordController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HabitLogController;
use App\Http\Controllers\auth\login as LoginController;
use App\Http\Controllers\auth\register as RegisterController;
use App\Http\Controllers\HealingPlanController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Guest only - redirect if already logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// Logout (must be authenticated)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (must be authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/habit-log', [HabitLogController::class, 'index'])->name('habit-log');
    Route::post('/habit-log/toggle', [HabitLogController::class, 'toggle'])->name('habit-log.toggle');
    Route::post('/habit-log/store', [HabitLogController::class, 'store'])->name('habit-log.store');
    Route::get('/healing-plan', [HealingPlanController::class, 'index'])->name('healing-plan');
    Route::post('/healing-pilih', [HealingPlanController::class, 'pilih'])->name('healing.pilih');
    Route::post('/healing-plan/toggle', [HealingPlanController::class, 'toggleActivity'])->name('healing.toggle');
    Route::post('/healing-plan/save-progress', [App\Http\Controllers\HealingPlanController::class, 'saveProgress'])->name('healing.save');

});
