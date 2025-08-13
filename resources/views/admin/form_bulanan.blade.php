@extends('layouts.admin')

@section('title', 'Form Input IPH Bulanan')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 max-w-4xl mx-auto animate-fade-in">
    <h2 class="text-3xl font-bold mb-6 text-indigo-700">📊 Form Input IPH Bulanan</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('iph-bulanan.store') }}" class="space-y-8">
        @csrf

        {{-- Tahun & Bulan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">📅 Tahun</label>
                <select name="tahun" required class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Tahun</option>
                    @for ($tahun = 2023; $tahun <= 2030; $tahun++)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">🗓️ Bulan</label>
                @php $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
                <select name="bulan" required class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Bulan</option>
                    @foreach ($bulanList as $bulan)
                        <option value="{{ $bulan }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Perubahan Harga & Fluktuasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">📈 Perubahan Harga (%)</label>
                <input type="text" name="perubahan_harga" placeholder="Contoh: 0,020202" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">📉 Fluktuasi Tertinggi</label>
                <input type="text" name="fluktuasi_tertinggi" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        {{-- Komoditas Dinamis --}}
        <div>
            <label class="block font-semibold mb-2 text-gray-700">🛒 Komoditas dan Nilai Andil</label>
            <div id="komoditas-wrapper" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="nama_komoditas_1" placeholder="Nama Komoditas 1" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
                    <input type="text" name="nilai_andil_1" placeholder="Nilai Andil 1" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <button type="button" onclick="tambahKomoditas()" class="mt-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                ➕ Tambah Komoditas
            </button>
        </div>

        {{-- Disparitas & Nilai Fluktuasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-gray-700">💸 Disparitas Harga</label>
                <input type="text" name="disparitas_harga" placeholder="Contoh: 0,005" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block font-semibold mb-1 text-gray-700">📊 Nilai Fluktuasi</label>
                <input type="text" name="nilai_fluktuasi" placeholder="Contoh: -0,0102" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700 transition w-full font-semibold">
            💾 Simpan Data Bulanan
        </button>
    </form>
</div>

{{-- Script Dinamis Komoditas --}}
<script>
    let index = 2;
    function tambahKomoditas() {
        const wrapper = document.getElementById('komoditas-wrapper');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 md:grid-cols-2 gap-4';
        row.innerHTML = `
            <input type="text" name="nama_komoditas_${index}" placeholder="Nama Komoditas ${index}" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
            <input type="text" name="nilai_andil_${index}" placeholder="Nilai Andil ${index}" class="w-full p-2 border rounded focus:ring-2 focus:ring-indigo-500">
        `;
        wrapper.appendChild(row);
        index++;
    }
</script>

{{-- Optional: Animasi Fade-in --}}
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
