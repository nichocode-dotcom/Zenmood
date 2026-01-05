<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Mood;
use App\Models\TransHabit;
use App\Models\Journal; // Pastikan namespace Journal benar
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // --- 1. PERHITUNGAN KONDISI MENTAL (BATERAI) ---
        
        // A. Komponen Mood (40%)
        $todayMoods = Mood::where('id_user', $user->id_user)
                          ->whereDate('created_at', $today)
                          ->get();
        
        $moodScore = 0;
        if (!$todayMoods->isEmpty()) {
            $avgMood = $todayMoods->avg('skor');
            $moodScore = ($avgMood / 10) * 40;
        }

        // B. Komponen Habit (30%)
        $allHabits = TransHabit::where('id_user', $user->id_user)
                                ->whereDate('created_at', $today)
                                ->get();
        $totalHabit = $allHabits->count();
        $doneHabit = $allHabits->where('status', 1)->count();
        $habitScore = ($totalHabit > 0) ? ($doneHabit / $totalHabit) * 30 : 0;
        $habitPercent = ($totalHabit > 0) ? round(($doneHabit / $totalHabit) * 100) : 0;

        // C. Komponen Journaling (30%)
        $latestJournal = Journal::where('id_user', $user->id_user)
                                ->whereDate('tanggal', $today)
                                ->latest()
                                ->first();
        
        $journalScore = 0;
        if ($latestJournal) {
            // Map skor -5 s/d 5 ke 0 s/d 30
            $journalScore = (($latestJournal->skor_analisis + 5) / 10) * 30;
        }

        // Total Persentase Baterai
        $mentalConditionPercent = (int) round($moodScore + $habitScore + $journalScore);
        $mentalConditionPercent = max(0, min(100, $mentalConditionPercent));

        // Update ke database user agar data tersinkron
        User::where('id_user', $user->id_user)->update([
            'battery_percentage' => $mentalConditionPercent
        ]);

        // --- 2. DATA CHART (Grafik Mood Hari Ini) ---
        $chartLabels = [];
        $chartValues = [];
        $chartEmojis = []; // Didefinisikan kosong agar tidak error jika tidak ada data
        $chartColors = [];

        foreach ($todayMoods as $mood) {
            $chartLabels[] = Carbon::parse($mood->created_at)->format('H:i');
            $chartValues[] = $mood->skor;

            // Logika Warna dan Emoji berdasarkan skor
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

        // --- 3. RECENT ACTIVITIES ---
        $recentActivities = Mood::where('id_user', $user->id_user)
                                ->with('aktivitas')
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        // --- 4. QUOTE OF THE DAY ---
        $quote = "Diam juga bentuk bertahan hidup.";

        return view('dashboard.index', compact(
            'user', 
            'mentalConditionPercent', 
            'chartLabels', 
            'chartValues', 
            'chartEmojis', // Variabel ini sekarang sudah terkirim ke View
            'chartColors',
            'recentActivities', 
            'habitPercent', 
            'doneHabit', 
            'totalHabit',
            'quote'
        ));
    }
}