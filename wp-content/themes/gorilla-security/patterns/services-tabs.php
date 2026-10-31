<?php
/**
 * Title: Services (tabs)
 * Slug: gorilla-security/services-tabs
 * Categories: gorilla-sections
 * Keywords: services, tabs, cctv, alarm, intercom, access control, locks, smart home
 *
 * Figma 1:162 (instance) — tab bar I1:162;1:1079, six panels (layer order is the reverse of the tab
 * bar: CCTV 1:984 … Smart Home 1:550), background 1:985, feature card 1:1051, notes 1:616…,
 * arrows 1:1043. Anchor #services (About's "Know More").
 * Without JS the tab bar is a list of jump links to stacked panels; gorilla.js turns it into an
 * ARIA tablist (arrow keys, Home/End, prev/next buttons). "Know More" goes to the contact page until service pages exist.
 *
 * @package gorilla-security
 */

$gorilla_services = array(
	array(
		'slug'  => 'cctv',
		'icon'  => 'cctv',
		'tab'   => __( 'CCTV Systems', 'gorilla-security' ),
		'title' => __( '[[CCTV]] Systems', 'gorilla-security' ),
		'text'  => __( 'Keep an eye on what matters with reliable, high-quality CCTV surveillance solutions for homes and businesses. Our systems are designed to provide clear video, remote access and complete peace of mind.', 'gorilla-security' ),
		'list'  => array( __( 'High-Definition Video', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'Remote Viewing', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ), __( 'Indoor & Outdoor Options', 'gorilla-security' ), __( 'Ongoing Support', 'gorilla-security' ) ),
		'card'  => array(
			'image' => 'service-cctv-live',
			'title' => __( 'Live Monitoring', 'gorilla-security' ),
			'text'  => __( 'View your property in real time from anywhere, on any device', 'gorilla-security' ),
			'icons' => array( 'smartphone', 'chip', 'laptop' ),
		),
	),
	array(
		'slug'  => 'alarm',
		'icon'  => 'bell',
		'tab'   => __( 'Alarm Systems', 'gorilla-security' ),
		'title' => __( '[[Alarm]] Systems', 'gorilla-security' ),
		'text'  => __( 'Get instant protection with professionally installed alarm systems for homes and businesses. Our solutions help detect intrusions, alert you immediately and keep your property and loved ones safe.', 'gorilla-security' ),
		'list'  => array( __( '24/7 Monitoring Options', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'Intrusion Detection', 'gorilla-security' ), __( 'Mobile App Control', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ), __( 'Instant Alerts', 'gorilla-security' ) ),
		'notes' => array( array( 'bell', __( 'Instant Alerts', 'gorilla-security' ), __( 'Get real-time notifications on your phone, wherever you are.', 'gorilla-security' ) ) ),
	),
	array(
		'slug'  => 'intercom',
		'icon'  => 'intercom',
		'tab'   => __( 'Intercoms', 'gorilla-security' ),
		'title' => __( '[[Intercom]] Systems', 'gorilla-security' ),
		'text'  => __( 'See, speak and grant access to visitors with modern intercom systems for homes and businesses. Our solutions offer clear communication, enhanced security and greater peace of mind.', 'gorilla-security' ),
		'list'  => array( __( 'Video & Audio Communication', 'gorilla-security' ), __( 'Mobile App Integration', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'HD Video Clarity', 'gorilla-security' ), __( 'Remote Door Access', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ) ),
		'notes' => array( array( 'smartphone', '', __( 'Talk to visitors in real time from anywhere', 'gorilla-security' ) ), array( 'lock', '', __( 'Unlock the door remotely with just a tap', 'gorilla-security' ) ) ),
	),
	array(
		'slug'  => 'access',
		'icon'  => 'access-card',
		'tab'   => __( 'Access Control', 'gorilla-security' ),
		'title' => __( '[[Access]] Control', 'gorilla-security' ),
		'text'  => __( 'Manage and control access to your property with modern access control systems for homes and businesses. Our solutions provide secure, convenient and flexible entry management.', 'gorilla-security' ),
		'list'  => array( __( 'Secure Entry Management', 'gorilla-security' ), __( 'Professional Installation', 'gorilla-security' ), __( 'Card, PIN & Biometric Access', 'gorilla-security' ), __( 'Remote Management', 'gorilla-security' ), __( 'Custom Access Permissions', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ) ),
		'notes' => array( array( 'access-card', __( 'Secure Access', 'gorilla-security' ), __( 'Control who enters your property with card, PIN or biometric access', 'gorilla-security' ) ) ),
	),
	array(
		'slug'  => 'locks',
		'icon'  => 'lock',
		'tab'   => __( 'Smart Locks', 'gorilla-security' ),
		'title' => __( '[[Smart]] Locks', 'gorilla-security' ),
		'text'  => __( 'Upgrade your security with smart locks that offer keyless, convenient and secure access for your home or business. Control and monitor your doors from anywhere, anytime.', 'gorilla-security' ),
		'list'  => array( __( 'Keyless Entry', 'gorilla-security' ), __( 'Access Logs & Monitoring', 'gorilla-security' ), __( 'Remote Lock & Unlock', 'gorilla-security' ), __( 'Multiple User Access', 'gorilla-security' ), __( 'Mobile App Control', 'gorilla-security' ), __( 'Reliable & Secure', 'gorilla-security' ) ),
		'notes' => array( array( 'access-card', '', __( 'Give access to family, staff or guests with ease.', 'gorilla-security' ) ), array( 'lock', '', __( 'Control your doors from anywhere, anytime.', 'gorilla-security' ) ) ),
	),
	array(
		'slug'  => 'home',
		'icon'  => 'smart-home',
		'tab'   => __( 'Smart Home', 'gorilla-security' ),
		'title' => __( '[[Smart]] Home', 'gorilla-security' ),
		'text'  => __( 'Create a smarter, safer and more connected home with our smart home solutions. Control your security, lighting, climate and more — all from one app, anytime, anywhere.', 'gorilla-security' ),
		'list'  => array( __( 'Centralised Control', 'gorilla-security' ), __( 'Enhanced Security', 'gorilla-security' ), __( 'Smart Lighting', 'gorilla-security' ), __( 'Home Automation', 'gorilla-security' ), __( 'Climate Control', 'gorilla-security' ), __( 'Remote Access', 'gorilla-security' ) ),
		'notes' => array( array( 'lightbulb', '', __( 'Control your lights from anywhere', 'gorilla-security' ) ), array( 'shield', '', __( 'Monitor and protect your home in real time', 'gorilla-security' ) ) ),
	),
);

