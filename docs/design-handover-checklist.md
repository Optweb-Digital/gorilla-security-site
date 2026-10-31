# Design Handover Checklist — Definition of "ready to build"

The designer ticks every line before a page enters development. Unticked items go to "Open decisions" in project-context.md with an owner and date. Development does not guess.

## File structure
- [ ] One page per site page; frames named `{Page} — {breakpoint}` (e.g. `Home — 1920`)
- [ ] Sections are top-level frames named after the pattern they map to (`hero`, `faq`, …)
- [ ] Auto layout used for every section (no free-floating absolute groups)
- [ ] Layers named meaningfully; no `Group 482`, no numeric export names on icons

## Tokens
- [ ] Colours, type, spacing, radius, shadow defined as Figma **variables/styles**, not raw values
- [ ] Every value used maps to a row in `docs/design-system.md`; new values flagged in a comment
- [ ] Text styles cover every text layer (no detached text)

## Breakpoints & states
- [ ] Desktop 1920 **and** mobile 390 frames for each new section (tablet optional)
- [ ] Hover, focus, active, disabled for buttons, links, tabs, form fields
- [ ] Form validation error + success states
- [ ] Empty/long-content variant for any repeatable component (cards, testimonials)

## Content
- [ ] Real copy, or copy doc reference in `docs/copy/` — no lorem ipsum in "ready" frames
- [ ] Alt-text intent noted for meaningful images
- [ ] CTA destinations specified

## Assets
- [ ] Photos marked for export (2× WebP); logos as SVG
- [ ] Icons from the agreed set (`assets/icons/`), or new icons supplied as 24×24 SVG, 1.8px stroke
- [ ] Third-party logos supplied with permission

## Sign-off
- [ ] Designer: ____ Date: ____  · Tech lead: ____ Date: ____
