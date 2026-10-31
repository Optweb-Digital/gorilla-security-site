<?php
/**
 * Title: Why us
 * Slug: gorilla-security/why-us
 * Categories: gorilla-sections
 * Keywords: why us, reasons, steps, stepper
 *
 * Figma 1:522 — intro, a photo per reason and six numbered reasons. gorilla.js makes it a
 * stepper: one reason open at a time with its photo, advancing on its own with a pause
 * button. Without JS every reason is open and the first photo shows.
 *
 * @package gorilla-security
 */

// [title, text, photo]. Texts 02–05 come from the 1:522 variants; 06 repeats 05 in Figma.
$gsec_steps = array(
	array( __( 'Proven Experience', 'gorilla-security' ), __( 'With industry experience, our team understands security challenges and delivers solutions tailored to your needs.', 'gorilla-security' ), 'why-1' ),
	array( __( 'Fast Response', 'gorilla-security' ), __( 'Quick response and dependable service when you need us, helping keep your property protected without unnecessary delays.', 'gorilla-security' ), 'why-2' ),
	array( __( 'Competitive Pricing', 'gorilla-security' ), __( 'Quality security solutions at fair and transparent prices, giving you reliable protection without unnecessary costs.', 'gorilla-security' ), 'why-3' ),
	array( __( 'Mobile Service', 'gorilla-security' ), __( 'Our fully mobile team brings professional security services directly to your home or business, wherever you need us.', 'gorilla-security' ), 'why-4' ),
	array( __( 'Trusted & Reliable', 'gorilla-security' ), __( 'Honest advice, quality workmanship, and reliable solutions designed to give you confidence in your security system.', 'gorilla-security' ), 'why-5' ),
	array( __( '24/7 Support', 'gorilla-security' ), '[[TODO: copy — Figma repeats step 05 here]]', 'why-6' ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"why-us","align":"full","className":"gs-why gs-steps","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-why gs-steps" id="why-us"><!-- wp:columns {"align":"wide","className":"gs-why__cols"} -->
<div class="wp-block-columns alignwide gs-why__cols"><!-- wp:column {"width":"40%","className":"gs-why__intro"} -->
<div class="wp-block-column gs-why__intro" style="flex-basis:40%">
<?php
echo wp_kses_post( gsec_eyebrow( __( 'Why Choose Gorilla Security?', 'gorilla-security' ) ) );
echo wp_kses_post( gsec_heading( __( '[[Built for Better]] Security.', 'gorilla-security' ) ) );
?>

<!-- wp:group {"className":"gs-steps__media","layout":{"type":"default"}} -->
<div class="wp-block-group gs-steps__media">
	<?php
	foreach ( $gsec_steps as $gsec_step ) {
		echo wp_kses_post( gsec_image( $gsec_step[2] ) ) . "\n";
	}
	?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%","className":"gs-why__steps"} -->
<div class="wp-block-column gs-why__steps" style="flex-basis:60%">
<?php echo wp_kses_post( gsec_buttons( array( gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) ) ); ?>

<!-- wp:group {"className":"gs-steps__list","layout":{"type":"default"}} -->
<div class="wp-block-group gs-steps__list">
<?php foreach ( $gsec_steps as $gsec_step ) : ?>
<!-- wp:group {"className":"gs-step","layout":{"type":"default"}} -->
<div class="wp-block-group gs-step">
	<?php
	echo wp_kses_post(
		gsec_heading(
			$gsec_step[0],
			array(
				'level' => 3,
				'size'  => 'card-title',
				'class' => 'gs-step__title',
			)
		)
	);
	?>

<!-- wp:paragraph {"className":"gs-step__text","fontSize":"medium"} -->
<p class="gs-step__text has-medium-font-size"><?php echo esc_html( $gsec_step[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
