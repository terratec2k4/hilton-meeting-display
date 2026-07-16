<?php
declare(strict_types=1);

namespace HMD;

defined('ABSPATH') || exit;

final class Database
{
    /**
     * Plugin database version.
     */
    private const DB_VERSION = '1.0.0';

    /**
     * Install plugin tables.
     */
    public static function install(): void
    {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charset = $wpdb->get_charset_collate();

        self::createRoomsTable($wpdb, $charset);
        self::createEventsTable($wpdb, $charset);
        self::createSettingsTable($wpdb, $charset);

        update_option('hmd_db_version', self::DB_VERSION);
    }

    /**
     * Rooms table.
     */
    private static function createRoomsTable(\wpdb $wpdb, string $charset): void
    {
        $table = $wpdb->prefix . 'hmd_rooms';

        $sql = "
        CREATE TABLE {$table} (

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            name VARCHAR(150) NOT NULL,

            slug VARCHAR(150) NOT NULL,

            floor VARCHAR(50) NULL,

            status VARCHAR(30) NOT NULL DEFAULT 'available',

            logo_id BIGINT UNSIGNED NULL,

            background_id BIGINT UNSIGNED NULL,

            created_at DATETIME NOT NULL,

            updated_at DATETIME NOT NULL,

            PRIMARY KEY (id),

            UNIQUE KEY slug (slug)

        ) {$charset};
        ";

        dbDelta($sql);
    }

    /**
     * Events table.
     */
    private static function createEventsTable(\wpdb $wpdb, string $charset): void
    {
        $table = $wpdb->prefix . 'hmd_events';

        $sql = "
        CREATE TABLE {$table} (

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            room_id BIGINT UNSIGNED NOT NULL,

            title VARCHAR(255) NOT NULL,

            company VARCHAR(255) NULL,

            organizer VARCHAR(255) NULL,

            event_date DATE NOT NULL,

            start_time TIME NOT NULL,

            end_time TIME NOT NULL,

            company_logo_id BIGINT UNSIGNED NULL,

            company_image_id BIGINT UNSIGNED NULL,

            welcome_message TEXT NULL,

            notes LONGTEXT NULL,

            created_at DATETIME NOT NULL,

            updated_at DATETIME NOT NULL,

            PRIMARY KEY (id),

            KEY room_id (room_id),

            KEY event_date (event_date)

        ) {$charset};
        ";

        dbDelta($sql);
    }

    /**
     * Settings table.
     */
    private static function createSettingsTable(\wpdb $wpdb, string $charset): void
    {
        $table = $wpdb->prefix . 'hmd_settings';

        $sql = "
        CREATE TABLE {$table} (

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            hotel_name VARCHAR(255) NOT NULL,

            hotel_logo_id BIGINT UNSIGNED NULL,

            timezone VARCHAR(100) NOT NULL,

            weather_city VARCHAR(150) NULL,

            language VARCHAR(20) NOT NULL DEFAULT 'es_ES',

            theme VARCHAR(50) NOT NULL DEFAULT 'hilton',

            created_at DATETIME NOT NULL,

            updated_at DATETIME NOT NULL,

            PRIMARY KEY (id)

        ) {$charset};
        ";

        dbDelta($sql);
    }
}
