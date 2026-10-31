<?php
/**
 * Title: Footer
 * Slug: gorilla-security/footer
 * Categories: gorilla-sections
 * Keywords: footer, links, contact
 * Inserter: no
 *
 * Figma 1:426 — dark photo cover: logo + award badge, intro, quote button; service and
 * quick links; contact list and hours box; copyright bar. Contact details come from
 * gsec_site() and show only when set. Hidden until decided (project-context.md → Open
 * decisions): social links ("Follow Us On"), opening hours (Figma conflict).
 *
 * @package gorilla-security
 */

$gsec_bg    = gsec_img( 'footer-bg' );
$gsec_site  = gsec_site();
$gsec_hours = array_values( array_filter( (array) $gsec_site['hours'] ) );

$gsec_cover   = array(
	'url'                => $gsec_bg ? $gsec_bg : null,
	'dimRatio'           => 100,
	'overlayColor'       => $gsec_bg ? null : 'night',
	'gradient'           => $gsec_bg ? 'night-fade' : null,
	'isUserOverlayColor' => true,
	'focalPoint'         => array(
		'x' => 1,
		'y' => 0.5,
	),
	'align'              => 'full',
	'className'          => 'gs-footer',
	'layout'             => array( 'type' => 'default' ),
);
$gsec_overlay = $gsec_bg
	? 'has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient has-night-fade-gradient-background'
	: 'has-night-background-color has-background-dim-100 has-background-dim';

// Service links open the matching tab of the services section on the home page.
$gsec_services = array(
	__( 'CCTV Systems', 'gorilla-security' )            => '/#service-cctv',
	__( 'Alarm System', 'gorilla-security' )            => '/#service-alarm',
	__( 'Intercom System', 'gorilla-security' )         => '/#service-intercom',
	__( 'Access Control System', 'gorilla-security' )   => '/#service-access',
	__( 'Smart Lock Installation', 'gorilla-security' ) => '/#service-locks',
	__( 'Smart Home Installation', 'gorilla-security' ) => '/#service-home',
);
$gsec_quick    = array(
	__( 'Home', 'gorilla-security' )       => '/',
	__( 'About Us', 'gorilla-security' )   => '/about-us/',
	__( 'Blog', 'gorilla-security' )       => '/blog/',
	__( 'Area', 'gorilla-security' )       => '/area/',
	__( 'Contact Us', 'gorilla-security' ) => '/contact-us/',
	__( 'FAQs', 'gorilla-security' )       => '/#faq',
);

/**
 * Footer column: title with a fading rule, then a list of links.
 *
 * @param string $title Column title.
 * @param array  $links Label => site path.
 * @return string Block markup.
 */
$gsec_link_column = static function ( $title, $links ) {
	$items = '';
	foreach ( $links as $label => $path ) {
		$items .= '<!-- wp:list-item -->' . "\n" . '<li><a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( $label ) . '</a></li>' . "\n" . '<!-- /wp:list-item -->';
	}
	return '<!-- wp:column {"className":"gs-footer__col"} -->' . "\n" . '<div class="wp-block-column gs-footer__col">'
		. gsec_heading(
			$title,
			array(
				'size'  => 'lead',
				'class' => 'gs-footer__title',
			)
		)
		. "\n" . '<!-- wp:list {"className":"gs-footer__links"} -->' . "\n" . '<ul class="wp-block-list gs-footer__links">' . $items . '</ul>' . "\n" . '<!-- /wp:list --></div>' . "\n" . '<!-- /wp:column -->';
};

// Contact list: [icon, text, href].
$gsec_contacts = array_filter(
	array(
		$gsec_site['phone'] ? array( 'phone', $gsec_site['phone'], 'tel:' . preg_replace( '/[^0-9+]/', '', $gsec_site['phone'] ) ) : null,
		$gsec_site['email'] ? array( 'mail', $gsec_site['email'], 'mailto:' . $gsec_site['email'] ) : null,
		$gsec_site['address'] ? array( 'map-pin', $gsec_site['address'], '' ) : null,
	)
);

