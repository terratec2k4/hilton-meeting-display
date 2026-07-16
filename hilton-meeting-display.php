<?php
declare(strict_types=1);

/**
 * Plugin Name: Hilton Meeting Display
 * Plugin URI: https://github.com/terratec2k4/hilton-meeting-display
 * Description: Professional Meeting Room Display System for Hilton Barcelona.
 * Version: 2.0.0-alpha1
 * Requires at least: 6.5
 * Requires PHP: 8.2
 * Author: Javier Mesa
 * License: GPL-2.0-or-later
 * Text Domain: hilton-meeting-display
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

define('HMD_VERSION', '2.0.0-alpha1');
define('HMD_PLUGIN_FILE', __FILE__);
define('HMD_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('HMD_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('HMD_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once HMD_PLUGIN_PATH . 'includes/Autoloader.php';

HMD\Autoloader::register();

register_activation_hook(
    __FILE__,
    [HMD\Plugin::class, 'activate']
);

register_deactivation_hook(
    __FILE__,
    [HMD\Plugin::class, 'deactivate']
);

add_action(
    'plugins_loaded',
    static function (): void {
        HMD\Plugin::boot();
    }
);
