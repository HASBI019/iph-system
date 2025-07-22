@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-6 space-y-6">

    <!-- AUTH DEBUG -->
    @if(Auth::check())
        <div class="bg-green-50 text-green-600 p-3 rounded shadow mb-4 text-sm">
            ✅ Login aktif sebagai: <strong>{{ Auth::user()->email }}</strong>
        </div>
    @else
        <div class="bg-red-50 text-red-600 p-3 rounded shadow mb-4 text-sm">
            ❌ Session login gagal. Silakan cek storage permission & session driver.
        </div>
    @endif

    <!-- HEADER -->
    <div class="text-left">
        <h2 class="text-2xl font-bold text-indigo-700 mb-1">📊 Dashboard Admin IPH</h2>
        <p class="text-gray-600">Selamat datang! Kelola data IPH dan tampilan publik situs.</p>
    </div>

    {{-- Ringkasan Mingguan & Bulanan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">📅 Data Mingguan</h3>
            <p>Total entri: 
                <strong>
                    {{ \App\Models\IphMingguan::count() ?? 0 }}
                </strong>
            </p>
            <a href="/admin/iph/view-mingguan" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Lihat detail</a>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">📆 Data Bulanan</h3>
            <p>Total entri: 
                <strong>
                    {{ \App\Models\IphBulanan::count() ?? 0 }}
                </strong>
            </p>
            <a href="/admin/iph/view-bulanan" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Lihat detail</a>
        </div>
    </div>

    {{-- Highlight Komoditas Mingguan --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Komoditas Tertinggi Minggu Ini</h3>
        @php
            $mingguan = \App\Models\IphMingguan::orderByDesc('created_at')->first();
        @endphp
        @if ($mingguan)
            <p><strong>{{ $mingguan->fluktuasi_tertinggi ?? '—' }}</strong> dari Minggu {{ $mingguan->minggu_ke }} Bulan {{ $mingguan->bulan }}</p>
        @else
            <p class="text-gray-500 italic">Belum ada data IPH Mingguan yang tersimpan.</p>
        @endif
    </div>

    {{-- Tombol Export --}}
    <div class="grid grid-cols-2 gap-4">
        <a href="/admin/iph/export-mingguan"
           class="bg-green-600 text-white py-2 px-4 rounded text-center hover:bg-green-700 transition">
            📤 Export IPH Mingguan
        </a>
        <a href="/admin/iph/export-bulanan"
           class="bg-blue-600 text-white py-2 px-4 rounded text-center hover:bg-blue-700 transition">
            📤 Export IPH Bulanan
        </a>
    </div>

    {{-- Seksi Branding --}}
    <div class="bg-indigo-600 text-white rounded-lg p-6 shadow-lg">
        <h3 class="text-2xl font-bold mb-2">Sistem IPH BPS Tasikmalaya</h3>
        <p class="text-sm">Monitoring fluktuasi harga secara efisien & akurat setiap minggu dan bulan.</p>
    </div>

    {{-- Statistik Singkat --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded shadow border-l-4 border-indigo-500">
            <h4 class="font-semibold text-gray-700">Total Data Mingguan</h4>
            <p class="text-2xl font-bold mt-2 text-indigo-700">
                {{ \App\Models\IphMingguan::count() ?? 0 }}
            </p>
        </div>

        <div class="bg-white p-4 rounded shadow border-l-4 border-indigo-500">
            <h4 class="font-semibold text-gray-700">Total Data Bulanan</h4>
            <p class="text-2xl font-bold mt-2 text-indigo-700">
                {{ \App\Models\IphBulanan::count() ?? 0 }}
            </p>
        </div>

        <div class="bg-white p-4 rounded shadow border-l-4 border-indigo-500">
            <h4 class="font-semibold text-gray-700">Fluktuasi Tertinggi</h4>
            <p class="text-sm mt-2">
                {{ $mingguan->fluktuasi_tertinggi ?? '—' }}
            </p>
        </div>
    </div>

</div>
@endsection
