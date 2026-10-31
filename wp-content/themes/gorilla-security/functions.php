<?php
/**
 * Gorilla Security theme bootstrap.
 *
 * Presentation only: enqueue, block-style registry, pattern categories, gorilla_img(), gorilla_site().
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
function gorilla_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'gorilla-components',
		$uri . '/assets/css/components.css',
		array(),
		(string) filemtime( $dir . '/assets/css/components.css' )
	);

	wp_enqueue_script(
		'gorilla-script',
		$uri . '/assets/js/gorilla.js',
		array(),
		(string) filemtime( $dir . '/assets/js/gorilla.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	wp_localize_script(
		'gorilla-script',
		'gorillaL10n',
		array(
			'pauseLogos' => __( 'Pause logo animation', 'gorilla-security' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'gorilla_enqueue_assets' );

/**
 * Drop WordPress's emoji polyfill (twemoji + wp-emoji, ~13 KB): browsers render emoji natively,
 * and the JS budget is 50 KB (AGENTS.md §7).
 *
 * @return void
 */
function gorilla_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'gorilla_disable_emoji' );

/**
 * Run shortcodes inside Shortcode blocks that come from patterns.
 *
 * Block templates run do_shortcode() before do_blocks(), so a [shortcode] inside a pattern
 * (e.g. the CF7 form in the quote card) would otherwise print as text. Post content is left to
 * core's own do_shortcode() (the_content, priority 11) so shortcodes never run twice.
 * The block's autop wraps the shortcode in <p>; around a <div> the browser splits that into empty
 * <p>s that add layout gaps, so the wrapper is dropped.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function gorilla_render_shortcode_block( $block_content ) {
	if ( doing_filter( 'the_content' ) ) {
		return (string) preg_replace( '#^\s*<p>\s*(\[.*\])\s*</p>\s*$#s', '$1', $block_content );
	}
	$html = do_shortcode( $block_content );
	return (string) preg_replace( '#<p>\s*(<div\b.*</div>)\s*</p>#s', '$1', $html );
}
add_filter( 'render_block_core/shortcode', 'gorilla_render_shortcode_block' );

/**
 * Load the component stylesheet in the block editor too, so patterns preview correctly.
 *
 * @return void
 */
function gorilla_editor_styles() {
	add_editor_style( 'assets/css/components.css' );
}
add_action( 'after_setup_theme', 'gorilla_editor_styles' );

/**
 * Register pattern categories shown in the inserter.
 *
 * @return void
 */
function gorilla_register_pattern_categories() {
	register_block_pattern_category(
		'gorilla-sections',
		array( 'label' => __( 'Gorilla · Sections', 'gorilla-security' ) )
	);
	register_block_pattern_category(
		'gorilla-components',
		array( 'label' => __( 'Gorilla · Components', 'gorilla-security' ) )
	);
}
add_action( 'init', 'gorilla_register_pattern_categories' );

/**
 * Register block styles listed in docs/design-system.md §2.
 *
 * Their CSS lives in assets/css/components.css and is added section by section via /build-section.
 *
 * @return void
 */