ob_start();
?>
<div class="wp-block-cover alignfull gs-footer"><span aria-hidden="true" class="wp-block-cover__background <?php echo esc_attr( $gsec_overlay ); ?>"></span>
<?php if ( $gsec_bg ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gsec_bg ); ?>" style="object-position:100% 50%" data-object-fit="cover" data-object-position="100% 50%"/>
<?php endif; ?>
<div class="wp-block-cover__inner-container"><!-- wp:columns {"className":"gs-footer__cols"} -->
<div class="wp-block-columns gs-footer__cols"><!-- wp:column {"width":"28%","className":"gs-footer__brand"} -->
<div class="wp-block-column gs-footer__brand" style="flex-basis:28%"><!-- wp:group {"className":"gs-footer__logos","layout":{"type":"default"}} -->
<div class="wp-block-group gs-footer__logos">
<?php if ( has_custom_logo() || '' !== gsec_img( 'logo' ) ) : ?>
<!-- wp:site-logo {"width":237,"className":"gs-footer__logo"} /-->
<?php else : ?>
<!-- wp:site-title {"level":0,"className":"gs-footer__logo"} /-->
<?php endif; ?>
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_image( 'footer-badge', __( 'ShowMeLocal award badge', 'gorilla-security' ), '', 100, 100 );
?>
</div>
<!-- /wp:group -->

<?php
echo gsec_paragraph( __( 'Trusted security and automation solutions for safer homes and businesses across Melbourne.', 'gorilla-security' ) );
echo gsec_buttons( array( gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) );
?>
</div>
<!-- /wp:column -->

<?php
echo $gsec_link_column( __( 'Security Systems', 'gorilla-security' ), $gsec_services );
echo "\n\n";
echo $gsec_link_column( __( 'Quick Links', 'gorilla-security' ), $gsec_quick );
?>

<!-- wp:column {"width":"30%","className":"gs-footer__col"} -->
<div class="wp-block-column gs-footer__col" style="flex-basis:30%">
<?php
echo gsec_heading(
	__( 'Contact Us', 'gorilla-security' ),
	array(
		'size'  => 'lead',
		'class' => 'gs-footer__title',
	)
);
if ( $gsec_contacts ) {
	echo "\n" . '<!-- wp:list {"className":"gs-contact-list"} -->' . "\n" . '<ul class="wp-block-list gs-contact-list">';
	foreach ( $gsec_contacts as $gsec_contact ) {
		$gsec_text = $gsec_contact[2] ? '<a href="' . esc_url( $gsec_contact[2], array( 'tel', 'mailto' ) ) . '">' . esc_html( $gsec_contact[1] ) . '</a>' : esc_html( $gsec_contact[1] );
		echo '<!-- wp:list-item {"className":"gs-ico-' . esc_attr( $gsec_contact[0] ) . '"} -->' . "\n" . '<li class="gs-ico-' . esc_attr( $gsec_contact[0] ) . '">' . $gsec_text . '</li>' . "\n" . '<!-- /wp:list-item -->';
	}
	echo '</ul>' . "\n" . '<!-- /wp:list -->';
}
?>

<!-- wp:group {"className":"gs-hours is-style-glass-violet-outline","layout":{"type":"default"}} -->
<div class="wp-block-group gs-hours is-style-glass-violet-outline">
<?php
if ( $gsec_hours ) {
	echo '<!-- wp:paragraph {"className":"gs-hours__item gs-ico-clock"} -->' . "\n" . '<p class="gs-hours__item gs-ico-clock">' . implode( '<br>', array_map( 'esc_html', $gsec_hours ) ) . '</p>' . "\n" . '<!-- /wp:paragraph -->';
}
echo '<!-- wp:paragraph {"className":"gs-hours__item gs-ico-headset"} -->' . "\n" . '<p class="gs-hours__item gs-ico-headset">' . esc_html__( '24/7', 'gorilla-security' ) . '<br>' . esc_html__( 'Support Available', 'gorilla-security' ) . '</p>' . "\n" . '<!-- /wp:paragraph -->';
?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<?php
echo gsec_paragraph(
	sprintf(
		/* translators: 1: year, 2: site name. */
		__( '©%1$s %2$s. All Rights Reserved | Website & SEO by OptWeb.', 'gorilla-security' ),
		gmdate( 'Y' ),
		$gsec_site['name']
	),
	'',
	'small'
);
// phpcs:enable
?>
</div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gsec_block_open( 'cover', $gsec_cover ) . "\n" . ob_get_clean() );
