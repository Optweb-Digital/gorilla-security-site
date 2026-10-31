---
name: sync-tokens
description: Pull colour, type, spacing, radius and shadow values from Figma and reconcile them with theme.json without anyone typing values by hand. Use when the designer changes styles/variables or at the start of a project.
---

# Sync design tokens (Figma → theme.json)

1. `get_variable_defs` on the frame. If the file has real variables, they are the source. If not (current Gorilla file has only one unused variable), extract from layer styles via `get_design_context` on representative nodes listed in `docs/design-system.md`.
2. Build a diff table: token slug · current theme.json value · Figma value · action (keep / update / add / flag).
   - Within ~2px or near-identical tint → keep, note the Figma variant in design-system.md color map.
   - Genuinely new → add with a semantic slug (`brand-*`, `surface-*`, not `purple-2`).
   - Removed in Figma but used in code → flag, never delete silently.
3. Apply to `theme.json` only (settings.color.palette, gradients, typography.fontSizes with fluid min/max, spacing.spacingSizes, shadow.presets, custom). `components.css :root` aliases may reference new tokens but never hold raw values.
4. Update the tables in `docs/design-system.md` in the same commit.
5. `npm run env:start`, open the editor, confirm presets appear and nothing visually regresses on the stress page. Run `npm run check`.
6. Commit as `chore(tokens): sync from Figma {date}` — a token commit never contains section code.

Long term: ask the designer to convert styles into Figma variables (collections: color, type, space, radius). Then this skill becomes a straight mapping with no judgement calls.
