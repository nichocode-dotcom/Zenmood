@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-transparent p-6"> <div class="max-w-6xl mx-auto mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm text-center relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-gray-500 italic text-sm mb-1">“{{ $quote }}”</p>
                <p class="text-[#7FBC4E] font-bold text-xs">ZenMood</p>
            </div>
            <div class="absolute top-0 left-0 w-full h-1 bg-[#7FBC4E]"></div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">

        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-[#7FBC4E] rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                <h3 class="font-medium mb-6">Kondisi Mental</h3>
                
                <div class="relative h-4 bg-white/30 rounded-full mb-4">
                    <div class="absolute top-0 left-0 h-full bg-white rounded-full transition-all duration-1000" style="width: {{ $mentalConditionPercent }}%"></div>
                    <div class="absolute top-1/2 -translate-y-1/2 h-8 w-8 bg-white rounded-full shadow-md transition-all duration-1000" style="left: {{ $mentalConditionPercent }}%"></div>
                </div>

                <p class="font-bold text-lg mt-2">Persentase Saat Ini: {{ $mentalConditionPercent }}%</p>
                
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <h3 class="text-[#7FBC4E] font-bold text-center mb-6">Recent Activities</h3>
                <div class="space-y-3">
                    @forelse($recentActivities as $activity)
                    <div class="flex items-center bg-[#7FBC4E] text-white rounded-full px-4 py-3 shadow-sm">
                        <span class="font-bold text-xs w-20">{{ \Carbon\Carbon::parse($activity->created_at)->format('h:i A') }}</span>
                        <div class="mx-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-medium text-sm flex-1 text-center">{{ $activity->aktivitas->nama ?? 'Aktivitas Umum' }}</span>
                    </div>
                    @empty
                    <p class="text-gray-400 text-center text-sm italic">Belum ada aktivitas hari ini.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-50">
                <h3 class="text-[#4A6B2F] font-bold mb-4">Mood Tracker Emosional</h3>
                <div class="relative h-48 w-full">
                    <canvas id="dashboardMoodChart"></canvas>
                </div>
                <div class="flex justify-between px-2 mt-2 text-xs text-gray-400">
                    <span class="text-center">😆<br>Sangat Bahagia</span>
                    <span class="text-center">😊<br>Senang</span>
                    <span class="text-center">😐<br>Biasa Saja</span>
                    <span class="text-center">😔<br>Sedih</span>
                    <span class="text-center">😡<br>Marah</span>
                </div>
            </div>

            <div class="bg-[#7FBC4E] rounded-3xl p-6 text-white shadow-lg">
                <h3 class="font-medium mb-4">Progres Pencapaian Habit</h3>
                
                <div class="relative h-4 bg-black/20 rounded-full mb-2 overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-white rounded-full transition-all duration-1000" style="width: {{ $habitPercent }}%"></div>
                </div>
                
                <div class="relative w-full h-4 -mt-6 mb-6">
                     <div class="absolute top-0 h-6 w-6 bg-white border-4 border-[#7FBC4E] rounded-full shadow-sm transition-all duration-1000" style="left: calc({{ $habitPercent }}% - 10px)"></div>
                </div>

                <p class="text-sm font-medium opacity-90">{{ $doneHabit }} dari {{ $totalHabit }} selesai</p>
            </div>

        </div>
        
        <div class="lg:col-span-12">
            <div class="bg-white rounded-3xl p-4 shadow-sm flex items-center justify-between border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full border-2 border-[#7FBC4E] flex items-center justify-center text-[#7FBC4E]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#7FBC4E] text-lg leading-none">Digital Detox</h4>
                        <p class="text-xs text-gray-500">Sleep</p>
                    </div>
                    <div class="hidden md:block text-xs text-gray-400 ml-4 border-l pl-4">
                        Puasa dari media sosial menjelang tidur
                    </div>
                </div>
                <button class="bg-[#7FBC4E] hover:bg-[#6da842] text-white text-xs font-bold py-2 px-6 rounded-full shadow-md transition-colors">
                    Pilih Rekomendasi
                </button>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardMoodChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Skor Mood',
                data: @json($chartValues),
                backgroundColor: '#7FBC4E',
                borderRadius: 4,
                barThickness: 20,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false, min: 0, max: 10 },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
</script>
@endsection