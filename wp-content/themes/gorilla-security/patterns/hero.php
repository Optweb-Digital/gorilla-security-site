<?php
/**
 * Title: Hero
 * Slug: gorilla-security/hero
 * Categories: gorilla-sections
 * Keywords: hero, banner, intro, quote
 *
 * Figma: photo 1:69 + 20% overlay 1:70 · H1 1:71 · lead with bar 1:76 · review badge 1:114 (source 1:161)
 * · Get A Quote 1:80 · social rail 1:83 · trust strip 1:515 · scroll cue 1:73 · quote card 1:97.
 * Optional parts (social rail) are only output when their data exists (AGENTS.md §6).
 *
 * @package gorilla-security
 */

$gorilla_bg     = gorilla_img( 'hero-bg' );
$gorilla_social = array_filter( (array) gorilla_site( 'social' ) );

$gorilla_cover_attrs = array(
	'url'                => $gorilla_bg,
	'dimRatio'           => $gorilla_bg ? 20 : 100,
	'overlayColor'       => 'night',
	'isUserOverlayColor' => true,
	'align'              => 'full',
	'className'          => 'gs-hero',
	'layout'             => array( 'type' => 'default' ),
);
$gorilla_dim_class   = $gorilla_bg ? 'has-background-dim-20' : 'has-background-dim-100';

$gorilla_trust = array_filter(
	array(
		gorilla_image( 'trust-licence', __( 'Licensed security installer — Victoria Police', 'gorilla-security' ), '', array( 'class' => 'gs-trust-strip__logo' ) ),
		gorilla_image( 'partner-1', __( 'Afterpay', 'gorilla-security' ), '', array( 'class' => 'gs-trust-strip__logo' ) ),
		gorilla_image( 'warranty', __( 'Warranty badge', 'gorilla-security' ), '', array( 'class' => 'gs-trust-strip__logo' ) ),
		gorilla_image( 'partner-2', __( 'Hikvision', 'gorilla-security' ), '', array( 'class' => 'gs-trust-strip__logo' ) ),
	)
);
?>
<?php
// Capture the whole cover so it goes through wp_kses_post() as one complete block: kses parses
// block markup, and a lone opener without its closer is re-serialized as a void block (rules-log 008).
ob_start();
?>
<div class="wp-block-cover alignfull gs-hero">
<?php if ( $gorilla_bg ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gorilla_bg ); ?>" data-object-fit="cover"/>
<?php endif; ?>
<span aria-hidden="true" class="wp-block-cover__background has-night-background-color <?php echo esc_attr( $gorilla_dim_class ); ?> has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"className":"gs-hero__cols"} -->
<div class="wp-block-columns gs-hero__cols"><!-- wp:column {"className":"gs-hero__main"} -->
<div class="wp-block-column gs-hero__main">
<?php
echo wp_kses_post(
	gorilla_heading(
		__( 'Smarter Security. Safer Spaces.', 'gorilla-security' ),
		array(
			'level' => 1,
			'size'  => 'display',
			'class' => 'gs-hero__title',
		)
	)
);
?>

<!-- wp:group {"className":"gs-hero__row","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-hero__row">
<?php echo wp_kses_post( gorilla_paragraph( __( 'Advanced security and smart technology, professionally designed and installed for Melbourne homes and businesses.', 'gorilla-security' ), 'lead-with-bar' ) ); ?>

<!-- wp:group {"className":"gs-review-badge","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-review-badge">
<?php echo wp_kses_post( gorilla_image( 'review-source', __( 'Google', 'gorilla-security' ), '', array( 'class' => 'gs-review-badge__source' ) ) ); ?>

<!-- wp:paragraph {"className":"gs-review-badge__text"} -->
<p class="gs-review-badge__text"><span class="gs-review-badge__stars" aria-hidden="true">★★★★★</span> <?php echo esc_html__( '1000+ Reviews', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php echo wp_kses_post( gorilla_buttons( array( gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), 'fill-no-icon', 'gs-hero__cta' ) ) ) ); ?>
</div>
<!-- /wp:group -->

<?php if ( $gorilla_social ) : ?>
<!-- wp:social-links {"className":"gs-hero__social","layout":{"type":"flex","orientation":"vertical"}} -->
<ul class="wp-block-social-links gs-hero__social">
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
<?php endif; ?>

<?php if ( $gorilla_trust ) : ?>
<!-- wp:group {"className":"gs-trust-strip","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group gs-trust-strip"><?php echo wp_kses_post( implode( "\n\n", $gorilla_trust ) ); ?></div>
<!-- /wp:group -->
<?php endif; ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"className":"gs-hero__aside"} -->
<div class="wp-block-column gs-hero__aside"><!-- wp:pattern {"slug":"gorilla-security/quote-card"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:html -->
<div class="gs-hero__scroll-wrap"><a class="gs-hero__scroll gs-ico-arrow-down" href="#about" aria-label="<?php echo esc_attr__( 'Scroll to the next section', 'gorilla-security' ); ?>"></a></div>
<!-- /wp:html --></div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gorilla_block_open( 'cover', $gorilla_cover_attrs ) . "\n" . ob_get_clean() );
