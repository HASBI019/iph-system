@extends('layouts.frontend')

@section('title', 'Dashboard IPH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-8">
        📊 Dashboard Indeks Perubahan Harga (IPH)
    </h1>

    <!-- Card untuk Dashboard -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <div class="p-4 bg-blue-50 border-b border-blue-200">
            <h2 class="text-xl font-semibold text-blue-800">Visualisasi Data Interaktif</h2>
           
        </div>

        <!-- Iframe Looker Studio -->
        <div class="relative" style="padding-top: 56.25%; height: 0;">
            <iframe 
                src="https://lookerstudio.google.com/embed/reporting/ee040c66-d7bd-43b6-886e-01d3f74ee98e/page/Qf0pD" 
                frameborder="0" 
                style="border:0; position:absolute; top:0; left:0; width:100%; height:100%;" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>
@endsection