/**
 * Small floating note on a service photo (Figma 1:616): icon circle, rule, optional title, text.
 *
 * @param array $note { 0: icon, 1: title, 2: text }.
 * @return string
 */
$gorilla_note = static function ( $note ) {
	$title = $note[1] ? "\n" . gorilla_heading(
		$note[1],
		array(
			'level' => 3,
			'size'  => 'card-title',
			'class' => 'gs-service-note__title',
		)
	) : '';
	return "<!-- wp:group {\"className\":\"gs-service-note\",\"layout\":{\"type\":\"flex\",\"flexWrap\":\"nowrap\"}} -->\n"
		. '<div class="wp-block-group gs-service-note">' . gorilla_icon( $note[0], 'md' ) . "\n\n"
		. "<!-- wp:group {\"className\":\"gs-service-note__body\",\"layout\":{\"type\":\"default\"}} -->\n"
		. '<div class="wp-block-group gs-service-note__body">' . $title . "\n" . gorilla_paragraph( $note[2], '', 'small' ) . "</div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->";
};
?>
<!-- wp:group {"anchor":"services","align":"full","className":"gs-services","layout":{"type":"constrained"}} -->
<div id="services" class="wp-block-group alignfull gs-services">
<?php echo wp_kses_post( gorilla_eyebrow( __( 'OUR SECURITY SOLUTIONS', 'gorilla-security' ) ) ); ?>

<!-- wp:html -->
<nav class="gs-tabs__nav alignwide" aria-label="<?php echo esc_attr__( 'Security solutions', 'gorilla-security' ); ?>"><ul class="gs-tabs__list">
<?php foreach ( $gorilla_services as $gorilla_i => $gorilla_s ) : ?>
<li><a class="gs-tabs__tab gs-ico-<?php echo esc_attr( $gorilla_s['icon'] ); ?><?php echo 0 === $gorilla_i ? ' is-active' : ''; ?>" href="#service-<?php echo esc_attr( $gorilla_s['slug'] ); ?>"><?php echo esc_html( $gorilla_s['tab'] ); ?></a></li>
<?php endforeach; ?>
</ul></nav>
<!-- /wp:html -->

