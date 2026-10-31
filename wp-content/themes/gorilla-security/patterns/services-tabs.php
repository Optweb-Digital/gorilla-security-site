<?php
/**
 * Title: Services tabs
 * Slug: gorilla-security/services-tabs
 * Categories: gorilla-sections
 * Keywords: services, tabs, cctv, alarm, intercom, access control, smart locks, smart home
 * Description: "Our Security Solutions" — six service tabs with checklist, buttons and photo cards (Figma 1:162).
 *
 * Copy is from the Figma component variants, pending content-writer confirmation (docs/copy/home.md).
 * Tabs are progressive enhancement (assets/js/gorilla.js): without JS every panel shows, stacked.
 * Each panel heading is an <h2> (the section has no other heading), styled at the 70px size.
 *
 * @package gorilla-security
 */

$gs_home   = home_url( '/' );
$gs_panels = array(
	array(
		'tab'   => __( 'CCTV Systems', 'gorilla-security' ),
		'icon'  => 'cctv',
		'title' => __( '[[CCTV]] Systems', 'gorilla-security' ),
		'text'  => __( 'Keep an eye on what matters with reliable, high-quality CCTV surveillance solutions for homes and businesses. Our systems are designed to provide clear video, remote access and complete peace of mind.', 'gorilla-security' ),
		'list'  => array( __( 'High-Definition Video', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'Remote Viewing', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ), __( 'Indoor & Outdoor Options', 'gorilla-security' ), __( 'Ongoing Support', 'gorilla-security' ) ),
		'image' => 'service-cctv',
		'alt'   => __( 'Security camera mounted on the wall of a modern home', 'gorilla-security' ),
		'cards' => array(
			array(
				'size'    => 'lg',
				'pos'     => 'br',
				'image'   => 'service-cctv-live',
				'title'   => __( 'Live Monitoring', 'gorilla-security' ),
				'text'    => __( 'View your property in real time from anywhere, on any device', 'gorilla-security' ),
				'devices' => true,
			),
		),
	),
	array(
		'tab'   => __( 'Alarm Systems', 'gorilla-security' ),
		'icon'  => 'bell',
		'title' => __( '[[Alarm]] Systems', 'gorilla-security' ),
		'text'  => __( 'Get instant protection with professionally installed alarm systems for homes and businesses. Our solutions help detect intrusions, alert you immediately and keep your property and loved ones safe.', 'gorilla-security' ),
		'list'  => array( __( '24/7 Monitoring Options', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'Intrusion Detection', 'gorilla-security' ), __( 'Mobile App Control', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ), __( 'Instant Alerts', 'gorilla-security' ) ),
		'image' => 'service-alarm',
		'alt'   => __( 'Alarm keypad and sensor installed in a home', 'gorilla-security' ),
		'cards' => array(
			array(
				'size'  => 'lg',
				'pos'   => 'bl',
				'image' => 'service-alarm-phone',
				'title' => __( 'Instant Alerts', 'gorilla-security' ),
				'text'  => __( 'Get real-time notifications on your phone, wherever you are.', 'gorilla-security' ),
			),
		),
	),
	array(
		'tab'   => __( 'Intercoms', 'gorilla-security' ),
		'icon'  => 'intercom',
		'title' => __( '[[Intercom]] Systems', 'gorilla-security' ),
		'text'  => __( 'See, speak and grant access to visitors with modern intercom systems for homes and businesses. Our solutions offer clear communication, enhanced security and greater peace of mind.', 'gorilla-security' ),
		'list'  => array( __( 'Video & Audio Communication', 'gorilla-security' ), __( 'Mobile App Integration', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'HD Video Clarity', 'gorilla-security' ), __( 'Remote Door Access', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ) ),
		'image' => 'service-intercom',
		'alt'   => __( 'Video intercom panel beside a front door', 'gorilla-security' ),
		'cards' => array(
			array(
				'size' => 'sm',
				'pos'  => 'tr',
				'icon' => 'speech',
				'text' => __( 'Talk to visitors in real time from anywhere', 'gorilla-security' ),
			),
			array(
				'size' => 'sm',
				'pos'  => 'br',
				'icon' => 'lock',
				'text' => __( 'Unlock the door remotely with just a tap', 'gorilla-security' ),
			),
		),
	),
	array(
		'tab'   => __( 'Access Control', 'gorilla-security' ),
		'icon'  => 'access-card',
		'title' => __( '[[Access]] Control', 'gorilla-security' ),
		'text'  => __( 'Manage and control access to your property with modern access control systems for homes and businesses. Our solutions provide secure, convenient and flexible entry management.', 'gorilla-security' ),
		'list'  => array( __( 'Secure Entry Management', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'Card, PIN & Biometric Access', 'gorilla-security' ), __( 'Remote Management', 'gorilla-security' ), __( 'Custom Access Permissions', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ) ),
		'image' => 'service-access-control',
		'alt'   => __( 'Access card being tapped on a door reader', 'gorilla-security' ),
		'cards' => array(
			array(
				'size'  => 'lg',
				'pos'   => 'bl',
				'icon'  => 'lock',
				'title' => __( 'Secure Access', 'gorilla-security' ),
				'text'  => __( 'Control who enters your property with card, PIN or biometric access', 'gorilla-security' ),
			),
		),
	),
	array(
		'tab'   => __( 'Smart Locks', 'gorilla-security' ),
		'icon'  => 'lock',
		'title' => __( '[[Smart]] Locks', 'gorilla-security' ),
		'text'  => __( 'Upgrade your security with smart locks that offer keyless, convenient and secure access for your home or business. Control and monitor your doors from anywhere, anytime.', 'gorilla-security' ),
		'list'  => array( __( 'Keyless Entry', 'gorilla-security' ), __( 'Access Logs & Monitoring', 'gorilla-security' ), __( 'Remote Lock & Unlock', 'gorilla-security' ), __( 'Multiple User Access', 'gorilla-security' ), __( 'Mobile App Control', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ) ),
		'image' => 'service-smart-locks',
		'alt'   => __( 'Smart lock on a front door', 'gorilla-security' ),
		'cards' => array(
			array(
				'size' => 'sm',
				'pos'  => 'tr',
				'icon' => 'users',
				'text' => __( 'Give access to family, staff or guests with ease.', 'gorilla-security' ),
			),
			array(
				'size' => 'sm',
				'pos'  => 'bc',
				'icon' => 'lock',
				'text' => __( 'Control your doors from anywhere, anytime.', 'gorilla-security' ),
			),
		),
	),
	array(
		'tab'   => __( 'Smart Home', 'gorilla-security' ),
		'icon'  => 'smart-home',
		'title' => __( '[[Smart]] Home', 'gorilla-security' ),
		'text'  => __( 'Create a smarter, safer and more connected home with our smart home solutions. Control your security, lighting, climate and more — all from one app, anytime, anywhere.', 'gorilla-security' ),
		'list'  => array( __( 'Centralised Control', 'gorilla-security' ), __( 'Enhanced Security', 'gorilla-security' ), __( 'Smart Lighting', 'gorilla-security' ), __( 'Home Automation', 'gorilla-security' ), __( 'Climate Control', 'gorilla-security' ), __( 'Remote Access', 'gorilla-security' ) ),
		'image' => 'service-smart-home',
		'alt'   => __( 'Living room with smart lighting and a wall control panel', 'gorilla-security' ),
		'cards' => array(
			array(
				'size' => 'sm',
				'pos'  => 'tr',
				'icon' => 'lightbulb',
				'text' => __( 'Control your lights from anywhere', 'gorilla-security' ),
			),
			array(
				'size' => 'sm',
				'pos'  => 'bl',
				'icon' => 'home-shield',
				'text' => __( 'Monitor and protect your home in real time', 'gorilla-security' ),
			),
		),
	),
);

