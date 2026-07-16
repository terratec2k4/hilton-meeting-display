<?php
defined( 'ABSPATH' ) || exit;

global $wpdb;

$rooms     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}hmd_rooms" );
$companies = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}hmd_companies" );
$events    = (int) $wpdb->get_var(
    $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}hmd_events WHERE event_date = %s",
        current_time( 'Y-m-d' )
    )
);

?>

<div class="wrap">

    <h1>Hilton Meeting Display</h1>

    <div class="hmd-dashboard">

        <div class="hmd-card">
            <h2>🏨 Salas</h2>
            <p><?php echo esc_html( $rooms ); ?></p>
        </div>

        <div class="hmd-card">
            <h2>🏢 Empresas</h2>
            <p><?php echo esc_html( $companies ); ?></p>
        </div>

        <div class="hmd-card">
            <h2>📅 Eventos hoy</h2>
            <p><?php echo esc_html( $events ); ?></p>
        </div>

        <div class="hmd-card">
            <h2>🖥 Pantallas</h2>
            <p>0</p>
        </div>

    </div>

    <hr>

    <h2>Estado del sistema</h2>

    <table class="widefat striped">

        <tbody>

        <tr>
            <td>Plugin</td>
            <td>🟢 Activo</td>
        </tr>

        <tr>
            <td>PHP</td>
            <td><?php echo esc_html( PHP_VERSION ); ?></td>
        </tr>

        <tr>
            <td>WordPress</td>
            <td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td>
        </tr>

        <tr>
            <td>Base de datos</td>
            <td>🟢 Disponible</td>
        </tr>

        </tbody>

    </table>

</div>
