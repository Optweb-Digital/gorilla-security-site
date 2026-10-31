<?php
/**
 * Title: Footer
 * Slug: gorilla-security/footer
 * Categories: gorilla-sections
 * Keywords: footer, contact, links, hours, social
 * Block Types: core/template-part/footer
 *
 * Figma 1:426 — photo 1:428 with fades 1:429 / 1:430, logo 1:501, badge 1:507, tagline 1:431,
 * Get A Quote 1:504, social 1:450 / 1:451, services 1:432, quick links 1:441, contact list 1:469,
 * hours 1:485, rule 1:499 and copyright 1:500.
 * Phone, email, address, hours and social come from gorilla_site(); each is only output once
 * confirmed (project-context). Blog and Area link to /blog/ and /area/
 * (pages still to be created).
 *
 * @package gorilla-security
 */

$gorilla_bg      = gorilla_img( 'footer-bg' );
$gorilla_name    = gorilla_site( 'name' );
$gorilla_phone   = gorilla_site( 'phone' );
$gorilla_email   = gorilla_site( 'email' );
$gorilla_address = gorilla_site( 'address' );
$gorilla_hours   = array_filter(
	(array) gorilla_site( 'hours' ),
	static function ( $row ) {
		return ! empty( $row['days'] ) && ! empty( $row['time'] );
	}
);

$gorilla_social = array_filter( (array) gorilla_site( 'social' ) );

$gorilla_services = array(
	'cctv'     => __( 'CCTV Systems', 'gorilla-security' ),
	'alarm'    => __( 'Alarm System', 'gorilla-security' ),
	'intercom' => __( 'Intercom System', 'gorilla-security' ),
	'access'   => __( 'Access Control System', 'gorilla-security' ),
	'locks'    => __( 'Smart Lock Installation', 'gorilla-security' ),
	'home'     => __( 'Smart Home Installation', 'gorilla-security' ),
);

$gorilla_links = array(
	array( __( 'Home', 'gorilla-security' ), home_url( '/' ) ),
	array( __( 'About Us', 'gorilla-security' ), home_url( '/#about' ) ),
	array( __( 'Blog', 'gorilla-security' ), home_url( '/blog/' ) ),
	array( __( 'Area', 'gorilla-security' ), home_url( '/area/' ) ),
	array( __( 'Contact Us', 'gorilla-security' ), home_url( '/contact-us/' ) ),
	array( __( 'FAQs', 'gorilla-security' ), home_url( '/#faq' ) ),
);

$gorilla_service_links = array();
foreach ( $gorilla_services as $gorilla_slug => $gorilla_label ) {
	$gorilla_service_links[] = array( $gorilla_label, home_url( '/#service-' . $gorilla_slug ) );
}

$gorilla_contact = array_filter(
	array(
		'phone'   => $gorilla_phone ? '<a href="' . esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $gorilla_phone ) ) . '">' . esc_html( $gorilla_phone ) . '</a>' : '',
		'mail'    => $gorilla_email ? '<a href="' . esc_url( 'mailto:' . $gorilla_email ) . '">' . esc_html( $gorilla_email ) . '</a>' : '',
		'map-pin' => $gorilla_address ? esc_html( $gorilla_address ) : '',
	)
);

/**
 * Core list block of links (or HTML items when $items are strings keyed by icon).
 *
 * @param array  $items      [ label, url ] pairs, or icon => HTML.
 * @param string $class_name List class.
 * @return string
 */
$gorilla_list = static function ( $items, $class_name ) {
	$lis = array();
	foreach ( $items as $key => $item ) {
		$html  = is_array( $item ) ? '<a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a>' : $item;
		$class = is_array( $item ) ? '' : 'gs-ico-' . sanitize_html_class( $key );
		$lis[] = gorilla_block_open( 'list-item', array( 'className' => $class ) ) . "\n<li" . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '>' . $html . "</li>\n<!-- /wp:list-item -->";
	}
	return gorilla_block_open( 'list', array( 'className' => $class_name ) ) . "\n"
		. '<ul class="wp-block-list ' . esc_attr( $class_name ) . '">' . implode( "\n\n", $lis ) . "</ul>\n<!-- /wp:list -->";
};

/**
 * Column title (h2, Figma 20px medium with a 160px brand rule).
 *
 * @param string $text Title.
 * @return string
 */
$gorilla_title = static function ( $text ) {
	return gorilla_heading(
		$text,
		array(
			'size'  => 'lead',
			'class' => 'gs-footer__title',
		)
	);
};

$gorilla_cover_attrs = array(
	'url'                => $gorilla_bg,
	'dimRatio'           => $gorilla_bg ? 0 : 100,
	'overlayColor'       => 'night',
	'isUserOverlayColor' => true,
	'align'              => 'full',
	'className'          => 'gs-footer',
	'layout'             => array( 'type' => 'default' ),
);

