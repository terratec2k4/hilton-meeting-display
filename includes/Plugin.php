<?php
declare(strict_types=1);

namespace HMD;

defined('ABSPATH') || exit;

final class Plugin
{
    private static ?Plugin $instance = null;

    public static function boot(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->registerHooks();
        $this->loadModules();
    }

    public static function activate(): void
    {
        Database::install();

        flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }

    private function registerHooks(): void
    {
        add_action('init', [$this, 'loadTextDomain']);
    }

    public function loadTextDomain(): void
    {
        load_plugin_textdomain(
            'hilton-meeting-display',
            false,
            dirname(HMD_PLUGIN_BASENAME) . '/languages'
        );
    }

    private function loadModules(): void
    {
        if (is_admin()) {
            new Admin();
        }

        new Assets();
    }
}
