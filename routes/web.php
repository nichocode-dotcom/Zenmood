<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackRecordController;
use App\Http\Controllers\AboutController;

Route::get('/', function () {
    return view('welcome'); // Ini file untuk beranda
})->name('home');

Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record');
Route::get('/about', [AboutController::class, 'index'])->name('about');

