# Patterns

One PHP file per section/component, created by `/build-section`. Header:

```php
<?php
/**
 * Title: FAQ
 * Slug: gorilla-security/faq
 * Categories: gorilla-sections
 * Keywords: faq, questions
 *
 * @package gorilla-security
 */
?>
<?php echo wp_kses_post( gs_heading( __( 'Frequently asked [[questions]]', 'gorilla-security' ) ) ); ?>
```

Planned slugs (docs/design-system.md §2): header · hero · quote-card · about · brands · why-us ·
services-tabs · quote-split · contact-card · split-intro · split-image-left · split-icon-trio ·
cta-dark · testimonials · faq · footer · stats.

Built: `stats`, `hero`, `quote-card`.
