# Gorilla Security — Design System Rules (Figma → WordPress)

Rules for anyone (human or agent) turning frames from the **Gorilla Dev** Figma file
(`eRJbcaKkAEQSHYALSEbjWt`, page `0:1`, frame `1:4 Home page`, 1920 × 11129) into this
WordPress block theme via the Figma MCP server.

**Golden rule:** reuse before you create. Every Figma value maps to a token in `theme.json`
and every repeated layer group maps to a block style or pattern listed below. If a design
needs something not listed, add the token / style first, then use it.

---

## 1. Token definitions

| What | Where | Exposed as |
|---|---|---|
| Colors, gradients | `theme.json → settings.color.palette / gradients` | `--wp--preset--color--{slug}`, `--wp--preset--gradient--{slug}` |
| Type scale, font | `theme.json → settings.typography` | `--wp--preset--font-size--{slug}`, `--wp--preset--font-family--poppins` |
| Spacing | `theme.json → settings.spacing.spacingSizes` | `--wp--preset--spacing--{10…90}` |
| Shadows | `theme.json → settings.shadow.presets` | `--wp--preset--shadow--{slug}` |
| Radii, blur, motion, control heights | `theme.json → settings.custom` | `--wp--custom--radius--{xs…pill}`, `--wp--custom--blur--glass`, … |
| Short aliases for CSS | `assets/css/components.css → :root` | `--gs-brand`, `--gs-grad`, `--gs-r-xl` … (alias only, never new values) |

No build step or token transformer: WordPress compiles `theme.json` into CSS custom properties
at runtime. The Figma file defines only one variable (`Colors/Primary HUE/Purple 700 #4A3AFF`)
and it is **not used** in the design — do not import it. All tokens below were extracted from
the layer styles.

### Color map (Figma value → token)

| Figma | Token | Use |
|---|---|---|
| `#870C6B` / `#890D6D` / `#870C6B` borders | `brand-500` | primary: links, active nav, outline buttons, checklist text |
| `#61107A` | `brand-700` | gradient start, arrow buttons, FAQ active |
| `#6D0D60`, `#370831`, `#21031A` | `brand-600`, `brand-800`, `brand-900` | deep plum: brand title gradient, rating badge |
| `#9F0B57` | `brand-400` | gradient end |
| `#BE26B9`, `#BB0EB5` | `brand-300` | eyebrow rule, focus rings, light-button border |
| `#9119B7` | `brand-200` | glass-outline borders (CTA cards, footer hours) |
| `#F0E4ED`, `#EBE2EF` | `brand-100` | icon circles, FAQ open row, stepper track |
| `#F3F1F7` | `brand-50` | feature card background |
| `rgba(13,11,11,.9)` | `ink` (`#252323`) | card titles |
| `rgba(22,22,22,.9)`, `#2D2D2D`, `#2E2E2E` | `heading` (`#2D2D2D`) | headings |
| `rgba(72,72,72,.9)` | `body` (`#5A5A5A`) | body copy |
| `#303030` | `muted` | FAQ questions |
| `#D9D9D9` | `border` | dividers |
| `#F5F5F5` / `#EFEFEF` | `surface` / `surface-2` | tab bar, field borders |
| `#0E0C1B`, `#141A24` | `night`, `night-2` | footer, dark glass |
| `rgba(223,223,223,.9)` | `on-dark` | footer links |

Figma uses `rgba(…, .9)` text colors; they are flattened to solid hex over white. Keep it that way.

### Gradients
`--wp--preset--gradient--{slug}`. Values extracted from Figma 2026-10-30.

| Slug | Use | Figma node | Value |
|---|---|---|---|
| `brand` | fill buttons, active tab | 1:233 (also 1:111, 1:542) | `90deg, #61107A 0%, #6A0D71 39.42%, #6D0D60 67.79%, #9F0B57 100%` |
| `brand-text` | accent words, stat numbers (solid fallback per rules-log 001) | 1:9 | `90deg, rgba(187,14,181,.9) → rgba(26,0,31,.9)` |
| `deco-block` | shapes behind photos | 1:240 | `250.59deg, #930274 6.97%, #A90279 34.28%, #80026F 64.07%, #7F016E 93.03%` |
| `soft-section` | white → lilac wash over quote-split photo | 1:171 | `-70.91deg, transparent 34.85% → #FDF9FF 70.52%` |
| `glass` | glass bar / light glass cards | 1:524 | `180deg, rgba(255,255,255,.2) 2.36% → transparent 118.39%` |
| `night-fade` | footer / dark overlays | 1:429 | `235.5deg, rgba(11,13,22,0) 12.7% → #0E0C1B 53.69%` |
| `photo-shade` | testimonial card photo | 1:4621 | `180deg, rgba(23,21,21,0) 27.07% → #0D0D0D 85.23%` |
| `rule-fade` | stepper dividers | I1:522;1:4081 | `90deg, rgba(135,12,107,.39) → transparent` |

