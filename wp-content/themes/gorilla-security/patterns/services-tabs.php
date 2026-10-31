<?php
/**
 * Title: Services (tabs)
 * Slug: gorilla-security/services-tabs
 * Categories: gorilla-sections
 * Keywords: services, tabs, cctv, alarm, intercom, access control, smart locks, smart home
 *
 * Figma 1:162 (variants 1:984, 1:907, 1:816, 1:733, 1:642, 1:550) — a tab bar and one panel
 * per service: title, text, checklist, buttons, photo with floating cards. gorilla.js turns
 * the bar into WAI-ARIA tabs with prev/next arrows. Without JS the bar is a list of jump
 * links and every panel shows, one after another.
 *
 * @package gorilla-security
 */

/*
 * One entry per service. Copy is verbatim from Figma (incl. "Intercoms Systems" and
 * "card, PIN biometric access"). Cards: thumb = image name, icon = gs-ico name,
 * mod = gs-float-card modifiers (top, start, center, thumb, pop), devices = device icon row.
 */
$gsec_services = array(
	array(
		'id'    => 'cctv',
		'tab'   => __( 'CCTV Systems', 'gorilla-security' ),
		'icon'  => 'cctv',
		'title' => __( '[[CCTV]] Systems', 'gorilla-security' ),
		'text'  => __( 'Keep an eye on what matters with reliable, high-quality CCTV surveillance solutions for homes and businesses. Our systems are designed to provide clear video, remote access and complete peace of mind.', 'gorilla-security' ),
		'items' => array(
			__( 'High-Definition Video', 'gorilla-security' ),
			__( 'Professional Installation', 'gorilla-security' ),
			__( 'Remote Viewing', 'gorilla-security' ),
			__( 'Reliable & Secure', 'gorilla-security' ),
			__( 'Indoor & Outdoor Options', 'gorilla-security' ),
			__( 'Ongoing Support', 'gorilla-security' ),
		),
		'photo' => array( 'service-cctv', __( 'Outdoor CCTV camera mounted on the wall of a modern home', 'gorilla-security' ) ),
		'cards' => array(
			array(
				'thumb'   => 'service-cctv-live',
				'mod'     => 'thumb',
				'title'   => __( 'Live Monitoring', 'gorilla-security' ),
				'text'    => __( 'View your property in real time from anywhere, on any device', 'gorilla-security' ),
				'devices' => true,
			),
		),
	),
	array(
		'id'    => 'alarm',
		'tab'   => __( 'Alarm Systems', 'gorilla-security' ),
		'icon'  => 'bell',
		'title' => __( '[[Alarm]] Systems', 'gorilla-security' ),
		'text'  => __( 'Get instant protection with professionally installed alarm systems for homes and businesses. Our solutions help detect intrusions, alert you immediately and keep your property and loved ones safe.', 'gorilla-security' ),
		'items' => array(
			__( '24/7 Monitoring Options', 'gorilla-security' ),
			__( 'Professional Installation', 'gorilla-security' ),
			__( 'Intrusion Detection', 'gorilla-security' ),
			__( 'Mobile App Control', 'gorilla-security' ),
			__( 'Reliable & Secure', 'gorilla-security' ),
			__( 'Instant Alerts', 'gorilla-security' ),
		),
		'photo' => array( 'service-alarm', __( 'Ceiling-mounted alarm sensor in a bright living area', 'gorilla-security' ) ),
		'cards' => array(
			array(
				'thumb' => 'service-alarm-phone',
				'mod'   => 'start pop',
				'title' => __( 'Instant Alerts', 'gorilla-security' ),
				'text'  => __( 'Get real-time notifications on your phone, wherever you are.', 'gorilla-security' ),
			),
		),
	),
	array(
		'id'    => 'intercom',
		'tab'   => __( 'Intercoms', 'gorilla-security' ),
		'icon'  => 'intercom',
		'title' => __( '[[Intercoms]] Systems', 'gorilla-security' ),
		'text'  => __( 'See, speak and grant access to visitors with modern intercom systems for homes and businesses. Our solutions offer clear communication, enhanced security and greater peace of mind.', 'gorilla-security' ),
		'items' => array(
			__( 'Video & Audio Communication', 'gorilla-security' ),
			__( 'Mobile App Integration', 'gorilla-security' ),
			__( 'Professional Installation', 'gorilla-security' ),
			__( 'HD Video Clarity', 'gorilla-security' ),
			__( 'Remote Door Access', 'gorilla-security' ),
			__( 'Reliable & Secure', 'gorilla-security' ),
		),
		'photo' => array( 'service-intercom', __( 'Video intercom panel beside a front door, showing a visitor', 'gorilla-security' ) ),
		'cards' => array(
			array(
				'icon' => 'video',
				'mod'  => 'top',
				'text' => __( 'Talk to visitors in real time from anywhere', 'gorilla-security' ),
			),
			array(
				'icon' => 'lock',
				'text' => __( 'Unlock the door remotely with just a tap', 'gorilla-security' ),
			),
		),
	),
	array(
		'id'    => 'access',
		'tab'   => __( 'Access Control', 'gorilla-security' ),
		'icon'  => 'access',
		'title' => __( '[[Access]] Control', 'gorilla-security' ),
		'text'  => __( 'Manage and control access to your property with modern access control systems for homes and businesses. Our solutions provide secure, convenient and flexible entry management.', 'gorilla-security' ),
		'items' => array(
			__( 'Secure Entry Management', 'gorilla-security' ),
			__( 'Professional Installation', 'gorilla-security' ),
			__( 'Card, PIN & Biometric Access', 'gorilla-security' ),
			__( 'Remote Management', 'gorilla-security' ),
			__( 'Custom Access Permissions', 'gorilla-security' ),
			__( 'Reliable & Secure', 'gorilla-security' ),
		),
		'photo' => array( 'service-access', __( 'Keypad and card reader beside a glass office door', 'gorilla-security' ) ),
		'cards' => array(
			array(
				'icon'  => 'lock',
				'mod'   => 'start',
				'title' => __( 'Secure Access', 'gorilla-security' ),
				'text'  => __( 'Control who enters your property with card, PIN biometric access', 'gorilla-security' ),
			),
		),
	),
	array(
		'id'    => 'locks',
		'tab'   => __( 'Smart Locks', 'gorilla-security' ),
		'icon'  => 'lock',
		'title' => __( '[[Smart]] Locks', 'gorilla-security' ),
		'text'  => __( 'Upgrade your security with smart locks that offer keyless, convenient and secure access for your home or business. Control and monitor your doors from anywhere, anytime.', 'gorilla-security' ),
		'items' => array(
			__( 'Keyless Entry', 'gorilla-security' ),
			__( 'Access Logs & Monitoring', 'gorilla-security' ),
			__( 'Remote Lock & Unlock', 'gorilla-security' ),
			__( 'Multiple User Access', 'gorilla-security' ),
			__( 'Mobile App Control', 'gorilla-security' ),
			__( 'Reliable & Secure', 'gorilla-security' ),
		),
		'photo' => array( 'service-locks', __( 'Smart lock with keypad on a timber door, and its phone app', 'gorilla-security' ) ),
		'cards' => array(
			array(
				'icon' => 'users',
				'mod'  => 'top',
				'text' => __( 'Give access to family, staff or guests with ease.', 'gorilla-security' ),
			),
			array(
				'icon' => 'lock',
				'mod'  => 'center',
				'text' => __( 'Control your doors from anywhere, anytime.', 'gorilla-security' ),
			),
		),
	),
	array(
		'id'    => 'home',
		'tab'   => __( 'Smart Home', 'gorilla-security' ),
		'icon'  => 'smart-home',
		'title' => __( '[[Smart]] Home', 'gorilla-security' ),
		'text'  => __( 'Create a smarter, safer and more connected home with our smart home solutions. Control your security, lighting, climate and more — all from one app, anytime, anywhere.', 'gorilla-security' ),
		'items' => array(
			__( 'Centralised Control', 'gorilla-security' ),
			__( 'Enhanced Security', 'gorilla-security' ),
			__( 'Smart Lighting', 'gorilla-security' ),
			__( 'Home Automation', 'gorilla-security' ),
			__( 'Climate Control', 'gorilla-security' ),
			__( 'Remote Access', 'gorilla-security' ),
		),
		'photo' => array( 'service-home', __( 'Hand tapping a smart home touch panel on a living room wall', 'gorilla-security' ) ),
		'cards' => array(
			array(
				'icon' => 'bulb',
				'mod'  => 'top',
				'text' => __( 'Control your lights from anywhere', 'gorilla-security' ),
			),
			array(
				'icon' => 'shield',
				'mod'  => 'center',
				'text' => __( 'Monitor and protect your home in real time', 'gorilla-security' ),
			),
		),
	),
);

