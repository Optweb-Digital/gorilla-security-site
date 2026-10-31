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
| PHP prefix (`<PREFIX>`) | `gorilla` (functions `gorilla_*`, constants `GORILLA_*`, hooks `gorilla/*`, meta `_gorilla_*`) — WPCS requires ≥ 4 chars |
| CSS namespace (`<CSS_NS>`) | `gs` (`.gs-block__el--mod`) |
| Text domain (`<TEXT_DOMAIN>`) | `gorilla-security` |
| mu-plugin | `wp-content/mu-plugins/gs-core/` |
| Min versions | **WP 7.1 · PHP 8.3** — required by Contact Form 7 6.2 (local/CI pinned to WP 7.1.4, PHP 8.3); theme PHP stays 7.4-compatible |

## Sources of truth
- Figma: file `eRJbcaKkAEQSHYALSEbjWt`, page `0:1`, frame `1:4` (Home, 1920px)
  https://www.figma.com/design/eRJbcaKkAEQSHYALSEbjWt/Gorilla-Dev?node-id=1-4
- Design system: `docs/design-system.md` (owner: designer)
- Sitemap: `docs/sitemap.md` (owner: designer)
- Copy: `docs/copy/*.md` (owner: content writer)

## Plugins (approved list — anything else needs approval)
- Forms: Contact Form 7 6.2.4.1 — forms "Hero quote form" and "Quote split form" ship in `fixtures/content.xml`; patterns find them by title. Mail goes to the site admin email until a recipient is confirmed
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
- [ ] SEO plugin: Yoast or Rank Math (then raise `categories:seo` in `tests/perf/lighthouserc.json` back to 0.95 — lowered to 0.9 because pages have no meta description yet)
- [ ] Hosting provider, cache and image CDN; SSH/deploy access for staging — **host must run PHP 8.3+ and WordPress 7.1+** (CF7)
- [ ] Staging and production URLs
- [ ] Names for tech lead, designer, developers, content writer
- [ ] CTA target URL confirmed (`/contact-us/#quote`?)
- [ ] "Know More" targets (About and the three splits → `#services`; omitted in the service panels until service pages exist) · Figma copy fixes: "livinng" → "living" (1:39), "Intercoms Systems" → "Intercom Systems", "card, PIN biometric" → "card, PIN or biometric" (services)
- [ ] Quote form recipient email; options for the quote-split "purpose" and "requirement" dropdowns (hero "Service" uses the 6 footer services)
- [ ] Copy for "Why us" steps 02–06 and FAQ answers 01, 03–08
- [ ] Partner/brand logo files supplied by partners
- [ ] Site details for `gorilla_site()`: phone, email, address, opening hours
