@extends('layouts.admin')

@section('title', 'Tambah Anggota Keluarga')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Tambah Anggota Keluarga</h2>
        <a href="{{ route('admin.persons.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.persons.store') }}" enctype="multipart/form-data" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        @include('admin.persons._fields')

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.persons.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Simpan
            </button>
        </div>
    </form>
@endsection
