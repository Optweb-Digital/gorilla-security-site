<?php
/**
 * Title: Brands
 * Slug: gorilla-security/brands
 * Categories: gorilla-sections
 * Keywords: brands, logos, partners, marquee
 *
 * Figma 1:508 / 1:510 — heading panel fading over two rows of partner logos.
 * gorilla.js turns the rows into a looping marquee with a pause button; without JS, or with
 * reduced motion, the logos sit still and wrap.
 *
 * @package gorilla-security
 */

// [image name, alt, Figma width, Figma height] — two staggered rows of five.
$gsec_rows = array(
	array(
		array( 'brand-01', 'Axis Communications', 133, 50 ),
		array( 'brand-02', 'HiLook by Hikvision', 144, 49 ),
		array( 'brand-03', 'Uniview', 86, 48 ),
		array( 'brand-04', 'Hikvision', 170, 55 ),
		array( 'brand-05', 'Paradox', 144, 48 ),
	),
	array(
		array( 'brand-06', 'Dahua Technology', 131, 45 ),
		array( 'brand-07', 'Aiphone', 198, 46 ),
		array( 'brand-08', 'Hills', 128, 52 ),
		array( 'brand-09', 'Inner Range', 197, 62 ),
		array( 'brand-10', 'Bosch', 143, 43 ),
	),
);
?>
<!-- wp:group {"tagName":"section","align":"full","className":"gs-brands","layout":{"type":"default"}} -->
<section class="wp-block-group alignfull gs-brands"><!-- wp:group {"className":"gs-brands__panel","layout":{"type":"default"}} -->
<div class="wp-block-group gs-brands__panel">
<?php
echo wp_kses_post(
	gsec_heading(
		__( 'Trusted By Forward Thinking Brands', 'gorilla-security' ),
		array(
			'size'  => 'h3',
			'class' => 'gs-brands__title',
		)
	)
);
?>
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-marquee","layout":{"type":"default"}} -->
<div class="wp-block-group gs-marquee"><!-- wp:group {"className":"gs-marquee__track","layout":{"type":"default"}} -->
<div class="wp-block-group gs-marquee__track">
<?php foreach ( $gsec_rows as $gsec_row ) : ?>
<!-- wp:group {"className":"gs-marquee__row","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group gs-marquee__row">
	<?php
	foreach ( $gsec_row as $gsec_logo ) {
		echo wp_kses_post( gsec_image( $gsec_logo[0], $gsec_logo[1], '', $gsec_logo[2], $gsec_logo[3] ) ) . "\n";
	}
	?>
</div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
