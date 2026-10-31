<?php
/**
 * Title: Contact card
 * Slug: gorilla-security/contact-card
 * Categories: gorilla-components
 * Keywords: contact, phone, call, hours
 *
 * Figma 1:199 — glass card with the phone number and opening hours from gsec_site().
 * Each item shows only when its value is set; hours stay hidden until the Figma conflict
 * is resolved (docs/project-context.md → Open decisions). Nothing is output without either.
 *
 * @package gorilla-security
 */

$gsec_phone = gsec_site( 'phone' );
$gsec_hours = array_values( array_filter( (array) gsec_site( 'hours' ) ) );
if ( '' === $gsec_phone && ! $gsec_hours ) {
	return;
}

/**
 * One item: icon circle, a strong first line and a second line.
 *
 * @param string $icon  gs-ico name.
 * @param string $first First line (HTML, escaped by the caller).
 * @param string $second Second line (plain text).
 * @return string Block markup.
 */
$gsec_contact_item = static function ( $icon, $first, $second ) {
	return '<!-- wp:group {"className":"gs-contact-card__item","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-contact-card__item">' . gsec_icon( $icon, 'sm' )
		. '<!-- wp:group {"className":"gs-contact-card__body","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group gs-contact-card__body"><!-- wp:paragraph {"className":"gs-contact-card__lead"} -->' . "\n"
		. '<p class="gs-contact-card__lead">' . $first . '</p>' . "\n"
		. '<!-- /wp:paragraph -->' . "\n\n"
		. ( '' !== $second ? '<!-- wp:paragraph -->' . "\n" . '<p>' . esc_html( $second ) . '</p>' . "\n" . '<!-- /wp:paragraph -->' : '' )
		. '</div>' . "\n" . '<!-- /wp:group --></div>' . "\n"
		. '<!-- /wp:group -->';
};

$gsec_items = array();
if ( '' !== $gsec_phone ) {
	$gsec_items[] = $gsec_contact_item(
		'phone',
		'<a href="' . esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $gsec_phone ) ) . '">' . esc_html( $gsec_phone ) . '</a>',
		__( 'Call Us Directly', 'gorilla-security' )
	);
}
if ( $gsec_hours ) {
	$gsec_items[] = $gsec_contact_item( 'clock', esc_html( $gsec_hours[0] ), implode( ' · ', array_slice( $gsec_hours, 1 ) ) );
}

echo wp_kses_post(
	'<!-- wp:group {"className":"gs-contact-card is-style-glass-dark","layout":{"type":"default"}} -->' . "\n"
	. '<div class="wp-block-group gs-contact-card is-style-glass-dark">' . implode( "\n\n", $gsec_items ) . '</div>' . "\n"
	. '<!-- /wp:group -->'
);
