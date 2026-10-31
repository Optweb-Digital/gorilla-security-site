<?php
/**
 * Title: Quote split
 * Slug: gorilla-security/quote-split
 * Categories: gorilla-sections
 * Keywords: quote, form, contact, enquiry
 *
 * Figma 1:169 — heading, lead and the "Quote request (band)" Contact Form 7 form
 * (docs/forms/quote-band.md) beside a photo with the contact card (1:199) over it.
 * The photo fades into the white text column; the text never sits on the photo.
 *
 * @package gorilla-security
 */

$gsec_has_form = function_exists( 'wpcf7_get_contact_form_by_title' ) && wpcf7_get_contact_form_by_title( 'Quote request (band)' );
?>
<!-- wp:group {"tagName":"section","anchor":"get-a-quote","align":"full","className":"gs-quote-split","layout":{"type":"default"}} -->
<section class="wp-block-group alignfull gs-quote-split" id="get-a-quote"><!-- wp:columns {"className":"gs-quote-split__cols"} -->
<div class="wp-block-columns gs-quote-split__cols"><!-- wp:column {"width":"50%","className":"gs-quote-split__body gs-form"} -->
<div class="wp-block-column gs-quote-split__body gs-form" style="flex-basis:50%">
<?php
echo wp_kses_post( gsec_heading( __( 'We aim to make our [[security services]] as smooth as possible.', 'gorilla-security' ) ) );
echo wp_kses_post( gsec_paragraph( __( 'Let us know what service you are looking for and we can contact you.', 'gorilla-security' ), '', 'lead' ) );
?>

<?php if ( $gsec_has_form ) : ?>
<!-- wp:shortcode -->
[contact-form-7 title="Quote request (band)"]
<!-- /wp:shortcode -->
<?php else : ?>
	<?php echo wp_kses_post( gsec_paragraph( '[[TODO: create the "Quote request (band)" Contact Form 7 form — docs/forms/quote-band.md]]' ) ); ?>
<?php endif; ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%","className":"gs-quote-split__media"} -->
<div class="wp-block-column gs-quote-split__media" style="flex-basis:50%">
<?php echo wp_kses_post( gsec_image( 'quote-split', __( 'Gorilla Security technician installing a dome camera under the eaves of a brick house', 'gorilla-security' ) ) ); ?>

<!-- wp:pattern {"slug":"gorilla-security/contact-card"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
