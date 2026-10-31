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
`brand` (buttons/active tab) · `brand-text` (accent words, stat numbers — in theme.json: brand-300 → brand-800) · `deco-block` (shapes
behind photos) · `soft-section` (grey→white→pink section bg) · `glass` · `night-fade` (footer) ·
`photo-shade` (testimonial cards) · `rule-fade` (stepper dividers).

**In `theme.json` now:** `brand` (brand-700 → brand-600 68% → brand-400; Figma 4-stop, near-identical
39% stop dropped) · `brand-text` · `glass` (brand-500 50% → transparent, 190°) · `hero-scrim` (night 80% →
65% @45% → 30% @75% → 40%; tuned so hero copy is ≥ 4.5:1 on the photo — replaces Figma 1:70 flat 20%
black; mobile uses an even night 65% in CSS) · `trust-strip` (white → border → white 63%). The others
are added with their sections.
Colour `rating` #F29603 (review stars, Figma 1:123).

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

Fluid sizes are computed by WP between 390px and 1920px viewports. Never set `px` font sizes
in blocks; pick a slug.

### Spacing, radius, shadow
- Spacing slugs `10…90`: 8, 12, 16, 24, 32, 48, 64, **96 (section padding)**, 128 — all clamp()ed.
- Root side padding: `clamp(16px, 6.9vw, 133px)` (Figma content starts at x=133 on 1920).
- Layout: `contentSize 1080px`, `wideSize 1620px` (Figma content width 162 → 1783).
- Radius: `xs 6` fields · `sm 10` badges/tabs · `md 12` buttons, glass bar · `lg 20` testimonials,
  glass cards · `xl 30` photos, cards · `2xl 37` FAQ container · `pill`.
- Shadow: `soft` section · `glass` floating · `field` inputs · `badge` review chip · `glow` FAQ.
  In `theme.json` now: `glass` (-20 22 70 / 25% black), `badge` (0 4 4 / 17% black); others with their sections.
- Custom (in `theme.json`): `blur.glass` 35px · `glass.border` (white 32%) · `glass.field` (night 38%) ·
  `control.field` 56px (form controls) · `duration.fast` 150ms · `easing` ease-out.

---

## 2. Component library

Components are **core blocks + block styles + CSS classes + patterns**. No custom React blocks.

| Component | How to use | Figma node |
|---|---|---|
| Button — fill (gradient + arrow) | core/button, default style | `Submit — Request a Quote` (e.g. 1:233) |
| Button — outline | button style **Outline** | 1:558 |
| Button — light phone | style **Light · phone** | 1:302 |
| Button — glass phone | style **Glass · phone** | 1:531 |
| Button — glass (no icon) | style **Glass** | 1:80 |
| Button — no icon (submit) | style **Fill · no icon** | 1:111 |
| Button sizes | `gs-btn-sm` (48px) · default (60px) · font size `Lead` (71px) | — |
| Eyebrow | paragraph style **Eyebrow** | 1:24 |
| Accent heading words | select words → **Highlight** (renders `<mark>`) | gradient spans in every H2 |
| Lead with bar | paragraph style **Lead with bar** | 1:76 |
| Card / Card tint | group styles **Card**, **Card · tint** | 1:28 |
| Glass light / dark / violet outline | group styles **Glass · light / dark / violet outline** | 1:524, 1:97, 1:314 |
| Icon circle | group with `gs-icon-circle gs-ico-{name}` (+ `--sm/--md/--dark/--solid`) | ellipses 1:33 etc. |
| Feature row | `gs-feature` group (icon circle + title + text) | 1:29 |
| Stats | columns style **Stats with dividers**, `gs-stat__num` / `gs-stat__label` | 1:12 |
| Checklist | list style **Checklist** | 1:565… |
| Icon trio | group `gs-icon-trio` | 1:265 |
| Deco photo frame | image styles **Deco frame · left / right** | 1:240/1:241, 1:254/1:255 |
| Float card | group `gs-float-card` | 1:1051 |
| Review badge | `gs-review-badge` (logo img + `gs-rating` of `gs-ico-star` + text) — not output until the claim is confirmed | 1:114 |
| Social bar (glass) | social-links style **Glass rail** (vertical; horizontal < 782px) — not output until URLs exist | 1:83 |
| Scroll cue | link `gs-scroll-cue gs-ico-arrow-down` (+ `.screen-reader-text` label); hidden < 782px | 1:73 |
| Trust strip | group `gs-trust-strip` with image blocks (4 across, 2×2 < 782px) — not output until claims are confirmed | 1:515 |
| Round arrows | `gs_arrows()` helper (core/html buttons) | 1:607 |
| Tabs | `gs-tabs` › `gs-tabs__nav` (buttons, `gs-ico-*`) + `gs-tabs__panel` × n | 1:162 |
| Stepper | `gs-steps` › `gs-steps__media` (images) + `gs-steps__list` › `gs-step` × n | 1:522 |
| Marquee | `gs-marquee` › `gs-marquee__track` | 1:510 |
| Slider | `gs-slider` › arrows + `gs-slider__track` (scroll-snap) | 1:418 |
| Testimonial card | cover `gs-testimonial` + `gs-rating`, `gs-testimonial__*` | 1:4619 |
| FAQ | group `gs-faq` › details style **FAQ (numbered)** | 1:339 |
| Forms | wrap plugin form in group `gs-form` (light) or `gs-form gs-form--dark` | 1:97, 1:172 |
| Contact card / list / hours | patterns `contact-card`, footer `gs-contact-list`, `gs-hours` | 1:199, 1:469, 1:485 |

