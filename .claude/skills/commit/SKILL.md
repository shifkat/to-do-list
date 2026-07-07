---
name: commit
description: Write a commit message following the Conventional Commits pattern and create the commit. Use when the user asks to commit changes or wants a commit message written.
---

# Conventional Commit

Create a git commit whose message follows the [Conventional Commits](https://www.conventionalcommits.org) specification.

## Steps

1. Inspect what is being committed:
   - `git status` — see staged/unstaged files
   - `git diff --staged` (and `git diff` if nothing is staged) — understand the actual change
   - `git log --oneline -10` — match the repo's existing message style
2. If nothing is staged, stage the files relevant to the change being described (never `git add -A` blindly — leave unrelated files out).
3. Compose the message using the format below.
4. Commit. Do not push unless the user asks.

## Message format

```
<type>(<scope>): <subject>

[optional body]

[optional footer(s)]
```

### Type (required)

Pick the one that best describes the change:

| Type       | Use for                                              |
| ---------- | ---------------------------------------------------- |
| `feat`     | A new feature                                        |
| `fix`      | A bug fix                                            |
| `refactor` | Code change that neither fixes a bug nor adds a feature |
| `perf`     | Performance improvement                              |
| `style`    | Formatting only (whitespace, Pint, etc.), no logic change |
| `test`     | Adding or correcting tests                           |
| `docs`     | Documentation only                                   |
| `build`    | Build system or dependencies (composer, npm, vite)   |
| `chore`    | Maintenance that touches no src/test code            |
| `ci`       | CI configuration                                     |

### Scope (optional)

A noun in parentheses naming the area touched, e.g. `feat(tasks): ...`,
`fix(feedback): ...`. Omit it when the change is broad or a scope adds nothing.

### Subject (required)

- Imperative mood, present tense: "add", not "added" or "adds"
- Lowercase first letter, no trailing period
- ≤ 72 characters for the whole first line
- Describes **what** the change does, not how

### Body (optional)

Add only when the subject alone can't explain **why** the change was made or
what its impact is. Wrap at 72 characters. Separate from the subject with a
blank line.

### Breaking changes

Append `!` after the type/scope (`feat(tasks)!: ...`) **and** add a footer:

```
BREAKING CHANGE: description of what breaks and how to migrate
```

## Examples

```
feat(tasks): add due date to task creation form
```

```
fix(feedback): re-open modal when validation fails

The modal closed on submit before the server responded, so users
never saw validation errors for empty messages.
```

```
refactor(tasks)!: scope task queries to authenticated user

BREAKING CHANGE: tasks now require a user_id; run the new migration
before deploying.
```

## Rules

- One logical change per commit — if the diff mixes unrelated changes, tell
  the user and suggest splitting rather than writing a vague message.
- Never invent a type outside the table above.
- The commit message must describe the diff, not the conversation.
