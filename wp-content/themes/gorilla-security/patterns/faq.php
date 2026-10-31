<?php
/**
 * Title: FAQ
 * Slug: gorilla-security/faq
 * Categories: gorilla-sections
 * Keywords: faq, questions, answers, accordion
 *
 * Figma 1:334 — wash 1:335, eyebrow 1:403, heading 1:402, Get A Quote 1:336 and the FAQ container
 * 1:339 (white, glow, radius 37) with eight numbered rows; row 02 is open (1:343) as in Figma.
 * Figma only has the answer to 02; the others are [[TODO: copy]] until docs/copy/ has them.
 *
 * @package gorilla-security
 */

$gorilla_faqs = array(
	array( __( 'What security systems does Gorilla Security specialise in installing?', 'gorilla-security' ), '' ),
	array( __( 'How can I benefit from a security system installation at my residence?', 'gorilla-security' ), __( 'Our security systems offer enhanced safety, providing real-time monitoring, intrusion detection, and access control. Enjoy peace of mind knowing that your property is protected around the clock.', 'gorilla-security' ) ),
	array( __( 'Are your security system installations suitable for both homes and businesses?', 'gorilla-security' ), '' ),
	array( __( 'What sets Gorilla Security apart in terms of installation expertise?', 'gorilla-security' ), '' ),
	array( __( 'Can I request a consultation to determine the right security system for my needs?', 'gorilla-security' ), '' ),
	array( __( 'What are business security systems, and how do they keep my business safe?', 'gorilla-security' ), '' ),
	array( __( 'What is a security system that doesn’t need wires?', 'gorilla-security' ), '' ),
	array( __( 'What is the process behind wireless home security systems?', 'gorilla-security' ), '' ),
);
$gorilla_open = 1;
?>
<!-- wp:group {"align":"full","anchor":"faq","className":"gs-faq-section","layout":{"type":"default"}} -->
<div id="faq" class="wp-block-group alignfull gs-faq-section"><!-- wp:group {"className":"gs-faq-section__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
<div class="wp-block-group gs-faq-section__head"><!-- wp:group {"className":"gs-faq-section__intro","layout":{"type":"default"}} -->
<div class="wp-block-group gs-faq-section__intro">
<?php
echo wp_kses_post( gorilla_eyebrow( __( 'Frequently Asked Questions', 'gorilla-security' ) ) );
echo wp_kses_post( gorilla_heading( __( '[[Clear Answers.]] Smarter Security.', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
?>
</div>
<!-- /wp:group -->

<?php echo wp_kses_post( gorilla_buttons( array( gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) ) ); ?></div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-faq","layout":{"type":"default"}} -->
<div class="wp-block-group gs-faq">
<?php
foreach ( $gorilla_faqs as $gorilla_i => $gorilla_faq ) {
	list( $gorilla_question, $gorilla_answer ) = $gorilla_faq;
	if ( '' === $gorilla_answer ) {
		/* translators: %s: two-digit FAQ number. */
		$gorilla_answer = sprintf( __( '[[TODO: copy — answer to FAQ %s]]', 'gorilla-security' ), sprintf( '%02d', $gorilla_i + 1 ) );
	}
	$gorilla_is_open = $gorilla_open === $gorilla_i;

	echo wp_kses_post(
		gorilla_block_open(
			'details',
			array(
				'showContent' => $gorilla_is_open ? true : null,
				'className'   => 'is-style-faq-numbered',
			)
		) . "\n"
		. '<details class="wp-block-details is-style-faq-numbered"' . ( $gorilla_is_open ? ' open' : '' ) . '><summary>' . esc_html( $gorilla_question ) . '</summary>'
		. gorilla_paragraph( $gorilla_answer )
		. "</details>\n<!-- /wp:details -->\n\n"
	);
}
?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
