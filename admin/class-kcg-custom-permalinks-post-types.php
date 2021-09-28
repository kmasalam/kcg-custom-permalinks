<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Custom_Permalinks_Post_Types {
	
	public static function total_permalinks() {
		global $wpdb;

		$total_posts = wp_cache_get( 'total_posts_result', 'custom_permalinks' );
		if ( ! $total_posts ) {
			$sql_query = "
				SELECT COUNT(p.ID) FROM $wpdb->posts AS p
				LEFT JOIN $wpdb->postmeta AS pm ON (p.ID = pm.post_id)
				WHERE pm.meta_key = 'custom_permalink' AND pm.meta_value != ''
			";
			
			if ( isset( $_REQUEST['s'] ) && ! empty( $_REQUEST['s'] ) ) {
				$search_value = ltrim( sanitize_text_field( $_REQUEST['s'] ), '/' );
				
				$total_posts = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT COUNT(p.ID) FROM {$wpdb->posts} AS p
							LEFT JOIN {$wpdb->postmeta} AS pm ON (p.ID = pm.post_id)
							WHERE pm.meta_key = 'custom_permalink'
								AND pm.meta_value != ''
								AND pm.meta_value LIKE %s",
						'%' . $wpdb->esc_like( $search_value ) . '%'
					)
				);
				
			} else {
				
				$total_posts = $wpdb->get_var(
					"SELECT COUNT(p.ID) FROM {$wpdb->posts} AS p
						LEFT JOIN {$wpdb->postmeta} AS pm ON (p.ID = pm.post_id)
						WHERE pm.meta_key = 'custom_permalink' AND pm.meta_value != ''"
				);
			}

			wp_cache_set( 'total_posts_result', $total_posts, 'custom_permalinks' );
		}

		return $total_posts;
	}

	public static function get_permalinks( $per_page = 20, $page_number = 1 ) {
		global $wpdb;

		$posts = wp_cache_get( 'post_type_results', 'custom_permalinks' );
		if ( ! $posts ) {
			$page_offset = ( $page_number - 1 ) * $per_page;
			$order_by    = 'p.ID';
			$order       = null;

			switch ( isset( $_REQUEST['orderby'] ) ? strtolower( sanitize_text_field( $_REQUEST['orderby'] ) ) : '' ) {
				case 'title':
					$order_by = 'p.post_title';
					break;

				case 'type':
					$order_by = 'p.post_type';
					break;

				case 'permalink':
					$order_by = 'pm.meta_value';
					break;
			}

			switch ( isset( $_REQUEST['order'] ) ? strtolower( sanitize_text_field( $_REQUEST['order'] ) ) : '' ) {
				case 'asc':
					$order = 'ASC';
					break;

				case 'desc':
				default:
					$order = 'DESC';
					break;
			}
			if ( isset( $_REQUEST['s'] ) && ! empty( $_REQUEST['s'] ) ) {
				$search_value = ltrim( sanitize_text_field( $_REQUEST['s'] ), '/' );
			
				$posts = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT p.ID, p.post_title, p.post_type, pm.meta_value
							FROM {$wpdb->posts} AS p
						LEFT JOIN {$wpdb->postmeta} AS pm ON (p.ID = pm.post_id)
						WHERE pm.meta_key = 'custom_permalink'
							AND pm.meta_value != ''
							AND pm.meta_value LIKE %s
						ORDER BY %s %s LIMIT %d, %d",
						'%' . $wpdb->esc_like( $search_value ) . '%',
						$order_by,
						$order,
						$page_offset,
						$per_page
					),
					ARRAY_A
				);
			} else {
				
				$posts = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT p.ID, p.post_title, p.post_type, pm.meta_value
							FROM {$wpdb->posts} AS p
						LEFT JOIN {$wpdb->postmeta} AS pm ON (p.ID = pm.post_id)
						WHERE pm.meta_key = 'custom_permalink' AND pm.meta_value != ''
						ORDER BY %s %s LIMIT %d, %d",
						$order_by,
						$order,
						$page_offset,
						$per_page
					),
					ARRAY_A
				);
			}
		
			wp_cache_set( 'post_type_results', $posts, 'custom_permalinks' );
		}

		return $posts;
	}
}
