<?php
/**
 * Title: Testimonials
 * Slug: gorilla-security/testimonials
 * Categories: gorilla-sections
 * Keywords: testimonials, reviews, slider
 *
 * Figma 1:407 / 1:418 — heading row, then a slider of review cards (photo, shade, score,
 * name, age, text). The track scrolls with scroll-snap; gorilla.js wires the round arrows.
 * Reviews are Figma's ("2Year ago" written "2 years ago").
 *
 * @package gorilla-security
 */

// [name, age, text]; photos testimonial-1…5 are decorative.
$gsec_reviews = array(
	array( 'Harrison Polites', __( '3 years ago', 'gorilla-security' ), __( 'Dan is fantastic. A great communicator, he arrived on time and just got the job done. In the end, the work was more than either of us expected, but regardless he stuck to his quoted price. A true professional.', 'gorilla-security' ) ),
	array( 'Amit harari', __( '2 years ago', 'gorilla-security' ), __( 'Dan installed new CCTV system at my house and I’m very happy with the new system. Will recommend to friends and family', 'gorilla-security' ) ),
	array( 'Sajjad Saeidi', __( '4 years ago', 'gorilla-security' ), __( 'Great service explain everything friendly guys And very reasonable price', 'gorilla-security' ) ),
	array( 'Matt To’omua', __( '4 years ago', 'gorilla-security' ), __( 'Outstanding service. Highly recommend', 'gorilla-security' ) ),
	array( 'Matt To’omua', __( '2 years ago', 'gorilla-security' ), __( 'Great service thanks Dan', 'gorilla-security' ) ),
);

ob_start();
?>
<!-- wp:group {"tagName":"section","align":"full","className":"gs-testimonials gs-slider","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-testimonials gs-slider"><!-- wp:columns {"align":"wide","className":"gs-testimonials__head"} -->
<div class="wp-block-columns alignwide gs-testimonials__head"><!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%">
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_eyebrow( __( 'Testimonials', 'gorilla-security' ) );
echo gsec_heading( __( '[[Trusted by]] Melbourne. Chosen for Security.', 'gorilla-security' ) );
?>
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"45%","className":"gs-testimonials__aside"} -->
<div class="wp-block-column gs-testimonials__aside" style="flex-basis:45%">
<?php
echo gsec_paragraph( __( 'Discover why homeowners and businesses across Melbourne trust Gorilla Security & Automation for dependable security solutions, professional installation, and responsive ongoing support.', 'gorilla-security' ), '', 'lead' );
?>

<!-- wp:group {"className":"gs-testimonials__actions","layout":{"type":"default"}} -->
<div class="wp-block-group gs-testimonials__actions">
<?php
echo gsec_buttons( array( gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) );
echo gsec_arrows( 'testimonials-track' );
?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"anchor":"testimonials-track","align":"full","className":"gs-slider__track","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gs-slider__track" id="testimonials-track">
<?php
foreach ( $gsec_reviews as $gsec_i => $gsec_review ) {
	echo '<!-- wp:group {"className":"gs-testimonial","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-testimonial">' . gsec_image( 'testimonial-' . ( $gsec_i + 1 ) )
		. '<!-- wp:group {"className":"gs-testimonial__body","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-testimonial__body"><!-- wp:paragraph {"className":"gs-testimonial__score"} -->' . "\n"
		. '<p class="gs-testimonial__score">5.0 <span class="gs-rating" role="img" aria-label="' . esc_attr__( 'Rated 5 out of 5', 'gorilla-security' ) . '"></span></p>' . "\n"
		. '<!-- /wp:paragraph -->' . "\n\n"
		. '<!-- wp:paragraph {"className":"gs-testimonial__meta"} -->' . "\n"
		. '<p class="gs-testimonial__meta"><strong>' . esc_html( $gsec_review[0] ) . '</strong> <span>' . esc_html( $gsec_review[1] ) . '</span></p>' . "\n"
		. '<!-- /wp:paragraph -->' . "\n\n"
		. '<!-- wp:paragraph {"className":"gs-testimonial__text"} -->' . "\n"
		. '<p class="gs-testimonial__text">' . esc_html( $gsec_review[2] ) . '</p>' . "\n"
		. '<!-- /wp:paragraph --></div>' . "\n"
		. '<!-- /wp:group --></div>' . "\n"
		. '<!-- /wp:group -->' . "\n";
}
// phpcs:enable
?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
<?php
echo wp_kses_post( ob_get_clean() );
