@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Form Input IPH Mingguan</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('iph-mingguan.store') }}" class="space-y-6">
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

        {{-- Minggu ke --}}
        <div>
            <label class="block font-medium">Minggu ke:</label>
            <select name="minggu_ke" required class="w-full p-2 border rounded">
                <option value="">-- Pilih Minggu --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ 'Minggu '.$i }}</option>
                @endfor
            </select>
        </div>

        {{-- Perubahan Harga --}}
        <div>
            <label class="block font-medium">Perubahan Harga (%):</label>
            <input type="number" step="0.0001" name="perubahan_harga" required class="w-full p-2 border rounded">
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
                    <input type="text" name="nama_komoditas_1" placeholder="Nama Komoditas" class="w-full p-2 border rounded">
                    <input type="number" step="0.0001" name="nilai_andil_1" placeholder="Nilai Andil (%)" class="w-full p-2 border rounded">
                </div>
            </div>
            <button type="button" onclick="tambahKomoditas()" class="mt-2 bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">
                + Tambah Komoditas
            </button>
        </div>

        {{-- Disparitas Harga --}}
        <div>
            <label class="block font-medium">Disparitas Harga:</label>
            <input type="number" step="0.0001" name="disparitas_harga" class="w-full p-2 border rounded">
        </div>

        {{-- Nilai Fluktuasi --}}
        <div>
            <label class="block font-medium">Nilai Fluktuasi:</label>
            <input type="number" step="0.0001" name="nilai_fluktuasi" class="w-full p-2 border rounded">
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
                <input type="text" name="nama_komoditas_${index}" placeholder="Nama Komoditas" class="w-full p-2 border rounded">
                <input type="number" step="0.0001" name="nilai_andil_${index}" placeholder="Nilai Andil (%)" class="w-full p-2 border rounded">
            `;
            wrapper.appendChild(row);
            index++;
        }
    </script>
@endsection
