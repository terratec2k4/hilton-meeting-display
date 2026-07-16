<?php
/**
 * Room Edit View.
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die(
		esc_html__( 'You are not allowed to access this page.', 'hilton-meeting-display' )
	);
}

$repository = new HMD_Room_Repository();

$room = (object) array(
	'id'                 => 0,
	'name'               => '',
	'display_name'       => '',
	'slug'               => '',
	'floor'              => '',
	'capacity'           => 0,
	'status'             => 'AVAILABLE',
	'screen_orientation' => 'LANDSCAPE',
	'photo_id'           => 0,
	'background_id'      => 0,
);

if ( isset( $_GET['id'] ) ) {
	$room = $repository->get( absint( $_GET['id'] ) );
}

?>

<div class="wrap">

	<h1 class="wp-heading-inline">

		<?php
		echo $room->id
			? esc_html__( 'Editar sala', 'hilton-meeting-display' )
			: esc_html__( 'Nueva sala', 'hilton-meeting-display' );
		?>

	</h1>

	<hr class="wp-header-end">

	<form method="post"
	      action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

		<?php wp_nonce_field( 'hmd_save_room' ); ?>

		<input type="hidden" name="action" value="hmd_save_room">

		<input type="hidden"
		       name="id"
		       value="<?php echo esc_attr( $room->id ); ?>">

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-2">

				<div id="post-body-content">

					<div class="postbox">

						<h2 class="hndle">
							<span><?php esc_html_e( 'Información', 'hilton-meeting-display' ); ?></span>
						</h2>

						<div class="inside">

							<table class="form-table">

								<tr>
									<th>Nombre interno</th>
									<td>
										<input
											type="text"
											name="name"
											class="regular-text"
											value="<?php echo esc_attr( $room->name ); ?>"
											required>
									</td>
								</tr>

								<tr>
									<th>Nombre visible</th>
									<td>
										<input
											type="text"
											name="display_name"
											class="regular-text"
											value="<?php echo esc_attr( $room->display_name ); ?>">
									</td>
								</tr>

								<tr>
									<th>Slug</th>
									<td>
										<input
											type="text"
											name="slug"
											class="regular-text"
											value="<?php echo esc_attr( $room->slug ); ?>">
									</td>
								</tr>

								<tr>
									<th>Planta</th>
									<td>
										<input
											type="text"
											name="floor"
											class="regular-text"
											value="<?php echo esc_attr( $room->floor ); ?>">
									</td>
								</tr>

								<tr>
									<th>Capacidad</th>
									<td>
										<input
											type="number"
											name="capacity"
											min="0"
											value="<?php echo esc_attr( $room->capacity ); ?>">
									</td>
								</tr>

							</table>

						</div>

					</div>

				</div>

				<div id="postbox-container-1" class="postbox-container">

					<div class="postbox">

						<h2 class="hndle">
							<span><?php esc_html_e( 'Pantalla', 'hilton-meeting-display' ); ?></span>
						</h2>

						<div class="inside">

							<p>

								<label>
									Estado
								</label>

								<select name="status">

									<option value="AVAILABLE">Disponible</option>

									<option value="IN_USE">En uso</option>

									<option value="SETUP">Preparación</option>

									<option value="CLEANING">Limpieza</option>

									<option value="OUT_OF_SERVICE">Fuera de servicio</option>

								</select>

							</p>

							<p>

								<label>

									Orientación

								</label>

								<select name="screen_orientation">

									<option value="LANDSCAPE">Horizontal</option>

									<option value="PORTRAIT">Vertical</option>

								</select>

							</p>

							<p>

								<input
									type="submit"
									class="button button-primary button-large"
									value="<?php esc_attr_e( 'Guardar sala', 'hilton-meeting-display' ); ?>">

							</p>

						</div>

					</div>

				</div>

			</div>

		</div>

	</form>

</div>
