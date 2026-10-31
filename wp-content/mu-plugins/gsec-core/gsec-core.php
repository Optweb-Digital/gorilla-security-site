<?php
/**
 * Gorilla Security Core — data layer.
 *
 * Custom post types, taxonomies, post meta, block bindings and integrations live here, never in
 * the theme (AGENTS.md §3). Add one file per content type in inc/ via /scaffold-content and load it
 * below.
 *
 * @package gsec-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GSEC_CORE_DIR', __DIR__ );

foreach ( glob( GSEC_CORE_DIR . '/inc/*.php' ) as $gsec_core_file ) {
	require_once $gsec_core_file;
}
unset( $gsec_core_file );
