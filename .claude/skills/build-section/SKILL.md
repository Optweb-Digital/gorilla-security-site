---
name: build-section
description: Build one page section from a Figma node into block-theme patterns, styles and tokens, then verify it. Use when asked to build, implement or convert a Figma section.
---

# Build a section

Input: a Figma node id or section name (e.g. `1:339` or "FAQ"). If neither is given, ask.

## 1. Locate
- Find the node in `docs/design-system.md` (component table) and `docs/sitemap.md`.
- Figma MCP: `get_metadata` on the node → `get_screenshot` → `get_design_context`. One node at a time.
- If an existing pattern already covers this node, you are EDITING it, not creating one.

## 2. Map — write this table in your reply before coding
| Figma value | Token / style / class | New? |
|---|---|---|
Rules: within ~2px or near-identical tint → existing token. Anything marked New? = yes → stop and ask (AGENTS.md §9).

## 3. Build
- Pattern file `patterns/{slug}.php` with header (Title, Slug `gorilla-security/{slug}`, Categories, Keywords).
- Use `inc/pattern-helpers.php` helpers (`gsec_heading`, `gsec_button`, `gsec_eyebrow`, `gsec_icon`, `gsec_image`, `gsec_arrows`).
- Layout via Group/Columns flex/grid. No absolute positioning, no Tailwind, no px font sizes.
- Strings translatable with text domain `gorilla-security`. Copy from `docs/copy/`; missing copy → `[[TODO: copy]]`.
- Component CSS appended to `assets/css/components.css` in Figma order, using tokens only.
- JS only if behaviour requires it; add to `assets/js/gorilla.js` as progressive enhancement.

## 4. Stress
Add/refresh the section on the `fixtures-stress-test` page with: long copy (3×), missing image, empty optional fields, 1 and 12 items where repeatable. Check every row of AGENTS.md §6.

## 5. Verify
- Compare against the Figma screenshot at 1920px; check 1100, 781, 390px.
- Keyboard-tab through the section; confirm focus is visible and order is logical.
- Run `npm run check`. Fix failures. Do not disable rules to pass.

## 6. Hand back
Reply with: files changed · mapping table · reused vs added · stress results · check output · suggested commit message (`feat({slug}): … Figma {node}`). Open a branch `feat/{slug}` if not already on one.
