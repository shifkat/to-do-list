# Architecture

The app follows standard Laravel conventions. Everything outside the files below
is framework scaffolding.

## Request flow

```
Browser ──▶ routes/web.php ──▶ Controller ──▶ Model (Eloquent) ──▶ SQLite
                                   │
                                   └──▶ Blade view (resources/views)
```

State-changing forms post back to a controller action, which redirects to
`tasks.index` and re-renders the page (classic server-rendered flow).

## Custom code

| Path | Responsibility |
| --- | --- |
| `routes/web.php` | Task routes (`tasks.*`) + `feedback.store` |
| `app/Http/Controllers/TaskController.php` | `index`, `store`, `toggle`, `destroy` |
| `app/Http/Controllers/FeedbackController.php` | `store` (validate + save) |
| `app/Models/Task.php` | `title`, `completed` (bool cast) |
| `app/Models/Feedback.php` | `rating` (1–5, nullable), `message` |
| `resources/views/tasks/index.blade.php` | The whole UI + feedback modal |
| `resources/js/app.js` | Theme toggle + modal behavior |
| `resources/css/app.css` | Tailwind entry, dark variant, keyframes |

## Database

SQLite at `database/database.sqlite`. Relevant migrations:

- `*_create_tasks_table.php` — `id`, `title`, `completed`, timestamps
- `*_create_feedback_table.php` — `id`, `rating` (nullable), `message`, timestamps

## Frontend build

Vite bundles `resources/css/app.css` and `resources/js/app.js`. The Blade view
loads them with `@vite(...)`. Tailwind CSS 4 is wired through the
`@tailwindcss/vite` plugin — there is no separate `tailwind.config.js`; theme
and variants are configured inside `app.css`.
