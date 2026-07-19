<?php
/**
 * Plugin Name: Hilton Meeting Display
 * Version: 3.0.0-alpha.1
 */
defined('ABSPATH') || exit;
require_once __DIR__.'/includes/Core/Application.php';
(new HMD\Core\Application())->boot();
