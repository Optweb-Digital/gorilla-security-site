<?php
/**
 * Title: Brands
 * Slug: gorilla-security/brands
 * Categories: gorilla-sections
 * Keywords: brands, logos, partners, marquee
 * Description: "Trusted By Forward Thinking Brands" logo marquee (Figma 1:508 / 1:510).
 *
 * The manufacturer logos are third-party marks pending client confirmation: they load from the local-only
 * fixtures/assets/pending/ folder (gs_pending_img). Without any logo the section is not output at all.
 *
 * @package gorilla-security
 */

$gs_brands = array(
	array( 'brand-axis.png', 'Axis Communications' ),
	array( 'brand-dahua.png', 'Dahua Technology' ),
	array( 'brand-hilook.png', 'HiLook by Hikvision' ),
	array( 'brand-aiphone.png', 'Aiphone' ),
	array( 'brand-unv.png', 'Uniview' ),
	array( 'brand-hills.png', 'Hills' ),
	array( 'brand-hikvision.png', 'Hikvision' ),
	array( 'brand-inner-range.png', 'Inner Range' ),
	array( 'brand-paradox.png', 'Paradox' ),
	array( 'brand-bosch.png', 'Bosch' ),
);
$gs_logos  = array();
foreach ( $gs_brands as $gs_brand ) {
	$gs_logos[] = gs_image( '', $gs_brand[1], '', array( 'src' => gs_pending_img( $gs_brand[0] ) ) );
}
$gs_logos = array_filter( $gs_logos );
if ( ! $gs_logos ) {
	return;
}

$gs   = array();
$gs[] = gs_group_open(
	'gs-brands gs-pending',
	array(
		'tag'    => 'section',
		'align'  => 'full',
		'layout' => array( 'type' => 'default' ),
	)
);
$gs[] = gs_group_open( 'gs-brands__panel', array( 'layout' => array( 'type' => 'default' ) ) );
$gs[] = gs_heading(
	__( 'Trusted By Forward Thinking Brands', 'gorilla-security' ),
	array(
		'size'  => 'h3',
		'class' => 'gs-brands__title',
	)
);
$gs[] = gs_group_close();
$gs[] = gs_group_open( 'gs-marquee', array( 'layout' => array( 'type' => 'default' ) ) );
$gs[] = gs_group_open( 'gs-marquee__track', array( 'layout' => array( 'type' => 'default' ) ) );
$gs[] = implode( "\n", $gs_logos );
$gs[] = gs_group_close();
$gs[] = gs_group_close();
$gs[] = gs_group_close( 'section' );

echo wp_kses_post( implode( "\n", $gs ) );
