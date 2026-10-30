# Rules Log

Every defect becomes a rule. Agents treat entries here as binding. Newest first.
Enforcement column: `lint` (tooling catches it) > `skill` (a skill step checks it) > `AGENTS` (prose).
Aim to move every entry toward `lint` over time.

| # | Date | Defect (what went wrong) | Rule (what to do instead) | Enforced by | Promoted to house AGENTS.md? |
|---|---|---|---|---|---|
| 001 | 2026-10-20 | Example: gradient heading text invisible when gradient fails to load | Gradient text must set a solid `color` fallback before `background-clip:text` | skill: review-pass §6 | no |
