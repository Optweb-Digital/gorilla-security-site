<?php
/**
 * Title: About
 * Slug: gorilla-security/about
 * Categories: gorilla-sections
 * Keywords: about, intro, stats, features
 *
 * Figma 1:6 — section 1:7 · eyebrow 1:24 · heading 1:9 · copy 1:11 · stats 1:12 · photo 1:68 ·
 * feature card 1:28 (rows 1:29 / 1:36 / 1:41) · van photo 1:67. Anchor #about (hero scroll cue).
 * Columns whose image is missing are not output (AGENTS.md §6).
 *
 * @package gorilla-security
 */

$gorilla_portrait = gorilla_image( 'about-portrait', __( 'Gorilla Security technician in uniform beside the company van', 'gorilla-security' ), '', array( 'class' => 'gs-about__photo' ) );
$gorilla_van      = gorilla_image( 'about-van', __( 'Gorilla Security service van', 'gorilla-security' ), '', array( 'class' => 'gs-about__photo gs-about__photo--van' ) );

$gorilla_stats = array(
	array( '6+', __( 'Security Solutions', 'gorilla-security' ) ),
	array( '600+', __( 'Homes & Businesses', 'gorilla-security' ) ),
	array( '1000+', __( 'Happy Customers', 'gorilla-security' ) ),
);

$gorilla_features = array(
	array( 'shield', __( 'Professional Installation', 'gorilla-security' ), __( 'Expert setup for reliable and long-lasting protection', 'gorilla-security' ) ),
	array( 'chip', __( 'Smart Technology', 'gorilla-security' ), __( 'Modern security and automation for easier, smarter living', 'gorilla-security' ) ),
	array( 'map-pin', __( 'Melbourne Service', 'gorilla-security' ), __( 'Local team providing fast, trusted and ongoing support.', 'gorilla-security' ) ),
);
?>
<!-- wp:group {"anchor":"about","align":"full","className":"gs-about","layout":{"type":"constrained"}} -->
<div id="about" class="wp-block-group alignfull gs-about"><!-- wp:columns {"align":"wide","className":"gs-about__cols"} -->
<div class="wp-block-columns alignwide gs-about__cols"><!-- wp:column {"className":"gs-about__intro"} -->
<div class="wp-block-column gs-about__intro">
<?php
echo wp_kses_post( gorilla_eyebrow( __( 'ABOUT GORILLA SECURITY', 'gorilla-security' ) ) );
echo wp_kses_post( gorilla_heading( __( 'Security Build [[Around]] You.', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
echo wp_kses_post( gorilla_paragraph( __( 'Gorilla Security & Automation delivers professional security and smart technology solutions for Melbourne homes and businesses. From CCTV and alarms to intercoms, access control, digital locks and smart home automation, we design and install tailored systems that make your space safer, smarter and more connected.', 'gorilla-security' ), '', 'lead' ) );
echo wp_kses_post(
	gorilla_buttons(
		array(
			gorilla_button( __( 'Know More', 'gorilla-security' ), '#services' ),
			gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ), 'outline' ),
		)
	)
);
?>

<!-- wp:columns {"isStackedOnMobile":false,"className":"is-style-stats-with-dividers"} -->
<div class="wp-block-columns is-not-stacked-on-mobile is-style-stats-with-dividers">
<?php foreach ( $gorilla_stats as $gorilla_stat ) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"gs-stat__num"} -->
<p class="gs-stat__num"><?php echo esc_html( $gorilla_stat[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"gs-stat__label"} -->
<p class="gs-stat__label"><?php echo esc_html( $gorilla_stat[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<?php if ( $gorilla_portrait ) : ?>
<!-- wp:column {"className":"gs-about__media"} -->
<div class="wp-block-column gs-about__media"><?php echo wp_kses_post( $gorilla_portrait ); ?></div>
<!-- /wp:column -->
<?php endif; ?>

<!-- wp:column {"className":"gs-about__aside"} -->
<div class="wp-block-column gs-about__aside"><!-- wp:group {"className":"is-style-card-tint gs-about__features","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card-tint gs-about__features">
<?php foreach ( $gorilla_features as $gorilla_feature ) : ?>
<!-- wp:group {"className":"gs-feature","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group gs-feature"><?php echo wp_kses_post( gorilla_icon( $gorilla_feature[0] ) ); ?>

<!-- wp:group {"className":"gs-feature__body","layout":{"type":"default"}} -->
<div class="wp-block-group gs-feature__body">
	<?php
	echo wp_kses_post(
		gorilla_heading(
			$gorilla_feature[1],
			array(
				'level' => 3,
				'size'  => 'card-title',
				'class' => 'gs-feature__title',
			)
		)
	);
	echo wp_kses_post( gorilla_paragraph( $gorilla_feature[2], '', 'lead' ) );
	?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<?php echo wp_kses_post( $gorilla_van ); ?></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
