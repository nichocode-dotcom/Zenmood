@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="bg-white rounded-2xl shadow-[2px_3px_15px_-3px_rgba(0,0,0,0.25)] p-6">
        <h2 class="text-2xl font-bold text-[#4A6B2F] mb-2">{{ $data['title'] }}</h2>
        <div class="text-xs text-gray-400 mb-4">{{ $data['date'] }}</div>
        <p class="text-gray-700">{{ $data['body'] }}</p>
        <div class="mt-6">
            <a href="{{ route('journals.index') }}" class="text-sm text-[#4A6B2F] underline">‹ Kembali ke Riwayat Jurnal</a>
        </div>
    </div>
</div>
@endsection
