<?php
/**
 * Title: Hero
 * Slug: gorilla-security/hero
 * Categories: gorilla-sections
 * Keywords: hero, banner, intro
 *
 * Figma 1:69–1:515 — photo cover with the page H1, lead, review badge, quote button,
 * social rail, trust strip and scroll cue; the quote card (1:97) sits in the right column.
 *
 * @package gorilla-security
 */

$gsec_bg = gsec_img( 'hero-bg' );

// Photo: hero-scrim overlay (darker behind the text, for AA contrast; Figma's flat 20% fails).
// Missing photo: a solid night cover keeps the white text readable (AGENTS.md §6).
$gsec_cover   = array(
	'url'                => $gsec_bg ? $gsec_bg : null,
	'dimRatio'           => 100,
	'overlayColor'       => $gsec_bg ? null : 'night',
	'gradient'           => $gsec_bg ? 'hero-scrim' : null,
	'isUserOverlayColor' => true,
	'align'              => 'full',
	'className'          => 'gs-hero',
	'layout'             => array( 'type' => 'default' ),
);
$gsec_overlay = $gsec_bg
	? 'has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient has-hero-scrim-gradient-background'
	: 'has-night-background-color has-background-dim-100 has-background-dim';

$gsec_trust = array_filter(
	array(
		gsec_image( 'trust-licence', __( 'Licensed security installers, licence issued by Victoria Police', 'gorilla-security' ), '', 158, 59 ),
		gsec_image( 'partner-1', __( 'Afterpay', 'gorilla-security' ), '', 165, 33 ),
		gsec_image( 'warranty', __( '2 year warranty', 'gorilla-security' ), '', 60, 60 ),
		gsec_image( 'partner-2', __( 'Hikvision Platinum Partner installers', 'gorilla-security' ), '', 126, 47 ),
	)
);

// The cover body is buffered and escaped together with its opener at the end:
// wp_kses_post() turns a lone block opener into a self-closing (empty) block.
ob_start();
?>
<div class="wp-block-cover alignfull gs-hero"><span aria-hidden="true" class="wp-block-cover__background <?php echo esc_attr( $gsec_overlay ); ?>"></span>
<?php if ( $gsec_bg ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gsec_bg ); ?>" data-object-fit="cover"/>
<?php endif; ?>
<div class="wp-block-cover__inner-container"><!-- wp:columns {"className":"gs-hero__cols"} -->
<div class="wp-block-columns gs-hero__cols"><!-- wp:column {"width":"72%","className":"gs-hero__main"} -->
<div class="wp-block-column gs-hero__main" style="flex-basis:72%">
<?php
echo wp_kses_post(
	gsec_heading(
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
<?php echo wp_kses_post( gsec_paragraph( __( 'Advanced security and smart technology, professionally designed and installed for Melbourne homes and businesses.', 'gorilla-security' ), 'lead-with-bar', 'lead' ) ); ?>

<!-- wp:group {"className":"gs-review-badge","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-review-badge">
<?php echo wp_kses_post( gsec_image( 'review-source', __( 'Google', 'gorilla-security' ), '', 29, 29 ) ); ?>

<!-- wp:html -->
<span class="gs-rating" role="img" aria-label="<?php esc_attr_e( 'Rated 5 out of 5', 'gorilla-security' ); ?>"></span>
<!-- /wp:html -->

<?php echo wp_kses_post( gsec_paragraph( __( '1000+ Reviews', 'gorilla-security' ), '', 'small' ) ); ?>
</div>
<!-- /wp:group -->

<?php echo wp_kses_post( gsec_buttons( array( gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), 'glass', 'gs-btn-sm' ) ) ) ); ?>
</div>
<!-- /wp:group -->

<!-- wp:social-links {"className":"gs-hero__social","layout":{"type":"flex","orientation":"vertical"}} -->
<ul class="wp-block-social-links gs-hero__social"><!-- wp:social-link {"url":"","service":"instagram"} /--><!-- wp:social-link {"url":"","service":"facebook"} /--><!-- wp:social-link {"url":"","service":"linkedin"} /--></ul>
<!-- /wp:social-links -->

<?php if ( $gsec_trust ) : ?>
<!-- wp:group {"className":"gs-trust-strip","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-trust-strip">
	<?php
	foreach ( $gsec_trust as $gsec_logo ) {
		echo wp_kses_post( $gsec_logo ) . "\n";
	}
	?>
</div>
<!-- /wp:group -->
<?php endif; ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"28%","className":"gs-hero__aside"} -->
<div class="wp-block-column gs-hero__aside" style="flex-basis:28%"><!-- wp:pattern {"slug":"gorilla-security/quote-card"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:html -->
<a class="gs-hero__cue" href="#about" aria-label="<?php esc_attr_e( 'Scroll to the next section', 'gorilla-security' ); ?>"></a>
<!-- /wp:html --></div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gsec_block_open( 'cover', $gsec_cover ) . "\n" . ob_get_clean() );