/**
 * Floating card over a service photo (Figma 1:1051). Empty parts are not output.
 *
 * @param array $card thumb, icon, mod, title, text, devices.
 * @return string Block markup.
 */
$gsec_float_card = static function ( $card ) {
	$card    = wp_parse_args(
		$card,
		array(
			'thumb'   => '',
			'icon'    => '',
			'mod'     => '',
			'title'   => '',
			'text'    => '',
			'devices' => false,
		)
	);
	$classes = 'gs-float-card';
	foreach ( array_filter( explode( ' ', $card['mod'] ) ) as $mod ) {
		$classes .= ' gs-float-card--' . sanitize_html_class( $mod );
	}

	$body = gsec_heading(
		$card['title'],
		array(
			'level' => 3,
			'size'  => 'card-title',
			'class' => 'gs-float-card__title',
		)
	);
	if ( '' !== $card['text'] ) {
		$body .= "\n" . '<!-- wp:paragraph {"className":"gs-float-card__text","fontSize":"base"} -->' . "\n"
			. '<p class="gs-float-card__text has-base-font-size">' . esc_html( $card['text'] ) . '</p>' . "\n"
			. '<!-- /wp:paragraph -->';
	}
	if ( $card['devices'] ) {
		$body .= "\n" . '<!-- wp:group {"className":"gs-float-card__devices","layout":{"type":"default"}} -->' . "\n"
			. '<div class="wp-block-group gs-float-card__devices">'
			. gsec_icon( 'mobile', 'sm' ) . gsec_icon( 'tablet', 'sm' ) . gsec_icon( 'laptop', 'sm' )
			. '</div>' . "\n" . '<!-- /wp:group -->';
	}

	return '<!-- wp:group {"className":"' . esc_attr( $classes ) . '","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group ' . esc_attr( $classes ) . '">'
		. ( $card['thumb'] ? gsec_image( $card['thumb'] ) : '' )
		. ( $card['icon'] ? gsec_icon( $card['icon'], 'sm' ) : '' )
		. '<!-- wp:group {"className":"gs-float-card__body","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-float-card__body">' . $body . '</div>' . "\n"
		. '<!-- /wp:group --></div>' . "\n"
		. '<!-- /wp:group -->';
};

