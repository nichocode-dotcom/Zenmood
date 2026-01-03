<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackRecordController;
// use App\Http\Controllers\AboutController;
use App\Http\Controllers\HabitLogController;
use App\Http\Controllers\HealingPlanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/habit-log', [HabitLogController::class, 'index'])->name('habit-log');
Route::post('/habit-log/toggle', [HabitLogController::class, 'toggle'])->name('habit-log.toggle');
Route::post('/habit-log/store', [HabitLogController::class, 'store'])->name('habit-log.store');
Route::get('/healing-plan', [HealingPlanController::class, 'index'])->name('healing-plan');
Route::post('/healing-pilih', [HealingPlanController::class, 'pilih'])->name('healing.pilih');

