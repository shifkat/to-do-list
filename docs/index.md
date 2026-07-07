# To-Do App

A simple, **offline** to-do list web app built on **Laravel 13**. Add tasks,
mark them complete, delete them, switch between light and dark themes, and send
feedback — all running entirely on your machine.

!!! info "Offline by design"
    This project runs fully locally on SQLite with no external services or
    network calls. It is intended to stay that way — see
    [Contributing](contributing.md) for the ground rules.

## At a glance

- **Backend:** Laravel 13 (PHP 8.3)
- **Database:** SQLite (`database/database.sqlite`)
- **Frontend:** Blade views styled with Tailwind CSS 4, bundled by Vite 8
- **Tests:** PHPUnit 12

## Features

- ✅ Create, list, complete, and delete tasks
- 🌗 Dark / light mode with a header toggle (remembers your choice)
- 💬 In-app feedback form (optional star rating + message)
- ✨ Subtle UI animations

## Where to next

- [Getting Started](getting-started.md) — install and run the app locally
- [Features](features.md) — how each feature works
- [Architecture](architecture.md) — code structure, models, and routes
- [Contributing](contributing.md) — conventions and things to avoid
