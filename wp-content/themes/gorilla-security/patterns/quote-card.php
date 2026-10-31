<?php
/**
 * Title: Quote card
 * Slug: gorilla-security/quote-card
 * Categories: gorilla-components
 * Keywords: quote, form, contact, enquiry
 * Description: Dark glass "Get a Free Quote" card with the Contact Form 7 form "Hero quote" (Figma 1:97).
 *
 * Copy is from Figma 1:97, pending content-writer confirmation in docs/copy/home.md.
 * The form itself lives in Contact Form 7 (title "Hero quote"); see fixtures/content.xml for its fields.
 *
 * @package gorilla-security
 */

?>
<!-- wp:group {"className":"is-style-glass-dark gs-form gs-form--dark","layout":{"type":"constrained"},"anchor":"quote"} -->
<div id="quote" class="wp-block-group is-style-glass-dark gs-form gs-form--dark">
<?php echo wp_kses_post( gs_eyebrow( __( 'Request a Quote', 'gorilla-security' ) ) ); ?>

<?php
echo wp_kses_post(
	gs_heading(
		__( 'Get a Free Quote', 'gorilla-security' ),
		array(
			'level' => 2,
			'size'  => 'h4',
			'class' => 'gs-form__title',
		)
	)
);
?>

<?php echo wp_kses_post( gs_paragraph( __( 'Tell us about your security needs and our team will get back to you with a tailored solution.', 'gorilla-security' ), '', '', 'gs-form__intro' ) ); ?>

<!-- wp:shortcode -->
[contact-form-7 title="Hero quote"]
<!-- /wp:shortcode -->

<?php echo wp_kses_post( gs_paragraph( __( '*Your information is secure and will only be used to respond to your enquiry.', 'gorilla-security' ), '', '', 'gs-form__note' ) ); ?>
</div>
<!-- /wp:group -->
