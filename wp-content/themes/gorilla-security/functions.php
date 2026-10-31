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
 * Whether unconfirmed Figma content (business details, third-party marks, reviews) may be shown.
 *
 * Only true where GS_SHOW_PENDING is defined — set in .wp-env.json for local layout QA, never on
 * staging or production. See docs/project-context.md → Open decisions.
 *
 * @return bool
 */
function gs_show_pending() {
	return defined( 'GS_SHOW_PENDING' ) && GS_SHOW_PENDING;
}

/**
 * URL of a pending (unconfirmed, third-party) asset in fixtures/assets/pending/ — local only.
 *
 * @param string $file File name, e.g. 'brand-bosch.png'.
 * @return string URL, or '' when pending content is off or the file is missing.
 */
function gs_pending_img( $file ) {
	$file = sanitize_file_name( $file );
	if ( ! gs_show_pending() || ! file_exists( ABSPATH . 'fixtures/assets/pending/' . $file ) ) {
		return '';
	}
	return home_url( '/fixtures/assets/pending/' . $file );
}

if ( gs_show_pending() ) {
	require_once get_template_directory() . '/inc/pending-content.php';
}

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
	wp_add_inline_script(
		'gs-gorilla',
		'window.gsL10n = ' . wp_json_encode(
			array(
				'pause'        => __( 'Pause logo animation', 'gorilla-security' ),
				'play'         => __( 'Play logo animation', 'gorilla-security' ),
				'closeQuote'   => __( 'Close quote form', 'gorilla-security' ),
				'pauseReviews' => __( 'Pause review slideshow', 'gorilla-security' ),
				'playReviews'  => __( 'Play review slideshow', 'gorilla-security' ),
			)
		) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'gs_enqueue_assets' );

/**
 * Flag JS support before first paint. The no-JS fallbacks (inline nav links, stacked tab panels) would
 * otherwise render first and collapse when the deferred script runs — a large layout shift (CLS).
 *
 * @return void
 */
function gs_js_flag() {
	wp_print_inline_script_tag( "document.documentElement.classList.add('gs-js');" );
}
add_action( 'wp_head', 'gs_js_flag', 1 );

/**
 * Skip the core emoji polyfill on the front end. Every browser the site supports renders emoji natively;
 * the polyfill adds ~13 KB of JS (twemoji + wp-emoji) wherever no emoji font is reported, e.g. CI Chrome,
 * against the 50 KB JS budget (AGENTS.md §7). Feeds and email keep core's emoji handling.
 *
 * @return void
 */
function gs_disable_emoji_polyfill() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	// Core's back-compat hook, normally unhooked by wp_enqueue_emoji_styles(); left alone it prints a deprecation notice.
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'gs_disable_emoji_polyfill' );

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
			'glass'        => __( 'Glass', 'gorilla-security' ),
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
			'glass-rail'   => __( 'Glass rail', 'gorilla-security' ),
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
 * The hero photo is the homepage LCP image: ask the browser to fetch it first.
 *
 * Core gives cover background images no fetchpriority (Lighthouse shows them at "Low"). Scoped to the
 * gs-hero cover so other covers keep the browser default.
 *
 * @param string $content Rendered block content.
 * @param array  $block   Parsed block.
 * @return string
 */
function gs_hero_image_priority( $content, $block ) {
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	$hero  = false !== strpos( ' ' . $class . ' ', ' gs-hero ' );
	$tags  = new WP_HTML_Tag_Processor( $content );
	if ( $tags->next_tag( array( 'class_name' => 'wp-block-cover__image-background' ) ) ) {
		if ( $hero ) {
			$tags->set_attribute( 'fetchpriority', 'high' );
			$tags->remove_attribute( 'loading' );
			// Smaller copies for phones/tablets (a theme-file cover gets no srcset from core).
			$src = (string) $tags->get_attribute( 'src' );
			if ( gs_img( 'hero-bg' ) === $src && gs_img( 'hero-bg-800' ) && gs_img( 'hero-bg-1200' ) ) {
				$tags->set_attribute( 'srcset', gs_img( 'hero-bg-800' ) . ' 800w, ' . gs_img( 'hero-bg-1200' ) . ' 1200w, ' . $src . ' 1676w' );
				$tags->set_attribute( 'sizes', '100vw' );
			}
		} elseif ( null === $tags->get_attribute( 'loading' ) ) {
			// Every other cover photo (quote, CTA, footer) is below the fold.
			$tags->set_attribute( 'loading', 'lazy' );
		}
	}
	return $tags->get_updated_html();
}

/**
 * Width and height of a theme (or local pending) image file, cached in a transient.
 *
 * Reading ~45 files per page view was ~60% of the homepage render time. The cache key includes the image
 * folders' modification times, so adding, removing or replacing files (git checkout and deploys write new
 * files) starts a fresh cache. Overwriting a file in place with different dimensions does not: delete the
 * `gs_img_sizes_*` transient in that case.
 *
 * @param string $path Absolute file path.
 * @return int[] Array( width, height ), or an empty array when the file is missing or unreadable.
 */
function gs_image_size( $path ) {
	static $cache = null;
	static $key   = '';
	if ( null === $cache ) {
		$dirs = array( get_template_directory() . '/assets/images' );
		if ( gs_show_pending() ) {
			$dirs[] = ABSPATH . 'fixtures/assets/pending';
		}
		$stamp = '';
		foreach ( $dirs as $dir ) {
			$stamp .= is_dir( $dir ) ? filemtime( $dir ) . '|' : '0|';
		}
		$key   = 'gs_img_sizes_' . md5( $stamp );
		$cache = get_transient( $key );
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
	}
	if ( ! isset( $cache[ $path ] ) ) {
		$size           = file_exists( $path ) ? wp_getimagesize( $path ) : false;
		$cache[ $path ] = $size ? array( (int) $size[0], (int) $size[1] ) : array();
		set_transient( $key, $cache, WEEK_IN_SECONDS );
	}
	return $cache[ $path ];
}

