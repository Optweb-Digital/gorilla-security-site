<?php
/**
 * Title: About
 * Slug: gorilla-security/about
 * Categories: gorilla-sections
 * Keywords: about, intro, stats, features
 *
 * Figma 1:6 (+ buttons 42:11497) — intro with stats, installer portrait, feature card and van photo.
 *
 * @package gorilla-security
 */

$gsec_stats = array(
	array( '6+', __( 'Security Solutions', 'gorilla-security' ) ),
	array( '600+', __( 'Homes & Businesses', 'gorilla-security' ) ),
	array( '1000+', __( 'Happy Customers', 'gorilla-security' ) ),
);

$gsec_features = array(
	array( 'shield', __( 'Professional Installation', 'gorilla-security' ), __( 'Expert setup for reliable and long-lasting protection', 'gorilla-security' ) ),
	array( 'chip', __( 'Smart Technology', 'gorilla-security' ), __( 'Modern security and automation for easier, smarter living', 'gorilla-security' ) ),
	array( 'map-pin', __( 'Melbourne Service', 'gorilla-security' ), __( 'Local team providing fast, trusted and ongoing support.', 'gorilla-security' ) ),
);

$gsec_portrait = gsec_image( 'about-portrait', __( 'Gorilla Security installer standing beside a branded service van', 'gorilla-security' ) );
$gsec_van      = gsec_image( 'about-van', __( 'Gorilla Security service van', 'gorilla-security' ) );
?>
<!-- wp:group {"tagName":"section","anchor":"about","align":"full","className":"gs-about","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-about" id="about"><!-- wp:columns {"align":"wide","className":"gs-about__cols"} -->
<div class="wp-block-columns alignwide gs-about__cols"><!-- wp:column {"width":"35%","className":"gs-about__intro"} -->
<div class="wp-block-column gs-about__intro" style="flex-basis:35%">
<?php
echo wp_kses_post( gsec_eyebrow( __( 'About Gorilla Security', 'gorilla-security' ) ) );
echo wp_kses_post( gsec_heading( __( 'Security Build [[Around]] You.', 'gorilla-security' ) ) );
echo wp_kses_post( gsec_paragraph( __( 'Gorilla Security & Automation delivers professional security and smart technology solutions for Melbourne homes and businesses. From CCTV and alarms to intercoms, access control, digital locks and smart home automation, we design and install tailored systems that make your space safer, smarter and more connected.', 'gorilla-security' ), '', 'lead' ) );
echo wp_kses_post(
	gsec_buttons(
		array(
			gsec_button( __( 'Know More', 'gorilla-security' ), home_url( '/about-us/' ) ),
			gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
		)
	)
);
?>

<!-- wp:columns {"isStackedOnMobile":false,"className":"gs-about__stats is-style-stats-with-dividers"} -->
<div class="wp-block-columns is-not-stacked-on-mobile gs-about__stats is-style-stats-with-dividers">
<?php foreach ( $gsec_stats as $gsec_stat ) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"gs-stat__num","fontSize":"h3"} -->
<p class="gs-stat__num has-h-3-font-size"><?php echo esc_html( $gsec_stat[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"gs-stat__label","fontSize":"lead"} -->
<p class="gs-stat__label has-lead-font-size"><?php echo esc_html( $gsec_stat[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<?php if ( $gsec_portrait ) : ?>
<!-- wp:column {"width":"33%","className":"gs-about__media"} -->
<div class="wp-block-column gs-about__media" style="flex-basis:33%"><?php echo wp_kses_post( $gsec_portrait ); ?></div>
<!-- /wp:column -->
<?php endif; ?>

<!-- wp:column {"width":"30%","className":"gs-about__aside"} -->
<div class="wp-block-column gs-about__aside" style="flex-basis:30%"><!-- wp:group {"className":"gs-feature-list is-style-card-tint","layout":{"type":"default"}} -->
<div class="wp-block-group gs-feature-list is-style-card-tint">
<?php foreach ( $gsec_features as $gsec_feature ) : ?>
<!-- wp:group {"className":"gs-feature","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group gs-feature">
	<?php
	echo wp_kses_post( gsec_icon( $gsec_feature[0] ) );
	?>

<!-- wp:group {"className":"gs-feature__body","layout":{"type":"default"}} -->
<div class="wp-block-group gs-feature__body">
	<?php
	echo wp_kses_post(
		gsec_heading(
			$gsec_feature[1],
			array(
				'level' => 3,
				'size'  => 'card-title',
				'class' => 'gs-feature__title',
			)
		)
	);
	echo wp_kses_post( gsec_paragraph( $gsec_feature[2], '', 'medium' ) );
	?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<?php echo wp_kses_post( $gsec_van ); ?></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
