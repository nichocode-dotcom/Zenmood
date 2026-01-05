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
        // Menampilkan data khusus user yang login saja
        $moods = Mood::with(['emosi']) 
                     ->where('id_user', Auth::id()) 
                     ->orderBy('tanggal', 'desc')
                     ->orderBy('jam', 'desc')
                     ->paginate(10);

        return view('mood_tracker.index', compact('moods'));
    }

    public function create()
    {
        $listEmosi = Emosi::all(); 
        return view('mood.create', compact('listEmosi'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'id_emosi'           => 'required|exists:emosi,id_emosi',
            'id_aktivitas'       => 'required|integer', 
            'kategori_aktivitas' => 'required|string',
            'faktor_note'        => 'nullable|string',
            'hal_disyukuri'      => 'nullable|string',
            'faktor_sistem'      => 'nullable|string', // <--- TAMBAHAN PENTING: Validasi faktor_sistem
            'tanggal'            => 'nullable|date', 
        ]);

        // 2. Simpan Data ke Database
        Mood::create([
            'id_user'            => Auth::id(), // Data tiap user beda (ambil ID user login)
            'id_emosi'           => $validated['id_emosi'],
            'id_aktivitas'       => $validated['id_aktivitas'],
            'kategori_aktivitas' => $validated['kategori_aktivitas'],
            'faktor_note'        => $validated['faktor_note'],
            'hal_disyukuri'      => $validated['hal_disyukuri'],
            'faktor_sistem'      => $request->faktor_sistem, // <--- TAMBAHAN PENTING: Simpan data dari tombol faktor
            
            // Tanggal & Jam
            'tanggal'            => $request->tanggal ?? Carbon::now()->toDateString(),
            'jam'                => Carbon::now()->toTimeString(),
        ]);

        return redirect()->route('mood-tracker')->with('success', 'Mood berhasil dicatat!');
    }
}