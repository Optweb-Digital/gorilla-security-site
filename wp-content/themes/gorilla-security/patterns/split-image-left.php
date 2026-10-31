<?php
/**
 * Title: Split — image left
 * Slug: gorilla-security/split-image-left
 * Categories: gorilla-sections
 * Keywords: split, image, residential, business, wireless
 * Description: Framed photo left, copy with sub-heads and lists right — "Secure Your Space…" (Figma 1:238).
 *
 * Copy is from Figma, pending content-writer confirmation (docs/copy/home.md). Figma says
 * "Gorilla Security & Locksmith"; the brand name is normalised to "Gorilla Security" (design-system.md).
 *
 * @package gorilla-security
 */

$gs_home = home_url( '/' );
$gs_sub  = array(
	'level' => 3,
	'size'  => 'lead',
	'class' => 'gs-split__subhead',
);

echo wp_kses_post(
	gs_split(
		array(
			'class'   => 'gs-split-feature',
			'heading' => __( '[[Secure Your Space]] with Affordable Security Systems', 'gorilla-security' ),
			'body'    => array(
				gs_paragraph( __( 'We at Gorilla Security take pride in providing the best security for all kinds of properties. We can help you protect your home or business with:', 'gorilla-security' ), '', 'lead' ),
				gs_heading( __( 'Residential & Business Protection', 'gorilla-security' ), $gs_sub ),
				gs_list(
					array(
						__( 'Residential security systems that protect your home with smart alarm monitoring, motion detection, and help available 24/7', 'gorilla-security' ),
						__( 'Business security systems designed for offices, stores, warehouses, and commercial complexes, with options that can grow with your needs', 'gorilla-security' ),
					),
					'',
					'gs-split__list'
				),
				gs_heading( __( 'Wireless & Smart Security Options', 'gorilla-security' ), $gs_sub ),
				gs_list(
					array(
						__( 'Our wireless security systems get rid of the need for cables while still providing strong protection.', 'gorilla-security' ),
						__( 'We sell wireless home security systems for Melbourne homes that fit right. They come with smartphone alerts, remote access, and are easy to set up.', 'gorilla-security' ),
					),
					'',
					'gs-split__list'
				),
			),
			'buttons' => gs_buttons(
				array(
					gs_button( __( 'Get A Quote', 'gorilla-security' ), $gs_home . '#quote' ),
					gs_button( __( 'Know More', 'gorilla-security' ), $gs_home . '#services', 'outline' ),
				)
			),
			'image'   => 'split-2',
			'alt'     => __( 'Person tapping an access card on an office door reader', 'gorilla-security' ),
			'side'    => 'left',
		)
	)
);
