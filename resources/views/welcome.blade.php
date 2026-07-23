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

            <!-- Form Search (Tanpa logic backend sesuai instruksi) -->
            <form action="#" method="GET" class="space-y-5">
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
                            placeholder="Contoh: 5105011508900001" 
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all duration-200"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-400 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        NIK terdiri dari 16 digit angka sesuai KTP / Kartu Keluarga
                    </p>
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