/**
 * Theme / pending images in image blocks: add width + height (no layout shift) and lazy loading.
 *
 * Pattern markup can't carry the dimensions (block validation), so they come from gs_image_size().
 * The header logo is the only image above the fold and stays eager.
 *
 * @param string $content Rendered block content.
 * @param array  $block   Parsed block.
 * @return string
 */
function gs_image_dimensions( $content, $block ) {
	$tags = new WP_HTML_Tag_Processor( $content );
	if ( ! $tags->next_tag( 'img' ) ) {
		return $content;
	}
	$src  = (string) $tags->get_attribute( 'src' );
	$path = '';
	if ( 0 === strpos( $src, get_template_directory_uri() ) ) {
		$path = get_template_directory() . substr( $src, strlen( get_template_directory_uri() ) );
	} elseif ( 0 === strpos( $src, home_url( '/fixtures/assets/pending/' ) ) ) {
		$path = ABSPATH . 'fixtures/assets/pending/' . basename( $src );
	}
	if ( $path && null === $tags->get_attribute( 'width' ) ) {
		$size = gs_image_size( $path );
		if ( $size ) {
			$tags->set_attribute( 'width', (string) $size[0] );
			$tags->set_attribute( 'height', (string) $size[1] );
		}
	}
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( false === strpos( $class, 'gs-header__logo' ) && null === $tags->get_attribute( 'loading' ) ) {
		$tags->set_attribute( 'loading', 'lazy' );
		$tags->set_attribute( 'decoding', 'async' );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/image', 'gs_image_dimensions', 10, 2 );
add_filter( 'render_block_core/cover', 'gs_hero_image_priority', 10, 2 );

/**
 * Mark custom navigation links that point at the current page with aria-current="page".
 *
 * Core only does this for links to post objects. Links with a #fragment (in-page sections) are skipped.
 *
 * @param string $content Rendered block content.
 * @param array  $block   Parsed block.
 * @return string
 */
function gs_nav_current( $content, $block ) {
	$url = isset( $block['attrs']['url'] ) ? $block['attrs']['url'] : '';
	if ( '' === $url || false !== strpos( $url, '#' ) || ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return $content;
	}
	$path    = untrailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) );
	$request = untrailingslashit( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) );
	if ( $path !== $request ) {
		return $content;
	}
	$tags = new WP_HTML_Tag_Processor( $content );
	if ( $tags->next_tag( 'a' ) ) {
		$tags->set_attribute( 'aria-current', 'page' );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/navigation-link', 'gs_nav_current', 10, 2 );

/**
 * Make slider tracks keyboard-scrollable without JS (WCAG 2.1.1): a focusable, labelled region.
 *
 * Group blocks cannot save tabindex/role, so they are added at render time.
 *
 * @param string $content Rendered block content.
 * @param array  $block   Parsed block.
 * @return string
 */
function gs_slider_track_region( $content, $block ) {
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( false === strpos( ' ' . $class . ' ', ' gs-slider__track ' ) ) {
		return $content;
	}
	$tags = new WP_HTML_Tag_Processor( $content );
	if ( $tags->next_tag() ) {
		$tags->set_attribute( 'tabindex', '0' );
		$tags->set_attribute( 'role', 'region' );
		$tags->set_attribute( 'aria-label', __( 'Customer reviews', 'gorilla-security' ) );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/group', 'gs_slider_track_region', 10, 2 );

/**
 * Expand shortcodes inside core/shortcode blocks wherever they render.
 *
 * Block templates run do_shortcode() before do_blocks(), so a shortcode inside a pattern referenced from a
 * template (e.g. the CF7 form in quote-card, nested in hero) would otherwise print as plain text.
 *
 * @param string $content Rendered block content.
 * @return string
 */
function gs_render_shortcode_block( $content ) {
	// The block already ran wpautop(); unwrap the <p> first so a form isn't nested inside a paragraph.
	return do_shortcode( shortcode_unautop( $content ) );
}
add_filter( 'render_block_core/shortcode', 'gs_render_shortcode_block' );

/**
 * Contact Form 7 wraps its hidden inputs in an unnamed <fieldset> with no legend, which fails
 * WCAG H71 / H91 checks (Gate 3) on every page with a form. It holds only type="hidden" inputs, so a
 * plain <div> is equivalent; CF7's script reads those inputs by name, not by their wrapper.
 *
 * @param string $output Shortcode output.
 * @param string $tag    Shortcode tag.
 * @return string
 */
function gs_cf7_hidden_fields_wrapper( $output, $tag ) {
	if ( 'contact-form-7' !== $tag ) {
		return $output;
	}
	return preg_replace( '#<fieldset class="hidden-fields-container">(.*?)</fieldset>#s', '<div class="hidden-fields-container">$1</div>', $output, 1 );
}
add_filter( 'do_shortcode_tag', 'gs_cf7_hidden_fields_wrapper', 10, 2 );

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
 * @param string $key Optional key: phone, email, address, hours, social (service => verified profile URL).
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
			'social'  => array(), // e.g. 'instagram' => 'https://…' — verified profile URLs only.
		)
	);

	if ( '' === $key ) {
		return $site;
	}
	return isset( $site[ $key ] ) ? $site[ $key ] : '';
}
