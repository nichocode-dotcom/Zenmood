@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenMood - Mood Tracker Harian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden; /* Hilangkan scroll horizontal */
        }
        
        /* Hilangkan scrollbar vertikal */
        body::-webkit-scrollbar {
            display: none;
        }
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Pastikan elemen daun berada di belakang semua konten */
        .leaf-decoration {
            z-index: 0;
        }
        
        /* Pastikan konten utama berada di depan daun */
        .main-content {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-[#F5F5F5] min-h-screen">

    <!-- Decorative Plants - Leaf decorations positioned around the page (Di belakang semua konten) -->
    
   
    
    <!-- Daun Kanan Atas - Pojok kiri tengah (naik sedikit ke atas) -->
    <div class="leaf-decoration fixed top-1/3 left-0 w-56 h-56 opacity-30 pointer-events-none hidden lg:block">
        <svg width="193" height="169" viewBox="0 0 193 169" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M75.4338 106.635C76.7037 87.222 68.5762 39.2003 25.9068 2.41772C28.7007 27.7057 42.5175 83.9524 75.4338 106.635ZM75.4338 106.635C68.7288 73.5307 47.7494 37.1568 38.0978 23.1079C42.3648 56.2122 64.7664 92.5861 75.4338 106.635ZM73.1478 106.635C61.2105 96.4176 29.8687 75.3698 0.000108587 72.9177C12.1914 88.7546 43.8887 117.67 73.1478 106.635ZM73.1478 106.635C65.0202 102.293 44.803 92.9948 28.9544 90.5426C36.066 95.1405 54.8609 104.796 73.1478 106.635Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M91.5976 75.0708C93.6232 62.3979 95.5476 33.8585 87.04 21.0842C81.4694 30.9691 71.6957 57.4301 77.1649 84.1953" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M84.1513 77.8227C85.7366 79.9943 90.3346 58.1339 86.5295 45.9731C84.4155 52.0053 82.566 75.6511 84.1513 77.8227Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M158.908 112.743C142.051 117.324 109.87 117.324 82.2868 105.107M158.908 112.743C199.364 96.8599 173.721 80.6715 155.843 74.5626M158.908 112.743C169.129 115.423 183.106 121.982 189.09 130.305M82.2868 105.107C50.1059 111.215 45.2532 125.215 43.21 132.596C43.21 135.142 40.1452 139.469 48.5735 150.923C55.638 160.523 86.3786 167.934 118.299 167.747M82.2868 105.107C62.0588 83.1151 89.1827 73.5445 105.273 71.5082M155.843 74.5626C155.843 71.5082 190.323 52.4182 146.649 40.9642C102.975 29.5102 90.7151 68.4538 105.273 71.5082M155.843 74.5626C155.843 74.5626 140.489 78.1785 130.558 77.617C114.468 76.7071 105.273 71.5082 105.273 71.5082M189.09 130.305C194.47 137.79 193.386 146.701 177.297 155.504C161.616 164.084 139.693 167.622 118.299 167.747M189.09 130.305C183.371 138.468 161.207 157.383 118.299 167.747M53.1709 126.487C51.1277 130.56 48.5736 140.385 54.7033 147.105M144.35 127.251C152.012 128.015 166.111 130.763 161.207 135.651C156.303 140.538 149.969 142.268 147.415 142.523C140.774 143.287 125.655 142.37 118.299 132.596C110.943 122.822 132.602 124.96 144.35 127.251Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M165.586 51.8119C159.467 64.5495 138.049 83.786 101.333 58.8306M167.116 86.9056C159.212 91.0648 139.885 96.7318 125.811 86.1257C124.026 84.0461 125.811 80.1988 147.228 81.4466C168.646 82.6943 169.411 85.6058 167.116 86.9056ZM143.404 48.6926C146.973 48.4327 153.654 49.0046 151.818 53.3718C149.982 57.739 145.444 57.2709 143.404 56.491C140.599 55.7112 134.837 53.6835 134.225 51.8119C133.613 49.9402 140.089 48.9525 143.404 48.6926Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M87.1112 90.4177C87.605 94.4812 93.6297 103.37 113.778 106.418" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    <!-- Daun Kiri Bawah - Lebih ke pojok kanan -->
    <div class="leaf-decoration fixed bottom-16 right-5 w-52 h-52 opacity-30 pointer-events-none hidden lg:block">
        <svg width="142" height="125" viewBox="0 0 142 125" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M86.6039 78.9525C85.6713 64.6961 91.6399 29.4302 122.975 2.41797C120.924 20.9889 110.777 62.295 86.6039 78.9525ZM86.6039 78.9525C91.5279 54.6415 106.935 27.9295 114.022 17.6123C110.889 41.9233 94.4378 68.6354 86.6039 78.9525ZM88.2827 78.9525C97.0492 71.4491 120.066 55.9922 142.001 54.1913C133.048 65.8216 109.77 87.0562 88.2827 78.9525ZM88.2827 78.9525C94.2513 75.7636 109.098 68.9355 120.737 67.1347C115.515 70.5112 101.712 77.6019 88.2827 78.9525Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M74.7338 55.7724C73.2463 46.4657 71.8331 25.5071 78.0809 16.126C82.1717 23.3852 89.3493 42.8175 85.3329 62.4732" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M80.2021 57.7933C79.0379 59.3881 75.6612 43.3344 78.4556 34.4038C80.0081 38.8336 81.3663 56.1986 80.2021 57.7933Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M25.3027 83.4378C37.6818 86.8022 61.3146 86.8022 81.5713 77.8301M25.3027 83.4378C-4.40722 71.7738 14.4241 59.8854 27.5534 55.3992M25.3027 83.4378C17.7968 85.4062 7.53199 90.2225 3.13799 96.3353M81.5713 77.8301C105.204 82.3161 108.768 92.597 110.268 98.0177C110.268 99.887 112.519 103.064 106.33 111.476C101.142 118.527 78.5664 123.969 55.125 123.832M81.5713 77.8301C96.4263 61.68 76.5072 54.6516 64.6907 53.1561M27.5534 55.3992C27.5534 53.1561 2.23254 39.1369 34.3057 30.7254C66.3788 22.3139 75.3818 50.9131 64.6907 53.1561M27.5534 55.3992C27.5534 55.3992 38.8292 58.0546 46.122 57.6423C57.9384 56.9741 64.6907 53.1561 64.6907 53.1561M3.13799 96.3353C-0.812894 101.832 -0.0173209 108.376 11.7982 114.841C23.3137 121.141 39.4139 123.74 55.125 123.832M3.13799 96.3353C7.33763 102.329 23.6145 116.221 55.125 123.832M102.953 93.5314C104.454 96.5221 106.329 103.737 101.828 108.672M35.9936 94.0922C30.3668 94.653 20.0133 96.6717 23.6145 100.261C27.2157 103.85 31.8673 105.121 33.7429 105.308C38.6195 105.868 49.7232 105.195 55.125 98.0176C60.5268 90.8397 44.6215 92.4099 35.9936 94.0922Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M20.3983 38.6917C24.8922 48.0459 40.6208 62.1727 67.5841 43.8461M19.2749 64.4636C25.0795 67.5181 39.2727 71.6798 49.6086 63.8909C50.9193 62.3637 49.6086 59.5384 33.88 60.4547C18.1514 61.371 17.5897 63.5091 19.2749 64.4636ZM36.6886 36.401C34.0672 36.2101 29.1614 36.6301 30.5095 39.8373C31.8577 43.0444 35.1907 42.7007 36.6886 42.128C38.7483 41.5553 42.9801 40.0662 43.4294 38.6917C43.8788 37.3172 39.1228 36.5919 36.6886 36.401Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M78.0284 67.043C77.6657 70.0271 73.2414 76.5549 58.4451 78.793" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    <!-- Daun Kanan Bawah - Pojok paling bawah di tengah (sudah sesuai) -->
    <div class="leaf-decoration fixed bottom-0 left-1/2 transform -translate-x-1/2 w-44 h-44 opacity-30 pointer-events-none hidden lg:block">
        <svg width="188" height="161" viewBox="0 0 188 161" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M74.4623 102.293C75.6793 83.6887 67.8905 37.6679 26.9989 2.41797C29.6764 26.6523 42.9175 80.5554 74.4623 102.293ZM74.4623 102.293C68.0367 70.5679 47.9314 35.7096 38.682 22.2461C42.7712 53.971 64.2394 88.8293 74.4623 102.293ZM72.2715 102.293C60.8316 92.5012 30.7958 72.3304 2.17169 69.9804C13.855 85.1575 44.2316 112.868 72.2715 102.293ZM72.2715 102.293C64.4827 98.1314 45.1078 89.221 29.9195 86.871C36.7348 91.2772 54.7466 100.53 72.2715 102.293Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M89.9526 72.0448C91.8939 59.8999 93.738 32.5497 85.5849 20.3076C80.2465 29.7806 70.88 55.1391 76.1213 80.7891" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M82.8165 74.6817C84.3358 76.7628 88.7422 55.8132 85.0957 44.1592C83.0697 49.94 81.2973 72.6006 82.8165 74.6817Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M154.458 108.147C138.304 112.538 107.464 112.538 81.0298 100.829M154.458 108.147C193.229 92.926 168.655 77.4121 151.521 71.5577M154.458 108.147C164.253 110.716 177.649 117.001 183.383 124.978M81.0298 100.829C50.1898 106.683 45.5393 120.099 43.5812 127.173C43.5812 129.613 40.6441 133.759 48.7212 144.736C55.4914 153.937 84.9512 161.039 115.541 160.86M81.0298 100.829C61.6447 79.7539 87.6384 70.5821 103.058 68.6306M151.521 71.5577C151.521 68.6306 184.564 50.336 142.71 39.3593C100.856 28.3826 89.107 65.7035 103.058 68.6306M151.521 71.5577C151.521 71.5577 136.807 75.023 127.29 74.4848C111.87 73.6129 103.058 68.6306 103.058 68.6306M183.383 124.978C188.538 132.15 187.5 140.691 172.081 149.127C157.054 157.349 136.044 160.74 115.541 160.86M183.383 124.978C177.902 132.8 156.661 150.927 115.541 160.86M53.1271 121.319C51.169 125.222 48.7214 134.637 54.5957 141.077M140.507 122.051C147.85 122.782 161.361 125.417 156.661 130.1C151.962 134.784 145.892 136.442 143.444 136.686C137.08 137.418 122.591 136.54 115.541 127.173C108.492 117.806 129.248 119.855 140.507 122.051Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M160.858 49.7542C154.994 61.9611 134.469 80.396 99.2827 56.4804M162.325 83.3856C154.75 87.3716 136.228 92.8024 122.74 82.6383C121.03 80.6453 122.74 76.9583 143.265 78.1541C163.791 79.3499 164.524 82.14 162.325 83.3856ZM139.6 46.7649C143.021 46.5158 149.423 47.0638 147.664 51.2491C145.904 55.4343 141.555 54.9858 139.6 54.2383C136.912 53.491 131.39 51.5478 130.804 49.7542C130.217 47.9605 136.424 47.0139 139.6 46.7649Z" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
            <path d="M85.6532 86.7515C86.1264 90.6456 91.9001 99.1642 111.209 102.085" stroke="#558B2F" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    <!-- Main Container - Dengan z-index lebih tinggi agar tidak transparan, jarak dari navbar diperkecil -->
    <div class="main-content max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        
        <!-- Content Area -->
        <div class="w-full">
            
            <!-- Left Side Content -->
            <div class="w-full">
                
                <!-- Title Section with Date -->
                <div class="mb-6 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 bg-[#F5F5F5] relative z-10">
                    <div class="flex-1">
                        <h2 class="text-[#558B2F] text-[28px] sm:text-[32px] lg:text-[36px] font-bold mb-2">Mood Tracker Harian</h2>
                        <p class="text-gray-600 text-[13px] sm:text-[14px] lg:text-[15px]">Hai, Zakil ini adalah untuk mengukur moodmu, selamat datang di fitur pengukuran mood.</p>
                    </div>
                    
                    <!-- Date Box - Now on the right side of title -->
                    <div class="bg-white border-2 border-[#72B940] rounded-[15px] px-4 sm:px-6 py-3 sm:py-4 flex items-center gap-3 w-full lg:w-auto lg:min-w-[320px] relative z-10">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#72B940] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke-width="2"/>
                            <line x1="3" y1="10" x2="21" y2="10" stroke-width="2"/>
                        </svg>
                        <span class="text-[#558B2F] font-bold text-[14px] sm:text-[16px]">Friday, 31 Desember 2025</span>
                    </div>
                </div>

                <!-- Category Tabs -->
                <div class="mb-6 relative z-10">
                    <h3 class="text-[#558B2F] text-[18px] sm:text-[20px] lg:text-[22px] font-bold mb-3">Kategori Aktivtas Utama</h3>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <button class="bg-[#72B940] text-white px-6 sm:px-8 py-3 rounded-full text-[14px] sm:text-[15px] font-semibold shadow-md hover:bg-[#87D503] transition-all">
                            Aktivitas Fisik
                        </button>
                        <button class="bg-white text-[#72B940] px-6 sm:px-8 py-3 rounded-full text-[14px] sm:text-[15px] font-semibold border-2 border-[#72B940] hover:bg-gray-50 transition-all">
                            Non-Fisik / Mental
                        </button>
                    </div>
                </div>

                <!-- Mood Selection Card -->
                <div class="bg-[#72B940] rounded-[20px] sm:rounded-[25px] shadow-lg p-4 sm:p-6 lg:p-8 mb-6 relative z-10">
                    <h3 class="text-white text-[20px] sm:text-[22px] lg:text-[24px] font-bold mb-4 sm:mb-6">Pilih Emosi:</h3>
                    
                    <!-- Mood Grid - Extended to full width, responsive -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-5">
                        <!-- Sangat Bahagia -->
                        <button class="bg-white rounded-[20px] px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#87D503] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5 0C8.28024 0 0 8.05645 0 18C0 27.9435 8.28024 36 18.5 36C28.7198 36 37 27.9435 37 18C37 8.05645 28.7198 0 18.5 0ZM21.0214 13.7685L26.9891 10.2847C27.8544 9.78387 28.7794 10.8435 28.1379 11.5911L25.6315 14.5161L28.1379 17.4411C28.7869 18.196 27.847 19.2411 26.9891 18.7476L21.0214 15.2637C20.447 14.9226 20.447 14.1097 21.0214 13.7685ZM8.8621 11.5911C8.22056 10.8435 9.14557 9.78387 10.0109 10.2847L15.9786 13.7685C16.5605 14.1097 16.5605 14.9226 15.9786 15.2637L10.0109 18.7476C9.15302 19.2411 8.22056 18.196 8.8621 17.4411L11.3685 14.5161L8.8621 11.5911ZM18.5 30.7742C13.9794 30.7742 8.46673 27.9944 7.77298 24.0024C7.62379 23.1387 8.47419 22.4347 9.31714 22.7032C11.57 23.4073 14.9194 23.8064 18.5 23.8064C22.0806 23.8064 25.43 23.4073 27.6829 22.7032C28.5407 22.4347 29.3687 23.1532 29.227 24.0024C28.5333 27.9944 23.0206 30.7742 18.5 30.7742Z" fill="white"/>
                                </svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[15px] sm:text-[16px] lg:text-[17px]">Sangat Bahagia</span>
                        </button>

                        <!-- Senang -->
                        <button class="bg-white rounded-[20px] px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#87D503] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 18.5C0 28.7198 8.28024 37 18.5 37C28.7198 37 37 28.7198 37 18.5C37 8.28024 28.7198 0 18.5 0C8.28024 0 0 8.28024 0 18.5ZM14.9194 14.9194C14.9194 16.2397 13.8526 17.3065 12.5323 17.3065C11.2119 17.3065 10.1452 16.2397 10.1452 14.9194C10.1452 13.599 11.2119 12.5323 12.5323 12.5323C13.8526 12.5323 14.9194 13.599 14.9194 14.9194ZM27.4516 16.7843L26.7429 16.1502C25.6389 15.1655 23.2966 15.1655 22.1925 16.1502L21.4839 16.7843C20.8647 17.3363 19.8726 16.8141 20.0069 15.9786C20.3052 14.0988 22.5581 12.8381 24.4752 12.8381C26.3923 12.8381 28.6452 14.0988 28.9436 15.9786C29.0629 16.7992 28.0857 17.3363 27.4516 16.7843ZM9.31714 23.3339C11.57 24.0575 14.9194 24.4677 18.5 24.4677C22.0806 24.4677 25.43 24.0575 27.6829 23.3339C28.5258 23.0579 29.3687 23.7815 29.227 24.6692C28.5407 28.772 23.0206 31.629 18.5 31.629C13.9794 31.629 8.46673 28.772 7.77298 24.6692C7.62379 23.7815 8.46673 23.0579 9.31714 23.3339Z" fill="white"/>
                                </svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[15px] sm:text-[16px] lg:text-[17px]">Senang</span>
                        </button>

                        <!-- Biasa Saja -->
                        <button class="bg-white rounded-[20px] px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#87D503] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 0C8.50403 0 0 8.28024 0 18.5C0 28.7198 8.50403 37 19 37C29.496 37 38 28.7198 38 18.5C38 8.28024 29.496 0 19 0ZM12.871 12.5323C14.227 12.5323 15.3226 13.599 15.3226 14.9194C15.3226 16.2397 14.227 17.3065 12.871 17.3065C11.5149 17.3065 10.4194 16.2397 10.4194 14.9194C10.4194 13.599 11.5149 12.5323 12.871 12.5323ZM26.3548 26.8548H11.6452C10.021 26.8548 10.021 24.4677 11.6452 24.4677H26.3548C27.979 24.4677 27.979 26.8548 26.3548 26.8548ZM25.129 17.3065C23.773 17.3065 22.6774 16.2397 22.6774 14.9194C22.6774 13.599 23.773 12.5323 25.129 12.5323C26.4851 12.5323 27.5806 13.599 27.5806 14.9194C27.5806 16.2397 26.4851 17.3065 25.129 17.3065Z" fill="white"/>
                                </svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[15px] sm:text-[16px] lg:text-[17px]">Biasa Saja</span>
                        </button>

                        <!-- Cemas/Gelisah -->
                        <button class="bg-white rounded-[20px] px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#87D503] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5 0C8.28024 0 0 8.05645 0 18C0 27.9435 8.28024 36 18.5 36C28.7198 36 37 27.9435 37 18C37 8.05645 28.7198 0 18.5 0ZM24.4677 12.1935C25.7881 12.1935 26.8548 13.2315 26.8548 14.5161C26.8548 15.8008 25.7881 16.8387 24.4677 16.8387C23.1474 16.8387 22.0806 15.8008 22.0806 14.5161C22.0806 13.2315 23.1474 12.1935 24.4677 12.1935ZM12.5323 12.1935C13.8526 12.1935 14.9194 13.2315 14.9194 14.5161C14.9194 15.8008 13.8526 16.8387 12.5323 16.8387C11.2119 16.8387 10.1452 15.8008 10.1452 14.5161C10.1452 13.2315 11.2119 12.1935 12.5323 12.1935ZM25.2286 28.0306C23.5577 26.0855 21.1034 24.9677 18.5 24.9677C15.8966 24.9677 13.4423 26.0855 11.7714 28.0306C10.7643 29.2137 8.92923 27.7258 9.93629 26.5427C12.0623 24.0677 15.1879 22.6452 18.5 22.6452C21.8121 22.6452 24.9377 24.0677 27.0563 26.55C28.0708 27.7258 26.2357 29.2137 25.2286 28.0306Z" fill="white"/>
                                </svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[15px] sm:text-[16px] lg:text-[17px]">Cemas/Gelisah</span>
                        </button>

                       <!-- Sangat Sedih -->
                        <button class="bg-white rounded-[20px] px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#87D503] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5 0C8.28024 0 0 8.28024 0 18.5C0 25.2212 3.59556 31.0845 8.95161 34.322V20.8871C8.95161 20.2306 9.48871 19.6936 10.1452 19.6936C10.8016 19.6936 11.3387 20.2306 11.3387 20.8871V35.5603C13.5393 36.4853 15.9637 37 18.5 37C21.0363 37 23.4607 36.4853 25.6613 35.5603V20.8871C25.6613 20.2306 26.1984 19.6936 26.8548 19.6936C27.5113 19.6936 28.0484 20.2306 28.0484 20.8871V34.322C33.4044 31.0845 37 25.2137 37 18.5C37 8.28024 28.7198 0 18.5 0ZM13.6139 16.1502C12.5099 15.1655 10.1675 15.1655 9.06351 16.1502L8.35484 16.7843C8.07137 17.0304 7.66109 17.0827 7.33286 16.9036C7.00464 16.7246 6.81815 16.3516 6.87782 15.9786C7.17621 14.0988 9.42903 12.8381 11.3462 12.8381C13.2633 12.8381 15.5161 14.0988 15.8145 15.9786C15.8742 16.3516 15.6877 16.7246 15.3595 16.9036C14.9268 17.1349 14.524 16.9558 14.3375 16.7843L13.6139 16.1502ZM18.5 30.4355C16.5232 30.4355 14.9194 28.2946 14.9194 25.6613C14.9194 23.028 16.5232 20.8871 18.5 20.8871C20.4768 20.8871 22.0806 23.028 22.0806 25.6613C22.0806 28.2946 20.4768 30.4355 18.5 30.4355ZM29.6746 16.8962C29.2419 17.1274 28.8391 16.9484 28.6526 16.7768L27.944 16.1427C26.8399 15.1581 24.4976 15.1581 23.3935 16.1427L22.6774 16.7843C22.394 17.0304 21.9837 17.0827 21.6554 16.9036C21.3272 16.7246 21.1407 16.3516 21.2004 15.9786C21.4988 14.0988 23.7516 12.8381 25.6688 12.8381C27.5859 12.8381 29.8387 14.0988 30.1371 15.9786C30.1819 16.3442 30.0028 16.7171 29.6746 16.8962Z" fill="white"/>
                                </svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[15px] sm:text-[16px] lg:text-[17px]">Sangat Sedih</span>
                        </button>

                        <!-- Marah -->
                        <button class="bg-white rounded-[20px] px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center gap-3 sm:gap-4 hover:scale-105 transition-transform shadow-md">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#87D503] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 0C8.50403 0 0 8.28024 0 18.5C0 28.7198 8.50403 37 19 37C29.496 37 38 28.7198 38 18.5C38 8.28024 29.496 0 19 0ZM21.5895 14.151L27.7185 10.5704C28.6073 10.0556 29.5573 11.1448 28.8984 11.9131L26.3242 14.9194L28.8984 17.9256C29.5649 18.7014 28.5996 19.7756 27.7185 19.2683L21.5895 15.6877C20.9996 15.3371 20.9996 14.5016 21.5895 14.151ZM9.10161 11.9131C8.44274 11.1448 9.39274 10.0556 10.2815 10.5704L16.4105 14.151C17.0081 14.5016 17.0081 15.3371 16.4105 15.6877L10.2815 19.2683C9.4004 19.7756 8.44274 18.7014 9.10161 17.9256L11.6758 14.9194L9.10161 11.9131ZM19 20.8871C22.9762 20.8871 27.8335 24.1544 28.4387 28.8466C28.569 29.8611 27.8258 30.6817 27.0827 30.3683C25.0984 29.5403 22.1488 29.0704 19 29.0704C15.8512 29.0704 12.9016 29.5403 10.9173 30.3683C10.1665 30.6817 9.43105 29.8462 9.56129 28.8466C10.1665 24.1544 15.0238 20.8871 19 20.8871Z" fill="white"/>
                                </svg>
                            </div>
                            <span class="text-[#72B940] font-bold text-[15px] sm:text-[16px] lg:text-[17px]">Marah</span>
                        </button>
                    </div>
                </div>

                <!-- Activity Input -->
                <div class="mb-6 relative z-10">
                    <label class="text-[#558B2F] text-[16px] sm:text-[17px] lg:text-[18px] font-bold mb-3 block">Apa aktivitas utamamu?</label>
                    <input 
                        type="text" 
                        placeholder="Ceritakan singkat aktivitasmu..." 
                        class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-white border-2 border-[#D1D5DB] rounded-[15px] focus:outline-none focus:border-[#72B940] transition-colors placeholder:text-gray-400 text-[14px] sm:text-[15px]"
                    />
                </div>

                <!-- Two Column Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8 relative z-10">
                    
                    <!-- Left Card - Mood Factors -->
                    <div class="bg-[#72B940] rounded-[20px] shadow-lg p-4 sm:p-6">
                        <h3 class="text-white text-[16px] sm:text-[17px] lg:text-[18px] font-bold mb-3 sm:mb-4">Apa yang mempengaruhi mood-mu?</h3>
                        
                        <div class="flex flex-wrap gap-2 mb-3 sm:mb-4">
                            <button class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Kurang tidur
                            </button>
                            <button class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Beban Pikiran
                            </button>
                            <button class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Kelelahan
                            </button>
                            <button class="bg-white text-[#558B2F] px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold hover:bg-gray-100 transition-colors">
                                Interaksi Sosial
                            </button>
                        </div>

                        <input 
                            type="text" 
                            placeholder="Lainnya: Ceritakan jika ada faktor lain..." 
                            class="w-full px-4 sm:px-5 py-2.5 sm:py-3 bg-white rounded-[15px] focus:outline-none focus:ring-2 focus:ring-white/50 transition-all placeholder:text-gray-400 text-[12px] sm:text-[13px]"
                        />
                    </div>

                    <!-- Right Card - Gratitude -->
                    <div class="bg-[#72B940] rounded-[20px] shadow-lg p-4 sm:p-6">
                        <h3 class="text-white text-[16px] sm:text-[17px] lg:text-[18px] font-bold mb-3 sm:mb-4">Hal yang disyukuri hari ini</h3>
                        
                        <textarea 
                            placeholder="Sekecil apapun itu, tuliskan hal baik yang terjadi hari ini&#10;Misal: Kopi pagi yang enak, atau bantuan dari teman."
                            rows="6"
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-white rounded-[15px] focus:outline-none focus:ring-2 focus:ring-white/50 transition-all placeholder:text-gray-400 text-[12px] sm:text-[13px] resize-none"
                        ></textarea>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="flex justify-center relative z-10">
                    <button class="bg-[#72B940] hover:bg-[#87D503] text-white px-12 sm:px-16 lg:px-20 py-3 sm:py-3.5 lg:py-4 rounded-full text-[16px] sm:text-[18px] lg:text-[20px] font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 w-full sm:w-auto">
                        SIMPAN
                    </button>
                </div>

            </div>

        </div>

    </div>

</body>
</html>

@endsection