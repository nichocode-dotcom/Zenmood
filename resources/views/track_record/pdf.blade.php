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
        
        .mt-8 { margin-top: 32px; }
        .mb-4 { margin-bottom: 16px; }
        .p-4 { padding: 16px; }
        .px-8 { padding-left: 32px; padding-right: 32px; }
        
        .bg-zen { background-color: #7FBC4E; }
        .bg-zen-light { background-color: #F0F7E6; }
        .bg-gray-50 { background-color: #F9FAFB; }
        .text-white { color: #ffffff; }
        .text-zen { color: #7FBC4E; }
        .text-zen-dark { color: #4A6B2F; }
        .text-gray-500 { color: #6B7280; }
        .text-gray-400 { color: #9CA3AF; }
        
        .border { border: 1px solid #E5E7EB; }
        .border-zen-light { border-color: #E7F6DF; }
        .rounded { border-radius: 4px; }
        .rounded-lg { border-radius: 8px; }

        .text-xs { font-size: 10px; }
        .text-sm { font-size: 12px; }
        .text-lg { font-size: 18px; }
        .text-2xl { font-size: 24px; }
        
        .header-container { padding: 30px 40px; }
        
        /* Layout Tabel Kolom 2 */
        .table-grid { width: 100%; border-collapse: separate; border-spacing: 15px 0; margin-left: -15px; }
        .table-grid td { vertical-align: top; width: 50%; } /* Paksa 50% agar seimbang */

        .chart-img { width: 100%; height: auto; max-height: 250px; object-fit: contain; }

        .progress-track { background-color: #E5E7EB; height: 6px; border-radius: 99px; overflow: hidden; margin-bottom: 12px; }
        .progress-fill { background-color: #7FBC4E; height: 100%; }

        .check-symbol { font-family: DejaVu Sans, sans-serif; margin-right: 8px; font-size: 14px; }
        .list-item { padding: 8px 0; border-bottom: 1px dashed #eee; display: block; }
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
                <div class="text-gray-500 mb-2">{{ $moodAnalysisText ?? 'Data tidak cukup.' }}</div>

                <strong class="text-zen-dark block mt-2">Rekomendasi Aktivitas:</strong>
                <div class="text-gray-500 mb-2">{{ $moodRecommendationText ?? '-' }}</div>

                <strong class="text-zen-dark block mt-2">Detail Visualisasi:</strong>
                <div class="text-gray-500">{{ $moodDetailText ?? '-' }}</div>
            </div>
        </div>

        <table class="table-grid mb-8">
            <tr>
                <td>
                    <div class="text-zen-dark font-bold text-lg uppercase border-b border-zen-light pb-2 mb-4">
                        Habit Log ({{ $habitPercentage }}%)
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $habitPercentage }}%"></div>
                        </div>

                        @forelse($allHabits as $habit)
                            <div class="list-item text-gray-500">
                                <span class="check-symbol {{ $habit->status ? 'text-zen' : 'text-gray-400' }}">
                                    {{ $habit->status ? '✔' : '○' }}
                                </span>
                                {{ $habit->habit->nama ?? 'Habit' }}
                            </div>
                        @empty
                            <div class="text-xs text-gray-400 italic py-2">Tidak ada data habit.</div>
                        @endforelse
                    </div>
                </td>

                <td>
                    <div class="text-zen-dark font-bold text-lg uppercase border-b border-zen-light pb-2 mb-4">
                        Healing Plan ({{ $healingPercentage }}%)
                    </div>
                    <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $healingPercentage }}%"></div>
                        </div>

                        @forelse($allHealing as $plan)
                            <div class="list-item text-gray-500">
                                {{-- FIX: status -> is_completed --}}
                                <span class="check-symbol {{ $plan->is_completed ? 'text-zen' : 'text-gray-400' }}">
                                    {{ $plan->is_completed ? '✔' : '○' }}
                                </span>
                                {{-- FIX: relasi masterHealing & judul_aktivitas --}}
                                {{ $plan->masterHealing->judul_aktivitas ?? 'Aktivitas Healing' }}
                            </div>
                        @empty
                            <div class="text-xs text-gray-400 italic py-2">Tidak ada healing plan.</div>
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
                        ⏰ {{ \Carbon\Carbon::parse($jurnal->created_at)->format('H:i') }} | {{ $jurnal->judul ?? 'Tanpa Judul' }}
                    </span>
                    <div class="text-sm text-gray-500 leading-relaxed">
                        {{-- FIX: isi -> isi_teks --}}
                        {{ $jurnal->isi_teks ?? $jurnal->isi ?? '-' }}
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