Seen in Figma but **not tokenised** (single use, or pending designer confirmation, so handle in section CSS
via existing tokens or ask first): violet glass on phone button 1:532 (`189.72deg, rgba(121,7,96,.5) → transparent`),
rating badge 1:4626 (`brand-500 → brand-900`, compose from palette), brands-strip side shadow 1:514
(`34px 0 17px rgba(0,0,0,.16)`), stepper active bar I1:522;1:4088 (`#BDBDBD`), dark field 1:101
(fill `rgba(13,18,26,.38)`, border `rgba(255,255,255,.28)`), dark-form eyebrow 1:98 `#990573` (→ `brand-500`).

### Typography
Poppins 400/500/600 only (the single Inter layer in the form note → Poppins). Headings 600,
`letter-spacing: -0.03em` (Figma −1.8px @ 60px). Eyebrows 18px, `+0.13em`.

| Figma px (desktop 1920) | Slug | Fluid min → max |
|---|---|---|
| 121 / 135 | `display` | 46 → 121 |
| 80 / 87 | `h1` | 40 → 80 |
| 70 / 73 | `h2-xl` (service titles) | 38 → 70 |
| 60 / 73 | `h2` (section titles) | 34 → 60 |
| 42 / 57 | `h3` | 28 → 42 |
| 36 | `h4` (form title) | 26 → 36 |
| 32 / 35 | `h5` (glass stat) | 24 → 32 |
| 23 / 35 | `card-title` | 19 → 23 |
| 20 / 35 | `lead` (section copy) | 17 → 20 |
| 18 | `medium` (base body, buttons, nav, eyebrow) | 16 → 18 |
| 16 / 14 / 13 | `base` / `small` / `caption` | fixed |

**CSS variable names are kebab-cased by WordPress:** slug `h3` → `--wp--preset--font-size--h-3`,
`h2-xl` → `--…--h-2-xl`, radius `2xl` → `--wp--custom--radius--2-xl` (class `has-h-3-font-size`). The
pattern helper `gorilla_slug_class()` handles classes; in CSS use the kebab name (lint enforces it, rules-log 005).

Fluid sizes are computed by WP between 390px and 1920px viewports. Never set `px` font sizes
in blocks; pick a slug.

### Spacing, radius, shadow
- Spacing slugs `10…90`: 8, 12, 16, 24, 32, 48, 64, **96 (section padding)**, 128 — all clamp()ed.
- Root side padding: `clamp(16px, 6.9vw, 133px)` (Figma content starts at x=133 on 1920).
- Layout: `contentSize 1080px`, `wideSize 1620px` (Figma content width 162 → 1783).
- Radius: `xs 6` fields · `sm 10` badges/tabs · `md 12` buttons, glass bar · `lg 20` testimonials,
  glass cards · `xl 30` photos, cards · `2xl 37` FAQ container · `pill`.
- Radius 22px on the dark quote card 1:97 → `lg` (within 2px).
- Shadow (`--wp--preset--shadow--{slug}`):

| Slug | Use | Figma node | Value |
|---|---|---|---|
| `soft` | white section panels | 1:7 | `0 4px 13px rgba(0,0,0,.11)` |
| `glass` | glass bar, floating glass | 1:524, 1:532 | `-20px 22px 70px rgba(0,0,0,.25)` |
| `field` | light form fields | 1:179 | `0 1px 14px rgba(0,0,0,.1)` |
| `badge` | review badge | 1:114 | `0 4px 4px rgba(0,0,0,.17)` |
| `glow` | FAQ container | 1:342 | `0 0 33px #DFCFDC` |

