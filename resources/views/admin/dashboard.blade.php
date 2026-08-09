@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Selamat datang, {{ auth()->user()->name }}</h2>
        <p class="mt-1 text-sm text-gray-500">Ini adalah halaman dashboard admin Family Tree.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Anggota Keluarga</p>
            <p class="mt-2 text-3xl font-semibold">{{ $totalPersons }}</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Silsilah</p>
            <p class="mt-2 text-3xl font-semibold">0</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Pengguna Terdaftar</p>
            <p class="mt-2 text-3xl font-semibold">{{ $totalUsers }}</p>
        </div>
    </div>
@endsection
