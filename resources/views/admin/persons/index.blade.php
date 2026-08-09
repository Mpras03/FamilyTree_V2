@extends('layouts.admin')

@section('title', 'Data Keluarga')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Data Keluarga</h2>
        <a href="{{ route('admin.persons.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
            + Tambah Anggota
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Foto</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Nama</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Jenis Kelamin</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tempat, Tanggal Lahir</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Ayah</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Ibu</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Pasangan</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($persons as $person)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($person->photo)
                                <img src="{{ $person->photoUrl() }}" alt="{{ $person->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-xs font-medium text-gray-500">
                                    {{ Str::substr($person->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $person->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $person->birth_place }}
                            @if ($person->birth_place && $person->birth_date)
                                ,
                            @endif
                            {{ optional($person->birth_date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->father?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->mother?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $person->spouse?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.persons.edit', $person) }}" class="font-medium text-gray-600 hover:text-gray-900">Edit</a>
                                <form method="POST" action="{{ route('admin.persons.destroy', $person) }}" onsubmit="return confirm('Hapus data {{ $person->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">Belum ada data keluarga.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $persons->links() }}
    </div>
@endsection
