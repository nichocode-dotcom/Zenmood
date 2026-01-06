<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterHealingPlan;
use App\Models\TransHealingPlan;
use App\Models\Mood; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HealingPlanController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // 1. SINKRONISASI TANGGAL (PENTING!)
        // Ambil tanggal dari session Track Record, default ke hari ini
        $todayStr = session('selected_date', Carbon::now('Asia/Jakarta')->format('Y-m-d'));
        $today = Carbon::parse($todayStr);

        // 2. CEK MOOD PADA TANGGAL YANG DIPILIH
        $userMood = Mood::where('id_user', $userId)
            ->whereDate('tanggal', $todayStr) // Gunakan $todayStr yang sinkron
            ->latest()
            ->first();

        $hasMood = $userMood ? true : false;

        // 3. AUTO-GENERATE (Jika mood ada tapi belum ada rekomendasi di tanggal tsb)
        if ($hasMood) {
            $this->generateDailyRecommendations($userId, $todayStr, $userMood);
        }

        // 4. AMBIL DATA TRANSAKSI
        $allPlans = MasterHealingPlan::all();
        $transactions = TransHealingPlan::where('id_user', $userId)
            ->whereDate('tanggal', $todayStr) // Gunakan $todayStr
            ->get()
            ->keyBy('id_healing');

        // ... (Kode MAPPING DATA $processedPlans sama persis seperti sebelumnya) ...
        // ... (Pastikan bagian getStepsByActivity tidak null) ...
        
        $processedPlans = $allPlans->map(function ($plan) use ($transactions) {
            $trans = $transactions->get($plan->id_healing);
            $steps = $this->getStepsByActivity($plan->judul_aktivitas) ?? []; // Safety null
            
            return [
                'id_healing' => $plan->id_healing,
                'title' => $plan->judul_aktivitas,
                'category' => $plan->kategori,
                'description' => $plan->deskripsi_detail,
                'poin' => $plan->poin_baterai,
                'is_active' => $trans ? true : false,
                'is_completed' => $trans ? $trans->is_completed : false,
                'is_utama' => $trans ? $trans->is_utama : false, 
                'icon' => $this->getIconByName($plan->judul_aktivitas, $plan->kategori),
                'color' => $this->getColorByCategory($plan->kategori),
                'steps' => $steps,
            ];
        });

        // 4. HITUNG ENERGI
        $currentEnergy = 0;
        foreach($processedPlans as $p) {
            if($p['is_completed']) $currentEnergy += $p['poin'];
        }
        $energyPercentage = min($currentEnergy, 100);

        // 5. DATA AKTIF (List kegiatan yang sudah ada di DB hari ini)
        $activeActivities = $processedPlans->where('is_active', true)->values();
        $activeIds = $activeActivities->pluck('id_healing')->toArray();
        
        // 6. LOGIKA REKOMENDASI
        $mainRecommendations = collect([]);
        $alternativeActivities = collect([]);

        if ($hasMood) {
            $idEmosi = $userMood->id_emosi;
            
            // Ambil pool kandidat (yang belum ada di DB)
            $pool = $processedPlans->where('is_active', false);

            // Filter Pool berdasarkan Emosi User
            $filteredPool = $pool->filter(function ($item) use ($idEmosi) {
                if (in_array($idEmosi, [4, 6])) { // Cemas (4) / Marah (6) -> Butuh Ketenangan
                    return stripos($item['category'], 'Relaksasi') !== false || stripos($item['title'], 'Napas') !== false || stripos($item['category'], 'Mental') !== false;
                } 
                elseif ($idEmosi == 5) { // Sedih (5) -> Butuh Refleksi / Mood Booster
                    return stripos($item['category'], 'Refleksi') !== false || stripos($item['title'], 'Jurnal') !== false || stripos($item['title'], 'Musik') !== false;
                }
                elseif (in_array($idEmosi, [1, 2])) { // Bahagia (1) / Senang (2) -> Salurkan Energi
                    return stripos($item['category'], 'Fisik') !== false || stripos($item['category'], 'Produktivitas') !== false || stripos($item['category'], 'Edukasi') !== false;
                }
                else { // Biasa Aja (3) -> Random
                    return true;
                }
            });

            // --- PILIH REKOMENDASI UTAMA ---
            // Cek apakah hari ini user SUDAH punya rekomendasi utama yang tersimpan?
            // Kita prioritaskan data yang sudah ada di DB (active & is_utama=true) agar konsisten.
            $existingMain = $activeActivities->where('is_utama', true);

            if ($existingMain->count() >= 3) {
                // Jika sudah ada 3, tampilkan itu saja
                $mainRecommendations = $existingMain->take(3);
            } else {
                // Jika kurang, ambil sisanya dari pool baru
                $needed = 3 - $existingMain->count();
                
                if ($filteredPool->count() >= $needed) {
                    $newRecs = $filteredPool->shuffle()->take($needed);
                } else {
                    $newRecs = $pool->shuffle()->take($needed);
                }

                // Gabungkan yang lama dengan yang baru
                $mainRecommendations = $existingMain->merge($newRecs);

                // --- AUTO SAVE LOGIC (PENTING) ---
                // Simpan rekomendasi BARU ini ke database saat halaman dimuat.
                // Tujuannya agar rekomendasi ini "terkunci" untuk hari ini.
                foreach ($newRecs as $rec) {
                    TransHealingPlan::firstOrCreate(
                        [
                            'id_user' => $userId,
                            'id_healing' => $rec['id_healing'],
                            'tanggal' => $todayStr
                        ],
                        [
                            'is_completed' => false,
                            'is_utama' => true // Kita tandai ini sebagai rekomendasi sistem
                        ]
                    );
                }
            }

            $mainIds = $mainRecommendations->pluck('id_healing')->toArray();

            // --- LOGIKA ALTERNATIF (WAJIB 5 KOTAK) ---
            // Ambil sisa kegiatan yang BUKAN Aktif dan BUKAN Rekomendasi Utama
            $remaining = $processedPlans->whereNotIn('id_healing', array_merge($activeIds, $mainIds))->shuffle();
            $alternativeActivities = $remaining->take(5);

            // Failsafe: Jika stok kurang dari 5, ambil filler dari mana saja (asal bukan yg sedang tampil di Main Recs sebagai is_active)
            if ($alternativeActivities->count() < 5) {
                $needed = 5 - $alternativeActivities->count();
                $currentAlternativeIds = $alternativeActivities->pluck('id_healing')->toArray();
                
                $filler = $processedPlans->whereNotIn('id_healing', array_merge($currentAlternativeIds, $mainIds))
                                         ->shuffle()
                                         ->take($needed);
                
                $alternativeActivities = $alternativeActivities->merge($filler);
            }
            $alternativeActivities = $alternativeActivities->values();
        }

        // 7. SIAPKAN DATA UNTUK JAVASCRIPT
        $activitiesDB = [];
        foreach ($processedPlans as $act) {
            $act['icon_url'] = asset('img/' . $act['icon']);
            $activitiesDB[$act['title']] = $act;
        }

        $formattedDate = $today->locale('id')->isoFormat('dddd, D MMMM Y');

        return view('healing_plan.index', compact(
            'activeActivities', 'mainRecommendations', 'alternativeActivities', 
            'activitiesDB', 'energyPercentage', 'formattedDate', 'hasMood'
        ));
    }

    private function generateDailyRecommendations($userId, $date, $moodData)
    {
        // Cek apakah sudah ada rekomendasi UTAMA di tanggal tersebut
        $existingCount = TransHealingPlan::where('id_user', $userId)
            ->whereDate('tanggal', $date)
            ->where('is_utama', 1)
            ->count();

        // Jika sudah ada 3, jangan generate ulang (biar stabil)
        if ($existingCount >= 3) return;

        // Ambil data mood (ID Emosi)
        $idEmosi = $moodData->id_emosi;

        // Ambil semua aktivitas Master
        $candidates = MasterHealingPlan::all();

        // Filter aktivitas yang cocok dengan emosi
        $filtered = $candidates->filter(function ($item) use ($idEmosi) {
            $cat = $item->kategori;
            $title = $item->judul_aktivitas;

            if (in_array($idEmosi, [4, 6])) { // Cemas/Marah -> Tenang
                return stripos($cat, 'Relaksasi') !== false || stripos($title, 'Napas') !== false;
            } elseif ($idEmosi == 5) { // Sedih -> Refleksi
                return stripos($cat, 'Refleksi') !== false || stripos($title, 'Jurnal') !== false;
            } elseif (in_array($idEmosi, [1, 2])) { // Senang -> Produktif/Fisik
                return stripos($cat, 'Fisik') !== false || stripos($cat, 'Produktivitas') !== false;
            } else {
                return true; // Random
            }
        });

        // Jika filter terlalu sedikit, ambil dari semua kandidat
        if ($filtered->count() < 3) $filtered = $candidates;

        // Ambil 3 acak
        $picks = $filtered->shuffle()->take(3 - $existingCount);

        // Simpan ke DB
        foreach ($picks as $pick) {
            TransHealingPlan::firstOrCreate([
                'id_user' => $userId,
                'id_healing' => $pick->id_healing,
                'tanggal' => $date
            ], [
                'is_completed' => 0,
                'is_utama' => 1
            ]);
        }
    }

    /**
     * FUNGSI UNTUK MENYIMPAN/UPDATE STATUS AKTIVITAS
     * Perbaikan: Menggunakan updateOrCreate untuk Check (1) maupun Uncheck (0)
     */
    public function toggleActivity(Request $request)
    {
        $userId = auth()->id();
        $today = session('selected_date', Carbon::now('Asia/Jakarta')->format('Y-m-d'));
        
        // 1. Cek apakah data ini sudah ada sebelumnya di DB?
        $existing = TransHealingPlan::where('id_user', $userId)
            ->where('id_healing', $request->id_healing)
            ->where('tanggal', $today)
            ->first();

        // 2. Tentukan status 'is_utama'
        // Jika data sudah ada di DB, KITA WAJIB PAKAI NILAI YANG ADA DI DB.
        // Jangan percaya input frontend 100% untuk field ini, karena bisa saja frontend reset jadi 0.
        // Ini menjaga agar rekomendasi utama tidak berubah jadi aktivitas biasa saat diklik.
        $isUtama = $request->is_utama ? 1 : 0;
        if ($existing) {
            $isUtama = $existing->is_utama; 
        }

        // 3. Tentukan status 'is_completed'
        // 1 = Selesai, 0 = Belum (Progress berjalan)
        $isCompleted = ($request->status == 1) ? 1 : 0;

        // 4. EKSEKUSI PENYIMPANAN
        // Kita gunakan updateOrCreate. Ini akan meng-handle INSERT jika belum ada, atau UPDATE jika sudah ada.
        // Kuncinya: Kita TIDAK PERNAH DELETE. Uncheck = Update jadi 0.
        TransHealingPlan::updateOrCreate(
            [
                'id_user' => $userId, 
                'id_healing' => $request->id_healing, 
                'tanggal' => $today
            ],
            [
                'is_completed' => $isCompleted,
                'is_utama' => $isUtama
            ]
        );

        // 5. Hitung Ulang Total Energi
        $newTotal = TransHealingPlan::where('id_user', $userId)
            ->where('tanggal', $today)
            ->where('is_completed', 1) // Hanya hitung yang 100% selesai
            ->join('master_healing_plan', 'trans_healing_plan.id_healing', '=', 'master_healing_plan.id_healing')
            ->sum('master_healing_plan.poin_baterai');

        return response()->json([
            'success' => true, 
            'new_energy' => min($newTotal, 100)
        ]);
    }

    // --- HELPER FUNCTIONS ---
    private function getIconByName($title, $category) {
        if (stripos($title, 'Tidur') !== false) return 'solar_sleeping-bold.svg';
        if (stripos($title, 'Jalan') !== false || stripos($title, 'Lari') !== false || stripos($title, 'Tanaman') !== false || stripos($title, 'Hewan') !== false) return 'fa7-solid_walking.svg';
        if (stripos($title, 'Teh') !== false || stripos($title, 'Minum') !== false || stripos($title, 'Masak') !== false || stripos($title, 'Makan') !== false || stripos($title, 'Buah') !== false) return 'streamline-flex_tea-cup-solid.svg';
        if (stripos($title, 'Digital') !== false || stripos($title, 'HP') !== false || stripos($title, 'Video') !== false || stripos($title, 'Unfollow') !== false || stripos($title, 'Galeri') !== false || stripos($title, 'Komplimen') !== false) return 'phone.svg';
        if (stripos($title, 'Jurnal') !== false || stripos($title, 'Tulis') !== false || stripos($title, 'Puisi') !== false || stripos($title, 'Gambar') !== false || stripos($title, 'Doodling') !== false) return 'Vector.svg';
        if (stripos($title, 'Meditasi') !== false || stripos($title, 'Napas') !== false || stripos($title, 'Yoga') !== false || stripos($title, 'Langit') !== false || stripos($title, 'Visualisasi') !== false || stripos($title, 'Mandi') !== false || stripos($title, 'Skincare') !== false) return 'mdi_meditation.svg';
        if (stripos($title, 'Baca') !== false || stripos($title, 'Buku') !== false || stripos($title, 'Podcast') !== false || stripos($title, 'Puzzle') !== false) return 'ion_book.svg';
        if (stripos($title, 'Stretching') !== false || stripos($title, 'Mata') !== false) return 'streching.png';
        if (stripos($title, 'Musik') !== false || stripos($title, 'Karaoke') !== false) return 'music_note.svg';
        if (stripos($title, 'Meja') !== false || stripos($title, 'Rapikan') !== false) return 'clean.svg'; 
        
        return match ($category) {
            'Relaksasi' => 'mdi_meditation.svg', 
            'Fisik' => 'streching.png', 
            'Refleksi' => 'Vector.svg', 
            'Teknologi' => 'phone.svg', 
            'Edukasi' => 'ion_book.svg',
            'Sosial' => 'communication.svg',
            default => 'star.svg',
        };
    }

    private function getColorByCategory($category) {
         return match ($category) {
            'Teknologi', 'Mental', 'Produktivitas' => 'bg-gradient-to-r from-[#558B2F] to-[#72B940]',
            'Refleksi', 'Edukasi' => 'bg-gradient-to-r from-[#72B940] to-[#A3E635]',
            default => 'bg-gradient-to-r from-[#558B2F] to-[#A3E635]',
        };
    }

    private function getStepsByActivity($title) {
        if (stripos($title, 'Grounding') !== false) return ['Sebutkan 5 benda dilihat', 'Sebutkan 4 benda diraba', 'Sebutkan 3 suara didengar', 'Tarik napas dalam'];
        if (stripos($title, 'Jurnal') !== false) return ['Siapkan buku', 'Tulis 3 hal disyukuri', 'Tulis harapan besok', 'Tutup buku'];
        if (stripos($title, 'Tidur') !== false) return ['Matikan lampu', 'Atur suhu', 'Jauhkan HP', 'Pejamkan mata'];
        if (stripos($title, 'Digital') !== false) return ['Matikan notifikasi', 'Jauhkan HP', 'Ambil buku/aktivitas lain', 'Fokus 1 jam'];
        if (stripos($title, 'Deep Talk') !== false) return ['Pilih teman dekat', 'Tanyakan kabar', 'Dengarkan cerita', 'Ceritakan perasaanmu'];
        if (stripos($title, 'Jalan') !== false) return ['Pakai sepatu nyaman', 'Minum air', 'Jalan santai', 'Nikmati udara'];
        if (stripos($title, 'Teh') !== false) return ['Seduh teh', 'Hirup aroma', 'Minum perlahan', 'Rasakan hangatnya'];
        if (stripos($title, 'Baca') !== false) return ['Pilih buku', 'Cari tempat tenang', 'Baca 15 menit', 'Catat poin menarik'];
        if (stripos($title, 'Yoga') !== false) return ['Gelar matras', 'Atur napas', 'Lakukan pose Child Pose', 'Selesai dengan Savasana'];
        if (stripos($title, 'Podcast') !== false) return ['Pilih topik menarik', 'Pasang earphone', 'Dengarkan 15 menit', 'Catat poin penting'];
        if (stripos($title, 'Masak') !== false) return ['Siapkan bahan', 'Cuci bersih', 'Masak perlahan', 'Nikmati aromanya'];
        if (stripos($title, 'Unfollow') !== false) return ['Buka daftar following', 'Cari akun toxic', 'Klik unfollow/mute', 'Tutup aplikasi'];
        if (stripos($title, 'Langit') !== false) return ['Keluar ruangan', 'Cari posisi nyaman', 'Tatap langit luas', 'Bernapas lega'];
        if (stripos($title, 'Puzzle') !== false) return ['Siapkan puzzle/TTS', 'Fokus satu bagian', 'Selesaikan tantangan', 'Rayakan keberhasilan'];
        if (stripos($title, 'Karaoke') !== false || stripos($title, 'Musik') !== false) return ['Pilih lagu', 'Pasang musik', 'Bernyanyi/Dengar', 'Nikmati nada'];
        if (stripos($title, 'Galeri') !== false) return ['Buka galeri', 'Pilih foto lama', 'Hapus yang buram', 'Kosongkan trash'];
        if (stripos($title, 'Mata') !== false) return ['Lepas kacamata', 'Putar bola mata', 'Kedipkan mata', 'Tutup mata 1 menit'];
        if (stripos($title, 'Puisi') !== false) return ['Ambil kertas', 'Tulis perasaan', 'Rangkai kalimat', 'Baca ulang'];
        if (stripos($title, 'Hewan') !== false) return ['Siapkan makanan', 'Dekati hewan', 'Beri makan', 'Elus jika bisa'];
        if (stripos($title, 'Mandi') !== false) return ['Siapkan air hangat', 'Gunakan sabun wangi', 'Nikmati guyuran air', 'Keringkan badan'];
        if (stripos($title, 'Meja') !== false) return ['Buang sampah', 'Rapikan kabel', 'Susun alat tulis', 'Lap meja'];
        if (stripos($title, 'Gambar') !== false || stripos($title, 'Doodling') !== false) return ['Siapkan kertas', 'Coret bebas', 'Jangan nilai hasil', 'Biarkan tangan gerak'];
        if (stripos($title, 'Tanaman') !== false) return ['Ambil air', 'Siram tanah', 'Bersihkan daun', 'Nikmati hijaunya'];
        if (stripos($title, 'Stretching') !== false) return ['Putar leher', 'Tarik lengan', 'Bungkuk badan', 'Atur napas'];
        if (stripos($title, 'Skincare') !== false) return ['Cuci tangan', 'Pakai produk', 'Pijat wajah', 'Rasakan segarnya'];
        if (stripos($title, 'Video') !== false) return ['Buka app video', 'Cari komedi', 'Tonton 1-2 video', 'Tertawa lepas'];
        if (stripos($title, 'Visualisasi') !== false) return ['Posisi nyaman', 'Pejam mata', 'Bayangkan tempat indah', 'Rasakan emosinya'];
        if (stripos($title, 'Komplimen') !== false) return ['Pikirkan teman', 'Ingat kebaikan', 'Tulis pesan', 'Kirim'];
        if (stripos($title, 'Buah') !== false) return ['Cuci buah', 'Potong kecil', 'Makan perlahan', 'Rasakan teksturnya'];

        return ['Persiapan', 'Lakukan aktivitas', 'Selesai'];
    }
}