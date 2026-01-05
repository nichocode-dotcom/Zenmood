@extends('layouts.app')
@section('content')
<style>
    /* Style ini khusus untuk menandai kartu yang sedang diklik/dipilih */
    .selected-mood {
        border: 3px solid #72B940 !important;
        background-color: #cbe8cbff !important; /* Hijau sangat muda agar teks tetap terbaca */
        transform: scale(1.05);
    }
</style>
<body class="bg-[#F5F5F5] min-h-screen">

    <form action="{{ route('mood.store') }}" method="POST" id="moodForm">
        @csrf <input type="hidden" name="id_emosi" id="input_id_emosi" required>
        <input type="hidden" name="kategori_aktivitas" id="input_kategori" value="Aktivitas Fisik">
        <input type="hidden" name="id_aktivitas" value="1"> 
        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

        <div class="leaf-decoration fixed top-1/3 left-0 w-56 h-56 opacity-30 pointer-events-none hidden lg:block">
            <svg width="193" height="169" viewBox="0 0 193 169" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M75.4338 106.635C76.7037 87.222 68.5762 39.2003 25.9068 2.41772C28.7007 27.7057 42.5175 83.9524 75.4338 106.635ZM75.4338 106.635C68.7288 73.5307 47.7494 37.1568 38.0978 23.1079C42.3648 56.2122 64.7664 92.5861 75.4338 106.635ZM73.1478 106.635C61.2105 96.4176 29.8687 75.3698 0.000108587 72.9177C12.1914 88.7546 43.8887 117.67 73.1478 106.635ZM73.1478 106.635C65.0202 102.293 44.803 92.9948 28.9544 90.5426C36.066 95.1405 54.8609 104.796 73.1478 106.635Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/></svg>
        </div>
        <div class="leaf-decoration fixed bottom-16 right-5 w-52 h-52 opacity-30 pointer-events-none hidden lg:block">
             <svg width="142" height="125" viewBox="0 0 142 125" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M86.6039 78.9525C85.6713 64.6961 91.6399 29.4302 122.975 2.41797C120.924 20.9889 110.777 62.295 86.6039 78.9525ZM86.6039 78.9525C91.5279 54.6415 106.935 27.9295 114.022 17.6123C110.889 41.9233 94.4378 68.6354 86.6039 78.9525ZM88.2827 78.9525C97.0492 71.4491 120.066 55.9922 142.001 54.1913C133.048 65.8216 109.77 87.0562 88.2827 78.9525ZM88.2827 78.9525C94.2513 75.7636 109.098 68.9355 120.737 67.1347C115.515 70.5112 101.712 77.6019 88.2827 78.9525Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/></svg>
        </div>
        <div class="leaf-decoration fixed bottom-0 left-1/2 transform -translate-x-1/2 w-44 h-44 opacity-30 pointer-events-none hidden lg:block">
            <svg width="188" height="161" viewBox="0 0 188 161" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M74.4623 102.293C75.6793 83.6887 67.8905 37.6679 26.9989 2.41797C29.6764 26.6523 42.9175 80.5554 74.4623 102.293ZM74.4623 102.293C68.0367 70.5679 47.9314 35.7096 38.682 22.2461C42.7712 53.971 64.2394 88.8293 74.4623 102.293ZM72.2715 102.293C60.8316 92.5012 30.7958 72.3304 2.17169 69.9804C13.855 85.1575 44.2316 112.868 72.2715 102.293ZM72.2715 102.293C64.4827 98.1314 45.1078 89.221 29.9195 86.871C36.7348 91.2772 54.7466 100.53 72.2715 102.293Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/></svg>
        </div>


        <div class="main-content max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-1">
            <div class="w-full">
                
                <div class="mb-6 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 relative z-10">
                    <div class="flex-1">
                        <h2 class="text-[#558B2F] text-[28px] sm:text-[32px] lg:text-[36px] font-bold mb-2">Mood Tracker Harian</h2>
                        <p class="text-gray-600 text-[13px] sm:text-[14px] lg:text-[15px]">Hai, {{ Auth::user()->name ?? 'User' }} ini adalah untuk fitur mengukur moodmu, selamat datang di fitur pengukuran mood.</p>
                    </div>
                    
                    <div class="flex items-center gap-2 text-[#558B2F] font-bold bg-white px-6 py-3 nb-4 rounded-xl border-2 border-[#558B2F] shadow-sm mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        
                        <span class="text-sm font-bold">
                            {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                </div>

                {{-- Pesan Feedback jika berhasil/gagal --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 z-20">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 z-20">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6 relative z-10">
                    <h3 class="text-[#558B2F] text-[18px] sm:text-[20px] lg:text-[22px] font-bold mb-3">Kategori Aktivitas Utama</h3>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <button type="button" onclick="selectCategory('Fisik', this)" class="category-btn selected-category bg-[#72B940] text-white px-6 sm:px-8 py-3 rounded-full text-[14px] sm:text-[15px] font-semibold shadow-md border-2 border-[#72B940] transition-all">
                            Fisik
                        </button>
                        <button type="button" onclick="selectCategory('Non-Fisik', this)" class="category-btn bg-white text-[#72B940] px-6 sm:px-8 py-3 rounded-full text-[14px] sm:text-[15px] font-semibold border-2 border-[#72B940] hover:bg-gray-50 transition-all">
                            Non-Fisik 
                        </button>
                        <button type="button" onclick="selectCategory('Sosial', this)" class="category-btn bg-white text-[#72B940] px-6 sm:px-8 py-3 rounded-full text-[14px] sm:text-[15px] font-semibold border-2 border-[#72B940] hover:bg-gray-50 transition-all">
                            Sosial
                        </button>
                        <button type="button" onclick="selectCategory('Relaksasi', this)" class="category-btn bg-white text-[#72B940] px-6 sm:px-8 py-3 rounded-full text-[14px] sm:text-[15px] font-semibold border-2 border-[#72B940] hover:bg-gray-50 transition-all">
                            Relaksasi
                        </button>
                    </div>
                </div>

                <div class="bg-[#72B940] rounded-[20px] sm:rounded-[25px] shadow-lg p-4 sm:p-6 lg:p-8 mb-6 relative z-10">
                    <h3 class="text-white text-[20px] sm:text-[22px] lg:text-[24px] font-bold mb-4 sm:mb-6">Pilih Emosi:</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-5">
                        
                        <button type="button" onclick="selectMood(1, this)" class="mood-card bg-white rounded-[20px] px-3 sm:px-4 lg:px-5 py-3 sm:py-4 flex items-center gap-2 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-11 h-11 flex items-center justify-center flex-shrink-0 ml-10">
                                <svg class="w-11 h-11" viewBox="0 0 37 36" fill="none"><path d="M18.5 0C8.28024 0 0 8.05645 0 18C0 27.9435 8.28024 36 18.5 36C28.7198 36 37 27.9435 37 18C37 8.05645 28.7198 0 18.5 0ZM21.0214 13.7685L26.9891 10.2847C27.8544 9.78387 28.7794 10.8435 28.1379 11.5911L25.6315 14.5161L28.1379 17.4411C28.7869 18.196 27.847 19.2411 26.9891 18.7476L21.0214 15.2637C20.447 14.9226 20.447 14.1097 21.0214 13.7685ZM8.8621 11.5911C8.22056 10.8435 9.14557 9.78387 10.0109 10.2847L15.9786 13.7685C16.5605 14.1097 16.5605 14.9226 15.9786 15.2637L10.0109 18.7476C9.15302 19.2411 8.22056 18.196 8.8621 17.4411L11.3685 14.5161L8.8621 11.5911ZM18.5 30.7742C13.9794 30.7742 8.46673 27.9944 7.77298 24.0024C7.62379 23.1387 8.47419 22.4347 9.31714 22.7032C11.57 23.4073 14.9194 23.8064 18.5 23.8064C22.0806 23.8064 25.43 23.4073 27.6829 22.7032C28.5407 22.4347 29.3687 23.1532 29.227 24.0024C28.5333 27.9944 23.0206 30.7742 18.5 30.7742Z" fill="#87D503"/></svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[17px] sm:text-[19px] lg:text-[21px] flex-1 text-center">Sangat Bahagia</span>
                        </button>

                        <button type="button" onclick="selectMood(2, this)" class="mood-card bg-white rounded-[20px] px-3 sm:px-4 lg:px-5 py-3 sm:py-4 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-11 h-11 flex items-center justify-center flex-shrink-0 ml-10">
                                <svg class="w-11 h-11" viewBox="0 0 37 37" fill="none"><path d="M0 18.5C0 28.7198 8.28024 37 18.5 37C28.7198 37 37 28.7198 37 18.5C37 8.28024 28.7198 0 18.5 0C8.28024 0 0 8.28024 0 18.5ZM14.9194 14.9194C14.9194 16.2397 13.8526 17.3065 12.5323 17.3065C11.2119 17.3065 10.1452 16.2397 10.1452 14.9194C10.1452 13.599 11.2119 12.5323 12.5323 12.5323C13.8526 12.5323 14.9194 13.599 14.9194 14.9194ZM27.4516 16.7843L26.7429 16.1502C25.6389 15.1655 23.2966 15.1655 22.1925 16.1502L21.4839 16.7843C20.8647 17.3363 19.8726 16.8141 20.0069 15.9786C20.3052 14.0988 22.5581 12.8381 24.4752 12.8381C26.3923 12.8381 28.6452 14.0988 28.9436 15.9786C29.0629 16.7992 28.0857 17.3363 27.4516 16.7843ZM9.31714 23.3339C11.57 24.0575 14.9194 24.4677 18.5 24.4677C22.0806 24.4677 25.43 24.0575 27.6829 23.3339C28.5258 23.0579 29.3687 23.7815 29.227 24.6692C28.5407 28.772 23.0206 31.629 18.5 31.629C13.9794 31.629 8.46673 28.772 7.77298 24.6692C7.62379 23.7815 8.46673 23.0579 9.31714 23.3339Z" fill="#87D503"/></svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[17px] sm:text-[19px] lg:text-[21px] flex-1 text-center">Senang</span>
                        </button>

                        <button type="button" onclick="selectMood(3, this)" class="mood-card bg-white rounded-[20px] px-3 sm:px-4 lg:px-5 py-3 sm:py-4 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-11 h-11 flex items-center justify-center flex-shrink-0 ml-10">
                                <svg class="w-11 h-11" viewBox="0 0 38 37" fill="none"><path d="M19 0C8.50403 0 0 8.28024 0 18.5C0 28.7198 8.50403 37 19 37C29.496 37 38 28.7198 38 18.5C38 8.28024 29.496 0 19 0ZM12.871 12.5323C14.227 12.5323 15.3226 13.599 15.3226 14.9194C15.3226 16.2397 14.227 17.3065 12.871 17.3065C11.5149 17.3065 10.4194 16.2397 10.4194 14.9194C10.4194 13.599 11.5149 12.5323 12.871 12.5323ZM26.3548 26.8548H11.6452C10.021 26.8548 10.021 24.4677 11.6452 24.4677H26.3548C27.979 24.4677 27.979 26.8548 26.3548 26.8548ZM25.129 17.3065C23.773 17.3065 22.6774 16.2397 22.6774 14.9194C22.6774 13.599 23.773 12.5323 25.129 12.5323C26.4851 12.5323 27.5806 13.599 27.5806 14.9194C27.5806 16.2397 26.4851 17.3065 25.129 17.3065Z" fill="#87D503"/></svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[17px] sm:text-[19px] lg:text-[21px] flex-1 text-center">Biasa Saja</span>
                        </button>

                        <button type="button" onclick="selectMood(4, this)" class="mood-card bg-white rounded-[20px] px-3 sm:px-4 lg:px-5 py-3 sm:py-4 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-11 h-11 flex items-center justify-center flex-shrink-0 ml-10">
                                <svg class="w-11 h-11" viewBox="0 0 37 36" fill="none"><path d="M18.5 0C8.28024 0 0 8.05645 0 18C0 27.9435 8.28024 36 18.5 36C28.7198 36 37 27.9435 37 18C37 8.05645 28.7198 0 18.5 0ZM24.4677 12.1935C25.7881 12.1935 26.8548 13.2315 26.8548 14.5161C26.8548 15.8008 25.7881 16.8387 24.4677 16.8387C23.1474 16.8387 22.0806 15.8008 22.0806 14.5161C22.0806 13.2315 23.1474 12.1935 24.4677 12.1935ZM12.5323 12.1935C13.8526 12.1935 14.9194 13.2315 14.9194 14.5161C14.9194 15.8008 13.8526 16.8387 12.5323 16.8387C11.2119 16.8387 10.1452 15.8008 10.1452 14.5161C10.1452 13.2315 11.2119 12.1935 12.5323 12.1935ZM25.2286 28.0306C23.5577 26.0855 21.1034 24.9677 18.5 24.9677C15.8966 24.9677 13.4423 26.0855 11.7714 28.0306C10.7643 29.2137 8.92923 27.7258 9.93629 26.5427C12.0623 24.0677 15.1879 22.6452 18.5 22.6452C21.8121 22.6452 24.9377 24.0677 27.0563 26.55C28.0708 27.7258 26.2357 29.2137 25.2286 28.0306Z" fill="#87D503"/></svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[17px] sm:text-[19px] lg:text-[21px] flex-1 text-center">Cemas/Gelisah</span>
                        </button>

                        <button type="button" onclick="selectMood(5, this)" class="mood-card bg-white rounded-[20px] px-3 sm:px-4 lg:px-5 py-3 sm:py-4 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-11 h-11 flex items-center justify-center flex-shrink-0 ml-10">
                                <svg class="w-11 h-11" viewBox="0 0 37 37" fill="none"><path d="M18.5 0C8.28024 0 0 8.28024 0 18.5C0 25.2212 3.59556 31.0845 8.95161 34.322V20.8871C8.95161 20.2306 9.48871 19.6936 10.1452 19.6936C10.8016 19.6936 11.3387 20.2306 11.3387 20.8871V35.5603C13.5393 36.4853 15.9637 37 18.5 37C21.0363 37 23.4607 36.4853 25.6613 35.5603V20.8871C25.6613 20.2306 26.1984 19.6936 26.8548 19.6936C27.5113 19.6936 28.0484 20.2306 28.0484 20.8871V34.322C33.4044 31.0845 37 25.2137 37 18.5C37 8.28024 28.7198 0 18.5 0ZM13.6139 16.1502C12.5099 15.1655 10.1675 15.1655 9.06351 16.1502L8.35484 16.7843C8.07137 17.0304 7.66109 17.0827 7.33286 16.9036C7.00464 16.7246 6.81815 16.3516 6.87782 15.9786C7.17621 14.0988 9.42903 12.8381 11.3462 12.8381C13.2633 12.8381 15.5161 14.0988 15.8145 15.9786C15.8742 16.3516 15.6877 16.7246 15.3595 16.9036C14.9268 17.1349 14.524 16.9558 14.3375 16.7843L13.6139 16.1502ZM18.5 30.4355C16.5232 30.4355 14.9194 28.2946 14.9194 25.6613C14.9194 23.028 16.5232 20.8871 18.5 20.8871C20.4768 20.8871 22.0806 23.028 22.0806 25.6613C22.0806 28.2946 20.4768 30.4355 18.5 30.4355ZM29.6746 16.8962C29.2419 17.1274 28.8391 16.9484 28.6526 16.7768L27.944 16.1427C26.8399 15.1581 24.4976 15.1581 23.3935 16.1427L22.6774 16.7843C22.394 17.0304 21.9837 17.0827 21.6554 16.9036C21.3272 16.7246 21.1407 16.3516 21.2004 15.9786C21.4988 14.0988 23.7516 12.8381 25.6688 12.8381C27.5859 12.8381 29.8387 14.0988 30.1371 15.9786C30.1819 16.3442 30.0028 16.7171 29.6746 16.8962Z" fill="#87D503"/></svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[17px] sm:text-[19px] lg:text-[21px] flex-1 text-center">Sangat Sedih</span>
                        </button>

                        <button type="button" onclick="selectMood(6, this)" class="mood-card bg-white rounded-[20px] px-3 sm:px-4 lg:px-5 py-3 sm:py-4 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-11 h-11 flex items-center justify-center flex-shrink-0 ml-10">
                                <svg class="w-11 h-11" viewBox="0 0 38 37" fill="none"><path d="M19 0C8.50403 0 0 8.28024 0 18.5C0 28.7198 8.50403 37 19 37C29.496 37 38 28.7198 38 18.5C38 8.28024 29.496 0 19 0ZM21.5895 14.151L27.7185 10.5704C28.6073 10.0556 29.5573 11.1448 28.8984 11.9131L26.3242 14.9194L28.8984 17.9256C29.5649 18.7014 28.5996 19.7756 27.7185 19.2683L21.5895 15.6877C20.9996 15.3371 20.9996 14.5016 21.5895 14.151ZM9.10161 11.9131C8.44274 11.1448 9.39274 10.0556 10.2815 10.5704L16.4105 14.151C17.0081 14.5016 17.0081 15.3371 16.4105 15.6877L10.2815 19.2683C9.4004 19.7756 8.44274 18.7014 9.10161 17.9256L11.6758 14.9194L9.10161 11.9131ZM19 20.8871C22.9762 20.8871 27.8335 24.1544 28.4387 28.8466C28.569 29.8611 27.8258 30.6817 27.0827 30.3683C25.0984 29.5403 22.1488 29.0704 19 29.0704C15.8512 29.0704 12.9016 29.5403 10.9173 30.3683C10.1665 30.6817 9.43105 29.8462 9.56129 28.8466C10.1665 24.1544 15.0238 20.8871 19 20.8871Z" fill="#87D503"/></svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[17px] sm:text-[19px] lg:text-[21px] flex-1 text-center">Marah</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6 relative z-10">
                    <label class="text-[#558B2F] text-[16px] sm:text-[17px] lg:text-[18px] font-bold mb-3 block">Apa aktivitas utamamu?</label>
                    <input 
                        type="text" 
                        name="faktor_note"
                        placeholder="Ceritakan singkat aktivitasmu..." 
                        class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-white border-2 border-[#558B2F] rounded-[15px] focus:outline-none focus:border-[#72B940] transition-colors placeholder:text-gray-400 text-[14px] sm:text-[15px]"
                    />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8 relative z-10">
                    
                    <div class="bg-[#72B940] rounded-[20px] shadow-lg p-4 sm:p-6">
                        <h3 class="text-white text-[16px] sm:text-[17px] lg:text-[18px] font-bold mb-3 sm:mb-4">Apa yang mempengaruhi mood-mu?</h3>
                        
                        <div class="flex flex-wrap gap-2 mb-3 sm:mb-4">
                            <button type="button" onclick="addFactor('Kurang tidur')" class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Kurang tidur
                            </button>
                            <button type="button" onclick="addFactor('Beban Pikiran')" class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Beban Pikiran
                            </button>
                            <button type="button" onclick="addFactor('Kelelahan')" class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Kelelahan
                            </button>
                            <button type="button" onclick="addFactor('Interaksi Sosial')" class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Interaksi Sosial
                            </button>
                        </div>

                        <input 
                            type="text" 
                            name="faktor_sistem"
                            id="faktor_sistem_input"
                            placeholder="Lainnya: Ceritakan jika ada faktor lain..." 
                            class="w-full px-4 sm:px-5 py-2.5 sm:py-3 bg-white rounded-[15px] focus:outline-none focus:ring-2 focus:ring-white/50 transition-all placeholder:text-gray-400 text-[12px] sm:text-[13px]"
                        />
                    </div>

                    <div class="bg-[#72B940] rounded-[20px] shadow-lg p-4 sm:p-6">
                        <h3 class="text-white text-[16px] sm:text-[17px] lg:text-[18px] font-bold mb-3 sm:mb-4">Hal yang disyukuri hari ini</h3>
                        
                        <textarea 
                            name="hal_disyukuri"
                            placeholder="Sekecil apapun itu, tuliskan hal baik yang terjadi hari ini&#10;Misal: Kopi pagi yang enak, atau bantuan dari teman."
                            rows="6"
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-white rounded-[15px] focus:outline-none focus:ring-2 focus:ring-white/50 transition-all placeholder:text-gray-400 text-[12px] sm:text-[13px] resize-none"
                        ></textarea>
                    </div>

                </div>

                <div class="flex justify-center relative z-10">
                    <button type="submit" class="bg-[#72B940] hover:bg-[#87D503] text-white px-12 sm:px-16 lg:px-20 py-3 sm:py-3.5 lg:py-4 rounded-full text-[16px] sm:text-[18px] lg:text-[20px] font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 w-full sm:w-auto">
                        SIMPAN
                    </button>
                </div>

            </div>
        </div>
    </form>
    
    <script>
        // 1. Fungsi Pilih Emosi
        function selectMood(id, element) {
            // Simpan ID Emosi ke Input Hidden
            document.getElementById('input_id_emosi').value = id;
            
            // Hapus style terpilih dari semua tombol emosi
            document.querySelectorAll('.mood-card').forEach(el => {
                el.classList.remove('selected-mood');
            });
            
            // Tambahkan style terpilih ke tombol yang diklik
            element.classList.add('selected-mood');
        }

        // 2. Fungsi Pilih Kategori
        function selectCategory(categoryName, element) {
            document.getElementById('input_kategori').value = categoryName;

            // Reset style tombol kategori
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('selected-category', 'bg-[#72B940]', 'text-white');
                btn.classList.add('bg-white', 'text-[#72B940]');
            });

            // Set style tombol aktif
            element.classList.remove('bg-white', 'text-[#72B940]');
            element.classList.add('selected-category', 'bg-[#72B940]', 'text-white');
        }

        // 3. Fungsi Tambah Faktor (Agar masuk ke input text)
        function addFactor(text) {
            let input = document.getElementById('faktor_sistem_input');
            if(input.value === "") {
                input.value = text;
            } else {
                input.value = input.value + ", " + text;
            }
        }
    </script>
</body>
</html>
@endsection