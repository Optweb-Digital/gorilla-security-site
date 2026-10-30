<?php
/**
 * Gorilla Security theme bootstrap.
 *
 * Presentation only: enqueue, block-style registry, pattern categories, gs_img(), gs_site().
 * Custom post types, meta and integrations belong in the gs-core mu-plugin.
 *
 * @package gorilla-security
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/pattern-helpers.php';

/**
 * Enqueue the component stylesheet and the progressive-enhancement script.
 *
 * @return void
 */
function gs_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'gs-components',
		$uri . '/assets/css/components.css',
		array(),
		(string) filemtime( $dir . '/assets/css/components.css' )
	);

	wp_enqueue_script(
		'gs-gorilla',
		$uri . '/assets/js/gorilla.js',
		array(),
		(string) filemtime( $dir . '/assets/js/gorilla.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'gs_enqueue_assets' );

/**
 * Load the component stylesheet in the block editor too, so patterns preview correctly.
 *
 * @return void
 */
function gs_editor_styles() {
	add_editor_style( 'assets/css/components.css' );
}
add_action( 'after_setup_theme', 'gs_editor_styles' );

/**
 * Register pattern categories shown in the inserter.
 *
 * @return void
 */
function gs_register_pattern_categories() {
	register_block_pattern_category(
		'gorilla-sections',
		array( 'label' => __( 'Gorilla · Sections', 'gorilla-security' ) )
	);
	register_block_pattern_category(
		'gorilla-components',
		array( 'label' => __( 'Gorilla · Components', 'gorilla-security' ) )
	);
}
add_action( 'init', 'gs_register_pattern_categories' );

/**
 * Register block styles listed in docs/design-system.md §2.
 *
 * Their CSS lives in assets/css/components.css and is added section by section via /build-section.
 *
 * @return void
 */
function gs_register_block_styles() {
	$styles = array(
		'core/button'       => array(
			'outline'      => __( 'Outline', 'gorilla-security' ),
			'light-phone'  => __( 'Light · phone', 'gorilla-security' ),
			'glass-phone'  => __( 'Glass · phone', 'gorilla-security' ),
			'fill-no-icon' => __( 'Fill · no icon', 'gorilla-security' ),
		),
		'core/paragraph'    => array(
			'eyebrow'       => __( 'Eyebrow', 'gorilla-security' ),
			'lead-with-bar' => __( 'Lead with bar', 'gorilla-security' ),
		),
		'core/group'        => array(
			'card'                 => __( 'Card', 'gorilla-security' ),
			'card-tint'            => __( 'Card · tint', 'gorilla-security' ),
			'glass-light'          => __( 'Glass · light', 'gorilla-security' ),
			'glass-dark'           => __( 'Glass · dark', 'gorilla-security' ),
			'glass-violet-outline' => __( 'Glass · violet outline', 'gorilla-security' ),
		),
		'core/columns'      => array(
			'stats-with-dividers' => __( 'Stats with dividers', 'gorilla-security' ),
		),
		'core/list'         => array(
			'checklist' => __( 'Checklist', 'gorilla-security' ),
		),
		'core/image'        => array(
			'deco-frame-left'  => __( 'Deco frame · left', 'gorilla-security' ),
			'deco-frame-right' => __( 'Deco frame · right', 'gorilla-security' ),
		),
		'core/details'      => array(
			'faq-numbered' => __( 'FAQ (numbered)', 'gorilla-security' ),
		),
		'core/social-links' => array(
			'tint-circles' => __( 'Tint circles', 'gorilla-security' ),
		),
	);

	foreach ( $styles as $block => $block_styles ) {
		foreach ( $block_styles as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'gs_register_block_styles' );

/**
 * Return the URL of a theme image by base name, preferring real photos over placeholders.
 *
 * Looks in assets/images/ for {name}.webp, .jpg, .png, then .svg (labelled placeholder).
 *
 * @param string $name Base file name without extension, e.g. 'hero-bg'.
 * @return string Image URL, or an empty string when no file exists.
 */
function gs_img( $name ) {
	$name = sanitize_file_name( $name );
	foreach ( array( 'webp', 'jpg', 'png', 'svg' ) as $ext ) {
		$relative = '/assets/images/' . $name . '.' . $ext;
		if ( file_exists( get_template_directory() . $relative ) ) {
			return get_template_directory_uri() . $relative;
		}
	}
	return '';
}

/**
 * Site-wide business details used by patterns (header, footer, contact card).
 *
 * Values are intentionally empty until confirmed — see "Open decisions" in
 * docs/project-context.md. Never invent phone numbers, emails or addresses.
 *
 * @param string $key Optional key: phone, email, address, hours.
 * @return array|string All details, or one value ('' when unknown).
 */
function gs_site( $key = '' ) {
	$site = apply_filters(
		'gs/site',
		array(
			'name'    => 'Gorilla Security',
			'phone'   => '',
			'email'   => '',
			'address' => '',
			'hours'   => array(),
		)
	);

	if ( '' === $key ) {
		return $site;
	}
	return isset( $site[ $key ] ) ? $site[ $key ] : '';
}
