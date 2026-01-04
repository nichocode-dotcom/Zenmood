@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl overflow-hidden flex flex-col md:flex-row">
        <!-- Left Section - Green Panel -->
        <div class="bg-[#558B2F] w-full md:w-2/5 p-8 md:p-12 flex flex-col justify-center items-center">
            <div class="w-full">
                <img src="{{ asset('white-logo.png') }}" alt="ZenMood" class="h-12 md:h-16 mb-8">
                <div class="space-y-2 mb-8">
                    <h1 class="text-white text-2xl md:text-3xl font-bold uppercase leading-tight text-left">
                        OPTIMIZE<br>YOUR<br>MOOD
                    </h1>
                </div>
                <p class="text-white text-sm md:text-base text-left">Tenang Fokus Terkendali</p>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="w-full md:w-3/5 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-[#558B2F] text-2xl md:text-3xl font-bold mb-2">Selamat Datang</h2>
                <p class="text-gray-600 text-sm md:text-base">Silakan login akun pengguna</p>
            </div>

            <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email Input -->
                <div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        placeholder="EMAIL" 
                        required
                        class="w-full px-4 py-3 border-2 border-[#87D503] rounded-full focus:outline-none focus:ring-2 focus:ring-[#87D503] focus:border-transparent text-gray-800 placeholder-gray-400">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="PASSWORD" 
                        required
                        class="w-full px-4 py-3 border-2 border-[#87D503] rounded-full focus:outline-none focus:ring-2 focus:ring-[#87D503] focus:border-transparent text-gray-800 placeholder-gray-400 pr-12">
                    <button 
                        type="button"
                        onclick="togglePassword('password')"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-[#558B2F] hover:text-[#87D503] focus:outline-none">
                        <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-off-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-[#558B2F] hover:bg-[#4A6B2F] text-white font-bold py-3 px-6 rounded-full transition-colors duration-200">
                    LOGIN
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-[#558B2F] hover:text-[#87D503] font-semibold">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById('eye-' + inputId);
    const eyeOff = document.getElementById('eye-off-' + inputId);
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.add('hidden');
        eyeOff.classList.remove('hidden');
    } else {
        input.type = 'password';
        eye.classList.remove('hidden');
        eyeOff.classList.add('hidden');
    }
}
</script>
@endsection
