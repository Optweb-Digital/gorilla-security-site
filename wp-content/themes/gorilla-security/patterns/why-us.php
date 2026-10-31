<?php
/**
 * Title: Why us (stepper)
 * Slug: gorilla-security/why-us
 * Categories: gorilla-sections
 * Keywords: why us, reasons, steps, benefits
 *
 * Figma 1:522 — eyebrow, heading, step photos I1:522;1:4091–4101, track 1:4087/4088,
 * six steps (numbers 1:4057–4062 as a CSS counter, titles, dividers 1:4081–4086), Get A Quote.
 * Step 1 is active on load; gorilla.js turns each title into a button that shows its text and
 * photo. Without JS every description is visible. Step copy comes from the Why us variants
 * (1:4047, Variant2–6); Figma gives step 06 the same sentence as step 05.
 *
 * @package gorilla-security
 */

$gorilla_steps = array(
	array( __( 'Proven Experience', 'gorilla-security' ), __( 'With industry experience, our team understands security challenges and delivers solutions tailored to your needs.', 'gorilla-security' ) ),
	array( __( 'Fast Response', 'gorilla-security' ), __( 'Quick response and dependable service when you need us, helping keep your property protected without unnecessary delays.', 'gorilla-security' ) ),
	array( __( 'Competitive Pricing', 'gorilla-security' ), __( 'Quality security solutions at fair and transparent prices, giving you reliable protection without unnecessary costs.', 'gorilla-security' ) ),
	array( __( 'Mobile Service', 'gorilla-security' ), __( 'Our fully mobile team brings professional security services directly to your home or business, wherever you need us.', 'gorilla-security' ) ),
	array( __( 'Trusted & Reliable', 'gorilla-security' ), __( 'Honest advice, quality workmanship, and reliable solutions designed to give you confidence in your security system.', 'gorilla-security' ) ),
	array( __( '24/7 Support', 'gorilla-security' ), __( 'Honest advice, quality workmanship, and reliable solutions designed to give you confidence in your security system.', 'gorilla-security' ) ),
);

// One photo per step (decorative: the text carries the meaning); none at all → no media frame.
$gorilla_media = array();
foreach ( $gorilla_steps as $gorilla_i => $gorilla_step ) {
	$gorilla_media[] = gorilla_image(
		'why-' . ( $gorilla_i + 1 ),
		'',
		'',
		array( 'class' => 'gs-steps__img' . ( 0 === $gorilla_i ? ' is-active' : '' ) )
	);
}
$gorilla_media = array_filter( $gorilla_media );
?>
<!-- wp:group {"align":"full","className":"gs-why","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gs-why"><!-- wp:columns {"align":"wide","className":"gs-why__cols"} -->
<div class="wp-block-columns alignwide gs-why__cols"><!-- wp:column {"className":"gs-why__intro"} -->
<div class="wp-block-column gs-why__intro">
<?php
echo wp_kses_post( gorilla_eyebrow( __( 'Why Choose Gorilla Security?', 'gorilla-security' ) ) );
echo wp_kses_post( gorilla_heading( __( '[[Built for Better]] Security.', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
?>

<?php if ( $gorilla_media ) : ?>
<!-- wp:group {"className":"gs-steps__media","layout":{"type":"default"}} -->
<div class="wp-block-group gs-steps__media"><?php echo wp_kses_post( implode( "\n\n", $gorilla_media ) ); ?></div>
<!-- /wp:group -->
<?php endif; ?></div>
<!-- /wp:column -->

<!-- wp:column {"className":"gs-why__list"} -->
<div class="wp-block-column gs-why__list">
<?php echo wp_kses_post( gorilla_buttons( array( gorilla_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) ) ); ?>

<!-- wp:group {"className":"gs-steps","layout":{"type":"default"}} -->
<div class="wp-block-group gs-steps">
<?php foreach ( $gorilla_steps as $gorilla_i => $gorilla_step ) : ?>
<!-- wp:group {"className":"gs-step<?php echo 0 === $gorilla_i ? ' is-active' : ''; ?>","layout":{"type":"default"}} -->
<div class="wp-block-group gs-step<?php echo 0 === $gorilla_i ? ' is-active' : ''; ?>"><!-- wp:group {"className":"gs-step__body","layout":{"type":"default"}} -->
<div class="wp-block-group gs-step__body">
	<?php
	echo wp_kses_post(
		gorilla_heading(
			$gorilla_step[0],
			array(
				'level' => 3,
				'size'  => 'card-title',
				'class' => 'gs-step__title',
			)
		)
	);
	echo wp_kses_post( gorilla_paragraph( $gorilla_step[1], '', 'lead' ) );
	?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
