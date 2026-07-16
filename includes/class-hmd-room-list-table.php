<?php
/**
 * Room List Table.
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

if ( ! class_exists( 'HMD_Room_List_Table' ) ) {

	class HMD_Room_List_Table extends WP_List_Table {

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

			parent::__construct(
				array(
					'singular' => 'room',
					'plural'   => 'rooms',
					'ajax'     => false,
				)
			);

			$this->repository = new HMD_Room_Repository();

		}

		/**
		 * Columnas.
		 *
		 * @return array
		 */
		public function get_columns(): array {

			return array(
				'cb'                 => '<input type="checkbox" />',
				'status'             => __( 'Estado', 'hilton-meeting-display' ),
				'name'               => __( 'Nombre', 'hilton-meeting-display' ),
				'display_name'       => __( 'Mostrar', 'hilton-meeting-display' ),
				'floor'              => __( 'Planta', 'hilton-meeting-display' ),
				'capacity'           => __( 'Capacidad', 'hilton-meeting-display' ),
				'screen_orientation' => __( 'Pantalla', 'hilton-meeting-display' ),
				'url'                => __( 'URL', 'hilton-meeting-display' ),
			);

		}

		/**
		 * Columnas ordenables.
		 *
		 * @return array
		 */
		protected function get_sortable_columns(): array {

			return array(
				'name'     => array( 'name', true ),
				'floor'    => array( 'floor', false ),
				'capacity' => array( 'capacity', false ),
			);

		}

		/**
		 * Acciones masivas.
		 *
		 * @return array
		 */
		protected function get_bulk_actions(): array {

			return array(
				'delete' => __( 'Eliminar', 'hilton-meeting-display' ),
			);

		}

		/**
		 * Checkbox.
		 *
		 * @param object $item Sala.
		 * @return string
		 */
		protected function column_cb( $item ): string {

			return sprintf(
				'<input type="checkbox" name="room[]" value="%d" />',
				(int) $item->id
			);

		}

		/**
		 * Columna Nombre.
		 *
		 * @param object $item Sala.
		 * @return string
		 */
		protected function column_name( $item ): string {

			$edit_url = admin_url(
				'admin.php?page=hmd-room-edit&id=' . (int) $item->id
			);

			$preview_url = home_url(
				'/meeting-display/' . $item->slug
			);

			$actions = array(
				'edit' => sprintf(
					'<a href="%s">%s</a>',
					esc_url( $edit_url ),
					__( 'Editar', 'hilton-meeting-display' )
				),
				'preview' => sprintf(
					'<a href="%s" target="_blank">%s</a>',
					esc_url( $preview_url ),
					__( 'Vista previa', 'hilton-meeting-display' )
				),
			);

			return sprintf(
				'<strong>%s</strong>%s',
				esc_html( $item->name ),
				$this->row_actions( $actions )
			);

		}

		/**
		 * Estado.
		 *
		 * @param object $item Sala.
		 * @return string
		 */
		protected function column_status( $item ): string {

			$statuses = array(
				'AVAILABLE'      => '🟢 Disponible',
				'IN_USE'         => '🔵 En uso',
				'SETUP'          => '🟡 Preparación',
				'CLEANING'       => '🟠 Limpieza',
				'OUT_OF_SERVICE' => '🔴 Fuera de servicio',
			);

			return esc_html(
				$statuses[ $item->status ] ?? $item->status
			);

		}

		/**
		 * URL.
		 *
		 * @param object $item Sala.
		 * @return string
		 */
		protected function column_url( $item ): string {

			$url = home_url( '/meeting-display/' . $item->slug );

			return sprintf(
				'<input type="text" class="regular-text hmd-url" readonly value="%s" />
				<button type="button" class="button hmd-copy-url">%s</button>',
				esc_url( $url ),
				esc_html__( 'Copiar', 'hilton-meeting-display' )
			);

		}

		/**
		 * Columna por defecto.
		 *
		 * @param object $item Sala.
		 * @param string $column_name Columna.
		 * @return string
		 */
		protected function column_default( $item, $column_name ): string {

			return esc_html(
				(string) ( $item->$column_name ?? '' )
			);

		}

		/**
		 * Preparar datos.
		 */
		public function prepare_items(): void {

			$per_page = 20;
			$current_page = $this->get_pagenum();

			$search = '';

			if ( isset( $_REQUEST['s'] ) ) {
				$search = sanitize_text_field( wp_unslash( $_REQUEST['s'] ) );
			}

			if ( '' !== $search ) {

				$data = $this->repository->search( $search );
				$total_items = count( $data );

			} else {

				$total_items = $this->repository->count();

				$data = $this->repository->get_paginated(
					$per_page,
					( $current_page - 1 ) * $per_page
				);

			}

			$this->_column_headers = array(
				$this->get_columns(),
				array(),
				$this->get_sortable_columns(),
			);

			$this->items = $data;

			$this->set_pagination_args(
				array(
					'total_items' => $total_items,
					'per_page'    => $per_page,
				)
			);

		}

		/**
		 * Mensaje cuando no hay registros.
		 */
		public function no_items(): void {

			esc_html_e(
				'No hay salas creadas.',
				'hilton-meeting-display'
			);

		}

	}
}
