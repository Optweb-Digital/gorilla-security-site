# Rules Log

Every defect becomes a rule. Agents treat entries here as binding. Newest first.
Enforcement column: `lint` (tooling catches it) > `skill` (a skill step checks it) > `AGENTS` (prose).
Aim to move every entry toward `lint` over time.

| # | Date | Defect (what went wrong) | Rule (what to do instead) | Enforced by | Promoted to house AGENTS.md? |
|---|---|---|---|---|---|
| 003 | 2026-10-31 | `wp-env start` failed: `.wp-env.json` pinned WordPress 6.8 / PHP 8.2 but installed `contact-form-7.latest-stable.zip`, whose newer release needs WP 7.1 / PHP 8.3 | Pin every plugin in `.wp-env.json` to an explicit version (`{slug}.{version}.zip`, never `latest-stable`), and change WordPress, PHP and plugin versions together | AGENTS (candidate for lint: CI check that rejects `latest-stable` URLs) | no |
| 002 | 2026-10-30 | `npm run lint:style` found no files on Windows: npm runs scripts through `cmd.exe`, which keeps single quotes, so stylelint received the literal glob `'wp-content/**/*.css'` | Quote globs in npm scripts with escaped double quotes (`\"wp-content/**/*.css\"`), never single quotes | AGENTS (candidate for lint: add a Windows runner to `quality.yml`) | no |
| 001 | 2026-10-20 | Example: gradient heading text invisible when gradient fails to load | Gradient text must set a solid `color` fallback before `background-clip:text` | skill: review-pass §6 | no |
