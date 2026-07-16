<?php
/**
 * Core Plugin Class
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'HMD_Plugin' ) ) {

	final class HMD_Plugin {

		/**
		 * Instancia única.
		 *
		 * @var HMD_Plugin|null
		 */
		private static $instance = null;

		/**
		 * Devuelve la instancia única del plugin.
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

			add_action(
				'plugins_loaded',
				array( $this, 'init' )
			);

		}

		/**
		 * Evita el clonado del singleton.
		 */
		private function __clone() {}

		/**
		 * Evita la deserialización.
		 */
		public function __wakeup() {

			_doing_it_wrong(
				__FUNCTION__,
				esc_html__( 'This class cannot be unserialized.', 'hilton-meeting-display' ),
				HMD_VERSION
			);

		}

		/**
		 * Inicializa el plugin.
		 */
		public function init(): void {

			if ( is_admin() ) {
				new HMD_Admin();
			}

		}

		/**
		 * Activación del plugin.
		 */
		public static function activate(): void {

			HMD_Database::install();

			flush_rewrite_rules();

		}

		/**
		 * Desactivación del plugin.
		 */
		public static function deactivate(): void {

			flush_rewrite_rules();

		}

	}

}