function gorilla_register_block_styles() {
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
add_action( 'init', 'gorilla_register_block_styles' );

/**
 * Mark a custom navigation link to the home URL as current on the front page.
 *
 * Core only marks links to a post ID as current, so the header's "Home" link was never active.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block.
 * @return string
 */
function gorilla_mark_home_nav_link( $block_content, $block ) {
	$url = isset( $block['attrs']['url'] ) ? $block['attrs']['url'] : '';
	if ( ! is_front_page() || untrailingslashit( $url ) !== untrailingslashit( home_url( '/' ) ) ) {
		return $block_content;
	}
	$tags = new WP_HTML_Tag_Processor( $block_content );
	if ( $tags->next_tag( 'li' ) ) {
		$tags->add_class( 'current-menu-item' );
	}
	if ( $tags->next_tag( 'a' ) ) {
		$tags->set_attribute( 'aria-current', 'page' );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/navigation-link', 'gorilla_mark_home_nav_link', 10, 2 );

/**
 * Return the URL of a theme image by base name, preferring real photos over placeholders.
 *
 * Looks in assets/images/ for {name}.webp, .jpg, .png, then .svg (labelled placeholder).
 *
 * @param string $name Base file name without extension, e.g. 'hero-bg'.
 * @return string Image URL, or an empty string when no file exists.
 */
function gorilla_img( $name ) {
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
 * Intrinsic size of a theme image (assets/images) from its URL, or null for other images.
 *
 * @param string $src Image URL.
 * @return array{0:int,1:int}|null
 */
function gorilla_theme_image_size( $src ) {
	static $cache = array();
	$base         = get_template_directory_uri() . '/assets/images/';
	if ( 0 !== strpos( $src, $base ) ) {
		return null;
	}
	if ( isset( $cache[ $src ] ) ) {
		return $cache[ $src ];
	}
	$file = get_template_directory() . '/assets/images/' . sanitize_file_name( wp_basename( wp_parse_url( $src, PHP_URL_PATH ) ) );
	$size = null;
	if ( is_readable( $file ) ) {
		if ( str_ends_with( $file, '.svg' ) ) {
			$svg = (string) file_get_contents( $file, false, null, 0, 600 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file, header only.
			if ( preg_match( '/width="(\d+)"[^>]*height="(\d+)"/', $svg, $m ) ) {
				$size = array( (int) $m[1], (int) $m[2] );
			}
		} else {
			$info = getimagesize( $file );
			$size = $info ? array( (int) $info[0], (int) $info[1] ) : null;
		}
	}
	$cache[ $src ] = $size;
	return $size;
}

/**
 * Theme images in image blocks: add width/height (no layout shift) and lazy loading.
 *
 * Core only lazy-loads images that already have dimensions, which pattern-built image blocks lack.
 * Logos stay eager: they are tiny, sit near the top, and are sized "auto" from the loaded file (a lazy
 * 0×0 image would never load). Media Library images are left to core.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function gorilla_optimize_theme_image( $block_content ) {
	$tags = new WP_HTML_Tag_Processor( $block_content );
	if ( ! $tags->next_tag( 'img' ) ) {
		return $block_content;
	}
	$size = gorilla_theme_image_size( (string) $tags->get_attribute( 'src' ) );
	if ( ! $size ) {
		return $block_content;
	}
	if ( null === $tags->get_attribute( 'width' ) ) {
		$tags->set_attribute( 'width', (string) $size[0] );
		$tags->set_attribute( 'height', (string) $size[1] );
	}
	$is_logo = (bool) preg_match( '/gs-(header__logo|footer__logo|trust-strip__logo|marquee__logo|review-badge__source)/', $block_content );
	if ( null === $tags->get_attribute( 'loading' ) && ! $is_logo ) {
		$tags->set_attribute( 'loading', 'lazy' );
	}
	$tags->set_attribute( 'decoding', 'async' );
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/image', 'gorilla_optimize_theme_image' );

/**
 * Cover photos from the theme: add dimensions. The hero's is the LCP image (fetch priority);
 * every other cover photo is below the fold and lazy-loads.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function gorilla_optimize_cover_image( $block_content ) {
	$tags = new WP_HTML_Tag_Processor( $block_content );
	if ( ! $tags->next_tag(
		array(
			'tag_name'   => 'img',
			'class_name' => 'wp-block-cover__image-background',
		)
	) ) {
		return $block_content;
	}
	$size = gorilla_theme_image_size( (string) $tags->get_attribute( 'src' ) );
	if ( ! $size ) {
		return $block_content;
	}
	if ( null === $tags->get_attribute( 'width' ) ) {
		$tags->set_attribute( 'width', (string) $size[0] );
		$tags->set_attribute( 'height', (string) $size[1] );
	}
	if ( false !== strpos( $block_content, 'gs-hero' ) ) {
		$tags->set_attribute( 'fetchpriority', 'high' );
		$tags->remove_attribute( 'loading' );
	} elseif ( null === $tags->get_attribute( 'loading' ) ) {
		$tags->set_attribute( 'loading', 'lazy' );
		$tags->set_attribute( 'decoding', 'async' );
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block_core/cover', 'gorilla_optimize_cover_image' );

/**
 * Site-wide business details used by patterns (header, footer, contact card).
 *
 * Values are the ones shown in Figma 1:4 (header 1:531, footer 1:469 / 1:485, contact card 1:199).
 * Social URLs are not in Figma and stay empty until supplied. Figma shows two different opening
 * hours (contact card vs footer); both are kept as designed until the client confirms one —
 * see "Open decisions" in docs/project-context.md.
 *
 * @param string $key Optional key: phone, email, address, hours, hours_card, social (service => URL).
 * @return array|string All details, or one value ('' when unknown).
 */
function gorilla_site( $key = '' ) {
	$site = apply_filters(
		'gorilla/site',
		array(
			'name'       => 'Gorilla Security',
			'phone'      => '0468 532 275',
			'email'      => 'info@gorillasecurity.com.au',
			'address'    => '110 Ruskin St, Elwood VIC 3184',
			'hours'      => array(
				array(
					'days' => 'Mon to Fri',
					'time' => '5:30am – 7pm',
				),
				array(
					'days' => 'Sat to Sun',
					'time' => '5:30am – 5pm',
				),
			),
			'hours_card' => array(
				'days' => 'Mon–Sat',
				'time' => '8:00 AM–6:00 PM',
			),
			'social'     => array(
				'instagram' => '',
				'facebook'  => '',
				'x'         => '',
				'linkedin'  => '',
			),
		)
	);

	if ( '' === $key ) {
		return $site;
	}
	return isset( $site[ $key ] ) ? $site[ $key ] : '';
}
