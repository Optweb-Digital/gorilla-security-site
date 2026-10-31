# Contact Form 7 — "Quote request"

Used by the **quote-card** pattern (hero, Figma 1:97). The pattern embeds the form **by title**:

```
[contact-form-7 title="Quote request"]
```

If no form with exactly this title exists, the card shows `[[TODO: …]]` instead of a broken shortcode.
Local and CI get the form from `fixtures/content.xml` (`npm run env:reset`). On staging and production,
create it once in **Contact → Add New** with the settings below.

## Form tab

Paste as-is. The `gs-field` wrappers, `id:` options and the `<label>` **after** each field drive the
floating labels in `components.css` (`.gs-form`). The placeholder repeats the label: CSS hides it
and shows the label in its place, but `:placeholder-shown` needs placeholder text to work.

```
<p class="gs-field">[text* full-name id:gs-quote-name autocomplete:name placeholder "Full Name *"]<label for="gs-quote-name">Full Name *</label></p>
<p class="gs-field">[tel* phone id:gs-quote-phone autocomplete:tel placeholder "Phone Number *"]<label for="gs-quote-phone">Phone Number *</label></p>
<p class="gs-field">[email* email id:gs-quote-email autocomplete:email placeholder "Email Address *"]<label for="gs-quote-email">Email Address *</label></p>
<p class="gs-field gs-field--select">[select* service id:gs-quote-service first_as_label "Service Interested In *" "CCTV Systems" "Alarm System" "Intercom System" "Access Control System" "Smart Lock Installation" "Smart Home Installation"]<label for="gs-quote-service">Service Interested In *</label></p>
<p class="gs-field gs-field--textarea">[textarea message id:gs-quote-message x3 placeholder "Your Message (Optional)"]<label for="gs-quote-message">Your Message (Optional)</label></p>
<p class="gs-form__submit">[submit "Request a Quote"]</p>
```

Rules:
- Keep each field on one line (CF7 would otherwise insert `<br>` between field and label).
- `id:` values must be unique on the page. If the form is ever embedded twice on one page, create a
  copy with different ids.
- The service options are the six services listed in the Figma footer (1:432). Change them here
  if the service list changes.

## Mail tab

| Field | Value |
|---|---|
| To | `[_site_admin_email]` — replace with the quote inbox once confirmed (project-context.md → Site details) |
| From | `[_site_title] <wordpress@[_site_domain]>` |
| Subject | `[_site_title] quote request from [full-name]` |
| Additional headers | `Reply-To: [email]` |
| Message body | see below |

```
Name: [full-name]
Phone: [phone]
Email: [email]
Service: [service]

[message]

-- 
Sent from [_site_url] (quote card)
```

Mail (2) stays off. Messages tab: CF7 defaults.
