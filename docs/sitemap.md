# Sitemap — Gorilla Security

> Owner: designer. Pages, templates and the patterns each page uses.
> Only the Home page is designed in Figma (frame `1:4`, 1920px). Section order and node ids below
> were checked against `get_metadata` on 2026-10-30; `templates/front-page.html` follows this order.

## Pages

| Page | URL | Template | Status |
|---|---|---|---|
| Home | `/` | `templates/front-page.html` | Designed (Figma `1:4`) |
| Contact us | `/contact-us/` (`#quote` anchor for the quote form) | `page` | Not designed — compose from existing patterns |
| Service pages | TBD | `page-landing` ("Landing (no title)") | Not designed — `split-*`, `services-tabs`, `faq`, `cta-dark` |
| Fixtures stress test | `/fixtures-stress-test/` | `page` | Local/CI only — every pattern with long copy, missing images, empty fields |

## Home — sections

Figma order, top to bottom. "Root" is the group to pass to `get_metadata`; the other ids are the parts
`/build-section` needs. Foundation (tokens, fonts, icons, block styles, placeholders) is done on `feat/foundation`.

| # | Section / pattern | Root node | Parts (Figma ids) | Key components | Status | Assigned |
|---|---|---|---|---|---|---|
| 1 | `header` | 1:523 | glass bar 1:524 · nav 1:525–1:530 · phone button 1:531 (fill 1:532) · Get A Quote 1:542 · logo 1:545 | Glass · light, Button glass phone, `gs-btn-sm` | done locally (`feat/header`) — 2 of 6 Figma links until the other pages exist | TBD |
| 2 | `hero` (+ `quote-card`) | bg 1:69 (+ overlay 1:72) | lead with bar 1:76 · trust strip 1:515 (licence 1:517, partners 1:519/1:521, warranty 1:520) · review badge 1:114 with review source 1:161 · quote card 1:97 · social rail 1:83 · scroll cue 1:73 | Display heading, Lead with bar, Trust strip, Review badge, Glass · dark form | done locally (`feat/hero`) — CF7 form live; social URLs and partner logos pending | TBD |
| 3 | `about` | 1:6 | eyebrow 1:24 · heading 1:9 · stats 1:12 · feature card 1:28 (rows 1:29/1:36/1:41) · photos 1:68 / 1:67 | Eyebrow, Stats with dividers, Card · tint, Feature row | done locally (`feat/about`) — Know More → `#services` until its target is decided | TBD |
| 4 | `brands` | 1:508 | title panel 1:511 · marquee 1:510 (10 logos, repeated) | Marquee | done locally (`feat/brands`) — logo placeholders until partner files are approved | TBD |
| 5 | `why-us` | 1:522 (instance) | stepper track I1:522;1:4087 / active I1:522;1:4088 · dividers I1:522;1:4081… · images I1:522;1:4091–1:4101 | Stepper | done locally (`feat/why-us`) — copy for steps 02–06 pending | TBD |
| 6 | `services-tabs` | 1:162 | panels 1:615–1:1078 · services arrows 1:607 · checklist 1:565 · float card 1:1051. **Panel layers are in reverse order to the tab bar** — map by tab label, not layer order | Tabs, Checklist, Float card, Round arrows | done locally (`feat/services`) — "Know More" waits for service pages | TBD |
| 7 | `quote-split` (+ `contact-card`) | 1:169 | photo 1:170 · wash 1:171 · form 1:172 · contact card 1:199 | `gs-form`, contact card | done locally (`feat/quote-split`) — contact card shows once phone/hours are confirmed; dropdown options pending | TBD |
| 8 | `split-intro` | 1:220 | deco 1:221/1:222 · image 1:237 | Deco frame · right | done locally (`feat/splits`) — Know More → `#services` | TBD |
| 9 | `split-image-left` | 1:238 | deco 1:240/1:241 · image 1:252 | Deco frame · left | done locally (`feat/splits`) — "& Locksmith" built as "Gorilla Security" | TBD |
| 10 | `split-icon-trio` | 1:253 | deco 1:254/1:255 · icon trio 1:265 · image 1:288 | Deco frame · right, Icon trio | done locally (`feat/splits`) | TBD |
| 11 | `cta-dark` | 1:289 | bg 1:291 + overlay 1:292 · model 1:320 · stat cards 1:314 / 1:321 · buttons 1:299 / 1:302 | Glass · violet outline, Button light phone | done locally (`feat/cta-dark`) — phone button shows once the phone number is confirmed | TBD |
| 12 | `testimonials` | 1:407 | slider 1:418 (cards 1:4619…) · **testimonial arrows 1:419** | Slider, Testimonial card, Round arrows | done locally (`feat/testimonials`) — 5 reviews; genuineness and photo rights pending | TBD |
| 13 | `faq` | 1:334 | container 1:342 · open row 1:343 · items 1:339 | FAQ (numbered) | done locally (`feat/faq`) — answers 01, 03–08 are `[[TODO: copy]]` | TBD |
| 14 | `footer` | 1:426 | bg image 1:428 + overlays 1:429 / 1:430 · logo 1:503 · badge 1:507 · services 1:432 · quick links 1:441 · contact list 1:469 · hours 1:485 · social 1:451 | `gs-contact-list`, `gs-hours`, Social links · tint circles | done locally (`feat/footer`) — contact, hours and social show once `gorilla_site()` is filled; Blog/Area links wait for their pages; badge is a placeholder | TBD |

Open content questions that block parts of these sections are tracked in `docs/project-context.md` → Open decisions
(hours conflict: contact card 1:199 "Mon–Sat 8–6" vs footer 1:485 "Mon–Fri 5:30am–7pm / Sat–Sun 5:30am–5pm").

Status values: `not started` · `in progress (branch)` · `in review (PR #)` · `done`.
