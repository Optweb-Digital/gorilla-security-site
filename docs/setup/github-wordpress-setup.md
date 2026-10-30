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
