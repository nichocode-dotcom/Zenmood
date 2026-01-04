@extends('layouts.app') 
@section('content')
<div class="px-4 lg:pl-8 lg:pr-8 pb-24">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 mt-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-[#558B2F] mb-2">Aktivitas Harian</h1>
            <p class="text-gray-600 text-sm md:text-base">Silahkan capai habit harianmu, semoga bisa terselesaikan dengan baik!</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-2 bg-[#87D503] text-white px-4 py-2 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-semibold text-sm md:text-base">{{ $formattedDate }}</span>
        </div>
    </div>

    <!-- Progress Bar Section -->
    <div class="bg-white rounded-2xl shadow-[2px_3px_10px_-3px_rgba(0,0,0,0.25)] p-6 mb-6">
        <div class="mb-3">
            <h2 class="text-lg font-semibold text-[#4A6B2F]">Progres Hari ini</h2>
        </div>
        <div class="w-full bg-[#E8F5E9] rounded-full h-8 md:h-10 relative overflow-hidden">
            <div class="h-full bg-[#558B2F] rounded-full transition-all duration-300 flex items-center justify-end pr-2 md:pr-3" 
                 style="width: {{ $totalHabits > 0 ? ($completedCount / $totalHabits * 100) : 0 }}%">
                @if($completedCount > 0 && ($completedCount / $totalHabits * 100) > 15)
                    <span class="text-white text-xs md:text-sm font-semibold">{{ $completedCount }} dari {{ $totalHabits }}</span>
                @endif
            </div>
        </div>
        <div class="mt-2 text-center">
            <span class="text-gray-600 text-sm md:text-base font-medium">{{ $completedCount }} dari {{ $totalHabits }} Selesai</span>
        </div>
    </div>

    <!-- Habit List -->
    <div class="space-y-4">
        @foreach($habits as $habit)
            @php
                $isCompleted = in_array($habit->id_habit, $completedHabits);
            @endphp
            <div class="bg-white rounded-2xl shadow-[2px_3px_10px_-3px_rgba(0,0,0,0.25)] p-4 md:p-6 flex items-center gap-4">
                <!-- Icon -->
                <div class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 rounded-full bg-[#87D503] flex items-center justify-center">
                    @if($habit->nama == 'Minum Air 2L')
                        <!-- Water Drop Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0L12 2.69z"/>
                        </svg>
                    @elseif($habit->nama == 'Meditasi')
                        <!-- Two Stars Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.8 2.4-7.2-6-4.8h7.6L12 2z"/>
                            <path d="M8 14l1.5 4.5h4.5L12 16l-1.5 2.5H8z" opacity="0.7"/>
                        </svg>
                    @elseif($habit->nama == 'Waktu Tidur')
                        <!-- Bed with Person Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2 6h20v12H2z"/>
                            <path d="M4 8h16v2H4z"/>
                            <circle cx="7" cy="11" r="1.5"/>
                            <path d="M18 10h-2v2h2v-2z"/>
                        </svg>
                    @elseif($habit->nama == 'Baca Buku')
                        <!-- Open Book Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/>
                        </svg>
                    @elseif($habit->nama == 'Joging Pagi')
                        <!-- Running Person Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="2"/>
                            <path d="M9 8h2v8l-2-2v4h2v4H9v-4l2 2v-8H9V8z"/>
                            <path d="M15 8h-2v8l2-2v4h-2v4h2v-4l-2 2v-8h2V8z"/>
                        </svg>
                    @elseif($habit->nama == 'Makan Buah')
                        <!-- Apple Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.96-3.24-1.44-1.88-.78-3.28-1.36-4.12-1.74C6.62 17.04 6 16.8 6 16.08c0-1.36 1.08-2.23 2.14-3.17C8.89 12.55 9.89 11.89 10.18 10c.15-.95.23-2.12.23-3.51 0-2.12.23-3.89.69-5.3C11.32.99 11.7 1 12 1c.29 0 .68-.01 1.01.19.23.14.46.39.69.7.48.65.77 1.58.77 2.61 0 .75-.08 1.49-.23 2.21-.15.72-.34 1.4-.56 2.04.5.31 1.07.67 1.69 1.08 1.06.94 2.14 1.81 2.14 3.17 0 .72-.62.96-1.61 1.42-.84.38-2.24.96-4.12 1.74-1.16.48-2.15.94-3.24 1.44-1.03.48-2.1.55-3.08-.4-.27-.26-.49-.57-.66-.92-.58-1.19-.15-2.54 1.05-3.21.65-.36 1.44-.65 2.38-.87.94-.22 2.01-.4 3.2-.54 1.19-.14 2.45-.25 3.78-.33 1.33-.08 2.59-.13 3.78-.15 1.19-.02 2.26-.01 3.2.03.94.04 1.73.11 2.38.21.6.1 1.05.22 1.35.36.3.14.5.31.6.5.1.19.15.4.15.64 0 .24-.05.49-.15.75-.1.26-.24.52-.42.78z"/>
                        </svg>
                    @elseif($habit->nama == 'Makan Sayur')
                        <!-- Broccoli/Vegetable Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            <path d="M9 12c0 .55.45 1 1 1s1-.45 1-1-.45-1-1-1-1 .45-1 1zm4 0c0 .55.45 1 1 1s1-.45 1-1-.45-1-1-1-1 .45-1 1z"/>
                        </svg>
                    @else
                        <!-- Default Check Icon -->
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>

                <!-- Habit Info -->
                <div class="flex-grow">
                    <h3 class="text-lg md:text-xl font-bold text-[#558B2F] mb-1">{{ $habit->nama }}</h3>
                    <p class="text-gray-500 text-sm md:text-base">Target: {{ $habit->target_harian }}</p>
                </div>

                <!-- Complete Button -->
                <button 
                    onclick="toggleHabit({{ $habit->id_habit }}, {{ $isCompleted ? 'true' : 'false' }})"
                    class="flex-shrink-0 px-4 md:px-6 py-2 md:py-3 rounded-lg font-semibold text-sm md:text-base transition-all duration-200 {{ $isCompleted ? 'bg-[#558B2F] text-white' : 'bg-[#E8F5E9] text-[#558B2F] hover:bg-[#C8E6C9]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Selesai</span>
                    </div>
                </button>
            </div>
        @endforeach
    </div>
</div>

<!-- Floating Action Button -->
<div class="fixed bottom-6 right-6 z-50">
    <button onclick="openModal()" class="w-14 h-14 md:w-16 md:h-16 bg-[#87D503] hover:bg-[#558B2F] text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
    </button>
</div>

<!-- Modal Overlay -->
<div id="modal-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 md:p-8 relative">
        <!-- Close Button -->
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Modal Content -->
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-[#558B2F] mb-2">Buat Aktivitas Baru</h2>
            <p class="text-gray-600 text-sm md:text-base mb-6">Silahkan tambahkan target habit yang mau kamu capai.</p>

            <!-- Form -->
            <form id="habit-form" onsubmit="submitHabit(event)">
                <!-- Nama Habit Input -->
                <div class="mb-4">
                    <input 
                        type="text" 
                        id="habit-nama" 
                        name="nama" 
                        placeholder="Beri judul targetmu..." 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87D503] focus:border-transparent text-gray-800 placeholder-gray-400">
                </div>

                <!-- Target Input -->
                <div class="mb-6">
                    <input 
                        type="text" 
                        id="habit-target" 
                        name="target_harian" 
                        placeholder="Target: Beri cakupan targetmu..." 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#87D503] focus:border-transparent text-gray-800 placeholder-gray-400">
                </div>

                <!-- Icon Selection -->
                <div class="mb-6">
                    <label class="block text-[#4A6B2F] font-semibold mb-3">Pilih Icon:</label>
                    <div class="flex gap-3 flex-wrap">
                        <button 
                            type="button"
                            onclick="selectIcon('water')"
                            class="icon-option w-12 h-12 rounded-full bg-[#87D503] flex items-center justify-center hover:bg-[#558B2F] transition-colors"
                            data-icon="water">
                            <!-- Water Drop Icon -->
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0L12 2.69z"/>
                            </svg>
                        </button>
                        <button 
                            type="button"
                            onclick="selectIcon('star')"
                            class="icon-option w-12 h-12 rounded-full bg-[#E8F5E9] flex items-center justify-center hover:bg-[#87D503] transition-colors"
                            data-icon="star">
                            <!-- Star Icon -->
                            <svg class="w-6 h-6 text-[#558B2F]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L12 17l-6 4.8 2.4-7.2-6-4.8h7.6L12 2z"/>
                            </svg>
                        </button>
                        <button 
                            type="button"
                            onclick="selectIcon('running')"
                            class="icon-option w-12 h-12 rounded-full bg-[#E8F5E9] flex items-center justify-center hover:bg-[#87D503] transition-colors"
                            data-icon="running">
                            <!-- Running Person Icon -->
                            <svg class="w-6 h-6 text-[#558B2F]" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="5" r="2"/>
                                <path d="M9 8h2v8l-2-2v4h2v4H9v-4l2 2v-8H9V8z"/>
                                <path d="M15 8h-2v8l2-2v4h-2v4h2v-4l-2 2v-8h2V8z"/>
                            </svg>
                        </button>
                        <button 
                            type="button"
                            onclick="selectIcon('apple')"
                            class="icon-option w-12 h-12 rounded-full bg-[#E8F5E9] flex items-center justify-center hover:bg-[#87D503] transition-colors"
                            data-icon="apple">
                            <!-- Apple Icon -->
                            <svg class="w-6 h-6 text-[#558B2F]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.96-3.24-1.44-1.88-.78-3.28-1.36-4.12-1.74C6.62 17.04 6 16.8 6 16.08c0-1.36 1.08-2.23 2.14-3.17C8.89 12.55 9.89 11.89 10.18 10c.15-.95.23-2.12.23-3.51 0-2.12.23-3.89.69-5.3C11.32.99 11.7 1 12 1c.29 0 .68-.01 1.01.19.23.14.46.39.69.7.48.65.77 1.58.77 2.61 0 .75-.08 1.49-.23 2.21-.15.72-.34 1.4-.56 2.04.5.31 1.07.67 1.69 1.08 1.06.94 2.14 1.81 2.14 3.17 0 .72-.62.96-1.61 1.42-.84.38-2.24.96-4.12 1.74-1.16.48-2.15.94-3.24 1.44-1.03.48-2.1.55-3.08-.4-.27-.26-.49-.57-.66-.92-.58-1.19-.15-2.54 1.05-3.21.65-.36 1.44-.65 2.38-.87.94-.22 2.01-.4 3.2-.54 1.19-.14 2.45-.25 3.78-.33 1.33-.08 2.59-.13 3.78-.15 1.19-.02 2.26-.01 3.2.03.94.04 1.73.11 2.38.21.6.1 1.05.22 1.35.36.3.14.5.31.6.5.1.19.15.4.15.64 0 .24-.05.49-.15.75-.1.26-.24.52-.42.78z"/>
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" id="selected-icon" name="icon" value="water">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="bg-[#87D503] hover:bg-[#558B2F] text-white font-bold px-6 py-3 rounded-lg transition-colors duration-200">
                        SELESAI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let selectedIcon = 'water';

function toggleHabit(habitId, isCompleted) {
    fetch('/habit-log/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            habit_id: habitId,
            status: isCompleted ? 0 : 1,
            tanggal: '{{ $today }}'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function openModal() {
    document.getElementById('modal-overlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modal-overlay').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Reset form
    document.getElementById('habit-form').reset();
    selectedIcon = 'water';
    selectIcon('water');
}

function selectIcon(iconType) {
    selectedIcon = iconType;
    document.getElementById('selected-icon').value = iconType;
    
    // Update icon buttons
    const iconButtons = document.querySelectorAll('.icon-option');
    iconButtons.forEach(btn => {
        const icon = btn.getAttribute('data-icon');
        if (icon === iconType) {
            btn.classList.remove('bg-[#E8F5E9]');
            btn.classList.add('bg-[#87D503]');
            const svg = btn.querySelector('svg');
            svg.classList.remove('text-[#558B2F]');
            svg.classList.add('text-white');
        } else {
            btn.classList.remove('bg-[#87D503]');
            btn.classList.add('bg-[#E8F5E9]');
            const svg = btn.querySelector('svg');
            svg.classList.remove('text-white');
            svg.classList.add('text-[#558B2F]');
        }
    });
}

function submitHabit(event) {
    event.preventDefault();
    
    const formData = {
        nama: document.getElementById('habit-nama').value,
        target_harian: document.getElementById('habit-target').value,
        _token: '{{ csrf_token() }}'
    };

    fetch('/habit-log/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            location.reload();
        } else {
            alert('Gagal menambahkan habit. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

// Close modal when clicking outside
document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection
