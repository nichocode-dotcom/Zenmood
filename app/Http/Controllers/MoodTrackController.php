<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mood;
use App\Models\Emosi;
use App\Models\MasterAktivitas; // Jangan lupa import model aktivitas kalau mau bikin dropdown
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoodTrackController extends Controller
{
    public function index()
    {
        // Kita pakai 'with' biar query hemat (Eager Loading)
        // Jadi kita bisa ambil ikon emosi langsung dari relasi
        $moods = Mood::with(['emosi']) // Load relasi emosi
                     ->where('id_user', Auth::id()) 
                     ->orderBy('tanggal', 'desc')
                     ->orderBy('jam', 'desc')
                     ->paginate(10);

        return view('mood_tracker.index', compact('moods'));
    }

    public function create()
    {
        // Kita butuh data emosi buat dropdown/pilihan di view
        $listEmosi = Emosi::all(); 
        // $listAktivitas = MasterAktivitas::all(); // Uncomment jika sudah ada modelnya
        
        return view('mood.create', compact('listEmosi'));
    }

    public function store(Request $request)
    {
        // 1. Validasi sesuai struktur tabel kamu
        $validated = $request->validate([
            'id_emosi'      => 'required|exists:emosi,id_emosi',
            'id_aktivitas'  => 'required|integer', // Pastikan tabel master_aktivitas ada
            'kategori_aktivitas' => 'required|string',
            'faktor_note'   => 'nullable|string',
            'hal_disyukuri' => 'nullable|string',
            // Tanggal & Jam bisa auto atau input manual
            'tanggal'       => 'nullable|date', 
        ]);

        // 2. Simpan Data
        Mood::create([
            'id_user'       => Auth::id(), // Mengambil ID user yang login
            'id_emosi'      => $validated['id_emosi'],
            'id_aktivitas'  => $validated['id_aktivitas'],
            'kategori_aktivitas' => $validated['kategori_aktivitas'],
            'faktor_note'   => $validated['faktor_note'],
            'hal_disyukuri' => $validated['hal_disyukuri'],
            
            // Kalau user gak isi tanggal, pakai hari ini
            'tanggal'       => $request->tanggal ?? Carbon::now()->toDateString(),
            // Jam otomatis saat input
            'jam'           => Carbon::now()->toTimeString(),
        ]);

        return redirect()->route('mood-tracker')->with('success', 'Mood berhasil dicatat!');
    }
}