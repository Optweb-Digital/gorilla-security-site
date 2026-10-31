<?php
/**
 * Contact Form 7 integration: load its scripts and styles only on requests that render a form.
 *
 * CF7 otherwise loads ~13 KB of JS (plus wp-hooks / wp-i18n) on every page, which counts against
 * the 50 KB JS budget (AGENTS.md §7). Block themes render the template before wp_head, so the
 * form is seen first and the assets are enqueued once CF7 has registered them.
 *
 * @package gs-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

/**
 * Remember (or report) whether this request rendered a CF7 form.
 *
 * @param bool|null $set Pass true to record a form.
 * @return bool
 */
function gorilla_cf7_has_form( $set = null ) {
	static $has_form = false;
	if ( true === $set ) {
		$has_form = true;
	}
	return $has_form;
}

/**
 * Enqueue CF7's scripts and styles (once).
 *
 * @return void
 */
function gorilla_cf7_enqueue_assets() {
	if ( ! function_exists( 'wpcf7_enqueue_scripts' ) || wp_script_is( 'contact-form-7', 'enqueued' ) ) {
		return;
	}
	wpcf7_enqueue_scripts();
	wpcf7_enqueue_styles();
}

/**
 * When a CF7 shortcode renders, record it; enqueue now if CF7's assets are already registered.
 *
 * @param string $output Shortcode output.
 * @param string $tag    Shortcode tag.
 * @return string Unchanged output.
 */
function gorilla_cf7_on_shortcode( $output, $tag ) {
	if ( 'contact-form-7' !== $tag && 'contact-form' !== $tag ) {
		return $output;
	}
	gorilla_cf7_has_form( true );
	if ( did_action( 'wp_enqueue_scripts' ) ) {
		gorilla_cf7_enqueue_assets();
	}
	return $output;
}
add_filter( 'do_shortcode_tag', 'gorilla_cf7_on_shortcode', 10, 2 );

/**
 * After CF7 registers its assets (wp_enqueue_scripts, priority 10), enqueue them if a form rendered.
 *
 * @return void
 */
function gorilla_cf7_maybe_enqueue() {
	if ( gorilla_cf7_has_form() ) {
		gorilla_cf7_enqueue_assets();
	}
}
add_action( 'wp_enqueue_scripts', 'gorilla_cf7_maybe_enqueue', 20 );
