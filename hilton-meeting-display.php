<?php
/**
 * Plugin Name: Hilton Meeting Display
 * Description: Professional Meeting Room Display System.
 * Version: 2.0.0-alpha1
 * Requires at least: 6.5
 * Requires PHP: 8.2
 * Author: Javier Mesa
 * Text Domain: hilton-meeting-display
 */

defined( 'ABSPATH' ) || exit;

define( 'HMD_VERSION', '2.0.0-alpha1' );
define( 'HMD_PLUGIN_FILE', __FILE__ );
define( 'HMD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HMD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once HMD_PLUGIN_DIR . 'includes/class-hmd-database.php';
require_once HMD_PLUGIN_DIR . 'includes/class-hmd-admin.php';
require_once HMD_PLUGIN_DIR . 'includes/class-hmd-plugin.php';

register_activation_hook(
    __FILE__,
    array( 'HMD_Plugin', 'activate' )
);

register_deactivation_hook(
    __FILE__,
    array( 'HMD_Plugin', 'deactivate' )
);

HMD_Plugin::instance();