<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'HMD_Admin' ) ) {

	final class HMD_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action(
				'admin_menu',
				array( $this, 'register_admin_menu' )
			);

			add_action(
				'admin_enqueue_scripts',
				array( $this, 'enqueue_assets' )
			);

		}

		/**
		 * Registra el menú del plugin.
		 */
		public function register_admin_menu(): void {

			$capability = 'manage_options';

			add_menu_page(
				__( 'Hilton Meeting Display', 'hilton-meeting-display' ),
				__( 'Meeting Display', 'hilton-meeting-display' ),
				$capability,
				'hmd-dashboard',
				array( $this, 'dashboard_page' ),
				'dashicons-screenoptions',
				58
			);

			add_submenu_page(
				'hmd-dashboard',
				__( 'Dashboard', 'hilton-meeting-display' ),
				__( 'Dashboard', 'hilton-meeting-display' ),
				$capability,
				'hmd-dashboard',
				array( $this, 'dashboard_page' )
			);

			add_submenu_page(
				'hmd-dashboard',
				__( 'Salas', 'hilton-meeting-display' ),
				__( 'Salas', 'hilton-meeting-display' ),
				$capability,
				'hmd-rooms',
				array( $this, 'rooms_page' )
			);

			/*
			 * Página oculta para crear / editar salas.
			 */
			add_submenu_page(
				null,
				__( 'Editar sala', 'hilton-meeting-display' ),
				__( 'Editar sala', 'hilton-meeting-display' ),
				$capability,
				'hmd-room-edit',
				array( $this, 'room_edit_page' )
			);

			add_submenu_page(
				'hmd-dashboard',
				__( 'Empresas', 'hilton-meeting-display' ),
				__( 'Empresas', 'hilton-meeting-display' ),
				$capability,
				'hmd-companies',
				array( $this, 'companies_page' )
			);

			add_submenu_page(
				'hmd-dashboard',
				__( 'Eventos', 'hilton-meeting-display' ),
				__( 'Eventos', 'hilton-meeting-display' ),
				$capability,
				'hmd-events',
				array( $this, 'events_page' )
			);

			add_submenu_page(
				'hmd-dashboard',
				__( 'Pantallas', 'hilton-meeting-display' ),
				__( 'Pantallas', 'hilton-meeting-display' ),
				$capability,
				'hmd-screens',
				array( $this, 'screens_page' )
			);

			add_submenu_page(
				'hmd-dashboard',
				__( 'Configuración', 'hilton-meeting-display' ),
				__( 'Configuración', 'hilton-meeting-display' ),
				$capability,
				'hmd-settings',
				array( $this, 'settings_page' )
			);

		}

		/**
		 * Carga CSS y JS únicamente en las páginas del plugin.
		 */
		public function enqueue_assets( string $hook ): void {

			if ( strpos( $hook, 'hmd' ) === false ) {
				return;
			}

			$css = HMD_PLUGIN_DIR . 'assets/css/admin.css';
			$js  = HMD_PLUGIN_DIR . 'assets/js/admin.js';

			if ( file_exists( $css ) ) {

				wp_enqueue_style(
					'hmd-admin',
					HMD_PLUGIN_URL . 'assets/css/admin.css',
					array(),
					HMD_VERSION
				);

			}

			if ( file_exists( $js ) ) {

				wp_enqueue_script(
					'hmd-admin',
					HMD_PLUGIN_URL . 'assets/js/admin.js',
					array( 'jquery' ),
					HMD_VERSION,
					true
				);

			}

		}

		/**
		 * Dashboard.
		 */
		public function dashboard_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/dashboard.php';

		}

		/**
		 * Salas.
		 */
		public function rooms_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/rooms.php';

		}

		/**
		 * Crear / Editar sala.
		 */
		public function room_edit_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/room-edit.php';

		}

		/**
		 * Empresas.
		 */
		public function companies_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/companies.php';

		}

		/**
		 * Eventos.
		 */
		public function events_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/events.php';

		}

		/**
		 * Pantallas.
		 */
		public function screens_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/screens.php';

		}

		/**
		 * Configuración.
		 */
		public function settings_page(): void {

			require_once HMD_PLUGIN_DIR . 'admin/views/settings.php';

		}

	}
}