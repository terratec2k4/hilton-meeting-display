<?php
/**
 * Rooms List View.
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

// Comprobar permisos.
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die(
		esc_html__( 'You are not allowed to access this page.', 'hilton-meeting-display' )
	);
}

// Crear listado.
$list_table = new HMD_Room_List_Table();
$list_table->prepare_items();

?>

<div class="wrap">

	<h1 class="wp-heading-inline">
		<?php esc_html_e( 'Salas', 'hilton-meeting-display' ); ?>
	</h1>

	<a href="<?php echo esc_url( admin_url( 'admin.php?page=hmd-room-edit' ) ); ?>"
		class="page-title-action">

		<?php esc_html_e( 'Añadir nueva', 'hilton-meeting-display' ); ?>

	</a>

	<hr class="wp-header-end">

	<?php HMD_Notices::display(); ?>

	<form method="get">

		<input
			type="hidden"
			name="page"
			value="hmd-rooms"
		/>

		<?php
		$list_table->search_box(
			__( 'Buscar sala', 'hilton-meeting-display' ),
			'hmd-room'
		);

		$list_table->display();
		?>

	</form>

</div>
