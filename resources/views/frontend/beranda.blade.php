@extends('layouts.frontend')

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('title', 'Beranda IPH')

@section('content')
<section class="w-full px-6 md:px-16 xl:px-24 py-10 flex items-center justify-between flex-wrap">
    @isset($setting)
        <div class="mb-6 md:mb-0">
        <h1 class="text-3xl font-bold text-indigo-800">Sistem IPH Tasikmalaya</h1>
        <p class="text-gray-600 mt-2">Indeks Perubahan Harga Kabupaten Tasikmalaya</p>
        </div>
        @if ($setting->foto)
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-200 shadow-lg">
                <img src="{{ asset('storage/' . $setting->foto) }}" alt="Logo IPH" class="object-cover w-full h-full">
            </div>
        @endif
    @endisset
</section>

<section class="w-full px-6 md:px-16 xl:px-24 py-4">
    {{-- 🔍 Filter --}}
    <form method="GET" action="{{ route('iph.beranda') }}" class="mb-6 flex flex-wrap gap-4 items-center justify-start">
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
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
    </form>

    {{-- 🧭 Tabs --}}
    <div class="mb-4">
        <ul class="flex border-b text-blue-800 font-semibold">
            <li class="mr-4 cursor-pointer tablink border-b-2 border-indigo-600 pb-2" onclick="showTab(event, 'bulanan')">📅 IPH Bulanan</li>
            <li class="mr-4 cursor-pointer tablink pb-2" onclick="showTab(event, 'mingguan')">🗓️ IPH Mingguan</li>
        </ul>
    </div>

    {{-- 📊 Tabel Bulanan --}}
    <div id="bulanan" class="tab-content">
        <div class="overflow-auto border rounded bg-white p-4 shadow-sm">
            <table id="tabelBulanan" class="min-w-full text-sm table-auto">
                <thead class="bg-indigo-700 text-white">
                    <tr>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Perubahan</th>
                        <th>Status</th>
                        <th>Fluktuasi</th>
                        <th>Komoditas & Andil</th>
                        <th>Disparitas</th>
                        <th>Fluktuasi (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulanan as $item)
                    <tr class="border-t hover:bg-indigo-50">
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->bulan }}</td>
                        <td>{{ formatPresisi($item->perubahan_harga) }}</td>
                        <td>{{ $item->status_harga }}</td>
                        <td>{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                        <td>
                            <ul class="list-disc pl-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($item["nama_komoditas_$i"])
                                        <li>{{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})</li>
                                    @endif
                                @endfor
                            </ul>
                        </td>
                        <td>{{ formatPresisi($item->disparitas_harga) }}</td>
                        <td>{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📊 Tabel Mingguan --}}
    <div id="mingguan" class="tab-content hidden">
        <div class="overflow-auto border rounded bg-white p-4 shadow-sm">
            <table id="tabelMingguan" class="min-w-full text-sm table-auto">
                <thead class="bg-indigo-700 text-white">
                    <tr>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Minggu</th>
                        <th>Perubahan</th>
                        <th>Status</th>
                        <th>Fluktuasi</th>
                        <th>Komoditas & Andil</th>
                        <th>Disparitas</th>
                        <th>Nilai Fluktuasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mingguan as $item)
                    <tr class="border-t hover:bg-indigo-50">
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->bulan }}</td>
                        <td>{{ $item->minggu_ke }}</td>
                        <td>{{ formatPresisi($item->perubahan_harga) }}</td>
                        <td>{{ $item->status_harga }}</td>
                        <td>{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                        <td>
                            <ul class="list-disc pl-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($item["nama_komoditas_$i"])
                                        <li>{{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})</li>
                                    @endif
                                @endfor
                            </ul>
                        </td>
                        <td>{{ formatPresisi($item->disparitas_harga) }}</td>
                        <td>{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="tentang" class="max-w-7xl mx-auto py-12 px-6 md:px-12">
    <h2 class="text-2xl font-semibold text-blue-800 mb-3">ℹ️ Tentang IPH</h2>
    <p class="text-base text-gray-700 leading-relaxed">
        Indeks Perubahan Harga (IPH) merupakan indikator fluktuasi harga komoditas terpilih yang dihimpun secara mingguan dan bulanan oleh Badan Pusat Statistik (BPS) Kabupaten Tasikmalaya.
    </p>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    const options = {
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        dom: '<"flex flex-wrap justify-between items-center gap-4 mb-4"lf>rt<"flex justify-between items-center mt-4"ip>'
    };

    $('#tabelBulanan').DataTable(options);
    $('#tabelMingguan').DataTable(options);
});

function showTab(evt, id) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');

    document.querySelectorAll('.tablink').forEach(btn => btn.classList.remove('border-indigo-600'));
    evt.target.classList.add('border-indigo-600');
}
</script>
@endpush
