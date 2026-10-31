<?php
/**
 * Title: About
 * Slug: gorilla-security/about
 * Categories: gorilla-sections
 * Keywords: about, intro, features, stats
 * Description: About Gorilla Security — copy, buttons, stats, portrait and feature card (Figma 1:6, stats 1:12).
 *
 * Copy is from Figma, pending content-writer confirmation in docs/copy/home.md ("livinng" typo corrected).
 * Markup is collected and passed through wp_kses_post() once, balanced (rules-log 010).
 *
 * @package gorilla-security
 */

$gs_home = home_url( '/' );
$gs      = array();

$gs[] = gs_group_open(
	'gs-section gs-about',
	array(
		'tag'    => 'section',
		'align'  => 'full',
		'anchor' => 'about',
	)
);
$gs[] = gs_columns_open( 'gs-about__grid', array( 'align' => 'wide' ) );

$gs[] = gs_column_open( 'gs-about__text' );
$gs[] = gs_eyebrow( __( 'ABOUT GORILLA SECURITY', 'gorilla-security' ) );
$gs[] = gs_heading( __( 'Security Build [[Around]] You.', 'gorilla-security' ) );
$gs[] = gs_paragraph( __( 'Gorilla Security & Automation delivers professional security and smart technology solutions for Melbourne homes and businesses. From CCTV and alarms to intercoms, access control, digital locks and smart home automation, we design and install tailored systems that make your space safer, smarter and more connected.', 'gorilla-security' ), '', 'lead' );
$gs[] = gs_buttons(
	array(
		gs_button( __( 'Know More', 'gorilla-security' ), $gs_home . '#services' ),
		gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote', 'outline' ),
	)
);
$gs[] = '<!-- wp:pattern {"slug":"gorilla-security/stats"} /-->';
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = gs_column_open( 'gs-about__media' );
$gs[] = gs_image( 'about-portrait', __( 'Gorilla Security technician standing beside a branded service van', 'gorilla-security' ), '', array( 'class' => 'gs-about__portrait gs-photo' ) );
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = gs_column_open( 'gs-about__aside' );
$gs[] = gs_group_open( 'is-style-card-tint gs-about__features', array( 'layout' => array( 'type' => 'default' ) ) );
$gs[] = gs_feature( 'shield', __( 'Professional Installation', 'gorilla-security' ), __( 'Expert setup for reliable and long-lasting protection', 'gorilla-security' ) );
$gs[] = gs_feature( 'chip', __( 'Smart Technology', 'gorilla-security' ), __( 'Modern security and automation for easier, smarter living', 'gorilla-security' ) );
$gs[] = gs_feature( 'map-pin', __( 'Melbourne Service', 'gorilla-security' ), __( 'Local team providing fast, trusted and ongoing support.', 'gorilla-security' ) );
$gs[] = gs_group_close();
$gs[] = gs_image( 'about-van', __( 'Gorilla Security branded service van', 'gorilla-security' ), '', array( 'class' => 'gs-about__van gs-photo' ) );
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = "</div>\n<!-- /wp:columns -->";
$gs[] = gs_group_close( 'section' );

echo wp_kses_post( implode( "\n", $gs ) );
