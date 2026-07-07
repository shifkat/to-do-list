# Contributing

## Conventions

- Follow standard Laravel conventions: route-model binding, `$fillable` for mass
  assignment, `$casts` for types, resource-style controller method names.
- Keep controllers thin; validate in the controller (or a Form Request as the
  app grows).
- All state-changing forms use `@csrf` and method spoofing (`@method`).
- Style views with Tailwind utility classes. Load assets via `@vite` and run
  `npm run build` (or `npm run dev`) after changing markup so classes compile.
- Format PHP with Pint before committing:

    ```bash
    ./vendor/bin/pint
    ```

## Ground rules

!!! danger "Keep it offline"
    This is an **offline, local-only** project. Do **not** add features that
    depend on the internet, remote APIs, or third-party services.

!!! warning "Keep it standalone"
    This is a self-contained to-do app. Do not add code or references belonging
    to unrelated projects.

## Documentation

These docs are built with [MkDocs](https://www.mkdocs.org/) + the
[Material](https://squidfunk.github.io/mkdocs-material/) theme.

```bash
pip install -r requirements-docs.txt   # one-time
mkdocs serve                           # live preview at http://127.0.0.1:8000
mkdocs build                           # output static site to ./site
```

Edit Markdown in `docs/`; update the `nav:` in `mkdocs.yml` when adding pages.
The built `site/` directory is generated output and is not committed.
