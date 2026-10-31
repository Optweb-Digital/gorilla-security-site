<?php
/**
 * Title: Footer
 * Slug: gorilla-security/footer
 * Categories: gorilla-components
 * Keywords: footer, contact, links
 * Inserter: no
 * Description: Dark footer with logo, link columns, contact details and hours (Figma 1:426). Used by parts/footer.html.
 *
 * Contact details, hours and the award badge are pending client confirmation: they only render when gs_site()
 * has them (local QA). Social icons link only to verified URLs in gs_site( 'social' ) (none yet: local QA shows
 * non-linked placeholders); Blog / Area links are omitted until those pages exist (docs/project-context.md).
 *
 * @package gorilla-security
 */

$gs_home    = home_url( '/' );
$gs_logo    = gs_img( 'logo' );
$gs_bg      = gs_img( 'footer-bg' );
$gs_badge   = gs_pending_img( 'badge-local.png' );
$gs_site    = gs_site();
$gs_heading = static function ( $text ) {
	return gs_heading(
		$text,
		array(
			'size'  => 'lead',
			'class' => 'gs-footer__heading',
		)
	);
};
$gs         = array();

$gs_cover = array(
	'overlayColor' => 'night',
	'dimRatio'     => 0,
	'tagName'      => 'div',
	'align'        => 'full',
	'className'    => 'gs-footer gs-on-dark',
	'layout'       => array( 'type' => 'constrained' ),
);
if ( $gs_bg ) {
	$gs_cover = array( 'url' => $gs_bg ) + $gs_cover;
}
$gs[] = gs_block_open( 'cover', $gs_cover ) . "\n"
	. '<div class="wp-block-cover alignfull gs-footer gs-on-dark">'
	. '<span aria-hidden="true" class="wp-block-cover__background has-night-background-color has-background-dim-0 has-background-dim"></span>'
	. ( $gs_bg ? '<img class="wp-block-cover__image-background" alt="" src="' . esc_url( $gs_bg ) . '" data-object-fit="cover"/>' : '' )
	. '<div class="wp-block-cover__inner-container">';

$gs[] = gs_columns_open( 'gs-footer__grid', array( 'align' => 'wide' ) );

/* Column 1 — brand */
$gs[]      = gs_column_open( 'gs-footer__brand' );
$gs[]      = gs_group_open(
	'gs-footer__badges',
	array(
		'layout' => array(
			'type'              => 'flex',
			'flexWrap'          => 'wrap',
			'verticalAlignment' => 'center',
		),
	)
)
	. gs_image( 'logo', __( 'Gorilla Security', 'gorilla-security' ), '', array( 'class' => 'gs-footer__logo' ) )
	. ( $gs_badge ? gs_image(
		'',
		__( 'Local business award badge', 'gorilla-security' ),
		'',
		array(
			'src'   => $gs_badge,
			'class' => 'gs-footer__badge gs-pending',
		)
	) : '' )
	. gs_group_close();
