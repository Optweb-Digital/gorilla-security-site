<?php
/**
 * Title: Testimonials
 * Slug: gorilla-security/testimonials
 * Categories: gorilla-sections
 * Keywords: testimonials, reviews, slider
 * Description: "Trusted by Melbourne. Chosen for Security." review slider (Figma 1:407, cards 1:418).
 *
 * The reviews, names and photos are PENDING CLIENT CONFIRMATION (they must be real, accurate and used with
 * consent — Australian Consumer Law). They load only where pending content is enabled (local QA) and the
 * photos exist in fixtures/assets/pending/; otherwise the section is not output at all.
 *
 * @package gorilla-security
 */

// Columns: photo, name, review date (only once confirmed — the Figma dates are placeholders, so none is shown), text.
$gs_reviews = array(
	array( 'testimonial-harrison-polites.webp', 'Harrison Polites', '', 'Dan is fantastic. A great communicator, he arrived on time and just got the job done. In the end, the work was more than either of us expected, but regardless he stuck to his quoted price. A true professional.' ),
	array( 'testimonial-amit-harari.webp', 'Amit Harari', '', 'Dan installed new CCTV system at my house and I’m very happy with the new system. Will recommend to friends and family' ),
	array( 'testimonial-sajjad-saeidi.webp', 'Sajjad Saeidi', '', 'Great service explain everything friendly guys And very reasonable price' ),
	array( 'testimonial-matt-toomua.webp', 'Matt To’omua', '', 'Outstanding service. Highly recommend' ),
	// Figma card 5: same name as card 4 with a different photo and review — name awaiting client confirmation.
	array( 'testimonial-card5-cap-man.webp', 'Matt To’omua', '', 'Great service thanks Dan' ),
);

$gs_cards = array();
foreach ( $gs_reviews as $gs_review ) {
	$gs_photo = gs_pending_img( $gs_review[0] );
	if ( '' === $gs_photo ) {
		continue;
	}
	$gs_cards[] = gs_group_open( 'gs-testimonial', array( 'layout' => array( 'type' => 'default' ) ) )
		. gs_image(
			'',
			'',
			'',
			array(
				'src'   => $gs_photo,
				'class' => 'gs-testimonial__photo',
			)
		)
		. gs_group_open( 'gs-testimonial__body', array( 'layout' => array( 'type' => 'default' ) ) )
		. '<!-- wp:paragraph {"className":"gs-rating-pill"} -->' . "\n"
		. '<p class="gs-rating-pill">5.0 <span class="gs-stars" role="img" aria-label="' . esc_attr__( 'Rated 5 out of 5', 'gorilla-security' ) . '"></span></p>' . "\n"
		. '<!-- /wp:paragraph -->'
		. gs_group_open(
			'gs-testimonial__meta',
			array(
				'layout' => array(
					'type'           => 'flex',
					'flexWrap'       => 'wrap',
					'justifyContent' => 'space-between',
				),
			)
		)
		. gs_paragraph( $gs_review[1], '', '', 'gs-testimonial__name' )
		. gs_paragraph( $gs_review[2], '', '', 'gs-testimonial__date' )
		. gs_group_close()
		. '<!-- wp:quote {"className":"gs-testimonial__quote"} -->' . "\n"
		. '<blockquote class="wp-block-quote gs-testimonial__quote">' . gs_paragraph( $gs_review[3] ) . '</blockquote>' . "\n"
		. '<!-- /wp:quote -->'
		. gs_group_close()
		. gs_group_close();
}
if ( ! $gs_cards ) {
	return;
}

$gs   = array();
$gs[] = gs_group_open(
	'gs-section gs-testimonials gs-pending',
	array(
		'tag'    => 'section',
		'align'  => 'full',
		'anchor' => 'testimonials',
	)
);
$gs[] = gs_columns_open( 'gs-testimonials__head', array( 'align' => 'wide' ) );
$gs[] = gs_column_open( 'gs-testimonials__intro' );
$gs[] = gs_eyebrow( __( 'Testimonials', 'gorilla-security' ) );
$gs[] = gs_heading( __( '[[Trusted by]] Melbourne. Chosen for Security.', 'gorilla-security' ) );
$gs[] = "</div>\n<!-- /wp:column -->";
$gs[] = gs_column_open( 'gs-testimonials__aside' );
$gs[] = gs_paragraph( __( 'Discover why homeowners and businesses across Melbourne trust Gorilla Security & Automation for dependable security solutions, professional installation, and responsive ongoing support.', 'gorilla-security' ), '', 'lead' );
$gs[] = gs_group_open(
	'gs-testimonials__actions',
	array(
		'layout' => array(
			'type'              => 'flex',
			'flexWrap'          => 'wrap',
			'verticalAlignment' => 'center',
		),
	)
)
	. gs_buttons( array( gs_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/#quote' ) ) ) )
	. gs_arrows(
		'gs-testimonials-track',
		array(
			'prev' => __( 'Previous reviews', 'gorilla-security' ),
			'next' => __( 'Next reviews', 'gorilla-security' ),
		)
	)
	. gs_group_close();
$gs[] = "</div>\n<!-- /wp:column -->";
$gs[] = "</div>\n<!-- /wp:columns -->";
$gs[] = gs_group_open(
	'gs-slider',
	array(
		'align'  => 'full',
		'layout' => array( 'type' => 'default' ),
	)
);
$gs[] = gs_group_open(
	'gs-slider__track',
	array(
		'anchor' => 'gs-testimonials-track',
		'layout' => array( 'type' => 'default' ),
	)
);
$gs[] = implode( "\n", $gs_cards );
$gs[] = gs_group_close();
$gs[] = gs_group_close();
$gs[] = gs_group_close( 'section' );

echo wp_kses_post( implode( "\n", $gs ) );
