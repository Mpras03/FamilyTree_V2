<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Family Tree') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-100 text-gray-900 antialiased">
        <div class="min-h-screen lg:flex">
            <aside
                id="sidebar"
                class="fixed inset-y-0 left-0 z-30 w-64 -translate-x-full bg-gray-900 text-gray-200 transition-transform duration-200 lg:static lg:translate-x-0"
            >
                <div class="flex h-16 items-center border-b border-gray-800 px-6">
                    <span class="text-lg font-semibold text-white">Family Tree</span>
                </div>

                <nav class="mt-4 space-y-1 px-3">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                    >
                        Dashboard
                    </a>
                    <a
                        href="{{ route('admin.persons.index') }}"
                        class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.persons.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                    >
                        Data Keluarga
                    </a>
                    <a
                        href="{{ route('admin.family-tree') }}"
                        class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.family-tree') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
                    >
                        Silsilah Keluarga
                    </a>
                </nav>
            </aside>

            <div id="sidebar-backdrop" class="fixed inset-0 z-20 hidden bg-black/40 lg:hidden"></div>

            <div class="flex min-h-screen flex-1 flex-col">
                <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 lg:px-6">
                    <button id="sidebar-toggle" type="button" class="rounded-md p-2 text-gray-500 hover:bg-gray-100 lg:hidden">
                        <span class="sr-only">Buka menu</span>
                        &#9776;
                    </button>

                    <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            {{ auth()->user()->name }} &middot; Logout
                        </button>
                    </form>
                </header>

                <main class="flex-1 p-4 lg:p-6">
                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggle = document.getElementById('sidebar-toggle');

            toggle?.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            });

            backdrop?.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            });
        </script>
    </body>
</html>
