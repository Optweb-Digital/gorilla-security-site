<?php
/**
 * Title: Split — icon trio
 * Slug: gorilla-security/split-icon-trio
 * Categories: gorilla-sections
 * Keywords: split, licensed, icons, installation, repairs
 * Description: Copy with three icon highlights left, framed photo right (Figma 1:253, icon trio 1:265).
 *
 * Copy is from Figma, pending content-writer confirmation — "Licensed" / "fully licensed provider" are claims
 * to confirm (docs/copy/home.md).
 *
 * @package gorilla-security
 */

$gs_home = home_url( '/' );
$gs_trio = array(
	array( 'shield', __( 'Licensed & Trusted', 'gorilla-security' ) ),
	array( 'gear', __( 'Installation & Maintenance', 'gorilla-security' ) ),
	array( 'wrench', __( 'Repairs & Support', 'gorilla-security' ) ),
);
$gs_list = '<!-- wp:list {"className":"gs-icon-trio"} -->' . "\n" . '<ul class="wp-block-list gs-icon-trio">';
foreach ( $gs_trio as $gs_item ) {
	$gs_class = 'gs-ico-' . $gs_item[0];
	$gs_list .= '<!-- wp:list-item {"className":"' . $gs_class . '"} -->' . "\n" . '<li class="' . esc_attr( $gs_class ) . '">' . esc_html( $gs_item[1] ) . "</li>\n<!-- /wp:list-item -->";
}
$gs_list .= "</ul>\n<!-- /wp:list -->";

echo wp_kses_post(
	gs_split(
		array(
			'class'   => 'gs-split-trio',
			'heading' => __( 'Licensed Security System Solutions [[You Can Trust]]', 'gorilla-security' ),
			'body'    => array(
				gs_paragraph( __( 'We provide high-quality security system services across Melbourne, including professional installation, maintenance, and quick repairs. As a fully licensed provider, we deliver reliable, affordable and long-lasting security solutions tailored to your property.', 'gorilla-security' ), '', 'lead' ),
				$gs_list,
			),
			'buttons' => gs_buttons(
				array(
					gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote' ),
					gs_button( __( 'Know More', 'gorilla-security' ), $gs_home . '#services', 'outline' ),
				)
			),
			'image'   => 'split-3',
			'alt'     => __( 'Person tapping an access card on a glass turnstile in an office lobby', 'gorilla-security' ),
			'side'    => 'right',
		)
	)
);
