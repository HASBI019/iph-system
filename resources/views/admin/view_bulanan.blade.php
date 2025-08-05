@extends('layouts.admin')

@section('title', 'Data IPH Bulanan')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-indigo-700">Data IPH Bulanan</h2>

{{-- Filter --}}
<form method="GET" action="{{ route('iph-bulanan.index') }}" class="mb-6 flex flex-wrap gap-4">
    <select name="tahun" class="border rounded p-2 text-sm">
        <option value="">Semua Tahun</option>
        @for ($tahun = 2023; $tahun <= date('Y'); $tahun++)
            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
        @endfor
    </select>
    <select name="bulan" class="border rounded p-2 text-sm">
        <option value="">Semua Bulan</option>
        @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
            <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ $b }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">Filter</button>
</form>

@if ($data->isEmpty())
    <p class="text-gray-500 text-sm">Tidak ada data tersedia.</p>
@else
<div class="overflow-x-auto border rounded shadow-sm">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-indigo-700 text-white text-xs uppercase">
            <tr>
                <th class="px-3 py-2">Waktu</th>
                <th class="px-3 py-2">Tahun</th>
                <th class="px-3 py-2">Bulan</th>
                <th class="px-3 py-2">Perubahan</th>
                <th class="px-3 py-2">Komoditas & Andil</th>
                <th class="px-3 py-2">Fluktuasi</th>
                <th class="px-3 py-2">Nilai Fluktuasi</th>
                <th class="px-3 py-2">Disparitas</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($data as $item)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-3 py-2 text-xs text-gray-500">
                    {{ $item->waktu ? \Carbon\Carbon::parse($item->waktu)->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="px-3 py-2">{{ $item->tahun }}</td>
                <td class="px-3 py-2">{{ $item->bulan }}</td>
                <td class="px-3 py-2">{{ formatPresisi($item->perubahan_harga) }}</td>
                <td class="px-3 py-2 whitespace-pre-line text-xs">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($item["nama_komoditas_$i"])
                            • {{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})  
                        @endif
                    @endfor
                </td>
                <td class="px-3 py-2">{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                <td class="px-3 py-2">{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                <td class="px-3 py-2">{{ formatPresisi($item->disparitas_harga) }}</td>
                <td class="px-3 py-2">{{ $item->status_harga }}</td>
                <td class="px-3 py-2 whitespace-nowrap space-x-2">
                    <a href="{{ route('iph-bulanan.edit', $item->id) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                    <a href="{{ route('iph-bulanan.delete', $item->id) }}" onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 hover:underline text-xs">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
