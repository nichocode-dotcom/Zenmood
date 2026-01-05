@extends('layouts.app') 
@section('content')

<div class="w-full -py-1 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] flex flex-col justify-center">
                <h5 class="text-xl font-bold text-gray-800">Halo, {{ $user->name }}!</h5>
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
                        <p class="text-sm opacity-90 leading-relaxed">{{ $insightMessage }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mt-4 mb-6">
        <form action="{{ route('track-record') }}" method="GET" class="flex items-center gap-2">
    
            <div class="relative">
                <input 
                    type="date" 
                    name="date" 
                    value="{{ $selectedDate }}" 
                    class="pl-10 pr-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-full shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] focus:outline-none focus:ring-2 focus:ring-[#7FBC4E] cursor-pointer"
                    onchange="this.form.submit()" 
                >
                
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            @if($selectedDate != \Carbon\Carbon::now()->format('Y-m-d'))
                <a href="{{ route('track-record', ['date' => \Carbon\Carbon::now()->format('Y-m-d')]) }}"
                    class="group flex items-center gap-2 px-4 py-2 bg-white border border-[#7FBC4E] text-[#7FBC4E] text-sm font-medium rounded-full shadow-sm hover:bg-[#7FBC4E] hover:text-white transition-all duration-300 transform hover:-translate-y-0.5">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    
                    <span>Kembali ke Hari Ini</span>
                </a>
            @endif

        </form>
        <a href="{{ route('track-record.cetak', ['date' => $selectedDate]) }}" target="_blank" class="border border-[#7FBC4E] text-[#7FBC4E] hover:bg-[#7FBC4E] hover:text-white text-sm font-medium px-4 py-2 rounded-full transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 8h-1V3H6v5H5a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2v-6a2 2 0 00-2-2zM8 5h8v3H8V5zm3 12H7v-5h4v5zm6 0h-4v-5h4v5z"/>
            </svg>
            <span>Cetak PDF</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6">
                <h5 class="font-bold text-gray-800 text-lg mb-4">Mood Tracker Emosional</h5>

                @if(count($chartValues) > 0)
                    
                    <div class="w-full relative" style="height: 350px;">
                        <canvas id="moodChart"></canvas>
                    </div>

                    <div class="text-center mt-6">
                        <button id="toggle-analysis-main" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-1.5 rounded-full transition-colors inline-flex items-center gap-2">
                            <span id="toggle-analysis-main-label">Buka Analisis ▾</span>
                        </button>
                    </div>

                    <div id="analysis-main" class="mt-4 bg-[#F0F7E6] p-4 rounded-xl border border-[#E1EFD6] hidden">
                        <strong class="block text-[#4A6B2F] mb-1">Analisis Sistem:</strong>
                        <p class="text-sm text-gray-600 mb-2">{{ $moodAnalysisText }}</p>
                        
                        <strong class="block text-[#4A6B2F] mb-1">Rekomendasi Aktivitas:</strong>
                        <p class="text-sm text-gray-600 mb-2">{{ $moodRecommendationText }}</p>
                        
                        <strong class="block text-[#4A6B2F] mb-1">Detail Visualisasi:</strong>
                        <p class="text-sm text-gray-600">{{ $moodDetailText }}</p>
                    </div>

                @else
                    
                    <div class="w-full h-[350px] flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        
                        <p class="text-sm font-medium text-gray-500">Belum ada data mood hari ini</p>
                        <p class="text-xs mt-1 text-gray-400">Silakan rekam mood Anda di menu Mood Tracker</p>
                        
                        <a href="{{ url('/mood-tracker') }}" class="mt-4 px-4 py-2 bg-white border border-gray-300 rounded-full text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
                            + Input Mood Sekarang
                        </a>
                    </div>

                @endif
                
            </div>

            <div>
                <h5 class="font-bold text-gray-800 text-lg mb-4">Riwayat Jurnal</h5>
                
                <div class="space-y-4">
                    @forelse($journals as $jurnal)
                    <div class="bg-[#F0F7E6] p-4 rounded-xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] mb-0 border border-transparent hover:border-[#7FBC4E] transition-all">
                        <div class="flex justify-between items-start">
                            <div class="max-w-[75%]">
                                <span class="inline-block bg-[#7FBC4E] text-white text-xs px-3 py-1 rounded-full mb-2">Jurnal Harian</span>
                                
                                <h4 class="font-bold text-[#4A6B2F] mb-1">{{ $jurnal->judul ?? 'Jurnal Harian' }}</h4>
                                <p class="text-sm text-gray-600">
                                    {{ Str::limit($jurnal->isi_teks, 100) }} 
                                    <button type="button" 
                                        onclick="openJournalModal(
                                            '{{ \Carbon\Carbon::parse($jurnal->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}', 
                                            '{{ addslashes($jurnal->judul) }}', 
                                            {{ json_encode($jurnal->isi_teks) }} {{-- Menggunakan json_encode agar baris baru aman --}}
                                        )"
                                        class="underline text-[#4A6B2F] font-bold ml-1 cursor-pointer focus:outline-none">
                                        Baca Selengkapnya
                                    </button>
                                </p>
                            </div>
                            <small class="text-gray-400 text-xs font-medium whitespace-nowrap ml-4">
                                {{ \Carbon\Carbon::parse($jurnal->created_at)->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">
                        Belum ada jurnal hari ini.
                    </div>
                    @endforelse
                </div>
            </div>

        </div> 
        <div class="lg:col-span-4 space-y-8">
            
            <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6 text-center">
                <h5 class="font-bold text-gray-800 text-lg text-left mb-4">Aktivitas Habit Log</h5>
                
                <div class="flex justify-center my-4">
                    <div class="w-44 h-44 rounded-full p-3" style="background: conic-gradient(#7FBC4E 0% {{ $habitPercentage }}%, #EEF9EE {{ $habitPercentage }}% 100%);">
                        <div class="bg-white rounded-full w-full h-full flex items-center justify-center">
                            <div class="text-center">
                                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $habitPercentage }}%</h3>
                                <small class="text-gray-500 text-sm">Tercapai</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-left space-y-4 mt-4">
                    @foreach($allHabits as $habit)
                    <div class="flex items-start gap-3">
                        <span class="flex-none w-7 h-7 rounded-md {{ $habit->status ? 'bg-[#7FBC4E]' : 'bg-gray-300' }} text-white flex items-center justify-center shadow-sm">
                            @if($habit->status)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" stroke="white"/>
                                </svg>
                            @else
                                <span class="text-white font-bold">-</span>
                            @endif
                        </span>
                        <label class="text-gray-700 text-sm font-medium">
                            {{ $habit->habit->nama ?? 'Habit' }}
                        </label>
                    </div>
                    @endforeach
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
                    <p class="text-sm">{{ $habitAnalysis }}</p>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-50">
                <h3 class="text-[#4A6B2F] font-bold mb-4">Progres Healing Plan</h3>
                
                <div class="relative h-9 bg-[#EEF9EE] rounded-full mb-6 overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-[#7FBC4E] rounded-full transition-all duration-1000" 
                        style="width: {{ $healingPercentage }}%"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-sm font-bold {{ $healingPercentage > 55 ? 'text-white' : 'text-[#4A6B2F]' }}">
                            {{ $healingPercentage }}% Selesai
                        </span>
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    @forelse($allHealing as $plan)
                        <div class="flex items-center gap-3">
                            <div class="flex-none w-6 h-6 rounded border-2 flex items-center justify-center transition-colors
                                {{ $plan->is_completed ? 'bg-[#7FBC4E] border-[#7FBC4E]' : 'border-gray-300 bg-white' }}">
                                @if($plan->is_completed)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-medium {{ $plan->is_completed ? 'text-gray-400 line-through' : 'text-gray-600' }}">
                                {{ $plan->masterHealing->judul_aktivitas ?? 'Aktivitas Healing' }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-400 text-xs italic">
                            Belum ada rencana healing pada tanggal ini.
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <button id="toggle-analysis-healing" class="bg-white border border-gray-100 text-[#4A6B2F] text-sm font-medium px-5 py-2 rounded-full shadow-[2px_6px_18px_-8px_rgba(0,0,0,0.2)] inline-flex items-center gap-2 hover:bg-gray-50 transition-colors">
                        <span id="toggle-analysis-healing-label">Buka Analisis ▾</span>
                    </button>
                </div>

                <div id="analysis-healing" class="mt-4 bg-[#F7FFF4] p-4 rounded-xl border border-[#E7F6DF] hidden text-left text-sm text-gray-700 animate-in fade-in slide-in-from-top-2 duration-300">
                    <strong class="block text-[#4A6B2F] mb-1 font-bold">Analisis Healing Plan</strong>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $healingAnalysis }}
                    </p>
                </div>
            </div>
        </div>
        </div> </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    function openJournalModal(date, title, body) {
        const modal = document.getElementById('journalModal');
        const container = document.getElementById('modalContainer');
        
        // Isi Data
        document.getElementById('modalDate').innerText = date;
        document.getElementById('modalTitle').innerText = title || 'Jurnal Harian';
        document.getElementById('modalBody').innerText = body;

        // Tampilkan Modal dengan Animasi
        modal.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeJournalModal() {
        const modal = document.getElementById('journalModal');
        const container = document.getElementById('modalContainer');

        // Sembunyikan dengan Animasi
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Menutup modal jika klik di area hitam (luar modal)
    window.onclick = function(event) {
        const modal = document.getElementById('journalModal');
        if (event.target == modal) {
            closeJournalModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('moodChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels), 
                    datasets: [{
                        label: 'Tingkat Mood',
                        data: @json($chartValues), 
                        backgroundColor: @json($chartColors), 
                        borderRadius: 10,
                        barThickness: 40, // Paksa tebal batang agar terlihat
                        minBarLength: 5,  // Batang tetap muncul sedikit meski skor rendah
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            enabled: true // Gunakan tooltip default agar lebih stabil
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: 10, // Memastikan skor 1-10 terlihat tinggi memenuhi canvas
                            grid: {
                                display: true,
                                color: '#F3F4F6',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                stepSize: 1, // Memunculkan garis bantu setiap kenaikan 1 skor
                                display: false // Tetap sembunyikan angka di samping agar bersih
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { padding: 10 } // Memberi jarak antara batang dan jam agar tidak terlalu mepet
                        }
                    }
                }
            });
        }

        // --- 2. SCRIPT TOGGLE ANALISIS (TETAP SAMA) ---
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

<div id="journalModal" class="fixed inset-0 z-[999] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity duration-300">
    
    <div class="bg-white rounded-[32px] w-full max-w-2xl p-8 shadow-2xl relative transform transition-all duration-300 scale-95 opacity-0" id="modalContainer">
        
        <div class="flex justify-between items-start mb-6">
            <div class="bg-white border border-[#7FBC4E] text-[#7FBC4E] px-4 py-1.5 rounded-full text-xs font-bold" id="modalDate">
                </div>
            <div class="flex gap-4">
                <button onclick="closeJournalModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <h2 class="text-[#4A6B2F] text-4xl font-extrabold mb-4" id="modalTitle">
            </h2>
        
        <div class="flex text-yellow-400 mb-6 text-xl">
            <i class="fas fa-star"></i> <i class="fas fa-star mx-1"></i> <i class="fas fa-star"></i>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <p class="text-gray-600 leading-relaxed text-lg" id="modalBody" style="white-space: pre-wrap; word-break: break-word;">
                </p>
        </div>
    </div>
</div>

@endsection