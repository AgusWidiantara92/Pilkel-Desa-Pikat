<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cek lokasi TPS Pemilihan Perbekel Desa Pikat 2026 berdasarkan NIK. Sistem resmi Panitia Pilkel Desa Pikat, Kecamatan Dawan, Kabupaten Klungkung, Bali.">
    <title>Cek DPT — Pilkel Desa Pikat 2026</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }

        /* Spinner animation */
        @keyframes spin { to { transform: rotate(360deg); } }
        .animate-spin-custom { animation: spin 0.7s linear infinite; }

        /* Subtle fade-in for results */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }

        /* Shake animation for validation error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .animate-shake { animation: shake 0.4s ease-in-out; }

        /* Radial dot pattern overlay */
        .dot-pattern {
            background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col antialiased selection:bg-red-500 selection:text-white">

    <!-- ═══════════════════════════════════════════════ -->
    <!-- HEADER — Background Merah (~40% layar)         -->
    <!-- ═══════════════════════════════════════════════ -->
    <header class="relative bg-red-600 text-white flex flex-col items-center justify-center px-4 pb-32 pt-12 sm:pt-16 md:pt-20 min-h-[42vh]">
        <!-- Dot Pattern Overlay -->
        <div class="absolute inset-0 dot-pattern pointer-events-none"></div>

        <!-- Konten Header -->
        <div class="relative z-10 flex flex-col items-center text-center">
            <!-- Logo Desa — Lingkaran Putih -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-white shadow-lg flex items-center justify-center mb-5 ring-4 ring-white/20">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-red-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>

            <!-- Judul Utama -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-wide text-white leading-tight">
                Pilkel Desa Pikat
            </h1>

            <!-- Subjudul -->
            <p class="mt-2 sm:mt-3 text-sm sm:text-base font-medium text-white/85 tracking-wide">
                Cek Lokasi TPS Berdasarkan NIK
            </p>
        </div>
    </header>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- CARD PENCARIAN — Posisi Tengah (overlap header) -->
    <!-- ═══════════════════════════════════════════════ -->
    <main class="flex-1 w-full max-w-md mx-auto px-4 -mt-20 relative z-20 mb-10">
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">

            <!-- Session Error Alert -->
            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-start">
                    <svg class="w-5 h-5 text-amber-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Pencarian -->
            <form id="searchForm" action="{{ route('dpt.search') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Label NIK -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="nik" class="block text-sm font-semibold text-gray-700">
                            Nomor Induk Kependudukan (NIK)
                        </label>
                        <!-- Counter Digit Realtime -->
                        <span id="nikCounter" class="text-xs font-semibold text-gray-400">0 / 16</span>
                    </div>

                    <!-- Input NIK -->
                    <input
                        type="text"
                        name="nik"
                        id="nik"
                        maxlength="16"
                        inputmode="numeric"
                        autocomplete="off"
                        value="{{ old('nik', $searchedNik ?? '') }}"
                        placeholder="Masukkan 16 Digit NIK"
                        class="w-full px-4 py-3 border rounded-xl text-gray-900 placeholder-gray-400 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 @error('nik') border-red-400 bg-red-50 @else border-gray-300 bg-gray-50 focus:bg-white @enderror"
                    >

                    <!-- Realtime Feedback -->
                    <div id="realtimeFeedback" class="mt-1.5 text-xs font-medium hidden"></div>

                    <!-- Client-Side Validation Error (Komponen Tailwind) -->
                    <div id="clientError" class="mt-3 hidden">
                        <div class="flex items-start p-3 rounded-lg bg-red-50 border border-red-200">
                            <svg class="w-4 h-4 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span id="clientErrorMsg" class="text-xs font-semibold text-red-700"></span>
                        </div>
                    </div>

                    <!-- Server-Side Validation Error (Laravel) -->
                    @error('nik')
                        <div class="mt-3">
                            <div class="flex items-start p-3 rounded-lg bg-red-50 border border-red-200">
                                <svg class="w-4 h-4 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs font-semibold text-red-700">{{ $message }}</span>
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Tombol Cek Data Pemilih -->
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full py-3.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <!-- Normal State -->
                    <span id="btnText" class="flex items-center">
                        Cek Data Pemilih
                    </span>

                    <!-- Loading State -->
                    <span id="btnLoading" class="hidden items-center">
                        <svg class="w-5 h-5 mr-2 animate-spin-custom text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses...</span>
                    </span>
                </button>

                <!-- Keterangan Bawah Tombol -->
                <p class="text-center text-xs text-gray-400 mt-1">
                    Masukkan NIK dengan benar untuk mengetahui lokasi TPS Anda.
                </p>
            </form>

            <!-- ═══════════════════════════════════════ -->
            <!-- HASIL PENCARIAN: DITEMUKAN              -->
            <!-- ═══════════════════════════════════════ -->
            @if(isset($voter))
                <div class="mt-6 pt-6 border-t border-gray-100 animate-fade-in-up">
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 sm:p-6">

                        <!-- Icon Centang Hijau + Judul -->
                        <div class="text-center mb-5">
                            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 ring-4 ring-green-200/50">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-green-900">Data Pemilih Ditemukan</h3>
                            <p class="text-xs text-green-700 mt-0.5">Berikut informasi lokasi TPS Anda</p>
                        </div>

                        <!-- Data Pemilih -->
                        <div class="bg-white rounded-xl border border-green-100 divide-y divide-green-50">
                            <!-- Nama -->
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-xs text-gray-500 font-medium">Nama</span>
                                <span class="text-sm font-bold text-gray-900">{{ $voter['nama_masked'] }}</span>
                            </div>
                            <!-- NIK -->
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-xs text-gray-500 font-medium">NIK</span>
                                <span class="text-sm font-bold text-gray-900 font-mono tracking-wide">{{ $voter['nik_masked'] }}</span>
                            </div>
                            <!-- Nomor TPS -->
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-xs text-gray-500 font-medium">Nomor TPS</span>
                                <span class="text-sm font-extrabold text-green-700 bg-green-100 px-3 py-1 rounded-lg">
                                    {{ $voter['nomor_tps'] }}
                                </span>
                            </div>
                            <!-- Banjar / Dusun -->
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-xs text-gray-500 font-medium">Banjar / Dusun</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $voter['dusun'] }}</span>
                            </div>
                            <!-- Lokasi TPS -->
                            <div class="flex justify-between items-center px-4 py-3">
                                <span class="text-xs text-gray-500 font-medium">Lokasi TPS</span>
                                <span class="text-sm font-semibold text-gray-800 text-right">{{ $voter['nama_lokasi_tps'] }}</span>
                            </div>
                        </div>

                        <!-- Keterangan Bawah -->
                        <p class="text-center text-xs text-green-600 mt-4 font-medium">
                            Status: {{ ucfirst($voter['status']) }} — {{ $voter['keterangan'] }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- ═══════════════════════════════════════ -->
            <!-- HASIL PENCARIAN: TIDAK DITEMUKAN        -->
            <!-- ═══════════════════════════════════════ -->
            @if(isset($notFound) && $notFound)
                <div class="mt-6 pt-6 border-t border-gray-100 animate-fade-in-up">
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-5 text-center">
                        <!-- Icon Peringatan -->
                        <div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-red-900 mb-4">NIK tidak terdaftar dalam DPT.</h3>

                        <!-- Tombol Hubungi Panitia (WhatsApp) -->
                        <a
                            href="{{ $whatsappUrl ?? 'https://wa.me/628xxxxxxxxxx' }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center w-full py-3.5 px-5 bg-green-600 hover:bg-green-700 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            Hubungi Panitia
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </main>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- FOOTER                                         -->
    <!-- ═══════════════════════════════════════════════ -->
    <footer class="w-full py-6 text-center mt-auto">
        <p class="text-xs text-gray-400 font-medium">
            Sistem Cek Data Pemilih Pemilihan Perbekel Desa Pikat
        </p>
    </footer>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- JAVASCRIPT — Validasi Realtime & Loading State -->
    <!-- ═══════════════════════════════════════════════ -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput       = document.getElementById('nik');
            const nikCounter     = document.getElementById('nikCounter');
            const feedback       = document.getElementById('realtimeFeedback');
            const clientError    = document.getElementById('clientError');
            const clientErrorMsg = document.getElementById('clientErrorMsg');
            const searchForm     = document.getElementById('searchForm');
            const submitBtn      = document.getElementById('submitBtn');
            const btnText        = document.getElementById('btnText');
            const btnLoading     = document.getElementById('btnLoading');

            // ── Helper: Tampilkan Error ──
            function showError(message) {
                clientErrorMsg.textContent = message;
                clientError.classList.remove('hidden');
                // Tambah border merah & shake pada input
                nikInput.classList.add('border-red-400', 'bg-red-50');
                nikInput.classList.remove('border-gray-300', 'bg-gray-50');
                nikInput.classList.add('animate-shake');
                setTimeout(function() {
                    nikInput.classList.remove('animate-shake');
                }, 400);
            }

            // ── Helper: Sembunyikan Error ──
            function clearError() {
                clientError.classList.add('hidden');
                clientErrorMsg.textContent = '';
                nikInput.classList.remove('border-red-400', 'bg-red-50');
                nikInput.classList.add('border-gray-300', 'bg-gray-50');
            }

            // ── Validasi Realtime NIK (saat mengetik) ──
            function updateValidation() {
                // Filter hanya angka, maksimal 16 digit
                let val = nikInput.value.replace(/\D/g, '');
                if (val.length > 16) val = val.substring(0, 16);
                nikInput.value = val;

                const len = val.length;
                nikCounter.textContent = len + ' / 16';

                // Hapus error saat user mulai mengetik ulang
                clearError();

                if (len === 0) {
                    nikCounter.className = 'text-xs font-semibold text-gray-400';
                    feedback.classList.add('hidden');
                } else if (len < 16) {
                    nikCounter.className = 'text-xs font-semibold text-amber-500';
                    feedback.textContent = 'NIK kurang ' + (16 - len) + ' digit lagi';
                    feedback.className = 'mt-1.5 text-xs font-medium text-amber-500';
                    feedback.classList.remove('hidden');
                } else {
                    nikCounter.className = 'text-xs font-semibold text-green-600';
                    feedback.textContent = '✓ Format NIK 16 digit sesuai';
                    feedback.className = 'mt-1.5 text-xs font-medium text-green-600';
                    feedback.classList.remove('hidden');
                }
            }

            if (nikInput) {
                nikInput.addEventListener('input', updateValidation);
                // Cek state awal saat halaman di-load (misal: ada old value)
                updateValidation();
            }

            // ══════════════════════════════════════════
            // VALIDASI SAAT TOMBOL DIKLIK (3 ATURAN)
            // ══════════════════════════════════════════
            if (searchForm) {
                searchForm.addEventListener('submit', function (e) {
                    const rawValue = nikInput.value;
                    const cleanValue = rawValue.replace(/\D/g, '');

                    // Aturan 1: Wajib diisi
                    if (rawValue.trim() === '') {
                        e.preventDefault();
                        showError('Nomor Induk Kependudukan (NIK) wajib diisi.');
                        nikInput.focus();
                        return false;
                    }

                    // Aturan 2: Hanya angka
                    if (/\D/.test(rawValue)) {
                        e.preventDefault();
                        showError('NIK hanya boleh berisi karakter angka (0-9).');
                        nikInput.focus();
                        return false;
                    }

                    // Aturan 3: Tepat 16 digit
                    if (cleanValue.length !== 16) {
                        e.preventDefault();
                        showError('NIK harus tepat 16 digit angka. Saat ini baru ' + cleanValue.length + ' digit.');
                        nikInput.focus();
                        return false;
                    }

                    // ── Semua validasi lolos → Tampilkan loading state ──
                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');
                    btnLoading.classList.add('flex');
                });
            }
        });
    </script>

</body>
</html>
