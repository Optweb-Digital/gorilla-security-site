# Gorilla Security — WordPress site

Block theme + mu-plugin for Gorilla Security & Automation (CCTV, alarms, intercom, access control,
locks, smart home). Built with a Claude Code workflow: the agent instructions, project context,
design system and skills are all in this repo, so every clone gets the same setup.

## Start here

| Read | What it is |
|---|---|
| [`AGENTS.md`](AGENTS.md) | House standard: build loop, coding rules, gates, boundaries |
| [`CLAUDE.md`](CLAUDE.md) | Claude Code entry point (imports AGENTS, project context, rules log) |
| [`docs/project-context.md`](docs/project-context.md) | Client facts, identifiers, environments, **open decisions** |
| [`docs/design-system.md`](docs/design-system.md) | Figma → token map, components, patterns |
| [`docs/sitemap.md`](docs/sitemap.md) | Pages and home-page sections with Figma nodes |
| [`docs/rules-log.md`](docs/rules-log.md) | Binding rules from past defects |
| [`docs/onboarding/developer-onboarding.md`](docs/onboarding/developer-onboarding.md) | Day 1–2 plan for new developers |
| [`docs/setup/github-wordpress-setup.md`](docs/setup/github-wordpress-setup.md) | GitHub settings, secrets, file index |

Figma: [Gorilla Dev — Home (1:4)](https://www.figma.com/design/eRJbcaKkAEQSHYALSEbjWt/Gorilla-Dev?node-id=1-4)

## Setup

Requires Git, Docker Desktop, Node 20, PHP 8.2 + Composer, and optionally gitleaks.

**First run only (tech lead):** there is no lockfile yet. Run `composer install && npm install`, then
commit `composer.lock` and `package-lock.json` (`chore: add lockfiles`). CI uses `npm ci`, which needs them.

```bash
composer install && npm ci
git config core.hooksPath .githooks
npm run env:start        # http://localhost:8888  (admin / password)
npm run env:reset        # load fixtures (contact-us, fixtures-stress-test)
npm run check            # all five quality gates
```

## Claude Code

```bash
claude
/mcp        # authenticate Figma (each dev uses their own account)
/context    # confirm CLAUDE.md, AGENTS.md, project-context.md, rules-log.md are loaded
```

Suggested first session:

1. `Read AGENTS.md and docs/project-context.md, then list anything missing or contradictory before we build.`
2. `/sync-tokens` — fills gradients and shadows in `theme.json` from Figma. Colours, type, spacing and radii are already in.
3. `/build-section 1:12` — Stats row (onboarding guided section).

## Layout

```
wp-content/themes/gorilla-security/   block theme — presentation only
wp-content/mu-plugins/gs-core/         CPTs, meta, block bindings — data only
docs/                                  context for humans and agents
.claude/skills/                        /build-section /scaffold-content /review-pass /sync-tokens
fixtures/                              WXR demo + stress content
tests/a11y  tests/perf                 pa11y-ci and Lighthouse CI
```

Branches: `develop` → staging, `main` → production. Work on `feat/{section}` branches and open PRs.
