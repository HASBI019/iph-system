@extends('layouts.frontend')

@section('title', 'Beranda IPH')

@section('content')
<section class="w-full px-6 md:px-16 xl:px-24 py-10 flex items-center justify-between flex-wrap">
    {{-- 🖼️ Logo Sistem --}}
    <div class="mb-6 md:mb-0">
        <h1 class="text-3xl font-bold text-indigo-800">Sistem IPH Tasikmalaya</h1>
        <p class="text-gray-600 mt-2">Indeks Perubahan Harga Kabupaten Tasikmalaya</p>
    </div>
    @isset($setting)
        @if ($setting->foto)
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-200 shadow-lg">
                <img src="{{ asset('storage/' . $setting->foto) }}" alt="Logo IPH" class="object-cover w-full h-full">
            </div>
        @endif
    @endisset
</section>

<section class="w-full px-6 md:px-16 xl:px-24 py-12">
    {{-- 🔍 Filter IPH --}}
    <form method="GET" action="{{ route('iph.beranda') }}" class="mb-6 flex gap-4 flex-wrap">
        <select name="tahun" class="border p-2 rounded">
            <option value="">Semua Tahun</option>
            @for ($tahun = date('Y'); $tahun >= 2023; $tahun--)
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endfor
        </select>

        <select name="bulan" class="border p-2 rounded">
            <option value="">Semua Bulan</option>
            @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ $b }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Filter
        </button>
    </form>

    {{-- 📅 Data IPH Bulanan --}}
    @php
        $bulanan = $bulanan ?? collect();
    @endphp
    <h3 class="text-xl font-bold text-blue-700 mb-4">Data IPH Bulanan</h3>
    <div class="overflow-auto border rounded shadow-sm mb-8">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-indigo-700 text-white">
                <tr>
                    <th class="px-4 py-2">Tahun</th>
                    <th class="px-4 py-2">Bulan</th>
                    <th class="px-4 py-2">Perubahan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Fluktuasi</th>
                    <th class="px-4 py-2">Komoditas & Andil</th>
                    <th class="px-4 py-2">Disparitas</th>
                    <th class="px-4 py-2">Fluktuasi (%)</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($bulanan as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->tahun }}</td>
                        <td class="px-4 py-2">{{ $item->bulan }}</td>
                        <td class="px-4 py-2">{{ formatPresisi($item->perubahan_harga) }}</td>
                        <td class="px-4 py-2">{{ $item->status_harga }}</td>
                        <td class="px-4 py-2">{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <ul class="list-disc pl-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($item["nama_komoditas_$i"])
                                        <li>{{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})</li>
                                    @endif
                                @endfor
                            </ul>
                        </td>
                        <td class="px-4 py-2">{{ formatPresisi($item->disparitas_harga) }}</td>
                        <td class="px-4 py-2">{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data bulanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📅 Data IPH Mingguan --}}
    @php
        $mingguan = $mingguan ?? collect();
    @endphp
    <h3 class="text-xl font-bold text-blue-700 mb-4">Data IPH Mingguan</h3>
    <div class="overflow-auto border rounded shadow-sm">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-indigo-700 text-white">
                <tr>
                    <th class="px-4 py-2">Tahun</th>
                    <th class="px-4 py-2">Bulan</th>
                    <th class="px-4 py-2">Minggu</th>
                    <th class="px-4 py-2">Perubahan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Fluktuasi</th>
                    <th class="px-4 py-2">Komoditas & Andil</th>
                    <th class="px-4 py-2">Disparitas</th>
                    <th class="px-4 py-2">Nilai Fluktuasi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($mingguan as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->tahun }}</td>
                        <td class="px-4 py-2">{{ $item->bulan }}</td>
                        <td class="px-4 py-2">{{ $item->minggu_ke }}</td>
                        <td class="px-4 py-2">{{ formatPresisi($item->perubahan_harga) }}</td>
                        <td class="px-4 py-2">{{ $item->status_harga }}</td>
                        <td class="px-4 py-2">{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <ul class="list-disc pl-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($item["nama_komoditas_$i"])
                                        <li>{{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})</li>
                                    @endif
                                @endfor
                            </ul>
                        </td>
                        <td class="px-4 py-2">{{ formatPresisi($item->disparitas_harga) }}</td>
                        <td class="px-4 py-2">{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4 text-gray-500">Tidak ada data mingguan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<section id="tentang" class="max-w-7xl mx-auto py-12 px-6 md:px-12">
    <h2 class="text-2xl font-semibold text-blue-800 mb-3">ℹ️ Tentang IPH</h2>
    <p class="text-base text-gray-700 leading-relaxed">
        Indeks Perubahan Harga (IPH) merupakan indikator fluktuasi harga komoditas terpilih yang dihimpun secara mingguan dan bulanan oleh Badan Pusat Statistik (BPS) Kabupaten Tasikmalaya.
        Data disajikan untuk transparansi publik, monitoring inflasi lokal, pengambilan kebijakan berbasis data serta memberikan transparansi kepada masyarakat terkait dinamika harga komoditas unggulan lokal.
    </p>
</section>
@endsection
