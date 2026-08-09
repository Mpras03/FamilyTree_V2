@php
    $unitId = 'unit-'.$unit['members'][0]->id;
    $hasChildren = count($unit['children']) > 0;
@endphp

<li>
    <div class="node inline-flex items-center gap-1 p-2">
        @foreach ($unit['members'] as $index => $member)
            @if ($index > 0)
                <span class="h-px w-4 shrink-0 bg-gray-300"></span>
            @endif

            <div
                class="flex w-24 cursor-pointer flex-col items-center rounded-md p-1 text-center hover:bg-gray-50"
                data-person="{{ $member->id }}"
                data-name="{{ $member->name }}"
                data-photo="{{ $member->photoUrl() }}"
                data-birth-place="{{ $member->birth_place }}"
                data-birth-date="{{ optional($member->birth_date)->translatedFormat('d M Y') }}"
                data-address="{{ $member->address }}"
                data-phone="{{ $member->phone }}"
                data-description="{{ $member->description }}"
                @if ($hasChildren) data-toggle="{{ $unitId }}" @endif
            >
                @if ($member->photo)
                    <img
                        src="{{ $member->photoUrl() }}"
                        alt="{{ $member->name }}"
                        class="h-16 w-16 rounded-full border border-gray-200 object-cover"
                    >
                @else
                    <div class="flex h-16 w-16 items-center justify-center rounded-full border border-gray-200 bg-gray-100 text-lg font-medium text-gray-500">
                        {{ Str::substr($member->name, 0, 1) }}
                    </div>
                @endif

                <span class="mt-2 line-clamp-2 text-xs font-medium text-gray-900">{{ $member->name }}</span>

                @if ($member->birth_date)
                    <span class="text-[11px] text-gray-400">{{ $member->birth_date->format('Y') }}</span>
                @endif
            </div>
        @endforeach

        @if ($hasChildren)
            <span
                data-toggle-icon="{{ $unitId }}"
                class="ml-1 flex h-5 w-5 shrink-0 cursor-pointer items-center justify-center self-start rounded-full bg-gray-900 text-xs font-semibold text-white"
            >+</span>
        @endif
    </div>

    @if ($hasChildren)
        <ul id="children-{{ $unitId }}" hidden>
            @foreach ($unit['children'] as $child)
                @include('admin.family-tree._unit', ['unit' => $child])
            @endforeach
        </ul>
    @endif
</li>
