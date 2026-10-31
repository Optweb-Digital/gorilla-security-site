<?php
/**
 * Title: Split · icon trio
 * Slug: gorilla-security/split-icon-trio
 * Categories: gorilla-sections
 * Keywords: licensed, trust, split, icons
 *
 * Figma 1:253 — heading, text, three icon highlights (gs-icon-trio) and two buttons beside
 * a photo in the Deco frame · right image style.
 *
 * @package gorilla-security
 */

$gsec_trio = array(
	'shield' => __( 'Licensed & Trusted', 'gorilla-security' ),
	'gear'   => __( 'Installation & Maintenance', 'gorilla-security' ),
	'wrench' => __( 'Repairs & Support', 'gorilla-security' ),
);

ob_start();
?>
<!-- wp:group {"tagName":"section","align":"full","className":"gs-split","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-split"><!-- wp:columns {"align":"wide","className":"gs-split__cols"} -->
<div class="wp-block-columns alignwide gs-split__cols"><!-- wp:column {"width":"45%","className":"gs-split__body"} -->
<div class="wp-block-column gs-split__body" style="flex-basis:45%">
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_heading( __( 'Licensed Security System Solutions [[You Can Trust]]', 'gorilla-security' ) );
echo gsec_paragraph( __( 'We provide high-quality security system services across Melbourne, including professional installation, maintenance, and quick repairs. As a fully licensed provider, we deliver reliable, affordable and long-lasting security solutions tailored to your property.', 'gorilla-security' ), '', 'lead' );
?>

<!-- wp:group {"className":"gs-icon-trio","layout":{"type":"default"}} -->
<div class="wp-block-group gs-icon-trio">
<?php
foreach ( $gsec_trio as $gsec_icon_name => $gsec_label ) {
	echo '<!-- wp:group {"className":"gs-icon-trio__item","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-icon-trio__item">' . gsec_icon( $gsec_icon_name )
		. "\n" . '<!-- wp:paragraph {"className":"gs-icon-trio__label"} -->' . "\n"
		. '<p class="gs-icon-trio__label">' . esc_html( $gsec_label ) . '</p>' . "\n"
		. '<!-- /wp:paragraph --></div>' . "\n" . '<!-- /wp:group -->' . "\n";
}
?>
</div>
<!-- /wp:group -->

<?php
echo gsec_buttons(
	array(
		gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
		gsec_button( __( 'Know More', 'gorilla-security' ), home_url( '/services/' ), 'outline' ),
	)
);
// phpcs:enable
?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"55%","className":"gs-split__media"} -->
<div class="wp-block-column gs-split__media" style="flex-basis:55%">
<?php echo gsec_image( 'split-icon-trio', __( 'Office worker tapping an access card at a security turnstile', 'gorilla-security' ), 'deco-frame-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below. ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
<?php
echo wp_kses_post( ob_get_clean() );