- Custom (`--wp--custom--{group}--{key}`): `blur--glass` 35px (1:524) · control heights `control--sm` 48
  (header button 1:542, light field 1:179) · `control--field` 56 (dark field 1:101) · `control--md` 60 (1:233) ·
  `control--lg` 71 (font-size Lead button; not seen in Figma) · `duration--fast/base/slow` 150/200/400ms and
  `easing--standard` `cubic-bezier(.2,0,0,1)` — **house defaults, not from Figma** (the file has no motion).

---

## 2. Component library

Components are **core blocks + block styles + CSS classes + patterns**. No custom React blocks.

| Component | How to use | Figma node |
|---|---|---|
| Button — fill (gradient + arrow) | core/button, default style | `Submit — Request a Quote` (e.g. 1:233) |
| Button — outline | button style **Outline** | 1:558 |
| Button — light phone | style **Light · phone** | 1:302 |
| Button — glass phone | style **Glass · phone** | 1:531 (header; fill 1:532) |
| Button — no icon (submit) | style **Fill · no icon** | 1:111 |
| Button sizes | `gs-btn-sm` (48px) · default (60px) · font size `Lead` (71px) | — |
| Eyebrow | paragraph style **Eyebrow** | 1:24 |
| Accent heading words | select words → **Highlight** (renders `<mark>`) | gradient spans in every H2 |
| Lead with bar | paragraph style **Lead with bar** | 1:76 (hero) |
| Card / Card tint | group styles **Card**, **Card · tint** | 1:28 |
| Glass light / dark / violet outline | group styles **Glass · light / dark / violet outline** | 1:524 (header bar), 1:97, 1:314 |
| Icon circle | group with `gs-icon-circle gs-ico-{name}` (+ `--sm/--md/--dark/--solid`) | ellipses 1:33 etc. |
| Feature row | `gs-feature` group (icon circle + title + text) | 1:29 |
| Stats | columns style **Stats with dividers**, `gs-stat__num` / `gs-stat__label` | 1:12 |
| Checklist | list style **Checklist** | 1:565… |
| Icon trio | group `gs-icon-trio` | 1:265 |
| Deco photo frame | image styles **Deco frame · left / right** (same corners: top-right + bottom-left; name = photo column) | 1:221/1:222, 1:240/1:241, 1:254/1:255 |
| Float card | group `gs-float-card` | 1:1051 |
| Review badge | group `gs-review-badge` | 1:114 |
| Trust strip | group `gs-trust-strip` | 1:515 (hero) |
| Round arrows | `gorilla_arrows()` helper (core/html buttons) | 1:419 (testimonials, 76px) · 1:607 (services) |
| Tabs | `gs-tabs` › `gs-tabs__nav` (buttons, `gs-ico-*`) + `gs-tabs__panel` × n | 1:162 |
| Stepper | `gs-steps` › `gs-steps__media` (images) + `gs-steps__list` › `gs-step` × n | 1:522 |
| Marquee | `gs-marquee` › `gs-marquee__track` | 1:510 |
| Slider | `gs-slider` › arrows + `gs-slider__track` (scroll-snap) | 1:418 |
| Testimonial card | cover `gs-testimonial` + `gs-rating`, `gs-testimonial__*` | 1:4619 |
| FAQ | group `gs-faq` › details style **FAQ (numbered)** | 1:339 |
| Forms | Contact Form 7 in a Shortcode block inside group `gs-form` (light) or `gs-form gs-form--dark`; hidden `<label>` per field + Figma placeholder; `gs-form__row` for side-by-side fields | 1:97, 1:172 |
| Contact card / list / hours | patterns `contact-card`, footer `gs-contact-list`, `gs-hours` | 1:199, 1:469, 1:485 |

### Patterns (`patterns/*.php`, inserter → *Gorilla · Sections / Components*)
`header` · `hero` · `quote-card` · `about` · `brands` · `why-us` · `services-tabs` ·
`quote-split` · `contact-card` · `split-intro` · `split-image-left` · `split-icon-trio` ·
`cta-dark` · `testimonials` · `faq` · `footer`. `templates/front-page.html` assembles the home
page in Figma order. Patterns use helpers from `inc/pattern-helpers.php` (`gorilla_button`,
`gorilla_heading` with `[[accent]]` syntax, `gorilla_eyebrow`, `gorilla_icon`, `gorilla_image`, `gorilla_arrows`) so
every atom serializes identically. Site-wide details (phone, email, address, hours) live in
`gorilla_site()` in `functions.php`.

