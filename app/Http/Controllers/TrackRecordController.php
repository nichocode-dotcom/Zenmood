<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Mood;
use App\Models\TransJurnal;
use App\Models\TransHabit;
use App\Models\TransHealingPlan;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TrackRecordController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $selectedDate = $request->input('date', Carbon::now()->format('Y-m-d'));
        $today = $selectedDate;
        $todayMood = Mood::where('id_user', $user->id_user)
                        ->whereDate('created_at', $today)
                        ->orderBy('created_at', 'desc') 
                        ->first();

        $insightMessage = "Belum ada data mood hari ini.";
        if ($todayMood) {
            if ($todayMood->skor >= 8) {
                $insightMessage = "Mood kamu luar biasa! Pertahankan energi positif ini.";
            } elseif ($todayMood->skor >= 5) {
                $insightMessage = "Mood kamu stabil. Terus jaga keseimbangan ya.";
            } else {
                $insightMessage = "Hari yang berat? Tidak apa-apa untuk istirahat sejenak.";
            }
        }

        $journals = TransJurnal::where('id_user', $user->id_user)
                            ->whereDate('created_at', $today)
                            ->latest()
                            ->take(3)
                            ->get();

        $allHabits = TransHabit::where('id_user', $user->id_user)
                            ->whereDate('created_at', $today)
                            ->with('habit') 
                            ->get();
        
        $totalHabit = $allHabits->count();
        $doneHabit = $allHabits->where('status', 1)->count(); 
        
        if ($totalHabit > 0) {
            $habitPercentage = round(($doneHabit / $totalHabit) * 100);
        } else {
            $habitPercentage = 0; 
        }

        $habitAnalysis = "";

        if ($totalHabit == 0) {
            $habitAnalysis = "Belum ada habit yang ditargetkan hari ini. Yuk, atur habitmu untuk mulai membangun rutinitas positif!";
        } elseif ($habitPercentage == 100) {
            $habitAnalysis = "Luar biasa! Anda telah menyelesaikan semua target habit hari ini. Pertahankan konsistensi ini untuk kesehatan mental yang lebih baik.";
        } elseif ($habitPercentage >= 80) {
            $habitAnalysis = "Progres pencapaian habit Anda hari ini sudah sangat baik. Sedikit lagi menuju sempurna, tetap semangat!";
        } elseif ($habitPercentage >= 50) {
            $habitAnalysis = "Kerja bagus! Anda sudah menyelesaikan lebih dari separuh target. Coba dorong sedikit lagi untuk hasil maksimal.";
        } elseif ($habitPercentage > 0) {
            $habitAnalysis = "Awal yang baik. Jangan memaksakan diri, satu langkah kecil lebih berarti daripada tidak sama sekali.";
        } else {
            $habitAnalysis = "Tampaknya belum ada habit yang selesai. Tidak apa-apa, pilih satu habit termudah dan kerjakan sekarang juga.";
        }

        $allHealing = TransHealingPlan::where('id_user', $user->id_user)
                                    ->whereDate('created_at', $today)
                                    ->with('masterHealingPlan') 
                                    ->get();

        $totalHealing = $allHealing->count();
        $doneHealing = $allHealing->where('status', 1)->count();
        $healingPercentage = $totalHealing > 0 ? round(($doneHealing / $totalHealing) * 100) : 0;
        
        $todaysMoods = Mood::where('id_user', $user->id_user)
                        ->whereDate('created_at', $today)
                        ->orderBy('created_at', 'asc') 
                        ->get();

        $chartLabels = [];
        $chartValues = [];
        $chartColors = [];

        foreach ($todaysMoods as $mood) {
            $jam = Carbon::parse($mood->created_at)->format('H:i');
            
            if ($mood->skor >= 9) {
                $emoji = '🤩'; 
                $color = '#4ade80'; 
            } elseif ($mood->skor >= 7) {
                $emoji = '😊'; 
                $color = '#a3e635'; 
            } elseif ($mood->skor >= 5) {
                $emoji = '😐'; 
                $color = '#facc15'; 
            } elseif ($mood->skor >= 3) {
                $emoji = '😔'; 
                $color = '#fb923c'; 
            } else {
                $emoji = '😡'; 
                $color = '#f87171'; 
            }

            $chartLabels[] = [$emoji, $jam]; 
            $chartValues[] = $mood->skor;
            $chartColors[] = $color;
        }

        $avgMoodScore = $todaysMoods->avg('skor');
        $moodCount = $todaysMoods->count();

        $moodAnalysisText = "Belum ada data mood yang terekam hari ini.";
        $moodRecommendationText = "Cobalah untuk mencatat mood pertamamu agar sistem bisa memberikan analisis.";
        $moodDetailText = "Grafik masih kosong. Silakan input mood Anda melalui menu Mood Tracker.";

        if ($moodCount > 0) {
            if ($avgMoodScore >= 8) {
                $moodAnalysisText = "Energi positif Anda sangat dominan hari ini! Grafik menunjukkan stabilitas emosi yang sangat baik di zona hijau.";
                $moodRecommendationText = "Manfaatkan energi tinggi ini untuk menyelesaikan tugas sulit, berkreasi, atau berbagi kebahagiaan dengan orang terdekat.";
                $moodDetailText = "Grafik batang didominasi warna hijau terang, menandakan konsistensi perasaan positif sepanjang hari.";
            
            } elseif ($avgMoodScore >= 5) {
                $moodAnalysisText = "Mood Anda hari ini cukup seimbang, meski mungkin ada sedikit fluktuasi. Ini adalah kondisi yang wajar dan manusiawi.";
                $moodRecommendationText = "Pertahankan keseimbangan ini. Luangkan waktu sejenak untuk 'me time' atau meditasi ringan jika mulai merasa lelah.";
                $moodDetailText = "Grafik menunjukkan variasi warna kuning dan hijau muda, mencerminkan dinamika emosi yang stabil namun tetap aktif.";
            
            } else {
                $moodAnalysisText = "Terdeteksi penurunan mood yang cukup signifikan hari ini. Grafik menunjukkan Anda mungkin sedang melewati fase yang berat atau melelahkan.";
                $moodRecommendationText = "Jangan memaksakan diri. Prioritaskan tidur lebih awal malam ini (7-8 jam), kurangi kafein, dan coba lakukan teknik pernapasan dalam.";
                $moodDetailText = "Grafik didominasi warna oranye atau merah. Penurunan batang grafik pada jam tertentu bisa menjadi petunjuk pemicu stres utama Anda.";
            }
        }

    
    
        return view('track_record.index', compact(
            'user', 
            'selectedDate',
            'insightMessage', 
            'todayMood', 
            'journals', 
            'allHabits', 
            'habitPercentage',
            'allHealing',
            'healingPercentage',
            'habitAnalysis',
            'chartLabels',
            'chartValues',
            'chartColors' 
            ,'moodAnalysisText',
            'moodRecommendationText',
            'moodDetailText'
        ));
    }

    public function cetakPdf(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->input('date', Carbon::now()->format('Y-m-d'));
        $today = $selectedDate;

        $todayMood = Mood::where('id_user', $user->id_user)->whereDate('created_at', $today)->orderBy('created_at', 'desc')->first();
        
        $insightMessage = "Belum ada data mood.";
        if ($todayMood) {
            if ($todayMood->skor >= 8) $insightMessage = "Mood luar biasa! Pertahankan energi positif ini.";
            elseif ($todayMood->skor >= 5) $insightMessage = "Mood stabil. Terus jaga keseimbangan.";
            else $insightMessage = "Hari yang berat? Tidak apa-apa untuk istirahat.";
        }

        $journals = TransJurnal::where('id_user', $user->id_user)->whereDate('created_at', $today)->latest()->get();
        
        $allHabits = TransHabit::where('id_user', $user->id_user)->whereDate('created_at', $today)->with('habit')->get();
        $habitPercentage = $allHabits->count() > 0 ? round(($allHabits->where('status', 1)->count() / $allHabits->count()) * 100) : 0;

        $allHealing = TransHealingPlan::where('id_user', $user->id_user)->whereDate('created_at', $today)->with('masterHealingPlan')->get();
        $healingPercentage = $allHealing->count() > 0 ? round(($allHealing->where('status', 1)->count() / $allHealing->count()) * 100) : 0;

        $todaysMoods = Mood::where('id_user', $user->id_user)
                        ->whereDate('created_at', $today)
                        ->orderBy('created_at', 'asc')->get();

        $avgMoodScore = $todaysMoods->avg('skor');
        $moodCount = $todaysMoods->count();
        $moodAnalysisText = "Data tidak cukup untuk analisis.";
        $moodRecommendationText = "Belum ada rekomendasi spesifik.";
        $moodDetailText = "Grafik belum terbentuk sempurna.";

        if ($moodCount > 0) {
            if ($avgMoodScore >= 8) {
                $moodAnalysisText = "Energi positif Anda sangat dominan hari ini! Grafik menunjukkan stabilitas emosi yang sangat baik di zona hijau.";
                $moodRecommendationText = "Manfaatkan energi tinggi ini untuk menyelesaikan tugas sulit, berkreasi, atau berbagi kebahagiaan dengan orang terdekat.";
                $moodDetailText = "Grafik batang didominasi warna hijau terang, menandakan konsistensi perasaan positif sepanjang hari.";
            } elseif ($avgMoodScore >= 5) {
                $moodAnalysisText = "Mood Anda hari ini cukup seimbang, meski mungkin ada sedikit fluktuasi. Ini adalah kondisi yang wajar dan manusiawi.";
                $moodRecommendationText = "Pertahankan keseimbangan ini. Luangkan waktu sejenak untuk 'me time' atau meditasi ringan jika mulai merasa lelah.";
                $moodDetailText = "Grafik menunjukkan variasi warna kuning dan hijau muda, mencerminkan dinamika emosi yang stabil namun tetap aktif.";
            } else {
                $moodAnalysisText = "Terdeteksi penurunan mood yang cukup signifikan hari ini. Grafik menunjukkan Anda mungkin sedang melewati fase yang berat atau melelahkan.";
                $moodRecommendationText = "Jangan memaksakan diri. Prioritaskan tidur lebih awal malam ini (7-8 jam), kurangi kafein, dan coba lakukan teknik pernapasan dalam.";
                $moodDetailText = "Grafik didominasi warna oranye atau merah. Penurunan batang grafik pada jam tertentu bisa menjadi petunjuk pemicu stres utama Anda.";
            }
        }

        $chartLabels = [];
        $chartValues = [];
        
        foreach ($todaysMoods as $mood) {
            $emoji = '';
            if ($mood->skor >= 9) $emoji = '🤩';
            elseif ($mood->skor >= 7) $emoji = '😊';
            elseif ($mood->skor >= 5) $emoji = '😐';
            elseif ($mood->skor >= 3) $emoji = '😔';
            else $emoji = '😡';

            $chartLabels[] = $emoji . " " . Carbon::parse($mood->created_at)->format('H:i');
            $chartValues[] = $mood->skor;
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $chartLabels,
                'datasets' => [[
                    'label' => 'Mood Score',
                    'data' => $chartValues,
                    'backgroundColor' => '#7FBC4E',
                    'borderRadius' => 5
                ]]
            ],
            'options' => [
                'legend' => ['display' => false],
                'scales' => [
                    'yAxes' => [[
                        'ticks' => ['beginAtZero' => true, 'max' => 10]
                    ]]
                ]
            ]
        ];
        
        $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));

        $pdf = PDF::loadView('track_record.pdf', compact(
    'user', 'selectedDate', 'insightMessage', 'journals', 
                'allHabits', 'habitPercentage', 'allHealing', 'healingPercentage', 
                'chartUrl',
                'moodAnalysisText',      
                'moodRecommendationText', 
                'moodDetailText'          
            ));

        $pdf->setOptions(['isRemoteEnabled' => true]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-ZenMood-'.$user->name.'.pdf');
    }
}