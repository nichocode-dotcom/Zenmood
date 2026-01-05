<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mood;
use App\Models\Emosi;
use App\Models\MasterAktivitas; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoodTrackController extends Controller
{
    public function index()
    {
        
        $date = session('selected_date', Carbon::now()->format('Y-m-d'));

        $moods = Mood::with(['emosi']) // Load relasi emosi
                     ->where('id_user', Auth::id()) 
                     ->whereDate('tanggal', $date)
                     ->latest('jam')
                     ->latest('tanggal')
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
        // 1. Validasi input
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

        $skorValue = $skorMap[$validated['id_emosi']] ?? 5; 

        Mood::create([
            'id_user'            => Auth::id(), 
            'id_emosi'           => $validated['id_emosi'],
            'id_aktivitas'       => $validated['id_aktivitas'],
            'kategori_aktivitas' => $validated['kategori_aktivitas'],
            'faktor_note'        => $validated['faktor_note'],
            'faktor_sistem'      => $request->input('faktor_sistem'), // Ambil input faktor sistem
            'hal_disyukuri'      => $validated['hal_disyukuri'],
            'skor'               => $skorValue, // SIMPAN SKOR DISINI
            
            
            'tanggal'            => $request->tanggal ?? Carbon::now('Asia/Jakarta')->toDateString(),
            'jam'                => Carbon::now('Asia/Jakarta')->toTimeString(),
        ]);

        return redirect()->route('track-record')->with('success', 'Mood berhasil dicatat!');
    }
}