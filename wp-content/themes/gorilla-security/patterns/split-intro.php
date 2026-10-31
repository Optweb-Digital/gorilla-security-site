<?php
/**
 * Title: Split · intro (text left, photo right)
 * Slug: gorilla-security/split-intro
 * Categories: gorilla-sections
 * Keywords: split, intro, security solutions, photo
 *
 * Figma 1:220 — eyebrow 1:226, heading 1:223, copy 1:225, buttons 1:233 / 1:230, photo 1:237 with
 * deco blocks 1:221 / 1:222. The photo column is not output when the image is missing.
 *
 * @package gorilla-security
 */

$gorilla_photo = gorilla_image( 'split-1', __( 'Gorilla Security technician installing a video intercom at a front door', 'gorilla-security' ), 'deco-frame-right', array( 'class' => 'gs-split__photo' ) );
?>
<!-- wp:group {"align":"full","className":"gs-split","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gs-split"><!-- wp:columns {"align":"wide","className":"gs-split__cols"} -->
<div class="wp-block-columns alignwide gs-split__cols"><!-- wp:column {"className":"gs-split__text"} -->
<div class="wp-block-column gs-split__text">
<?php
echo wp_kses_post( gorilla_eyebrow( __( 'Security Solutions', 'gorilla-security' ) ) );
echo wp_kses_post( gorilla_heading( __( '[[Smarter Security]] for Melbourne Homes & Businesses.', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
echo wp_kses_post( gorilla_paragraph( __( 'At Gorilla Security and Automation, we help protect what matters. We supply and install CCTV, alarm, intercom and access control systems for homes and businesses across Melbourne. Our experienced team delivers reliable, high-quality installations using advanced technology, so you can enjoy greater peace of mind and a safer property.', 'gorilla-security' ), '', 'lead' ) );
echo wp_kses_post(
	gorilla_buttons(
		array(
			gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
			gorilla_button( __( 'Know More', 'gorilla-security' ), '#services', 'outline' ),
		)
	)
);
?>
</div>
<!-- /wp:column -->

<?php if ( $gorilla_photo ) : ?>
<!-- wp:column {"className":"gs-split__media"} -->
<div class="wp-block-column gs-split__media"><?php echo wp_kses_post( $gorilla_photo ); ?></div>
<!-- /wp:column -->
<?php endif; ?></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
