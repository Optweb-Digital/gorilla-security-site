<?php
/**
 * Pattern helpers: serialize repeated atoms identically in every pattern.
 *
 * Every helper RETURNS valid block markup (it never echoes). Patterns output the result with
 * wp_kses_post(). Dynamic values are escaped inside the helper.
 *
 * @package gorilla-security
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build the opening block comment with JSON attributes.
 *
 * @param string $block Block name without the core/ prefix, e.g. 'heading'.
 * @param array  $attrs Block attributes.
 * @return string
 */
function gorilla_block_open( $block, $attrs = array() ) {
	$attrs = array_filter(
		$attrs,
		static function ( $value ) {
			return null !== $value && '' !== $value && array() !== $value;
		}
	);

	$json = $attrs ? ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : '';
	return '<!-- wp:' . $block . $json . ' -->';
}

/**
 * Convert a preset slug to the class WordPress generates for it (e.g. 'h2' → 'h-2').
 *
 * @param string $slug Preset slug.
 * @return string
 */
function gorilla_slug_class( $slug ) {
	return function_exists( '_wp_to_kebab_case' ) ? _wp_to_kebab_case( $slug ) : sanitize_html_class( $slug );
}

/**
 * Heading with [[accent]] words rendered as <mark> (the editor's Highlight format).
 *
 * @param string $text Heading text. Wrap accent words in [[double brackets]].
 * @param array  $args { level: int 1–6, size: font-size slug, class: extra classes, align: left|center|right }.
 * @return string Block markup, or '' when $text is empty.
 */
function gorilla_heading( $text, $args = array() ) {
	if ( '' === trim( (string) $text ) ) {
		return '';
	}
	$args = wp_parse_args(
		$args,
		array(
			'level' => 2,
			'size'  => '',
			'class' => '',
			'align' => '',
		)
	);

	$level = min( 6, max( 1, absint( $args['level'] ) ) );

	$html = preg_replace( '/\[\[(.+?)\]\]/', '<mark class="gs-accent">$1</mark>', esc_html( $text ) );

	$classes = array( 'wp-block-heading' );
	if ( $args['align'] ) {
		$classes[] = 'has-text-align-' . sanitize_html_class( $args['align'] );
	}
	if ( $args['class'] ) {
		$classes[] = $args['class'];
	}
	if ( $args['size'] ) {
		$classes[] = 'has-' . gorilla_slug_class( $args['size'] ) . '-font-size';
	}

	$attrs = array(
		'textAlign' => $args['align'],
		'level'     => 2 === $level ? null : $level,
		'className' => $args['class'],
		'fontSize'  => $args['size'],
	);

	return gorilla_block_open( 'heading', $attrs ) . "\n"
		. '<h' . $level . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $html . '</h' . $level . '>' . "\n"
		. '<!-- /wp:heading -->';
}

/**
 * Paragraph helper (optionally with a block style such as 'eyebrow' or 'lead-with-bar').
 *
 * @param string $text  Paragraph text.
 * @param string $style Block style name without the is-style- prefix.
 * @param string $size  Optional font-size slug.
 * @return string Block markup, or '' when $text is empty.
 */
function gorilla_paragraph( $text, $style = '', $size = '' ) {
	if ( '' === trim( (string) $text ) ) {
		return '';
	}
	$class   = $style ? 'is-style-' . sanitize_html_class( $style ) : '';
	$classes = array_filter( array( $class, $size ? 'has-' . gorilla_slug_class( $size ) . '-font-size' : '' ) );
	$attr    = $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '';

	return gorilla_block_open(
		'paragraph',
		array(
			'className' => $class,
			'fontSize'  => $size,
		)
	) . "\n<p" . $attr . '>' . esc_html( $text ) . "</p>\n<!-- /wp:paragraph -->";
}

/**
 * Eyebrow label above a section heading.
 *
 * @param string $text Eyebrow text.
 * @return string
 */
function gorilla_eyebrow( $text ) {
	return gorilla_paragraph( $text, 'eyebrow' );
}

