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
        $validated = $request->validate([
            'id_emosi'           => 'required|exists:emosi,id_emosi',
            'id_aktivitas'       => 'required|integer', 
            'kategori_aktivitas' => 'required|string',
            'faktor_note'        => 'nullable|string',
            'faktor_sistem'      => 'nullable|string', 
            'hal_disyukuri'      => 'nullable|string',
            'tanggal'            => 'nullable|date', 
        ]);

        $skorMap = [
            1 => 10, 
            2 => 8,  
            3 => 6,  
            4 => 4,  
            5 => 2,  
            6 => 1,  
        ];
        
        $emosiId = (int) $validated['id_emosi'];
        $skorValue = $skorMap[$emosiId] ?? 5; 

        $inputDate = $request->tanggal ?? Carbon::now('Asia/Jakarta')->toDateString();

        Mood::create([
            'id_user'            => Auth::id(),
            'id_emosi'           => $validated['id_emosi'],
            'id_aktivitas'       => $validated['id_aktivitas'],
            'kategori_aktivitas' => $validated['kategori_aktivitas'],
            'faktor_note'        => $validated['faktor_note'],
            'faktor_sistem'      => $request->input('faktor_sistem'), 
            'hal_disyukuri'      => $validated['hal_disyukuri'],
            'skor'               => $skorValue, 
            
            'tanggal'            => $inputDate,
            'jam'                => Carbon::now('Asia/Jakarta')->toTimeString(),
        ]);

        session(['selected_date' => $inputDate]);

        return redirect()->route('healing-plan')->with('success', 'Mood berhasil dicatat! Cek rekomendasi kegiatanmu.');
    }
}