### Patterns (`patterns/*.php`, inserter → *Gorilla · Sections / Components*)
**All built:** `header` · `hero` · `quote-card` (CF7 "Hero quote") · `about` (contains `stats`) · `brands` · `why-us` ·
`services-tabs` · `quote-split` (CF7 "Quote split", contains `contact-card`) · `split-intro` · `split-image-left` ·
`split-icon-trio` (all via `gs_split()`) · `cta-dark` · `testimonials` · `faq` · `footer`. The header/footer template
parts reference the `header` / `footer` patterns. Original planned list: · `about` · `brands` · `why-us` · `services-tabs` ·
`quote-split` · `contact-card` · `split-intro` · `split-image-left` · `split-icon-trio` ·
`cta-dark` · `testimonials` · `faq` · `footer` · `stats` (component). `templates/front-page.html` assembles the home
page in Figma order. Patterns use helpers from `inc/pattern-helpers.php` (`gs_button`,
`gs_heading` with `[[accent]]` syntax, `gs_eyebrow`, `gs_icon`, `gs_image`, `gs_arrows`) so
every atom serializes identically. Site-wide details (phone, email, address, hours) live in
`gs_site()` in `functions.php`.

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
  exist. Replace in the editor; `gs_img()` will also pick up a `.webp/.jpg/.png` with the same
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
| cta-bg / cta-model | 1:291 / 1:320 (transparent PNG) | testimonial-1 … 5 | 1:4620, 1:4376, 1:4432, 1:4492, 1:4556 |
| footer-bg | 1:428 | logo / badge-local | 1:545 / 1:507 |
| trust-licence / partner-1 / warranty / partner-2 | 1:517 / 1:519 / 1:520 / 1:521 | brand-01 … 10 | children of 1:510 |
| review-source | 1:161 | | |

---

## 5. Icon system

- Present now: `star` (filled), `arrow-down`. Others are added with the sections that use them.
- Location: `assets/icons/*.svg` — 24×24, 1.8px stroke, `currentColor`, kebab-case names
  (`cctv`, `bell`, `intercom`, `access-card`, `lock`, `smart-home`, `shield`, `gear`, `wrench`,
  `phone`, `mail`, `map-pin`, `clock`, `headset`, `check`, `star`, `plus`, `close`,
  `arrow-left/right`, `chevron-down`, `lightbulb`, `smartphone`, `laptop`, `building-shield`,
  `chip`, `play`).
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
├── functions.php           enqueue, block-style registry, gs_img(), gs_site()
├── inc/pattern-helpers.php serializers for repeated atoms
├── assets/css/components.css   component layer (sections ordered as in Figma)
├── assets/js/gorilla.js    tabs, stepper, slider, marquee, header state
├── assets/icons/           SVG icon set
├── assets/images/          labelled placeholders (replace with Media Library images)
├── assets/fonts/           put poppins-400/500/600.woff2 here (Google Fonts fallback until then)
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

## Pending (unconfirmed) content

`GS_SHOW_PENDING` (defined only in `.wp-env.json`) loads `inc/pending-content.php` (Figma phone, email, address, hours)
and lets `gs_pending_img()` serve third-party files from the gitignored `fixtures/assets/pending/` (brand logos,
review photos, award badge, hero review/trust marks). Without the constant (staging/production) those parts are not
output at all. Elements built from pending content carry `gs-pending` (dashed amber outline, local only).

## Build gotchas (see rules-log)

- Preset/custom slugs with a letter-to-digit boundary are kebab-cased in CSS vars: `h3` → `--wp--preset--font-size--h-3`,
  radius `2xl` → `--wp--custom--radius--2-xl`.
