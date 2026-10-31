<?php
/**
 * Title: Why us
 * Slug: gorilla-security/why-us
 * Categories: gorilla-sections
 * Keywords: why, choose, steps, benefits
 * Description: "Built for Better Security." stepper — six reasons with a matching photo (Figma 1:522).
 *
 * Copy is from the Figma component variants, pending content-writer confirmation (docs/copy/home.md).
 * Step 06 has no description in Figma (it repeats step 05), so only its title is output.
 *
 * @package gorilla-security
 */

$gs_home  = home_url( '/' );
$gs_steps = array(
	array( __( 'Proven Experience', 'gorilla-security' ), __( 'With industry experience, our team understands security challenges and delivers solutions tailored to your needs.', 'gorilla-security' ) ),
	array( __( 'Fast Response', 'gorilla-security' ), __( 'Quick response and dependable service when you need us, helping keep your property protected without unnecessary delays.', 'gorilla-security' ) ),
	array( __( 'Competitive Pricing', 'gorilla-security' ), __( 'Quality security solutions at fair and transparent prices, giving you reliable protection without unnecessary costs.', 'gorilla-security' ) ),
	array( __( 'Mobile Service', 'gorilla-security' ), __( 'Our fully mobile team brings professional security services directly to your home or business, wherever you need us.', 'gorilla-security' ) ),
	array( __( 'Trusted & Reliable', 'gorilla-security' ), __( 'Honest advice, quality workmanship, and reliable solutions designed to give you confidence in your security system.', 'gorilla-security' ) ),
	array( __( '24/7 Support', 'gorilla-security' ), '' ),
);

$gs   = array();
$gs[] = gs_group_open(
	'gs-section gs-why',
	array(
		'tag'    => 'section',
		'align'  => 'full',
		'anchor' => 'why-us',
	)
);
$gs[] = gs_columns_open( 'gs-why__grid gs-steps', array( 'align' => 'wide' ) );

$gs[]     = gs_column_open( 'gs-why__intro' );
$gs[]     = gs_eyebrow( __( 'Why Choose Gorilla Security?', 'gorilla-security' ) );
$gs[]     = gs_heading( __( "[[Built for Better]]\nSecurity.", 'gorilla-security' ) );
$gs[]     = gs_group_open( 'gs-steps__media', array( 'layout' => array( 'type' => 'default' ) ) );
$gs_total = count( $gs_steps );
for ( $gs_i = 1; $gs_i <= $gs_total; $gs_i++ ) {
	$gs[] = gs_image( 'why-' . $gs_i, '', '', array( 'class' => 'gs-photo' ) );
}
$gs[] = gs_group_close();
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = gs_column_open( 'gs-why__list' );
$gs[] = gs_buttons( array( gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote' ) ) );
$gs[] = gs_group_open( 'gs-steps__list', array( 'layout' => array( 'type' => 'default' ) ) );
foreach ( $gs_steps as $gs_n => $gs_step ) {
	$gs[] = gs_group_open( 'gs-step', array( 'layout' => array( 'type' => 'default' ) ) );
	$gs[] = gs_paragraph( sprintf( '%02d', $gs_n + 1 ), '', '', 'gs-step__num' );
	$gs[] = gs_heading(
		$gs_step[0],
		array(
			'level' => 3,
			'size'  => 'card-title',
			'class' => 'gs-step__title',
		)
	);
	$gs[] = gs_paragraph( $gs_step[1], '', '', 'gs-step__body' );
	$gs[] = gs_group_close();
}
$gs[] = gs_group_close();
$gs[] = "</div>\n<!-- /wp:column -->";

$gs[] = "</div>\n<!-- /wp:columns -->";
$gs[] = gs_group_close( 'section' );

echo wp_kses_post( implode( "\n", $gs ) );
