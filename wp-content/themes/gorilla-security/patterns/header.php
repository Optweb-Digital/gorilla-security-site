<?php
/**
 * Title: Header
 * Slug: gorilla-security/header
 * Categories: gorilla-sections
 * Keywords: header, navigation, menu, logo
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * Figma 1:523 — glass bar 1:524, logo 1:545, nav 1:525–1:530, phone 1:531, Get A Quote 1:542.
 * Glass over the hero on front/landing pages, solid elsewhere and once scrolled (design-system §6).
 * The phone button is only output once gorilla_site( 'phone' ) is confirmed (project-context).
 *
 * @package gorilla-security
 */

$gorilla_phone = gorilla_site( 'phone' );
$gorilla_tel   = $gorilla_phone ? 'tel:' . preg_replace( '/[^0-9+]/', '', $gorilla_phone ) : '';
?>
<!-- wp:group {"align":"full","className":"gs-header","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gs-header"><!-- wp:group {"className":"is-style-glass-light gs-header__bar","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group is-style-glass-light gs-header__bar">
<?php
echo wp_kses_post(
	gorilla_image(
		'logo',
		gorilla_site( 'name' ),
		'',
		array(
			'class' => 'gs-header__logo',
			'href'  => home_url( '/' ),
		)
	)
);
?>

<!-- wp:navigation {"overlayMenu":"mobile","className":"gs-header__nav","layout":{"type":"flex","justifyContent":"center"}} -->
<?php
echo wp_kses_post(
	implode(
		"\n\n",
		array(
			gorilla_nav_link( __( 'Home', 'gorilla-security' ), home_url( '/' ) ),
			gorilla_nav_link( __( 'Contact Us', 'gorilla-security' ), home_url( '/contact-us/' ), 'contact-us' ),
		)
	)
);
?>

<!-- /wp:navigation -->

<!-- wp:buttons {"className":"gs-header__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-buttons gs-header__actions">
<?php
echo wp_kses_post(
	implode(
		"\n\n",
		array_filter(
			array(
				gorilla_button( $gorilla_phone, $gorilla_tel, 'glass-phone', 'gs-header__phone' ),
				gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), '', 'gs-btn-sm' ),
			)
		)
	)
);
?>
</div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
