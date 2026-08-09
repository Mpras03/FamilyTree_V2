<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Family Tree') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center px-6 text-center">
            <h1 class="text-3xl font-semibold">{{ config('app.name', 'Family Tree') }}</h1>
            <p class="mt-3 max-w-md text-gray-600">
                Aplikasi untuk mengelola dan menelusuri silsilah keluarga.
            </p>

            <a
                href="{{ route('login') }}"
                class="mt-8 inline-flex items-center rounded-md bg-gray-900 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-gray-800"
            >
                Login Admin
            </a>
        </div>
    </body>
</html>
