# Gorilla Security — WordPress website

The website for **Gorilla Security & Automation** (CCTV, alarms, intercoms, access control, smart locks
and smart home installs in Melbourne). It is a custom WordPress **block theme**, built to match the
Figma design: [Gorilla Dev — Home](https://www.figma.com/design/eRJbcaKkAEQSHYALSEbjWt/Gorilla-Dev?node-id=1-4).

**Status:** the home page is built and matches Figma at 1920px. It also scales down for laptops
(1280–1536px) and has tablet and phone layouts. A few content items are still waiting on the client
(see [Still to do](#still-to-do-before-launch)).

---

## What's on the home page

Built in this order, top to bottom, exactly as in Figma:

| # | Section | What it does |
|---|---|---|
| 1 | Header | Glass bar over the hero, 6 links, call button, "Get A Quote". Turns into a menu button on tablet and phone. |
| 2 | Hero | Big headline, Google reviews badge, trust logos, and the **"Get a Free Quote"** form. |
| 3 | About | Text, stats (6+, 600+, 1000+), photo, feature card, van photo. |
| 4 | Brands | Scrolling strip of partner logos (pauses on hover, has a pause button). |
| 5 | Why us | Six reasons; click one to see its text and photo. |
| 6 | Our security solutions | Six service tabs with photos, notes and arrows. |
| 7 | Quote form | Second quote form with a photo and a call/hours card. |
| 8–10 | Three "split" sections | Text beside a framed photo. |
| 11 | Dark call-to-action | "Ready for Smarter Security" with phone button. |
| 12 | Testimonials | Review cards in a slider. |
| 13 | FAQ | Eight questions that open and close. |
| 14 | Footer | Links, contact details, opening hours, social icons. |

Forms use **Contact Form 7** (two forms: "Hero quote form" and "Quote split form").

---

## Run it on your computer

You need: **Git**, **Docker Desktop** (running), **Node.js 20+**. PHP and Composer are optional — the
PHP checks can run inside Docker instead.

```bash
npm ci                    # install the tools (first time only)
npm run env:start         # start WordPress in Docker
```

Then open **http://localhost:8888** — the admin is **http://localhost:8888/wp-admin** with
user `admin` and password `password` (local only).

To load the sample content (Contact page, the two quote forms, the stress-test page):

```bash
npm run env:reset
```

Stop it with `npm run env:stop`.

> **Windows tip:** if a `wp-env run … /var/www/...` command says the file doesn't exist, Git Bash is
> changing the path. Put `MSYS_NO_PATHCONV=1` in front of the command.

---

## Where to change things

| You want to change… | Edit this |
|---|---|
| Phone, email, address, opening hours, social links | `gorilla_site()` in `wp-content/themes/gorilla-security/functions.php` |
| Text of a section | The matching file in `wp-content/themes/gorilla-security/patterns/` (e.g. `faq.php`) |
| Order of sections on the home page | `templates/front-page.html` |
| Colours, fonts, spacing | `theme.json` (the design tokens) |
| How things look | `assets/css/components.css` (one file, sections in Figma order) |
| Images and logos | `assets/images/` — a `.webp` with the same name replaces the placeholder `.svg` automatically |
| Quote form fields | WordPress admin → **Contact** → the form |
| Contact Form 7 loading / tweaks | `wp-content/mu-plugins/gs-core/inc/contact-form-7.php` |

Rule of thumb: **the theme is how it looks, the `gs-core` plugin is what the data is.**

---

## Quality checks

Every change must pass these before it is merged (GitHub runs them on every pull request too):

| Check | Command | What it catches |
|---|---|---|
| Stress page coverage | `npm run test:fixtures` | A section missing from the stress-test page |
| PHP standards + security | `composer run lint:php` / `lint:security` | WordPress coding rules, unescaped output |
| CSS + JavaScript style | `npm run lint:style` | Style mistakes, wrong token names |
| Accessibility | `npm run test:a11y` | WCAG 2.2 AA problems (pa11y) |
| Speed | Lighthouse CI | Performance ≥ 0.9, layout shift ≤ 0.1, JavaScript ≤ 50 KB |

`npm run check` runs them all. Current results: 0 accessibility errors, performance 0.90–0.95,
accessibility 1.0, layout shift 0.006, JavaScript 35 KB.

> When running Lighthouse yourself, use `npx lhci collect` and `npx lhci assert` — **don't** run the
> upload step, it publishes the report publicly.

---

## Project layout

```
wp-content/themes/gorilla-security/   the theme (look and layout)
  ├─ patterns/                        one file per section
  ├─ templates/ parts/                page templates, header and footer
  ├─ assets/css, js, images, fonts    styles, small scripts, photos, Poppins font
  └─ theme.json                       colours, fonts, sizes
wp-content/mu-plugins/gs-core/        site plugin (Contact Form 7 setup)
fixtures/content.xml                  sample pages and forms
tests/                                accessibility, speed and coverage checks
docs/                                 design system, sitemap, open decisions, rules log
```

---

## Working with Git

- `main` is the live branch. **Never push to it directly** — open a pull request.
- Work on a branch such as `feat/footer` or `fix/header-logo`.
- Commit messages follow *Conventional Commits*, e.g. `fix(footer): keep hours on one row`.
- With **GitHub Desktop**: pick the branch → **Push origin** → **Create Pull Request** → base `main`.

---

## Still to do before launch

These need answers from the client (full list in [`docs/project-context.md`](docs/project-context.md)):

- **FAQ answers** 01 and 03–08 — not in Figma, shown as `[[TODO: copy]]`.
- **Social media links** — the icons show, but link to `#` for now.
- **Opening hours** — Figma shows two different versions (contact card vs footer).
- **Blog and Area pages** — linked in the menu but not created yet.
- **"Why us" step 06** — Figma repeats the text of step 05.
- **Testimonials** — confirm they are real reviews and the photos can be used.
- **Partner / brand logos** — confirm the client may use these third-party logos.
- **SEO plugin** (Yoast or Rank Math) — adds meta descriptions; raises the SEO score to ~1.0.
- **Claude review on GitHub** — install the Claude GitHub App and add the `ANTHROPIC_API_KEY`
  secret if you want automatic code reviews (the check skips itself until then).

---

## Problems we ran into (and how we fixed them)

Every fix is also written up as a rule in [`docs/rules-log.md`](docs/rules-log.md) so it doesn't
happen again.

### Setting up

| Problem | What was going on | Fix |
|---|---|---|
| The style check crashed before it even started | npm installed TypeScript 7, which the linting tools don't support yet | Pinned TypeScript to 5.9 |
| Lint commands failed on Windows | Windows doesn't understand single quotes in npm scripts | Switched to escaped double quotes |
| The site wouldn't start / showed "not found" | The WordPress download from GitHub failed, and the page links weren't set up | Download WordPress from wordpress.org instead, and refresh the link settings on start |
| "Database update required" screen | WordPress was updated to 7.1.4 | Ran the database update (`wp core update-db`) |
| PHP name check failed | WordPress requires prefixes of 4+ letters; we used `gs` | Renamed everything to `gorilla_` |
| Speed numbers looked worse than reality | Local WordPress loads un-minified debug scripts | Turned off script debugging so we measure what visitors get |

### WordPress quirks

| Problem | What was going on | Fix |
|---|---|---|
| Every heading showed at 18px | WordPress renames sizes like `h3` to `h-3`, so our CSS pointed at names that didn't exist | Use the real names; a lint rule now blocks the wrong ones |
| The hero showed as "invalid block" in the editor | Part of the block was cleaned on its own and broke | Build and clean the whole block in one go |
| The quote form showed as plain text `[contact-form-7 …]` | Shortcodes inside patterns weren't being run | A small filter now runs them |
| The form broke when the dropdown said "[TODO]" | Square brackets confuse Contact Form 7 | Placeholder text without brackets |
| Extra empty gaps inside the forms | WordPress wrapped the form in a `<p>`, which the browser split into empty paragraphs | Remove that wrapper before the page is sent |
| Columns wouldn't stack on tablet | WordPress forces columns side by side above 782px (with `!important`) | One shared rule overrides it, with a comment explaining why |
| The phone menu opened inside the header bar | The header's glass blur effect trapped the full-screen menu | Turn the blur off while the menu is open |

### Matching the design

| Problem | What was going on | Fix |
|---|---|---|
| Lots of small differences from Figma | Sections were checked one measurement at a time | Compared a full Figma render with a full-page screenshot, section by section, until heights matched |
| A pink background faded the wrong way | Figma's exported gradient angle came out mirrored | Check every gradient visually against Figma |
| Page looked wrong on laptops (header buttons wrapping, text too big) | Laptops at 125% Windows scaling show the site at ~1536px wide, but text didn't shrink with the layout | Sizes now scale with the screen like the design (1536px = Figma × 0.8) |
| Missing content (Why us steps, phone, logos) | Some content lived in other Figma variants or had been held back | Took everything that exists in Figma; the rest is listed in *Still to do* |
| Testimonials looked like "fewer than Figma" | Figma shows the same 5 reviews 4 times in a loop | The slider repeats them the same way (screen readers hear each once) |
| Quote card looked blurry, call button too pink | Our glass style added a blur and a solid colour Figma doesn't have | Removed both to match Figma exactly |
| Service tabs had the wrong cards and no lines | The extra cards and connector lines were in other Figma variants | Rebuilt each tab's overlay from its own Figma variant |

### Speed and accessibility

| Problem | What was going on | Fix |
|---|---|---|
| Every image loaded at once | WordPress only lazy-loads images that have sizes; ours didn't | Images now get sizes and lazy loading automatically |
| Logos disappeared | Lazy-loaded logos with no size never appeared | Logos always load straight away |
| Accessibility check failed on all gradient text | The checker can't read gradients and guesses "fail" | Keep a solid fallback colour; contrast is still checked by two other tools |
| "Smarter Security" was hard to read on the dark section | The gradient ended almost black on a dark photo | A lighter gradient for dark sections |
| The page jumped while loading | The font arrived late and pushed the hero down | The font now loads first (layout shift 0.125 → 0.006) |
| Contact Form 7 slowed every page | Its scripts loaded even on pages without a form | They now load only where a form is shown |

### GitHub

| Problem | What was going on | Fix |
|---|---|---|
| The "Claude" check failed on every pull request | The Claude GitHub App isn't installed on the repo | The check now skips itself until it's set up |
| Only one branch (`chore/scaffold`) showed on GitHub | All later work was on local branches | Everything was gathered into `feat/homepage` and opened as one pull request |
| The SEO score sometimes dips to 0.83 locally | Lighthouse occasionally can't download `robots.txt` from the local site | Not a site problem — the file is fine and passes in other runs |

---

## More documentation

| File | What's in it |
|---|---|
| [`AGENTS.md`](AGENTS.md) | Team rules: how sections are built, coding standards, what needs approval |
| [`docs/design-system.md`](docs/design-system.md) | Colours, fonts, components and how they map to Figma |
| [`docs/sitemap.md`](docs/sitemap.md) | Every home section with its Figma node and status |
| [`docs/project-context.md`](docs/project-context.md) | Client details and open questions |
| [`docs/rules-log.md`](docs/rules-log.md) | Every problem we fixed, as a rule for next time |
