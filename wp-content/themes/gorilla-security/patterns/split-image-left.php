<?php
/**
 * Title: Split · photo left (tinted)
 * Slug: gorilla-security/split-image-left
 * Categories: gorilla-sections
 * Keywords: split, photo left, affordable, residential, business, wireless
 *
 * Figma 1:238 — tinted band 1:239, photo 1:252 with deco blocks 1:240 / 1:241, heading 1:242,
 * copy 1:244 (intro, two sub-heads, two bullet lists), buttons 1:248 / 1:245.
 * Figma's "Gorilla Security & Locksmith" is built as "Gorilla Security" (design-system known gaps).
 *
 * @package gorilla-security
 */

$gorilla_photo = gorilla_image( 'split-2', __( 'Customer using a key card on an access control reader', 'gorilla-security' ), 'deco-frame-left', array( 'class' => 'gs-split__photo' ) );

$gorilla_lists = array(
	__( 'Residential & Business Protection', 'gorilla-security' ) => array(
		__( 'Residential security systems that protect your home with smart alarm monitoring, motion detection, and help available 24/7', 'gorilla-security' ),
		__( 'Business security systems designed for offices, stores, warehouses, and commercial complexes, with options that can grow with your needs', 'gorilla-security' ),
	),
	__( 'Wireless & Smart Security Options', 'gorilla-security' )  => array(
		__( 'Our wireless security systems get rid of the need for cables while still providing strong protection.', 'gorilla-security' ),
		__( 'We sell wireless home security systems for Melbourne homes that fit right. They come with smartphone alerts, remote access, and are easy to set up.', 'gorilla-security' ),
	),
);
?>
<!-- wp:group {"align":"full","className":"gs-split gs-split--image-left gs-split--tint","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gs-split gs-split--image-left gs-split--tint"><!-- wp:columns {"align":"wide","className":"gs-split__cols"} -->
<div class="wp-block-columns alignwide gs-split__cols">
<?php if ( $gorilla_photo ) : ?>
<!-- wp:column {"className":"gs-split__media"} -->
<div class="wp-block-column gs-split__media"><?php echo wp_kses_post( $gorilla_photo ); ?></div>
<!-- /wp:column -->
<?php endif; ?>

<!-- wp:column {"className":"gs-split__text"} -->
<div class="wp-block-column gs-split__text">
<?php
echo wp_kses_post( gorilla_heading( __( '[[Secure Your Space]] with Affordable Security Systems', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
echo wp_kses_post( gorilla_paragraph( __( 'We at Gorilla Security take pride in providing the best security for all kinds of properties. We can help you protect your home or business with:', 'gorilla-security' ), '', 'lead' ) );
foreach ( $gorilla_lists as $gorilla_label => $gorilla_items ) {
	echo wp_kses_post( gorilla_paragraph( $gorilla_label, '', 'lead' ) );
	$gorilla_lis = implode(
		"\n\n",
		array_map(
			static function ( $item ) {
				return "<!-- wp:list-item -->\n<li>" . esc_html( $item ) . "</li>\n<!-- /wp:list-item -->";
			},
			$gorilla_items
		)
	);
	echo wp_kses_post( "<!-- wp:list {\"className\":\"gs-split__list\",\"fontSize\":\"lead\"} -->\n<ul class=\"wp-block-list gs-split__list has-lead-font-size\">" . $gorilla_lis . "</ul>\n<!-- /wp:list -->" );
}
echo wp_kses_post(
	gorilla_buttons(
		array(
			gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ),
			gorilla_button( __( 'Know More', 'gorilla-security' ), '#services', 'outline' ),
		)
	)
);
?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
