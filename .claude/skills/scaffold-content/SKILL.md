---
name: scaffold-content
description: Scaffold structured content (custom post types, taxonomies, meta fields, block bindings) in the gsec-core mu-plugin and populate it from a copy document. Use for services, testimonials, FAQs, team, locations or any repeatable content.
---

# Scaffold content fields

## 1. Decide the model (write it out, get approval)
For each content type: name · fields (type, required/optional, max length) · where it renders (pattern) · who edits it.
Prefer, in order: core blocks in a pattern (one-off content) → post meta + Block Bindings (repeatable structured fields) → CPT (collections like services, testimonials).

## 2. Implement in `wp-content/mu-plugins/gsec-core/` (never the theme)
- One file per type: `inc/cpt-{type}.php`, loaded from `gsec-core.php`.
- `register_post_type` with `show_in_rest => true`, sensible `supports`, `template` locking where layout must not break.
- `register_post_meta` with `type`, `single`, `show_in_rest`, `sanitize_callback`, `auth_callback`.
- Block Bindings source via `register_block_bindings_source` when meta must appear inside theme patterns.
- Prefix everything `gsec_` / `_gsec_`. Escape at output, sanitize at input.

## 3. Populate from copy
- Read `docs/copy/{page}.md`. Map each copy block to a field. Report anything in copy with no field, and any field with no copy.
- Generate a WXR fragment or WP-CLI script under `fixtures/` (e.g. `fixtures/services.sh` using `wp post create` / `wp post meta update`).
- Populate SEO title + meta description per page per the SEO plugin in project context; ≤ 60 / ≤ 155 chars.
- Never invent facts (prices, certifications, phone numbers). Leave `[[TODO]]` and list them.

## 4. Verify
`npm run env:reset` then check every rendering pattern with real content AND the stress fixtures. Run `npm run check`.
Record time taken in the measurement sheet (content population row).
