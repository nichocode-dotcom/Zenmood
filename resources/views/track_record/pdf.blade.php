<!DOCTYPE html>
<html>
<head>
    <title>Laporan ZenMood</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; font-family: sans-serif; color: #374151; background-color: #ffffff; font-size: 14px; }
        
        .w-full { width: 100%; }
        .h-auto { height: auto; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .relative { position: relative; }
        
        .m-0 { margin: 0; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .mt-8 { margin-top: 32px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 16px; }
        .p-4 { padding: 16px; }
        .p-8 { padding: 32px; }
        .px-8 { padding-left: 32px; padding-right: 32px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        
        .bg-zen { background-color: #7FBC4E; }
        .bg-zen-light { background-color: #F0F7E6; }
        .bg-gray-50 { background-color: #F9FAFB; }
        .bg-gray-100 { background-color: #F3F4F6; }
        .bg-white { background-color: #ffffff; }
        
        .text-white { color: #ffffff; }
        .text-zen { color: #7FBC4E; }
        .text-zen-dark { color: #4A6B2F; }
        .text-gray-500 { color: #6B7280; }
        .text-gray-400 { color: #9CA3AF; }
        
        .border { border: 1px solid #E5E7EB; }
        .border-zen-light { border-color: #E7F6DF; }
        .rounded { border-radius: 4px; }
        .rounded-lg { border-radius: 8px; }
        .rounded-full { border-radius: 9999px; }

        .text-xs { font-size: 10px; }
        .text-sm { font-size: 12px; }
        .text-lg { font-size: 18px; }
        .text-xl { font-size: 20px; }
        .text-2xl { font-size: 24px; }
        
        .header-container {
            padding: 30px 40px;
        }
        
        .table-grid { width: 100%; border-collapse: collapse; }
        .table-grid td { vertical-align: top; }
        .w-half { width: 48%; }
        .w-gap { width: 4%; }

        .chart-img {
            width: 100%;
            height: auto;
            max-height: 250px;
            object-fit: contain;
        }

        .progress-track {
            background-color: #E5E7EB;
            height: 6px;
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        .progress-fill {
            background-color: #7FBC4E;
            height: 100%;
        }

        .check-symbol {
            font-family: DejaVu Sans, sans-serif; 
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <div class="bg-zen text-white header-container">
        <table class="w-full">
            <tr>
                <td>
                    <div class="text-2xl font-bold tracking-wide">ZenMood</div>
                    <div class="text-sm opacity-90 mt-1">Mental Health Tracker Report</div>
                </td>
                <td class="text-right">
                    <div class="text-lg font-bold">{{ $user->name }}</div>
                    <div class="text-xs opacity-90 mt-1">
                        {{ \Carbon\Carbon::parse($selectedDate)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="px-8 mt-8">

        <div class="bg-zen-light border-l-4 border-zen p-4 rounded text-zen-dark text-sm mb-8">
            <strong class="block mb-1">💡 Insight Hari Ini:</strong>
            {{ $insightMessage }}
        </div>

        <div class="mb-8">
            <div class="text-zen-dark font-bold text-lg uppercase border-b border-zen-light pb-2 mb-4">
                Mood Tracker Emosional
            </div>
            
            <div class="border border-gray-100 rounded-lg p-2 mb-4 text-center">
                <img src="{{ $chartUrl }}" class="chart-img" alt="Grafik Mood">
            </div>

            <div class="bg-gray-50 border border-zen-light rounded-lg p-4 text-sm leading-relaxed">
                <strong class="text-zen-dark block">Analisis Sistem:</strong>
                <div class="text-gray-500 mb-2">{{ $moodAnalysisText ?? 'Data tidak cukup untuk analisis.' }}</div>

                <strong class="text-zen-dark block mt-2">Rekomendasi Aktivitas:</strong>
                <div class="text-gray-500 mb-2">{{ $moodRecommendationText ?? 'Belum ada rekomendasi spesifik.' }}</div>

                <strong class="text-zen-dark block mt-2">Detail Visualisasi:</strong>
                <div class="text-gray-500">{{ $moodDetailText ?? 'Grafik belum terbentuk sempurna.' }}</div>
            </div>
        </div>

        <table class="table-grid mb-8">
            <tr>
                <td class="w-half">
                    <div class="text-zen-dark font-bold text-lg uppercase border-b border-zen-light pb-2 mb-4">
                        Habit Log ({{ $habitPercentage }}%)
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4">
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $habitPercentage }}%"></div>
                        </div>

                        @forelse($allHabits as $habit)
                            <div class="text-sm py-2 border-b border-dashed border-gray-100 text-gray-500">
                                <span class="check-symbol {{ $habit->status ? 'text-zen' : 'text-gray-400' }}">
                                    {{ $habit->status ? '✔' : '○' }}
                                </span>
                                {{ $habit->habit->nama ?? 'Habit' }}
                            </div>
                        @empty
                            <div class="text-xs text-gray-400 italic">Tidak ada data habit.</div>
                        @endforelse
                    </div>
                </td>

                <td class="w-gap"></td>

                <td class="w-half">
                    <div class="text-zen-dark font-bold text-lg uppercase border-b border-zen-light pb-2 mb-4">
                        Healing Plan ({{ $healingPercentage }}%)
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4">
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $healingPercentage }}%"></div>
                        </div>

                        @forelse($allHealing as $plan)
                            <div class="text-sm py-2 border-b border-dashed border-gray-100 text-gray-500">
                                <span class="check-symbol {{ $plan->status ? 'text-zen' : 'text-gray-400' }}">
                                    {{ $plan->status ? '✔' : '○' }}
                                </span>
                                {{ $plan->masterHealingPlan->nama_kegiatan ?? 'Kegiatan' }}
                            </div>
                        @empty
                            <div class="text-xs text-gray-400 italic">Tidak ada healing plan.</div>
                        @endforelse
                    </div>
                </td>
            </tr>
        </table>

        <div class="mb-8">
            <div class="text-zen-dark font-bold text-lg uppercase border-b border-zen-light pb-2 mb-4">
                Riwayat Jurnal
            </div>
            @forelse($journals as $jurnal)
                <div class="bg-gray-50 border-l-4 border-gray-400 p-3 mb-2 rounded-r">
                    <span class="text-zen font-bold text-xs block mb-1">
                        ⏰ {{ \Carbon\Carbon::parse($jurnal->created_at)->format('H:i') }}
                    </span>
                    <div class="text-sm text-gray-500 leading-relaxed">
                        {{ $jurnal->isi }}
                    </div>
                </div>
            @empty
                <div class="text-xs text-gray-400 italic">Tidak ada jurnal yang ditulis pada tanggal ini.</div>
            @endforelse
        </div>

    </div>

    <div class="text-center text-xs text-gray-400 p-4 border-t border-gray-100 mt-8 fixed bottom-0 w-full bg-white">
        Dokumen ini dibuat otomatis oleh ZenMood | Referensi Konsultasi Psikolog
    </div>

</body>
</html>