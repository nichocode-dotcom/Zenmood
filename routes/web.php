<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mood-tracker', function () {
    return view('mood_tracker.index');
});