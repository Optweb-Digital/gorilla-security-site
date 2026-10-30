<?php
/**
 * Gorilla Security Core — data layer.
 *
 * Custom post types, taxonomies, post meta, block bindings and integrations live here, never in
 * the theme (AGENTS.md §3). Add one file per content type in inc/ via /scaffold-content and load it
 * below.
 *
 * @package gs-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GORILLA_CORE_DIR', __DIR__ );

foreach ( glob( GORILLA_CORE_DIR . '/inc/*.php' ) as $gorilla_core_file ) {
	require_once $gorilla_core_file;
}
unset( $gorilla_core_file );
