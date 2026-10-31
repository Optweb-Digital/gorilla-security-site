# AGENTS.md — House Standard for Custom WordPress Builds

> Version 1.0 · Owner: the tech lead named in `docs/project-context.md` → People · Applies to every client repository.
> This file is IDENTICAL across all projects. Never put client-specific values here;
> they belong in `docs/project-context.md` and `docs/design-system.md`.
> Every agent (Claude Code, Copilot, Cursor, etc.) and every human reads this first.
>
> **Identifiers in `<angle brackets>`** (`<THEME_SLUG>`, `<PREFIX>`, `<TEXT_DOMAIN>`, `<CSS_NS>`) are
> resolved from the "Code identifiers" table in `docs/project-context.md`. They are references, not
> unfilled placeholders.

Precedence when instructions conflict:
1. A direct instruction from the developer in the current session
2. `docs/project-context.md` (this client's facts and exceptions)
3. `docs/design-system.md` (this client's tokens and components)
4. This file (house defaults)
5. General WordPress / framework conventions

---

## 1. Read before every task

| File | Why |
|---|---|
| `docs/project-context.md` | Client, prefix, text domain, environments, owners, open decisions |
| `docs/design-system.md` | Figma → token map, component library, pattern list |
| `docs/sitemap.md` | Pages, templates, which patterns each page uses |
| `docs/rules-log.md` | Rules added after past defects. These are binding. |

If any of these files is missing or contains `{{placeholders}}`, stop and tell the developer before writing code.
Values marked `TBD` are known-unknowns listed under "Open decisions": do not guess them, but they do not block work that doesn't depend on them.

---

## 2. Commands

```bash
# one-time
composer install && npm ci
git config core.hooksPath .githooks

# local WordPress (Docker, http://localhost:8888, admin/password)
npm run env:start          # wp-env start
npm run env:stop
npm run env:reset          # wipe DB and re-import fixtures

# quality gates (same commands CI runs)
npm run check              # runs all five below
composer run lint:php      # 1 Standards    — PHPCS WordPress-Extra + PHPCompatibilityWP
composer run lint:security # 2 Security     — escaping, nonces, SQL, secrets
npm run test:a11y          # 3 Accessibility — pa11y-ci, WCAG 2.2 AA
npm run test:perf          # 4 Speed        — Lighthouse CI budgets
npm run lint:style         # 5 Style        — stylelint + eslint

# auto-fix what can be fixed
composer run fix:php && npm run fix:style
```

Never claim a task is done without running `npm run check` and reporting the result.

---

## 3. Repository map

```
/
├── AGENTS.md  CLAUDE.md          agent instructions (this file + Claude shim)
├── docs/                         project-context, design-system, sitemap, rules-log, copy/
├── .claude/skills/               build-section, scaffold-content, review-pass, sync-tokens
├── .github/workflows/            quality.yml, deploy.yml, claude.yml
├── wp-content/
│   ├── themes/<THEME_SLUG>/      block theme — presentation only
│   └── mu-plugins/<PREFIX>-core/ CPTs, meta, block bindings, integrations — data only
├── tests/a11y/ tests/perf/       pa11y + Lighthouse config
└── fixtures/                     demo content (WXR) incl. long-copy & empty-field cases
```

WordPress core, uploads and third-party plugins are NOT committed.

Separation rule: **theme = how it looks, mu-plugin = what the data is.** A custom post type,
taxonomy, meta field or shortcode never lives in the theme.

---

## 4. The build loop (one section at a time)

1. **Locate** — find the Figma node in `docs/design-system.md` / `docs/sitemap.md`.
   Run `get_metadata`, then `get_design_context` and `get_screenshot` for that node only.
2. **Map** — list every color, size, spacing, radius, shadow and map each to an existing token.
   Values within ~2px or near-identical tints use the existing token. Missing token → add it to
   `theme.json` first, in its own commit.
3. **Reuse** — pick existing block styles, component classes and patterns. Only create a new
   pattern if no combination of existing ones works. Say which you reused.
4. **Build** — core blocks + block styles + pattern PHP. Translate Figma/Tailwind output;
   never paste Tailwind classes or absolute positioning.
5. **Stress** — render with `fixtures/` long-copy, missing-image and empty-field content.
6. **Verify** — compare to `get_screenshot` at 1920px and at 390px; run `npm run check`.
7. **Commit** — one section per PR, message per §10, screenshots attached.

Use `/build-section` for this loop. Do not skip steps 5 and 6.

---

## 5. Coding standards

### PHP
- WordPress Coding Standards (WordPress-Extra). PHP ≥ 7.4 compatible.
- Prefix every function, class, constant, hook, option, meta key and handle with `<PREFIX>_`.
- Text domain `<TEXT_DOMAIN>` on every user-facing string; wrap with `__()`, `esc_html__()`, etc.
- **Escape late, at output:** `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post` — never echo raw.
- **Sanitize early, at input:** `sanitize_text_field`, `absint`, `sanitize_email`, etc.
- Every form/AJAX/REST handler: nonce check + `current_user_can()` + sanitize.
- Database: `$wpdb->prepare()` for any variable SQL. Prefer WP_Query / meta APIs.
- Enqueue assets with `wp_enqueue_*` and `filemtime()` versioning; no hard-coded `<script>`/`<link>`.
- No `extract()`, no `eval()`, no `@` error suppression, no direct file includes from user input.

### Block theme
- `theme.json` first → block styles (`.is-style-*`) → component classes (`.<CSS_NS>-block__el--mod`).
- No inline hex, px font sizes or magic spacing in blocks or patterns; use presets/tokens.
- No `!important` except to override core block inline styles (comment why).
- Patterns use the helper functions in `inc/pattern-helpers.php` so atoms serialize identically.
- Patterns must be valid block markup: open the pattern in the editor, no "invalid block" warnings.

### CSS / JS
- One component CSS file, sections ordered as in Figma. Breakpoints only from `docs/design-system.md`.
- Vanilla JS, no jQuery, no build step unless the project context says otherwise.
- JS is progressive enhancement: content and links work with JS disabled.
- Respect `prefers-reduced-motion`. No animation on content needed to understand the page.

---

## 6. Content resilience (every section must survive)

| Case | Required behaviour |
|---|---|
| Copy 2–3× longer than Figma | Wraps cleanly, no overflow, no clipped text, buttons grow in height |
| Very short copy / single word | Layout holds, no collapsed columns |
| Missing image | Section still renders; no broken-image icon; decorative frames hide |
| Empty optional field | Its wrapper and spacing are not output at all |
| Long unbroken word / URL / email | `overflow-wrap: anywhere` where text is user-supplied |
| 1 item vs. many items (cards, slides, FAQs) | Grid/slider works with 1, 3 and 12 items |
| Translated / RTL text | No layout built on fixed text width; logical CSS properties |

Fixtures for each case live in `fixtures/`. A section is not done until it passes all rows.

---

## 7. Accessibility, SEO, performance

- WCAG 2.2 AA. One `<h1>` per page; heading levels never skip.
- Every interactive element is keyboard-reachable with a visible focus ring (token, not browser default removed).
- Images: meaningful `alt` or `alt=""` if decorative. Icons via CSS mask carry no text meaning;
  icon-only buttons have `aria-label`.
- Tabs, sliders, accordions follow WAI-ARIA Authoring Practices (or use `<details>`).
- Colour contrast ≥ 4.5:1 body, ≥ 3:1 large text/UI. Gradient text needs a solid fallback colour.
- SEO: semantic landmarks, descriptive link text (no "click here"), one canonical per page,
  structured data via the SEO plugin named in project context — do not hand-roll.
- Performance budgets (mobile, Lighthouse): Performance ≥ 90, LCP ≤ 2.5s, CLS ≤ 0.1,
  total JS ≤ 50 KB, no render-blocking third-party scripts. Images have width/height; below-the-fold
  images `loading="lazy"`; the LCP image is not lazy.

---

## 8. Quality gates

The five gates in §2 run on pre-commit (fast subset) and in CI on every push/PR (all five).
A red gate blocks merge. Never disable a rule inline (`phpcs:ignore`, `stylelint-disable`)
without a comment explaining why AND a note in the PR description.

---

## 9. Boundaries

**Always**
- Work on a feature branch. Keep PRs to one section or one concern.
- State which tokens, styles and patterns you reused and which you added.
- Report the output of `npm run check`.

**Ask first**
- Adding a dependency (composer, npm, or a WordPress plugin).
- Adding a new token, breakpoint, block style or pattern not in the design system.
- Changing `theme.json` structure, templates, or anything in `mu-plugins/`.
- Any change touching more than ~5 files or more than one section.

**Never**
- Commit secrets, `.env`, database dumps, `wp-config.php` or `uploads/`.
- Push to `main` or `develop` directly; force-push shared branches.
- Run commands against staging or production (`wp` CLI over SSH, deploys) — CI does that.
- Invent copy, prices, phone numbers, certifications or legal text. Use `[[TODO: copy]]`.
- Use page builders, Tailwind, or absolute positioning copied from Figma output.

---

## 10. Git conventions

- Branches: `feat/{section}`, `fix/{issue-id}-{slug}`, `chore/{slug}`, `docs/{slug}`.
- Commits: Conventional Commits — `feat(hero): build hero section from Figma 1:69`.
- PR template sections: What · Figma node · Tokens/patterns reused · Tokens/patterns added ·
  Screenshots (1920 + 390) · `npm run check` output · Rules-log entry (if a defect was fixed).
- `main` = production, `develop` = staging. Both protected; PR + green CI + 1 review to merge.

---

## 11. Definition of done (a section)

- [ ] Matches Figma at 1920px; sensible at 1100 / 781 / 390px
- [ ] All values come from tokens; no new hard-coded values
- [ ] Passes every row of §6 using fixtures
- [ ] Keyboard and screen-reader checked; heading order correct
- [ ] All five gates green locally and in CI
- [ ] Editable by the content writer in the block editor without touching code
- [ ] PR follows §10 template

---

## 12. Improvement loop

Every defect found in review, QA or by the client becomes a written rule — never only a verbal correction.
1. Fix the defect.
2. Add an entry to `docs/rules-log.md`: date · defect · rule · where enforced (lint rule, skill, or this file).
3. If the rule is house-wide, open a PR against the house template repo to update this file.
4. Prefer enforcement by tooling (lint rule, CI check) over prose. Prose is the fallback.

Keep this file under 300 lines. If it grows past that, move detail into a skill or `docs/`.
