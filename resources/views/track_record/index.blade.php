@extends('layouts.app') 
@section('content')

<div class="w-full -py-1 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] flex flex-col justify-center">
                <h5 class="text-xl font-bold text-gray-800">Halo, {{ $namaUser }}!</h5>
                <p class="text-gray-500 text-sm mt-1">Ini hasil Track Record Anda</p>                
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-[#7FBC4E] p-6 rounded-2xl shadow-[2px_3px_10px_-3px_rgba(0,0,0,0.25)] flex items-center text-white">
                <div class="flex items-start gap-3">
                    <div class="bg-none/20 p-2 h-10 rounded-full shrink-0">
                        <svg class="-translate-y-1 translate-x-0.5" width="33" height="43" viewBox="0 0 33 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.00562 38.1576C9.00656 38.6858 9.18094 39.2031 9.50813 39.6432L11.1103 41.8007C11.384 42.1695 11.7552 42.472 12.191 42.6813C12.6267 42.8905 13.1134 43 13.6078 43H19.3931C19.8875 43 20.3742 42.8905 20.81 42.6813C21.2457 42.472 21.6169 42.1695 21.8906 41.8007L23.4928 39.6432C23.8199 39.2031 23.9947 38.6863 23.9953 38.1576L23.9991 34.9368H9.00094L9.00562 38.1576ZM0 14.781C0 18.5073 1.54219 21.9069 4.08375 24.5045C5.6325 26.0876 8.055 29.3948 8.97844 32.1847C8.98219 32.2066 8.985 32.2284 8.98875 32.2502H24.0112C24.015 32.2284 24.0178 32.2074 24.0216 32.1847C24.945 29.3948 27.3675 26.0876 28.9163 24.5045C31.4578 21.9069 33 18.5073 33 14.781C33 6.60194 25.5853 -0.0251232 16.4484 7.16017e-05C6.885 0.0261062 0 6.96811 0 14.781ZM16.5 8.0624C12.3647 8.0624 9 11.0765 9 14.781C9 15.5234 8.32875 16.1247 7.5 16.1247C6.67125 16.1247 6 15.5234 6 14.781C6 9.59424 10.71 5.37496 16.5 5.37496C17.3288 5.37496 18 5.97627 18 6.71868C18 7.46109 17.3288 8.0624 16.5 8.0624Z" fill="#FFE8A4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="block text-lg text-white font-semibold">Insight:</p>
                        <p class="text-sm opacity-90 leading-relaxed">{{ $insight }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mt-4 mb-6">
        <button class="bg-white border border-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-full shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Hari ini</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>
        <button class="border border-[#7FBC4E] text-[#7FBC4E] hover:bg-[#7FBC4E] hover:text-white text-sm font-medium px-4 py-2 rounded-full transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 8h-1V3H6v5H5a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2v-6a2 2 0 00-2-2zM8 5h8v3H8V5zm3 12H7v-5h4v5zm6 0h-4v-5h4v5z"/>
            </svg>
            <span>Cetak PDF</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6">
                <h5 class="font-bold text-gray-800 text-lg mb-4">Mood Tracker Emosional</h5>
                <div class="h-[300px] bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 border border-dashed border-gray-200">
                    [Area Grafik Batang Hijau]
                </div>
                <div class="text-center mt-4">
                    <button id="toggle-analysis-main" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-1.5 rounded-full transition-colors inline-flex items-center gap-2">
                        <span id="toggle-analysis-main-label">Buka Analisis ▾</span>
                    </button>
                </div>

                <div id="analysis-main" class="mt-4 bg-[#F0F7E6] p-4 rounded-xl border border-[#E1EFD6] hidden">
                    <strong class="block text-[#4A6B2F] mb-1">Analisis Sistem:</strong>
                    <p class="text-sm text-gray-600 mb-2">Mood anda mengalami penurunan signifikan pada hari tersebut. Data jurnal menunjukkan catatan seperti "Merasa sangat lelah" dan "Kurang tidur", yang konsisten dengan penurunan skor mood di grafik.</p>
                    <strong class="block text-[#4A6B2F] mb-1">Rekomendasi Aktivitas:</strong>
                    <p class="text-sm text-gray-600 mb-2">Prioritaskan tidur 7-8 jam pada hari berikutnya. Coba hentikan kafein setelah jam 15:00 dan lakukan relaksasi ringan sebelum tidur (meditasi 10 menit, peregangan).</p>
                    <strong class="block text-[#4A6B2F] mb-1">Detail Visualisasi:</strong>
                    <p class="text-sm text-gray-600">Grafik batang menunjukkan frekuensi mood sepanjang hari. Batang tinggi pada jam tertentu menunjukkan periode mood yang lebih positif; perhatikan pola waktu (pagi/siang/malam) untuk mengidentifikasi pemicu.</p>
                </div>
            </div>

            <div>
                <h5 class="font-bold text-gray-800 text-lg mb-4">Riwayat Jurnal</h5>
                
                <div class="space-y-4">
                    @for ($i = 1; $i <= 3; $i++)
                    <div class="bg-[#F0F7E6] p-4 rounded-xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] mb-0 border border-transparent hover:border-[#7FBC4E] transition-all">
                        <div class="flex justify-between items-start">
                            <div class="max-w-[75%]">
                                <span class="inline-block bg-[#7FBC4E] text-white text-xs px-3 py-1 rounded-full mb-2">Hari yang produktif untuk berangkat kerja.</span>
                                <p class="text-sm text-gray-600">Baru saja saya berusaha memulai hari ini dengan produktif, karena... <a href="#" class="underline text-[#4A6B2F]">Baca Selengkapnya</a></p>
                            </div>
                            <small class="text-gray-400 text-xs font-medium whitespace-nowrap ml-4">28 Des 2025</small>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="text-center mt-4">
                    <a href="#" class="inline-block bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium px-5 py-2 mt-2 rounded-full shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] transition-all">
                        Lihat Semua Jurnal ›
                    </a>
                </div>
            </div>

        </div> 
        <div class="lg:col-span-4 space-y-8">
            
            <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6 text-center">
                <h5 class="font-bold text-gray-800 text-lg text-left mb-4">Aktivitas Habit Log</h5>
                
                <div class="flex justify-center my-4">
                    <div class="w-44 h-44 rounded-full p-3" style="background: conic-gradient(#7FBC4E 0% {{ $persenHabit }}%, #EEF9EE {{ $persenHabit }}% 100%);">
                        <div class="bg-white rounded-full w-full h-full flex items-center justify-center">
                            <div class="text-center">
                                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $persenHabit }}%</h3>
                                <small class="text-gray-500 text-sm">Tercapai</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-left space-y-4 mt-4">
                    <div class="flex items-start gap-3">
                        <span class="flex-none w-7 h-7 rounded-md bg-[#7FBC4E] text-white flex items-center justify-center shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" stroke="white"/>
                            </svg>
                        </span>
                        <label class="text-gray-700 text-sm font-medium">Olahraga 15 Menit</label>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex-none w-7 h-7 rounded-md bg-[#7FBC4E] text-white flex items-center justify-center shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" stroke="white"/>
                            </svg>
                        </span>
                        <label class="text-gray-700 text-sm font-medium">Minum Air 2 Liter</label>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button id="toggle-analysis-habit" class="bg-white border border-gray-100 text-[#4A6B2F] text-sm font-medium px-5 py-2 rounded-full shadow-[2px_6px_18px_-8px_rgba(0,0,0,0.2)] inline-flex items-center gap-2">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 15l-6-6-6 6"></path>
                        </svg> -->
                        <span id="toggle-analysis-habit-label">Tutup Analisis ▴</span>
                    </button>
                </div>
                <div id="analysis-habit" class="mt-4 bg-[#F7FFF4] p-4 rounded-xl border border-[#E7F6DF] text-left text-sm text-gray-700">
                    <strong class="block text-[#4A6B2F] mb-2">Analisis Sistem</strong>
                    <p class="text-sm">Progres pencapaian habit anda hari ini sudah sangat baik, kurang 20% lagi anda mencapai tahap sempurna. Lanjutkan, semoga konsisten.</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6">
                <h5 class="font-bold text-gray-800 text-lg mb-4">Progres Healing Plan</h5>
                <div class="w-full mb-4">
                    <div class="w-full bg-[#EEF9EE] rounded-full p-1">
                        <div class="bg-[#7FBC4E] text-white font-bold rounded-full h-10 flex items-center justify-center shadow-sm" style="width:75%; min-width:72px;">
                            <span class="px-4">75% Selesai</span>
                        </div>
                    </div>
                </div>
                <ul class="space-y-3 text-sm text-gray-600">
    
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-[#7FBC4E] rounded flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="font-medium">Baca Buku</span>
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-[#7FBC4E] rounded flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="font-medium">Nonton Film</span>
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-[#7FBC4E] rounded flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="font-medium">Stretching Tipis</span>
                    </li>

                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 border-2 border-gray-300 rounded flex items-center justify-center shrink-0 bg-gray-50">
                            </span>
                        <span class="text-gray-400">Berenang (Belum)</span>
                    </li>

                </ul>
                <div class="text-center mt-4">
                    <button id="toggle-analysis-healing" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-medium px-4 py-1.5 rounded-full shadow-sm transition-colors inline-flex items-center gap-2">
                        <span id="toggle-analysis-healing-label">Buka Analisis ▾</span>
                    </button>
                </div>
                <div id="analysis-healing" class="mt-4 bg-[#F7FFF4] p-4 rounded-lg border border-[#E7F6DF] hidden text-left text-sm text-gray-700">
                    <strong class="block text-[#4A6B2F] mb-1">Analisis Healing Plan</strong>
                    <p class="text-sm">Anda sudah melakukan beberapa aktivitas yang disarankan oleh sistem; teruskan kebiasaan baik ini. Prioritaskan tugas yang memberi kepuasan kecil untuk menjaga motivasi.</p>
                </div>
            </div>
        </div>
        </div> </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnMain = document.getElementById('toggle-analysis-main');
        const panelMain = document.getElementById('analysis-main');
        const labelMain = document.getElementById('toggle-analysis-main-label');

        const btnHabit = document.getElementById('toggle-analysis-habit');
        const panelHabit = document.getElementById('analysis-habit');
        const labelHabit = document.getElementById('toggle-analysis-habit-label');

        const btnHealing = document.getElementById('toggle-analysis-healing');
        const panelHealing = document.getElementById('analysis-healing');
        const labelHealing = document.getElementById('toggle-analysis-healing-label');

        function toggle(panel, label, openText, closeText) {
            const isHidden = panel.classList.contains('hidden');
            if (isHidden) {
                panel.classList.remove('hidden');
                label.textContent = closeText;
                panel.classList.add('opacity-0');
                setTimeout(() => panel.classList.remove('opacity-0'), 10);
            } else {
                panel.classList.add('hidden');
                label.textContent = openText;
            }
        }
        if (btnMain && panelMain && labelMain) {
            btnMain.addEventListener('click', () => toggle(panelMain, labelMain, 'Buka Analisis ▾', 'Tutup Analisis ▴'));
        }
        if (btnHabit && panelHabit && labelHabit) {
            btnHabit.addEventListener('click', () => toggle(panelHabit, labelHabit, 'Buka Analisis ▾', 'Tutup Analisis ▴'));
        }
            if (btnHealing && panelHealing && labelHealing) {
                btnHealing.addEventListener('click', () => toggle(panelHealing, labelHealing, 'Buka Analisis ▾', 'Tutup Analisis ▴'));
            }
    });
</script>
@endsection