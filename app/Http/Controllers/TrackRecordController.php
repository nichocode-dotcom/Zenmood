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

        if ($request->has("date")) {
            $selectedDate = $request->input('date');
            session(['selected_date' => $selectedDate]);
        } else {
            $selectedDate = session('selected_date', Carbon::now()->format('Y-m-d'));
        }
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
                            ->whereDate('tanggal', $today)
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
                                        ->where('tanggal', $today) 
                                        ->with('masterHealing') 
                                        ->get();

        $totalHealing = $allHealing->count();
        
        $doneHealing = $allHealing->where('is_completed', 1)->count(); 
        
        $healingPercentage = $totalHealing > 0 ? round(($doneHealing / $totalHealing) * 100) : 0;

        $healingAnalysis = "";

        if ($totalHealing == 0) {
            $healingAnalysis = "Belum ada rencana healing. Yuk, isi mood tracker dulu untuk mendapatkan rekomendasi aktivitas yang pas buat kamu!";
        } elseif ($healingPercentage == 100) {
            $healingAnalysis = "Luar biasa! Kamu memprioritaskan kesehatan mentalmu dengan sangat baik hari ini. Nikmati perasaan lega dan tenang ini ya.";
        } elseif ($healingPercentage >= 50) {
            $healingAnalysis = "Progres yang bagus! Kamu sudah melakukan sebagian besar aktivitas healing. Usahakan selesaikan sisanya agar baterai energimu penuh kembali.";
        } elseif ($healingPercentage > 0) {
            $healingAnalysis = "Awal yang baik. Anda sudah melakukan beberapa aktivitas yang disarankan oleh sistem; teruskan kebiasaan baik ini. Prioritaskan tugas yang memberi kepuasan kecil untuk menjaga motivasi.";
        } else {
            $healingAnalysis = "Rencana sudah dibuat, namun belum ada aktivitas yang dicentang. Tidak apa-apa, coba pilih satu aktivitas termudah (misal: Minum Air) dan lakukan sekarang.";
        }
        
        $todaysMoods = Mood::where('id_user', $user->id_user)
                        ->whereDate('created_at', $today)
                        ->orderBy('created_at', 'asc') 
                        ->get();

        $chartLabels = [];
        $chartValues = [];
        $chartColors = [];

        foreach ($todaysMoods as $mood) {
            $jam = Carbon::parse($mood->created_at)->timezone('Asia/Jakarta')->format('H:i');

            $skorNumerik = (int)$mood->skor;
            
            if ($skorNumerik >= 9) {
                $emoji = '🤩'; 
                $color = '#4ade80'; 
            } elseif ($skorNumerik >= 7) {
                $emoji = '😊'; 
                $color = '#a3e635'; 
            } elseif ($skorNumerik >= 5) {
                $emoji = '😐'; 
                $color = '#facc15'; 
            } elseif ($skorNumerik >= 3) {
                $emoji = '😔'; 
                $color = '#fb923c'; 
            } else {
                $emoji = '😡'; 
                $color = '#f87171'; 
            }

            $chartLabels[] = $emoji . " " . $jam;
            $chartValues[] = $skorNumerik;
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
            'healingAnalysis',
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
        
        $selectedDate = $request->input('date', session('selected_date', Carbon::now()->format('Y-m-d')));
        $today = $selectedDate;

        $todayMood = Mood::where('id_user', $user->id_user)
                        ->whereDate('created_at', $today)
                        ->orderBy('created_at', 'desc')
                        ->first();
        
        $insightMessage = "Belum ada data mood.";
        if ($todayMood) {
            if ($todayMood->skor >= 8) $insightMessage = "Mood luar biasa! Pertahankan energi positif ini.";
            elseif ($todayMood->skor >= 5) $insightMessage = "Mood stabil. Terus jaga keseimbangan.";
            else $insightMessage = "Hari yang berat? Tidak apa-apa untuk istirahat.";
        }

        $journals = TransJurnal::where('id_user', $user->id_user)
                                ->whereDate('created_at', $today)
                                ->latest()
                                ->get();
        
        $allHabits = TransHabit::where('id_user', $user->id_user)
                                ->where('tanggal', $today)
                                ->with('habit')
                                ->get();
                                
        $habitPercentage = $allHabits->count() > 0 ? round(($allHabits->where('status', 1)->count() / $allHabits->count()) * 100) : 0;

        $allHealing = TransHealingPlan::where('id_user', $user->id_user)
                                      ->where('tanggal', $today)
                                      ->with('masterHealing')
                                      ->get();
                                      
        $healingPercentage = $allHealing->count() > 0 ? round(($allHealing->where('is_completed', 1)->count() / $allHealing->count()) * 100) : 0;

        $todaysMoods = Mood::where('id_user', $user->id_user)
                           ->whereDate('created_at', $today)
                           ->orderBy('created_at', 'asc')->get();

        $chartLabels = [];
        $chartValues = [];
        
        foreach ($todaysMoods as $mood) {
            $jam = Carbon::parse($mood->created_at)->format('H:i');
            $chartLabels[] = $jam;
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

        $avgMoodScore = $todaysMoods->avg('skor');
        $moodCount = $todaysMoods->count();
        $moodAnalysisText = "Data tidak cukup untuk analisis.";
        $moodRecommendationText = "Belum ada rekomendasi spesifik.";
        $moodDetailText = "Grafik belum terbentuk sempurna.";

        if ($moodCount > 0) {
            if ($avgMoodScore >= 8) {
                $moodAnalysisText = "Energi positif Anda sangat dominan hari ini! Grafik menunjukkan stabilitas emosi yang sangat baik.";
                $moodRecommendationText = "Manfaatkan energi ini untuk menyelesaikan tugas sulit atau berbagi kebahagiaan.";
                $moodDetailText = "Grafik batang didominasi level tinggi, menandakan konsistensi perasaan positif.";
            } elseif ($avgMoodScore >= 5) {
                $moodAnalysisText = "Mood Anda hari ini cukup seimbang. Ini adalah kondisi yang wajar dan manusiawi.";
                $moodRecommendationText = "Pertahankan keseimbangan ini. Luangkan waktu sejenak untuk 'me time' jika mulai lelah.";
                $moodDetailText = "Grafik menunjukkan variasi skor menengah, mencerminkan dinamika emosi yang stabil.";
            } else {
                $moodAnalysisText = "Terdeteksi penurunan mood hari ini. Anda mungkin sedang melewati fase yang berat.";
                $moodRecommendationText = "Jangan memaksakan diri. Prioritaskan istirahat dan lakukan hal yang menenangkan.";
                $moodDetailText = "Grafik didominasi level rendah. Ini bisa menjadi petunjuk adanya pemicu stres.";
            }
        }

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