<?php
/**
 * Title: Split — intro
 * Slug: gorilla-security/split-intro
 * Categories: gorilla-sections
 * Keywords: split, intro, image, security solutions
 * Description: Copy left, framed photo right — "Smarter Security for Melbourne Homes & Businesses." (Figma 1:220).
 *
 * Copy is from Figma, pending content-writer confirmation (docs/copy/home.md).
 *
 * @package gorilla-security
 */

$gs_home = home_url( '/' );

echo wp_kses_post(
	gs_split(
		array(
			'class'   => 'gs-split-intro',
			'eyebrow' => __( 'Security Solutions', 'gorilla-security' ),
			'heading' => __( '[[Smarter Security]] for Melbourne Homes & Businesses.', 'gorilla-security' ),
			'body'    => array(
				gs_paragraph( __( 'At Gorilla Security and Automation, we help protect what matters. We supply and install CCTV, alarm, intercom and access control systems for homes and businesses across Melbourne. Our experienced team delivers reliable, high-quality installations using advanced technology, so you can enjoy greater peace of mind and a safer property.', 'gorilla-security' ), '', 'lead' ),
			),
			'buttons' => gs_buttons(
				array(
					gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote' ),
					gs_button( __( 'Know More', 'gorilla-security' ), $gs_home . '#services', 'outline' ),
				)
			),
			'image'   => 'split-1',
			'alt'     => __( 'Gorilla Security installer fitting a video intercom panel', 'gorilla-security' ),
			'side'    => 'right',
		)
	)
);
