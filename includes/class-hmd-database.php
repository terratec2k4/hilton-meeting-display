<?php
defined('ABSPATH') || exit;

if ( ! class_exists( 'HMD_Database' ) ) {

    final class HMD_Database {

        /**
         * Versión del esquema de base de datos.
         */
        const DB_VERSION = '1.0.0';

        /**
         * Instala o actualiza la base de datos.
         */
        public static function install() {

            global $wpdb;

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            $charset_collate = $wpdb->get_charset_collate();

            self::create_rooms_table( $wpdb, $charset_collate );
            self::create_companies_table( $wpdb, $charset_collate );
            self::create_events_table( $wpdb, $charset_collate );
            self::create_settings_table( $wpdb, $charset_collate );

            update_option( 'hmd_db_version', self::DB_VERSION );
        }

        /**
         * Tabla de salas.
         */
        private static function create_rooms_table( $wpdb, $charset_collate ) {

            $table = $wpdb->prefix . 'hmd_rooms';

            $sql = "CREATE TABLE {$table} (

                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

                name VARCHAR(150) NOT NULL,

                display_name VARCHAR(150) NOT NULL,

                slug VARCHAR(150) NOT NULL,

                floor VARCHAR(100) NULL,

                capacity SMALLINT UNSIGNED DEFAULT 0,

                status VARCHAR(30) NOT NULL DEFAULT 'AVAILABLE',

                photo_id BIGINT UNSIGNED NULL,

                background_id BIGINT UNSIGNED NULL,

                screen_orientation VARCHAR(20) DEFAULT 'LANDSCAPE',

                created_at DATETIME NOT NULL,

                updated_at DATETIME NOT NULL,

                PRIMARY KEY (id),

                UNIQUE KEY slug (slug)

            ) {$charset_collate};";

            dbDelta( $sql );
        }

        /**
         * Tabla de empresas.
         */
        private static function create_companies_table( $wpdb, $charset_collate ) {

            $table = $wpdb->prefix . 'hmd_companies';

            $sql = "CREATE TABLE {$table} (

                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

                name VARCHAR(200) NOT NULL,

                logo_id BIGINT UNSIGNED NULL,

                image_id BIGINT UNSIGNED NULL,

                website VARCHAR(255) NULL,

                contact_name VARCHAR(150) NULL,

                contact_email VARCHAR(150) NULL,

                created_at DATETIME NOT NULL,

                updated_at DATETIME NOT NULL,

                PRIMARY KEY (id)

            ) {$charset_collate};";

            dbDelta( $sql );
        }

        /**
         * Tabla de eventos.
         */
        private static function create_events_table( $wpdb, $charset_collate ) {

            $table = $wpdb->prefix . 'hmd_events';

            $sql = "CREATE TABLE {$table} (

                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

                room_id BIGINT UNSIGNED NOT NULL,

                company_id BIGINT UNSIGNED NULL,

                title VARCHAR(255) NOT NULL,

                organizer VARCHAR(255) NULL,

                event_date DATE NOT NULL,

                start_time TIME NOT NULL,

                end_time TIME NOT NULL,

                welcome_message TEXT NULL,

                agenda LONGTEXT NULL,

                notes LONGTEXT NULL,

                created_at DATETIME NOT NULL,

                updated_at DATETIME NOT NULL,

                PRIMARY KEY (id),

                KEY room_id (room_id),

                KEY company_id (company_id),

                KEY event_date (event_date)

            ) {$charset_collate};";

            dbDelta( $sql );
        }

        /**
         * Tabla de configuración.
         */
        private static function create_settings_table( $wpdb, $charset_collate ) {

            $table = $wpdb->prefix . 'hmd_settings';

            $sql = "CREATE TABLE {$table} (

                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

                hotel_name VARCHAR(255) NOT NULL,

                hotel_logo_id BIGINT UNSIGNED NULL,

                timezone VARCHAR(100) NOT NULL,

                weather_city VARCHAR(100) NULL,

                language VARCHAR(20) DEFAULT 'es_ES',

                theme VARCHAR(50) DEFAULT 'hilton',

                refresh_seconds SMALLINT UNSIGNED DEFAULT 60,

                created_at DATETIME NOT NULL,

                updated_at DATETIME NOT NULL,

                PRIMARY KEY (id)

            ) {$charset_collate};";

            dbDelta( $sql );
        }
    }
}
