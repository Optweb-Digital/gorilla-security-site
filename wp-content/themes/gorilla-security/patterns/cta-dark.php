<?php
/**
 * Title: CTA — dark
 * Slug: gorilla-security/cta-dark
 * Categories: gorilla-sections
 * Keywords: cta, call to action, contact, quote, phone
 * Description: "Ready for Smarter Security" call to action over a night photo, with model and glass stats (Figma 1:289).
 *
 * Copy is from Figma, pending content-writer confirmation (docs/copy/home.md). The phone button only renders
 * when gs_site( 'phone' ) is set.
 *
 * @package gorilla-security
 */

$gs_home  = home_url( '/' );
$gs_phone = gs_site( 'phone' );
$gs_bg    = gs_img( 'cta-bg' );
$gs       = array();

$gs_cover = array(
	'overlayColor' => 'night',
	'dimRatio'     => 40,
	'tagName'      => 'section',
	'align'        => 'full',
	'className'    => 'gs-cta gs-on-dark',
	'layout'       => array( 'type' => 'constrained' ),
	'anchor'       => 'contact',
);
if ( $gs_bg ) {
	$gs_cover = array( 'url' => $gs_bg ) + $gs_cover;
}

$gs[] = gs_block_open( 'cover', $gs_cover ) . "\n"
	. '<section class="wp-block-cover alignfull gs-cta gs-on-dark" id="contact">'
	. '<span aria-hidden="true" class="wp-block-cover__background has-night-background-color has-background-dim-40 has-background-dim"></span>'
	. ( $gs_bg ? '<img class="wp-block-cover__image-background" alt="" src="' . esc_url( $gs_bg ) . '" data-object-fit="cover"/>' : '' )
	. '<div class="wp-block-cover__inner-container">';

$gs[] = gs_columns_open( 'gs-cta__grid', array( 'align' => 'wide' ) );

$gs[] = gs_column_open( 'gs-cta__text' );
$gs[] = gs_eyebrow( __( 'Let’s Connect', 'gorilla-security' ) );
$gs[] = gs_heading(
	__( 'Ready for [[Smarter Security]]', 'gorilla-security' ),
	array(
		'size'  => 'h1',
		'class' => 'gs-cta__title',
	)
);
$gs[] = gs_paragraph( __( 'Get tailored security and automation solutions designed to meet the unique needs of Melbourne homes and businesses. From CCTV and alarm systems to intercoms, access control, smart locks and automation, our team provides practical recommendations, professional guidance and solutions suited to your property. Speak with our experienced team for expert advice and a free, no-obligation quote.', 'gorilla-security' ), '', 'lead' );
$gs[] = gs_buttons(
	array(
		gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote', '', 'gs-btn-lg' ),
		$gs_phone ? gs_button( $gs_phone, gs_tel( $gs_phone ), 'light-phone', 'gs-btn-lg gs-pending' ) : '',
	)
);
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = gs_column_open( 'gs-cta__visual' );
$gs[] = gs_image( 'cta-model', '', '', array( 'class' => 'gs-cta__model' ) );
$gs[] = gs_paragraph( __( '24/7 Support', 'gorilla-security' ), '', '', 'gs-glass-stat gs-glass-stat--top gs-ico-headset' );
$gs[] = gs_paragraph( __( 'Homes & Businesses', 'gorilla-security' ), '', '', 'gs-glass-stat gs-glass-stat--bottom gs-ico-building-shield' );
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = "</div>\n<!-- /wp:columns -->";
$gs[] = "</div></section>\n<!-- /wp:cover -->";

echo wp_kses_post( implode( "\n", $gs ) );
