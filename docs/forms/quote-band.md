# Contact Form 7 — "Quote request (band)"

Used by the **quote-split** pattern (Figma 1:169). The pattern embeds the form **by title**:

```
[contact-form-7 title="Quote request (band)"]
```

It is a separate form from "Quote request" (docs/forms/quote-request.md) because both appear on the
home page and field `id:` values must be unique on a page. If no form with exactly this title
exists, the section shows `[[TODO: …]]` instead of a broken shortcode. Local and CI get the form
from `fixtures/content.xml`; on staging and production create it once in **Contact → Add New**.

## Form tab

Same floating-label markup as "Quote request". `gs-field--third` / `gs-field--half` set the
three-up and two-up rows (Figma 1:172); fields without them span the full width.

```
<p class="gs-field gs-field--third">[text* full-name id:gs-band-name autocomplete:name placeholder "Name *"]<label for="gs-band-name">Name *</label></p>
<p class="gs-field gs-field--third">[email* email id:gs-band-email autocomplete:email placeholder "Email *"]<label for="gs-band-email">Email *</label></p>
<p class="gs-field gs-field--third">[tel* phone id:gs-band-phone autocomplete:tel placeholder "Phone *"]<label for="gs-band-phone">Phone *</label></p>
<p class="gs-field gs-field--select gs-field--half">[select* purpose id:gs-band-purpose first_as_label "Choose the purpose of your services ? *" "Residential" "Business"]<label for="gs-band-purpose">Choose the purpose of your services ? *</label></p>
<p class="gs-field gs-field--select gs-field--half">[select* service id:gs-band-service first_as_label "Choose what is required ? *" "CCTV Systems" "Alarm System" "Intercom System" "Access Control System" "Smart Lock Installation" "Smart Home Installation"]<label for="gs-band-service">Choose what is required ? *</label></p>
<p class="gs-field gs-field--textarea">[textarea message id:gs-band-message x3 placeholder "Message"]<label for="gs-band-message">Message</label></p>
<p class="gs-form__submit">[submit "Get A Quote"]</p>
```

Notes (confirm with the client):
- Labels are Figma's; " *" marks required fields (Figma shows none).
- Figma gives no options for "purpose". "Residential" / "Business" come from the site copy
  (1:244 "Residential & Business Protection"). Service options are the six from the footer (1:432).
- Figma's submit has an arrow; CF7 renders an `<input>`, so it has none.

## Mail tab

As "Quote request", plus `Purpose: [purpose]`, and the body ends `Sent from [_site_url] (quote band)`.
Mail (2) stays off. Messages tab: CF7 defaults.
