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

			add_action( 'admin_post_hmd_save_room', array( $this, 'save' ) );
			add_action( 'admin_post_hmd_delete_room', array( $this, 'delete' ) );

		}

		/**
		 * Guarda una sala.
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
				'name'               => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
				'display_name'       => sanitize_text_field( wp_unslash( $_POST['display_name'] ?? '' ) ),
				'slug'               => sanitize_title( wp_unslash( $_POST['slug'] ?? '' ) ),
				'floor'              => sanitize_text_field( wp_unslash( $_POST['floor'] ?? '' ) ),
				'capacity'           => absint( $_POST['capacity'] ?? 0 ),
				'status'             => sanitize_text_field( wp_unslash( $_POST['status'] ?? 'AVAILABLE' ) ),
				'screen_orientation' => sanitize_text_field( wp_unslash( $_POST['screen_orientation'] ?? 'LANDSCAPE' ) ),
				'photo_id'           => absint( $_POST['photo_id'] ?? 0 ),
				'background_id'      => absint( $_POST['background_id'] ?? 0 ),
			);

			// Validaciones.
			if ( '' === $data['name'] ) {
				$this->redirect( 'error=name_required' );
			}

			if ( '' === $data['slug'] ) {
				$this->redirect( 'error=slug_required' );
			}

			// Evitar slug duplicado.
			$existing = $this->repository->get_by_slug( $data['slug'] );

			if ( $existing && (int) $existing->id !== $id ) {
				$this->redirect( 'error=slug_exists' );
			}

			do_action( 'hmd_before_save_room', $data, $id );

			if ( 0 === $id ) {
				$result = $this->repository->insert( $data );
			} else {
				$result = $this->repository->update( $id, $data );
			}

			if ( false === $result ) {
				$this->redirect( 'error=db' );
			}

			do_action( 'hmd_after_save_room', $data, $id );

			$this->redirect( 'message=saved' );

		}

		/**
		 * Elimina una sala.
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

				do_action( 'hmd_before_delete_room', $id );

				$this->repository->delete( $id );

				do_action( 'hmd_after_delete_room', $id );

			}

			$this->redirect( 'message=deleted' );

		}

		/**
		 * Redirección centralizada.
		 */
		private function redirect( string $query ): void {

			wp_safe_redirect(
				admin_url(
					'admin.php?page=hmd-rooms&' . $query
				)
			);

			exit;

		}

	}
}