// Whole cover through kses at once — a lone opener would be re-serialized as void (rules-log 008).
ob_start();
?>
<div class="wp-block-cover alignfull gs-footer">
<?php if ( $gorilla_bg ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gorilla_bg ); ?>" data-object-fit="cover"/>
<?php endif; ?>
<span aria-hidden="true" class="wp-block-cover__background has-night-background-color has-background-dim-<?php echo esc_attr( $gorilla_bg ? 0 : 100 ); ?> has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"gs-footer__main","layout":{"type":"default"}} -->
<div class="wp-block-group gs-footer__main"><!-- wp:group {"className":"gs-footer__brand","layout":{"type":"default"}} -->
<div class="wp-block-group gs-footer__brand"><!-- wp:group {"className":"gs-footer__logos","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-footer__logos">
<?php
echo wp_kses_post(
	gorilla_image(
		'logo',
		/* translators: %s: site name. */
		sprintf( __( '%s — home', 'gorilla-security' ), $gorilla_name ),
		'',
		array(
			'class' => 'gs-footer__logo',
			'href'  => home_url( '/' ),
		)
	)
);
echo wp_kses_post( gorilla_image( 'badge-local', __( 'ShowMeLocal badge', 'gorilla-security' ), '', array( 'class' => 'gs-footer__badge' ) ) );
?>
</div>
<!-- /wp:group -->

<?php
echo wp_kses_post( gorilla_paragraph( __( 'Trusted security and automation solutions for safer homes and businesses across Melbourne.', 'gorilla-security' ), '', 'medium' ) );
echo wp_kses_post( gorilla_buttons( array( gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) ) );
?>

<?php if ( $gorilla_social ) : ?>
<!-- wp:paragraph {"className":"gs-footer__follow"} -->
<p class="gs-footer__follow"><?php echo esc_html__( 'Follow Us On:', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"className":"is-style-tint-circles gs-footer__social","layout":{"type":"flex","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links is-style-tint-circles gs-footer__social">
	<?php
	foreach ( $gorilla_social as $gorilla_service => $gorilla_url ) {
		echo wp_kses_post(
			'<!-- wp:social-link ' . wp_json_encode(
				array(
					'url'     => esc_url_raw( $gorilla_url ),
					'service' => sanitize_key( $gorilla_service ),
				),
				JSON_UNESCAPED_SLASHES
			) . ' /-->'
		) . "\n";
	}
	?>
</ul>
<!-- /wp:social-links -->
<?php endif; ?></div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-footer__col","layout":{"type":"default"}} -->
<div class="wp-block-group gs-footer__col">
<?php
echo wp_kses_post( $gorilla_title( __( 'Security Systems', 'gorilla-security' ) ) );
echo wp_kses_post( $gorilla_list( $gorilla_service_links, 'gs-footer__links' ) );
?>
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-footer__col","layout":{"type":"default"}} -->
<div class="wp-block-group gs-footer__col">
<?php
echo wp_kses_post( $gorilla_title( __( 'Quick Links', 'gorilla-security' ) ) );
echo wp_kses_post( $gorilla_list( $gorilla_links, 'gs-footer__links' ) );
?>
</div>
<!-- /wp:group -->

<?php if ( $gorilla_contact || $gorilla_hours ) : ?>
<!-- wp:group {"className":"gs-footer__col gs-footer__contact","layout":{"type":"default"}} -->
<div class="wp-block-group gs-footer__col gs-footer__contact">
	<?php
	echo wp_kses_post( $gorilla_title( __( 'Contact Us', 'gorilla-security' ) ) );
	if ( $gorilla_contact ) {
		echo wp_kses_post( $gorilla_list( $gorilla_contact, 'gs-contact-list' ) );
	}
	?>

	<?php if ( $gorilla_hours ) : ?>
<!-- wp:group {"className":"is-style-glass-violet-outline gs-hours","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group is-style-glass-violet-outline gs-hours"><!-- wp:group {"className":"gs-hours__item gs-ico-clock","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-hours__item gs-ico-clock">
		<?php
		$gorilla_hours_html = implode(
			'<br>',
			array_map(
				static function ( $row ) {
					return esc_html( $row['days'] . ': ' . $row['time'] );
				},
				$gorilla_hours
			)
		);
		echo wp_kses_post( "<!-- wp:paragraph -->\n<p>{$gorilla_hours_html}</p>\n<!-- /wp:paragraph -->" );
		?>
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-hours__item gs-ico-headset","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-hours__item gs-ico-headset"><!-- wp:paragraph -->
<p><?php echo esc_html__( '24/7', 'gorilla-security' ); ?><br><?php echo esc_html__( 'Support Available', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
	<?php endif; ?>
</div>
<!-- /wp:group -->
<?php endif; ?></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"gs-footer__legal"} -->
<?php /* translators: 1: year, 2: site name. */ ?>
<p class="gs-footer__legal"><?php echo esc_html( sprintf( __( '©%1$s %2$s. All Rights Reserved | Website & SEO by OptWeb.', 'gorilla-security' ), gmdate( 'Y' ), $gorilla_name ) ); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gorilla_block_open( 'cover', $gorilla_cover_attrs ) . "\n" . ob_get_clean() );