/**
 * Single core/button. Wrap one or more in gorilla_buttons().
 *
 * @param string $label       Button label.
 * @param string $url         Link target.
 * @param string $style       Optional block style: outline, light-phone, glass-phone, fill-no-icon.
 * @param string $extra_class Optional extra class, e.g. 'gs-btn-sm'.
 * @return string Block markup, or '' when label is empty.
 */
function gorilla_button( $label, $url, $style = '', $extra_class = '' ) {
	if ( '' === trim( (string) $label ) ) {
		return '';
	}
	$classes = array_filter( array( $style ? 'is-style-' . sanitize_html_class( $style ) : '', $extra_class ) );
	$wrapper = implode( ' ', array_merge( array( 'wp-block-button' ), $classes ) );

	return gorilla_block_open( 'button', array( 'className' => implode( ' ', $classes ) ) ) . "\n"
		. '<div class="' . esc_attr( $wrapper ) . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></div>' . "\n"
		. '<!-- /wp:button -->';
}

/**
 * Wrap buttons in a core/buttons block.
 *
 * @param string[] $buttons Markup from gorilla_button().
 * @return string Block markup, or '' when no buttons.
 */
function gorilla_buttons( $buttons ) {
	$buttons = array_filter( (array) $buttons );
	if ( ! $buttons ) {
		return '';
	}
	return "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">" . implode( "\n", $buttons ) . "</div>\n<!-- /wp:buttons -->";
}

/**
 * Image block from a theme image name. Returns '' when the file is missing (AGENTS.md §6).
 *
 * @param string $name  Base name in assets/images/, e.g. 'about-portrait'.
 * @param string $alt   Alt text; '' for decorative images.
 * @param string $style Optional block style, e.g. 'deco-frame-left'.
 * @return string
 */
function gorilla_image( $name, $alt = '', $style = '' ) {
	$src = gorilla_img( $name );
	if ( '' === $src ) {
		return '';
	}
	$class   = $style ? 'is-style-' . sanitize_html_class( $style ) : '';
	$classes = trim( 'wp-block-image size-full ' . $class );

	return gorilla_block_open(
		'image',
		array(
			'sizeSlug'  => 'full',
			'className' => $class,
		)
	) . "\n"
		. '<figure class="' . esc_attr( $classes ) . '"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '"/></figure>' . "\n"
		. '<!-- /wp:image -->';
}

/**
 * Decorative icon circle (CSS mask icon from assets/icons/).
 *
 * @param string $name     Icon name, e.g. 'cctv'.
 * @param string $modifier Optional modifier: sm, md, dark, solid.
 * @return string
 */
function gorilla_icon( $name, $modifier = '' ) {
	$classes = 'gs-icon-circle gs-ico-' . sanitize_html_class( $name );
	if ( $modifier ) {
		$classes .= ' gs-icon-circle--' . sanitize_html_class( $modifier );
	}
	return gorilla_block_open( 'group', array( 'className' => $classes ) ) . "\n"
		. '<div class="wp-block-group ' . esc_attr( $classes ) . '"></div>' . "\n"
		. '<!-- /wp:group -->';
}

/**
 * Round previous/next arrow buttons for sliders (enhanced by assets/js/gorilla.js).
 *
 * @param string $controls ID of the element the arrows scroll.
 * @return string
 */
function gorilla_arrows( $controls ) {
	$id = esc_attr( $controls );
	return "<!-- wp:html -->\n"
		. '<div class="gs-arrows">'
		. '<button type="button" class="gs-arrow gs-ico-arrow-left" data-gs-dir="prev" aria-controls="' . $id . '" aria-label="' . esc_attr__( 'Previous', 'gorilla-security' ) . '"></button>'
		. '<button type="button" class="gs-arrow gs-ico-arrow-right" data-gs-dir="next" aria-controls="' . $id . '" aria-label="' . esc_attr__( 'Next', 'gorilla-security' ) . '"></button>'
		. "</div>\n<!-- /wp:html -->";
}
