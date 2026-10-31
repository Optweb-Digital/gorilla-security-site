<?php
/**
 * Gorilla Security theme bootstrap.
 *
 * Presentation only: enqueue, block-style registry, pattern categories, gsec_img(), gsec_site().
 * Custom post types, meta and integrations belong in the gsec-core mu-plugin.
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
function gsec_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'gsec-components',
		$uri . '/assets/css/components.css',
		array(),
		(string) filemtime( $dir . '/assets/css/components.css' )
	);

	wp_enqueue_script(
		'gsec-gorilla',
		$uri . '/assets/js/gorilla.js',
		array(),
		(string) filemtime( $dir . '/assets/js/gorilla.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	// Translatable strings for gorilla.js (no build step, so no wp.i18n).
	wp_add_inline_script(
		'gsec-gorilla',
		'window.gsecI18n = ' . wp_json_encode(
			array(
				'pauseLogos' => __( 'Pause the moving logos', 'gorilla-security' ),
				'playLogos'  => __( 'Play the moving logos', 'gorilla-security' ),
				'pauseSteps' => __( 'Pause the reasons slideshow', 'gorilla-security' ),
				'playSteps'  => __( 'Play the reasons slideshow', 'gorilla-security' ),
			)
		) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'gsec_enqueue_assets' );

/**
 * Preload the Poppins files declared in theme.json. Without this they are only requested
 * once text renders, and the late swap from the fallback font shifts the layout (CLS).
 *
 * @param array $resources Resources to preload.
 * @return array
 */
function gsec_preload_fonts( $resources ) {
	foreach ( array( '400', '500', '600' ) as $weight ) {
		$resources[] = array(
			'href'        => get_template_directory_uri() . '/assets/fonts/poppins-' . $weight . '.woff2',
			'as'          => 'font',
			'type'        => 'font/woff2',
			'crossorigin' => 'anonymous',
		);
	}
	return $resources;
}
add_filter( 'wp_preload_resources', 'gsec_preload_fonts' );

/**
 * Load the component stylesheet in the block editor too, so patterns preview correctly.
 *
 * @return void
 */
function gsec_editor_styles() {
	add_editor_style( 'assets/css/components.css' );
}
add_action( 'after_setup_theme', 'gsec_editor_styles' );

/**
 * Register pattern categories shown in the inserter.
 *
 * @return void
 */
function gsec_register_pattern_categories() {
	register_block_pattern_category(
		'gorilla-sections',
		array( 'label' => __( 'Gorilla · Sections', 'gorilla-security' ) )
	);
	register_block_pattern_category(
		'gorilla-components',
		array( 'label' => __( 'Gorilla · Components', 'gorilla-security' ) )
	);
}
add_action( 'init', 'gsec_register_pattern_categories' );

/**
 * Register block styles listed in docs/design-system.md §2.
 *
 * Their CSS lives in assets/css/components.css and is added section by section via /build-section.
 *
 * @return void
 */
