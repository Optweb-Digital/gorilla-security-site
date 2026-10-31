# Sitemap — Gorilla Security

> Owner: designer. Pages, templates and the patterns each page uses.
> Only the Home page is designed in Figma (frame `1:4`, 1920px). Section order below follows the
> pattern list in `docs/design-system.md`; confirm exact order with `get_metadata` on `1:4`
> before assembling `templates/front-page.html`.

## Pages

| Page | URL | Template | Status |
|---|---|---|---|
| Home | `/` | `templates/front-page.html` | Designed (Figma `1:4`) |
| Contact us | `/contact-us/` (`#quote` anchor for the quote form) | `page` | Not designed — compose from existing patterns |
| Service pages | TBD | `page-landing` ("Landing (no title)") | Not designed — `split-*`, `services-tabs`, `faq`, `cta-dark` |
| Fixtures stress test | `/fixtures-stress-test/` | `page` | Local/CI only — every pattern with long copy, missing images, empty fields |

## Home — sections

| # | Section / pattern | Figma node(s) | Key components | Status | Assigned |
|---|---|---|---|---|---|
| 1 | `header` (pattern, via parts/header.html) | 1:523 (logo 1:545) | Glass bar, core/navigation (overlay < 1100px), Glass · phone + fill buttons | built (feat/stats-row, uncommitted) — Blog/Area links omitted until pages exist | TBD |
| 2 | `hero` | 1:69 (overlay 1:70; cut-out 1:72 not used) — contains quote form 1:97, trust strip 1:515, review badge 1:114, social bar 1:83, scroll cue 1:73 | Display H1, Lead with bar, button **Glass**, `quote-card`; badge / trust strip / social bar styled but **not output until claims & URLs are confirmed** | built | TBD |
| 3 | `stats` (component, **inside about 1:6**) | 1:12 | Columns **Stats with dividers** | built — **onboarding guided section** | TBD |
| 4 | `quote-card` (component, **inside hero**; reusable on Contact) | 1:97 | Glass · dark + `gs-form gs-form--dark`, CF7 form "Hero quote" | built | TBD |
| 5 | `about` (contains `stats`) | 1:6 (images 1:68 / 1:67, features 1:28–1:48, buttons 42:11497) | Eyebrow, Card · tint, Feature row, Stats | built | TBD |
| 6 | `brands` | 1:508 / marquee 1:510 | Marquee (pause button, reduced motion) — logos pending confirmation, local-only | built (pending logos) | TBD |
| 7 | `why-us` | 1:522 (images 1:4091–1:4101) | Stepper (APG accordion buttons) — step 06 description missing | built | TBD |
| 8 | `services-tabs` | 1:162 (6 tabs; panels 1:550–1:984) | Tabs (WAI-ARIA), Checklist, Float card | built | TBD |
| 9 | `quote-split` (contains `contact-card`) | 1:169 / 1:172 / 1:170 | Light `gs-form`, CF7 "Quote split" | built | TBD |
| 10 | `contact-card` (inside quote-split) | 1:199 | Glass card — phone/hours pending confirmation | built (pending details) | TBD |
| 11 | `split-intro` / `split-image-left` / `split-icon-trio` | 1:220 / 1:238 / 1:253 | `gs_split()` helper, Deco frame, Icon trio | built | TBD |
| 12 | `cta-dark` | 1:289 (model 1:320, stats 1:314 / 1:321) | Glass stat cards, Light · phone button | built | TBD |
| 13 | `testimonials` | 1:407 / 1:418 | Slider (scroll-snap + arrows) — reviews pending confirmation, local-only | built (pending reviews) | TBD |
| 14 | `faq` | 1:334 / 1:339 | core/details style FAQ (numbered) — 7 answers [[TODO: copy]] | built | TBD |
| 15 | `footer` (pattern, via parts/footer.html) | 1:426 | Link lists, contact list + hours (pending), badge (pending) — social links omitted (no URLs) | built | TBD |

Status values: `not started` · `in progress (branch)` · `in review (PR #)` · `done`.
