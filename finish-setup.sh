#!/usr/bin/env bash
# finish-setup.sh — run ONCE from this folder:  bash finish-setup.sh
# Creates the files Claude is not allowed to write remotely (.claude/, .github/, .mcp.json),
# initialises Git (develop + main) and makes the first commit. Deletes itself when done.
set -euo pipefail
cd "$(dirname "$0")"
if [ -d .git ]; then echo "A .git folder already exists here — aborting so nothing is overwritten."; exit 1; fi
rm -- "$0"
mkdir -p .claude/skills/build-section .claude/skills/scaffold-content .claude/skills/review-pass .claude/skills/sync-tokens .github/workflows

cat > '.claude/settings.json' <<'GS_EOF'
{
  "permissions": {
    "allow": ["Bash(npm run *)", "Bash(composer run *)", "Bash(npx wp-env *)", "Bash(git status)", "Bash(git diff *)", "Bash(git checkout -b *)", "Bash(git add *)", "Bash(git commit *)"],
    "ask": ["Bash(git push *)", "Bash(npm install *)", "Bash(composer require *)"],
    "deny": ["Read(./.env)", "Read(./**/wp-config.php)", "Bash(git push * main)", "Bash(git push * develop)", "Bash(ssh *)", "Bash(rsync *)"]
  }
}
GS_EOF

cat > '.claude/skills/build-section/SKILL.md' <<'GS_EOF'
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
- Use `inc/pattern-helpers.php` helpers (`gs_heading`, `gs_button`, `gs_eyebrow`, `gs_icon`, `gs_image`, `gs_arrows`).
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
GS_EOF

cat > '.claude/skills/scaffold-content/SKILL.md' <<'GS_EOF'
---
name: scaffold-content
description: Scaffold structured content (custom post types, taxonomies, meta fields, block bindings) in the gs-core mu-plugin and populate it from a copy document. Use for services, testimonials, FAQs, team, locations or any repeatable content.
---

# Scaffold content fields

## 1. Decide the model (write it out, get approval)
For each content type: name · fields (type, required/optional, max length) · where it renders (pattern) · who edits it.
Prefer, in order: core blocks in a pattern (one-off content) → post meta + Block Bindings (repeatable structured fields) → CPT (collections like services, testimonials).

## 2. Implement in `wp-content/mu-plugins/gs-core/` (never the theme)
- One file per type: `inc/cpt-{type}.php`, loaded from `gs-core.php`.
- `register_post_type` with `show_in_rest => true`, sensible `supports`, `template` locking where layout must not break.
- `register_post_meta` with `type`, `single`, `show_in_rest`, `sanitize_callback`, `auth_callback`.
- Block Bindings source via `register_block_bindings_source` when meta must appear inside theme patterns.
- Prefix everything `gs_` / `_gs_`. Escape at output, sanitize at input.

## 3. Populate from copy
- Read `docs/copy/{page}.md`. Map each copy block to a field. Report anything in copy with no field, and any field with no copy.
- Generate a WXR fragment or WP-CLI script under `fixtures/` (e.g. `fixtures/services.sh` using `wp post create` / `wp post meta update`).
- Populate SEO title + meta description per page per the SEO plugin in project context; ≤ 60 / ≤ 155 chars.
- Never invent facts (prices, certifications, phone numbers). Leave `[[TODO]]` and list them.

## 4. Verify
`npm run env:reset` then check every rendering pattern with real content AND the stress fixtures. Run `npm run check`.
Record time taken in the measurement sheet (content population row).
GS_EOF

cat > '.claude/skills/review-pass/SKILL.md' <<'GS_EOF'
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
GS_EOF

cat > '.claude/skills/sync-tokens/SKILL.md' <<'GS_EOF'
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
GS_EOF

cat > '.mcp.json' <<'GS_EOF'
{ "mcpServers": { "figma": { "type": "http", "url": "https://mcp.figma.com/mcp" } } }
GS_EOF

cat > '.github/pull_request_template.md' <<'GS_EOF'
## What
## Figma node(s)
## Reused (tokens / styles / patterns)
## Added (tokens / styles / patterns) — approved by:
## Screenshots
| 1920 | 390 |
|---|---|
| | |
## `npm run check`
## Content resilience (AGENTS.md §6) — all rows pass?
## Rules-log entry (if this fixes a defect)
GS_EOF

cat > '.github/workflows/quality.yml' <<'GS_EOF'
name: Quality gates
on:
  push: { branches: [develop, main] }
  pull_request:
concurrency: { group: "quality-${{ github.ref }}", cancel-in-progress: true }

