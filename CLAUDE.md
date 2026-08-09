# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

FamilyTree_V2 — a Laravel family-tree application, built as a monolith (per README.md, in Indonesian). The codebase is currently a fresh Laravel 13 skeleton install: no custom models, controllers, or routes beyond Laravel's defaults have been added yet.

Stack: PHP 8.3+, Laravel 13, SQLite (dev/test), Vite + Tailwind CSS 4 for the frontend, vanilla JS (no SPA framework configured).

## Setup

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
```

## Common commands

Run the full dev stack (Laravel server, queue listener, log viewer via Pail, and Vite) concurrently:
```bash
composer dev
```

Or run pieces individually:
```bash
php artisan serve          # app at http://127.0.0.1:8000
npm run dev                # Vite dev server
npm run build               # production frontend build
```

Tests (Pest/PHPUnit via Artisan):
```bash
composer test                          # clears config cache, then runs php artisan test
php artisan test                       # run full suite
php artisan test --filter=testName     # run a single test by name
php artisan test tests/Feature/ExampleTest.php   # run a single test file
```

Lint/format (Laravel Pint):
```bash
vendor/bin/pint            # format all files
vendor/bin/pint --test     # check formatting without writing
```

Database:
```bash
php artisan migrate            # run migrations (SQLite db at database/database.sqlite)
php artisan migrate:fresh --seed
php artisan db:seed
```

## Architecture notes

- Standard Laravel structure: `app/Http/Controllers`, `app/Models`, `app/Providers`, `routes/web.php`, `routes/console.php`.
- Tests use PHPUnit/Pest and run against an in-memory SQLite database (`phpunit.xml` sets `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`). Feature tests live in `tests/Feature`, unit tests in `tests/Unit`.
- Frontend assets are compiled via Vite (`vite.config.js`), entry points are `resources/css/app.css` and `resources/js/app.js`, rendered through Blade views in `resources/views`.
- No API layer, authentication scaffolding, or family-tree domain models exist yet — when adding them, follow standard Laravel conventions (migrations in `database/migrations`, Eloquent models in `app/Models`, routes in `routes/web.php` or a new `routes/api.php`).