// Panel anchors: footer service links and #hash URLs open the matching tab (gorilla.js). Keyed by panel icon.
$gs_anchors = array(
	'cctv'        => 'cctv-systems',
	'bell'        => 'alarm-systems',
	'intercom'    => 'intercom-systems',
	'access-card' => 'access-control',
	'lock'        => 'smart-locks',
	'smart-home'  => 'smart-home',
);

$gs   = array();
$gs[] = gs_group_open(
	'gs-section gs-services',
	array(
		'tag'    => 'section',
		'align'  => 'full',
		'anchor' => 'services',
	)
);
$gs[] = gs_eyebrow( __( 'OUR SECURITY SOLUTIONS', 'gorilla-security' ) );
$gs[] = gs_group_open(
	'gs-tabs',
	array(
		'align'  => 'wide',
		'layout' => array( 'type' => 'default' ),
	)
);

$gs_nav = '<div class="gs-tabs__nav" id="gs-services-tablist">';
foreach ( $gs_panels as $gs_panel ) {
	$gs_nav .= '<button type="button" class="gs-tabs__tab gs-ico-' . esc_attr( $gs_panel['icon'] ) . '">' . esc_html( $gs_panel['tab'] ) . '</button>';
}
$gs[] = "<!-- wp:html -->\n" . $gs_nav . "</div>\n<!-- /wp:html -->";

