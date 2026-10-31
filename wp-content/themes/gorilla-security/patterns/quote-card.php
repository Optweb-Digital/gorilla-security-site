<?php
/**
 * Title: Quote card (dark glass)
 * Slug: gorilla-security/quote-card
 * Categories: gorilla-components
 * Keywords: quote, form, contact, request
 *
 * Figma 1:97 — dark glass card with the hero quote form (name, phone, email, service, message).
 * The form is the Contact Form 7 form titled "Hero quote form" (fixtures/content.xml), looked up by
 * title so no post ID is hard-coded. Without CF7 or the form, the card shows a [[TODO]] instead.
 * .gs-form--dark styles the CF7 fields.
 *
 * @package gorilla-security
 */

$gorilla_form_title = 'Hero quote form';
$gorilla_has_form   = function_exists( 'wpcf7_get_contact_form_by_title' ) && wpcf7_get_contact_form_by_title( $gorilla_form_title );
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
<div class="wp-block-group gs-form gs-form--dark">
<?php if ( $gorilla_has_form ) : ?>
<!-- wp:shortcode -->
[contact-form-7 title="<?php echo esc_attr( $gorilla_form_title ); ?>"]
<!-- /wp:shortcode -->
<?php else : ?>
<!-- wp:paragraph -->
<p>[[TODO: quote form — Contact Form 7 form "<?php echo esc_html( $gorilla_form_title ); ?>" (fields: full name, phone, email, service, message; submit "Request a Quote")]]</p>
<!-- /wp:paragraph -->
<?php endif; ?>
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"gs-quote-card__note"} -->
<p class="gs-quote-card__note"><?php echo esc_html__( '*Your information is secure and will only be used to respond to your enquiry.', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
