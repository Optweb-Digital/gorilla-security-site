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
| 1 | `header` | — (logo 1:545) | nav, Button fill "Get A Quote" | not started | TBD |
| 2 | `hero` | 1:69 (+1:72 overlay) | Display heading, review badge 1:114, Glass · dark form 1:97 | not started | TBD |
| 3 | Stats row (inside hero/about) | 1:12 | Columns **Stats with dividers** | not started — **onboarding guided section** | TBD |
| 4 | `quote-card` | 1:97 | `gs-form gs-form--dark` | not started | TBD |
| 5 | `about` | 1:68 / 1:67, features 1:28–1:33 | Eyebrow 1:24, Lead with bar 1:76, Card, Feature row 1:29 | not started | TBD |
| 6 | `brands` | 1:510 (trust strip 1:515) | Marquee, Trust strip | not started | TBD |
| 7 | `why-us` | 1:522 (images 1:4091–1:4101) | Stepper, Glass · light 1:524 | not started | TBD |
| 8 | `services-tabs` | 1:162 (panels 1:615–1:1078) | Tabs, Checklist 1:565, Float card 1:1051 | not started | TBD |
| 9 | `quote-split` | 1:172 / 1:170 | `gs-form`, review source 1:161 | not started | TBD |
| 10 | `contact-card` | 1:199 | contact card | not started | TBD |
| 11 | `split-intro` / `split-image-left` / `split-icon-trio` | 1:237 / 1:252 / 1:288 (icon trio 1:265, deco 1:240–1:255) | Deco frame, Icon trio | not started | TBD |
| 12 | `cta-dark` | 1:291 / 1:320 | Glass · violet outline 1:314, Button glass phone 1:531, light phone 1:302 | not started | TBD |
| 13 | `testimonials` | 1:418 (cards 1:4619…) | Slider, Testimonial card, Round arrows 1:607 | not started | TBD |
| 14 | `faq` | 1:339 | FAQ (numbered) details — **suggested Day-2 solo section** | not started | TBD |
| 15 | `footer` | 1:428 (contact list 1:469, hours 1:485) | `gs-contact-list`, `gs-hours`, Social Links | not started | TBD |

Status values: `not started` · `in progress (branch)` · `in review (PR #)` · `done`.
