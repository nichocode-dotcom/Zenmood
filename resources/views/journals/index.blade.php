@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6">
        <h2 class="text-2xl font-bold text-[#4A6B2F] mb-4">Riwayat Jurnal</h2>
        <ul class="space-y-4">
            @for ($i = 1; $i <= 6; $i++)
            <li class="bg-[#F0F7E6] p-4 rounded-xl flex justify-between items-start">
                <div>
                    <span class="inline-block bg-[#7FBC4E] text-white text-xs px-3 py-1 rounded-full mb-2">Hari yang produktif untuk berangkat kerja.</span>
                    <p class="text-sm text-gray-600">Baru saja saya berusaha memulai hari ini dengan produktif, karena... <a href="{{ route('journals.show', $i) }}" class="underline text-[#4A6B2F]">Baca Selengkapnya</a></p>
                </div>
                <div class="text-xs text-gray-400">28 Des 2025</div>
            </li>
            @endfor
        </ul>
    </div>
</div>
@endsection
