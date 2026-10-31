<?php
/**
 * Title: Testimonials (slider)
 * Slug: gorilla-security/testimonials
 * Categories: gorilla-sections
 * Keywords: testimonials, reviews, slider, customers
 *
 * Figma 1:407 — eyebrow 1:414, heading 1:408, copy 1:410, Get A Quote 1:411, arrows 1:419 and the
 * slider 1:418 (cards 1:4619, 1:4375, 1:4431, 1:4491, 1:4555). Figma repeats them 4× (20 cards); gorilla.js
 * adds the 3 extra copies as aria-hidden, inert clones, so the HTML keeps each review once.
 * Reviews are quoted as in Figma; whether they are genuine and the photos cleared is an open decision.
 * Without JS the track is a native horizontal scroller and the arrows are hidden.
 *
 * @package gorilla-security
 */

$gorilla_track = 'gs-testimonials-track';

// [ photo, name, posted, quote lines, rating ].
$gorilla_reviews = array(
	array( 'testimonial-1', 'Harrison Polites', __( '3 years ago', 'gorilla-security' ), array( 'Dan is fantastic. A great communicator, he arrived on time and just got the job done. In the end, the work was more than either of us expected, but regardless he stuck to his quoted price. A true professional.' ), '5.0' ),
	array( 'testimonial-2', 'Amit harari', __( '2 years ago', 'gorilla-security' ), array( 'Dan installed new CCTV system at my house and I’m very happy with the new system. Will recommend to friends and family' ), '5.0' ),
	array( 'testimonial-3', 'Sajjad Saeidi', __( '4 years ago', 'gorilla-security' ), array( 'Great service explain everything friendly guys', 'And very reasonable price' ), '5.0' ),
	array( 'testimonial-4', 'Matt To’omua', __( '4 years ago', 'gorilla-security' ), array( 'Outstanding service. Highly recommend' ), '5.0' ),
	array( 'testimonial-5', 'Matt To’omua', __( '2 years ago', 'gorilla-security' ), array( 'Great service thanks Dan' ), '5.0' ),
);

/**
 * Paragraph block with a class (core/paragraph serializes className as the only class).
 *
 * @param string $class_name Class.
 * @param string $html       Inner HTML, already escaped.
 * @return string
 */
$gorilla_p = static function ( $class_name, $html ) {
	return gorilla_block_open( 'paragraph', array( 'className' => $class_name ) ) . "\n"
		. '<p class="' . esc_attr( $class_name ) . '">' . $html . "</p>\n<!-- /wp:paragraph -->";
};
?>
<!-- wp:group {"align":"full","className":"gs-testimonials","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gs-testimonials"><!-- wp:group {"className":"gs-testimonials__head","layout":{"type":"default"}} -->
<div class="wp-block-group gs-testimonials__head"><!-- wp:group {"className":"gs-testimonials__intro","layout":{"type":"default"}} -->
<div class="wp-block-group gs-testimonials__intro">
<?php
echo wp_kses_post( gorilla_eyebrow( __( 'Testimonials', 'gorilla-security' ) ) );
echo wp_kses_post( gorilla_heading( __( '[[Trusted by]] Melbourne. Chosen for Security.', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
?>
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-testimonials__aside","layout":{"type":"default"}} -->
<div class="wp-block-group gs-testimonials__aside">
<?php echo wp_kses_post( gorilla_paragraph( __( 'Discover why homeowners and businesses across Melbourne trust Gorilla Security & Automation for dependable security solutions, professional installation, and responsive ongoing support.', 'gorilla-security' ), '', 'lead' ) ); ?>

<!-- wp:group {"className":"gs-testimonials__actions","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"right"}} -->
<div class="wp-block-group gs-testimonials__actions">
<?php
echo wp_kses_post( gorilla_buttons( array( gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) ) );
echo wp_kses_post( gorilla_arrows( $gorilla_track ) );
?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"<?php echo esc_attr( $gorilla_track ); ?>","className":"gs-slider__track gs-slider__track--repeat","layout":{"type":"default"}} -->
<div id="<?php echo esc_attr( $gorilla_track ); ?>" class="wp-block-group gs-slider__track gs-slider__track--repeat">
<?php foreach ( $gorilla_reviews as $gorilla_review ) : ?>
	<?php
	list( $gorilla_photo, $gorilla_name, $gorilla_when, $gorilla_lines, $gorilla_score ) = $gorilla_review;

	$gorilla_rating = '<span class="screen-reader-text">' . esc_html__( 'Rated', 'gorilla-security' ) . ' </span>' . esc_html( $gorilla_score )
		. '<span class="screen-reader-text"> ' . esc_html__( 'out of 5', 'gorilla-security' ) . '</span> <span class="gs-rating__stars" aria-hidden="true">★★★★★</span>';
	?>
<!-- wp:group {"tagName":"article","className":"gs-testimonial","layout":{"type":"default"}} -->
<article class="wp-block-group gs-testimonial">
	<?php
	echo wp_kses_post( gorilla_image( $gorilla_photo, '', '', array( 'class' => 'gs-testimonial__photo' ) ) );
	?>

<!-- wp:group {"className":"gs-testimonial__body","layout":{"type":"default"}} -->
<div class="wp-block-group gs-testimonial__body">
	<?php
	echo wp_kses_post( $gorilla_p( 'gs-rating', $gorilla_rating ) );
	?>

<!-- wp:group {"className":"gs-testimonial__meta","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group gs-testimonial__meta">
	<?php
	echo wp_kses_post( $gorilla_p( 'gs-testimonial__name', esc_html( $gorilla_name ) ) );
	echo wp_kses_post( $gorilla_p( 'gs-testimonial__date', esc_html( $gorilla_when ) ) );
	?>
</div>
<!-- /wp:group -->

	<?php
	echo wp_kses_post( $gorilla_p( 'gs-testimonial__quote', implode( '<br>', array_map( 'esc_html', $gorilla_lines ) ) ) );
	?>
</div>
<!-- /wp:group --></article>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
