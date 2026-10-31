<?php
/**
 * PENDING CLIENT CONFIRMATION — local layout QA only.
 *
 * Business details copied verbatim from the Figma file so the homepage can be reviewed against the design.
 * Loaded only when GS_SHOW_PENDING is defined (set in .wp-env.json). Staging and production never load this
 * file, so none of these values are published until the client confirms them and they are moved into
 * gs_site() defaults (docs/project-context.md → Open decisions, docs/copy/home.md → Pending confirmation).
 *
 * @package gorilla-security
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Merge the Figma business details into gs_site().
 *
 * @param array $site Site details.
 * @return array
 */
function gs_pending_site_details( $site ) {
	return array_merge(
		$site,
		array(
			'phone'         => '0468 532 275',                    // Shown in the Figma header, contact card, CTA and footer.
			'email'         => 'info@gorillasecurity.com.au',     // From the Figma footer.
			'address'       => '110 Ruskin St, Elwood VIC 3184',  // From the Figma footer.
			'hours_summary' => array( 'Mon-Sat', '8:00 AM-6:00 PM' ), // From the Figma contact card; differs from the footer hours.
			'hours'         => array(                             // From the Figma footer hours box.
				array( 'Mon to Fri', '5:30am – 7pm' ),
				array( 'Sat to Sun', '5:30am – 5pm' ),
			),
			'support'       => '24/7 Support Available',          // From the Figma footer hours box.
		)
	);
}
add_filter( 'gs/site', 'gs_pending_site_details' );