- `wp_kses_post()` re-serialises block comments: pass only **balanced** block markup (patterns collect strings, kses once).
- Icons: `gs-ico-{name}` mask, sized with `--gs-icon-size` (no px font sizes). Icon in a circle = tint `::before` + masked `::after`.
- Images: `gs_image_dimensions()` adds width/height + `loading=lazy` at render; covers other than the hero are lazy;
  the hero gets `fetchpriority=high` and an 800/1200/1676w `srcset`. Sizes come from `gs_image_size()` (transient keyed on
  the image folders' mtimes; overwriting a file in place with new dimensions needs the `gs_img_sizes_*` transient deleted).
- Mobile menu: core overlay from 1100px down (CSS override); without JS the links list inline. The overlay loads core's
  Interactivity API (~29 KB of the 50 KB JS budget).
- RTL: horizontal cover gradients are mirrored (`.wp-block-cover:dir(rtl)`); the hero uses an even scrim once it stacks (≤ 1100px).
- Service tabs: previous/next arrows (`gs_arrows()` with custom labels) switch tabs; hidden without JS.
- Core emoji polyfill is disabled on the front end (`gs_disable_emoji_polyfill()`).
- `gs-pending` is a class-only marker for unconfirmed content (no visual style — rules-log 020).
- Headings: a newline in `gs_heading()` text is the Figma line break (hero "Smarter Security. / Safer Spaces.",
  why-us "Built for Better / Security.").
- Social icons: `gs_social_links( $services, 'gs-social--rail' | 'gs-social--footer' )` — links only from verified
  `gs_site( 'social' )` URLs; locally, non-linked placeholders (`gs-ico-social-*` masks copied from core's icons).
- Quote dialog: every `#quote` link opens the hero quote card in a native `<dialog>` (card moved in and back, one CF7
  instance); two-column field grid inside the dialog, one column ≤ 600px; CF7 status border restyled to tokens.
- Hover intent (desktop mouse only, 180 ms rest, ignores layout shifts): why-us steps and service tabs activate on
  hover as well as click/keyboard; touch never depends on hover.
- Testimonial slider: whole cards only (--gs-per-view 4 / 2 ≤1100px / 1 <600px), one card per step, 3 s autoplay at
  every width with an infinite loop (outermost card moved while snapping is off — no jumps), hidden scrollbar, pauses
  on hover/focus/off-screen/reduced motion. The pause/play button is visually hidden and appears only on keyboard focus
  (design request vs WCAG 2.2.2 — see report). Hidden copies (aria-hidden + inert) only if every card would fit.
- Quote dialog: scrollbar hidden (scrollbar-width / ::-webkit-scrollbar) on the dialog only; still scrolls.
- FAQ: core/details with name="gs-faq" (exclusive accordion) + JS fallback; desktop hover intent opens a question.
- Dark CTA visual: grid card | person | card (≈1 : 2.9 : 1, container units); person fills the column height (top-
  anchored cover, min 3:4); cards below the photo ≤ 600px.
- Hero: heading → description → .gs-hero__actions row (review badge + Get A Quote, 48px high); stacked focal point 64%.
- Header: light glass over the hero (white 8%), night-2 72% once scrolled; logo has a soft light halo (drop-shadow).
- Columns vertical alignment: per column, gs_column_open( $class, 'center' ) (rules-log 021).
- Service tab anchors: `#cctv-systems`, `#alarm-systems`, `#intercom-systems`, `#access-control`, `#smart-locks`,
  `#smart-home` select their tab (on click, load and `hashchange`).

## Hero implementation notes (Figma 1:69)

- Photo: `assets/images/hero-bg.webp` is the original Figma image fill at its native 1676 × 1029 (WebP,
  ~74 KB). Replace with a Media Library image in production so WordPress emits `srcset` (mobile LCP).
- The worker cut-out layer 1:72 is intentionally not used; contrast comes from `hero-scrim`.
- Fonts: Poppins 400/500/600 latin woff2 self-hosted in `assets/fonts/` (SIL OFL, `OFL.txt`).
- Form labels are visible above the fields (Figma shows placeholders only) — accessibility decision.

## Known gaps in the Figma file (decide before launch)

- Only the home page at 1920px is designed — no tablet/mobile frames, hover/focus states, form
  error states or inner pages. Theme defines sensible defaults for all of these.
- "Why us" steps 02–06 and FAQ answers 01, 03–08 have no copy in Figma; patterns contain draft
  copy marked for review.
- Section copy says "Gorilla Security **& Locksmith**" once (1:244) vs "& Automation"
  everywhere else; the pattern uses "Gorilla Security".
- Header "Get A Quote" and other CTAs link to `/contact-us/#quote` — confirm the target.
- Partner/brand logos and the review-source mark are third-party marks: use the files the
  partners supply under their brand guidelines.
