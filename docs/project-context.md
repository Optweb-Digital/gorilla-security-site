# Project Context — Gorilla Security

> The ONLY per-client file agents rely on for facts. Copy this template for each new client.
> Keep it under 80 lines. `TBD` = known-unknown tracked under "Open decisions" — agents must not guess it.

## Client
- Name: Gorilla Security & Automation (use "Gorilla Security" in copy — see design-system.md "Known gaps")
- Business: security & surveillance installation — CCTV, alarms, intercom, access control, locks, smart home
- Primary goal of site: quote requests (`/contact-us/#quote`) and phone calls
- Audience: homeowners and small businesses; service area TBD (see Open decisions)

## Code identifiers
| Key | Value |
|---|---|
| Theme slug (`<THEME_SLUG>`) | `gorilla-security` |
| PHP prefix (`<PREFIX>`) | `gsec` (functions `gsec_*`, hooks `gsec/*`, meta `_gsec_*`) — WPCS needs ≥ 4 chars |
| CSS namespace (`<CSS_NS>`) | `gs` (`.gs-block__el--mod`) |
| Text domain (`<TEXT_DOMAIN>`) | `gorilla-security` |
| mu-plugin | `wp-content/mu-plugins/gsec-core/` |
| Min versions | WP 7.1 · PHP 8.3 (Contact Form 7 requires both; hosting must run PHP 8.3) |

## Sources of truth
- Figma: file `eRJbcaKkAEQSHYALSEbjWt`, page `0:1`, frame `1:4` (Home, 1920px)
  https://www.figma.com/design/eRJbcaKkAEQSHYALSEbjWt/Gorilla-Dev?node-id=1-4
- Design system: `docs/design-system.md` (owner: designer)
- Sitemap: `docs/sitemap.md` (owner: designer)
- Copy: `docs/copy/*.md` (owner: content writer)

## Plugins (approved list — anything else needs approval)
- Forms: Contact Form 7 (patterns ship CF7 shortcode placeholders)
- Import (local/CI only): WordPress Importer — loads `fixtures/content.xml`
- SEO: TBD (Yoast or Rank Math — see Open decisions)
- Caching/image: TBD (depends on hosting — see Open decisions)

## Environments
| Env | URL | Branch | Deploy |
|---|---|---|---|
| Local | http://localhost:8888 | any | `npm run env:start` |
| Staging | TBD | `develop` | GitHub Action on merge |
| Production | TBD | `main` | Manual approval in GitHub Action |

## People
| Role | Name | Owns |
|---|---|---|
| Tech lead / handbook owner | TBD | AGENTS.md, CI, rules-log review |
| Designer | TBD | Figma, design-system.md, sitemap.md |
| Developer 1 | TBD | sections assigned in sitemap.md |
| Developer 2 | TBD | sections assigned in sitemap.md |
| Content writer | TBD | docs/copy, editor population, SEO metadata |

## Project-specific exceptions to AGENTS.md
- Design is desktop-only (1920). Mobile/tablet behaviour is defined in CSS by developers and approved by designer on staging.
- No hover/focus/error states in Figma — use theme defaults in design-system.md §6.
- The starter theme in `wp-content/themes/gorilla-security/` holds tokens and helpers only; sections are built with `/build-section`.

## Open decisions (agents must not guess these)
- [ ] Service area (cities/regions) for audience and local SEO
- [ ] SEO plugin: Yoast or Rank Math
- [ ] Hosting provider, cache and image CDN; SSH/deploy access for staging
- [ ] Staging and production URLs
- [ ] Names for tech lead, designer, developers, content writer
- [ ] CTA target URL confirmed (`/contact-us/#quote`?)
- [ ] Page URLs (no `sitemap.md` yet): header nav uses slugs from its labels — `/about-us/`, `/services/`, `/blog/`, `/area/`, `/contact-us/` (2026-10-31)
- [ ] Copy for "Why us" step 06 (Figma's variant repeats step 05; steps 02–05 come from the 1:522 variants) and FAQ answers 01, 03–08
- [ ] Partner/brand logo files supplied by partners (hero trust strip: Victoria Police licence, Afterpay, warranty badge, Hikvision; Google review mark — labelled placeholders until then). Brands marquee: Axis, HiLook, Uniview, Hikvision, Paradox, Dahua, Aiphone, Hills, Inner Range, Bosch — low-res exports from Figma until official files arrive
- [ ] Social profile URLs (Instagram, Facebook, LinkedIn) — hero social rail stays hidden until set
- [x] Site details for `gsec_site()`: phone, email, address taken from Figma 1:4 (approved 2026-10-31)
- [ ] Opening hours: Figma conflicts — contact card 1:199 "Mon-Sat 8:00 AM-6:00 PM" vs footer 1:485 "Mon to Fri 5:30am–7pm / Sat to Sun 5:30am–5pm"
