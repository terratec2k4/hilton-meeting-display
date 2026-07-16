<?php
/**
 * Room Repository
 *
 * @package HiltonMeetingDisplay
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'HMD_Room_Repository' ) ) {

	final class HMD_Room_Repository {

		/**
		 * Tabla de salas.
		 *
		 * @var string
		 */
		private string $table;

		/**
		 * Constructor.
		 */
		public function __construct() {

			global $wpdb;

			$this->table = $wpdb->prefix . 'hmd_rooms';

		}

		/**
		 * Obtiene todas las salas.
		 *
		 * @return array
		 */
		public function get_all(): array {

			global $wpdb;

			$sql = "SELECT * FROM {$this->table} ORDER BY name ASC";

			return $wpdb->get_results( $sql );
		}

		/**
		 * Obtiene una sala.
		 *
		 * @param int $id ID.
		 * @return object|null
		 */
		public function get( int $id ) {

			global $wpdb;

			return $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM {$this->table} WHERE id = %d",
					$id
				)
			);

		}

		/**
		 * Busca una sala por slug.
		 *
		 * @param string $slug Slug.
		 * @return object|null
		 */
		public function get_by_slug( string $slug ) {

			global $wpdb;

			return $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM {$this->table} WHERE slug = %s",
					$slug
				)
			);

		}

		/**
		 * Inserta una sala.
		 *
		 * @param array $data Datos.
		 * @return int
		 */
		public function insert( array $data ): int {

			global $wpdb;

			$wpdb->insert(
				$this->table,
				$data
			);

			return (int) $wpdb->insert_id;

		}

		/**
		 * Actualiza una sala.
		 *
		 * @param int   $id   ID.
		 * @param array $data Datos.
		 * @return bool
		 */
		public function update(
			int $id,
			array $data
		): bool {

			global $wpdb;

			return false !== $wpdb->update(
				$this->table,
				$data,
				array(
					'id' => $id,
				)
			);

		}

		/**
		 * Elimina una sala.
		 *
		 * @param int $id ID.
		 * @return bool
		 */
		public function delete( int $id ): bool {

			global $wpdb;

			return false !== $wpdb->delete(
				$this->table,
				array(
					'id' => $id,
				)
			);

		}

		/**
		 * Comprueba si existe un slug.
		 *
		 * @param string $slug Slug.
		 * @return bool
		 */
		public function exists_slug(
			string $slug
		): bool {

			return null !== $this->get_by_slug( $slug );

		}

		/**
		 * Número total de salas.
		 *
		 * @return int
		 */
		public function count(): int {

			global $wpdb;

			return (int) $wpdb->get_var(
				"SELECT COUNT(*) FROM {$this->table}"
			);

		}

	}
}
