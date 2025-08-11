@extends('layouts.frontend')

@section('title', 'Grafik IPH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-8">📊 Grafik Indeks Perubahan Harga (IPH)</h1>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('grafik') }}" class="bg-white shadow-md rounded-lg p-6 mb-10 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun" id="tahun" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach($tahunTersedia as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Data</label>
                <select name="jenis" id="jenis" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="perubahan" {{ $jenis == 'perubahan' ? 'selected' : '' }}>Perubahan Harga</option>
                    <option value="nilai" {{ $jenis == 'nilai' ? 'selected' : '' }}>Nilai Fluktuasi</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition">
                    Tampilkan
                </button>
            </div>
        </div>
    </form>

    {{-- Grafik Bulanan --}}
    <div class="mb-16">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4 text-center">
            📅 Grafik Bulanan ({{ $jenis == 'nilai' ? 'Nilai Fluktuasi' : 'Perubahan Harga' }})
        </h2>
        <div class="bg-white shadow rounded-lg p-4">
            <canvas id="chartBulanan" class="w-full h-64"></canvas>
        </div>
    </div>

    {{-- Grafik Mingguan --}}
    <div>
        <h2 class="text-xl font-semibold text-blue-700 mb-4 text-center">
            🗓️ Grafik Mingguan ({{ $jenis == 'nilai' ? 'Nilai Fluktuasi' : 'Perubahan Harga' }})
        </h2>
        <div class="bg-white shadow rounded-lg p-4">
            <canvas id="chartMingguan" class="w-full h-64"></canvas>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    const chartBulanan = new Chart(document.getElementById('chartBulanan'), {
        type: 'line',
        data: {
            labels: @json($labelsBulanan),
            datasets: [{
                label: '{{ $jenis == "nilai" ? "Nilai Fluktuasi Bulanan" : "Perubahan Harga Bulanan" }}',
                data: @json($dataBulanan),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Harga (Rp)' }
                },
                x: {
                    title: { display: true, text: 'Bulan' }
                }
            }
        }
    });

    const chartMingguan = new Chart(document.getElementById('chartMingguan'), {
        type: 'line',
        data: {
            labels: @json($labelsMingguan),
            datasets: [{
                label: '{{ $jenis == "nilai" ? "Nilai Fluktuasi Mingguan" : "Perubahan Harga Mingguan" }}',
                data: @json($dataMingguan),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Harga (Rp)' }
                },
                x: {
                    title: { display: true, text: 'Minggu' }
                }
            }
        }
    });
</script>
@endpush
