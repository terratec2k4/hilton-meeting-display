<?php
/**
 * Core Plugin Class
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

final class HMD_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var HMD_Plugin|null
	 */
	private static ?HMD_Plugin $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return HMD_Plugin
	 */
	public static function instance(): HMD_Plugin {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {

		add_action( 'plugins_loaded', array( $this, 'init' ) );

	}

	/**
	 * Prevent cloning.
	 */
	private function __clone(): void {}

	/**
	 * Prevent unserialize.
	 */
	public function __wakeup(): void {

		throw new Exception(
			'Cannot unserialize singleton ' . __CLASS__
		);

	}

	/**
	 * Initialize plugin.
	 */
	public function init(): void {

		load_plugin_textdomain(
			'hilton-meeting-display',
			false,
			dirname( plugin_basename( HMD_PLUGIN_FILE ) ) . '/languages'
		);

		if ( is_admin() ) {

			// Admin menus.
			new HMD_Admin();

			// Rooms controller.
			new HMD_Room_Controller();

		}

	}

	/**
	 * Plugin activation.
	 */
	public static function activate(): void {

		HMD_Database::install();

		flush_rewrite_rules();

	}

	/**
	 * Plugin deactivation.
	 */
	public static function deactivate(): void {

		flush_rewrite_rules();

	}

}