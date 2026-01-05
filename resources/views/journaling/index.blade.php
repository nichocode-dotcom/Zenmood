@extends('layouts.app')

@section('content')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZenMood</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<style>
    [x-cloak] { display: none !important; }
</style>

<div x-data='{
    journals: @json($journals),

    isModalOpen: false, 
    modalMode: "create",
    editIndex: null,

    formData: { 
        title: "", 
        content: "", 
        date: "", 
        rating: 0 
    },

    openModal(mode, index = null, data = null) {
        this.modalMode = mode;
        this.editIndex = index;
        
        if (data) {
            this.formData = JSON.parse(JSON.stringify(data));
        } else {
            this.formData = { title: "", content: "", date: "", rating: 0 };
        }
        this.isModalOpen = true; 
    },

    saveData() {
        if(this.formData.title === "" || this.formData.content === "") {
            alert("Mohon isi judul dan konten ceritanya ya!");
            return;
        }

        let payload = {
            title: this.formData.title,
            content: this.formData.content,
            rating: this.formData.rating,
            _token: "{{ csrf_token() }}"
        };

        fetch("{{ route('journaling.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) throw new Error("Gagal menyimpan");
            return response.json();
        })
        .then(result => {
            if(result.success) {
                if (this.modalMode === "create") {
                    this.journals.unshift(result.data);
                } else {
                    this.journals[this.editIndex] = result.data;
                }

                this.isModalOpen = false;
                this.formData = { title: "", content: "", date: "", rating: 0 };
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Gagal menyimpan data.");
        });
    },

    deleteJournal(index) {
        if(confirm("Hapus cerita ini?")) {
            this.journals.splice(index, 1);
        }
    }
}' class="min-h-screen relative pb-24">

    <div class="fixed top-0 right-0 -z-10 pointer-events-none">
        <svg width="437" height="442" viewBox="0 0 437 442" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M291.218 385.652C183.714 458.294 114.868 402.366 93.8824 365.322C86.6079 354.71 85.7935 335.05 86.2956 326.547C91.3822 303.901 93.3447 256.257 60.5024 246.846C27.6601 237.436 12.3921 217.038 8.86335 208.016C-15.2174 162.369 18.385 134.454 38.1964 126.203C45.2665 123.258 88.8518 128.791 85.6153 53.9742C82.3789 -20.8426 144.586 -41.3494 176.094 -42.2507C190.057 -40.3119 223.234 -45.2029 244.245 -80.2773C265.255 -115.352 295.713 -102.657 308.316 -91.9255C337.775 -57.118 361.703 -51.954 369.985 -53.723C440.084 -77.9392 482.968 -52.1799 495.648 -36.2732C576.237 41.2013 540.259 119.532 494.692 128.293C390.537 148.319 360.961 199.988 359.192 223.319C359.499 316.859 314.004 370.516 291.218 385.652Z" fill="#72B940" fill-opacity="0.1" stroke="#396935"/>
        <path d="M486.312 21.9384C482.679 -108.669 397.102 -132.082 354.768 -127.463C341.904 -127.172 325.453 -116.28 318.836 -110.87C303.399 -93.3974 265.827 -63.7829 239.036 -85.1041C212.246 -106.425 186.771 -106.918 177.382 -104.499C126.253 -97.3526 123.156 -53.4664 127.998 -32.4165C129.727 -24.9044 159.628 7.48068 96.9447 48.8191C34.2614 90.1576 53.8572 153.078 71.4904 179.37C81.2045 189.647 96.5688 219.65 80.3137 257.45C64.0587 295.249 92.1282 312.691 108.195 316.686C153.651 320.31 171.795 336.839 175.184 344.651C196.366 416.204 242.295 436.125 262.611 437.141C372.542 457.488 415.223 382.02 395.783 339.611C351.345 242.675 376.092 188.116 394.02 172.954C470.211 118.212 487.294 49.4679 486.312 21.9384Z" fill="#72B940" fill-opacity="0.1" stroke="#396935"/>
        </svg>
    </div>

    <div class="fixed bottom-0 left-0 -z-10 pointer-events-none">
        <svg width="465" height="451" viewBox="0 0 465 451" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M173.341 55.4034C280.845 -17.2386 349.692 38.6888 370.677 75.7327C377.951 86.3454 378.766 106.005 378.264 114.508C373.177 137.154 371.215 184.798 404.057 194.209C436.899 203.619 452.167 224.017 455.696 233.039C479.777 278.686 446.174 306.601 426.363 314.852C419.293 317.797 375.708 312.264 378.944 387.081C382.18 461.898 319.973 482.405 288.465 483.306C274.503 481.367 241.325 486.258 220.315 521.332C199.304 556.407 168.846 543.712 156.243 532.981C126.785 498.173 102.856 493.009 94.5742 494.778C24.4756 518.994 -18.4087 493.235 -31.0885 477.328C-111.678 399.854 -75.6995 321.523 -30.1328 312.762C74.0227 292.736 103.598 241.068 105.367 217.737C105.06 124.196 150.555 70.5392 173.341 55.4034Z" fill="#72B940" fill-opacity="0.1" stroke="#396935"/>
        <path d="M-21.7526 419.117C-18.1195 549.724 67.4573 573.137 109.792 568.518C122.656 568.227 139.106 557.335 145.723 551.925C161.161 534.453 198.733 504.838 225.523 526.159C252.314 547.481 277.788 547.973 287.177 545.554C338.306 538.408 341.403 494.522 336.561 473.472C334.833 465.96 304.931 433.574 367.615 392.236C430.298 350.898 410.702 287.978 393.069 261.685C383.355 251.408 367.991 221.405 384.246 183.605C400.501 145.806 372.431 128.364 356.365 124.369C310.909 120.745 292.765 104.216 289.375 96.4041C268.194 24.8509 222.265 4.93004 201.948 3.91384C92.0171 -16.4331 49.3359 59.0354 68.7768 101.444C113.214 198.381 88.4675 252.939 70.5393 268.101C-5.6515 322.843 -22.7348 391.587 -21.7526 419.117Z" fill="#72B940" fill-opacity="0.1" stroke="#396935"/>
        </svg>
    </div>

    <div class="px-4 md:px-8 mt-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-[#558B2F] mb-2 font-sans">Ruang Bercerita</h1>
                <p class="text-[#396935] text-sm md:text-base max-w-xl font-light">Silahkan sampaikan semua keluh kesahmu disini, tidak perlu khawatir ZenMood siap mendengarkan kok.</p>
            </div>
            <div class="flex items-center gap-3 text-[#558B2F] font-bold bg-white px-6 py-3 rounded-xl border-2 border-[#558B2F] shadow-sm mb-7">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                
                <span class="text-base tracking-wide">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-8">
        
        <template x-if="journals.length === 0">
            <div class="flex flex-col items-center object-center justify-center py-20 text-center opacity-80">
                <svg width="60" height="54" viewBox="0 0 60 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 0C33.7 0 36.6667 2.96667 36.6667 6.66667C36.6667 10.3667 33.7 13.3333 30 13.3333C26.3 13.3333 23.3333 10.3667 23.3333 6.66667C23.3333 2.96667 26.3333 0 30 0ZM60 40V33.3333C52.5333 33.3333 46.1333 30.1333 41.3333 24.4L36.8667 19.0667C36.2465 18.3149 35.4675 17.7098 34.5858 17.2949C33.704 16.8799 32.7412 16.6654 31.7667 16.6667H28.3333C26.3 16.6667 24.4333 17.5333 23.1667 19.0667L18.7 24.4C13.8667 30.1333 7.46667 33.3333 0 33.3333V40C9.23333 40 17.3 36.1 23.3333 29.1667V36.6667L10.4 41.8333C8.16667 42.7333 6.66667 45 6.66667 47.3667C6.66667 50.6667 9.33333 53.3333 12.6333 53.3333H20V51.6667C20 49.4565 20.878 47.3369 22.4408 45.7741C24.0036 44.2113 26.1232 43.3333 28.3333 43.3333H38.3333C39.2667 43.3333 40 44.0667 40 45C40 45.9333 39.2667 46.6667 38.3333 46.6667H28.3333C25.5667 46.6667 23.3333 48.9 23.3333 51.6667V53.3333H47.3667C50.6667 53.3333 53.3333 50.6667 53.3333 47.3667C53.3333 45 51.8333 42.7333 49.6 41.8333L36.6667 36.6667V29.1667C42.7 36.1 50.7667 40 60 40Z" fill="#558B2F"/>
                </svg>
                    <h3 class="text-sm font-bold text-[#558B2F] mb-0 font-sans">Belum ada catatan.</h3>
                    <p class="text-gray-400 text-xs font-sans">Mulai tulis ceritamu hari ini dengan menekan tombol +</p>
            </div>
        </template>

        <div x-show="journals.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" x-cloak>
            <template x-for="(journal, index) in journals" :key="index">
                
                    <div @click="openModal('view', index, journal)" 
                        x-data="{ openMenu: false }" 
                        class="bg-white p-6 rounded-[24px] shadow-xl border-2 border-[#72B940] hover:border-[#558B2F] transition duration-300 relative group flex flex-col h-full cursor-pointer">
                    
                        <div class="flex justify-between items-start mb-4 relative">
                        
                        <h3 class="text-lg font-bold text-[#396935] line-clamp-1 pr-10" x-text="journal.title"></h3>
                        
                        <div class="absolute right-0 top-0">
                            <button @click.stop="openMenu = !openMenu" 
                                    @click.away="openMenu = false" 
                                    class="bg-[#558B2F] hover:bg-[#457225] text-white rounded-lg transition transform hover:scale-105 focus:outline-none shadow-sm w-8 h-8 flex items-center justify-center">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="5" cy="12" r="2" fill="white"/>
                                    <circle cx="12" cy="12" r="2" fill="white"/>
                                    <circle cx="19" cy="12" r="2" fill="white"/>
                                </svg>
                            </button>

                            <div x-show="openMenu" x-cloak 
                                 class="absolute right-0 top-10 bg-white shadow-[0_4px_20px_rgba(0,0,0,0.15)] rounded-xl py-2 w-32 z-20 border border-gray-100">
                                
                                <button @click.stop="openModal('edit', index, journal); openMenu = false" 
                                        class="w-full flex items-center px-4 py-2 text-sm text-[#396935] font-semibold hover:bg-green-50 gap-2 text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit
                                </button>

                                <button @click.stop="deleteJournal(index); openMenu = false" 
                                        class="w-full flex items-center px-4 py-2 text-sm text-[#396935] font-semibold hover:bg-red-50 gap-2 text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex mb-3 text-[#396935]">
                        <template x-for="i in 5">
                             <svg x-show="i <= journal.rating" class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </template>
                    </div>

                    <p class="text-[#396935] text-sm mb-6 leading-relaxed line-clamp-3 whitespace-pre-line" x-text="journal.content"></p>
                    
                    <div class="text-xs text-[#396935] font-medium mt-auto border-t border-gray-50 pt-4" x-text="journal.date"></div>
                </div>
            </template>
        </div>

    <button @click="openModal('create')" class="fixed bottom-10 right-10 bg-[#558B2F] hover:bg-[#457225] text-white rounded-[24px] p-4 shadow-xl transition transform hover:scale-110 active:scale-95 z-40">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
    </button>

    <div x-show="isModalOpen" x-cloak 
         class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        
        <div @click.away="isModalOpen = false" class="bg-white rounded-[24px] shadow-2xl w-full max-w-2xl p-8 relative flex flex-col max-h-[90vh]">
            
            <div class="flex justify-between items-center mb-6">
                <h2 x-show="modalMode !== 'view'" class="text-2xl font-bold text-[#558B2F]" x-text="modalMode === 'create' ? 'Buat Catatan Baru' : 'Edit Catatan'"></h2>
                
                <div x-show="modalMode === 'view'" class="text-sm text-[#558B2F] bg-transparent border-2 border-[#558B2F] px-3 py-1 rounded-lg" x-text="formData.date"></div>

                <div class="flex gap-2">
                    <button x-show="modalMode === 'view'" @click="modalMode = 'edit'" class="text-[#558B2F] p-1 hover:text-gray-600 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </button>
                    <button @click="isModalOpen = false" class="text-[#558B2F] hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-y-auto pr-2 pb-6">
                <div x-show="modalMode === 'view'" class="mb-4">
                    <h1 class="text-3xl font-bold text-[#396935] leading-tight mb-4" x-text="formData.title"></h1>
                    
                    <div class="flex text-[#FFC107] mb-4">
                        <template x-for="i in 5"><svg x-show="i <= formData.rating" class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></template>
                    </div>
                    
                    <div class="text-gray-700 text-lg leading-loose whitespace-pre-line font-light border-t border-gray-100 pt-4" x-text="formData.content"></div>
                </div>

                <form x-show="modalMode !== 'view'" @submit.prevent="saveData">
                    <p class="text-[#558B2F] mb-6">Silahkan sampaikan semua keluh kesahmu disini.</p>
                    
                    <div class="mb-4">
                        <input type="text" x-model="formData.title" placeholder="Beri judul cerita hari ini..." class="w-full border-2 border-[#558B2F] rounded-xl px-4 py-3 focus:outline-none focus:border-[#558B2F]">
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-[#558B2F] font-bold">Rating Harimu:</span>
                        <div class="flex cursor-pointer">
                            <template x-for="i in 5">
                                <svg @click="formData.rating = i" class="h-8 w-8 transition transform hover:scale-110" 
                                    :class="i <= formData.rating ? 'text-[#558B2F] fill-current' : 'text-[#558B2F] fill-none stroke-current'"
                                    viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </template>
                        </div>
                    </div>

                    <div class="mb-6">
                        <textarea x-model="formData.content" rows="6" placeholder="Silahkan isi ceritamu hari ini..." class="w-full border-2 border-[#558B2F] rounded-xl px-4 py-3 focus:outline-none focus:border-[#558B2F] resize-none"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#558B2F] hover:bg-[#457225] text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                            SELESAI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection