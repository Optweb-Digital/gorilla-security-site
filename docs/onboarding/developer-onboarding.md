# Developer Onboarding — Claude-enabled WordPress Workflow

Goal: by the end of Day 2 the developer has shipped one reviewed section to staging using the workflow, unassisted.

## Day 1 — Machine setup (≈ 2 hours, tech lead pairs)

| # | Step | Done when |
|---|---|---|
| 1 | Install Git, Docker Desktop, Node 20 LTS, PHP 8.2 + Composer, gitleaks | `docker run hello-world` works |
| 2 | Install Claude Code; sign in with your **own** seat | `claude` opens and shows your name |
| 3 | Accept GitHub org invite; set up SSH key | `ssh -T git@github.com` greets you |
| 4 | `git clone` → `composer install && npm ci` → `git config core.hooksPath .githooks` | no errors |
| 5 | `npm run env:start` → open http://localhost:8888/wp-admin (admin/password) | theme active, home renders |
| 6 | `npm run env:reset` to load fixtures | stress-test page exists |
| 7 | In repo, run `claude` → `/mcp` → authenticate Figma | Figma server shows connected |
| 8 | In Claude Code run `/context` | CLAUDE.md, AGENTS.md, project-context.md listed under memory |
| 9 | `npm run check` | all five gates run (green or with known failures listed by lead) |
| 10 | Join the claude.ai Project "Gorilla security" | can read design-system-rules.md |

## Day 1 — Read (≈ 1 hour)
1. `AGENTS.md` in full — especially §4 build loop, §6 resilience, §9 boundaries.
2. `docs/project-context.md` and the "Known gaps" in `docs/design-system.md`.
3. `docs/rules-log.md` — every entry is a past mistake you must not repeat.

## Day 1 — Guided section (≈ 2 hours, on screen with lead)
Build the **Stats** row (Figma `1:12`) together with `/build-section 1:12`. Watch for:
- Claude writes the mapping table before code. If it doesn't, stop it — that is a skill/AGENTS gap to log.
- Reuse of `Stats with dividers` style, not a new component.
- Stress fixtures, `npm run check`, PR using the template, review with `/review-pass`.

## Day 2 — Solo section
Pick an assigned section from `docs/sitemap.md` (suggested: FAQ `1:339`). Run the full loop alone. Lead reviews the PR only — not the process. Log time in the measurement sheet.

## Working rules that matter most
- One section = one branch = one PR.
- Ask Claude to plan first (Shift+Tab → plan mode) for anything on the "Ask first" list.
- When you correct Claude, ask it to draft the `docs/rules-log.md` entry immediately.
- Never paste client secrets or production DB contents into any chat.
- If Claude's output is wrong twice in the same way, the fix belongs in AGENTS.md, a skill, or a lint rule — raise it at the daily check-in.

## Daily rhythm (programme weeks)
- 15-min stand-up: yesterday's sections, gate failures, rules-log additions.
- Homework: one section per developer per day, logged in the tracking sheet.
- Day 10: both developers run the workflow end to end without the lead.
