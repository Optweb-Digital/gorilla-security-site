<?php
/**
 * Title: Contact card
 * Slug: gorilla-security/contact-card
 * Categories: gorilla-components
 * Keywords: contact, phone, hours
 * Description: Glass card with phone and opening hours (Figma 1:199).
 *
 * Values come from gs_site(); they are pending client confirmation, so in production the card is not
 * output until the phone / hours are set (docs/project-context.md → Open decisions).
 *
 * @package gorilla-security
 */

$gs_phone = gs_site( 'phone' );
$gs_hours = gs_site( 'hours_summary' );
if ( ! $gs_phone && ! $gs_hours ) {
	return;
}

$gs_item = static function ( $icon, $value, $label, $href = '' ) {
	$value_html = $href ? '<a href="' . esc_url( $href ) . '">' . esc_html( $value ) . '</a>' : esc_html( $value );
	return gs_group_open(
		'gs-contact-card__item',
		array(
			'layout' => array(
				'type'     => 'flex',
				'flexWrap' => 'nowrap',
			),
		)
	)
		. gs_icon( $icon, 'sm' )
		. gs_group_open( 'gs-contact-card__text', array( 'layout' => array( 'type' => 'default' ) ) )
		. '<!-- wp:paragraph {"className":"gs-contact-card__value"} -->' . "\n" . '<p class="gs-contact-card__value">' . $value_html . "</p>\n<!-- /wp:paragraph -->"
		. gs_paragraph( $label, '', '', 'gs-contact-card__label' )
		. gs_group_close()
		. gs_group_close();
};

$gs   = array();
$gs[] = gs_group_open(
	'gs-contact-card gs-pending',
	array(
		'layout' => array(
			'type'     => 'flex',
			'flexWrap' => 'wrap',
		),
	)
);
if ( $gs_phone ) {
	$gs[] = $gs_item( 'phone-call', $gs_phone, __( 'Call Us Directly', 'gorilla-security' ), gs_tel( $gs_phone ) );
}
if ( is_array( $gs_hours ) && 2 === count( $gs_hours ) ) {
	$gs[] = $gs_item( 'clock', $gs_hours[0], $gs_hours[1] );
}
$gs[] = gs_group_close();

echo wp_kses_post( implode( "\n", $gs ) );
