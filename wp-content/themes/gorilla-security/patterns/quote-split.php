<?php
/**
 * Title: Quote split (form + photo)
 * Slug: gorilla-security/quote-split
 * Categories: gorilla-sections
 * Keywords: quote, form, contact, request
 *
 * Figma 1:169 — installer photo 1:170 with the soft-section wash 1:171, heading 1:176, copy 1:178,
 * light quote form 1:172 (Contact Form 7 "Quote split form", found by title) and the contact card
 * 1:199. Anchor #quote. Without CF7 or the form a [[TODO]] stands in; without phone/hours the
 * card is not output.
 *
 * @package gorilla-security
 */

$gorilla_photo      = gorilla_img( 'quote-installer' );
$gorilla_form_title = 'Quote split form';
$gorilla_has_form   = function_exists( 'wpcf7_get_contact_form_by_title' ) && wpcf7_get_contact_form_by_title( $gorilla_form_title );

$gorilla_cover_attrs = array(
	'url'                => $gorilla_photo,
	'dimRatio'           => 0,
	'overlayColor'       => 'white',
	'isUserOverlayColor' => true,
	'focalPoint'         => array(
		'x' => 0,
		'y' => 0.5,
	),
	'align'              => 'full',
	'className'          => 'gs-quote-split',
	'layout'             => array( 'type' => 'default' ),
);

// Whole cover through kses at once — a lone opener would be re-serialized as void (rules-log 008).
ob_start();
?>
<div class="wp-block-cover alignfull gs-quote-split">
<?php if ( $gorilla_photo ) : ?>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $gorilla_photo ); ?>" style="object-position:0% 50%" data-object-fit="cover" data-object-position="0% 50%"/>
<?php endif; ?>
<span aria-hidden="true" class="wp-block-cover__background has-white-background-color has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"gs-quote-split__inner","layout":{"type":"default"}} -->
<div class="wp-block-group gs-quote-split__inner"><!-- wp:group {"anchor":"quote","className":"gs-quote-split__form","layout":{"type":"default"}} -->
<div id="quote" class="wp-block-group gs-quote-split__form">
<?php
echo wp_kses_post( gorilla_heading( __( 'We aim to make our [[security services]] as smooth as possible.', 'gorilla-security' ), array( 'size' => 'h2' ) ) );
echo wp_kses_post( gorilla_paragraph( __( 'Let us know what service you are looking for and we can contact you.', 'gorilla-security' ), '', 'lead' ) );
?>

<!-- wp:group {"className":"gs-form","layout":{"type":"default"}} -->
<div class="wp-block-group gs-form">
<?php if ( $gorilla_has_form ) : ?>
<!-- wp:shortcode -->
[contact-form-7 title="<?php echo esc_attr( $gorilla_form_title ); ?>"]
<!-- /wp:shortcode -->
<?php else : ?>
<!-- wp:paragraph -->
<p>[[TODO: quote form — Contact Form 7 form "<?php echo esc_html( $gorilla_form_title ); ?>" (name, email, phone, purpose, requirement, message; submit "Get A Quote")]]</p>
<!-- /wp:paragraph -->
<?php endif; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"gorilla-security/contact-card"} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
<?php
echo wp_kses_post( gorilla_block_open( 'cover', $gorilla_cover_attrs ) . "\n" . ob_get_clean() );
