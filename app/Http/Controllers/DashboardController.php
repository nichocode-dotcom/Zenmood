<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Mood;
use App\Models\TransHabit;
use App\Models\Journal;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Gunakan fallback ke hari ini jika session kosong
        $today = session('selected_date', Carbon::now()->format('Y-m-d'));

        // --- 1. MOOD (40%) ---
        $todayMoods = Mood::where('id_user', $user->id_user)
                          ->whereDate('created_at', $today) // Atau 'tanggal' jika ada
                          ->orderBy('created_at', 'asc') // Urutkan grafik dari pagi ke malam
                          ->get();

        $moodScore = 0;
        if ($todayMoods->isNotEmpty()) {
            $avgMood = $todayMoods->avg('skor');
            $moodScore = ($avgMood / 10) * 40;
        }

        // --- 2. HABIT (30%) ---
        $allHabits = TransHabit::where('id_user', $user->id_user)
                                ->whereDate('tanggal', $today) // Cek nama kolom di DB: 'created_at' atau 'tanggal'?
                                ->get();
        
        $totalHabit = $allHabits->count();
        $doneHabit = $allHabits->where('status', 1)->count();
        
        $habitScore = 0;
        $habitPercent = 0;
        
        if ($totalHabit > 0) {
            $habitScore = ($doneHabit / $totalHabit) * 30;
            $habitPercent = round(($doneHabit / $totalHabit) * 100);
        }

        // --- 3. JOURNAL (30%) ---
        $latestJournal = Journal::where('id_user', $user->id_user)
                                ->whereDate('tanggal', $today) // Pastikan kolom 'tanggal' ada di Journal
                                ->latest()
                                ->first();

        $journalScore = 0;
        if ($latestJournal) {
            // Normalisasi skor -5..5 menjadi 0..30
            // Rumus: ((skor + 5) / 10) * 30
            $journalScore = (($latestJournal->skor_analisis + 5) / 10) * 30;
        }

        // --- TOTAL BATERAI ---
        $mentalConditionPercent = (int) round($moodScore + $habitScore + $journalScore);
        $mentalConditionPercent = max(0, min(100, $mentalConditionPercent)); // Clamp 0-100

        // Update Baterai User (Opsional: Pindahkan ke Observer/Event untuk performa lebih baik)
        User::where('id_user', $user->id_user)->update([
            'battery_percentage' => $mentalConditionPercent
        ]);

        // --- CHART DATA ---
        $chartLabels = [];
        $chartValues = [];
        $chartEmojis = [];
        $chartColors = [];

        foreach ($todayMoods as $mood) {
            // Format jam (H:i)
            $chartLabels[] = Carbon::parse($mood->created_at)->format('H:i');
            $chartValues[] = $mood->skor;

            // Logika Warna & Emoji
            if ($mood->skor >= 9) {
                $emoji = '😆'; $color = '#4ade80';
            } elseif ($mood->skor >= 7) {
                $emoji = '😊'; $color = '#a3e635';
            } elseif ($mood->skor >= 5) {
                $emoji = '😐'; $color = '#facc15';
            } elseif ($mood->skor >= 3) {
                $emoji = '😔'; $color = '#fb923c';
            } else {
                $emoji = '😡'; $color = '#f87171';
            }

            $chartEmojis[] = $emoji;
            $chartColors[] = $color;
        }

        // --- RECENT ACTIVITIES ---
        $recentActivities = Mood::where('id_user', $user->id_user)
                                ->with('aktivitas') // Pastikan relasi ini ada di Model Mood
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        $quote = "Diam juga bentuk bertahan hidup.";

        return view('dashboard.index', compact(
            'user',
            'mentalConditionPercent',
            'chartLabels',
            'chartValues',
            'chartEmojis',
            'chartColors',
            'recentActivities',
            'habitPercent',
            'doneHabit',
            'totalHabit',
            'quote'
        ));
    }
}