No Storybook. The browsable reference is the **Gorilla Security Design System** artifact, and
the editor's Patterns panel is the live component catalogue.

---

## 3. Frameworks & libraries

- WordPress **block theme** (FSE), WP ≥ 6.6, PHP ≥ 7.4, `theme.json` v3.
- Styling: theme.json global styles + one plain CSS file (`assets/css/components.css`). No
  Tailwind, no Sass, no bundler, no npm. Figma MCP output is React + Tailwind — **always
  translate it** to blocks + tokens; never paste Tailwind classes or absolute positioning.
- JS: one dependency-free file, `assets/js/gorilla.js` (deferred), progressive enhancement only.
- Forms: any plugin; patterns ship a Contact Form 7 shortcode placeholder.

(npm in the repo root is dev tooling only — linting, wp-env, a11y and Lighthouse. The theme itself ships without a build step.)

---

## 4. Asset management

- Images are **Media Library** content, not theme files. `assets/images/*.svg` are labelled
  placeholders (each shows its Figma node id and size) so patterns render before real photos
  exist. Replace in the editor; `gorilla_img()` will also pick up a `.webp/.jpg/.png` with the same
  name dropped into `assets/images/`.
- Export from Figma at 2× as WebP (photos) or SVG/PNG (logos). Let WordPress generate
  responsive `srcset`; keep photos ≤ 2400px wide, ~200 KB.
- No CDN configured; add one at hosting/plugin level (e.g. image CDN) — no theme changes needed.

| Placeholder | Figma node | Placeholder | Figma node |
|---|---|---|---|
| hero-bg | 1:69 (+1:72 overlay) | service-cctv / -live | 1:987 / 1:1078 |
| about-portrait / about-van | 1:68 / 1:67 | service-alarm / intercom | 1:973 / 1:881 |
| why-1 … why-6 | 1:4101, 1:4099, 1:4097, 1:4095, 1:4093, 1:4091 | service-access / locks / home | 1:799 / 1:707 / 1:615 |
| quote-installer | 1:170 | split-1 / 2 / 3 | 1:237 / 1:252 / 1:288 |
| cta-bg / cta-model | 1:291 (+ overlay 1:292) / 1:320 (transparent PNG) | testimonial-1 … 5 | 1:4620, 1:4376, 1:4432, 1:4492, 1:4556 |
| footer-bg | 1:428 (+ overlays 1:429/1:430, in 1:426) | logo / badge-local | 1:545 / 1:507 |
| trust-licence / partner-1 / warranty / partner-2 | 1:517 / 1:519 / 1:520 / 1:521 | brand-01 … 10 | children of 1:510 |
| review-source | 1:161 (hero review badge) | | |

---

## 5. Icon system

- Location: `assets/icons/*.svg` — 24×24, 1.8px stroke, `currentColor`, kebab-case names
  (`cctv`, `bell`, `intercom`, `access-card`, `lock`, `smart-home`, `shield`, `gear`, `wrench`,
  `phone`, `mail`, `map-pin`, `clock`, `headset`, `check`, `star`, `plus`, `close`,
  `arrow-left/right/down`, `chevron-down`, `lightbulb`, `smartphone`, `laptop`, `building-shield`,
  `chip`, `play`, `pause`).
- Source: Lucide (`lucide-static` 1.65.0, ISC — `assets/icons/LICENSE-lucide.txt`), stroke set to 1.8.
  Renamed from Lucide: `intercom` = monitor-speaker · `access-card` = id-card · `smart-home` = house-wifi ·
  `gear` = settings · `close` = x · `building-shield` = building-2 · `chip` = cpu. Each SVG's first line names its source.
- Icon circle sizes: default 69px (1:33) · `--md` 46px (1:205) · `--sm` 34px (1:471); fill `brand-100`,
  icon `brand-700`. `--dark` (brand-700 fill, white icon) and `--solid` (brand gradient, white icon) for dark/accent areas.
- Use via CSS mask so icons inherit color: add `gs-ico-{name}` to an icon circle or tab button.
  To add an icon: drop the SVG in `assets/icons/`, add one `.gs-ico-{name}` line in
  `components.css`.
