<?php
/**
 * Title: Hero
 * Slug: gorilla-security/hero
 * Categories: gorilla-sections
 * Keywords: hero, banner, quote, header
 * Description: Full-width photo hero with the page H1, lead, quote CTA and the quote card (Figma 1:69 + 1:97).
 *
 * Copy is from Figma, pending content-writer confirmation in docs/copy/home.md.
 * The review badge (1:114), trust strip (1:515) and social rail (1:83) carry unconfirmed claims / URLs: they are
 * output only locally (GS_SHOW_PENDING) from fixtures/assets/pending/, never on staging or production, until
 * the client confirms them (docs/project-context.md → Open decisions).
 * The worker cut-out layer (1:72) is intentionally not used; contrast comes from the hero-scrim gradient.
 *
 * @package gorilla-security
 */

$gs_hero_img = gs_img( 'hero-bg' );
$gs_cover    = array(
	'isUserOverlayColor' => true,
	'gradient'           => 'hero-scrim',
	'tagName'            => 'section',
	'align'              => 'full',
	'className'          => 'gs-hero',
	'layout'             => array( 'type' => 'constrained' ),
	'anchor'             => 'hero',
);
$gs_hero_tag = '';
if ( $gs_hero_img ) {
	$gs_cover    = array( 'url' => $gs_hero_img ) + $gs_cover;
	$gs_hero_tag = '<img class="wp-block-cover__image-background" alt="" src="' . esc_url( $gs_hero_img ) . '" data-object-fit="cover"/>';
}
?>
<?php
// Not wp_kses_post(): kses rewrites a block comment containing a URL into a self-closing "/-->" (rules-log 006).
// serialize_block_attributes() inside gs_block_open() escapes <, >, &, " and -- so nothing can leave the comment.
echo gs_block_open( 'cover', $gs_cover ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see comment above.
?>
<section class="wp-block-cover alignfull gs-hero" id="hero"><?php echo wp_kses_post( $gs_hero_tag ); ?><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient has-hero-scrim-gradient-background"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"align":"wide","className":"gs-hero__grid"} -->
<div class="wp-block-columns alignwide gs-hero__grid"><!-- wp:column {"className":"gs-hero__main"} -->
<div class="wp-block-column gs-hero__main">
<?php
echo wp_kses_post(
	gs_heading(
		__( "Smarter Security.\nSafer Spaces.", 'gorilla-security' ),
		array(
			'level' => 1,
			'size'  => 'display',
			'class' => 'gs-hero__title',
		)
	)
);
?>

<!-- wp:group {"className":"gs-hero__intro","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-hero__intro">
<?php echo wp_kses_post( gs_paragraph( __( 'Advanced security and smart technology, professionally designed and installed for Melbourne homes and businesses.', 'gorilla-security' ), 'lead-with-bar' ) ); ?>

<!-- wp:group {"className":"gs-hero__actions","layout":{"type":"flex","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-hero__actions">
<?php echo wp_kses_post( gs_hero_review_badge() ); ?>

<?php echo wp_kses_post( gs_buttons( array( gs_button( __( 'Get A Quote', 'gorilla-security' ), '#quote', 'glass', 'gs-btn-sm' ) ) ) ); ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php echo wp_kses_post( gs_social_links( array( 'instagram', 'facebook', 'linkedin' ), 'gs-social--rail' ) ); ?>

<?php echo wp_kses_post( gs_hero_trust_strip() ); ?></div>
<!-- /wp:column -->

<!-- wp:column {"className":"gs-hero__aside"} -->
<div class="wp-block-column gs-hero__aside"><!-- wp:pattern {"slug":"gorilla-security/quote-card"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:html -->
<a class="gs-scroll-cue gs-ico-arrow-down" href="#about"><span class="screen-reader-text"><?php echo esc_html__( 'Scroll to the next section', 'gorilla-security' ); ?></span></a>
<!-- /wp:html --></div></section>
<!-- /wp:cover -->
