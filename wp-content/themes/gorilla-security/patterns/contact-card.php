<?php
/**
 * Title: Contact card (glass)
 * Slug: gorilla-security/contact-card
 * Categories: gorilla-components
 * Keywords: contact, phone, hours, call
 *
 * Figma 1:199/1:200 — glass card with "call us" and opening hours. Values come from
 * gorilla_site() ('phone', 'hours' = list of [ 'days' => …, 'time' => … ]); each half is only
 * output when its value is confirmed, and the card not at all when neither is (AGENTS.md §6).
 *
 * @package gorilla-security
 */

$gorilla_phone = gorilla_site( 'phone' );
$gorilla_hours = (array) gorilla_site( 'hours' );
$gorilla_first = gorilla_site( 'hours_card' ) ? gorilla_site( 'hours_card' ) : ( $gorilla_hours ? reset( $gorilla_hours ) : null );

if ( ! $gorilla_phone && empty( $gorilla_first['days'] ) ) {
	return;
}

$gorilla_tel = 'tel:' . preg_replace( '/[^0-9+]/', '', (string) $gorilla_phone );
?>
<!-- wp:group {"className":"is-style-glass-light gs-contact-card","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group is-style-glass-light gs-contact-card">
<?php if ( $gorilla_phone ) : ?>
<!-- wp:group {"className":"gs-contact-card__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-contact-card__item"><?php echo wp_kses_post( gorilla_icon( 'phone', 'md' ) ); ?>

<!-- wp:group {"className":"gs-contact-card__text","layout":{"type":"default"}} -->
<div class="wp-block-group gs-contact-card__text"><!-- wp:paragraph {"className":"gs-contact-card__value"} -->
<p class="gs-contact-card__value"><a href="<?php echo esc_url( $gorilla_tel ); ?>"><?php echo esc_html( $gorilla_phone ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Call Us Directly', 'gorilla-security' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endif; ?>

<?php if ( ! empty( $gorilla_first['days'] ) ) : ?>
<!-- wp:group {"className":"gs-contact-card__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group gs-contact-card__item"><?php echo wp_kses_post( gorilla_icon( 'clock', 'md' ) ); ?>

<!-- wp:group {"className":"gs-contact-card__text","layout":{"type":"default"}} -->
<div class="wp-block-group gs-contact-card__text"><!-- wp:paragraph {"className":"gs-contact-card__value"} -->
<p class="gs-contact-card__value"><?php echo esc_html( $gorilla_first['days'] ); ?></p>
<!-- /wp:paragraph -->

	<?php if ( ! empty( $gorilla_first['time'] ) ) : ?>
<!-- wp:paragraph -->
<p><?php echo esc_html( $gorilla_first['time'] ); ?></p>
<!-- /wp:paragraph -->
	<?php endif; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endif; ?>
</div>
<!-- /wp:group -->
