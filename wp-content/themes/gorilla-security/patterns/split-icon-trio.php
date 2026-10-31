<?php
/**
 * Title: Split · icon trio (text left, photo right)
 * Slug: gorilla-security/split-icon-trio
 * Categories: gorilla-sections
 * Keywords: split, licensed, icons, trust
 *
 * Figma 1:253 — heading 1:256, copy 1:258, icon trio 1:265 (shield / gear / wrench, dividers
 * 1:285–1:287), buttons 1:262 / 1:259, photo 1:288 with deco blocks 1:254 / 1:255.
 *
 * @package gorilla-security
 */

$gorilla_photo = gorilla_image( 'split-3', __( 'Person passing through a secure access gate in an office lobby', 'gorilla-security' ), 'deco-frame-right', array( 'class' => 'gs-split__photo' ) );

$gorilla_trio = array(
	'shield' => __( 'Licensed & Trusted', 'gorilla-security' ),
	'gear'   => __( 'Installation & Maintenance', 'gorilla-security' ),
	'wrench' => __( 'Repairs & Support', 'gorilla-security' ),
);
?>
<!-- wp:group {"align":"full","className":"gs-split","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gs-split"><!-- wp:columns {"align":"wide","className":"gs-split__cols"} -->
<div class="wp-block-columns alignwide gs-split__cols"><!-- wp:column {"className":"gs-split__text"} -->
<div class="wp-block-column gs-split__text">
<?php
echo wp_kses_post( gorilla_heading( __( 'Licensed Security System Solutions [[You Can Trust]]', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
echo wp_kses_post( gorilla_paragraph( __( 'We provide high-quality security system services across Melbourne, including professional installation, maintenance, and quick repairs. As a fully licensed provider, we deliver reliable, affordable and long-lasting security solutions tailored to your property.', 'gorilla-security' ), '', 'lead' ) );
?>

<!-- wp:group {"className":"gs-icon-trio","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-icon-trio">
<?php foreach ( $gorilla_trio as $gorilla_icon_name => $gorilla_label ) : ?>
<!-- wp:group {"className":"gs-icon-trio__item","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group gs-icon-trio__item"><?php echo wp_kses_post( gorilla_icon( $gorilla_icon_name ) . "\n\n" . gorilla_paragraph( $gorilla_label ) ); ?></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<?php
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
