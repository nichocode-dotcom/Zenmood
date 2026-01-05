<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Lebih disarankan untuk Laravel modern
use Carbon\Carbon; // WAJIB ADA agar Carbon::now() berfungsi

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     * 
     * 
     * 
     * 
     
     *
     * @return void
     */
    public function run()
    {
       // 1. MASTER EMOSI
        DB::table('emosi')->insert([
            ['nama' => 'Sangat Bahagia', 'ikon' => '🤩', 'skor' => 5],
            ['nama' => 'Senang', 'ikon' => '🙂', 'skor' => 3],
            ['nama' => 'Biasa Aja', 'ikon' => '😐', 'skor' => 0],
            ['nama' => 'Cemas/Gelisah', 'ikon' => '😟', 'skor' => -3],
            ['nama' => 'Sangat Sedih', 'ikon' => '😭', 'skor' => -5],
            ['nama' => 'Marah', 'ikon' => '😡', 'skor' => -4],
        ]);

        // 2. MASTER AKTIVITAS (Mood Tracker)
        // Note: Gunakan 'kategori' jika di migration kamu string, 
        // gunakan 'id_kategori' jika kamu pakai tabel relasi.
        DB::table('master_aktivitas')->insert([
            ['nama_aktivitas' => 'Tidur Cukup', 'id_kategori' => 1, 'label' => 'Fisik'],
            ['nama_aktivitas' => 'Tugas Kuliah', 'id_kategori' => 2, 'label' => 'Kerja'],
            ['nama_aktivitas' => 'Main Sosmed', 'id_kategori' => 3, 'label' => 'Hiburan'],
            ['nama_aktivitas' => 'Bertengkar', 'id_kategori' => 4, 'label' => 'Sosial'],
            ['nama_aktivitas' => 'Olahraga', 'id_kategori' => 1, 'label' => 'Fisik'],
            ['nama_aktivitas' => 'Meeting Kerja', 'id_kategori' => 2, 'label' => 'Kerja'],
            ['nama_aktivitas' => 'Nonton Film', 'id_kategori' => 3, 'label' => 'Hiburan'],
            ['nama_aktivitas' => 'Berkumpul dengan Teman', 'id_kategori' => 4, 'label' => 'Sosial'],
            ['nama_aktivitas' => 'Makan Sehat', 'id_kategori' => 1, 'label' => 'Fisik'],
            ['nama_aktivitas' => 'Bekerja Lembur', 'id_kategori' => 2, 'label' => 'Kerja'],
            ['nama_aktivitas' => 'Main Game', 'id_kategori' => 3, 'label' => 'Hiburan'],
            ['nama_aktivitas' => 'Mengobrol dengan Keluarga', 'id_kategori' => 4, 'label' => 'Sosial'],
        ]);

        // 3. MASTER HABIT
        DB::table('master_habit')->insert([
            ['nama' => 'Minum Air 2L', 'target_harian' => '2 Liter'],
            ['nama' => 'Meditasi', 'target_harian' => '10 Menit'],
            ['nama' => 'Waktu Tidur', 'target_harian' => '7-8 Jam'],
            ['nama' => 'Baca Buku', 'target_harian' => '15 Menit'],
            ['nama' => 'Jogging Pagi', 'target_harian' => '30 Menit'],
            ['nama' => 'Makan Buah', 'target_harian' => '1 Porsi'],
            ['nama' => 'Makan Sayur', 'target_harian' => '1 Porsi'],
            ['nama' => 'Minum Susu', 'target_harian' => '1-2 Gelas'],
            ['nama' => 'No Sosmed', 'target_harian' => '1 Jam'],
            ['nama' => 'Skincare', 'target_harian' => 'Malam'],
        ]);

        // 4. MASTER TEMPLATE JURNAL
        $templates = [
            ['pertanyaan' => 'Apa yang kamu syukuri hari ini?'],
            ['pertanyaan' => 'Apa hal berat yang berhasil kamu lewati?'],
            ['pertanyaan' => 'Bagaimana perasaanmu saat bangun tidur?'],
            ['pertanyaan' => 'Ceritakan momen menyenangkan yang kamu alami hari ini.'],
            ['pertanyaan' => 'Apa tantangan terbesar yang kamu hadapi hari ini?'],
            ['pertanyaan' => 'Siapa orang yang membuat harimu lebih baik?'],
            ['pertanyaan' => 'Apa hal kecil yang membuatmu tersenyum hari ini?'],
            ['pertanyaan' => 'Bagaimana kamu merawat dirimu sendiri hari ini?'],
            ['pertanyaan' => 'Apa tujuan utama yang ingin kamu capai minggu ini?'],
            ['pertanyaan' => 'Ceritakan sesuatu yang baru yang kamu pelajari hari ini.'],
            ['pertanyaan' => 'Apa yang bisa kamu lakukan besok untuk membuat harimu lebih baik?'],
            ['pertanyaan' => 'Bagaimana kamu mengatasi stres hari ini?'],
            ['pertanyaan' => 'Apa hal positif yang bisa kamu ambil dari pengalaman sulit hari ini?'],
            ['pertanyaan' => 'Ceritakan tentang momen kebahagiaan sederhana yang kamu alami.'],
            ['pertanyaan' => 'Apa satu hal yang ingin kamu ubah tentang rutinitas harianmu?'],

        ];
        DB::table('master_template')->insert($templates);

        // 5. MASTER QUOTES
        DB::table('master_quote')->insert([
        // --- Kategori: SUPPORT ---
            ['isi' => 'Tidak apa-apa untuk istirahat sejenak. Dunia bisa menunggu.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Menangis itu valid. Keluarkan saja.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Kamu lebih kuat dari yang kamu kira, tapi sekarang waktunya pulih.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Hari ini berat, dan itu fakta. Kamu tidak lemah karenanya.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Berhenti sebentar bukan berarti menyerah.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Kalau napas terasa sesak, pelan-pelan saja. Tidak perlu buru-buru sembuh.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Kalau hari ini cuma sanggup bertahan, itu sudah cukup.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Ada luka yang nggak minta disembuhkan cepat-cepat.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Kamu capek bukan karena lemah, tapi karena terlalu lama kuat.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Diam juga bentuk bertahan hidup.', 'penulis' => 'ZenMood', 'kategori' => 'support'],
            ['isi' => 'Hari ini kamu boleh nggak punya jawaban.', 'penulis' => 'ZenMood', 'kategori' => 'support'],

            // --- Kategori: MOTIVASI ---
            ['isi' => 'Satu langkah kecil tetaplah langkah maju.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Fokus pada apa yang bisa kamu kendalikan.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Kesulitan hari ini adalah kekuatan di masa depan.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Kamu tidak harus sempurna untuk tetap melangkah.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Progress pelan lebih baik daripada diam di tempat.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Tidak semua hari harus produktif, tapi hari ini masih berarti.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Pelan bukan berarti mundur.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Kamu masih berjalan, meski sambil ragu.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Nggak apa-apa kalau langkahmu kecil, asal tetap milikmu.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Hari ini mungkin biasa, tapi kamu tetap hadir.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],
            ['isi' => 'Kamu belajar, bahkan saat merasa tersesat.', 'penulis' => 'Serinity', 'kategori' => 'motivasi'],

            // --- Kategori: APRESIASI ---
            ['isi' => 'Pertahankan energimu, kamu melakukan hal hebat!', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Jangan lupa berbagi senyum hari ini.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Nikmati momen ini, kamu pantas mendapatkannya.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Kamu datang sejauh ini, itu bukan kebetulan.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Energi kamu hari ini hangat. Gunakan dengan bijak.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Bangga itu boleh. Hari ini kamu layak merasa begitu.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Tenangmu hari ini terasa nyata.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Kamu nggak sekadar bertahan—kamu hidup.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Ada cahaya kecil di caramu menjalani hari.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Energi ini hasil dari proses panjang. Hormati itu.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
            ['isi' => 'Hari ini kamu selaras dengan dirimu sendiri.', 'penulis' => 'Stain', 'kategori' => 'apresiasi'],
        ]);

        // 6. MASTER HEALING PLAN (Sesuai Migration kamu yang kompleks)
        DB::table('master_healing_plan')->insert([
            [
                'judul_aktivitas' => 'Teknik Grounding 5-4-3-2-1', 
                'deskripsi_detail' => 'Sebutkan 5 benda yang dilihat, 4 yang dirasa, 3 suara, 2 bau, dan 1 rasa.',
                'poin_baterai' => 15,
                'kategori' => 'Relaksasi'
            ],
            [
                'judul_aktivitas' => 'Digital Detox 1 Jam', 
                'deskripsi_detail' => 'Jauhkan semua perangkat elektronik. Fokuslah membaca buku fisik.',
                'poin_baterai' => 10,
                'kategori' => 'Mental'
            ],
            [
                'judul_aktivitas' => 'Deep Talk dengan Teman', 
                'deskripsi_detail' => 'Hubungi satu teman dekat dan bicara minimal 15 menit.',
                'poin_baterai' => 12,
                'kategori' => 'Sosial'
            ],

            [
                'judul_aktivitas' => 'Jurnal Syukur 5 Hal', 
                'deskripsi_detail' => 'Tulis 5 hal yang kamu syukuri hari ini di jurnalmu.',
                'poin_baterai' => 8,
                'kategori' => 'Refleksi'
            ],
            [
                'judul_aktivitas' => 'Meditasi 10 Menit', 
                'deskripsi_detail' => 'Lakukan meditasi terpandu selama 10 menit menggunakan aplikasi meditasi favoritmu.',
                'poin_baterai' => 15,
                'kategori' => 'Relaksasi'
            ],
            [
                'judul_aktivitas' => 'Jalan Kaki Pagi', 
                'deskripsi_detail' => 'Jalan santai di sekitar rumah selama 15 menit.',
                'poin_baterai' => 8,
                'kategori' => 'Fisik'
            ],
            [
                'judul_aktivitas' => 'Meditasi Pernapasan', 
                'deskripsi_detail' => 'Fokus pada napas selama 5 menit.',
                'poin_baterai' => 10,
                'kategori' => 'Relaksasi'
            ],
            [
                'judul_aktivitas' => 'Minum Teh Hangat', 
                'deskripsi_detail' => 'Seduh teh favoritmu tanpa gula.',
                'poin_baterai' => 5,
                'kategori' => 'Fisik'
            ],
            [
                'judul_aktivitas' => 'Tidur Siang Singkat', 
                'deskripsi_detail' => 'Tidur siang selama 20 menit untuk menyegarkan pikiran.',
                'poin_baterai' => 10,
                'kategori' => 'Fisik'
            ],
            [
                'judul_aktivitas' => 'Membaca Buku Inspiratif', 
                'deskripsi_detail' => 'Luangkan waktu 15 menit untuk membaca buku yang menginspirasi.',
                'poin_baterai' => 7,
                'kategori' => 'Edukasi'
            ],


        ]);

        // 7. USER AWAL
        DB::table('users')->insert([
            [
                'id_user' => 1,
                'name' => 'nicho', 
                'email' => 'nicho@zenmood.com',
                'password' => bcrypt('123'), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'name' => 'fadhlur', 
                'email' => 'fadhlur@zenmood.com',
                'password' => bcrypt('456'), 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]); 
    }
}
