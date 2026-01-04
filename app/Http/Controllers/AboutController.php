<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Masukkan codingan di sini (di dalam kurung kurawal class)
    
    public function index()
    {
        // Fungsi ini bertugas memanggil tampilan (view) about
        return view('about.index');
    }
}