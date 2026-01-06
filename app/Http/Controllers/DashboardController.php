<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use App\Models\Mood;
use App\Models\TransHabit;
use App\Models\Journal;
use App\Models\TransHealingPlan;
use App\Models\User;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $todayStr = session('selected_date', Carbon::now('Asia/Jakarta')->format('Y-m-d'));
        $today = Carbon::parse($todayStr);

        $todayMoods = Mood::where('id_user', $user->id_user)
            ->whereDate('tanggal', $todayStr)
            ->orderBy('jam', 'asc')
            ->get();

        $scoreMood = null;
        if ($todayMoods->isNotEmpty()) {
            $rawAvgMood = $todayMoods->avg('skor'); 
            $scoreMood = (($rawAvgMood - 1) / 9 * 10) - 5;
        }

        $todayJournals = Journal::where('id_user', $user->id_user)
            ->whereDate('tanggal', $todayStr)
            ->get();

        $scoreJournal = null;
        if ($todayJournals->isNotEmpty()) {
            $totalSkorJurnal = 0;
            foreach ($todayJournals as $journal) {
                $skorAi = $journal->skor_analisis; 
                $ratingUser = $journal->rating_user; 

                $skorUser = 0;
                if ($ratingUser) {
                    $skorUser = ($ratingUser - 3) * 2.5;
                } else {
                    $skorUser = $skorAi; 
                }

                $skorItem = ($skorAi + $skorUser) / 2;
                $totalSkorJurnal += $skorItem;
            }
            $scoreJournal = $totalSkorJurnal / $todayJournals->count();
        }

        $allHabits = TransHabit::where('id_user', $user->id_user)
            ->whereDate('tanggal', $todayStr)
            ->get();
        
        $totalHabit = $allHabits->count();
        $doneHabit = $allHabits->where('status', 1)->count(); 
        
        $scoreHabit = null;
        $habitPercent = 0;

        if ($totalHabit > 0) {
            $ratio = $doneHabit / $totalHabit;
            $habitPercent = round($ratio * 100);
            $scoreHabit = ($ratio * 10) - 5;
        }

        $healingPlans = TransHealingPlan::where('id_user', $user->id_user)
            ->whereDate('tanggal', $todayStr)
            ->get();

        $scoreHealing = null;
        if ($healingPlans->isNotEmpty()) {
            $currentPoints = 0;
            $targetPoints = 30; 

            foreach ($healingPlans as $plan) {
                if ($plan->is_utama) {
                    $currentPoints += ($plan->is_completed) ? 15 : 5;
                } else {
                    $currentPoints += ($plan->is_completed) ? 8 : 2;
                }
            }
            $ratioHealing = min($currentPoints / $targetPoints, 1.0);
            $scoreHealing = ($ratioHealing * 10) - 5;
        }

        $components = [];
        if (!is_null($scoreMood)) $components[] = $scoreMood;
        if (!is_null($scoreJournal)) $components[] = $scoreJournal;
        if (!is_null($scoreHabit)) $components[] = $scoreHabit;
        if (!is_null($scoreHealing)) $components[] = $scoreHealing;

        if (empty($components)) {
            $mentalConditionPercent = 0; 
        } else {
            $avgTotal = array_sum($components) / count($components);
            $baterai = ($avgTotal + 5) * 10;
            $mentalConditionPercent = (int) max(0, min(100, round($baterai)));
        }

        User::where('id_user', $user->id_user)->update([
            'battery_percentage' => $mentalConditionPercent
        ]);

        
        $chartLabels = []; $chartValues = []; $chartEmojis = []; $chartColors = [];

        foreach ($todayMoods as $mood) {
            $chartLabels[] = Carbon::parse($mood->jam)->format('H:i');
            $displaySkor = $mood->skor; 
            $chartValues[] = $displaySkor;

            if ($displaySkor >= 9) { $emoji = '😆'; $color = '#4ade80'; }
            elseif ($displaySkor >= 7) { $emoji = '😊'; $color = '#a3e635'; }
            elseif ($displaySkor >= 5) { $emoji = '😐'; $color = '#facc15'; }
            elseif ($displaySkor >= 3) { $emoji = '😔'; $color = '#fb923c'; }
            else { $emoji = '😡'; $color = '#f87171'; }

            $chartEmojis[] = $emoji;
            $chartColors[] = $color;
        }

        $recentActivities = Mood::where('id_user', $user->id_user)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->take(4)
            ->get();

        if ($mentalConditionPercent <= 30) {
            $targetKategori = 'support';
        } elseif ($mentalConditionPercent <= 70) {
            $targetKategori = 'apresiasi'; 
        } else {
            $targetKategori = 'motivasi'; 
        }

        $quoteData = DB::table('master_quote')
            ->where('kategori', $targetKategori)
            ->inRandomOrder()
            ->first();

        if (!$quoteData) {
            $quoteContent = "Diam juga bentuk bertahan hidup.";
            $quoteAuthor = "ZenMood";
        } else {
            $quoteContent = $quoteData->isi; 
            $quoteAuthor = $quoteData->penulis;
        }

        $pendingPlans = TransHealingPlan::where('id_user', $user->id_user)
            ->whereDate('tanggal', $todayStr)
            ->where('is_completed', 0) 
            ->get()
            ->map(function($plan) {
                return [
                    'id'        => $plan->id, 
                    'judul'     => $plan->judul ?? $plan->nama_aktivitas ?? 'Aktivitas', 
                    'kategori'  => $plan->kategori ?? 'Self Care',
                    'deskripsi' => $plan->deskripsi ?? 'Lakukan aktivitas ini untuk menaikkan mood.',
                ];
            });
        
        return view('dashboard.index', [
            'user'                   => $user,
            'mentalConditionPercent' => $mentalConditionPercent, 
            'chartLabels'            => $chartLabels,
            'chartValues'            => $chartValues,
            'chartEmojis'            => $chartEmojis,
            'chartColors'            => $chartColors,
            'recentActivities'       => $recentActivities,
            'habitPercent'           => $habitPercent,
            'doneHabit'              => $doneHabit,
            'totalHabit'             => $totalHabit,
            
            'battery' => $mentalConditionPercent, 
            'quote'   => $quoteContent,
            'author'  => $quoteAuthor,
            'pendingPlans' => $pendingPlans,
        ]);
    }
}