<?php
/**
 * Title: Split · intro
 * Slug: gorilla-security/split-intro
 * Categories: gorilla-sections
 * Keywords: intro, about, split, image
 *
 * Figma 1:220 — eyebrow, heading, text and two buttons beside a photo in the
 * Deco frame · right image style.
 *
 * @package gorilla-security
 */

ob_start();
?>
<!-- wp:group {"tagName":"section","align":"full","className":"gs-split","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-split"><!-- wp:columns {"align":"wide","className":"gs-split__cols"} -->
<div class="wp-block-columns alignwide gs-split__cols"><!-- wp:column {"width":"50%","className":"gs-split__body"} -->
<div class="wp-block-column gs-split__body" style="flex-basis:50%">
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_eyebrow( __( 'Security Solutions', 'gorilla-security' ) );
echo gsec_heading( __( '[[Smarter Security]] for Melbourne Homes & Businesses.', 'gorilla-security' ) );
echo gsec_paragraph( __( 'At Gorilla Security and Automation, we help protect what matters. We supply and install CCTV, alarm, intercom and access control systems for homes and businesses across Melbourne. Our experienced team delivers reliable, high-quality installations using advanced technology, so you can enjoy greater peace of mind and a safer property.', 'gorilla-security' ), '', 'lead' );
echo gsec_buttons(
	array(
		gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
		gsec_button( __( 'Know More', 'gorilla-security' ), home_url( '/about-us/' ), 'outline' ),
	)
);
// phpcs:enable
?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%","className":"gs-split__media"} -->
<div class="wp-block-column gs-split__media" style="flex-basis:50%">
<?php echo gsec_image( 'split-intro', __( 'Gorilla Security technician fitting a video intercom beside a front door', 'gorilla-security' ), 'deco-frame-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below. ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
<?php
echo wp_kses_post( ob_get_clean() );
