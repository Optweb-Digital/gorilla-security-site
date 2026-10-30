<?php
/**
 * Title: Quote card (dark glass)
 * Slug: gorilla-security/quote-card
 * Categories: gorilla-components
 * Keywords: quote, form, contact, request
 *
 * Figma 1:97 — dark glass card with the hero quote form (name, phone, email, service, message).
 * The form itself is Contact Form 7 (approved, not yet installed): until it is configured the
 * card shows a [[TODO]] where the shortcode goes. .gs-form--dark styles the CF7 fields.
 *
 * @package gorilla-security
 */

?>
<!-- wp:group {"className":"is-style-glass-dark gs-quote-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-glass-dark gs-quote-card"><!-- wp:paragraph {"className":"gs-quote-card__eyebrow"} -->
<p class="gs-quote-card__eyebrow"><?php echo esc_html__( 'Request a Quote', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph -->

<?php
echo wp_kses_post(
	gorilla_heading(
		__( 'Get a Free Quote', 'gorilla-security' ),
		array(
			'size'  => 'h4',
			'class' => 'gs-quote-card__title',
		)
	)
);
?>

<!-- wp:paragraph {"className":"gs-quote-card__text"} -->
<p class="gs-quote-card__text"><?php echo esc_html__( 'Tell us about your security needs and our team will get back to you with a tailored solution.', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"gs-form gs-form--dark","layout":{"type":"default"}} -->
<div class="wp-block-group gs-form gs-form--dark"><!-- wp:paragraph -->
<p>[[TODO: quote form — Contact Form 7 shortcode (fields: full name, phone, email, service, message; submit "Request a Quote")]]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"gs-quote-card__note"} -->
<p class="gs-quote-card__note"><?php echo esc_html__( '*Your information is secure and will only be used to respond to your enquiry.', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
