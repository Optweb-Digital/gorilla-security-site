<?php
/**
 * Title: FAQ
 * Slug: gorilla-security/faq
 * Categories: gorilla-sections
 * Keywords: faq, questions, answers, accordion
 *
 * Figma 1:334 — heading row with a quote button, then a card of numbered questions
 * (Details blocks, style FAQ (numbered); native open/close, no JS). Only answer 02 exists
 * in Figma; the others are [[TODO: copy]] (docs/project-context.md → Open decisions).
 *
 * @package gorilla-security
 */

$gsec_todo = '[[TODO: copy — FAQ answer missing in Figma]]';

// [question, answer]; the item with an answer opens first, as in Figma.
$gsec_faqs = array(
	array( __( 'What security systems does Gorilla Security specialise in installing?', 'gorilla-security' ), $gsec_todo ),
	array( __( 'How can I benefit from a security system installation at my residence?', 'gorilla-security' ), __( 'Our security systems offer enhanced safety, providing real-time monitoring, intrusion detection, and access control. Enjoy peace of mind knowing that your property is protected around the clock.', 'gorilla-security' ) ),
	array( __( 'Are your security system installations suitable for both homes and businesses?', 'gorilla-security' ), $gsec_todo ),
	array( __( 'What sets Gorilla Security apart in terms of installation expertise?', 'gorilla-security' ), $gsec_todo ),
	array( __( 'Can I request a consultation to determine the right security system for my needs?', 'gorilla-security' ), $gsec_todo ),
	array( __( 'What are business security systems, and how do they keep my business safe?', 'gorilla-security' ), $gsec_todo ),
	array( __( 'What is a security system that doesn’t need wires?', 'gorilla-security' ), $gsec_todo ),
	array( __( 'What is the process behind wireless home security systems?', 'gorilla-security' ), $gsec_todo ),
);

ob_start();
?>
<!-- wp:group {"tagName":"section","anchor":"faq","align":"full","className":"gs-faq","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull gs-faq" id="faq"><!-- wp:group {"align":"wide","className":"gs-faq__head","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide gs-faq__head"><!-- wp:group {"className":"gs-faq__intro","layout":{"type":"default"}} -->
<div class="wp-block-group gs-faq__intro">
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- buffered; escaped with wp_kses_post() below.
echo gsec_eyebrow( __( 'Frequently Asked Questions', 'gorilla-security' ) );
echo gsec_heading( __( '[[Clear Answers.]] Smarter Security.', 'gorilla-security' ) );
?>
</div>
<!-- /wp:group -->

<?php echo gsec_buttons( array( gsec_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/contact-us/#quote' ) ) ) ); ?>
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"gs-faq__list","layout":{"type":"default"}} -->
<div class="wp-block-group gs-faq__list">
<?php
$gsec_opened = false;
foreach ( $gsec_faqs as $gsec_faq ) {
	$gsec_open   = ! $gsec_opened && $gsec_todo !== $gsec_faq[1];
	$gsec_opened = $gsec_opened || $gsec_open;
	echo '<!-- wp:details {"className":"is-style-faq-numbered"' . ( $gsec_open ? ',"showContent":true' : '' ) . '} -->' . "\n"
		. '<details class="wp-block-details is-style-faq-numbered"' . ( $gsec_open ? ' open' : '' ) . '><summary>' . esc_html( $gsec_faq[0] ) . '</summary>'
		. '<!-- wp:paragraph -->' . "\n" . '<p>' . esc_html( $gsec_faq[1] ) . '</p>' . "\n" . '<!-- /wp:paragraph --></details>' . "\n"
		. '<!-- /wp:details -->' . "\n\n";
}
// phpcs:enable
?>
</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
<?php
echo wp_kses_post( ob_get_clean() );
