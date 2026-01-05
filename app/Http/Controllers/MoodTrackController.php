<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mood;
use App\Models\Emosi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoodTrackController extends Controller
{
    public function index()
    {
        // 1. PERBAIKAN: Ambil tanggal dari session (agar sinkron dengan Track Record)
        // Jika tidak ada session, default ke hari ini.
        $date = session('selected_date', Carbon::now()->format('Y-m-d'));

        $moods = Mood::with(['emosi']) 
                     ->where('id_user', Auth::id()) 
                     ->whereDate('tanggal', $date) // Sekarang $date sudah terdefinisi
                     ->latest('jam')
                     ->paginate(10);

        return view('mood_tracker.index', compact('moods', 'date'));
    }

    public function create()
    {
        $listEmosi = Emosi::all(); 
        return view('mood.create', compact('listEmosi'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'id_emosi'           => 'required|exists:emosi,id_emosi',
            'id_aktivitas'       => 'required|integer', 
            'kategori_aktivitas' => 'required|string',
            'faktor_note'        => 'nullable|string',
            'faktor_sistem'      => 'nullable|string', // Pastikan ini ada agar faktor tersimpan
            'hal_disyukuri'      => 'nullable|string',
            'tanggal'            => 'nullable|date', 
        ]);

        // 2. PERBAIKAN LOGIKA SKOR (PENTING UNTUK GRAFIK)
        // Mapping skor agar grafik batang muncul (tidak 0/null)
        $skorMap = [
            1 => 10, // Sangat Bahagia
            2 => 8,  // Senang
            3 => 6,  // Biasa Saja
            4 => 4,  // Cemas
            5 => 2,  // Sangat Sedih
            6 => 1,  // Marah
        ];
        
        $emosiId = (int) $validated['id_emosi'];
        $skorValue = $skorMap[$emosiId] ?? 5; // Default 5

        // Tentukan tanggal input
        $inputDate = $request->tanggal ?? Carbon::now('Asia/Jakarta')->toDateString();

        // 3. Simpan Data
        Mood::create([
            'id_user'            => Auth::id(),
            'id_emosi'           => $validated['id_emosi'],
            'id_aktivitas'       => $validated['id_aktivitas'],
            'kategori_aktivitas' => $validated['kategori_aktivitas'],
            'faktor_note'        => $validated['faktor_note'],
            'faktor_sistem'      => $request->input('faktor_sistem'), // Ambil dari request
            'hal_disyukuri'      => $validated['hal_disyukuri'],
            'skor'               => $skorValue, // Simpan Skor
            
            'tanggal'            => $inputDate,
            'jam'                => Carbon::now('Asia/Jakarta')->toTimeString(),
        ]);

        // 4. PERBAIKAN SESSION (PENTING UNTUK HEALING PLAN)
        // Update session agar saat redirect, Healing Plan langsung tahu tanggal yang baru diinput
        session(['selected_date' => $inputDate]);

        // Redirect ke Healing Plan agar user langsung melihat rekomendasi
        return redirect()->route('healing-plan')->with('success', 'Mood berhasil dicatat! Cek rekomendasi kegiatanmu.');
    }
}