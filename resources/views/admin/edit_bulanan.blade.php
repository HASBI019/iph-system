@extends('layouts.admin')

@section('title', 'Edit Data IPH Bulanan')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-indigo-700">Edit Data IPH Bulanan</h2>

<form method="POST" action="{{ route('iph-bulanan.update', $data->id) }}" class="space-y-6">
    @csrf

    {{-- Tahun & Bulan --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-medium">Tahun:</label>
            @php $start = 2023; $now = date('Y'); @endphp
            <select name="tahun" class="w-full border rounded p-2">
                @for ($t = $start; $t <= $now; $t++)
                    <option value="{{ $t }}" {{ $data->tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Bulan:</label>
            @php $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
            <select name="bulan" class="w-full border rounded p-2">
                @foreach ($bulan as $b)
                    <option value="{{ $b }}" {{ $data->bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Perubahan Harga & Fluktuasi --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-medium">Perubahan Harga:</label>
            <input type="text" name="perubahan_harga" value="{{ $data->perubahan_harga }}" placeholder="Contoh: 0,020202" required class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block mb-1 font-medium">Fluktuasi Tertinggi:</label>
            <input type="text" name="fluktuasi_tertinggi" value="{{ $data->fluktuasi_tertinggi }}" class="w-full border rounded p-2">
        </div>
    </div>

    {{-- Komoditas & Andil --}}
    <div>
        <label class="block mb-2 font-medium">Komoditas & Nilai Andil:</label>
        <div class="space-y-4">
            @for ($i = 1; $i <= 5; $i++)
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nama_komoditas_{{ $i }}" value="{{ $data["nama_komoditas_$i"] }}" placeholder="Nama Komoditas {{ $i }}" class="w-full border rounded p-2">
                    <input type="text" name="nilai_andil_{{ $i }}" value="{{ $data["nilai_andil_$i"] }}" placeholder="Nilai Andil {{ $i }}" class="w-full border rounded p-2">
                </div>
            @endfor
        </div>
    </div>

    {{-- Disparitas & Nilai Fluktuasi --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-medium">Disparitas Harga:</label>
            <input type="text" name="disparitas_harga" value="{{ $data->disparitas_harga }}" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block mb-1 font-medium">Nilai Fluktuasi:</label>
            <input type="text" name="nilai_fluktuasi" value="{{ $data->nilai_fluktuasi }}" class="w-full border rounded p-2">
        </div>
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700 transition">
        Simpan Perubahan
    </button>
</form>
@endsection
