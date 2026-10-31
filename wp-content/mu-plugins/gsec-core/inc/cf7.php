<?php
/**
 * Contact Form 7 integration.
 *
 * @package gsec-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render CF7's hidden-fields wrapper as a <div> instead of a <fieldset>.
 *
 * CF7 wraps its hidden inputs in <fieldset class="hidden-fields-container"> with no
 * <legend>, which accessibility checkers report as an error on every page with a form
 * (WCAG H71). The wrapper only groups hidden inputs, so it needs no group semantics.
 * CF7 targets it by class only (styles.css), and has no filter for this markup.
 *
 * @param string $output Shortcode output.
 * @param string $tag    Shortcode name.
 * @return string
 */
function gsec_cf7_hidden_fields_wrapper( $output, $tag ) {
	if ( ! in_array( $tag, array( 'contact-form-7', 'contact-form' ), true ) ) {
		return $output;
	}
	return (string) preg_replace(
		'#<fieldset class="hidden-fields-container">(.*?)</fieldset>#s',
		'<div class="hidden-fields-container">$1</div>',
		$output,
		1
	);
}
add_filter( 'do_shortcode_tag', 'gsec_cf7_hidden_fields_wrapper', 10, 2 );
