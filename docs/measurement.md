# Measurement — Baseline vs. Programme

## Tracking sheet (`docs/tracking.csv`, one row per unit of work)

```csv
date,developer,unit_type,unit_name,figma_node,method,build_minutes,review_minutes,gate_failures_first_run,defects_found_in_review,defects_found_after_merge,rework_minutes,rules_log_entries_added,notes
2026-10-21,dev1,section,stats,1:12,claude,,,,,,,,
```
- `unit_type`: section · template · content-page · token-sync · fix
- `method`: `manual` (baseline) or `claude` (workflow)
- Record honestly, including time spent correcting Claude.

## Day-1 baseline
Before using the workflow, each developer builds one comparable section manually (e.g. a split-image section) and the content writer populates one page manually. Record both rows with `method=manual`.

## Metrics reported on Day 10
| Metric | Baseline | Day 10 | Change |
|---|---|---|---|
| Median build minutes per section | | | |
| Gate failures on first run (avg) | | | |
| Defects in review per section | | | |
| Defects after merge | | | |
| Rework minutes per section | | | |
| Minutes to populate one page (content + SEO) | | | |
| Rules-log entries added / promoted to lint | | | |

Check-ins on Day 15 and Day 20 re-run the same table to catch drift.

## Ownership & maintenance rhythm
- Handbook owner: tech lead. Reviews rules-log weekly; promotes house-wide rules to the template repo monthly.
- Designer owns design-system.md and handover checklist; developers propose changes via PR.
- Each new client project starts from the template repo; only `docs/` content changes per client.
