<?php
/**
 * Title: Quote split
 * Slug: gorilla-security/quote-split
 * Categories: gorilla-sections
 * Keywords: quote, form, contact, installer
 * Description: Quote form over a faded installer photo, with the contact card (Figma 1:169, form 1:172, card 1:199).
 *
 * Copy is from Figma, pending content-writer confirmation (docs/copy/home.md). The form is Contact Form 7
 * "Quote split" (fixtures/content.xml). Select options are not in Figma: "purpose" uses Home / Business and
 * "required" uses the footer service list — flagged for the content writer.
 *
 * @package gorilla-security
 */

$gs_img = gs_img( 'quote-installer' );
$gs     = array();

$gs_cover = array(
	'isUserOverlayColor' => true,
	'gradient'           => 'quote-fade',
	'isDark'             => false,
	'tagName'            => 'section',
	'align'              => 'full',
	'className'          => 'gs-quote-split',
	'layout'             => array( 'type' => 'constrained' ),
	'anchor'             => 'get-quote',
);
if ( $gs_img ) {
	$gs_cover = array( 'url' => $gs_img ) + $gs_cover;
}

$gs[] = gs_block_open( 'cover', $gs_cover ) . "\n"
	. '<section class="wp-block-cover alignfull is-light gs-quote-split" id="get-quote">'
	. ( $gs_img ? '<img class="wp-block-cover__image-background" alt="" src="' . esc_url( $gs_img ) . '" data-object-fit="cover"/>' : '' )
	. '<span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient has-quote-fade-gradient-background"></span>'
	. '<div class="wp-block-cover__inner-container">';

$gs[] = gs_columns_open( 'gs-quote-split__grid', array( 'align' => 'wide' ) );
$gs[] = gs_column_open( 'gs-quote-split__form gs-form' );
$gs[] = gs_heading( __( 'We aim to make our [[security services]] as smooth as possible.', 'gorilla-security' ) );
$gs[] = gs_paragraph( __( 'Let us know what service you are looking for and we can contact you.', 'gorilla-security' ), '', 'lead' );
$gs[] = "<!-- wp:shortcode -->\n[contact-form-7 title=\"Quote split\"]\n<!-- /wp:shortcode -->";
$gs[] = "</div>\n<!-- /wp:column -->";
$gs[] = gs_column_open( 'gs-quote-split__contact' );
$gs[] = '<!-- wp:pattern {"slug":"gorilla-security/contact-card"} /-->';
$gs[] = "</div>\n<!-- /wp:column -->";
$gs[] = "</div>\n<!-- /wp:columns -->";

$gs[] = "</div></section>\n<!-- /wp:cover -->";

echo wp_kses_post( implode( "\n", $gs ) );
