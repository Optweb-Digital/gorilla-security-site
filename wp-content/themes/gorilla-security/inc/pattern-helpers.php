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
function gs_block_open( $block, $attrs = array() ) {
	$attrs = array_filter(
		$attrs,
		static function ( $value ) {
			return null !== $value && '' !== $value && array() !== $value;
		}
	);

	// Core's serializer escapes "--", "<", ">" and "&" exactly like the editor does (BEM "--modifier" classes).
	$json = $attrs ? ' ' . serialize_block_attributes( $attrs ) : '';
	return '<!-- wp:' . $block . $json . ' -->';
}

/**
 * Convert a preset slug to the class WordPress generates for it (e.g. 'h2' → 'h-2').
 *
 * @param string $slug Preset slug.
 * @return string
 */
function gs_slug_class( $slug ) {
	return function_exists( '_wp_to_kebab_case' ) ? _wp_to_kebab_case( $slug ) : sanitize_html_class( $slug );
}

/**
 * Heading with [[accent]] words rendered as <mark> (the editor's Highlight format).
 *
 * @param string $text Heading text. Wrap accent words in [[double brackets]]; "\n" becomes a line break.
 * @param array  $args { level: int 1–6, size: font-size slug, class: extra classes, align: left|center|right }.
 * @return string Block markup, or '' when $text is empty.
 */
function gs_heading( $text, $args = array() ) {
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
	// A newline in the text is the Figma line break (e.g. "Smarter Security.\nSafer Spaces.").
	$html = str_replace( "\n", '<br>', $html );

	$classes = array( 'wp-block-heading' );
	if ( $args['align'] ) {
		$classes[] = 'has-text-align-' . sanitize_html_class( $args['align'] );
	}
	if ( $args['class'] ) {
		$classes[] = $args['class'];
	}
	if ( $args['size'] ) {
		$classes[] = 'has-' . gs_slug_class( $args['size'] ) . '-font-size';
	}

	$attrs = array(
		'textAlign' => $args['align'],
		'level'     => 2 === $level ? null : $level,
		'className' => $args['class'],
		'fontSize'  => $args['size'],
	);

	return gs_block_open( 'heading', $attrs ) . "\n"
		. '<h' . $level . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $html . '</h' . $level . '>' . "\n"
		. '<!-- /wp:heading -->';
}

/**
 * Paragraph helper (optionally with a block style such as 'eyebrow' or 'lead-with-bar').
 *
 * @param string $text  Paragraph text.
 * @param string $style Block style name without the is-style- prefix.
 * @param string $size  Optional font-size slug.
 * @param string $extra Optional component class, e.g. 'gs-stat__num'.
 * @return string Block markup, or '' when $text is empty.
 */
