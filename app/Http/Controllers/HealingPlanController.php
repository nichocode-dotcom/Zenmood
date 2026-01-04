<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterHealingPlan;
use App\Models\TransHealingPlan;
use Carbon\Carbon;

class HealingPlanController extends Controller
{
    public function index()
    {
        // Get current user ID (sementara 1, nanti bisa ganti ke auth()->id())
        $user = auth()->user();
        $userId = $user->id;

        $today = Carbon::today();

        // 1. Ambil Data Rekomendasi (Sesuai kategori atau judul di desain)
        $judulUtama = ['Digital Detox', 'Jurnal', 'Tidur Cukup'];
        $rekomendasiUtama = MasterHealingPlan::whereIn('judul_aktivitas', $judulUtama)->get();
        $alternatif = MasterHealingPlan::whereNotIn('judul_aktivitas', $judulUtama)->get();

        // 2. Ambil Transaksi Hari Ini untuk hitung Progress Energi
        $todayTransactions = TransHealingPlan::where('id_user', $userId)
            ->where('tanggal', $today->format('Y-m-d'))
            ->get();

        // 3. Hitung Persentase Energi (Progress Bar)
        $totalPoinTersedia = 100; // Target maksimal energi harian
        $currentEnergy = 0;
        
        foreach ($todayTransactions as $trans) {
            if ($trans->is_completed) {
                // Ambil poin dari relasi master (pastikan relasi 'master' ada di Model TransHealingPlan)
                $currentEnergy += $trans->masterHealing->poin_baterai ?? 20; 
            }
        }

        // Batasi maksimal 100%
        $energyPercentage = min($currentEnergy, 100);

        // 4. Format Tanggal Indonesia
        $formattedDate = $today->locale('id')->isoFormat('dddd, D MMMM YYYY');

        return view('healing_plan.index', [
            'rekomendasiUtama' => $rekomendasiUtama,
            'alternatif' => $alternatif,
            'energyPercentage' => $energyPercentage,
            'formattedDate' => $formattedDate,
            'userId' => $userId
        ]);
    }

    public function pilih(Request $request)
    {
        $userId = $request->input('user_id', 1);
        $idHealing = $request->input('id_healing');

        // Create transaksi baru (User memilih aktivitas)
        TransHealingPlan::create([
            'id_user' => $userId,
            'id_healing' => $idHealing,
            'tanggal' => Carbon::today()->format('Y-m-d'),
            'is_completed' => false
        ]);

        return redirect()->back()->with('success', 'Aktivitas berhasil ditambahkan ke rencana harimu!');
    }
}