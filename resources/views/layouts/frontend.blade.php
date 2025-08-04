@php
    $setting = \App\Models\SiteSetting::first() ?? new \App\Models\SiteSetting();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'IPH Publik')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind & Alpine -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>[x-cloak] { display: none !important; }</style>
    @stack('style')
</head>
<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR -->
<header class="bg-blue-900 text-white sticky top-0 z-50 shadow">
    <div class="scale-[0.75] origin-top">
        <div class="w-full px-4 py-2 flex flex-col md:flex-row items-center justify-between gap-2">
            <!-- Logo + Judul -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/' . ($setting->logo ?? 'images/logo-bps.png')) }}" class="h-10">
                <div>
                    <h1 class="text-base font-bold italic uppercase leading-tight tracking-wide">
                        {{ $setting->judul ?? 'BADAN PUSAT STATISTIK' }}
                    </h1>
                    <span class="text-sm font-semibold italic uppercase tracking-wide">
                        {{ $setting->subjudul ?? 'KABUPATEN TASIKMALAYA' }}
                    </span>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex gap-3 text-sm font-semibold uppercase mt-2 md:mt-0">
                <a href="{{ route('beranda') }}" class="hover:underline">Beranda</a>

                <!-- Dropdown -->
                <div class="relative" x-data="{ openDropdown: false }">
                    <button @click="openDropdown = !openDropdown"
                            class="hover:underline flex items-center gap-1 focus:outline-none">
                        Informasi Publik <span class="text-xs">▾</span>
                    </button>
                    <div x-show="openDropdown"
                         x-cloak
                         @click.away="openDropdown = false"
                         x-transition
                         class="absolute bg-white text-blue-900 rounded shadow-lg mt-2 z-50 w-48 text-sm">
                        <a href="https://ppid.bps.go.id/app/konten/0000/Profil-BPS.html" class="block px-4 py-2 hover:bg-blue-100">Tentang Kami</a>
                        <a href="https://ppid.bps.go.id/?mfd=0000" class="block px-4 py-2 hover:bg-blue-100">PPID</a>
                        <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3" class="block px-4 py-2 hover:bg-blue-100">Kebijakan Diseminasi</a>
                        <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html" class="block px-4 py-2 hover:bg-blue-100">Informasi Layanan</a>
                        <a href="https://ppid.bps.go.id/app/keberatan_informasi" class="block px-4 py-2 hover:bg-blue-100">Pengaduan</a>
                    </div>
                </div>

                <a href="{{ route('grafik') }}" class="hover:underline">Grafik</a>
            </nav>
        </div>
    </div>
</header>

<!-- KONTEN -->
<main class="w-full px-6 md:px-12 xl:px-24 py-10">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-blue-900 text-white mt-10">
    <div class="scale-[0.75] origin-top">
        <div class="w-full px-6 py-8 flex flex-col md:flex-row justify-between gap-8">
            <!-- Kiri -->
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('storage/' . ($setting->logo_iph ?? 'images/logo-iph.png')) }}" class="h-12 w-auto">
                    <strong class="text-base font-semibold block">BPS Kabupaten Tasikmalaya</strong>
                </div>
                <p class="text-sm leading-relaxed mt-2">
                    {!! nl2br(e($setting->alamat ?? 'Jl. Raya Timur km 4 Cintaraja Singaparna Tasikmalaya 46417')) !!}<br>
                    <span class="block mt-1">📧 {{ $setting->email ?? 'bps3206@bps.go.id' }}</span>
                    <span class="block mt-1">📞 {{ $setting->telepon ?? '(0265) 549281' }}</span>
                </p>
                <img src="{{ asset('storage/' . ($setting->logo_berakhlak ?? 'images/logo-berakhlak.png')) }}" class="mt-6 h-20 w-auto rounded-md">
                <div class="flex gap-4 mt-3 text-xs">
                    <a href="https://manual-website-bps.readthedocs.io/id/latest/" class="hover:underline">Manual</a>
                    <a href="https://tasikmalayakab.bps.go.id/id/term-of-use" class="hover:underline">S&amp;K</a>
                    <a href="https://tasikmalayakab.bps.go.id/id/tautan" class="hover:underline">Tautan</a>
                </div>
            </div>

            <!-- Kanan -->
            <div class="flex flex-col md:flex-row gap-12 text-sm">
                <div>
                    <strong class="block mb-2 text-base font-semibold">Tentang Kami</strong>
                    <ul class="space-y-2">
                        <li><a href="https://ppid.bps.go.id/app/konten/3206/Profil-BPS.html" class="hover:underline">Profil BPS</a></li>
                        <li><a href="https://ppid.bps.go.id/?mfd=3206" class="hover:underline">PPID</a></li>
                        <li><a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3" class="hover:underline">Kebijakan Diseminasi</a></li>
                    </ul>
                </div>
                <div>
                    <strong class="block mb-2 text-base font-semibold">Tautan Lain</strong>
                    <ul class="space-y-2">
                        <li><a href="https://www.aseanstats.org/" class="hover:underline">ASEAN Stats</a></li>
                        <li><a href="https://fmsindonesia.id/" class="hover:underline">Forum Statistik</a></li>
                        <li><a href="https://rb.bps.go.id/" class="hover:underline">Reformasi Birokrasi</a></li>
                        <li><a href="https://spse.inaproc.id/" class="hover:underline">LPSE</a></li>
                        <li><a href="https://www.stis.ac.id/" class="hover:underline">STIS</a></li>
                        <li><a href="https://pusdiklat.bps.go.id/" class="hover:underline">Pusdiklat BPS</a></li>
                        <li><a href="https://jdih.web.bps.go.id/" class="hover:underline">JDIH BPS</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sosmed -->
        <div class="w-full px-6 pt-3 border-t border-white/30 flex flex-col md:flex-row justify-between items-center text-xs">
            <p class="text-sm font-semibold">&copy; {{ date('Y') }} Badan Pusat Statistik</p>
            <div class="flex gap-3 mt-3 md:mt-0">
                               <a href="https://facebook.com/..." target="_blank" class="bg-blue-800 rounded-full h-10 w-10 flex items-center justify-center">
                    <img src="{{ asset('images/icon-fb.png') }}" class="h-6 w-6" alt="Facebook">
                </a>
                <a href="https://instagram.com/..." target="_blank" class="bg-blue-800 rounded-full h-10 w-10 flex items-center justify-center">
                    <img src="{{ asset('images/icon-ig.png') }}" class="h-7 w-7" alt="Instagram">
                </a>
                <a href="https://x.com/bpstasik/" target="_blank" class="bg-blue-800 rounded-full h-10 w-10 flex items-center justify-center">
                    <img src="{{ asset('images/icon-x.png') }}" class="h-6 w-6" alt="X (Twitter)">
                </a>
                <a href="https://youtube.com/@bpskabtasikmalaya3206" target="_blank" class="bg-blue-800 rounded-full h-10 w-10 flex items-center justify-center">
                    <img src="{{ asset('images/icon-yt.png') }}" class="h-5 w-5" alt="YouTube">
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- Slot untuk script tambahan -->
@stack('script')

</body>
</html>