function gs_paragraph( $text, $style = '', $size = '', $extra = '' ) {
	if ( '' === trim( (string) $text ) ) {
		return '';
	}
	$class   = trim( ( $style ? 'is-style-' . sanitize_html_class( $style ) : '' ) . ' ' . implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $extra ) ) ) );
	$classes = array_filter( array( $class, $size ? 'has-' . gs_slug_class( $size ) . '-font-size' : '' ) );
	$attr    = $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '';

	return gs_block_open(
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
function gs_eyebrow( $text ) {
	return gs_paragraph( $text, 'eyebrow' );
}

/**
 * Single core/button. Wrap one or more in gs_buttons().
 *
 * @param string $label Button label.
 * @param string $url   Link target.
 * @param string $style Optional block style: outline, light-phone, glass-phone, fill-no-icon.
 * @param string $css_class Optional extra class(es), space-separated, e.g. 'gs-btn-sm'.
 * @param string $sr_suffix Optional visually hidden text appended to the label, so repeated labels
 *                          ("Know More") get a unique accessible name.
 * @return string Block markup, or '' when label is empty.
 */
function gs_button( $label, $url, $style = '', $css_class = '', $sr_suffix = '' ) {
	if ( '' === trim( (string) $label ) ) {
		return '';
	}
	$classes = array_filter(
		array_merge(
			array( $style ? 'is-style-' . sanitize_html_class( $style ) : '' ),
			array_map( 'sanitize_html_class', explode( ' ', $css_class ) )
		)
	);
	$wrapper = implode( ' ', array_merge( array( 'wp-block-button' ), $classes ) );

	return gs_block_open( 'button', array( 'className' => implode( ' ', $classes ) ) ) . "\n"
		. '<div class="' . esc_attr( $wrapper ) . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">' . esc_html( $label )
		. ( '' !== $sr_suffix ? '<span class="screen-reader-text">' . esc_html( $sr_suffix ) . '</span>' : '' )
		. '</a></div>' . "\n"
		. '<!-- /wp:button -->';
}

/**
 * Wrap buttons in a core/buttons block.
 *
 * @param string[] $buttons Markup from gs_button().
 * @return string Block markup, or '' when no buttons.
 */
function gs_buttons( $buttons ) {
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
 * @param array  $args  { class: extra classes, src: explicit image URL (e.g. from gs_pending_img()) }.
 * @return string
 */
function gs_image( $name, $alt = '', $style = '', $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class' => '', // Extra component class, e.g. 'gs-about__photo'.
			'src'   => '', // Explicit URL (e.g. from gs_pending_img()) instead of a theme image name.
		)
	);
	$src  = $args['src'] ? $args['src'] : gs_img( $name );
	if ( '' === $src ) {
		return '';
	}
	$class   = trim( ( $style ? 'is-style-' . sanitize_html_class( $style ) : '' ) . ' ' . $args['class'] );
	$classes = trim( 'wp-block-image size-full ' . $class );

	return gs_block_open(
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
 * Opening markup of a core/group block. Close with gs_group_close() using the same tag.
 *
 * @param string $css_class Component classes.
 * @param array  $args  { tag: div|section|ul…, align: wide|full, anchor: id, layout: array }.
 * @return string
 */
function gs_group_open( $css_class, $args = array() ) {
	$args    = wp_parse_args(
		$args,
		array(
			'tag'    => 'div',
			'align'  => '',
			'anchor' => '',
			'layout' => array( 'type' => 'constrained' ),
		)
	);
	$classes = array_filter( array( 'wp-block-group', $args['align'] ? 'align' . $args['align'] : '', $css_class ) );
	$id      = $args['anchor'] ? ' id="' . esc_attr( $args['anchor'] ) . '"' : '';

	return gs_block_open(
		'group',
		array(
			'tagName'   => 'div' === $args['tag'] ? null : $args['tag'],
			'align'     => $args['align'],
			'className' => $css_class,
			'layout'    => $args['layout'],
			'anchor'    => $args['anchor'],
		)
	) . "\n<" . tag_escape( $args['tag'] ) . $id . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">';
}

/**
 * Closing markup for gs_group_open().
 *
 * @param string $tag Same tag passed to gs_group_open().
 * @return string
 */
function gs_group_close( $tag = 'div' ) {
	return '</' . tag_escape( $tag ) . ">\n<!-- /wp:group -->";
}

/**
 * Opening markup of a core/columns block (close with "</div>\n<!-- /wp:columns -->").
 *
 * @param string $css_class Component classes.
 * @param array  $args  { align: wide|full, stack: bool (stack on mobile, default true),
 *                       valign: top|center|bottom (core vertical alignment; core forces align-items: normal otherwise) }.
 * @return string
 */
function gs_columns_open( $css_class, $args = array() ) {
	$args    = wp_parse_args(
		$args,
		array(
			'align'  => '',
			'stack'  => true,
			'valign' => '',
		)
	);
	$valign  = $args['valign'] ? sanitize_html_class( $args['valign'] ) : '';
	$classes = array_filter( array( 'wp-block-columns', $valign ? 'are-vertically-aligned-' . $valign : '', $args['align'] ? 'align' . $args['align'] : '', $args['stack'] ? '' : 'is-not-stacked-on-mobile', $css_class ) );

	return gs_block_open(
		'columns',
		array(
			'verticalAlignment' => $valign ? $valign : null,
			'align'             => $args['align'],
			'isStackedOnMobile' => $args['stack'] ? null : false,
			'className'         => $css_class,
		)
	) . "\n" . '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
}

/**
 * Opening markup of a core/column block (close with "</div>\n<!-- /wp:column -->").
 *
 * @param string $css_class Component classes.
 * @param string $valign    Optional top|center|bottom — core's per-column vertical alignment (align-self), which
 *                          is what actually aligns columns (the parent's align-items is forced to normal by core).
 * @return string
 */
function gs_column_open( $css_class, $valign = '' ) {
	$valign = $valign ? sanitize_html_class( $valign ) : '';
	$class  = trim( 'wp-block-column ' . ( $valign ? 'is-vertically-aligned-' . $valign . ' ' : '' ) . $css_class );
	return gs_block_open(
		'column',
		array(
			'verticalAlignment' => $valign ? $valign : null,
			'className'         => $css_class,
		)
	) . "\n" . '<div class="' . esc_attr( $class ) . '">';
}

/**
 * Core/list block with one list-item block per entry.
 *
 * @param string[] $items Item text (plain; escaped here).
 * @param string   $style Optional list style, e.g. 'checklist'.
 * @param string   $css_class Optional extra class.
 * @return string Block markup, or '' when there are no items.
 */
function gs_list( $items, $style = '', $css_class = '' ) {
	$items = array_filter( array_map( 'trim', (array) $items ) );
	if ( ! $items ) {
		return '';
	}
	$css_class = trim( ( $style ? 'is-style-' . sanitize_html_class( $style ) : '' ) . ' ' . $css_class );
	$out       = gs_block_open( 'list', array( 'className' => $css_class ) ) . "\n" . '<ul class="' . esc_attr( trim( 'wp-block-list ' . $css_class ) ) . '">';
	foreach ( $items as $item ) {
		$out .= "<!-- wp:list-item -->\n<li>" . esc_html( $item ) . "</li>\n<!-- /wp:list-item -->";
	}
	return $out . "</ul>\n<!-- /wp:list -->";
}

/**
 * Split section: copy column + photo with deco frame (Figma 1:220 / 1:238 / 1:253).
 *
 * @param array $args Options: class, anchor, eyebrow, heading ([[accent]] syntax), body (block markup strings),
 *                    buttons (block markup), image (theme image name), alt, side ('right' = photo right, or 'left').
 * @return string Balanced block markup.
 */
function gs_split( $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'   => '',
			'anchor'  => '',
			'eyebrow' => '',
			'heading' => '',
			'body'    => array(),
			'buttons' => '',
			'image'   => '',
			'alt'     => '',
			'side'    => 'right',
		)
	);

	$text = gs_column_open( 'gs-split__text', 'center' )
		. ( $args['eyebrow'] ? gs_eyebrow( $args['eyebrow'] ) : '' )
		. gs_heading( $args['heading'], array( 'class' => 'gs-split__title' ) )
		. implode( "\n", (array) $args['body'] )
		. $args['buttons']
		. "</div>\n<!-- /wp:column -->";

	$photo = gs_image( $args['image'], $args['alt'], 'left' === $args['side'] ? 'deco-frame-left' : 'deco-frame-right', array( 'class' => 'gs-split__photo' ) );
	$media = gs_column_open( 'gs-split__media', 'center' ) . $photo . "</div>\n<!-- /wp:column -->";

	return gs_group_open(
		trim( 'gs-section gs-split gs-split--photo-' . $args['side'] . ' ' . $args['class'] ),
		array(
			'tag'    => 'section',
			'align'  => 'full',
			'anchor' => $args['anchor'],
		)
	)
		. gs_columns_open(
			'gs-split__grid',
			array(
				'align'  => 'wide',
				'valign' => 'center', // Figma 1:220 / 1:238 / 1:253: the image is centred against the copy.
			)
		)
		. ( 'left' === $args['side'] ? $media . $text : $text . $media )
		. "</div>\n<!-- /wp:columns -->"
		. gs_group_close( 'section' );
}

