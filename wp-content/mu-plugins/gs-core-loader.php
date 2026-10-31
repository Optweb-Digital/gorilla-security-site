<?php
/**
 * Plugin Name: Gorilla Security Core (loader)
 * Description: Loads the gs-core mu-plugin. WordPress only autoloads top-level files in mu-plugins/.
 *
 * @package gs-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/gs-core/gs-core.php';
