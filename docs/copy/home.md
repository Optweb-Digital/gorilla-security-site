# Home — copy

> **Status: DRAFT from Figma — pending content-writer confirmation.**
> Copied verbatim from Figma file `eRJbcaKkAEQSHYALSEbjWt` (frame 1:4) so sections could be built.
> The content writer confirms or replaces each line, then removes this note.

SEO title: [[TODO: copy]] (≤ 60 chars)
Meta description: [[TODO: copy]] (≤ 155 chars)

## hero (1:69)
- heading: Smarter Security. / Safer Spaces. (forced line break after "Security.", as in Figma)
- lead: Advanced security and smart technology, professionally designed and installed for Melbourne homes and businesses.
- button: Get A Quote (→ `#quote`, the form in the hero)

## quote-card (1:97)
- eyebrow: Request a Quote
- heading: Get a Free Quote
- intro: Tell us about your security needs and our team will get back to you with a tailored solution.
- field labels: Full Name * · Phone Number * · Email Address * · Service Interested In * · Your Message (Optional)
- added for accessibility (not in Figma): "Fields marked * are required."
- service options (from the footer list 1:432): CCTV Systems · Alarm System · Intercom System · Access Control System · Smart Lock Installation · Smart Home Installation
- button: Request a Quote
- note: *Your information is secure and will only be used to respond to your enquiry.
  (Review: the leading "*" reads like the required-field marker — consider removing it.)

## stats (1:12, inside about)
1. 6+ / Security Solutions
2. 600+ / Homes & Businesses
3. 1000+ / Happy Customers

## Pending confirmation — NOT published
These appear in Figma but are factual claims or details the client must confirm. They render **locally only**
(GS_SHOW_PENDING, files in the gitignored fixtures/assets/pending/) so the layout can be reviewed against Figma;
staging and production output nothing until each item is confirmed.

- Review badge (1:114): "1000+ Reviews", 5-star rating, Google as the source — need the real count, rating and
  the Google reviews profile URL.
- Trust strip (1:515): "Licensed Security Installers — License issued by Victoria Police" (licence number to show?),
  Afterpay, "2 Years Warranty", "Hikvision Platinum Partners Installers" — need confirmation and official logo files.
- Social bar (1:83) and footer icons (1:426): Instagram, Facebook, X, LinkedIn profile URLs. Locally the icons
  show as non-linked placeholders; they become links only once verified URLs are added to gs_site( 'social' ).
- Quote form recipient email (CF7 currently sends to the site admin email).
- Service area: copy says "Melbourne" (hero lead and elsewhere) — confirm.

## header (1:523)
- nav: Home · About Us · Services · Contact Us — **Blog** and **Area** omitted until those pages exist.
- buttons: phone (pending) · Get A Quote (→ `#quote`).

## about (1:6)
- eyebrow: ABOUT GORILLA SECURITY · heading: Security Build [[Around]] You. (review: "Build" vs "Built"?)
- copy, buttons (Know More → `#services`, Get A Quote), stats (below).
- features: Professional Installation / Smart Technology ("livinng" typo corrected to "living") / Melbourne Service.

## brands (1:508) — PENDING, local only
- heading: Trusted By Forward Thinking Brands · 10 manufacturer logos (Axis, Dahua, HiLook, Aiphone, Uniview, Hills,
  Hikvision, Inner Range, Paradox, Bosch). Confirm the brand relationship and supply transparent logo files.

## why-us (1:522)
- eyebrow: Why Choose Gorilla Security? · heading: [[Built for Better]] / Security. (line break as in Figma)
- steps 01–05 copy from Figma variants; **step 06 "24/7 Support" has no description** (Figma repeats step 05).

## services-tabs (1:162) — 6 tabs
- CCTV Systems · Alarm Systems · Intercoms · Access Control · Smart Locks · Smart Home; each heading, paragraph,
  6 checklist items and float-card text from Figma. Edits: "Intercoms Systems" → "Intercom Systems";
  "card, PIN biometric" → "card, PIN or biometric"; double space removed. Claims: "24/7 Monitoring Options".

## quote-split (1:169) + contact-card (1:199)
- heading: We aim to make our [[security services]] as smooth as possible. · intro from Figma.
- form "Quote split": select options are **placeholders** (purpose: Home / Business; required: footer service list).
- contact card (pending): 0468 532 275 / Call Us Directly · Mon-Sat / 8:00 AM-6:00 PM (conflicts with footer hours).

## split-intro / split-image-left / split-icon-trio (1:220 / 1:238 / 1:253)
- Copy from Figma. "Gorilla Security & Locksmith" normalised to "Gorilla Security". Claims to confirm: "Affordable",
  "the best security", "help available 24/7", "Licensed", "fully licensed provider", "high-quality".

## cta-dark (1:289)
- Let's Connect · Ready for [[Smarter Security]] · copy · Get A Quote · phone (pending) · cards "24/7 Support",
  "Homes & Businesses".

## testimonials (1:407) — PENDING, local only
- 5 reviews from Figma (names, photos, quotes). Must be real, accurate and used with consent (Australian Consumer Law).
  Card 5 repeats the name "Matt To'omua". **Review dates are not shown** (the Figma dates are placeholders);
  add the real date per review once confirmed. **Card 5 is shown as in Figma** but repeats the name "Matt To'omua" with a different photo and review
  ("Great service thanks Dan") — client to confirm the reviewer's real name.
- Slider: autoplays every 3 s in an infinite loop at every width (pause button; pauses on hover/focus; off under
  reduced motion). Where all cards fit, one hidden copy (aria-hidden, inert) keeps it moving.

## faq (1:334)
- Accordion: one answer open at a time (native exclusive <details name="gs-faq">); opens on desktop hover (intent
  delay) as well as click/tap/keyboard.
- 8 questions and answer 02 from Figma. **Answers 01, 03–08 are drafts** written only from facts already in the
  approved page copy — content writer to confirm or replace:
  - 01 services list (about + services copy) · 03 homes & businesses, offices/stores/warehouses (split copy)
  - 04 tailored design, professional installation, honest advice, quality workmanship, ongoing support (about /
    why-us copy) · 05 Get A Quote form, free no-obligation quote (quote card + CTA copy)
  - 06 CCTV/alarm/intercom/access control for business premises (services + split copy)
  - 07–08 wireless systems: no cabling, smartphone alerts, remote access (split copy) plus a plain description of
    how wireless sensors report to a panel/app — no new claims, warranties, licences or monitoring promises.

## footer (1:426)
- tagline, Security Systems links (→ each service tab: `#cctv-systems`, `#alarm-systems`, `#intercom-systems`,
  `#access-control`, `#smart-locks`, `#smart-home`), Quick Links (Home, About Us, Contact Us, FAQs — Blog/Area omitted),
  contact details + hours (pending; address links to a Google Maps search of the address as given), award badge (pending),
  "Follow Us On :" + social icons (placeholders, no URLs), copyright "© {year} Gorilla Security…".

## Links and quote dialog
- Every "Get A Quote" link (header, hero, about, why-us, services, splits, CTA, testimonials, FAQ, footer) opens the hero
  quote card in a modal dialog (one form instance; without JS it jumps to the card in the hero).
- Services panel "Know More" → `#faq` (visually hidden text "about {service} in our FAQs") until service pages exist.
- About / split "Know More" → `#services`.
