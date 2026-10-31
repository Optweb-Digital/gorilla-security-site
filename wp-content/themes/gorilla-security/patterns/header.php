<?php
/**
 * Title: Header
 * Slug: gorilla-security/header
 * Categories: gorilla-sections
 * Block Types: core/template-part/header
 * Keywords: header, navigation, menu
 *
 * Figma 1:523 — glass bar with logo, navigation, phone and quote buttons.
 *
 * @package gorilla-security
 */

$gsec_nav = array(
	array( __( 'Home', 'gorilla-security' ), '/' ),
	array( __( 'About Us', 'gorilla-security' ), '/about-us/' ),
	array( __( 'Services', 'gorilla-security' ), '/services/' ),
	array( __( 'Blog', 'gorilla-security' ), '/blog/' ),
	array( __( 'Area', 'gorilla-security' ), '/area/' ),
	array( __( 'Contact Us', 'gorilla-security' ), '/contact-us/' ),
);

$gsec_phone = gsec_site( 'phone' );
$gsec_tel   = $gsec_phone ? 'tel:' . preg_replace( '/[^0-9+]/', '', $gsec_phone ) : '';
?>
<!-- wp:group {"className":"gs-header is-style-glass-light","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group gs-header is-style-glass-light">
<?php if ( has_custom_logo() || '' !== gsec_img( 'logo' ) ) : ?>
<!-- wp:site-logo {"width":225,"className":"gs-header__logo"} /-->
<?php else : ?>
<!-- wp:site-title {"level":0,"className":"gs-header__logo"} /-->
<?php endif; ?>

<!-- wp:navigation {"overlayMenu":"mobile","className":"gs-header__nav","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
<?php
foreach ( $gsec_nav as $gsec_item ) {
	// Self-closing block: swap the helper's trailing " -->" for " /-->".
	$gsec_link = gsec_block_open(
		'navigation-link',
		array(
			'label'          => $gsec_item[0],
			'url'            => home_url( $gsec_item[1] ),
			'kind'           => 'custom',
			'isTopLevelLink' => true,
		)
	);
	echo wp_kses_post( substr( $gsec_link, 0, -4 ) . ' /-->' ) . "\n";
}
?>
<!-- /wp:navigation -->

<?php
echo wp_kses_post(
	gsec_buttons(
		array(
			$gsec_tel ? gsec_button( $gsec_phone, $gsec_tel, 'glass-phone', 'gs-btn-sm' ) : '',
			gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), '', 'gs-btn-sm' ),
		)
	)
);
?>
</div>
<!-- /wp:group -->