jobs:
  standards:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.2', tools: composer }
      - run: composer install --no-progress
      - run: composer run lint:php

  security:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
        with: { fetch-depth: 0 }
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.2', tools: composer }
      - run: composer install --no-progress
      - run: composer run lint:security
      - uses: gitleaks/gitleaks-action@v2
        env: { GITHUB_TOKEN: "${{ secrets.GITHUB_TOKEN }}" }

  style:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with: { node-version: 20, cache: npm }
      - run: npm ci
      - run: npm run lint:style

  accessibility:
    runs-on: ubuntu-latest
    needs: [standards, security]
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with: { node-version: 20, cache: npm }
      - run: npm ci
      - run: npx wp-env start
      - run: npx wp-env run cli wp import /var/www/html/fixtures/content.xml --authors=create
      - run: npm run test:a11y

  performance:
    runs-on: ubuntu-latest
    needs: [standards, security]
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with: { node-version: 20, cache: npm }
      - run: npm ci
      - run: npx wp-env start
      - run: npx wp-env run cli wp import /var/www/html/fixtures/content.xml --authors=create
      - run: npm run test:perf
GS_EOF

cat > '.github/workflows/deploy.yml' <<'GS_EOF'
name: Deploy
# Code only (theme + mu-plugins). Database and media are never pushed from Git.
on:
  push: { branches: [develop, main] }
jobs:
  deploy:
    runs-on: ubuntu-latest
    environment: "${{ github.ref_name == 'main' && 'production' || 'staging' }}"
    steps:
      - uses: actions/checkout@v4
      - name: Configure SSH
        run: |
          mkdir -p ~/.ssh
          echo "${{ secrets.SSH_PRIVATE_KEY }}" > ~/.ssh/id_deploy && chmod 600 ~/.ssh/id_deploy
          echo "${{ secrets.SSH_KNOWN_HOSTS }}" > ~/.ssh/known_hosts
      - name: Rsync theme and mu-plugins
        run: |
          RS="rsync -az --delete -e 'ssh -i ~/.ssh/id_deploy -p ${{ secrets.SSH_PORT }}'"
          eval $RS wp-content/themes/gorilla-security/ ${{ secrets.SSH_USER }}@${{ secrets.SSH_HOST }}:${{ secrets.REMOTE_PATH }}/wp-content/themes/gorilla-security/
          eval $RS wp-content/mu-plugins/ ${{ secrets.SSH_USER }}@${{ secrets.SSH_HOST }}:${{ secrets.REMOTE_PATH }}/wp-content/mu-plugins/
      - name: Flush caches
        run: ssh -i ~/.ssh/id_deploy -p ${{ secrets.SSH_PORT }} ${{ secrets.SSH_USER }}@${{ secrets.SSH_HOST }} "cd ${{ secrets.REMOTE_PATH }} && wp cache flush && wp rewrite flush"
GS_EOF

cat > '.github/workflows/claude.yml' <<'GS_EOF'
name: Claude
# Needs repo secret ANTHROPIC_API_KEY (or run /install-github-app in Claude Code).
# Review job only for now; add an @claude mention job once the team trusts it.
on:
  pull_request: { types: [opened, synchronize] }
permissions: { contents: read, pull-requests: write, issues: write, id-token: write }
jobs:
  review:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: anthropics/claude-code-action@v1
        with:
          anthropic_api_key: "${{ secrets.ANTHROPIC_API_KEY }}"
          prompt: |
            Run the review-pass skill in .claude/skills/review-pass/SKILL.md against this PR.
            Post findings as one PR comment grouped by AGENTS.md section. Do not push commits.
GS_EOF

chmod +x .githooks/pre-commit
git init -q -b develop
if [ -z "$(git config user.email || true)" ]; then
  echo "Set your identity first:  git config --global user.name \"Your Name\" && git config --global user.email you@example.com"
  echo "Then run:  git add -A && git commit -m 'chore: initial repo structure with project context' && git branch main"
  exit 0
fi
git add -A
git commit -q -F - <<'GS_EOF'
chore: initial repo structure with project context

- AGENTS.md, CLAUDE.md and docs/ (project context, design system, sitemap,
  rules log, onboarding, handover checklist, measurement, setup)
- Claude Code config: .claude/skills (build-section, scaffold-content,
  review-pass, sync-tokens), .claude/settings.json, .mcp.json (Figma)
- Tooling: wp-env, composer + PHPCS rulesets, stylelint, pa11y, Lighthouse,
  pre-commit hook
- CI: quality gates, deploy, Claude PR review; PR template
- Starter block theme (tokens in theme.json, pattern helpers) and gs-core
  mu-plugin; fixtures/content.xml

Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>
Claude-Session: https://claude.ai/code/session_01GgQDC2TAYhcmH4CjdDRSDJ
GS_EOF
git branch main
git config core.hooksPath .githooks   # enable the hook after the initial commit
echo
git log --oneline --decorate -1
echo "Done: $(git ls-files | wc -l | tr -d ' ') files committed on develop (main created at the same commit)."
