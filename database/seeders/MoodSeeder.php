<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mood;
use App\Models\User;
use Carbon\Carbon;

class MoodSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error("Tabel User kosong! Jalankan UserSeeder terlebih dahulu.");
            return;
        }

        $userId = $user->id_user; 
        $today = Carbon::now()->format('Y-m-d'); 

        Mood::create([
            'id_user' => $userId,
            'id_emosi' => 1,
            'id_aktivitas' => 1,
            
            'tanggal' => $today,
            'jam' => '07:00:00',
            'kategori_aktivitas' => 'Kesehatan Fisik',
            'faktor_sistem' => 'Kualitas Tidur Baik',
            'skor' => 9,
            
            'faktor_note' => 'Bangun tidur terasa sangat segar karena tidur cukup 8 jam.',
            'hal_disyukuri' => 'Bisa menghirup udara pagi yang cerah.',
            
            'created_at' => Carbon::now()->setTime(7, 0, 0)
        ]);

        Mood::create([
            'id_user' => $userId,
            'id_emosi' => 3, 
            'id_aktivitas' => 2, 
            
            'tanggal' => $today,
            'jam' => '12:30:00',
            'kategori_aktivitas' => 'Produktivitas',
            'faktor_sistem' => 'Beban Tugas',
            'skor' => 6,
            
            'faktor_note' => 'Lumayan pusing dengan tugas yang menumpuk, tapi masih terkendali.',
            'hal_disyukuri' => 'Makan siang yang enak.',
            
            'created_at' => Carbon::now()->setTime(12, 30, 0)
        ]);

        Mood::create([
            'id_user' => $userId,
            'id_emosi' => 4, 
            'id_aktivitas' => 2, 
            
            'tanggal' => $today,
            'jam' => '16:00:00',
            'kategori_aktivitas' => 'Produktivitas',
            'faktor_sistem' => 'Deadline Mendesak',
            'skor' => 4,
            
            'faktor_note' => 'Energi mulai habis dan deadline semakin dekat.',
            'hal_disyukuri' => 'Teman satu tim yang suportif.',
            
            'created_at' => Carbon::now()->setTime(16, 0, 0)
        ]);

        Mood::create([
            'id_user' => $userId,
            'id_emosi' => 2, 
            'id_aktivitas' => 3, 
            
            'tanggal' => $today,
            'jam' => '20:00:00',
            'kategori_aktivitas' => 'Diri Sendiri',
            'faktor_sistem' => 'Waktu Luang',
            'skor' => 8,
            
            'faktor_note' => 'Menonton film favorit sambil bersantai.',
            'hal_disyukuri' => 'Bisa beristirahat di kasur yang nyaman.',
            
            'created_at' => Carbon::now()->setTime(20, 0, 0)
        ]);
    }
}