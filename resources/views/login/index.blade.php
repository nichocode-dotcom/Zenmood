@extends('layouts.app') 

<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4 font-['Poppins']">
    <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-[2rem] overflow-hidden shadow-2xl min-h-[500px]">
        
        <div class="w-full md:w-1/2 bg-[#558B2F] p-12 flex flex-col justify-center text-white">
            <div class="mb-8">
                <h1 class="text-4xl font-bold flex items-center gap-2">
                    <span class="italic text-5xl">Z</span>enMood
                </h1>
            </div>
            
            <div class="space-y-2">
                <h2 class="text-5xl font-extrabold leading-tight tracking-tight">
                    OPTIMIZE<br>YOUR<br>MOOD
                </h2>
                <p class="text-xl font-light opacity-90 mt-4">
                    Tenang Fokus Terkendali
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white">
            <div class="max-w-sm mx-auto w-full">
                <h3 class="text-[#558B2F] text-3xl font-bold mb-1">Selamat Datang</h3>
                <p class="text-gray-400 text-sm mb-10">Silakan login akun pengguna</p>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="EMAIL ADDRESS" required
                            class="w-full px-6 py-4 bg-[#F1F8E9] border-2 @error('email') border-red-500 @else border-[#8BC34A] @enderror rounded-full focus:outline-none focus:ring-2 focus:ring-[#558B2F] text-xs font-semibold tracking-widest text-gray-500 placeholder-gray-400 transition-all">
                        @error('email')
                            <span class="text-red-500 text-[10px] absolute -bottom-5 left-4 italic font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="relative">
                        <input type="password" name="password" placeholder="PASSWORD" required
                            class="w-full px-6 py-4 bg-[#F1F8E9] border-2 border-[#8BC34A] rounded-full focus:outline-none focus:ring-2 focus:ring-[#558B2F] text-xs font-semibold tracking-widest text-gray-500 placeholder-gray-400 transition-all">
                        
                        <div class="absolute right-5 top-1/2 -translate-y-1/2">
                            <div class="w-5 h-5 border-2 border-[#558B2F] rounded-full flex items-center justify-center">
                                <div class="w-2 h-2 bg-[#558B2F] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full bg-[#558B2F] hover:bg-[#33691E] text-white font-bold py-4 rounded-full transition duration-300 shadow-lg mt-6 uppercase tracking-widest">
                        Login
                    </button>
                </form>

                <p class="mt-8 text-center text-xs text-gray-500">
                    Belum punya akun? <a href="#" class="text-[#558B2F] font-bold hover:underline">Daftar di sini</a>
                </p>
            </div>
        </div>

    </div>
</div>