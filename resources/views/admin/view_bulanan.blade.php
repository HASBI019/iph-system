@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Data IPH Bulanan</h2>

    {{-- Filter Tahun & Bulan --}}
    <form method="GET" action="/admin/iph/view-bulanan" class="mb-6 flex space-x-4">
        <select name="tahun" class="border rounded p-2">
            <option value="">Semua Tahun</option>
            @php $tahunAwal = 2023; $tahunSekarang = date('Y'); @endphp
            @for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++)
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endfor
        </select>

        <select name="bulan" class="border rounded p-2">
            <option value="">Semua Bulan</option>
            @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ $b }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filter</button>
    </form>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($data->isEmpty())
        <p class="text-gray-500">Tidak ada data tersedia.</p>
    @else
        <div class="overflow-auto border rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-700 text-white">
                    <tr>
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2">Bulan</th>
                        <th class="px-4 py-2">Perubahan Harga</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Fluktuasi</th>
                        <th class="px-4 py-2">Komoditas & Andil</th>
                        <th class="px-4 py-2">Disparitas</th>
                        <th class="px-4 py-2">Nilai Fluktuasi</th>
                        <th class="px-4 py-2">Waktu</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($data as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->tahun }}</td>
                            <td class="px-4 py-2">{{ $item->bulan }}</td>
                            <td class="px-4 py-2">{{ $item->perubahan_harga }}</td>
                            <td class="px-4 py-2">{{ $item->status_harga }}</td>
                            <td class="px-4 py-2">{{ $item->fluktuasi_tertinggi ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">
                                <ul class="list-disc pl-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($item["nama_komoditas_$i"])
                                            <li>{{ $item["nama_komoditas_$i"] }} ({{ $item["nilai_andil_$i"] }})</li>
                                        @endif
                                    @endfor
                                </ul>
                            </td>
                            <td class="px-4 py-2">{{ $item->disparitas_harga ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->nilai_fluktuasi ?? '-' }}</td>
                            <td class="px-4 py-2 text-xs text-gray-500">{{ $item->created_at }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.iph.edit.bulanan', ['id' => $item->id]) }}" class="text-blue-600 hover:underline">Edit</a>
<a href="/admin/iph/delete-bulanan/{{ $item->id }}" onclick="return confirm('Hapus data ini?')" class="text-red-600 hover:underline">Hapus</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
