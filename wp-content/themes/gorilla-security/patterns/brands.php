<?php
/**
 * Title: Brands
 * Slug: gorilla-security/brands
 * Categories: gorilla-sections
 * Keywords: brands, partners, logos, marquee
 *
 * Figma 1:508 — band 1:509, title panel 1:511 (1:512 fade + 1:513 heading), logo marquee 1:510
 * (two rows of five). gorilla.js clones each row and scrolls it, with a pause button
 * (WCAG 2.2.2); without JS or with reduced motion the rows are static. Logos without a file are
 * skipped; a row with no logos is not output (AGENTS.md §6).
 *
 * @package gorilla-security
 */

// Rows as laid out in Figma 1:510 (brand-NN = placeholder name in assets/images, design-system §4).
$gorilla_rows = array(
	array(
		'brand-01' => __( 'Axis Communications', 'gorilla-security' ),
		'brand-02' => __( 'HiLook by Hikvision', 'gorilla-security' ),
		'brand-03' => __( 'Uniview (UNV)', 'gorilla-security' ),
		'brand-04' => __( 'Hikvision', 'gorilla-security' ),
		'brand-05' => __( 'Paradox', 'gorilla-security' ),
	),
	array(
		'brand-07' => __( 'Dahua', 'gorilla-security' ),
		'brand-08' => __( 'Aiphone', 'gorilla-security' ),
		'brand-09' => __( 'Hills', 'gorilla-security' ),
		'brand-10' => __( 'Inner Range', 'gorilla-security' ),
		'brand-06' => __( 'Bosch', 'gorilla-security' ),
	),
);

$gorilla_tracks = array();
foreach ( $gorilla_rows as $gorilla_row ) {
	$gorilla_logos = array();
	foreach ( $gorilla_row as $gorilla_name => $gorilla_alt ) {
		$gorilla_logos[] = gorilla_image( $gorilla_name, $gorilla_alt, '', array( 'class' => 'gs-marquee__logo' ) );
	}
	$gorilla_logos = array_filter( $gorilla_logos );
	if ( $gorilla_logos ) {
		$gorilla_tracks[] = $gorilla_logos;
	}
}
?>
<!-- wp:group {"align":"full","className":"gs-brands","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gs-brands"><!-- wp:group {"className":"gs-brands__panel","layout":{"type":"default"}} -->
<div class="wp-block-group gs-brands__panel">
<?php
echo wp_kses_post(
	gorilla_heading(
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

<?php if ( $gorilla_tracks ) : ?>
<!-- wp:group {"className":"gs-marquee","layout":{"type":"default"}} -->
<div class="wp-block-group gs-marquee">
	<?php foreach ( $gorilla_tracks as $gorilla_track ) : ?>
<!-- wp:group {"className":"gs-marquee__track","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-marquee__track"><?php echo wp_kses_post( implode( "\n\n", $gorilla_track ) ); ?></div>
<!-- /wp:group -->
	<?php endforeach; ?>
</div>
<!-- /wp:group -->
<?php endif; ?></div>
<!-- /wp:group -->
