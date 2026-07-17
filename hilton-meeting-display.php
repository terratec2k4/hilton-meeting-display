<?php
/**
 * Plugin Name: Hilton Meeting Display
 * Plugin URI: https://github.com/terratec2k4/hilton-meeting-display
 * Description: Professional Meeting Room Display System.
 * Version: 2.0.0-alpha2
 * Requires at least: 6.5
 * Requires PHP: 8.2
 * Author: Javier Mesa
 * Text Domain: hilton-meeting-display
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

/*
|--------------------------------------------------------------------------
| Plugin Constants
|--------------------------------------------------------------------------
*/

define( 'HMD_VERSION', '2.0.0-alpha2' );
define( 'HMD_PLUGIN_FILE', __FILE__ );
define( 'HMD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HMD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/*
|--------------------------------------------------------------------------
| Core Classes
|--------------------------------------------------------------------------
*/

require_once HMD_PLUGIN_DIR . 'includes/class-hmd-database.php';

require_once HMD_PLUGIN_DIR . 'includes/class-hmd-room-repository.php';
require_once HMD_PLUGIN_DIR . 'includes/class-hmd-room-controller.php';
require_once HMD_PLUGIN_DIR . 'includes/class-hmd-room-list-table.php';

require_once HMD_PLUGIN_DIR . 'includes/class-hmd-admin.php';
require_once HMD_PLUGIN_DIR . 'includes/class-hmd-plugin.php';

/*
|--------------------------------------------------------------------------
| Activation / Deactivation
|--------------------------------------------------------------------------
*/

register_activation_hook(
    __FILE__,
    array( 'HMD_Plugin', 'activate' )
);

register_deactivation_hook(
    __FILE__,
    array( 'HMD_Plugin', 'deactivate' )
);

/*
|--------------------------------------------------------------------------
| Bootstrap
|--------------------------------------------------------------------------
*/

HMD_Plugin::instance();