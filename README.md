# FamilyTree_V2

Aplikasi Family Tree berbasis Laravel dengan arsitektur monolith.

## Requirement

- PHP >= 8.2
- Composer
- Node.js & NPM (untuk build asset frontend)

## Setup

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

## Menjalankan aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`.
