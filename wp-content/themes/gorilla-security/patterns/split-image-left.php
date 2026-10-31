<?php
/**
 * Title: Split · image left
 * Slug: gorilla-security/split-image-left
 * Categories: gorilla-sections
 * Keywords: split, image, list, residential, business, wireless
 *
 * Figma 1:238 — soft-section background; photo (Deco frame · left) before the heading,
 * text with two sub-headed lists, and two buttons. Figma's "Gorilla Security & Locksmith"
 * is written "Gorilla Security" (design-system.md → Known gaps).
 *
 * @package gorilla-security
 */

$gsec_lists = array(
	__( 'Residential & Business Protection', 'gorilla-security' ) => array(
		__( 'Residential security systems that protect your home with smart alarm monitoring, motion detection, and help available 24/7', 'gorilla-security' ),
		__( 'Business security systems designed for offices, stores, warehouses, and commercial complexes, with options that can grow with your needs', 'gorilla-security' ),
	),
	__( 'Wireless & Smart Security Options', 'gorilla-security' )  => array(
		__( 'Our wireless security systems get rid of the need for cables while still providing strong protection.', 'gorilla-security' ),
		__( 'We sell wireless home security systems for Melbourne homes that fit right. They come with smartphone alerts, remote access, and are easy to set up.', 'gorilla-security' ),
	),
);

ob_start();
?>
<!-- wp:group {"tagName":"section","align":"full","className":"gs-split gs-split--soft","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-split gs-split--soft"><!-- wp:columns {"align":"wide","className":"gs-split__cols"} -->
<div class="wp-block-columns alignwide gs-split__cols"><!-- wp:column {"width":"52%","className":"gs-split__media"} -->
<div class="wp-block-column gs-split__media" style="flex-basis:52%">
<?php echo gsec_image( 'split-image-left', __( 'Woman holding an access card to a reader beside an office door', 'gorilla-security' ), 'deco-frame-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below. ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"48%","className":"gs-split__body"} -->
<div class="wp-block-column gs-split__body" style="flex-basis:48%">
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_heading( __( '[[Secure Your Space]] with Affordable Security Systems', 'gorilla-security' ) );
echo gsec_paragraph( __( 'We at Gorilla Security take pride in providing the best security for all kinds of properties. We can help you protect your home or business with:', 'gorilla-security' ), '', 'lead' );
foreach ( $gsec_lists as $gsec_title => $gsec_items ) {
	echo gsec_heading(
		$gsec_title,
		array(
			'level' => 3,
			'size'  => 'lead',
			'class' => 'gs-split__subhead',
		)
	);
	echo "\n<!-- wp:list {\"fontSize\":\"lead\"} -->\n<ul class=\"wp-block-list has-lead-font-size\">";
	foreach ( $gsec_items as $gsec_item ) {
		echo "<!-- wp:list-item -->\n<li>" . esc_html( $gsec_item ) . "</li>\n<!-- /wp:list-item -->";
	}
	echo "</ul>\n<!-- /wp:list -->\n";
}
echo gsec_buttons(
	array(
		gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
		gsec_button( __( 'Know More', 'gorilla-security' ), home_url( '/services/' ), 'outline' ),
	)
);
// phpcs:enable
?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
<?php
echo wp_kses_post( ob_get_clean() );
