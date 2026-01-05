@extends('layouts.app')

@section('title', 'Healing Plan - ZenMood')

@section('content')
<div class="min-h-screen bg-transparent font-poppins pb-24">
    <div class="container mx-auto px-4 py-6 max-w-[1500px]"> 
        
        <div class="relative bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100 mb-8"> 
            <div class="absolute right-0 top-0 h-full w-2/2 opacity-100 pointer-events-none">
                <img src="{{ asset('/img/image1.svg') }}" onerror="this.style.display='none'" class="h-full w-full object-cover opacity-50 md:opacity-100">
            </div>
            <div class="relative p-6 md:px-12 md:py-8 flex flex-col md:flex-row items-center justify-between gap-4"> 
                <div class="w-full md:w-3/5">
                    <h1 class="text-3xl font-bold text-[#4A6B2F] mb-2">Hai, {{ Auth::user()->name ?? 'User' }}!</h1> 
                    <div class="inline-flex items-center gap-2 text-[#558B2F] px-3 py-1.5 rounded-2xl shadow-sm mb-5 bg-green-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-semibold text-sm tracking-wide">{{ $formattedDate }}</span>
                    </div>
                    <div class="space-y-3">
                        <div class="w-full bg-gray-100 rounded-full h-8 p-1.5 shadow-inner relative"> 
                            <div id="main-energy-bar" 
                                 class="h-full rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-4"
                                 style="width: {{ $energyPercentage }}%; background: linear-gradient(90deg, #558B2F 0%, #72B940 100%);">
                                <span id="main-energy-text-inner" class="text-white font-bold text-xs {{ $energyPercentage <= 15 ? 'hidden' : '' }}">{{ $energyPercentage }}%</span>
                            </div>
                            <div id="main-energy-icon" class="absolute top-1/2 -translate-y-1/2 transition-all duration-1000 ease-out" style="left: calc({{ $energyPercentage }}% - 15px);">
                                <div class="bg-white p-1 rounded-full shadow-md border border-gray-100"><span class="text-xl">🪨</span></div>
                            </div>
                        </div>
                        <p class="text-[#558B2F] font-bold text-lg italic">Energi harianmu: <span id="main-energy-text-label" class="text-[#72B940]">{{ $energyPercentage }}% Terisi</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div id="active-section" class="mb-12 {{ count($activeActivities) > 0 ? '' : 'hidden' }} animate-in fade-in slide-in-from-top-4 duration-500">
            <h2 class="text-2xl font-bold text-[#558B2F] mb-8 flex items-center gap-3">
                <span class="w-2 h-8 bg-[#558B2F] rounded-full"></span> Pilihan Aktif
            </h2>
            <div id="active-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($activeActivities as $act)
                    @php $percent = $act['is_completed'] ? 100 : 50; @endphp
                    <div class="bg-lime-50 border border-lime-200 rounded-[2.5rem] p-6 shadow-sm flex flex-col h-full cursor-pointer hover:shadow-md transition-all"
                         onclick="openModal(this)"
                         data-id="{{ $act['id_healing'] }}" data-title="{{ $act['title'] }}" data-desc="{{ $act['description'] }}"
                         data-icon="{{ asset('img/' . $act['icon']) }}" data-poin="{{ $act['poin'] }}" data-steps='@json($act['steps'])'
                         data-is-utama="{{ $act['is_utama'] }}"> <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm"><img src="{{ asset('img/' . $act['icon']) }}" class="w-8 h-8 object-contain"></div>
                            <div><h3 class="font-bold text-[#558B2F]">{{ $act['title'] }}</h3><span class="text-xs font-semibold text-[#72B940]">Sedang Berjalan</span></div>
                        </div>
                        <div class="w-full bg-white rounded-full h-3 mb-2 overflow-hidden border border-lime-100"><div class="bg-lime-500 h-3 rounded-full transition-all" style="width: {{ $percent }}%"></div></div>
                        <div class="flex justify-between text-xs text-lime-700 font-medium mt-auto"><span>Status</span><span>{{ $percent }}%</span></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-12">
            <h2 class="text-2xl font-bold text-[#558B2F] mb-8 flex items-center gap-3">
                <span class="w-2 h-8 bg-[#558B2F] rounded-full"></span> Rekomendasi utama saat ini
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($mainRecommendations as $rec)
                    <div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 cursor-pointer group border border-gray-100 flex flex-col h-full" 
                         onclick="openModal(this)"
                         data-id="{{ $rec['id_healing'] }}" data-title="{{ $rec['title'] }}" data-desc="{{ $rec['description'] }}"
                         data-icon="{{ asset('img/' . $rec['icon']) }}" data-poin="{{ $rec['poin'] }}" data-steps='@json($rec['steps'])'
                         data-is-utama="1"> <div class="{{ $rec['color'] }} h-3 w-full"></div>
                        <div class="p-8 flex-grow flex flex-col">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform"><img src="{{ asset('img/' . $rec['icon']) }}" class="w-10 h-10 object-contain"></div>
                                    <div><h3 class="font-bold text-xl text-[#558B2F] leading-tight">{{ $rec['title'] }}</h3><span class="text-xs font-bold text-[#72B940] uppercase tracking-[0.1em]">{{ $rec['category'] }}</span></div>
                                </div>
                            </div>
                            <p class="text-[#4A7829] mb-8 line-clamp-3 text-sm leading-relaxed font-medium flex-grow">{{ $rec['description'] }}</p>
                            <div class="flex justify-between items-center pt-6 border-t border-gray-50 mt-auto"><span class="text-[#558B2F] hover:text-[#72B940] font-bold text-sm flex items-center transition-colors">Lihat rekomendasi</span><span class="text-[10px] font-black bg-green-50 text-[#558B2F] px-4 py-1.5 rounded-full uppercase tracking-tighter">Direkomendasikan</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-16">
            <h2 class="text-2xl font-bold text-[#558B2F] flex items-center gap-3 mb-8"><span class="w-2 h-8 bg-[#558B2F] rounded-full"></span> Alternatif Kegiatan Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach($alternativeActivities as $activity)
                    <div class="bg-white rounded-[2rem] shadow-sm p-6 hover:shadow-lg transition-all duration-300 cursor-pointer border border-gray-50 flex flex-col items-center text-center group h-full"
                         onclick="openModal(this)"
                         data-id="{{ $activity['id_healing'] }}" data-title="{{ $activity['title'] }}" data-desc="{{ $activity['description'] }}"
                         data-icon="{{ asset('img/' . $activity['icon']) }}" data-poin="{{ $activity['poin'] }}" data-steps='@json($activity['steps'])'
                         data-is-utama="0"> <div class="w-20 h-20 rounded-2xl flex items-center justify-center mb-5 bg-green-50 group-hover:bg-green-100 transition-colors"><img src="{{ asset('img/' . $activity['icon']) }}" class="w-12 h-12 object-contain"></div>
                        <h3 class="font-bold text-[#558B2F] mb-2">{{ $activity['title'] }}</h3><span class="text-xs font-semibold text-[#72B940] mb-4 uppercase tracking-tighter">{{ $activity['category'] }}</span>
                        <p class="text-[11px] text-[#4A7829] mb-6 line-clamp-2 leading-relaxed">{{ $activity['description'] }}</p>
                        <button class="bg-[#72B940] hover:bg-[#558B2F] text-white text-xs font-bold py-2.5 px-4 rounded-xl w-full transition-all shadow-md mt-auto">Pilih</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div id="modal-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <button onclick="closeModal()" class="absolute top-4 right-4 z-50 bg-white rounded-full p-2 hover:bg-gray-100 shadow-sm border border-gray-100 transition text-lime-700"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        <div class="flex items-center gap-3 mb-4 pr-12">
            <div class="w-14 h-14 bg-lime-50 rounded-2xl flex items-center justify-center shrink-0"><img id="modal-icon-img" src="" alt="Icon" class="w-8 h-8 object-contain"></div>
            <h2 id="modal-title" class="text-2xl font-extrabold text-lime-600 leading-tight">Judul</h2>
        </div>
        <p id="modal-desc" class="text-gray-600 text-sm font-medium mb-6">Deskripsi...</p>
        <div class="mb-6">
            <div class="flex justify-between text-xs font-bold text-lime-700 mb-1"><span id="progress-text">Progress: 0%</span></div>
            <div class="w-full bg-lime-100 rounded-full h-4 overflow-hidden"><div id="progress-bar" class="bg-lime-500 h-4 rounded-full transition-all duration-300" style="width: 0%"></div></div>
        </div>
        <div id="modal-steps" class="space-y-3 max-h-[40vh] overflow-y-auto pr-2"></div>
        <input type="hidden" id="current-id"><input type="hidden" id="current-poin"><input type="hidden" id="current-title"><input type="hidden" id="current-is-utama">
    </div>
