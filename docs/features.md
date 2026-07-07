# Features

## Tasks

The core of the app is a single `Task` resource.

| Action | Route | Method |
| --- | --- | --- |
| List tasks | `tasks.index` (`/`) | GET |
| Add a task | `tasks.store` (`/tasks`) | POST |
| Toggle complete | `tasks.toggle` (`/tasks/{task}/toggle`) | PATCH |
| Delete a task | `tasks.destroy` (`/tasks/{task}`) | DELETE |

- Tasks are listed newest-first (`Task::latest()`).
- Adding a task validates `title` as `required|string|max:255`.
- Completing a task toggles the boolean `completed` flag; the title gets a
  strikethrough in the UI.

!!! note "Not user-scoped"
    Tasks are **not** linked to a user — the list is shared/global. Adding
    multi-user support means adding a `user_id` and scoping queries.

## Dark / light mode

- Toggled by the **sun/moon icon** in the header.
- Implemented as **class-based** dark mode: a `.dark` class on `<html>`.
- The choice is saved to `localStorage`, and an inline `<head>` script applies
  the saved theme **before paint** so there's no flash on reload. First-time
  visitors fall back to their operating system preference.
- The `dark` variant is enabled in `resources/css/app.css` via
  `@custom-variant`.

The toggle logic lives in `resources/js/app.js`.

## Feedback

- Opened by the **chat icon** in the header, which reveals a modal.
- Fields: an optional **star rating** (1–5) and a required **message**.
- Submits to `feedback.store` (`POST /feedback`).
- On success, a green flash banner thanks the user; on a validation error, the
  modal **re-opens** with the message preserved.
- The modal closes on the ✕ button, Cancel, backdrop click, or the `Escape` key.

Feedback is stored in the `feedback` table (`rating`, `message`). There is no
admin screen to read submissions yet.

## Animations

Small, subtle motion built with Tailwind utilities and custom keyframes in
`resources/css/app.css`:

- The card **pops in** on load.
- Task rows **slide in**, staggered by row.
- Buttons have hover/press transitions; the complete toggle scales on hover.
