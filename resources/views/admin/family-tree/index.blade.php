@extends('layouts.admin')

@section('title', 'Silsilah Keluarga')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Silsilah Keluarga</h2>
        <p class="mt-1 text-sm text-gray-500">Klik foto atau nama anggota keluarga untuk melihat detail dan menampilkan generasi berikutnya.</p>
    </div>

    @if (empty($tree))
        <div class="rounded-lg border border-gray-200 bg-white p-8 text-center text-gray-500 shadow-sm">
            Belum ada data untuk ditampilkan.
            <a href="{{ route('admin.persons.create') }}" class="font-medium text-gray-900 underline">Tambahkan anggota keluarga</a> terlebih dahulu.
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[1fr_320px]">
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
                <div class="family-tree">
                    <ul class="flex justify-center">
                        @foreach ($tree as $unit)
                            @include('admin.family-tree._unit', ['unit' => $unit])
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="h-fit rounded-lg border border-gray-200 bg-white p-5 shadow-sm lg:sticky lg:top-6">
                <p id="person-detail-empty" class="text-sm text-gray-500">
                    Klik salah satu anggota keluarga di pohon untuk melihat detailnya di sini.
                </p>

                <div id="person-detail" class="hidden">
                    <div id="detail-photo-wrapper" class="mb-4"></div>
                    <h3 id="detail-name" class="text-lg font-semibold text-gray-900"></h3>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div>
                            <dt class="font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                            <dd id="detail-birth" class="mt-0.5 text-gray-900">-</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Alamat</dt>
                            <dd id="detail-address" class="mt-0.5 text-gray-900">-</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Nomor HP</dt>
                            <dd id="detail-phone" class="mt-0.5 text-gray-900">-</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Deskripsi</dt>
                            <dd id="detail-description" class="mt-0.5 whitespace-pre-line text-gray-900">-</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <style>
            .family-tree, .family-tree ul, .family-tree li {
                list-style: none;
                margin: 0;
                padding: 0;
                position: relative;
            }

            .family-tree ul {
                display: flex;
                padding-top: 32px;
            }

            .family-tree li {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 32px 10px 0 10px;
            }

            .family-tree li::before,
            .family-tree li::after {
                content: '';
                position: absolute;
                top: 0;
                right: 50%;
                width: 50%;
                height: 32px;
                border-top: 2px solid #d1d5db;
            }
            .family-tree li::after {
                right: auto;
                left: 50%;
                border-left: 2px solid #d1d5db;
            }
            .family-tree li:only-child::before,
            .family-tree li:only-child::after {
                display: none;
            }
            .family-tree li:only-child {
                padding-top: 0;
            }
            .family-tree li:first-child::before {
                border: none;
            }
            .family-tree li:last-child::after {
                border: none;
            }
            .family-tree li:last-child::before {
                border-right: 2px solid #d1d5db;
                border-radius: 0 6px 0 0;
            }
            .family-tree li:first-child::after {
                border-radius: 6px 0 0 0;
            }

            .family-tree > ul > li::before,
            .family-tree > ul > li::after {
                display: none;
            }

            .family-tree ul ul::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                border-left: 2px solid #d1d5db;
                width: 0;
                height: 32px;
            }
        </style>

        <script>
            (function () {
                const detailEmpty = document.getElementById('person-detail-empty');
                const detail = document.getElementById('person-detail');
                const photoWrapper = document.getElementById('detail-photo-wrapper');
                const nameEl = document.getElementById('detail-name');
                const birthEl = document.getElementById('detail-birth');
                const addressEl = document.getElementById('detail-address');
                const phoneEl = document.getElementById('detail-phone');
                const descriptionEl = document.getElementById('detail-description');

                function showDetail(el) {
                    const name = el.dataset.name;
                    const photo = el.dataset.photo;

                    nameEl.textContent = name;

                    photoWrapper.innerHTML = photo
                        ? `<img src="${photo}" alt="${name}" class="h-32 w-32 rounded-lg object-cover">`
                        : `<div class="flex h-32 w-32 items-center justify-center rounded-lg bg-gray-100 text-3xl font-medium text-gray-400">${name.charAt(0)}</div>`;

                    const ttl = [el.dataset.birthPlace, el.dataset.birthDate].filter(Boolean).join(', ');
                    birthEl.textContent = ttl || '-';
                    addressEl.textContent = el.dataset.address || '-';
                    phoneEl.textContent = el.dataset.phone || '-';
                    descriptionEl.textContent = el.dataset.description || '-';

                    detailEmpty.classList.add('hidden');
                    detail.classList.remove('hidden');
                }

                function toggleChildren(unitId) {
                    const children = document.getElementById('children-' + unitId);
                    const icon = document.querySelector('[data-toggle-icon="' + unitId + '"]');

                    if (!children) {
                        return;
                    }

                    if (children.hasAttribute('hidden')) {
                        children.removeAttribute('hidden');
                        if (icon) icon.textContent = '−';
                    } else {
                        children.setAttribute('hidden', '');
                        if (icon) icon.textContent = '+';
                    }
                }

                document.querySelectorAll('[data-person]').forEach((el) => {
                    el.addEventListener('click', () => {
                        showDetail(el);

                        if (el.dataset.toggle) {
                            toggleChildren(el.dataset.toggle);
                        }
                    });
                });

                document.querySelectorAll('[data-toggle-icon]').forEach((el) => {
                    el.addEventListener('click', (event) => {
                        event.stopPropagation();
                        toggleChildren(el.getAttribute('data-toggle-icon'));
                    });
                });
            })();
        </script>
    @endif
@endsection
