---
name: review-pass
description: Review a branch or PR against AGENTS.md, the design system and the rules log, and report findings by severity. Use before opening a PR, when asked to review, or from the GitHub PR workflow.
---

# Review pass

Review `git diff develop...HEAD` (or the PR diff). Read AGENTS.md, `docs/design-system.md`, `docs/rules-log.md` first.

Check, in this order, and cite file:line for each finding:
1. **Security** — unescaped output, missing nonce/capability/sanitize, raw SQL, secrets, unsafe file ops.
2. **Data/presentation split** — CPTs, meta, shortcodes or business logic in the theme.
3. **Tokens** — hex values, px font sizes, magic spacing, new values not in theme.json.
4. **Reuse** — duplicated pattern markup, new class where a block style exists, helper not used.
5. **Content resilience** — any AGENTS.md §6 row likely to fail (fixed heights, `white-space: nowrap`, wrappers printed when fields are empty).
6. **Accessibility** — heading order, alt text, focus, ARIA on tabs/slider/accordion, contrast on gradient text.
7. **Performance** — new third-party scripts, unsized images, lazy-loaded LCP image, JS weight.
8. **Rules log** — any repeat of a logged defect (call out as BLOCKER).
9. **Conventions** — prefixes, text domain, branch/commit/PR template.

Output:
```
BLOCKER  (must fix before merge)
MAJOR    (fix in this PR unless agreed otherwise)
MINOR    (nice to have)
RULE CANDIDATES (defects that should become a rules-log entry or lint rule)
```
Do not rewrite code in a review pass. Do not approve if any BLOCKER exists.
