<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterHealingPlan;
use App\Models\TransHealingPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HealingPlanController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $today = Carbon::now('Asia/Jakarta');

        // 1. AMBIL DATA
        $allPlans = MasterHealingPlan::all();
        $transactions = TransHealingPlan::where('id_user', $userId)
            ->whereDate('tanggal', $today->format('Y-m-d'))
            ->get()
            ->keyBy('id_healing');

        // 2. MAPPING DATA
        $processedPlans = $allPlans->map(function ($plan) use ($transactions) {
            $trans = $transactions->get($plan->id_healing);
            $steps = $this->getStepsByActivity($plan->judul_aktivitas);
            
            return [
                'id_healing' => $plan->id_healing,
                'title' => $plan->judul_aktivitas,
                'category' => $plan->kategori,
                'description' => $plan->deskripsi_detail,
                'poin' => $plan->poin_baterai,
                // Status Logic
                'is_active' => $trans ? true : false,
                'is_completed' => $trans ? $trans->is_completed : false,
                // PERBAIKAN 1: Ambil status is_utama dari DB jika ada
                'is_utama' => $trans ? $trans->is_utama : false, 
                
                // Helper UI
                'icon' => $this->getIconByName($plan->judul_aktivitas, $plan->kategori),
                'color' => $this->getColorByCategory($plan->kategori),
                'steps' => $steps,
            ];
        });

        // 3. HITUNG ENERGI (Server Side Calculation)
        $currentEnergy = 0;
        foreach($processedPlans as $p) {
            // Hitung poin penuh jika selesai
            if($p['is_completed']) {
                $currentEnergy += $p['poin'];
            } 
            // Opsional: Jika ingin hitung setengah jalan, butuh logic step detail di DB
        }
        $energyPercentage = min($currentEnergy, 100);

        // 4. BAGI DATA
        // A. Aktif
        $activeActivities = $processedPlans->where('is_active', true)->values();
        $activeIds = $activeActivities->pluck('id_healing')->toArray();

        // B. Sisa Pool
        $pool = $processedPlans->where('is_active', false)->shuffle();

        // C. Rekomendasi Utama (3)
        $mainRecommendations = $pool->take(3);
        $mainIds = $mainRecommendations->pluck('id_healing')->toArray();

        // D. Alternatif (5) - Pastikan selalu 5
        $remaining = $processedPlans->whereNotIn('id_healing', array_merge($activeIds, $mainIds))->shuffle();
        if ($remaining->count() < 5) {
            // Ambil filler dari data yg bukan Main (boleh duplikat dgn aktif kalau kepepet)
            $filler = $processedPlans->whereNotIn('id_healing', $mainIds)->shuffle();
            $alternativeActivities = $remaining->merge($filler)->take(5);
        } else {
            $alternativeActivities = $remaining->take(5);
        }

        // 5. DB JS
        $activitiesDB = [];
        foreach ($processedPlans as $act) {
            $act['icon_url'] = asset('img/' . $act['icon']);
            $activitiesDB[$act['title']] = $act;
        }

        $formattedDate = $today->locale('id')->isoFormat('dddd, D MMMM Y');

        return view('healing_plan.index', compact(
            'activeActivities', 'mainRecommendations', 'alternativeActivities', 
            'activitiesDB', 'energyPercentage', 'formattedDate'
        ));
    }

    public function toggleActivity(Request $request)
    {
        $userId = auth()->id();
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        
        // Cek Data Lama
        $existing = TransHealingPlan::where('id_user', $userId)
            ->where('id_healing', $request->id_healing)
            ->where('tanggal', $today)
            ->first();

        // LOGIKA PERBAIKAN is_utama:
        // Jika di DB sudah tercatat sebagai UTAMA (1), jangan biarkan berubah jadi 0.
        $isUtamaInput = $request->is_utama ? true : false;
        
        if ($existing && $existing->is_utama == true) {
            $isUtamaInput = true; // Paksa tetap true
        }

        if ($request->status == 1) {
            // SIMPAN / UPDATE
            TransHealingPlan::updateOrCreate(
                [
                    'id_user' => $userId,
                    'id_healing' => $request->id_healing,
                    'tanggal' => $today
                ],
                [
                    'is_completed' => true,
                    'is_utama' => $isUtamaInput
                ]
            );
        } else {
            // HAPUS (Reset Progress)
            // Note: Jika dihapus, history 'is_utama' hilang. 
            // Jika user mengambil lagi dari kotak bawah, akan jadi 0. Ini perilaku wajar.
            if($existing) $existing->delete();
        }

        // Hitung Energi Baru
        $newTotal = TransHealingPlan::where('id_user', $userId)
            ->where('tanggal', $today)
            ->where('is_completed', true)
            ->join('master_healing_plan', 'trans_healing_plan.id_healing', '=', 'master_healing_plan.id_healing')
            ->sum('master_healing_plan.poin_baterai');

        return response()->json([
            'success' => true,
            'new_energy' => min($newTotal, 100)
        ]);
    }

    // --- HELPER SAMA SEPERTI SEBELUMNYA ---
    private function getIconByName($title, $category) {
        if (stripos($title, 'Tidur') !== false) return 'solar_sleeping-bold.svg';
        if (stripos($title, 'Jalan') !== false || stripos($title, 'Lari') !== false) return 'fa7-solid_walking.svg';
        if (stripos($title, 'Teh') !== false || stripos($title, 'Minum') !== false) return 'streamline-flex_tea-cup-solid.svg';
        if (stripos($title, 'Digital') !== false || stripos($title, 'HP') !== false) return 'phone.svg';
        if (stripos($title, 'Jurnal') !== false || stripos($title, 'Tulis') !== false) return 'Vector.svg';
        if (stripos($title, 'Meditasi') !== false || stripos($title, 'Napas') !== false) return 'mdi_meditation.svg';
        if (stripos($title, 'Baca') !== false) return 'ion_book.svg';
        return match ($category) {
            'Relaksasi' => 'mdi_meditation.svg', 'Fisik' => 'streching.png', 'Refleksi' => 'Vector.svg', 'Teknologi' => 'phone.svg', default => 'star.svg',
        };
    }
    private function getColorByCategory($category) {
        return match ($category) {
            'Teknologi', 'Mental' => 'bg-gradient-to-r from-[#558B2F] to-[#72B940]',
            'Refleksi' => 'bg-gradient-to-r from-[#72B940] to-[#A3E635]',
            default => 'bg-gradient-to-r from-[#558B2F] to-[#A3E635]',
        };
    }
    private function getStepsByActivity($title) {
        if (stripos($title, 'Grounding') !== false) return ['Sebutkan 5 benda dilihat', 'Sebutkan 4 benda diraba', 'Sebutkan 3 suara didengar', 'Tarik napas dalam'];
        if (stripos($title, 'Jurnal') !== false) return ['Siapkan buku', 'Tulis 3 hal disyukuri', 'Tulis harapan besok', 'Tutup buku'];
        if (stripos($title, 'Tidur') !== false) return ['Matikan lampu', 'Atur suhu', 'Jauhkan HP', 'Pejamkan mata'];
        return ['Persiapan', 'Lakukan aktivitas', 'Selesai'];
    }
}