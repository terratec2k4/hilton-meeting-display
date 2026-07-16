<?php
/**
 * Room Controller.
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'HMD_Room_Controller' ) ) {

	final class HMD_Room_Controller {

		/**
		 * Repositorio.
		 *
		 * @var HMD_Room_Repository
		 */
		private HMD_Room_Repository $repository;

		/**
		 * Constructor.
		 */
		public function __construct() {

			$this->repository = new HMD_Room_Repository();

			add_action(
				'admin_post_hmd_save_room',
				array( $this, 'save' )
			);

			add_action(
				'admin_post_hmd_delete_room',
				array( $this, 'delete' )
			);

		}

		/**
		 * Guarda una sala.
		 *
		 * @return void
		 */
		public function save(): void {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die(
					esc_html__( 'You are not allowed to perform this action.', 'hilton-meeting-display' )
				);
			}

			check_admin_referer( 'hmd_save_room' );

			$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

			$data = array(
				'name'                => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
				'display_name'        => sanitize_text_field( wp_unslash( $_POST['display_name'] ?? '' ) ),
				'slug'                => sanitize_title( wp_unslash( $_POST['slug'] ?? '' ) ),
				'floor'               => sanitize_text_field( wp_unslash( $_POST['floor'] ?? '' ) ),
				'capacity'            => absint( $_POST['capacity'] ?? 0 ),
				'status'              => sanitize_text_field( wp_unslash( $_POST['status'] ?? 'AVAILABLE' ) ),
				'screen_orientation'  => sanitize_text_field( wp_unslash( $_POST['screen_orientation'] ?? 'LANDSCAPE' ) ),
				'photo_id'            => absint( $_POST['photo_id'] ?? 0 ),
				'background_id'       => absint( $_POST['background_id'] ?? 0 ),
			);

			if ( 0 === $id ) {
				$this->repository->insert( $data );
			} else {
				$this->repository->update( $id, $data );
			}

			wp_safe_redirect(
				admin_url(
					'admin.php?page=hmd-rooms&message=saved'
				)
			);

			exit;

		}

		/**
		 * Elimina una sala.
		 *
		 * @return void
		 */
		public function delete(): void {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die(
					esc_html__( 'You are not allowed to perform this action.', 'hilton-meeting-display' )
				);
			}

			check_admin_referer( 'hmd_delete_room' );

			$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;

			if ( $id > 0 ) {
				$this->repository->delete( $id );
			}

			wp_safe_redirect(
				admin_url(
					'admin.php?page=hmd-rooms&message=deleted'
				)
			);

			exit;

		}

	}
}
