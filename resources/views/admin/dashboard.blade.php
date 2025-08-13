@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $mingguan = \App\Models\IphMingguan::orderByDesc('created_at')->first();
@endphp

<div class="max-w-7xl mx-auto px-6 py-6 space-y-6">

    {{-- TOPBAR --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-indigo-700">📊 Dashboard IPH</h2>
            <p class="text-gray-600 text-sm">Kelola data fluktuasi harga mingguan & bulanan.</p>
        </div>
        @if(Auth::check())
            <div class="flex items-center space-x-2 bg-green-100 text-green-700 px-4 py-2 rounded shadow text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ Auth::user()->email }}</span>
            </div>
        @endif
    </div>

    {{-- STATISTIK CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <h4 class="text-gray-700 font-semibold">Data Mingguan</h4>
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m12 6h-6m6 6h-6" />
                </svg>
                 
            </div>
            <p class="text-2xl font-bold mt-2 text-indigo-700">{{ \App\Models\IphMingguan::count() ?? 0 }}</p>
            <a href="/admin/iph/view-mingguan" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Lihat detail</a>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <h4 class="text-gray-700 font-semibold">Data Bulanan</h4>
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 10h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="text-2xl font-bold mt-2 text-blue-700">{{ \App\Models\IphBulanan::count() ?? 0 }}</p>
             <a href="/admin/iph/view-bulanan" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Lihat detail</a>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <h4 class="text-gray-700 font-semibold">Fluktuasi Tertinggi</h4>
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
            </div>
            <p class="text-sm mt-2 text-gray-600">{{ $mingguan->fluktuasi_tertinggi ?? '—' }}</p>
        </div>
    </div>


    {{-- EXPORT BUTTONS --}}
    <div class="grid grid-cols-2 gap-4">
        <a href="/admin/iph/export-mingguan"
           class="flex items-center justify-center bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm4 8h8m-8 4h8" />
            </svg>
            Export Mingguan
        </a>
        <a href="/admin/iph/export-bulanan"
           class="flex items-center justify-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm4 8h8m-8 4h8" />
            </svg>
            Export Bulanan
        </a>
    </div>

    {{-- BRANDING --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg p-6 shadow-lg mt-6">
        <h3 class="text-2xl font-bold mb-2">Sistem IPH BPS Tasikmalaya</h3>
        <p class="text-sm">Monitoring fluktuasi harga secara efisien & akurat setiap minggu dan bulan.</p>
    </div>


    </div>
@endsection
