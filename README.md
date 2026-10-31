# Gorilla Security — WordPress Website

The website for **Gorilla Security & Automation** — they install CCTV, alarms, intercoms, access control,
smart locks and smart home systems for homes and businesses in Melbourne.

It is a custom WordPress theme built to look exactly like the approved Figma design:
**[Gorilla Dev — Home page in Figma](https://www.figma.com/design/eRJbcaKkAEQSHYALSEbjWt/Gorilla-Dev?node-id=1-4)**

> **Status:** the home page is finished. It matches Figma on a 1920px screen, scales down for laptops,
> and has tablet and phone layouts. A few content items are still waiting on the client —
> see [Still to do](#12-still-to-do-before-launch).

---

## Contents

1. [The project in 30 seconds](#1-the-project-in-30-seconds)
2. [What's on the home page](#2-whats-on-the-home-page)
3. [What you need installed](#3-what-you-need-installed)
4. [First-time setup](#4-first-time-setup)
5. [Start and stop the website](#5-start-and-stop-the-website)
6. [Add the sample content](#6-add-the-sample-content)
7. [Where to change things](#7-where-to-change-things)
8. [Checking your work](#8-checking-your-work)
9. [Folder map](#9-folder-map)
10. [Saving and sharing your work (Git)](#10-saving-and-sharing-your-work-git)
11. [Something's not working?](#11-somethings-not-working)
12. [Still to do before launch](#12-still-to-do-before-launch)
13. [Problems we faced and how we fixed them](#13-problems-we-faced-and-how-we-fixed-them)
14. [Other useful documents](#14-other-useful-documents)

---

## 1. The project in 30 seconds

- **WordPress runs on your own computer inside Docker** — nothing to install on a server.
- **The design lives in a WordPress theme** called `gorilla-security`. Each section of the page is
  its own small file, so you can change one section without touching the others.
- **The quote forms use Contact Form 7** (a free WordPress plugin).
- **Automatic checks** test code quality, security, accessibility and speed every time you push.

| Part | What it is |
|---|---|
| WordPress | 7.1.4 |
| PHP | 8.3 inside Docker (code also works on PHP 7.4+) |
| Theme | Block theme — no page builder, no build step |
| Plugins | Contact Form 7, WordPress Importer |
| Local server | Docker Desktop + `@wordpress/env` |
| Node.js | 20 |
| Checks | PHP CodeSniffer, stylelint + ESLint, pa11y (accessibility), Lighthouse (speed) |

---

## 2. What's on the home page

Top to bottom, in the same order as Figma:

| # | Section | What visitors see |
|---|---|---|
| 1 | **Header** | Logo, 6 menu links, call button, "Get A Quote". Becomes a menu button on tablet and phone. |
| 2 | **Hero** | Big headline, Google reviews badge, trust logos and the **"Get a Free Quote"** form. |
| 3 | **About** | Text, numbers (6+, 600+, 1000+), photo, feature card, van photo. |
| 4 | **Brands** | Moving strip of partner logos (pauses on hover). |
| 5 | **Why us** | Six reasons — click one to see its text and photo. |
| 6 | **Our security solutions** | Six service tabs, each with a photo, checklist and notes. |
| 7 | **Quote form** | Second quote form with a call / opening-hours card. |
| 8–10 | **Three photo + text sections** | Text beside a framed photo. |
| 11 | **Dark call-to-action** | "Ready for Smarter Security" with a phone button. |
| 12 | **Testimonials** | Review cards in a slider. |
| 13 | **FAQ** | Eight questions that open and close. |
| 14 | **Footer** | Links, contact details, opening hours, social icons. |

---

## 3. What you need installed

| Tool | Why | How to check it works |
|---|---|---|
| **Git** (or GitHub Desktop) | Download and save the code | `git --version` |
| **Docker Desktop** | Runs WordPress — **must be open** before you start | `docker run hello-world` |
| **Node.js 20** | Runs the start/stop and check commands | `node -v` |
| PHP + Composer *(optional)* | Only for running the PHP checks on your own machine | `php -v`, `composer --version` |

> New to these tools? The [`documents/`](documents/) folder has step-by-step Windows guides for Docker,
> GitHub Desktop and Git basics.

---

## 4. First-time setup

Do this once, after downloading the project.

```bash
git clone https://github.com/Optweb-Digital/gorilla-security-site.git
cd gorilla-security-site

npm ci                                   # installs the tools (creates node_modules/)
composer install                         # optional: PHP check tools (creates vendor/)
git config core.hooksPath .githooks      # turns on the automatic check before each commit
```

WordPress itself, `node_modules/`, `vendor/` and uploads are **not** stored in Git — they're created on
your computer.

---

## 5. Start and stop the website

1. Open **Docker Desktop** and wait until it says it's running.
2. In the project folder, run:

```bash
npm run env:start
```

The first start downloads WordPress, so it takes a few minutes. After that it's quick.

| What | Where |
|---|---|
| Website | **http://localhost:8888** |
| WordPress admin | **http://localhost:8888/wp-admin** |
| Login | user `admin`, password `password` — the standard local default |

> The login above only exists on your computer. If you'd like your own password:
> `npx wp-env run cli wp user update admin --user_pass="your-password"`

| To… | Run |
|---|---|
| Start | `npm run env:start` |
| Stop | `npm run env:stop` |
| Restart | `npm run env:stop` then `npm run env:start` |
| Wipe everything and start fresh with sample content | `npm run env:reset` ⚠️ deletes all local content |

The theme is switched on automatically every time you start, and page links (like `/contact-us/`) are set up for you.

---

## 6. Add the sample content

The file `fixtures/content.xml` holds the sample content:

- the **Contact us** page,
- the **Fixtures stress test** page (every section with extra-long text, for testing),
- the two **quote forms** ("Hero quote form" and "Quote split form").

| Situation | Command |
|---|---|
| Add the sample content to your site | `MSYS_NO_PATHCONV=1 npx wp-env run cli wp import /var/www/html/fixtures/content.xml --authors=create` |
| Start over with a clean site + sample content | `npm run env:reset` |

> On Windows Git Bash, keep the `MSYS_NO_PATHCONV=1` at the front — otherwise Git Bash changes the path
> and the import says the file doesn't exist. In PowerShell you can leave it out.

---

## 7. Where to change things

All theme files are in `wp-content/themes/gorilla-security/`.

| I want to change… | Open this file |
|---|---|
| Phone, email, address, opening hours, social media links | `functions.php` → `gorilla_site()` |
| The text of one section | `patterns/<section>.php` (e.g. `patterns/faq.php`) |
| The order of sections on the home page | `templates/front-page.html` |
| Colours, fonts, sizes, spacing | `theme.json` |
| How something looks | `assets/css/components.css` (sections are in Figma order) |
| Sliders, tabs, menu behaviour | `assets/js/gorilla.js` |
| Photos and logos | `assets/images/` — a `.webp` with the same name automatically replaces the placeholder `.svg` |
| The quote form fields | WordPress admin → **Contact** → choose the form |
| How Contact Form 7 loads | `wp-content/mu-plugins/gs-core/inc/contact-form-7.php` |

> **Added a new section file and it doesn't show up?** Clear the pattern cache:
> `npx wp-env run cli wp cache flush` (and refresh the page).

Simple rule: **the theme controls how it looks; the `gs-core` plugin controls the data.**

---

## 8. Checking your work

Run everything at once (the site must be running):

```bash
npm run check
```

It stops at the first problem. To see each result on its own:

| Check | Command | What it looks for |
|---|---|---|
| 1. Stress page | `npm run test:fixtures` | Every section is on the stress-test page |
| 2. PHP standards | `composer run lint:php` | WordPress coding rules |
| 3. PHP security | `composer run lint:security` | Unsafe output, missing escaping |
| 4. CSS + JavaScript | `npm run lint:style` | Style mistakes (`npm run fix:style` fixes many automatically) |
| 5. Accessibility | `npm run test:a11y` | Problems for people using screen readers, keyboards, etc. |
| 6. Speed | `npx lhci collect --config=tests/perf/lighthouserc.json` then `npx lhci assert --config=tests/perf/lighthouserc.json` | Speed ≥ 90, layout shift ≤ 0.1, JavaScript ≤ 50 KB |

> ⚠️ For speed, use the two `lhci` commands above. `npm run test:perf` also **uploads the report
> publicly**, so avoid it.

**Latest results:** 0 accessibility errors · speed 90–95 · accessibility 100 · layout shift 0.006 · JavaScript 35 KB.

Also automatic:

- **Before each commit**, a hook checks the PHP and CSS files you changed.
- **On every pull request**, GitHub runs all the checks (`.github/workflows/quality.yml`).
- Never switch a rule off just to make a check pass.

---

## 9. Folder map

```
gorilla-security-site/
├── README.md                      ← you are here
├── AGENTS.md                      team rules for building and reviewing
├── .wp-env.json                   local WordPress settings
├── package.json / composer.json   tools and commands
├── docs/                          design system, sitemap, client questions, rules log
├── documents/                     beginner guides: Windows setup, Docker, GitHub Desktop, Git
├── fixtures/content.xml           sample pages and forms
├── tests/                         accessibility, speed and coverage checks
├── .github/workflows/             automatic checks on GitHub
└── wp-content/
    ├── themes/gorilla-security/   ← the website's design
    │   ├── patterns/              one file per section
    │   ├── templates/ parts/      page template, header, footer
    │   ├── assets/                css · js · images · fonts · icons
    │   ├── theme.json             colours, fonts, sizes
    │   └── functions.php          site details and setup
    └── mu-plugins/gs-core/        site plugin (Contact Form 7 setup)
```

---

## 10. Saving and sharing your work (Git)

**The golden rules**

- `main` is the live branch — **never push to it directly.**
- Make a new branch for each change, e.g. `feat/footer` or `fix/header-logo`.
- One section or one fix per branch.
- Never commit passwords, `.env` files, database exports or `uploads/`.

**Commit messages** say what changed, like:
`feat(faq): build FAQ section` · `fix(footer): keep opening hours on one row` · `docs(readme): update setup`

**With GitHub Desktop**

1. **Current branch → New branch** (e.g. `fix/footer-hours`).
2. Make your changes, run `npm run check`.
3. Tick the changed files, write a summary, **Commit**.
4. **Push origin**, then **Create Pull Request** → base `main`.
5. Fill in the pull request template (what changed, Figma section, screenshots at 1920 and 390, check results).
6. Merge once the checks are green and someone has reviewed it.

**With the command line**

```bash
git checkout main && git pull
git checkout -b fix/footer-hours
# make the change, then:
npm run check
git add <files you changed>
git commit -m "fix(footer): keep opening hours on one row"
git push -u origin fix/footer-hours
```

Code is deployed by GitHub Actions (`deploy.yml`) — never upload files to the live site by hand.

---

## 11. Something's not working?

| Problem | Fix |
|---|---|
| `npm run env:start` fails | Make sure **Docker Desktop is open**, check with `docker run hello-world`, then try again. |
| The site looks like a plain default theme | `npx wp-env run cli wp theme activate gorilla-security` |
| `/contact-us/` says "Not found" | `npx wp-env run cli wp rewrite flush --hard` |
| "Database update required" screen | Click **Update WordPress Database** — or run `npx wp-env run cli wp core update-db`. Happens after WordPress is updated. |
| Import says the file doesn't exist (`C:/Program Files/Git/var/www/...`) | Git Bash changed the path. Put `MSYS_NO_PATHCONV=1` in front of the command, or use PowerShell. |
| A new section file doesn't appear | `npx wp-env run cli wp cache flush`, then refresh. |
| Can't log in | Reset the password: `npx wp-env run cli wp user update admin --user_pass="your-password"` |
| `'phpcs' is not recognized` on Windows | Run `composer install` with your own PHP, or run the PHP checks through Docker. |
| Style check crashes with `@typescript-eslint` errors | Run `npm ci` so the locked TypeScript 5.9 is installed (TypeScript 7 isn't supported yet). |
| Your changes don't show in the browser | Hard refresh (**Ctrl + F5**) and run `npx wp-env run cli wp cache flush`. |
| Speed score changes between runs | Local Docker is slower and less steady than real hosting. Look at the trend, and confirm on staging. |
| SEO score sometimes 83 locally | Lighthouse occasionally fails to download `robots.txt` from the local site. The file is fine. |
| Social icons link to `#` | Expected — the real links are still to come (see below). |

---

## 12. Still to do before launch

Waiting on the client (full list in [`docs/project-context.md`](docs/project-context.md)):

- [ ] **FAQ answers** 01 and 03–08 — not in Figma yet, showing `[[TODO: copy]]`.
- [ ] **Social media links** — icons are in place, linking to `#` for now.
- [ ] **Opening hours** — Figma shows two different versions (contact card vs footer).
- [ ] **Blog and Area pages** — linked in the menu but not created yet.
- [ ] **"Why us" step 06 text** — Figma repeats the text from step 05.
- [ ] **Testimonials** — confirm they're real reviews and the photos may be used.
- [ ] **Partner and brand logos** — confirm the client may use them.
- [ ] **SEO plugin** (Yoast or Rank Math) — adds page descriptions and raises the SEO score.
- [ ] **Claude review on GitHub** *(optional)* — install the Claude GitHub App and add the
      `ANTHROPIC_API_KEY` secret; until then that check skips itself.

---

## 13. Problems we faced and how we fixed them

Each one is also saved as a rule in [`docs/rules-log.md`](docs/rules-log.md) so it doesn't happen again.

### Getting set up

| What went wrong | Why | How we fixed it |
|---|---|---|
| The style check crashed before it started | npm installed TypeScript 7, which the lint tools don't support yet | Locked TypeScript to version 5.9 |
| Commands failed on Windows | Windows doesn't understand single quotes inside npm commands | Switched to double quotes |
| The site wouldn't start / pages said "Not found" | Downloading WordPress from GitHub failed, and page links weren't set up | Download WordPress from wordpress.org; links are now set up automatically on start |
| "Database update required" | WordPress was upgraded to 7.1.4 | Ran the database update once |
| Import couldn't find the file | Git Bash rewrote `/var/www/...` into a Windows path | Use `MSYS_NO_PATHCONV=1` (or PowerShell) |
| PHP name check failed | WordPress needs code prefixes of 4+ letters; we had `gs` | Renamed to `gorilla_` |
| Speed looked worse than it really was | Local WordPress was sending un-minified debug scripts | Turned debug scripts off, so we measure what visitors get |

### WordPress surprises

| What went wrong | Why | How we fixed it |
|---|---|---|
| Every heading was the same small size | WordPress renames sizes like `h3` to `h-3`, so the CSS pointed at names that didn't exist | Used the real names; a check now blocks the wrong ones |
| The hero said "invalid block" in the editor | Part of the block was cleaned separately and broke | Build and clean the whole block in one go |
| The form showed as text: `[contact-form-7 …]` | Shortcodes inside sections weren't being run | Added a small filter to run them |
| The form broke when a dropdown said "[TODO]" | Square brackets confuse Contact Form 7 | Used placeholder text without brackets |
| Odd empty gaps inside the forms | WordPress wrapped the form in a paragraph, which the browser split into empty ones | Remove that wrapper before the page is sent |
| Columns wouldn't stack on tablets | WordPress forces columns side by side above 782px | One shared rule overrides it, with a note explaining why |
| The phone menu opened inside the header bar | The header's glass blur trapped the full-screen menu | Turn the blur off while the menu is open |

### Making it match Figma

| What went wrong | Why | How we fixed it |
|---|---|---|
| Lots of small differences from the design | Sections were checked one measurement at a time | Compared a full Figma picture with a full-page screenshot, section by section, until the heights matched |
| A pink background faded the wrong way | Figma's exported gradient angle came out mirrored | Check every gradient by eye against Figma |
| On laptops the header buttons wrapped and text looked too big | Laptops with 125% Windows scaling show the site about 1536px wide, but text didn't shrink with the layout | Sizes now shrink with the screen exactly like the design (1536px = Figma × 0.8) |
| Some content was missing (Why us steps, phone, logos) | It was in other Figma variants, or had been held back | Used everything that exists in Figma; the rest is in *Still to do* |
| It looked like there were "more testimonials" in Figma | Figma shows the same 5 reviews 4 times in a loop | The slider repeats them the same way (screen readers hear each once) |
| The quote form looked blurry; the call button too pink | Our glass style added a blur and a solid colour that Figma doesn't have | Removed both |
| Footer hours box stacked on laptops; icon circles looked squashed | The box was too narrow and rows were shorter than the circles | Kept the box on one row on desktop; circles can no longer be clipped |
| Service tabs had the wrong cards and no lines | The extra cards and connector lines were in other Figma variants | Rebuilt each tab from its own Figma variant |
| Social icons were missing | Their links aren't known yet | Show the icons with placeholder `#` links |

### Speed and accessibility

| What went wrong | Why | How we fixed it |
|---|---|---|
| Every image loaded at once | WordPress only lazy-loads images that have sizes; ours didn't | Images now get sizes and lazy loading automatically |
| Logos disappeared | Lazy-loaded logos without a size never appeared | Logos always load straight away |
| The accessibility check failed on all gradient text | The checker can't read gradients and guesses "fail" | Keep a solid backup colour; contrast is still checked by two other tools |
| "Smarter Security" was hard to read on the dark section | The gradient faded to almost black on a dark photo | A lighter gradient for dark sections |
| The page jumped while loading | The font arrived late and pushed the hero down | The font now loads first (layout shift went from 0.125 to 0.006) |
| Contact Form 7 slowed down every page | Its scripts loaded even where there's no form | They now load only on pages that show a form |

### GitHub

| What went wrong | Why | How we fixed it |
|---|---|---|
| The "Claude" check failed on every pull request | The Claude GitHub App isn't installed on the repository | The check now skips itself until it's set up |
| Only `chore/scaffold` showed on GitHub | All later work was on branches that hadn't been pushed | Gathered everything into `feat/homepage` and opened one pull request |
| SEO score sometimes 83 instead of 92 | Lighthouse occasionally can't download `robots.txt` locally | Not a site problem — the file is valid |

---

## 14. Other useful documents

| Document | What's in it |
|---|---|
| [`AGENTS.md`](AGENTS.md) | Team rules: how sections are built, coding standards, what needs approval |
| [`docs/project-context.md`](docs/project-context.md) | Client details and open questions |
| [`docs/design-system.md`](docs/design-system.md) | Colours, fonts, components and how they map to Figma |
| [`docs/sitemap.md`](docs/sitemap.md) | Each home section with its Figma reference and status |
| [`docs/rules-log.md`](docs/rules-log.md) | Every problem we fixed, written as a rule for next time |
| [`documents/`](documents/) | Beginner guides: Windows setup, Docker, GitHub Desktop, Git basics |