ob_start();
?>
<!-- wp:group {"tagName":"section","anchor":"services","align":"full","className":"gs-services gs-tabs","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-services gs-tabs" id="services"><!-- wp:group {"align":"wide","className":"gs-services__inner","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide gs-services__inner">
<?php echo gsec_eyebrow( __( 'OUR SECURITY SOLUTIONS', 'gorilla-security' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below. ?>

<!-- wp:list {"className":"gs-tabs__nav"} -->
<ul class="wp-block-list gs-tabs__nav">
<?php foreach ( $gsec_services as $gsec_service ) : ?>
<!-- wp:list-item {"className":"gs-ico-<?php echo esc_attr( $gsec_service['icon'] ); ?>"} -->
<li class="gs-ico-<?php echo esc_attr( $gsec_service['icon'] ); ?>"><a href="#service-<?php echo esc_attr( $gsec_service['id'] ); ?>"><?php echo esc_html( $gsec_service['tab'] ); ?></a></li>
<!-- /wp:list-item -->
<?php endforeach; ?>
</ul>
<!-- /wp:list -->

<?php foreach ( $gsec_services as $gsec_service ) : ?>
<!-- wp:group {"anchor":"service-<?php echo esc_attr( $gsec_service['id'] ); ?>","className":"gs-tabs__panel gs-service","layout":{"type":"default"}} -->
<div class="wp-block-group gs-tabs__panel gs-service" id="service-<?php echo esc_attr( $gsec_service['id'] ); ?>"><!-- wp:columns {"className":"gs-service__cols"} -->
<div class="wp-block-columns gs-service__cols"><!-- wp:column {"width":"42%","className":"gs-service__body"} -->
<div class="wp-block-column gs-service__body" style="flex-basis:42%">
	<?php
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
	echo gsec_heading( $gsec_service['title'], array( 'class' => 'gs-service__title' ) );
	echo gsec_paragraph( $gsec_service['text'], '', 'lead' );
	// phpcs:enable
	?>

<!-- wp:list {"className":"is-style-checklist"} -->
<ul class="wp-block-list is-style-checklist">
	<?php foreach ( $gsec_service['items'] as $gsec_item ) : ?>
<!-- wp:list-item -->
<li><?php echo esc_html( $gsec_item ); ?></li>
<!-- /wp:list-item -->
<?php endforeach; ?>
</ul>
<!-- /wp:list -->

<!-- wp:group {"className":"gs-service__actions","layout":{"type":"default"}} -->
<div class="wp-block-group gs-service__actions">
	<?php
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
	echo gsec_buttons(
		array(
			gsec_button( __( 'Know More', 'gorilla-security' ), home_url( '/services/' ) ),
			gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), 'outline' ),
		)
	);
	echo gsec_arrows( 'services' );
	// phpcs:enable
	?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%","className":"gs-service__media"} -->
<div class="wp-block-column gs-service__media" style="flex-basis:58%">
	<?php
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
	echo gsec_image( $gsec_service['photo'][0], $gsec_service['photo'][1] );
	foreach ( $gsec_service['cards'] as $gsec_card ) {
		echo $gsec_float_card( $gsec_card );
	}
	// phpcs:enable
	?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
<?php
echo wp_kses_post( ob_get_clean() );