/**
 * Core/list of links.
 *
 * @param array  $links Label => URL.
 * @param string $css_class List class.
 * @return string
 */
function gs_link_list( $links, $css_class = '' ) {
	$out = gs_block_open( 'list', array( 'className' => $css_class ) ) . "\n" . '<ul class="' . esc_attr( trim( 'wp-block-list ' . $css_class ) ) . '">';
	foreach ( $links as $label => $url ) {
		$out .= "<!-- wp:list-item -->\n<li><a href=\"" . esc_url( $url ) . '">' . esc_html( $label ) . "</a></li>\n<!-- /wp:list-item -->";
	}
	return $out . "</ul>\n<!-- /wp:list -->";
}

/**
 * Self-closing core/navigation-link block.
 *
 * @param string $label Link text.
 * @param string $url   Link URL.
 * @return string
 */
function gs_nav_link( $label, $url ) {
	return '<!-- wp:navigation-link ' . serialize_block_attributes(
		array(
			'label'          => $label,
			'url'            => $url,
			'kind'           => 'custom',
			'isTopLevelLink' => true,
		)
	) . ' /-->';
}

/**
 * The phone number as a tel: URL ('' when unknown).
 *
 * @param string $phone Display phone number.
 * @return string
 */
function gs_tel( $phone ) {
	$digits = preg_replace( '/[^0-9+]/', '', (string) $phone );
	return $digits ? 'tel:' . $digits : '';
}

