<?php
/**
 * Title: FAQ
 * Slug: gorilla-security/faq
 * Categories: gorilla-sections
 * Keywords: faq, questions, answers, accordion
 * Description: "Clear Answers. Smarter Security." numbered accordion (Figma 1:334 / 1:339).
 *
 * Questions and answer 02 are from Figma. Answers 01 and 03–08 are drafted only from facts already in the
 * approved page copy (service list, homes & businesses, business premises, wireless systems, free quote) and
 * await content-writer confirmation in docs/copy/home.md. Uses core/details — no JS needed.
 *
 * @package gorilla-security
 */

$gs_items = array(
	array( __( 'What security systems does Gorilla Security specialise in installing?', 'gorilla-security' ), __( 'We install CCTV systems, alarm systems, intercoms, access control, smart locks and smart home automation for homes and businesses across Melbourne. Each system is designed around your property and installed by our team.', 'gorilla-security' ) ),
	array( __( 'How can I benefit from a security system installation at my residence?', 'gorilla-security' ), __( 'Our security systems offer enhanced safety, providing real-time monitoring, intrusion detection, and access control. Enjoy peace of mind knowing that your property is protected around the clock.', 'gorilla-security' ) ),
	array( __( 'Are your security system installations suitable for both homes and businesses?', 'gorilla-security' ), __( 'Yes. We design and install systems for both homes and businesses, from residential alarms and CCTV to security for offices, stores, warehouses and commercial complexes, with options that can grow with your needs.', 'gorilla-security' ) ),
	array( __( 'What sets Gorilla Security apart in terms of installation expertise?', 'gorilla-security' ), __( 'Our team designs each system around your property and needs, and sets it up professionally for reliable, long-lasting protection. You can expect honest advice, quality workmanship and ongoing support after installation.', 'gorilla-security' ) ),
	array( __( 'Can I request a consultation to determine the right security system for my needs?', 'gorilla-security' ), __( 'Yes. Tell us about your property and security needs using the Get A Quote form, and our team will get back to you with a tailored recommendation and a free, no-obligation quote.', 'gorilla-security' ) ),
	array( __( 'What are business security systems, and how do they keep my business safe?', 'gorilla-security' ), __( 'Business security systems protect your premises by combining CCTV, alarm systems, intercoms and access control to record activity, detect intrusions and control who can enter. We design them for offices, stores, warehouses and commercial complexes.', 'gorilla-security' ) ),
	array( __( 'What is a security system that doesn’t need wires?', 'gorilla-security' ), __( 'A wireless security system connects its cameras and sensors without running cables between them. It removes the need for cabling while still providing strong protection, and comes with smartphone alerts and remote access.', 'gorilla-security' ) ),
	array( __( 'What is the process behind wireless home security systems?', 'gorilla-security' ), __( 'Wireless cameras and sensors communicate with a central control panel or app instead of running on cables. When activity is detected, the system alerts you on your smartphone and you can check in remotely. Our team recommends the right components for your home, then installs and sets everything up for you.', 'gorilla-security' ) ),
);

$gs   = array();
$gs[] = gs_group_open(
	'gs-section gs-faq-section',
	array(
		'tag'    => 'section',
		'align'  => 'full',
		'anchor' => 'faq',
	)
);
$gs[] = gs_columns_open( 'gs-faq-section__head', array( 'align' => 'wide' ) );
$gs[] = gs_column_open( 'gs-faq-section__intro' );
$gs[] = gs_eyebrow( __( 'Frequently Asked Questions', 'gorilla-security' ) );
$gs[] = gs_heading( __( '[[Clear Answers.]] Smarter Security.', 'gorilla-security' ) );
$gs[] = "</div>\n<!-- /wp:column -->";
$gs[] = gs_column_open( 'gs-faq-section__action' );
$gs[] = gs_buttons( array( gs_button( __( 'Get A Quote', 'gorilla-security' ), home_url( '/#quote' ) ) ) );
$gs[] = "</div>\n<!-- /wp:column -->";
$gs[] = "</div>\n<!-- /wp:columns -->";

$gs[] = gs_group_open( 'gs-faq', array( 'layout' => array( 'type' => 'default' ) ) );
foreach ( $gs_items as $gs_n => $gs_item ) {
	$gs_open  = 1 === $gs_n;
	$gs_class = 'is-style-faq-numbered';
	$gs[]     = gs_block_open(
		'details',
		array(
			'showContent' => $gs_open ? true : null,
			'className'   => $gs_class,
		)
	) . "\n"
		// name="gs-faq": native exclusive accordion — opening one answer closes the open one (gorilla.js covers older browsers).
		. '<details class="wp-block-details ' . esc_attr( $gs_class ) . '" name="gs-faq"' . ( $gs_open ? ' open' : '' ) . '><summary>' . esc_html( $gs_item[0] ) . '</summary>'
		. gs_paragraph( $gs_item[1] )
		. "</details>\n<!-- /wp:details -->";
}
$gs[] = gs_group_close();
$gs[] = gs_group_close( 'section' );

echo wp_kses_post( implode( "\n", $gs ) );
