<?php
/**
 * Title: CTA · dark (photo background)
 * Slug: gorilla-security/cta-dark
 * Categories: gorilla-sections
 * Keywords: cta, call to action, quote, phone, connect
 *
 * Figma 1:289 — photo 1:291 with the 34% night overlay 1:292 (baked into cta-bg.webp), eyebrow 1:293,
 * heading 1:298, copy 1:313, Get A Quote 1:299, phone 1:302, glass panel 1:297, model 1:320 and the
 * glass stat cards 1:314 (24/7 Support) / 1:321 (Homes & Businesses).
 * The phone button is only output once gorilla_site( 'phone' ) is confirmed; without the model photo
 * the whole media column (panel, photo, cards) is not output (AGENTS.md §6).
 *
 * @package gorilla-security
 */

$gorilla_bg    = gorilla_img( 'cta-bg' );
$gorilla_phone = gorilla_site( 'phone' );
$gorilla_tel   = $gorilla_phone ? 'tel:' . preg_replace( '/[^0-9+]/', '', $gorilla_phone ) : '';
$gorilla_model = gorilla_image( 'cta-model', __( 'Gorilla Security team member in a branded uniform', 'gorilla-security' ), '', array( 'class' => 'gs-cta__model' ) );

// cta-bg.webp already has Figma's 34% night overlay; the SVG placeholder gets 30%; no image → solid night.
if ( ! $gorilla_bg ) {
	$gorilla_dim = 100;
} elseif ( str_ends_with( $gorilla_bg, '.svg' ) ) {
	$gorilla_dim = 30;
} else {
	$gorilla_dim = 0;
}

$gorilla_cover_attrs = array(
	'url'                => $gorilla_bg,
	'dimRatio'           => $gorilla_dim,
	'overlayColor'       => 'night',
	'isUserOverlayColor' => true,
	'align'              => 'full',
	'className'          => 'gs-cta',
	'layout'             => array( 'type' => 'default' ),
);

$gorilla_cards = array(
	'support' => array( 'headset', __( '24/7 Support', 'gorilla-security' ) ),
	'homes'   => array( 'building-shield', __( 'Homes & Businesses', 'gorilla-security' ) ),
);

// Whole cover through kses at once — a lone opener would be re-serialized as void (rules-log 008).
ob_start();
?>
<div class="wp-block-cover alignfull gs-cta">
<?php if ( $gorilla_bg ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gorilla_bg ); ?>" data-object-fit="cover"/>
<?php endif; ?>
<span aria-hidden="true" class="wp-block-cover__background has-night-background-color has-background-dim-<?php echo esc_attr( $gorilla_dim ); ?> has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"className":"gs-cta__cols"} -->
<div class="wp-block-columns gs-cta__cols"><!-- wp:column {"className":"gs-cta__text"} -->
<div class="wp-block-column gs-cta__text">
<?php
echo wp_kses_post( gorilla_eyebrow( __( 'Let’s Connect', 'gorilla-security' ) ) );
echo wp_kses_post(
	gorilla_heading(
		__( 'Ready for [[Smarter Security]]', 'gorilla-security' ),
		array(
			'size'  => 'h1',
			'class' => 'gs-cta__title',
		)
	)
);
echo wp_kses_post( gorilla_paragraph( __( 'Get tailored security and automation solutions designed to meet the unique needs of Melbourne homes and businesses. From CCTV and alarm systems to intercoms, access control, smart locks and automation, our team provides practical recommendations, professional guidance and solutions suited to your property. Speak with our experienced team for expert advice and a free, no-obligation quote.', 'gorilla-security' ), '', 'lead' ) );
echo wp_kses_post(
	gorilla_buttons(
		array(
			gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
			gorilla_button( $gorilla_phone, $gorilla_tel, 'light-phone' ),
		)
	)
);
?>
</div>
<!-- /wp:column -->

<?php if ( $gorilla_model ) : ?>
<!-- wp:column {"className":"gs-cta__media"} -->
<div class="wp-block-column gs-cta__media"><!-- wp:group {"className":"gs-cta__stage","layout":{"type":"default"}} -->
<div class="wp-block-group gs-cta__stage"><!-- wp:group {"className":"is-style-glass-violet-outline gs-cta__panel","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-glass-violet-outline gs-cta__panel"></div>
<!-- /wp:group -->

	<?php echo wp_kses_post( $gorilla_model ); ?>

	<?php foreach ( $gorilla_cards as $gorilla_key => $gorilla_card ) : ?>
<!-- wp:group {"className":"is-style-glass-violet-outline gs-cta__card gs-cta__card--<?php echo esc_attr( $gorilla_key ); ?>","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-glass-violet-outline gs-cta__card gs-cta__card--<?php echo esc_attr( $gorilla_key ); ?>"><!-- wp:group {"className":"gs-cta__icon gs-ico-<?php echo esc_attr( $gorilla_card[0] ); ?>","layout":{"type":"default"}} -->
<div class="wp-block-group gs-cta__icon gs-ico-<?php echo esc_attr( $gorilla_card[0] ); ?>"></div>
<!-- /wp:group -->

		<?php echo wp_kses_post( gorilla_paragraph( $gorilla_card[1] ) ); ?></div>
<!-- /wp:group -->
<?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endif; ?></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gorilla_block_open( 'cover', $gorilla_cover_attrs ) . "\n" . ob_get_clean() );
