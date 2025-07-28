@extends('layouts.frontend')
@section('title', 'Grafik IPH')

@section('content')
<section class="px-6 md:px-16 xl:px-24 py-10">
    <h2 class="text-2xl font-bold text-indigo-800 mb-4">Grafik Indeks Perubahan Harga</h2>

    <canvas id="grafikBulanan" height="120"></canvas>
    <canvas id="grafikMingguan" height="120" class="mt-12"></canvas>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxBulanan = document.getElementById('grafikBulanan');
new Chart(ctxBulanan, {
    type: 'line',
    data: {
        labels: {!! json_encode($labelsBulanan) !!},
        datasets: [{
            label: 'Fluktuasi Bulanan',
            data: {!! json_encode($dataBulanan) !!},
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            tension: 0.3
        }]
    }
});

const ctxMingguan = document.getElementById('grafikMingguan');
new Chart(ctxMingguan, {
    type: 'line',
    data: {
        labels: {!! json_encode($labelsMingguan) !!},
        datasets: [{
            label: 'Fluktuasi Mingguan',
            data: {!! json_encode($dataMingguan) !!},
            borderColor: '#059669',
            backgroundColor: 'rgba(5, 150, 105, 0.1)',
            tension: 0.3
        }]
    }
});
</script>
@endpush
