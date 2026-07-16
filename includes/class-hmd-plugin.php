<?php
defined('ABSPATH') || exit;

if (!class_exists('HMD_Plugin')) {

    final class HMD_Plugin
    {
        /**
         * Instancia única.
         *
         * @var HMD_Plugin|null
         */
        private static $instance = null;

        /**
         * Devuelve la instancia.
         */
        public static function instance(): self
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor.
         */
        private function __construct()
        {
            $this->load_dependencies();

            add_action('plugins_loaded', [$this, 'init']);
        }

        /**
         * Inicializa el plugin.
         */
        public function init(): void
        {
            new HMD_Admin();
        }

        /**
         * Carga las dependencias.
         */
        private function load_dependencies(): void
        {
            require_once HMD_PLUGIN_DIR . 'includes/class-hmd-database.php';
            require_once HMD_PLUGIN_DIR . 'includes/class-hmd-admin.php';
        }

        /**
         * Activación.
         */
        public static function activate(): void
        {
            HMD_Database::install();

            flush_rewrite_rules();
        }

        /**
         * Desactivación.
         */
        public static function deactivate(): void
        {
            flush_rewrite_rules();
        }
    }
}
