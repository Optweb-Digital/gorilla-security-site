<?php
/**
 * Title: Quote card
 * Slug: gorilla-security/quote-card
 * Categories: gorilla-components
 * Keywords: quote, form, contact, enquiry
 *
 * Figma 1:97 — dark glass card with the "Quote request" Contact Form 7 form
 * (template and setup: docs/forms/quote-request.md).
 *
 * @package gorilla-security
 */

$gsec_has_form = function_exists( 'wpcf7_get_contact_form_by_title' ) && wpcf7_get_contact_form_by_title( 'Quote request' );
?>
<!-- wp:group {"anchor":"quote","className":"gs-quote-card gs-form gs-form--dark is-style-glass-dark","layout":{"type":"default"}} -->
<div class="wp-block-group gs-quote-card gs-form gs-form--dark is-style-glass-dark" id="quote">
<?php
echo wp_kses_post( gsec_eyebrow( __( 'Request a Quote', 'gorilla-security' ) ) );
echo wp_kses_post(
	gsec_heading(
		__( 'Get a Free Quote', 'gorilla-security' ),
		array(
			'size'  => 'h4',
			'class' => 'gs-quote-card__title',
		)
	)
);
echo wp_kses_post( gsec_paragraph( __( 'Tell us about your security needs and our team will get back to you with a tailored solution.', 'gorilla-security' ), '', 'base' ) );
?>

<?php if ( $gsec_has_form ) : ?>
<!-- wp:shortcode -->
[contact-form-7 title="Quote request"]
<!-- /wp:shortcode -->
<?php else : ?>
	<?php echo wp_kses_post( gsec_paragraph( '[[TODO: create the "Quote request" Contact Form 7 form — docs/forms/quote-request.md]]' ) ); ?>
<?php endif; ?>

<?php echo wp_kses_post( gsec_paragraph( __( '*Your information is secure and will only be used to respond to your enquiry.', 'gorilla-security' ), '', 'small' ) ); ?>
</div>
<!-- /wp:group -->
