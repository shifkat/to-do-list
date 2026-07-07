# CLAUDE.md

Guidance for Claude Code when working in this repository.

## Project

A simple **to-do list** web app built on Laravel 13. A single `Task` resource
(create, list, toggle complete, delete) rendered by a server-side Blade view.
Tasks are currently **not** scoped to users — the list is shared/global.

This is an **offline project** — it runs entirely locally (SQLite, no external
services or network calls). Do not add features that depend on remote APIs,
third-party services, or internet connectivity.

## Stack

- **Backend:** Laravel 13 (PHP 8.3)
- **Database:** SQLite (`database/database.sqlite`)
- **Frontend:** Blade views styled with Tailwind CSS 4, built via Vite 8
  (assets loaded with `@vite` in the view)
- **Tests:** PHPUnit 12

## Commands

```bash
composer setup          # first-time: install, .env, key, migrate, npm build
composer dev            # run server + queue + logs + vite concurrently
php artisan serve       # app only, http://localhost:8000
php artisan migrate     # run migrations
php artisan test        # run the test suite
./vendor/bin/pint       # format PHP (Laravel Pint)
npm run dev             # vite dev server
npm run build           # production asset build
```

## Structure

The custom application code (everything else is Laravel scaffolding):

- `routes/web.php` — task routes (`tasks.*`) plus `feedback.store`
- `app/Http/Controllers/TaskController.php` — `index`, `store`, `toggle`, `destroy`
- `app/Http/Controllers/FeedbackController.php` — `store` (rating + message)
- `app/Models/Task.php` — fields: `title`, `completed` (bool cast)
- `app/Models/Feedback.php` — fields: `rating` (1-5, nullable), `message`
- `database/migrations/*_create_tasks_table.php` — tasks schema
- `database/migrations/*_create_feedback_table.php` — feedback schema
- `resources/views/tasks/index.blade.php` — the UI (tasks + feedback modal)
- `resources/js/app.js` — theme toggle + feedback modal behavior

## Features

- **Dark/light mode:** class-based (`.dark` on `<html>`), toggled by the header
  icon, persisted to `localStorage`, with an inline `<head>` script that applies
  the saved theme before paint (no flash). The `dark` variant is enabled in
  `resources/css/app.css` via `@custom-variant`.
- **Feedback:** header icon opens a modal (optional star rating + message) that
  posts to `feedback.store`; success shows a flash banner, validation errors
  re-open the modal.

## Conventions

- Follow standard Laravel conventions: route-model binding, `$fillable` for
  mass assignment, `$casts` for types, resource controller method names.
- Keep controllers thin; validate in the controller (or a Form Request as the
  app grows).
- All state-changing forms use `@csrf` and method spoofing (`@method`).
- Style views with Tailwind utility classes; load assets via `@vite` and run
  `npm run build` (or `npm run dev`) after changing markup so classes compile.
- Format PHP with Pint before committing.

## Don't

- This is a standalone to-do app — keep it entirely separate.
- Don't add features requiring the internet, remote APIs, or third-party
  services — this is an offline, local-only project.

## Notes / gotchas

- The `User` model and users table exist but tasks are **not** linked to users;
  adding auth means adding a `user_id` to tasks and scoping queries.
- No automated tests cover the Task feature yet — only default example stubs.