foreach ( $gs_panels as $gs_panel ) {
	$gs[] = gs_group_open(
		'gs-tabs__panel',
		array(
			'anchor' => $gs_anchors[ $gs_panel['icon'] ],
			'layout' => array( 'type' => 'default' ),
		)
	);
	$gs[] = gs_columns_open( 'gs-service' );

	$gs[] = gs_column_open( 'gs-service__text' );
	$gs[] = gs_heading(
		$gs_panel['title'],
		array(
			'size'  => 'h2-xl',
			'class' => 'gs-service__title',
		)
	);
	$gs[] = gs_paragraph( $gs_panel['text'], '', 'lead' );
	$gs[] = gs_list( $gs_panel['list'], 'checklist' );
	// Buttons + previous/next service arrows (Figma 1:162); the arrows only show once tabs are enhanced.
	$gs[] = gs_group_open(
		'gs-service__actions',
		array(
			'layout' => array(
				'type'              => 'flex',
				'flexWrap'          => 'wrap',
				'verticalAlignment' => 'center',
			),
		)
	)
		. gs_buttons(
			array(
				gs_button(
					__( 'Know More', 'gorilla-security' ),
					$gs_home . '#faq',
					'',
					'',
					/* translators: %s: service name. */
					sprintf( __( ' about %s in our FAQs', 'gorilla-security' ), $gs_panel['tab'] )
				),
				gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote', 'outline' ),
			)
		)
		. gs_arrows(
			'gs-services-tablist',
			array(
				'prev' => __( 'Previous service', 'gorilla-security' ),
				'next' => __( 'Next service', 'gorilla-security' ),
			)
		)
		. gs_group_close();
	$gs[] = "</div>\n<!-- /wp:column -->";

	$gs[] = gs_column_open( 'gs-service__media' );
	$gs[] = gs_image( $gs_panel['image'], $gs_panel['alt'], '', array( 'class' => 'gs-photo gs-service__photo' ) );
	foreach ( $gs_panel['cards'] as $gs_card ) {
		$gs[] = gs_group_open( 'gs-float-card gs-float-card--' . $gs_card['size'] . ' gs-float-card--' . $gs_card['pos'], array( 'layout' => array( 'type' => 'default' ) ) );
		if ( ! empty( $gs_card['image'] ) ) {
			$gs[] = gs_image( $gs_card['image'], '', '', array( 'class' => 'gs-float-card__media' ) );
		} else {
			$gs[] = gs_icon( $gs_card['icon'], 'lg' === $gs_card['size'] ? '' : 'md' );
		}
		$gs[] = gs_group_open( 'gs-float-card__text', array( 'layout' => array( 'type' => 'default' ) ) );
		if ( ! empty( $gs_card['title'] ) ) {
			$gs[] = gs_paragraph( $gs_card['title'], '', '', 'gs-float-card__title' );
		}
		$gs[] = gs_paragraph( $gs_card['text'] );
		if ( ! empty( $gs_card['devices'] ) ) {
			$gs[] = gs_group_open(
				'gs-float-card__devices',
				array(
					'layout' => array(
						'type'     => 'flex',
						'flexWrap' => 'nowrap',
					),
				)
			)
				. gs_icon( 'smartphone', 'sm' ) . gs_icon( 'tablet', 'sm' ) . gs_icon( 'laptop', 'sm' )
				. gs_group_close();
		}
		$gs[] = gs_group_close();
		$gs[] = gs_group_close();
	}
	$gs[] = "</div>\n<!-- /wp:column -->";

	$gs[] = "</div>\n<!-- /wp:columns -->";
	$gs[] = gs_group_close();
}

$gs[] = gs_group_close();
$gs[] = gs_group_close( 'section' );

echo wp_kses_post( implode( "\n", $gs ) );