$gs[]      = gs_paragraph( __( 'Trusted security and automation solutions for safer homes and businesses across Melbourne.', 'gorilla-security' ), '', '', 'gs-footer__tagline' );
$gs[]      = gs_buttons( array( gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote' ) ) );
$gs_social = gs_social_links( array( 'instagram', 'facebook', 'x', 'linkedin' ), 'gs-social--footer' );
if ( $gs_social ) {
	$gs[] = gs_paragraph( __( 'Follow Us On :', 'gorilla-security' ), '', '', 'gs-footer__follow' );
	$gs[] = $gs_social;
}
$gs[] = "</div>\n<!-- /wp:column -->";

/* Column 2 — services */
$gs[] = gs_column_open( 'gs-footer__col' );
$gs[] = $gs_heading( __( 'Security Systems', 'gorilla-security' ) );
$gs[] = gs_link_list(
	array(
		// Each opens its tab in the Services section (panel anchors in patterns/services-tabs.php) until service pages exist.
		__( 'CCTV Systems', 'gorilla-security' )          => $gs_home . '#cctv-systems',
		__( 'Alarm System', 'gorilla-security' )          => $gs_home . '#alarm-systems',
		__( 'Intercom System', 'gorilla-security' )       => $gs_home . '#intercom-systems',
		__( 'Access Control System', 'gorilla-security' ) => $gs_home . '#access-control',
		__( 'Smart Lock Installation', 'gorilla-security' ) => $gs_home . '#smart-locks',
		__( 'Smart Home Installation', 'gorilla-security' ) => $gs_home . '#smart-home',
	),
	'gs-footer__links'
);
$gs[] = "</div>\n<!-- /wp:column -->";

/* Column 3 — quick links */
$gs[] = gs_column_open( 'gs-footer__col' );
$gs[] = $gs_heading( __( 'Quick Links', 'gorilla-security' ) );
$gs[] = gs_link_list(
	array(
		__( 'Home', 'gorilla-security' )       => $gs_home,
		__( 'About Us', 'gorilla-security' )   => $gs_home . '#about',
		__( 'Contact Us', 'gorilla-security' ) => home_url( '/contact-us/' ),
		__( 'FAQs', 'gorilla-security' )       => $gs_home . '#faq',
	),
	'gs-footer__links'
);
$gs[] = "</div>\n<!-- /wp:column -->";

/* Column 4 — contact (pending details only) */
$gs_contact = array();
if ( $gs_site['phone'] ) {
	$gs_contact[] = array( 'phone', $gs_site['phone'], gs_tel( $gs_site['phone'] ) );
}
if ( $gs_site['email'] ) {
	$gs_contact[] = array( 'mail', $gs_site['email'], 'mailto:' . $gs_site['email'] );
}
if ( $gs_site['address'] ) {
	// Map search for the address as given (no invented place ID or map embed).
	$gs_contact[] = array( 'map-pin', $gs_site['address'], 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $gs_site['address'] ) );
}
if ( $gs_contact || ! empty( $gs_site['hours'] ) ) {
	$gs[] = gs_column_open( 'gs-footer__contact' );
	$gs[] = $gs_heading( __( 'Contact Us', 'gorilla-security' ) );
	if ( $gs_contact ) {
		$gs_list = '<!-- wp:list {"className":"gs-contact-list gs-pending"} -->' . "\n" . '<ul class="wp-block-list gs-contact-list gs-pending">';
		foreach ( $gs_contact as $gs_row ) {
			$gs_text  = $gs_row[2] ? '<a href="' . esc_url( $gs_row[2] ) . '">' . esc_html( $gs_row[1] ) . '</a>' : esc_html( $gs_row[1] );
			$gs_list .= '<!-- wp:list-item {"className":"gs-ico-' . $gs_row[0] . '"} -->' . "\n" . '<li class="gs-ico-' . esc_attr( $gs_row[0] ) . '">' . $gs_text . "</li>\n<!-- /wp:list-item -->";
		}
		$gs[] = $gs_list . "</ul>\n<!-- /wp:list -->";
	}
	if ( ! empty( $gs_site['hours'] ) ) {
		$gs_hours = array();
		foreach ( $gs_site['hours'] as $gs_h ) {
			$gs_hours[] = $gs_h[0] . ': ' . $gs_h[1];
		}
		$gs[] = gs_group_open(
			'gs-hours gs-pending',
			array(
				'layout' => array(
					'type'     => 'flex',
					'flexWrap' => 'wrap',
				),
			)
		)
			. gs_list( $gs_hours, '', 'gs-hours__times gs-ico-clock' )
			. ( ! empty( $gs_site['support'] ) ? gs_paragraph( $gs_site['support'], '', '', 'gs-hours__support gs-ico-headset' ) : '' )
			. gs_group_close();
	}
	$gs[] = "</div>\n<!-- /wp:column -->";
}

$gs[] = "</div>\n<!-- /wp:columns -->";
$gs[] = gs_paragraph(
	/* translators: %s: year. */
	sprintf( __( '© %s Gorilla Security. All Rights Reserved | Website & SEO by OptWeb.', 'gorilla-security' ), wp_date( 'Y' ) ),
	'',
	'',
	'gs-footer__copyright'
);
$gs[] = "</div></div>\n<!-- /wp:cover -->";

echo wp_kses_post( implode( "\n", $gs ) );
