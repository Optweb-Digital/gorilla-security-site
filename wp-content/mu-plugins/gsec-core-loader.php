<?php
/**
 * Plugin Name: Gorilla Security Core (loader)
 * Description: Loads the gsec-core mu-plugin. WordPress only autoloads top-level files in mu-plugins/.
 *
 * @package gsec-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/gsec-core/gsec-core.php';