/**
 * Feature row: icon circle + title + text (Figma 1:29). Title is an <h3> by default.
 *
 * @param string $icon  Icon name in assets/icons/.
 * @param string $title Title.
 * @param string $text  Description ('' to omit).
 * @param int    $level Heading level for the title.
 * @return string
 */
function gs_feature( $icon, $title, $text, $level = 3 ) {
	return gs_group_open(
		'gs-feature',
		array(
			'layout' => array(
				'type'              => 'flex',
				'flexWrap'          => 'nowrap',
				'verticalAlignment' => 'top',
			),
		)
	)
		. gs_icon( $icon )
		. gs_group_open( 'gs-feature__text', array( 'layout' => array( 'type' => 'default' ) ) )
		. gs_heading(
			$title,
			array(
				'level' => $level,
				'size'  => 'card-title',
				'class' => 'gs-feature__title',
			)
		)
		. gs_paragraph( $text, '', '', 'gs-feature__desc' )
		. gs_group_close()
		. gs_group_close();
}

/**
 * Decorative icon circle (CSS mask icon from assets/icons/).
 *
 * @param string $name     Icon name, e.g. 'cctv'.
 * @param string $modifier Optional modifier: sm, md, dark, solid.
 * @return string
 */
function gs_icon( $name, $modifier = '' ) {
	$classes = 'gs-icon-circle gs-ico-' . sanitize_html_class( $name );
	if ( $modifier ) {
		$classes .= ' gs-icon-circle--' . sanitize_html_class( $modifier );
	}
	return gs_block_open( 'group', array( 'className' => $classes ) ) . "\n"
		. '<div class="wp-block-group ' . esc_attr( $classes ) . '"></div>' . "\n"
		. '<!-- /wp:group -->';
}

/**
 * Round previous/next arrow buttons for sliders and tabs (enhanced by assets/js/gorilla.js).
 *
 * @param string $controls ID of the element the arrows scroll or switch.
 * @param array  $labels   Optional accessible names: 'prev', 'next'.
 * @return string
 */
function gs_arrows( $controls, $labels = array() ) {
	$id     = esc_attr( $controls );
	$labels = wp_parse_args(
		$labels,
		array(
			'prev' => __( 'Previous', 'gorilla-security' ),
			'next' => __( 'Next', 'gorilla-security' ),
		)
	);
	return "<!-- wp:html -->\n"
		. '<div class="gs-arrows">'
		. '<button type="button" class="gs-arrow gs-ico-arrow-left" data-gs-dir="prev" aria-controls="' . $id . '" aria-label="' . esc_attr( $labels['prev'] ) . '"></button>'
		. '<button type="button" class="gs-arrow gs-ico-arrow-right" data-gs-dir="next" aria-controls="' . $id . '" aria-label="' . esc_attr( $labels['next'] ) . '"></button>'
		. "</div>\n<!-- /wp:html -->";
}

/**
 * Social profile icons (Figma 1:83 hero rail, 1:426 footer).
 *
 * Only verified URLs from gs_site( 'social' ) become links. Without any, nothing is output — except locally
 * (GS_SHOW_PENDING), where non-linked placeholder icons keep the Figma layout for review.
 *
 * @param string[] $services  Services in display order: instagram, facebook, x, linkedin.
 * @param string   $css_class Modifier class, e.g. 'gs-social--rail' or 'gs-social--footer'.
 * @return string Block markup, or '' when there is nothing to show.
 */
