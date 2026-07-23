<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek DPT Pilkel Desa Pikat 2026</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite & CDN Fallback) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-between antialiased selection:bg-red-500 selection:text-white">

    <!-- Section Atas (Merah 40%) -->
    <div class="relative bg-gradient-to-br from-red-800 via-red-700 to-red-900 text-white pt-12 pb-32 px-4 sm:px-6 lg:px-8 shadow-lg">
        <!-- Top Nav / Admin Link -->
        <div class="max-w-5xl mx-auto flex items-center justify-between mb-8">
            <div class="flex items-center space-x-3">
                <!-- Logo Putih -->
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-wide uppercase text-white/90">PILKEL DESA PIKAT</span>
            </div>
            
            <a href="/admin" class="inline-flex items-center text-xs font-semibold px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-white backdrop-blur-sm transition-all duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Login Panitia
            </a>
        </div>

        <!-- Header Content & Judul -->
        <div class="max-w-3xl mx-auto text-center mt-4">
            <!-- Badge -->
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-900/60 border border-red-400/30 text-red-100 mb-4 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                Pemilihan Perbekel Desa Pikat Tahun 2026
            </div>
            
            <!-- Judul Utama -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                Cek Daftar Pemilih Tetap (DPT)
            </h1>
            <p class="mt-3 text-base sm:text-lg text-red-100/90 max-w-xl mx-auto font-normal">
                Periksa status hak pilih dan lokasi TPS Anda dengan memasukkan 16 digit Nomor Induk Kependudukan (NIK).
            </p>
        </div>
        
        <!-- Subtle Pattern Overlay -->
        <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>
    </div>

    <!-- Main Section (Card Putih di Tengah) -->
    <div class="max-w-xl w-full mx-auto px-4 sm:px-6 -mt-24 relative z-10 mb-auto">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 sm:p-10 transition-all duration-300">
            
            <div class="text-center mb-8">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-red-600 shadow-sm border border-red-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Pencarian Data DPT</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan NIK KTP elektronik Anda di bawah ini</p>
            </div>

            <!-- Session Alert Rate Limiter / General Error -->
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Search -->
            <form action="{{ route('dpt.search') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="nik" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Nomor Induk Kependudukan (NIK)
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="nik" 
                            id="nik" 
                            maxlength="16"
                            value="{{ old('nik', $searchedNik ?? '') }}"
                            placeholder="Contoh: 5105011508900001" 
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border @error('nik') border-red-500 @else border-gray-300 @enderror rounded-xl text-gray-900 placeholder-gray-400 font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all duration-200"
                        >
                    </div>

                    @error('nik')
                        <p class="mt-2 text-xs text-red-600 font-medium flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @else
                        <p class="mt-2 text-xs text-gray-400 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            NIK terdiri dari 16 digit angka sesuai KTP / Kartu Keluarga
                        </p>
                    @enderror
                </div>

                <!-- Tombol Merah -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-red-600/30 hover:shadow-red-600/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center group"
                >
                    <span>Cari Data Pemilih</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- HASIL PENCARIAN: DITEMUKAN -->
            @if(isset($voter))
                <div class="mt-8 pt-6 border-t border-gray-100 space-y-4 animate-fade-in">
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                TERDAFTAR DALAM DPT
                            </span>
                            <span class="text-xs font-semibold text-gray-500">Status: {{ ucfirst($voter['status']) }}</span>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center py-1.5 border-b border-emerald-100">
                                <span class="text-gray-500">NIK (Masked):</span>
                                <span class="font-bold text-gray-900 font-mono">{{ $voter['nik_masked'] }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-emerald-100">
                                <span class="text-gray-500">Nama Pemilih:</span>
                                <span class="font-bold text-gray-900">{{ $voter['nama_masked'] }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-emerald-100">
                                <span class="text-gray-500">Banjar / Dusun:</span>
                                <span class="font-semibold text-gray-800">{{ $voter['dusun'] }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-emerald-100">
                                <span class="text-gray-500">TPS Terdaftar:</span>
                                <span class="font-bold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-lg">
                                    {{ $voter['nomor_tps'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pt-1.5">
                                <span class="text-gray-500">Lokasi TPS:</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $voter['nama_lokasi_tps'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- HASIL PENCARIAN: TIDAK DITEMUKAN (TAMPILKAN TOMBOL WHATSAPP) -->
            @if(isset($notFound) && $notFound)
                <div class="mt-8 pt-6 border-t border-gray-100 space-y-4 animate-fade-in">
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-5 text-center">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-red-900 mb-1">NIK Tidak Ditemukan</h3>
                        <p class="text-xs text-red-700 mb-4">
                            Data NIK <span class="font-mono font-bold">{{ $searchedNik }}</span> belum terdaftar di DPT Desa Pikat atau terdapat kendala data.
                        </p>

                        <!-- Tombol WhatsApp Panitia -->
                        <a 
                            href="{{ $whatsappUrl }}" 
                            target="_blank" 
                            class="inline-flex items-center justify-center w-full py-3.5 px-5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/50 transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Hubungi Panitia via WhatsApp</span>
                        </a>
                    </div>
                </div>
            @endif

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span class="flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                    Sistem Resmi Pilkel Pikat
                </span>
                <span>Desa Pikat, Klungkung</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full py-8 text-center text-xs text-gray-500 mt-12 border-t border-gray-200/60 bg-white/50 backdrop-blur-sm">
        <div class="max-w-5xl mx-auto px-4 space-y-2">
            <p class="font-medium text-gray-600">
                Panitia Pemilihan Perbekel (Pilkel) Desa Pikat &copy; 2026
            </p>
            <p class="text-gray-400">
                Kecamatan Dawan, Kabupaten Klungkung, Provinsi Bali
            </p>
        </div>
    </footer>

</body>
</html>
