# Getting Started

## Requirements

- PHP 8.3+
- Composer
- Node.js + npm

## First-time setup

The `setup` Composer script handles install, environment, database, and asset
build in one step:

```bash
composer setup
```

That runs, in order:

1. `composer install`
2. copies `.env.example` → `.env` (if missing)
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install`
6. `npm run build`

## Running the app

Run the full local stack (server + queue + logs + Vite) with one command:

```bash
composer dev
```

Then open <http://localhost:8000>.

Prefer to run pieces individually:

```bash
php artisan serve   # app only, http://localhost:8000
npm run dev         # Vite dev server (hot reload for assets)
```

## Common commands

| Command | What it does |
| --- | --- |
| `php artisan migrate` | Run database migrations |
| `php artisan test` | Run the PHPUnit test suite |
| `./vendor/bin/pint` | Format PHP (Laravel Pint) |
| `npm run build` | Production asset build |
| `npm run dev` | Vite dev server |

!!! tip "After changing Blade markup"
    Tailwind only compiles classes it can see. Run `npm run build` (or keep
    `npm run dev` running) after editing views so new utility classes appear.
