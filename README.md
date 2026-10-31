# Gorilla Security — WordPress Website

Custom WordPress block-theme website for **Gorilla Security & Automation**, built section by section from the

approved Figma design and developed locally in Docker with `@wordpress/env` (wp-env).

## Contents

1. [Project overview](#1-project-overview)

2. [Technologies and tools](#2-technologies-and-tools)

3. [Prerequisites](#3-prerequisites)

4. [Fresh clone and installation](#4-fresh-clone-and-installation)

5. [Docker Desktop and wp-env setup](#5-docker-desktop-and-wp-env-setup)

6. [Start, stop and restart the local environment](#6-start-stop-and-restart-the-local-environment)

7. [Local website and WordPress admin URLs](#7-local-website-and-wordpress-admin-urls)

8. [WordPress theme activation and verification](#8-wordpress-theme-activation-and-verification)

9. [Local content setup and import](#9-local-content-setup-and-import)

10. [Development commands](#10-development-commands)

11. [Linting, accessibility and performance testing](#11-linting-accessibility-and-performance-testing)

12. [Project folder structure](#12-project-folder-structure)

13. [Git workflow: branches, commits and pull requests](#13-git-workflow-branches-commits-and-pull-requests)

14. [Common troubleshooting](#14-common-troubleshooting)

15. [Important project documentation](#15-important-project-documentation)

---

## 1. Project overview

Gorilla Security & Automation installs security and surveillance systems — CCTV, alarms, intercoms, access

control, smart locks and smart home automation — for homes and businesses. The main goals of the website are

quote requests and phone calls (`docs/project-context.md`).

The project contains:

- a **block theme** (`wp-content/themes/gorilla-security`) — presentation only: `theme.json` design tokens,

  block patterns, templates, one component stylesheet and one progressive-enhancement script;

- a **must-use plugin** (`wp-content/mu-plugins/gs-core`) — the data layer;

- **demo content** (`fixtures/content.xml`) for local development and automated tests;

- **quality gates** (coding standards, security, style, accessibility and performance) that run locally and in CI.

Before writing code, read [`AGENTS.md`](AGENTS.md), [`docs/project-context.md`](docs/project-context.md) and

[`docs/rules-log.md`](docs/rules-log.md). Claude Code users also load [`CLAUDE.md`](CLAUDE.md).

---

## 2. Technologies and tools

| Area | Details | Source |
|---|---|---|
| CMS | WordPress 7.1.4 | `.wp-env.json` (`core`) |
| PHP in the local container | 8.3 | `.wp-env.json` (`phpVersion`) |
| PHP compatibility target | PHP 7.4 and later | `phpcs.xml.dist` (`testVersion`) |
| Theme | Block theme (Full Site Editing), vanilla JavaScript, no build step | `wp-content/themes/gorilla-security` |
| Plugins installed by wp-env | Contact Form 7, WordPress Importer | `.wp-env.json` (`plugins`) |
| Local environment | Docker Desktop + `@wordpress/env` 10 | `package.json` |
| Node.js | 20 | `.nvmrc` |
| CSS and JS linting | `@wordpress/scripts` 30 (stylelint + ESLint) | `package.json` |
| Accessibility testing | `pa11y-ci` 3 (axe + HTML_CodeSniffer, WCAG 2 AA) | `package.json`, `tests/a11y/.pa11yci.json` |
| Performance testing | Lighthouse CI (`@lhci/cli` 0.14) | `package.json`, `tests/perf/lighthouserc.json` |
| PHP linting | PHP_CodeSniffer with WordPress Coding Standards 3 and PHPCompatibilityWP | `composer.json` |
| CI/CD | GitHub Actions | `.github/workflows/` |

---

## 3. Prerequisites

| Tool | Notes | Check |
|---|---|---|
| Git | Any recent version | `git --version` |
| Docker Desktop | Must be running before you start wp-env | `docker run hello-world` |
| Node.js and npm | Version 20 (`.nvmrc`; CI also uses 20) | `node -v` |
| PHP and Composer | Needed for the PHP linting tools; CI uses PHP 8.2 | `php -v` and `composer --version` |
| gitleaks (optional) | The pre-commit hook runs it only if it is installed | — |

---

## 4. Fresh clone and installation

```bash

git clone https://github.com/Optweb-Digital/gorilla-security-site.git

cd gorilla-security-site

# PHP linting tools (creates vendor/)

composer install

# Node tooling, using the committed package-lock.json (creates node_modules/)

npm ci

# Use the project's Git hooks (pre-commit lint and secret scan)

git config core.hooksPath .githooks

```

WordPress core, uploads, `vendor/` and `node_modules/` are not stored in the repository (see `.gitignore`).

On Windows, run `composer install` with your own local PHP installation so the `vendor/bin` launchers work in

your shell (see [Common troubleshooting](#14-common-troubleshooting)).

---

## 5. Docker Desktop and wp-env setup

1. Install and open **Docker Desktop**, and wait until it reports that it is running.

2. Check Docker works:

   ```bash

   docker run hello-world

   ```

3. Start the environment from the project root (section 6). The first start downloads WordPress and builds the

   containers, so it takes longer than later starts.

The environment is defined in `.wp-env.json`:

| Setting | Value |
|---|---|
| WordPress | 7.1.4 |
| PHP | 8.3 |
| Theme mounted | `./wp-content/themes/gorilla-security` |
| Extra mappings | `wp-content/mu-plugins` and `fixtures` |
| Plugins | Contact Form 7, WordPress Importer |
| Config constants | `WP_DEBUG`, `SCRIPT_DEBUG`, `GS_SHOW_PENDING` (local only — see section 9) |
| After start / after clean | Activates the `gorilla-security` theme and sets the `/%postname%/` permalink structure |

WP-CLI commands run inside the container with:

```bash

npx wp-env run cli wp <command>

```

---

## 6. Start, stop and restart the local environment

| Task | Command |
|---|---|
| Start | `npm run env:start` |
| Stop | `npm run env:stop` |
| Restart | `npm run env:stop`, then `npm run env:start` |
| Reset to demo content (**destructive** — see section 9) | `npm run env:reset` |

---

## 7. Local website and WordPress admin URLs

| | URL |
|---|---|
| Website | http://localhost:8888 |
| WordPress admin | http://localhost:8888/wp-admin |

### Your local WordPress password

wp-env creates a local administrator user named `admin`. No password is documented here. After your first

start, set your own local password:

```bash

npx wp-env run cli wp user update admin --user_pass="your-own-local-password"

```

Use the same command whenever you need to reset it — including after `npm run env:reset`, which recreates the

database. Use a password that is only for your local environment, and never commit or share credentials.

---

## 8. WordPress theme activation and verification

The theme is activated automatically every time the environment starts (the `afterStart` script in

`.wp-env.json`). To verify:

```bash

npx wp-env run cli wp theme list

```

`gorilla-security` should have the status `active`. Then open http://localhost:8888 — the homepage should show

the header, the hero with the quote form, the homepage sections and the footer.

To activate the theme manually:

```bash

npx wp-env run cli wp theme activate gorilla-security

```

---

## 9. Local content setup and import

Demo content is stored in [`fixtures/content.xml`](fixtures/content.xml) (WordPress export format). It contains

the **Contact us** page, the **Fixtures stress test** page used for content-resilience testing, and the two

Contact Form 7 forms used by the theme (**Hero quote** and **Quote split**).

| Situation | Command |
|---|---|
| Import the demo content into your current database | `npx wp-env run cli wp import /var/www/html/fixtures/content.xml --authors=create` |
| Start again from a clean database with demo content | `npm run env:reset` |

> **Warning:** `npm run env:reset` runs `wp-env clean all`, which **deletes all local WordPress content, users

> and settings**, then imports the demo content. Set your local password again afterwards (section 7).

### Unconfirmed client content (local only)

`.wp-env.json` defines `GS_SHOW_PENDING`. It lets the local site show Figma content that the client has not yet

confirmed — business details, the review badge, partner logos, testimonials and the award badge — so layouts can

be checked against the design. The related image files belong in `fixtures/assets/pending/`, which is

git-ignored, so a fresh clone does not include them and those elements are not displayed. Staging and production

never define this constant. Details: `docs/setup/github-wordpress-setup.md` (section "Pending content switch").

---

## 10. Development commands

| Purpose | Command |
|---|---|
| Lint CSS and JavaScript | `npm run lint:style` |
| Auto-fix CSS and JavaScript where possible | `npm run fix:style` |
| PHP coding standards | `composer run lint:php` |
| PHP security checks | `composer run lint:security` |
| Auto-fix PHP formatting | `composer run fix:php` |
| Run all quality gates | `npm run check` |
| Clear the theme pattern cache after adding a **new** pattern file | `npx wp-env run cli wp eval "wp_get_theme()->delete_pattern_cache();"` |

Key theme locations (inside `wp-content/themes/gorilla-security/`):

| Path | Contents |
|---|---|
| `theme.json` | Design tokens: colours, typography, spacing, gradients, shadows |
| `patterns/` | Section patterns (built with helpers from `inc/pattern-helpers.php`) |
| `templates/`, `parts/` | Page templates and the header/footer template parts |
| `assets/css/components.css` | All component styles |
| `assets/js/gorilla.js` | Progressive-enhancement script (tabs, accordions, slider, quote dialog) |
| `functions.php` | Asset loading, block styles and render filters |

---

## 11. Linting, accessibility and performance testing

`npm run check` runs the five quality gates in this order and stops at the first failure:

| # | Gate | Command | Configuration |
|---|---|---|---|
| 1 | PHP standards | `composer run lint:php` | `phpcs.xml.dist` |
| 2 | PHP security | `composer run lint:security` | `phpcs-security.xml.dist` |
| 3 | Style (stylelint + ESLint) | `npm run lint:style` | `.stylelintrc.json` and `@wordpress/scripts` defaults |
| 4 | Accessibility | `npm run test:a11y` | `tests/a11y/.pa11yci.json` |
| 5 | Performance | `npm run test:perf` | `tests/perf/lighthouserc.json` |

- Gates 4 and 5 test the running local site, so start the environment first (section 6).

- Accessibility tests run against http://localhost:8888/, `/contact-us/` and `/fixtures-stress-test/`.

- Lighthouse writes its reports to `.lighthouseci/reports/` (git-ignored).

- The **pre-commit hook** (`.githooks/pre-commit`) checks staged PHP files with both PHPCS rulesets and staged

  CSS files with stylelint, and runs `gitleaks` when it is installed. Accessibility and performance run in CI.

- **CI** (`.github/workflows/quality.yml`) runs all five gates on pull requests and on pushes to `develop` and

  `main`.

- Do not disable or suppress a rule to make a gate pass (`AGENTS.md` section 8). Known tool limitations and

  open decisions are listed in `docs/setup/github-wordpress-setup.md` ("Known tooling gaps") and

  `docs/project-context.md` ("Open decisions").

---

## 12. Project folder structure

```text

gorilla-security-site/

├── AGENTS.md                       House standard for developers and AI agents

├── CLAUDE.md                       Claude Code instructions

├── README.md                       This file

├── composer.json                   PHP linting tools and scripts

├── package.json                    Node tooling and npm scripts

├── .wp-env.json                    Local WordPress environment

├── phpcs.xml.dist                  PHP coding-standards ruleset

├── phpcs-security.xml.dist         PHP security ruleset

├── .stylelintrc.json               CSS lint rules

├── .githooks/pre-commit            Local pre-commit checks

├── .github/

│   ├── workflows/                  quality.yml, deploy.yml, claude.yml

│   └── pull_request_template.md

├── .claude/skills/                 build-section, review-pass, scaffold-content, sync-tokens

├── docs/                           Project context, design system, sitemap, rules log, copy, setup, onboarding

├── documents/                      Training notes (Windows setup, Docker, Git and GitHub Desktop)

├── fixtures/

│   └── content.xml                 Demo content (assets/pending/ is local only and git-ignored)

├── tests/

│   ├── a11y/.pa11yci.json          Accessibility test configuration

│   └── perf/lighthouserc.json      Performance test configuration

└── wp-content/

    ├── themes/gorilla-security/    Block theme

    │   ├── theme.json  functions.php  style.css

    │   ├── inc/                    Pattern helpers, local pending content

    │   ├── patterns/  parts/  templates/

    │   └── assets/                 css, js, fonts, icons, images

    └── mu-plugins/

        ├── gs-core-loader.php

        └── gs-core/                Data layer (custom post types, meta, integrations)

```

---

## 13. Git workflow: branches, commits and pull requests

These rules come from `AGENTS.md` (sections 9 and 10).

**Branches**

| Branch | Purpose |
|---|---|
| `main` | Production — protected |
| `develop` | Staging — protected |
| `feat/{section}` | A new section or feature |
| `fix/{issue-id}-{slug}` | A bug fix |
| `chore/{slug}` | Maintenance |
| `docs/{slug}` | Documentation |

- Never push directly to `main` or `develop`, and never force-push shared branches.

- Keep each branch and pull request to one section or one concern.

**Commits**

- Use Conventional Commits, for example: `feat(hero): build hero section from Figma 1:69`.

- Never commit secrets, `.env` files, database dumps, `wp-config.php` or `uploads/`.

**Example flow**

```bash

git checkout develop

git pull

git checkout -b feat/faq

# build and test the change, then:

npm run check

git add <changed files>

git commit -m "feat(faq): build FAQ accordion from Figma 1:334"

git push -u origin feat/faq

```

**Pull requests**

Open the pull request against `develop` and complete the template in `.github/pull_request_template.md`:

- what changed, and the Figma node(s);

- tokens, styles and patterns reused and added;

- screenshots at 1920 px and 390 px;

- the `npm run check` output;

- confirmation that the content-resilience cases in `AGENTS.md` section 6 pass;

- a `docs/rules-log.md` entry if the pull request fixes a defect.

Merging needs a pull request, green CI and one review.

**Deployment**

`.github/workflows/deploy.yml` deploys code only (the theme and mu-plugins) — to staging on pushes to `develop`

and to production on pushes to `main`, using the `staging` and `production` GitHub environments. Database and

media are never deployed from Git. Do not run commands against staging or production yourself.

---

## 14. Common troubleshooting

| Problem | Solution |
|---|---|
| `npm run env:start` fails | Check Docker Desktop is running (`docker run hello-world`), then start again. |
| The site shows a default theme | `npx wp-env run cli wp theme activate gorilla-security` |
| Pages such as `/contact-us/` return "Not found" | `npx wp-env run cli wp rewrite structure /%postname%/ --hard` |
| A newly added pattern file does not appear | `npx wp-env run cli wp eval "wp_get_theme()->delete_pattern_cache();"` |
| You cannot log in to WordPress admin | Set a new local password: `npx wp-env run cli wp user update admin --user_pass="your-own-local-password"` |
| Windows: `'phpcs' is not recognized` when running `composer run lint:php` | `vendor/` was installed by a non-Windows PHP (for example a Docker Composer image), so the Windows launchers are missing. Run `composer install` again with your local Windows PHP. Meanwhile you can run `php vendor/bin/phpcs --standard=phpcs.xml.dist`. |
| Git Bash changes `/var/www/html/...` into `C:/Program Files/Git/var/www/html/...` | Prefix the command with `MSYS_NO_PATHCONV=1`, for example `MSYS_NO_PATHCONV=1 npx wp-env run cli wp import /var/www/html/fixtures/content.xml --authors=create`, or run it in PowerShell. |
| ESLint fails with `Failed to load plugin '@typescript-eslint'` | An unsupported TypeScript version is installed. `package.json` pins it with `"overrides": { "typescript": "~5.9.3" }`; reinstall with `npm ci` so the locked version is used. |
| `npm run check` stops after one gate | It stops at the first failing gate. Run the gates one at a time (section 11) to see every result. |
| Lighthouse results vary between runs | Local Docker timings are noisier than hosting; treat CI as the trend line and confirm on staging. |
| Partner logos, testimonials or contact details are missing locally | Expected on a fresh clone — they depend on the git-ignored `fixtures/assets/pending/` folder (section 9). |

---

## 15. Important project documentation

| Document | Contents |
|---|---|
| [AGENTS.md](AGENTS.md) | House standard: build loop, coding, accessibility and performance rules, boundaries, Git conventions |
| [CLAUDE.md](CLAUDE.md) | Claude Code instructions |
| [docs/project-context.md](docs/project-context.md) | Client facts, code identifiers, environments and open decisions |
| [docs/design-system.md](docs/design-system.md) | Figma-to-token map, components, patterns and build notes |
| [docs/sitemap.md](docs/sitemap.md) | Pages, templates and the sections each page uses |
| [docs/rules-log.md](docs/rules-log.md) | Binding rules learned from past defects |
| [docs/copy/](docs/copy/) | Page copy and content awaiting client or content-writer confirmation |
| [docs/setup/github-wordpress-setup.md](docs/setup/github-wordpress-setup.md) | Repository and CI setup, known tooling gaps, pending-content switch |
| [docs/onboarding/developer-onboarding.md](docs/onboarding/developer-onboarding.md) | Developer onboarding plan |
| [documents/](documents/) | Training notes: Windows prerequisites, Docker setup, GitHub Desktop and Git concepts |
