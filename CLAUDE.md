@AGENTS.md
@docs/project-context.md
@docs/rules-log.md

## Claude Code specifics

- Load `docs/design-system.md` only when a task touches visual output (it is long).
- Figma MCP: call `get_metadata` first, then `get_design_context` on ONE node at a time.
  Never request the whole 1920 × 11k home frame in one call.
- Use skills for repeated jobs: `/build-section`, `/scaffold-content`, `/review-pass`, `/sync-tokens`.
- Before finishing, run `npm run check` and paste the summary. If a gate fails, fix it or say why you couldn't.
- When the developer corrects you, propose a `docs/rules-log.md` entry in the same reply.
- Use plan mode for anything in the "Ask first" list of AGENTS.md §9.
