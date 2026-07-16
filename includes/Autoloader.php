<?php
declare(strict_types=1);

namespace HMD;

defined('ABSPATH') || exit;

/**
 * Hilton Meeting Display
 * PSR-4 Autoloader
 */
final class Autoloader
{
    /**
     * Register autoloader.
     */
    public static function register(): void
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    /**
     * Autoload classes.
     */
    private static function autoload(string $class): void
    {
        $namespace = __NAMESPACE__ . '\\';

        if (!str_starts_with($class, $namespace)) {
            return;
        }

        $relativeClass = substr($class, strlen($namespace));

        $file = HMD_PLUGIN_PATH .
            'includes/' .
            str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) .
            '.php';

        if (is_readable($file)) {
            require_once $file;
        }
    }
}
