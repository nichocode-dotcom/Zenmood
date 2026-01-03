@extends('layouts.app')

@section('title', 'Healing Plan - ZenMood')

@section('content')
    <div class="min-h-screen bg-gray-50 font-poppins">
        <div class="container mx-auto px-4 py-6 max-w-[1500px]"> 
            <div class="relative bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100 mb-8"> 
                <div class="absolute right-0 top-0 h-full w-2/2 opacity-100 pointer-events-none">
                    <img src="{{ asset('/img/image1.svg') }}" class="h-full w-full ">
                </div>


                <div class="relative p-6 md:px-12 md:py-8 flex flex-col md:flex-row items-center justify-between gap-4"> 
                    <div class="w-full md:w-3/5">
                        <h1 class="text-3xl font-bold text-[#4A6B2F] mb-2">Hai, Salsa!</h1> 
                        
                        <div class="inline-flex items-center gap-2 text-[#558B2F] px-3 py-1.5 rounded-2xl shadow-sm mb-5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-semibold text-sm tracking-wide">{{ $formattedDate }}</span>
                        </div>

                        <div class="space-y-3">
                            <div class="w-full bg-gray-100 rounded-full h-8 p-1.5 shadow-inner relative"> 
                                <div class="h-full rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-4"
                                     style="width: {{ $energyPercentage }}%; background: linear-gradient(90deg, #558B2F 0%, #72B940 100%);">
                                    @if($energyPercentage > 15)
                                        <span class="text-white font-bold text-xs">{{ $energyPercentage }}%</span>
                                    @endif
                                </div>
                                <div class="absolute top-1/2 -translate-y-1/2 transition-all duration-1000 ease-out"
                                     style="left: calc({{ $energyPercentage }}% - 15px);">
                                    <div class="bg-white p-1 rounded-full shadow-md border border-gray-100">
                                        <span class="text-xl">🪨</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[#558B2F] font-bold text-lg italic">
                                Energi harianmu: <span class="text-[#72B940]">{{ $energyPercentage }}% Terisi</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Header -->

            <!-- Rekomendasi Utama -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-[#558B2F] mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 bg-[#558B2F] rounded-full"></span>
                    Rekomendasi utama saat ini
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $mainRecommendations = [
                            [
                                'title' => 'Digital Detox',
                                'category' => 'Teknologi',
                                'description' => 'Puas dari media sosial dapat membantu menjalani hari dengan lebih produktif dan fokus.',
                                'color' => 'bg-gradient-to-r from-[#558B2F] to-[#72B940]',
                                'icon' => 'phone.svg'
                            ],
                            [
                                'title' => 'Jurnal',
                                'category' => 'Refleksi',
                                'description' => 'Menulis jurnal sebelum tidur dapat membantu merapikan pikiran dan memperbaiki kualitas tidur.',
                                'color' => 'bg-gradient-to-r from-[#72B940] to-[#A3E635]',
                                'icon' => 'Vector.svg'
                            ],
                            [
                                'title' => 'Tidur Cukup',
                                'category' => 'Kesehatan',
                                'description' => 'Puas dari media sosial menjelang tidur dapat meningkatkan kualitas istirahat.',
                                'color' => 'bg-gradient-to-r from-[#558B2F] to-[#72B940]',
                                'icon' => 'solar_sleeping-bold.svg'
                            ]
                        ];
                    @endphp
                    
                    @foreach($mainRecommendations as $recommendation)
                        <div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 cursor-pointer group border border-gray-100 flex flex-col" 
                             onclick="showActivityPopup('{{ $recommendation['title'] }}', '{{ $recommendation['category'] }}', '{{ $recommendation['description'] }}')">
                            
                            <div class="{{ $recommendation['color'] }} h-3 w-full"></div>
                            
                            <div class="p-8 flex-grow">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                                            <img src="{{ asset('img/' . $recommendation['icon']) }}" 
                                                alt="{{ $recommendation['title'] }}" 
                                                class="w-10 h-10 object-contain">
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-xl text-[#558B2F] leading-tight">{{ $recommendation['title'] }}</h3>
                                            <span class="text-xs font-bold text-[#72B940] uppercase tracking-[0.1em]">{{ $recommendation['category'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-[#4A7829] mb-8 line-clamp-3 text-sm leading-relaxed font-medium">
                                    {{ $recommendation['description'] }}
                                </p>
                                
                                <div class="flex justify-between items-center pt-6 border-t border-gray-50 mt-auto">
                                    <button onclick="showActivityDetail(
                                        '{{ $recommendation['title'] }}', 
                                        '{{ $recommendation['category'] }}', 
                                        '{{ $recommendation['description'] }}',
                                        ['Cari posisi yang nyaman', 'Atur timer 5 menit', 'Fokus pada pernapasan'],
                                        50
                                    )" class="text-[#558B2F] hover:text-[#72B940] font-bold text-sm flex items-center transition-colors">
                                        Lihat rekomendasi
                                        <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                    <span class="text-[10px] font-black bg-green-50 text-[#558B2F] px-4 py-1.5 rounded-full uppercase tracking-tighter">
                                        Direkomendasikan
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Alternatif Kegiatan -->
            <div class="mb-16">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-[#558B2F] flex items-center gap-3">
                        <span class="w-2 h-8 bg-[#558B2F] rounded-full"></span>
                        Alternatif Kegiatan Lainnya
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                    @php
                        $alternativeActivities = [
                            ['title' => 'Meditasi Pagi', 'category' => 'Relaksasi', 'icon' => '🧘', 'color' => 'bg-gradient-to-br from-[#72B940] to-[#558B2F]'],
                            ['title' => 'Stretching', 'category' => 'Olahraga', 'icon' => '🤸', 'color' => 'bg-gradient-to-br from-teal-400 to-[#558B2F]'],
                            ['title' => 'Teh Pagi', 'category' => 'Ritual', 'icon' => '🍵', 'color' => 'bg-gradient-to-br from-[#A3E635] to-[#72B940]'],
                            ['title' => 'Jalan Kaki', 'category' => 'Olahraga', 'icon' => '🚶', 'color' => 'bg-gradient-to-br from-blue-400 to-[#558B2F]'],
                            ['title' => 'Baca Buku', 'category' => 'Edukasi', 'icon' => '📚', 'color' => 'bg-gradient-to-br from-purple-400 to-[#72B940]'],
                        ];
                    @endphp
                    
                    @foreach($alternativeActivities as $activity)
                        <div class="bg-white rounded-[2rem] shadow-sm p-6 hover:shadow-lg transition-all duration-300 cursor-pointer border border-gray-50 flex flex-col items-center text-center group"
                             onclick="showActivityPopup('{{ $activity['title'] }}', '{{ $activity['category'] }}', 'Aktivitas ini dirancang untuk menenangkan pikiran dan memulihkan energi Anda.')">
                            
                            <div class="{{ $activity['color'] }} w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-5 text-white shadow-lg shadow-green-100 group-hover:rotate-6 transition-transform">
                                {{ $activity['icon'] }}
                            </div>
                            <h3 class="font-bold text-[#558B2F] mb-2">{{ $activity['title'] }}</h3>
                            <span class="text-xs font-semibold text-[#72B940] mb-4 uppercase tracking-tighter">{{ $activity['category'] }}</span>
                            
                            <p class="text-[11px] text-[#4A7829] mb-6 line-clamp-2 leading-relaxed">
                                Aktivitas ini dirancang untuk menenangkan pikiran dan memulihkan energi Anda.
                            </p>
                            
                            <button class="text-[#558B2F] hover:text-[#72B940] text-xs font-bold py-2 px-4 bg-green-50 rounded-lg w-full transition-colors">
                                Pilih
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> <!-- End container -->

        <!-- Activity Popup -->
        <div id="activityPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <!-- Popup Header -->
                <div class="bg-gradient-to-r from-[#558B2F] to-[#72B940] p-6 rounded-t-2xl">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 id="popupTitle" class="text-2xl font-bold text-white mb-2"></h2>
                            <span id="popupCategory" class="inline-block bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm"></span>
                        </div>
                        <button onclick="closePopup()" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Popup Content -->
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="font-semibold text-[#2D3748] mb-3">Deskripsi Aktivitas</h3>
                        <p id="popupDescription" class="text-[#4A5568]"></p>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-[#2D3748] mb-3">Durasi</h3>
                        <div class="flex space-x-3">
                            <button class="flex-1 py-2 border border-gray-300 rounded-lg text-[#4A5568] hover:border-[#558B2F] hover:text-[#558B2F] transition-colors">
                                15 menit
                            </button>
                            <button class="flex-1 py-2 border border-[#558B2F] bg-gradient-to-r from-[#558B2F] to-[#72B940] text-white rounded-lg">
                                30 menit
                            </button>
                            <button class="flex-1 py-2 border border-gray-300 rounded-lg text-[#4A5568] hover:border-[#558B2F] hover:text-[#558B2F] transition-colors">
                                60 menit
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-[#2D3748] mb-3">Waktu</h3>
                        <div class="flex items-center space-x-3">
                            <input type="time" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#558B2F] text-[#4A5568]">
                            <span class="text-gray-500">-</span>
                            <input type="time" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#558B2F] text-[#4A5568]">
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button onclick="closePopup()" class="flex-1 py-3 border border-gray-300 text-[#4A5568] rounded-lg hover:border-gray-400 transition-colors">
                            Nanti
                        </button>
                        <button class="flex-1 py-3 bg-gradient-to-r from-[#558B2F] to-[#72B940] text-white rounded-lg hover:opacity-90 transition-opacity">
                            Tambahkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Detail Popup -->
        <div id="activityDetailPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <!-- ... kode popup detail dari sebelumnya ... -->
        </div>
    </div> <!-- End min-h-screen -->
@endsection


@push('scripts')
<script>
    // Function untuk menampilkan popup
    function showActivityPopup(title, category, description) {
        const popup = document.getElementById('activityPopup');
        const popupTitle = document.getElementById('popupTitle');
        const popupCategory = document.getElementById('popupCategory');
        const popupDescription = document.getElementById('popupDescription');
        
        popupTitle.textContent = title;
        popupCategory.textContent = category;
        popupDescription.textContent = description;
        
        popup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Function untuk menutup popup
    function closePopup() {
        document.getElementById('activityPopup').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close popup when clicking outside
    document.getElementById('activityPopup')?.addEventListener('click', function(e) {
        if (e.target.id === 'activityPopup') {
            closePopup();
        }
    });

    // Close popup with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePopup();
        }
    });
</script>
@endpush