function gsec_register_block_styles() {
	$styles = array(
		'core/button'       => array(
			'outline'      => __( 'Outline', 'gorilla-security' ),
			'glass'        => __( 'Glass', 'gorilla-security' ),
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
add_action( 'init', 'gsec_register_block_styles' );

/**
 * Return the URL of a theme image by base name, preferring real photos over placeholders.
 *
 * Looks in assets/images/ for {name}.webp, .jpg, .png, then .svg (labelled placeholder).
 *
 * @param string $name Base file name without extension, e.g. 'hero-bg'.
 * @return string Image URL, or an empty string when no file exists.
 */
function gsec_img( $name ) {
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
 * Phone, email and address come from Figma frame 1:4 (approved 2026-10-31).
 * Hours stay empty until the Figma conflict is resolved — see "Open decisions"
 * in docs/project-context.md. Never invent phone numbers, emails or addresses.
 *
 * @param string $key Optional key: phone, email, address, hours.
 * @return array|string All details, or one value ('' when unknown).
 */
function gsec_site( $key = '' ) {
	$site = apply_filters(
		'gsec/site',
		array(
			'name'    => 'Gorilla Security',
			'phone'   => '0468 532 275',
			'email'   => 'info@gorillasecurity.com.au',
			'address' => '110 Ruskin St, Elwood VIC 3184',
			'hours'   => array(),
		)
	);

	if ( '' === $key ) {
		return $site;
	}
	return isset( $site[ $key ] ) ? $site[ $key ] : '';
}

/**
 * Flag pages whose template opens with a full-bleed hero (main.gs-hero-page), so the
 * header can float over it. A body class rather than CSS :has() keeps the header
 * readable in browsers without :has().
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function gsec_body_class( $classes ) {
	if ( is_front_page() || is_page_template( 'page-landing' ) ) {
		$classes[] = 'gs-has-hero';
	}
	return $classes;
}
add_filter( 'body_class', 'gsec_body_class' );

/**
 * Run shortcodes inside Shortcode blocks when they render.
 *
 * Block templates run do_shortcode() before patterns are expanded, so a shortcode in a
 * pattern placed in a template (e.g. the quote card's Contact Form 7 form) stays literal.
 *
 * @param string $content Rendered shortcode block.
 * @return string
 */
function gsec_render_shortcode_block( $content ) {
	return do_shortcode( $content );
}
add_filter( 'render_block_core/shortcode', 'gsec_render_shortcode_block' );

/**
 * Add width/height (and lazy loading) to Image blocks showing a theme fallback image.
 *
 * WordPress does this only for Media Library images; without dimensions the browser can't
 * reserve space (Lighthouse "unsized-images", CLS). Front end only, so saved block
 * markup — and editor validation — is unchanged. SVG placeholders are skipped.
 *
 * @param string $content Rendered image block.
 * @return string
 */
function gsec_size_theme_images( $content ) {
	$base = get_template_directory_uri() . '/assets/images/';
	if ( false === strpos( $content, $base ) ) {
		return $content;
	}
	$tags = new WP_HTML_Tag_Processor( $content );
	if ( ! $tags->next_tag( 'img' ) || null !== $tags->get_attribute( 'width' ) ) {
		return $content;
	}
	$src = (string) $tags->get_attribute( 'src' );
	if ( 0 !== strpos( $src, $base ) ) {
		return $content;
	}
	$file = get_template_directory() . '/assets/images/' . basename( wp_parse_url( $src, PHP_URL_PATH ) );
	$size = file_exists( $file ) ? wp_getimagesize( $file ) : false;
	if ( ! $size ) {
		return $content;
	}
	$tags->set_attribute( 'width', (string) $size[0] );
	$tags->set_attribute( 'height', (string) $size[1] );
	// Theme photos in Image blocks sit below the hero (its photo is a Cover, not an Image block).
	if ( null === $tags->get_attribute( 'loading' ) ) {
		$tags->set_attribute( 'loading', 'lazy' );
		$tags->set_attribute( 'decoding', 'async' );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/image', 'gsec_size_theme_images' );

/**
 * Site Logo fallback: use assets/images/logo.* until a logo is set in the editor.
 *
 * @param string $html Custom logo markup ('' when no logo is set).
 * @return string
 */
function gsec_logo_fallback( $html ) {
	if ( '' !== $html || has_custom_logo() ) {
		return $html;
	}
	$src = gsec_img( 'logo' );
	if ( '' === $src ) {
		return $html;
	}
	return sprintf(
		'<a href="%1$s" class="custom-logo-link" rel="home"><img src="%2$s" class="custom-logo" width="225" height="75" alt="%3$s" /></a>',
		esc_url( home_url( '/' ) ),
		esc_url( $src ),
		esc_attr( gsec_site( 'name' ) )
	);
}
add_filter( 'get_custom_logo', 'gsec_logo_fallback' );

/**
 * Mark custom navigation links that point at the current page with aria-current="page".
 *
 * Core only does this for links to posts/pages by ID; header links are custom URLs.
 *
 * @param string $content Rendered navigation-link block.
 * @param array  $block   Parsed block.
 * @return string
 */
function gsec_nav_current( $content, $block ) {
	if ( empty( $block['attrs']['url'] ) || ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return $content;
	}
	$request = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );
	$target  = wp_parse_url( $block['attrs']['url'], PHP_URL_PATH );
	if ( trailingslashit( (string) $request ) !== trailingslashit( (string) $target ) ) {
		return $content;
	}
	$tags = new WP_HTML_Tag_Processor( $content );
	if ( $tags->next_tag( 'a' ) ) {
		$tags->set_attribute( 'aria-current', 'page' );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/navigation-link', 'gsec_nav_current', 10, 2 );
