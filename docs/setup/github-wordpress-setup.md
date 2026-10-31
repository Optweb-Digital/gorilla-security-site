# GitHub ↔ WordPress Integration — Setup

All config from the original setup kit is now committed as real files (index below). What remains
are the **manual GitHub settings**, which can't live in the repo.

## 1. Repository & branch protection (one-time, tech lead)

1. Create the org repo `gorilla-security-site` (private). Owner: tech lead.
2. Push this repo; default branch `develop`; `main` already exists.
   ```bash
   git remote add origin git@github.com:<org>/gorilla-security-site.git
   git push -u origin develop main
   ```
3. Settings → General → Default branch → `develop`.
4. Settings → Branches → protect `main` and `develop`:
   require PR, 1 approval, status checks `standards`, `security`, `style`, `accessibility`, `performance`; no force-push.
5. Settings → Environments: `staging` (no approval), `production` (required reviewer = tech lead).
6. Secrets (per environment): `SSH_HOST`, `SSH_USER`, `SSH_PORT`, `SSH_PRIVATE_KEY`, `SSH_KNOWN_HOSTS`, `REMOTE_PATH`.
   Repo secret for the Claude action: `ANTHROPIC_API_KEY` (or run `/install-github-app` in Claude Code).

## 2. File index

| Kit § | File | Purpose |
|---|---|---|
| 2 | `.gitignore` | Keep core, uploads, plugins, secrets, dumps out of Git |
| 3 | `.wp-env.json` | Identical Docker WordPress locally and in CI (pin `core` to production's version) |
| 4 | `package.json` (+ `package-lock.json`) | wp-env, lint, a11y, Lighthouse scripts; `npm run check` |
| 5 | `composer.json`, `phpcs.xml.dist`, `phpcs-security.xml.dist` | Gates 1 (Standards) and 2 (Security) |
| 6 | `tests/a11y/.pa11yci.json` | Gate 3 (Accessibility) — add every new template/page URL |
| 6 | `tests/perf/lighthouserc.json` | Gate 4 (Speed) budgets |
| 6 | `.stylelintrc.json` | Gate 5 (Style) — bans hex colours and px font sizes outside `components.css :root` |
| 7 | `.githooks/pre-commit` | Fast local subset of the gates + gitleaks |
| 8 | `.github/workflows/quality.yml` | All five gates on every push/PR |
| 9 | `.github/workflows/deploy.yml` | Code-only rsync deploy; `develop`→staging, `main`→production (approval) |
| 10 | `.github/workflows/claude.yml` | Claude PR review using the `review-pass` skill (needs `ANTHROPIC_API_KEY`) |
| 11 | `.mcp.json`, `.claude/settings.json` | Figma MCP for every dev; Claude Code permissions |
| 12 | `.github/pull_request_template.md` | PR sections required by AGENTS.md §10 |

## Notes
- Deploy is code only (theme + mu-plugins). Database and media are never pushed from Git.
- Managed hosts (WP Engine, Kinsta, Pantheon, SpinupWP, etc.) have their own deploy actions — swap the rsync step; keep everything else.
- The Claude workflow uses API billing plus Actions minutes. It runs the `review` job only; add an `@claude` mention job once the team trusts it.
- Local Docker Lighthouse timings are noisier than hosting — treat CI as the trend line and confirm on staging.

## Known tooling gaps (found 2026-10-30, `feat/stats-row`)

| # | Gap | Status |
|---|---|---|
| 1 | `npm run lint:style` used single-quoted globs. On Windows the quotes reach stylelint literally, so it linted **nothing** and failed with `NoFilesFoundError` (failing for the wrong reason). | Fixed: globs are double-quoted (work in `cmd`, PowerShell and `sh`). Stylelint and ESLint both exit non-zero when a glob matches no files — do not add `--allow-empty-input`. |
| 2 | `npm run env:reset` runs `wp-env clean all`, which resets the DB, and `afterStart` does not run again — the default theme was left active and permalinks were plain. | Fixed: `.wp-env.json` → `lifecycleScripts.afterClean` re-activates `gorilla-security` and sets permalinks. |
| 3 | `tests/perf/lighthouserc.json` uploaded every run (local and CI) to `temporary-public-storage`, publishing a public report URL. | Fixed: `upload.target` is `filesystem` (`.lighthouseci/reports/`, gitignored). Attach the HTML report to the PR when needed. |
| 4 | Pa11y (6.2.3, also tested 8.0.0 and 9.1.1) turns axe **"needs review"** results into errors when their impact is serious. Gradient text (`background-clip: text`) always gets axe `color-contrast` "needs review" with reason `bgGradient` (axe cannot measure text over a gradient), so it fails Gate 3 even when contrast is fine. Upgrading does not change this; Pa11y stays on the current version. | Open, by design: **no `hideElements`/`ignore` for gradient text.** Verify manually (below) and list the ratios in the PR. |
| 6 | Theme patterns are cached by WordPress (development mode off), so a **new** `patterns/*.php` file is not registered until the cache is cleared. | Workaround: `npx wp-env run cli wp eval "wp_get_theme()->delete_pattern_cache();"`. Proposed (needs approval): `"WP_DEVELOPMENT_MODE": "theme"` in `.wp-env.json` config (local only). |
| 5 | ESLint (`@wordpress/scripts` 30) crashes on every Node version (`Failed to load plugin '@typescript-eslint' … reading 'Intrinsic'`). `package-lock.json` resolves **TypeScript 7.0.2** (via `@wordpress/eslint-plugin`'s open `typescript >=5` peer range), which `@typescript-eslint` 6.x does not support. `npm ci` installs the same version in CI, so the JS half of Gate 5 is red everywhere. | Fixed 2026-10-31: `package.json` → `"overrides": { "typescript": "~5.9.3" }` (pins the existing transitive package; no new dependency). ESLint now runs and lints `assets/js/`. |
| 7 | Pa11y 6 bundles axe-core **4.2.4**, which throws `Unable to parse color "color(srgb …)"` in current Chrome (how Chrome serialises `color-mix()`), so the `color-contrast` rule silently returns nothing there. Pa11y only works because it drives its own older Chromium. | Open: when Pa11y is upgraded or pointed at system Chrome, confirm `color-contrast` still reports. Cross-check with axe-core 4.14 (`node_modules/axe-core`) — 0 violations on all three URLs. |
| 8 | PHPCS `PrefixAllGlobals` requires prefixes of ≥ 4 characters. With the project prefix `gs` it reports `ShortPrefixPassed` **and then checks no prefix at all** — the sniff has never enforced prefixing here. | Open decision (project-context): rename the prefix (e.g. `gorilla_`) or record an accepted exception. Not excluded from the ruleset (that would hide it). |
| 9 | Contrast pixel sampling with the repo's puppeteer (9.1.1): `captureBeyondViewport: false` is ignored and `clip` is in **document** coordinates. Sampling with viewport coordinates read the wrong area (earlier hand measurements taken that way are void). | Fixed in the method below: clip at `rect + scroll`, sample only the text's own line boxes (`Range.getClientRects()`), and measure gradient text against each gradient stop. |

### Manual contrast check for gradient text (gap 4)
For each gradient: compute WCAG contrast of the solid fallback `color` and of the lightest point along the gradient against the background. Body-size text needs ≥ 4.5:1; large text (≥ 24px, or ≥ 18.66px bold) needs ≥ 3:1.

| Gradient / use | Fallback `color` | Lightest gradient point | Darkest point | Result |
|---|---|---|---|---|
| `brand-text` on white — stat numbers (28–42px, 600) | `brand-500` #870C6B — 9.15:1 | `brand-300` #BE26B9 — 5.04:1 (at 0%) | `brand-800` #370831 — 16.91:1 | Pass (≥ 4.5:1 throughout) |

Text over the hero photo / glass (axe "needs review": `bgGradient`) — measured on the rendered page by hiding the
text and taking the **lightest** background pixel behind each element (worst case), 2026-10-31:

| Element (white unless noted) | 1920 | 1100 | 390 | Needs |
|---|---|---|---|---|
| Hero H1 (display, 400) | 6.53:1 | 10.30:1 | 11.04:1 | 3:1 (large) |
| Hero lead (20px) | 8.73:1 | 7.85:1 | 8.03:1 | 4.5:1 |
| Glass CTA label (interior) | 10.76:1 | 11.64:1 | 10.88:1 | 4.5:1 |
| Form eyebrow / title / labels | ≥ 8.75:1 | ≥ 13.64:1 | ≥ 15.62:1 | 4.5:1 |
| Form intro / note (`on-dark`) | ≥ 8.18:1 | ≥ 8.32:1 | ≥ 10.33:1 | 4.5:1 |
| Submit label (interior, `brand` gradient) | 8.12:1 | — | — | 4.5:1 |

Re-measure whenever the photo, `hero-scrim` or glass tokens change.

**Full audit, 2026-10-31.** Every node axe 4.14 flags as "needs review" on `/`, `/contact-us/` and the stress page,
at 1920 / 1100 / 781 / 390, was measured as above (text hidden, worst background pixel behind the text's own line
boxes, gradient text against each stop). This found and fixed: split-section list text on the soft-section pink
(4.12:1 → `muted`), testimonial text under the photo (paint order, then shade ramp), and the RTL hero (scrim
mirrored; even scrim when the hero stacks). Remaining "below AA" readings are artefacts: the inline `<head>` script
(`:root`) and the 2,000px-tall long-copy H1 that exceeds the capture.


## Pending third-party marks (local layout QA only)

The hero review badge (Google mark) and trust strip (Victoria Police licence, Afterpay, warranty badge,
Hikvision) are **not confirmed for use**, so they are not committed or published. The stress page reads them
from `fixtures/assets/pending/` (gitignored, served by wp-env at `/fixtures/assets/pending/…`).
To recreate them, export from Figma file `eRJbcaKkAEQSHYALSEbjWt` at 2× PNG into that folder:

| File | Figma node |
|---|---|
| `review-source.png` (resize to 96px) | 1:161 |
| `trust-licence.png` | 1:517 |
| `partner-1.png` (Afterpay) | 1:519 |
| `warranty.png` | 1:520 |
| `partner-2.png` (Hikvision) | 1:521 |

When the client confirms the claims and supplies official files, move them to the Media Library and add the
badge / trust strip markup (see the stress page) to the hero.

## Pending content switch (local only)

`.wp-env.json` defines `GS_SHOW_PENDING`. With it, the theme loads `inc/pending-content.php` (Figma business details) and
renders third-party / unconfirmed assets from `fixtures/assets/pending/` (gitignored): brand logos, testimonial photos,
the award badge and the hero review/trust marks. Staging and production never define the constant, so none of it is
published. To recreate the folder, export the files listed above plus the brand logos (children of Figma 1:510), the
testimonial photos (1:4620, 1:4376, 1:4432, 1:4492, 1:4556) and the award badge (1:507).

After adding a new `patterns/*.php` file, clear the WordPress pattern cache (gap 6 above).
