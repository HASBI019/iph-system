@extends('layouts.frontend')

@section('title', 'Beranda IPH')

@section('content')
<section class="w-full px-6 md:px-16 xl:px-24 py-12">
    <h2 class="text-4xl font-bold text-blue-800 mb-6">📊 Grafik IPH Mingguan</h2>
    <p class="text-base text-gray-700 mb-8 leading-relaxed">
        Fluktuasi mingguan terakhir di Kabupaten Tasikmalaya. Data ditampilkan berdasarkan 12 minggu terakhir dari sistem IPH.
    </p>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <canvas id="iphChart" class="w-full h-72"></canvas>
    </div>
</section>

<section id="tentang" class="max-w-7xl mx-auto py-12 px-6 md:px-12">
    <h2 class="text-2xl font-semibold text-blue-800 mb-3">ℹ️ Tentang IPH</h2>
    <p class="text-base text-gray-700 leading-relaxed">
        Indeks Perubahan Harga (IPH) merupakan indikator fluktuasi harga komoditas terpilih yang dihimpun secara mingguan dan bulanan oleh Badan Pusat Statistik (BPS) Kabupaten Tasikmalaya.
        Grafik di atas menunjukkan tren mingguan dalam 3 bulan terakhir. Data disajikan untuk transparansi publik, monitoring inflasi lokal,pengambilan kebijakan berbasis data serta memberikan transparansi kepada masyarakat terkait dinamika harga komoditas unggulan lokal.
    </p>
</section>
@endsection

@push('script')
<script>
const ctx = document.getElementById('iphChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: 'Fluktuasi IPH',
            data: {!! json_encode($data) !!},
            borderColor: '#1e3a8a',
            backgroundColor: '#93c5fd',
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: '#1e3a8a'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Nilai IPH' }
            },
            x: {
                title: { display: true, text: 'Periode Mingguan' }
            }
        }
    }
});
</script>
@endpush