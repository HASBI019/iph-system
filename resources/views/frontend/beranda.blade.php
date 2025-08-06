@extends('layouts.frontend')

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('title', 'Beranda IPH')

@section('content')

<section class="max-w-5xl mx-auto px-4 md:px-6 xl:px-8 py-8 space-y-8">
 {{-- ℹ️ Tentang IPH --}}
@isset($setting)
<div class="w-full mb-6">
    <h2 class="text-xl font-semibold text-blue-800 mb-4">ℹ️ Tentang IPH</h2>

    <div class="flex flex-col md:flex-row gap-4 items-start">
        {{-- Deskripsi --}}
        <div class="md:w-2/3 text-justify text-sm leading-relaxed text-gray-700">
            {!! $setting->deskripsi_iph !!}
        </div>

        {{-- Foto --}}
<div class="md:w-1/3">
    @if($setting->foto_iph)
        <img src="{{ asset('storage/' . $setting->foto_iph) }}"
             alt="Foto IPH"
             class="w-full h-auto rounded shadow-sm object-cover">
    @else
        <p class="text-sm text-gray-500 italic">Belum ada foto IPH yang ditampilkan.</p>
    @endif
</div>

</div>
@endisset


    {{-- 🔍 Filter --}}
    <form method="GET" action="{{ route('iph.beranda') }}" class="mb-6 flex flex-wrap gap-3 items-center justify-start text-sm">
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
        <ul class="flex border-b text-blue-800 font-semibold text-sm">
            <li class="mr-4 cursor-pointer tablink border-b-2 border-indigo-600 pb-2" onclick="showTab(event, 'bulanan')">📅 IPH Bulanan</li>
            <li class="mr-4 cursor-pointer tablink pb-2" onclick="showTab(event, 'mingguan')">🗓️ IPH Mingguan</li>
        </ul>
    </div>

   {{-- 📊 Tabel Bulanan --}}
<div id="bulanan" class="tab-content">
    <div class="w-full overflow-x-auto border rounded bg-white p-4 shadow-sm">
        <table id="tabelBulanan" class="min-w-full text-xs table-auto">
            <thead class="bg-indigo-700 text-white">
                <tr>
                    <th class="px-2 py-2 text-left">Tahun</th>
                    <th class="px-2 py-2 text-left">Bulan</th>
                    <th class="px-2 py-2 text-left">Perubahan</th>
                    <th class="px-2 py-2 text-left">Status</th>
                    <th class="px-2 py-2 text-left whitespace-nowrap w-32">Fluktuasi</th>
                    <th class="px-2 py-2 text-left whitespace-nowrap">Komoditas & Andil</th>
                    <th class="px-2 py-2 text-left">Disparitas</th>
                    <th class="px-2 py-2 text-left">Nilai fluktuasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bulanan as $item)
                <tr class="border-t hover:bg-indigo-50 align-top">
                    <td class="px-2 py-2 align-top">{{ $item->tahun }}</td>
                    <td class="px-2 py-2 align-top">{{ $item->bulan }}</td>
                    <td class="px-2 py-2 align-top">{{ formatPresisi($item->perubahan_harga) }}</td>
                    <td class="px-2 py-2 align-top">{{ $item->status_harga }}</td>
                    <td class="px-2 py-2 align-top w-32">{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                    <td class="px-2 py-2 align-top whitespace-normal">
                        <div class="space-y-1 text-sm pl-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if (!empty($item["nama_komoditas_$i"]))
                                    <div>• {{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})</div>
                                @endif
                            @endfor
                        </div>
                    </td>
                    <td class="px-2 py-2 align-top">{{ formatPresisi($item->disparitas_harga) }}</td>
                    <td class="px-2 py-2 align-top">{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

   {{-- 📊 Tabel Mingguan --}}
<div id="mingguan" class="tab-content hidden">
    <div class="w-full overflow-x-auto border rounded bg-white p-4 shadow-sm">
        <table id="tabelMingguan" class="min-w-full text-xs table-auto">
            <thead class="bg-indigo-700 text-white">
                <tr>
                    <th class="px-2 py-2 text-left">Tahun</th>
                    <th class="px-2 py-2 text-left">Bulan</th>
                    <th class="px-2 py-2 text-left">Minggu</th>
                    <th class="px-2 py-2 text-left">Perubahan</th>
                    <th class="px-2 py-2 text-left">Status</th>
                    <th class="px-2 py-2 text-left whitespace-nowrap w-32">Fluktuasi</th>
                    <th class="px-2 py-2 text-left whitespace-nowrap">Komoditas & Andil</th>
                    <th class="px-2 py-2 text-left">Disparitas</th>
                    <th class="px-2 py-2 text-left">Nilai Fluktuasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mingguan as $item)
                <tr class="border-t hover:bg-indigo-50 align-top">
                    <td class="px-2 py-2 align-top">{{ $item->tahun }}</td>
                    <td class="px-2 py-2 align-top">{{ $item->bulan }}</td>
                    <td class="px-2 py-2 align-top">{{ $item->minggu_ke }}</td>
                    <td class="px-2 py-2 align-top">{{ formatPresisi($item->perubahan_harga) }}</td>
                    <td class="px-2 py-2 align-top">{{ $item->status_harga }}</td>
                    <td class="px-2 py-2 align-top w-32">{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                    <td class="px-2 py-2 align-top whitespace-normal">
                        <div class="space-y-1 text-sm pl-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if (!empty($item["nama_komoditas_$i"]))
                                    <div>• {{ $item["nama_komoditas_$i"] }} ({{ formatPresisi($item["nilai_andil_$i"]) }})</div>
                                @endif
                            @endfor
                        </div>
                    </td>
                    <td class="px-2 py-2 align-top">{{ formatPresisi($item->disparitas_harga) }}</td>
                    <td class="px-2 py-2 align-top">{{ formatPresisi($item->nilai_fluktuasi) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

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
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
        paginate: {
          previous: "Prev",
          next: "Next"
        },
        search: "Cari:",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri"
      },
      dom: '<"flex flex-wrap justify-between items-center gap-4 mb-4"lf>rt<"flex justify-between items-center mt-4"ip>'
    };

$('#tabelBulanan').DataTable({
  ...options,
  order: [] 
});

$('#tabelMingguan').DataTable({
  ...options,
  order: []
});

    const defaultTab = document.querySelector('.tablink');
    if (defaultTab) {
      showTab({ currentTarget: defaultTab }, 'bulanan');
    }
  });

  function showTab(evt, id) {

    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));

    // Tampilkan tab yang dipilih
    document.getElementById(id).classList.remove('hidden');

    document.querySelectorAll('.tablink').forEach(btn => {
      btn.classList.remove('border-indigo-600', 'text-indigo-700');
    });

    evt.currentTarget.classList.add('border-indigo-600', 'text-indigo-700');
  }
</script>
@endpush