function gs_social_links( $services, $css_class = '' ) {
	$labels = array(
		'instagram' => __( 'Instagram', 'gorilla-security' ),
		'facebook'  => __( 'Facebook', 'gorilla-security' ),
		'x'         => __( 'X (Twitter)', 'gorilla-security' ),
		'linkedin'  => __( 'LinkedIn', 'gorilla-security' ),
	);
	$urls   = (array) gs_site( 'social' );
	$linked = array_filter(
		$services,
		static function ( $service ) use ( $urls ) {
			return ! empty( $urls[ $service ] );
		}
	);
	if ( ! $linked && ! gs_show_pending() ) {
		return '';
	}
	$items = '';
	foreach ( ( $linked ? $linked : $services ) as $service ) {
		if ( ! isset( $labels[ $service ] ) ) {
			continue;
		}
		$icon = 'gs-social__icon gs-ico-social-' . sanitize_html_class( $service );
		if ( $linked ) {
			/* translators: %s: social network name. */
			$label  = sprintf( __( 'Gorilla Security on %s (opens in a new tab)', 'gorilla-security' ), $labels[ $service ] );
			$items .= '<li><a class="' . esc_attr( $icon ) . '" href="' . esc_url( $urls[ $service ] ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( $label ) . '"></a></li>';
		} else {
			$items .= '<li><span class="' . esc_attr( $icon ) . '"><span class="screen-reader-text">' . esc_html( $labels[ $service ] ) . '</span></span></li>';
		}
	}
	$classes = trim( 'gs-social ' . sanitize_html_class( $css_class ) . ( $linked ? '' : ' gs-social--placeholder gs-pending' ) );
	$label   = $linked ? __( 'Social profiles', 'gorilla-security' ) : __( 'Social profiles (links awaiting confirmation)', 'gorilla-security' );
	return "<!-- wp:html -->\n"
		. '<ul class="' . esc_attr( $classes ) . '" aria-label="' . esc_attr( $label ) . '">' . $items . '</ul>'
		. "\n<!-- /wp:html -->";
}

/**
 * Hero review badge (Figma 1:114). Unconfirmed claim: local review only (GS_SHOW_PENDING), else ''.
 *
 * @return string Block markup.
 */
function gs_hero_review_badge() {
	$logo = gs_pending_img( 'review-source.png' );
	if ( ! $logo ) {
		return '';
	}
	$stars = str_repeat( '<span class="gs-ico-star"></span>', 5 );
	return "<!-- wp:html -->\n"
		. '<div class="gs-review-badge gs-pending"><img src="' . esc_url( $logo ) . '" alt="' . esc_attr__( 'Google', 'gorilla-security' ) . '" width="30" height="30"/>'
		. '<span class="gs-rating" role="img" aria-label="' . esc_attr__( 'Rated 5 out of 5', 'gorilla-security' ) . '">' . $stars . '</span>'
		. '<span>' . esc_html__( '1000+ Reviews', 'gorilla-security' ) . '</span></div>'
		. "\n<!-- /wp:html -->";
}

/**
 * Hero trust strip (Figma 1:515): licence, Afterpay, warranty, Hikvision partner marks.
 * Unconfirmed claims / third-party marks: local review only (GS_SHOW_PENDING), else ''.
 *
 * @return string Block markup.
 */
function gs_hero_trust_strip() {
	$marks = array(
		'trust-licence.png' => __( 'Licensed Security Installers, licence issued by Victoria Police', 'gorilla-security' ),
		'partner-1.png'     => __( 'Afterpay', 'gorilla-security' ),
		'warranty.png'      => __( '2 year warranty', 'gorilla-security' ),
		'partner-2.png'     => __( 'Hikvision Platinum Partner Installers', 'gorilla-security' ),
	);
	$items = '';
	foreach ( $marks as $file => $alt ) {
		$src = gs_pending_img( $file );
		if ( $src ) {
			$items .= gs_image( '', $alt, '', array( 'src' => $src ) );
		}
	}
	if ( '' === $items ) {
		return '';
	}
	return gs_group_open( 'gs-trust-strip gs-pending', array( 'layout' => array( 'type' => 'default' ) ) )
		. $items
		. gs_group_close();
}
