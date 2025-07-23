@extends('layouts.admin')

@section('title', 'Form Input IPH Bulanan')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-indigo-700">Form Input IPH Bulanan</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('iph-bulanan.store') }}" class="space-y-6">
        @csrf

        {{-- Tahun --}}
        <div>
            <label class="block font-medium">Tahun:</label>
            <select name="tahun" required class="w-full p-2 border rounded">
                <option value="">-- Pilih Tahun --</option>
                @for ($tahun = 2023; $tahun <= date('Y'); $tahun++)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endfor
            </select>
        </div>

        {{-- Bulan --}}
        <div>
            <label class="block font-medium">Bulan:</label>
            @php $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
            <select name="bulan" required class="w-full p-2 border rounded">
                <option value="">-- Pilih Bulan --</option>
                @foreach ($bulanList as $bulan)
                    <option value="{{ $bulan }}">{{ $bulan }}</option>
                @endforeach
            </select>
        </div>

        {{-- Perubahan Harga --}}
        <div>
            <label class="block font-medium">Perubahan Harga (%):</label>
            <input type="text" name="perubahan_harga" placeholder="Contoh: 0,020202" class="w-full p-2 border rounded" required>
        </div>

        {{-- Fluktuasi Tertinggi --}}
        <div>
            <label class="block font-medium">Fluktuasi Tertinggi:</label>
            <input type="text" name="fluktuasi_tertinggi" class="w-full p-2 border rounded">
        </div>

        {{-- Komoditas Dinamis --}}
        <div>
            <label class="block font-medium mb-2">Komoditas dan Nilai Andil:</label>
            <div id="komoditas-wrapper" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nama_komoditas_1" placeholder="Nama Komoditas 1" class="w-full p-2 border rounded">
                    <input type="text" name="nilai_andil_1" placeholder="Nilai Andil 1" class="w-full p-2 border rounded">
                </div>
            </div>
            <button type="button" onclick="tambahKomoditas()" class="mt-2 bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">
                + Tambah Komoditas
            </button>
        </div>

        {{-- Disparitas Harga --}}
        <div>
            <label class="block font-medium">Disparitas Harga:</label>
            <input type="text" name="disparitas_harga" placeholder="Contoh: 0,005" class="w-full p-2 border rounded">
        </div>

        {{-- Nilai Fluktuasi --}}
        <div>
            <label class="block font-medium">Nilai Fluktuasi:</label>
            <input type="text" name="nilai_fluktuasi" placeholder="Contoh: -0,0102" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-5 py-3 rounded hover:bg-indigo-700">
            Simpan Data Mingguan
        </button>
    </form>

    {{-- Script Dinamis Komoditas --}}
    <script>
        let index = 2;
        function tambahKomoditas() {
            const wrapper = document.getElementById('komoditas-wrapper');
            const row = document.createElement('div');
            row.className = 'grid grid-cols-2 gap-4';
            row.innerHTML = `
                <input type="text" name="nama_komoditas_${index}" placeholder="Nama Komoditas ${index}" class="w-full p-2 border rounded">
                <input type="text" name="nilai_andil_${index}" placeholder="Nilai Andil ${index}" class="w-full p-2 border rounded">
            `;
            wrapper.appendChild(row);
            index++;
        }
    </script>
@endsection
