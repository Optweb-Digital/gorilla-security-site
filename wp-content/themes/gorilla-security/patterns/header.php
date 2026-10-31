<?php
/**
 * Title: Header
 * Slug: gorilla-security/header
 * Categories: gorilla-components
 * Keywords: header, navigation, menu
 * Inserter: no
 * Description: Glass navigation bar (Figma 1:523). Used by parts/header.html.
 *
 * Blog and Area links from Figma are omitted until those pages exist (docs/project-context.md → Open decisions).
 * The phone button only renders when gs_site( 'phone' ) is set (pending client confirmation).
 *
 * @package gorilla-security
 */

$gs_logo  = gs_img( 'logo' );
$gs_phone = gs_site( 'phone' );
$gs_home  = home_url( '/' );
$gs       = array();

$gs[] = gs_group_open(
	'gs-header',
	array(
		'layout' => array(
			'type'           => 'flex',
			'flexWrap'       => 'nowrap',
			'justifyContent' => 'space-between',
		),
	)
);
if ( $gs_logo ) {
	$gs[] = '<!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"gs-header__logo"} -->' . "\n"
		. '<figure class="wp-block-image size-full gs-header__logo"><a href="' . esc_url( $gs_home ) . '"><img src="' . esc_url( $gs_logo ) . '" alt="' . esc_attr__( 'Gorilla Security — home', 'gorilla-security' ) . '"/></a></figure>' . "\n"
		. '<!-- /wp:image -->';
} else {
	$gs[] = '<!-- wp:site-title {"level":0} /-->';
}
$gs[] = '<!-- wp:navigation {"overlayMenu":"mobile","overlayBackgroundColor":"night","overlayTextColor":"white","className":"gs-header__nav","layout":{"type":"flex","justifyContent":"center"}} -->';
$gs[] = gs_nav_link( __( 'Home', 'gorilla-security' ), $gs_home );
$gs[] = gs_nav_link( __( 'About Us', 'gorilla-security' ), $gs_home . '#about' );
$gs[] = gs_nav_link( __( 'Services', 'gorilla-security' ), $gs_home . '#services' );
$gs[] = gs_nav_link( __( 'Contact Us', 'gorilla-security' ), home_url( '/contact-us/' ) );
$gs[] = '<!-- /wp:navigation -->';
$gs[] = gs_buttons(
	array(
		$gs_phone ? gs_button( $gs_phone, gs_tel( $gs_phone ), 'glass-phone', 'gs-btn-sm gs-header__phone gs-pending' ) : '',
		gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote', '', 'gs-btn-sm' ),
	)
);
$gs[] = gs_group_close();

echo wp_kses_post( implode( "\n", $gs ) );
