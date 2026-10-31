<?php
/**
 * Title: CTA · dark
 * Slug: gorilla-security/cta-dark
 * Categories: gorilla-sections
 * Keywords: cta, call to action, quote, phone, contact
 *
 * Figma 1:289 — dark photo cover with eyebrow, heading, text, quote and phone buttons; a
 * team member on a glass panel with two Glass · violet outline badges.
 *
 * @package gorilla-security
 */

$gsec_bg    = gsec_img( 'cta-bg' );
$gsec_phone = gsec_site( 'phone' );
$gsec_tel   = $gsec_phone ? 'tel:' . preg_replace( '/[^0-9+]/', '', $gsec_phone ) : '';

// Night overlay (Figma 34% #13131B); without the photo a solid night cover keeps white text readable.
$gsec_cover   = array(
	'url'                => $gsec_bg ? $gsec_bg : null,
	'dimRatio'           => $gsec_bg ? 40 : 100,
	'overlayColor'       => 'night',
	'isUserOverlayColor' => true,
	'align'              => 'full',
	'className'          => 'gs-cta',
	'layout'             => array( 'type' => 'default' ),
);
$gsec_overlay = 'has-night-background-color has-background-dim-' . ( $gsec_bg ? '40' : '100' ) . ' has-background-dim';

$gsec_badges = array(
	array( 'headset', __( '24/7 Support', 'gorilla-security' ), 'gs-cta__badge--top' ),
	array( 'building', __( 'Homes & Businesses', 'gorilla-security' ), 'gs-cta__badge--bottom' ),
);

// Buffered and escaped together with the cover opener (see hero.php).
ob_start();
?>
<div class="wp-block-cover alignfull gs-cta"><span aria-hidden="true" class="wp-block-cover__background <?php echo esc_attr( $gsec_overlay ); ?>"></span>
<?php if ( $gsec_bg ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gsec_bg ); ?>" data-object-fit="cover"/>
<?php endif; ?>
<div class="wp-block-cover__inner-container"><!-- wp:columns {"align":"wide","className":"gs-cta__cols"} -->
<div class="wp-block-columns alignwide gs-cta__cols"><!-- wp:column {"width":"45%","className":"gs-cta__body"} -->
<div class="wp-block-column gs-cta__body" style="flex-basis:45%">
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_eyebrow( __( 'Let’s Connect', 'gorilla-security' ) );
echo gsec_heading(
	__( 'Ready for [[Smarter Security]]', 'gorilla-security' ),
	array(
		'size'  => 'h1',
		'class' => 'gs-cta__title',
	)
);
echo gsec_paragraph( __( 'Get tailored security and automation solutions designed to meet the unique needs of Melbourne homes and businesses. From CCTV and alarm systems to intercoms, access control, smart locks and automation, our team provides practical recommendations, professional guidance and solutions suited to your property. Speak with our experienced team for expert advice and a free, no-obligation quote.', 'gorilla-security' ), '', 'lead' );
echo gsec_buttons(
	array(
		gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
		$gsec_tel ? gsec_button( $gsec_phone, $gsec_tel, 'light-phone' ) : '',
	)
);
?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"55%","className":"gs-cta__media"} -->
<div class="wp-block-column gs-cta__media" style="flex-basis:55%"><!-- wp:group {"className":"gs-cta__panel","layout":{"type":"default"}} -->
<div class="wp-block-group gs-cta__panel"></div>
<!-- /wp:group -->

<?php
echo gsec_image( 'cta-model', __( 'Gorilla Security team member in a branded uniform', 'gorilla-security' ) );
foreach ( $gsec_badges as $gsec_badge ) {
	$gsec_class = 'gs-cta__badge ' . $gsec_badge[2] . ' is-style-glass-violet-outline';
	echo "\n" . '<!-- wp:group {"className":"' . $gsec_class . '","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group ' . $gsec_class . '"><!-- wp:group {"className":"gs-cta__badge-icon gs-ico-' . $gsec_badge[0] . '","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-cta__badge-icon gs-ico-' . $gsec_badge[0] . '"></div>' . "\n"
		. '<!-- /wp:group -->' . "\n\n"
		. '<!-- wp:paragraph {"className":"gs-cta__badge-text"} -->' . "\n"
		. '<p class="gs-cta__badge-text">' . esc_html( $gsec_badge[1] ) . '</p>' . "\n"
		. '<!-- /wp:paragraph --></div>' . "\n"
		. '<!-- /wp:group -->';
}
// phpcs:enable
?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gsec_block_open( 'cover', $gsec_cover ) . "\n" . ob_get_clean() );
