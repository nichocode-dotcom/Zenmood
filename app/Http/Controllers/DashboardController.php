<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Mood;
use App\Models\TransHabit;
use App\Models\TransJurnal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');

        // 1. DATA KONDISI MENTAL (Rata-rata Skor Mood Hari Ini)
        // Kita konversi skor 1-10 menjadi Persentase 0-100%
        $todayMoods = Mood::where('id_user', $user->id_user)->whereDate('created_at', $today)->get();
        $avgScore = $todayMoods->avg('skor'); 
        $mentalConditionPercent = $avgScore ? round(($avgScore / 10) * 100) : 0;

        // 2. DATA CHART (Grafik Mood Hari Ini)
        $chartLabels = [];
        $chartValues = [];
        foreach ($todayMoods as $mood) {
            $chartLabels[] = Carbon::parse($mood->created_at)->format('H:i');
            $chartValues[] = $mood->skor;
        }

        // 3. RECENT ACTIVITIES (Ambil dari Mood terakhir yang diinput)
        $recentActivities = Mood::where('id_user', $user->id_user)
                                ->with('aktivitas') // Pastikan ada relasi ke MasterAktivitas
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        // 4. PROGRESS HABIT
        $allHabits = TransHabit::where('id_user', $user->id_user)->whereDate('created_at', $today)->get();
        $totalHabit = $allHabits->count();
        $doneHabit = $allHabits->where('status', 1)->count();
        $habitPercent = $totalHabit > 0 ? round(($doneHabit / $totalHabit) * 100) : 0;

        // 5. QUOTE OF THE DAY (Hardcode dulu atau ambil dari database)
        $quote = "Diam juga bentuk bertahan hidup.";

        return view('dashboard.index', compact(
            'user', 
            'mentalConditionPercent', 
            'chartLabels', 
            'chartValues', 
            'recentActivities', 
            'habitPercent', 
            'doneHabit', 
            'totalHabit',
            'quote'
        ));
    }
}