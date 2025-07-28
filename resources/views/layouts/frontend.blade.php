@php
    $setting = \App\Models\SiteSetting::first() ?? new \App\Models\SiteSetting();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'IPH Publik')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <style>[x-cloak] { display: none !important; }</style>
    @stack('script')
</head>
<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR -->
<header class="bg-blue-900 text-white sticky top-0 z-50 shadow">
    <div class="w-full px-4 md:px-8 xl:px-16 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ asset('storage/' . ($setting->logo ?? 'images/logo-bps.png')) }}" class="h-12">

            <div>
                <h1 class="text-xl md:text-2xl font-bold italic uppercase leading-tight tracking-wide">
                    {{ $setting->judul ?? 'BADAN PUSAT STATISTIK' }}
                </h1>
                <span class="text-lg md:text-xl font-bold italic uppercase tracking-wide">
                    {{ $setting->subjudul ?? 'KABUPATEN TASIKMALAYA' }}
                </span>
            </div>
        </div>
<nav class="flex flex-wrap gap-4 md:gap-6 text-sm md:text-base font-semibold uppercase">
    <a href="{{ route('beranda') }}" class="hover:underline">Beranda</a>

    <!-- Dropdown Informasi Publik -->
    <div class="relative" x-data="{ openDropdown: false }">
        <button @click="openDropdown = !openDropdown"
                class="hover:underline flex items-center gap-1 focus:outline-none">
            Informasi Publik <span class="text-xs">▾</span>
        </button>

        <div x-show="openDropdown"
             x-cloak
             @click.away="openDropdown = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute bg-white text-blue-900 rounded shadow-lg mt-2 z-50 w-56">
            <a href="https://ppid.bps.go.id/app/konten/3206/Profil-BPS.html"
               class="block px-4 py-2 hover:bg-blue-100">Tentang Kami</a>
            <a href="https://ppid.bps.go.id/?mfd=3206"
               class="block px-4 py-2 hover:bg-blue-100">PPID</a>
            <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3"
               class="block px-4 py-2 hover:bg-blue-100">Kebijakan Diseminasi</a>
            <a href="https://bps.go.id/informasi-layanan.html"
               class="block px-4 py-2 hover:bg-blue-100">Informasi Layanan</a>
            <a href="https://bps.go.id/pengaduan.html"
               class="block px-4 py-2 hover:bg-blue-100">Pengaduan</a>
        </div>
    </div>

    <a href="{{ route('grafik') }}" class="hover:underline">Grafik</a>
</nav>

    </div>
</header>

<!-- KONTEN HALAMAN -->
<main class="w-full px-6 md:px-12 xl:px-24 py-12">
    @yield('content')
</main>



<!-- FOOTER -->
<footer class="bg-blue-900 text-white mt-10">
    <div class="w-full px-6 md:px-12 xl:px-24 py-10 flex flex-col md:flex-row justify-between gap-12">
        <!-- Kiri -->
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ asset('storage/' . ($setting->logo_iph ?? 'images/logo-iph.png')) }}"
     alt="Logo IPH" class="h-16 w-auto">
                <strong class="text-lg md:text-xl font-semibold block">Badan Pusat Statistik Kabupaten Tasikmalaya</strong>
            </div>
            <p class="text-base md:text-lg leading-relaxed mt-2">
    {!! nl2br(e($setting->alamat ?? 'Jl. Raya Timur km 4 Cintaraja Singaparna Tasikmalaya 46417')) !!}<br>
    <span class="block mt-1">📧 Email: {{ $setting->email ?? 'bps3206@bps.go.id' }}</span>
    <span class="block mt-1">📞 Telepon: {{ $setting->telepon ?? '(0265) 549281' }}</span>
</p>


           <img src="{{ asset('storage/' . ($setting->logo_berakhlak ?? 'images/logo-berakhlak.png')) }}" style="height:120px" class="mt-6 w-auto rounded-md">
            <div class="flex gap-4 mt-3 text-sm">
                <a href="https://manual-website-bps.readthedocs.io/id/latest/" class="hover:underline">Manual</a>
                <a href="https://tasikmalayakab.bps.go.id/id/term-of-use" class="hover:underline">S&amp;K</a>
                <a href="https://tasikmalayakab.bps.go.id/id/tautan" class="hover:underline">Tautan</a>
            </div>
        </div>

        <!-- Kanan -->
        <div class="flex flex-col md:flex-row md:gap-20 items-start md:ml-auto text-base">
            <div>
                <strong class="block mb-2 text-lg font-semibold">Tentang Kami</strong>
                <ul class="space-y-2">
                    <li><a href="https://ppid.bps.go.id/app/konten/3206/Profil-BPS.html" class="hover:underline">Profil BPS</a></li>
                    <li><a href="https://ppid.bps.go.id/?mfd=3206" class="hover:underline">PPID</a></li>
                    <li><a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3" class="hover:underline">Kebijakan Diseminasi</a></li>
                </ul>
            </div>
            <div>
                <strong class="block mb-2 text-lg font-semibold">Tautan Lain</strong>
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

    <!-- Sosmed & Copyright -->
    <div class="w-full px-8 md:px-12 xl:px-24 pt-3 border-t border-white/30 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="text-base font-semibold">&copy; {{ date('Y') }} Badan Pusat Statistik</p>
        <div class="flex gap-5 mt-4 md:mt-0">
            <a href="https://facebook.com/..." target="_blank" class="bg-blue-800 rounded-full h-14 w-14 flex items-center justify-center">
                <img src="{{ asset('images/icon-fb.png') }}" class="h-9 w-9">
            </a>
            <a href="https://instagram.com/..." target="_blank" class="bg-blue-800 rounded-full h-14 w-14 flex items-center justify-center">
                <img src="{{ asset('images/icon-ig.png') }}" class="h-14 w-14">
            </a>
            <a href="https://x.com/bpstasik/" target="_blank" class="bg-blue-800 rounded-full h-14 w-14 flex items-center justify-center">
                <img src="{{ asset('images/icon-x.png') }}" class="h-12 w-12">
            </a>
            <a href="https://youtube.com/@bpskabtasikmalaya3206" target="_blank" class="bg-blue-800 rounded-full h-14 w-14 flex items-center justify-center">
                <img src="{{ asset('images/icon-yt.png') }}" class="h-8 w-8">
            </a>
        </div>
    </div>
</footer>

</body>
</html>
