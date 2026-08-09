@php
    $current = old('gender', $person->gender);
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name', $person->name) }}"
                required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="block text-sm font-medium text-gray-700">Jenis Kelamin</span>
            <div class="mt-1 flex gap-6">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="radio" name="gender" value="L" {{ $current === 'L' ? 'checked' : '' }} required>
                    Laki-laki
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="radio" name="gender" value="P" {{ $current === 'P' ? 'checked' : '' }} required>
                    Perempuan
                </label>
            </div>
            @error('gender')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input
                    id="birth_place"
                    type="text"
                    name="birth_place"
                    value="{{ old('birth_place', $person->birth_place) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
                >
                @error('birth_place')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input
                    id="birth_date"
                    type="date"
                    name="birth_date"
                    value="{{ old('birth_date', optional($person->birth_date)->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
                >
                @error('birth_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea
                id="address"
                name="address"
                rows="2"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >{{ old('address', $person->address) }}</textarea>
            @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
            <input
                id="phone"
                type="text"
                name="phone"
                value="{{ old('phone', $person->phone) }}"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >{{ old('description', $person->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <span class="block text-sm font-medium text-gray-700">Foto</span>

            @if ($person->photo)
                <img src="{{ $person->photoUrl() }}" alt="{{ $person->name }}" class="mt-2 h-32 w-32 rounded-md object-cover">
            @endif

            <input
                type="file"
                name="photo"
                accept="image/*"
                class="mt-2 block w-full text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-gray-900 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800"
            >
            @error('photo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="father_id" class="block text-sm font-medium text-gray-700">Ayah</label>
            <select
                id="father_id"
                name="father_id"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >
                <option value="">- Tidak diketahui -</option>
                @foreach ($fathers as $father)
                    <option value="{{ $father->id }}" {{ (int) old('father_id', $person->father_id) === $father->id ? 'selected' : '' }}>
                        {{ $father->name }}
                    </option>
                @endforeach
            </select>
            @error('father_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="mother_id" class="block text-sm font-medium text-gray-700">Ibu</label>
            <select
                id="mother_id"
                name="mother_id"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >
                <option value="">- Tidak diketahui -</option>
                @foreach ($mothers as $mother)
                    <option value="{{ $mother->id }}" {{ (int) old('mother_id', $person->mother_id) === $mother->id ? 'selected' : '' }}>
                        {{ $mother->name }}
                    </option>
                @endforeach
            </select>
            @error('mother_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="spouse_id" class="block text-sm font-medium text-gray-700">Pasangan</label>
            <select
                id="spouse_id"
                name="spouse_id"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
            >
                <option value="">- Tidak ada -</option>
                @foreach ($spouses as $spouse)
                    <option value="{{ $spouse->id }}" {{ (int) old('spouse_id', $person->spouse_id) === $spouse->id ? 'selected' : '' }}>
                        {{ $spouse->name }}
                    </option>
                @endforeach
            </select>
            @error('spouse_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
