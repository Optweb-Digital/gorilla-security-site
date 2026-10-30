# Rules Log

Every defect becomes a rule. Agents treat entries here as binding. Newest first.
Enforcement column: `lint` (tooling catches it) > `skill` (a skill step checks it) > `AGENTS` (prose).
Aim to move every entry toward `lint` over time.

| # | Date | Defect (what went wrong) | Rule (what to do instead) | Enforced by | Promoted to house AGENTS.md? |
|---|---|---|---|---|---|
| 003 | 2026-10-30 | CI style gate crashed before linting: optional peer `typescript >=5` (from `@wordpress/eslint-plugin`) resolved to TypeScript 7, whose JS API breaks `typescript-eslint`; lint globs in single quotes also failed on Windows | Pin TypeScript to 5.x in `devDependencies` until `@wordpress/scripts` supports 7; review major-version bumps in `package-lock.json` diffs; quote globs in npm scripts with escaped double quotes | lint: CI `style` job | no |
| 002 | 2026-10-30 | CI PHPCS failed on the scaffold: 2-char PHP prefix `gs` rejected by WPCS, and a parameter named `$class` (reserved keyword) | PHP prefix must be ≥ 4 chars (`gorilla_*`, `GORILLA_*`, `gorilla/*`); never name variables/params after reserved keywords (`$class`, `$default`, `$list`…) — use e.g. `$extra_class` | lint: PHPCS `WordPress.NamingConventions.PrefixAllGlobals` (prefix in `phpcs.xml.dist`) + `Universal.NamingConventions.NoReservedKeywordParameterNames` | no |
| 001 | 2026-10-20 | Example: gradient heading text invisible when gradient fails to load | Gradient text must set a solid `color` fallback before `background-clip:text` | skill: review-pass §6 | no |