<!-- wp:group {"align":"wide","className":"gs-tabs__panels","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide gs-tabs__panels">
<?php
foreach ( $gorilla_services as $gorilla_i => $gorilla_s ) :
	$gorilla_photo = gorilla_image( 'service-' . $gorilla_s['slug'], '', '', array( 'class' => 'gs-service__photo' ) );
	$gorilla_extra = '';
	if ( ! empty( $gorilla_s['card'] ) ) {
		$gorilla_card_icons = implode( "\n\n", array_map( 'gorilla_icon', $gorilla_s['card']['icons'], array_fill( 0, count( $gorilla_s['card']['icons'] ), 'md' ) ) );
		$gorilla_extra      = "<!-- wp:group {\"className\":\"gs-service-card\",\"layout\":{\"type\":\"flex\",\"flexWrap\":\"nowrap\"}} -->\n"
			. '<div class="wp-block-group gs-service-card">' . gorilla_image( $gorilla_s['card']['image'], '', '', array( 'class' => 'gs-service-card__photo' ) ) . "\n\n"
			. "<!-- wp:group {\"className\":\"gs-service-card__body\",\"layout\":{\"type\":\"default\"}} -->\n"
			. '<div class="wp-block-group gs-service-card__body">'
			. gorilla_heading(
				$gorilla_s['card']['title'],
				array(
					'level' => 3,
					'size'  => 'card-title',
				)
			) . "\n" . gorilla_paragraph( $gorilla_s['card']['text'], '', 'small' ) . "\n"
			. "<!-- wp:group {\"className\":\"gs-service-card__icons\",\"layout\":{\"type\":\"flex\",\"flexWrap\":\"nowrap\"}} -->\n"
			. '<div class="wp-block-group gs-service-card__icons">' . $gorilla_card_icons . "</div>\n<!-- /wp:group --></div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->";
	} elseif ( ! empty( $gorilla_s['notes'] ) ) {
		$gorilla_extra = implode( "\n\n", array_map( $gorilla_note, $gorilla_s['notes'] ) );
	}
	$gorilla_items = implode(
		"\n\n",
		array_map(
			static function ( $item ) {
				return "<!-- wp:list-item -->\n<li>" . esc_html( $item ) . "</li>\n<!-- /wp:list-item -->";
			},
			$gorilla_s['list']
		)
	);
	?>
<!-- wp:group {"anchor":"service-<?php echo esc_attr( $gorilla_s['slug'] ); ?>","className":"gs-tabs__panel<?php echo 0 === $gorilla_i ? ' is-active' : ''; ?>","layout":{"type":"default"}} -->
<div id="service-<?php echo esc_attr( $gorilla_s['slug'] ); ?>" class="wp-block-group gs-tabs__panel<?php echo 0 === $gorilla_i ? ' is-active' : ''; ?>"><!-- wp:columns {"className":"gs-service"} -->
<div class="wp-block-columns gs-service"><!-- wp:column {"className":"gs-service__text"} -->
<div class="wp-block-column gs-service__text">
	<?php
	echo wp_kses_post(
		gorilla_heading(
			$gorilla_s['title'],
			array(
				'size'  => 'h2-xl',
				'class' => 'gs-service__title',
			)
		)
	);
	echo wp_kses_post( gorilla_paragraph( $gorilla_s['text'], '', 'lead' ) );
	?>

<!-- wp:list {"className":"is-style-checklist gs-service__list"} -->
<ul class="wp-block-list is-style-checklist gs-service__list"><?php echo wp_kses_post( $gorilla_items ); ?></ul>
<!-- /wp:list -->

<!-- wp:group {"className":"gs-service__actions","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-service__actions"><?php echo wp_kses_post( gorilla_buttons( array( gorilla_button( __( 'Know More', 'gorilla-security' ), home_url( '/contact-us/' ) ), gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), 'outline' ) ) ) ); ?>

	<?php echo wp_kses_post( gorilla_arrows( 'services' ) ); ?></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

	<?php if ( $gorilla_photo ) : ?>
<!-- wp:column {"className":"gs-service__media"} -->
<div class="wp-block-column gs-service__media"><?php echo wp_kses_post( $gorilla_photo . "\n\n" . $gorilla_extra ); ?></div>
<!-- /wp:column -->
	<?php endif; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
