# Copilot Instructions for this Repository

This is a Laravel 13 starter application with a Vite/Tailwind front end. The source code is mostly scaffolded: models, controllers, and migrations are present, but few routes and business flows are implemented.

## What to know first
- `routes/web.php` currently only serves the default `welcome` page.
- `resources/views/welcome.blade.php` is the current landing page and includes Vite/Tailwind integration with an `@vite` fallback.
- The app has resource stubs for `Message`, `Project`, `Quote`, `Service`, `Testimonial`, and `User` in `app/Models` and `app/Http/Controllers`.
- There is an admin namespace under `app/Http/Controllers/Admin/` with stubbed `AuthController`, `DashboardController`, and `SettingController`.
- Most controllers are empty scaffolds; do not assume complete CRUD or route wiring exists.

## Data model domain
- `database/migrations/2026_04_29_045613_create_projects_table.php` defines a realistic project domain with `title`, `location`, `category`, `status`, `image`, `description`, `is_featured`, and `completion_date`.
- `database/migrations/2026_04_29_045613_create_quotes_table.php` defines a quote/contact workflow with `name`, `phone`, `email`, `service`, `message`, and `status`.
- Other migrations for `services`, `messages`, `testimonials`, and `settings` are mostly empty tables.

## Build and run workflows
- Install PHP dependencies: `composer install`
- Install JavaScript dependencies: `npm install`
- Generate app key / prepare env: copy `.env.example` to `.env` if missing, then `php artisan key:generate`
- Run migrations: `php artisan migrate --force`
- Build assets: `npm run build`
- Local development: `npm run dev` or use `php artisan serve` plus Vite separately.
- Dev script exists in `composer.json` but the simplest local command is `npm run dev`.

## Test workflow
- Run tests with `composer test` or `php artisan test`.
- `phpunit.xml` uses an in-memory SQLite database and sync queue/array session drivers for tests.

## Project-specific guidance
- Keep changes aligned with Laravel conventions; this repo is a standard Laravel project in structure.
- Prefer editing `routes/web.php` only after confirming the intended endpoint exists.
- Add route definitions only when there is a clear UI or admin requirement; the current app has no custom web routes besides `/`.
- If adding CRUD actions, wire them into resource routes rather than inventing new routing patterns.

## Notes for code generation
- Use `resources/css/app.css` and `resources/js/app.js` as the frontend entry points.
- Don’t assume authentication scaffolding is present even though `welcome.blade.php` checks `Route::has('login')` and `Route::has('register')`.
- Favor small, incremental changes because this repository appears to be an initialized starter, not a complete application.

## Files to inspect for architecture
- `routes/web.php` — route definitions and landing page wiring.
- `resources/views/welcome.blade.php` — current user-facing view and Vite/Tailwind integration.
- `composer.json` and `package.json` — dependency, build, and test commands.
- `app/Http/Controllers/` + `app/Http/Controllers/Admin/` — controller scaffolding and expected domain boundaries.
- `database/migrations/` — current schema shape and resource data expectations.

If any section is unclear or missing important details, I can revise this guide with more specific instructions.