</div>

<script>
    const todayDate = "{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}";
    const STORAGE_KEY_DATA = 'zenmood_checklist_v2_{{ Auth::id() }}'; 
    const STORAGE_KEY_DATE = 'zenmood_date_v2_{{ Auth::id() }}';
    const activitiesDB = @json($activitiesDB);
    let activityStates = {};

    function initChecklistSystem() {
        const storedDate = localStorage.getItem(STORAGE_KEY_DATE);
        if (storedDate !== todayDate) {
            localStorage.setItem(STORAGE_KEY_DATE, todayDate);
            localStorage.setItem(STORAGE_KEY_DATA, JSON.stringify({}));
            activityStates = {};
        } else {
            const savedData = localStorage.getItem(STORAGE_KEY_DATA);
            if (savedData) activityStates = JSON.parse(savedData);
        }
        renderActiveSection(); 
        updateGlobalEnergy();
    }
    document.addEventListener("DOMContentLoaded", initChecklistSystem);

    function renderActiveSection() {
        const activeContainer = document.getElementById('active-container');
        const activeSection = document.getElementById('active-section');
        // Jangan hapus isi container jika itu hasil render server (saat refresh)
        // Kita hanya update/append jika ada interaksi lokal
        // Namun, jika activityStates kosong, kita harus cek apakah server merender sesuatu.
        
        // Agar sync, kita rebuild hanya jika activityStates punya data.
        // Jika tidak, biarkan apa adanya dari server.
        
        // Simpelnya: Kita kosongkan dulu agar tidak duplikat, lalu loop.
        activeContainer.innerHTML = ''; 
        let hasActiveActivities = false;

        for (const [title, states] of Object.entries(activityStates)) {
            const checkedCount = states.filter(Boolean).length;
            if (checkedCount > 0 && activitiesDB[title]) {
                hasActiveActivities = true;
                const data = activitiesDB[title];
                const total = states.length;
                const percent = Math.round((checkedCount/total)*100);
                
                // Disini kita tidak tahu is_utama secara pasti jika hanya dari local storage
                // Tapi user tidak mempermasalahkan tampilan is_utama di kartu, yang penting DB
                // Jadi kita set default 0 atau ambil dari data jika ada (tapi activitiesDB tidak simpan is_utama)
                
                const html = `
                <div class="bg-lime-50 border border-lime-200 rounded-[2rem] p-6 shadow-sm flex flex-col h-full cursor-pointer hover:shadow-md transition-all"
                     onclick="openModal(this)"
                     data-id="${data.id_healing}" data-title="${data.title}" data-desc="${data.description}"
                     data-icon="${data.icon_url}" data-poin="${data.poin}" data-steps='${JSON.stringify(data.steps)}'
                     data-is-utama="0">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm"><img src="${data.icon_url}" class="w-8 h-8 object-contain"></div>
                        <div><h3 class="font-bold text-[#558B2F]">${data.title}</h3><span class="text-xs font-semibold text-[#72B940]">Sedang Berjalan</span></div>
                    </div>
                    <div class="w-full bg-white rounded-full h-3 mb-2 overflow-hidden border border-lime-100"><div class="bg-lime-500 h-3 rounded-full transition-all" style="width: ${percent}%"></div></div>
                    <div class="flex justify-between text-xs text-lime-700 font-medium mt-auto"><span>${checkedCount}/${total} Langkah</span><span>${percent}%</span></div>
                </div>`;
                activeContainer.innerHTML += html;
            }
        }
        
        // Jika lokal kosong, kita cek apakah server mengirim data aktif?
        // Masalahnya JS menghapus container di awal fungsi ini.
        // Solusi: Kita biarkan JS mengontrol UI Aktif sepenuhnya.
        
        if (hasActiveActivities) {
            activeSection.classList.remove('hidden');
        } else {
            // Cek apakah server mengirim data aktif (backup plan)
            if (@json(count($activeActivities)) > 0 && Object.keys(activityStates).length === 0) {
                 // Jika server kirim data tapi local kosong (misal beda browser), kita pakai server render
                 // Caranya: Reload page ini, biarkan PHP render.
                 // Tapi kita di sisi JS, jadi biarkan saja hidden kalau local kosong.
                 activeSection.classList.add('hidden');
            } else {
                 activeSection.classList.add('hidden');
            }
        }
    }

    function openModal(element) {
        const id = element.getAttribute('data-id');
        const title = element.getAttribute('data-title');
        const desc = element.getAttribute('data-desc');
        const iconSrc = element.getAttribute('data-icon');
        const poin = element.getAttribute('data-poin');
        const isUtama = element.getAttribute('data-is-utama'); // AMBIL DARI HTML

        let steps = [];
        try { steps = JSON.parse(element.getAttribute('data-steps')); } catch(e) { steps = ['Mulai', 'Selesai']; }

        document.getElementById('current-id').value = id;
        document.getElementById('current-title').value = title;
        document.getElementById('current-poin').value = poin;
        document.getElementById('current-is-utama').value = isUtama; // SIMPAN
        
        document.getElementById('modal-title').innerText = title;
        document.getElementById('modal-desc').innerText = desc;
        document.getElementById('modal-icon-img').src = iconSrc;
        
        if (!activityStates[title]) activityStates[title] = new Array(steps.length).fill(false);

        const container = document.getElementById('modal-steps');
        container.innerHTML = ''; 
        steps.forEach((step, index) => {
            const isChecked = activityStates[title][index] ? 'checked' : '';
            const html = `
                <label class="flex items-start gap-3 cursor-pointer group select-none">
                    <input type="checkbox" class="peer sr-only task-checkbox" 
                           data-step-index="${index}" onchange="toggleStep(this)" ${isChecked}>
                    <div class="shrink-0 w-6 h-6 border-2 border-lime-500 rounded bg-white text-transparent peer-checked:bg-lime-500 peer-checked:text-white transition-all duration-200 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-600 font-medium text-sm group-hover:text-lime-700">${step}</span>
                </label>`;
            container.innerHTML += html;
        });
        calculateVisual(title);
        document.getElementById('modal-overlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }

    function toggleStep(checkbox) {
        const title = document.getElementById('current-title').value;
        const index = checkbox.getAttribute('data-step-index');
        const idHealing = document.getElementById('current-id').value;
        const isUtama = document.getElementById('current-is-utama').value; // AMBIL VALUE UTAMA
        
        activityStates[title][index] = checkbox.checked;
        localStorage.setItem(STORAGE_KEY_DATA, JSON.stringify(activityStates));

        calculateVisual(title);
        renderActiveSection();
        updateGlobalEnergy();

        const currentStates = activityStates[title];
        const total = currentStates.length;
        const checkedCount = currentStates.filter(Boolean).length;
        const percent = Math.round((checkedCount / total) * 100);
        
        const status = percent === 100 ? 1 : 0;
        saveToDatabase(idHealing, status, isUtama); // KIRIM KE DB
    }

    function calculateVisual(title) {
        const currentStates = activityStates[title];
        const total = currentStates.length;
        const checked = currentStates.filter(Boolean).length;
        const percent = total > 0 ? Math.round((checked / total) * 100) : 0;
        document.getElementById('progress-bar').style.width = percent + '%';
        document.getElementById('progress-text').innerText = 'Progress: ' + percent + '%';
    }

    function updateGlobalEnergy() {
        let totalPoints = 0;
        for (const [title, states] of Object.entries(activityStates)) {
            if (activitiesDB[title]) {
                const data = activitiesDB[title];
                const totalSteps = states.length;
                const checkedSteps = states.filter(Boolean).length;
                const maxPoints = parseInt(data.poin) || 0; // Fix NaN jika poin null
                
                if (totalSteps > 0) {
                    totalPoints += (checkedSteps / totalSteps) * maxPoints;
                }
            }
        }
        let newEnergy = Math.min(Math.round(totalPoints), 100);
        const bar = document.getElementById('main-energy-bar');
        const icon = document.getElementById('main-energy-icon');
        const textInner = document.getElementById('main-energy-text-inner');
        const textLabel = document.getElementById('main-energy-text-label');

        if(bar) bar.style.width = newEnergy + '%';
        if(icon) icon.style.left = `calc(${newEnergy}% - 15px)`;
        if(textInner) {
            textInner.innerText = newEnergy + '%';
            newEnergy > 15 ? textInner.classList.remove('hidden') : textInner.classList.add('hidden');
        }
        if(textLabel) textLabel.innerText = newEnergy + '% Terisi';
    }

    function saveToDatabase(idHealing, status, isUtama) {
        fetch("{{ route('healing.toggle') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ id_healing: idHealing, status: status, is_utama: isUtama })
        }).catch(err => console.log(err));
    }

    function closeModal() {
        document.getElementById('modal-overlay').classList.add('hidden');
        document.body.style.overflow = 'auto'; 
    }
    document.getElementById('modal-overlay').addEventListener('click', function(e) { if (e.target === this) closeModal(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
</script>
@endsection