- Figma icon layers have numeric export names (e.g. `35807004816285958273805 (1) 1`). Map them
  by meaning to the set above; don't import them as-is.
- Social icons come from the core Social Links block (style **Tint circles**).

---

## 6. Styling approach

- Methodology: **theme.json first, then block styles (`.is-style-*`), then BEM-ish component
  classes (`.gs-block__element--modifier`)**. No inline hex values, no `!important` except
  where overriding core block inline styles.
- Global styles: element styles (headings, links, buttons) in `theme.json → styles`.
- Responsive: fluid type + clamp() spacing do most of the work; columns stack < 782px (WP
  default); component CSS has targeted breakpoints at 1100 / 781 / 600px. Design is desktop-
  only in Figma — mobile behaviour is defined in CSS, check it on real devices.
- Motion: tokens `--wp--custom--duration--*`, `--wp--custom--easing`; all animation disabled
  under `prefers-reduced-motion`.
- Header: transparent glass on `.gs-hero-page` (front page + "Landing (no title)" template),
  solid on scroll and on all other pages.

---

## 7. Project structure

```
gorilla-security/
├── style.css               theme header only
├── theme.json              ALL tokens + global element styles
├── functions.php           enqueue, block-style registry, gorilla_img(), gorilla_site()
├── inc/pattern-helpers.php serializers for repeated atoms
├── assets/css/components.css   component layer (sections ordered as in Figma)
├── assets/js/gorilla.js    tabs, stepper, slider, marquee, header state
├── assets/icons/           SVG icon set
├── assets/images/          labelled placeholders (replace with Media Library images)
├── assets/fonts/           Poppins 400/500/600 latin woff2 (self-hosted, OFL)
├── parts/                  header.html, footer.html → reference patterns
├── patterns/               one file per section/component
└── templates/              front-page, page, page-landing, single, index, 404
```

New page sections = new pattern in `patterns/`, composed from existing styles. New service
pages = **Landing (no title)** template + `split-*`, `services-tabs`, `faq`, `cta-dark` patterns.

---

## Figma → WordPress workflow (MCP)

1. `get_metadata` on the frame → identify which existing pattern/component each group is.
2. `get_design_context` on that node (load the figma-design-to-code skill first).
3. Map every color/size/radius/shadow in the returned code to the tables above. If a value is
   within ~2px or a near-identical tint, use the existing token.
4. Build with core blocks + the listed styles; edit or add a pattern. Do not reproduce Figma's
   absolute positioning; use Columns/Group flex/grid layouts.
5. Export imagery (see §4) and replace placeholders.
6. Verify against `get_screenshot` at 1920 and on mobile.

## Known gaps in the Figma file (decide before launch)

- Only the home page at 1920px is designed — no tablet/mobile frames, hover/focus states, form
  error states or inner pages. Theme defines sensible defaults for all of these.
- "Why us" steps 02–06 and FAQ answers 01, 03–08 have no copy in Figma; patterns use
  `[[TODO: copy]]` until the content writer supplies it (AGENTS.md §9 — no invented copy).
- Opening hours conflict: contact card 1:199 "Mon–Sat 8:00 AM–6:00 PM" vs footer 1:485
  "Mon to Fri 5:30am–7pm / Sat to Sun 5:30am–5pm". `gorilla_site('hours')` stays empty until confirmed.
- Quote forms differ: hero card 1:97 has 5 fields (name, phone, email, service, message); quote-split
  1:172 has 6 (name, email, phone, purpose, requirement, message). Confirm the Contact Form 7 setup.
- Hero 1:83 is a social-links rail and 1:73 a scroll-down cue (identified 2026-10-31). The rail
  renders only once `gorilla_site( 'social' )` URLs are confirmed.
- Quote card eyebrow 1:98 is `#990573` on dark glass (≈1.8:1) — built in `brand-100` for AA. Designer to confirm.
- Services tabs (1:162): the panel layers are stacked in the reverse order of the tab bar — map
  panels by their title, not by layer order.
- Section copy says "Gorilla Security **& Locksmith**" once (1:244) vs "& Automation"
  everywhere else; the pattern uses "Gorilla Security".
- Header "Get A Quote" and other CTAs link to `/contact-us/#quote` — confirm the target.
- Partner/brand logos and the review-source mark are third-party marks: use the files the
  partners supply under their brand guidelines.
