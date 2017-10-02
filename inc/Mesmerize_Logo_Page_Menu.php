<?php


class Mesmerize_Logo_Page_Menu extends \Walker_Page {


	public function display_logo( &$output ) {
		ob_start();
		mesmerize_print_logo();
		$logo = ob_get_clean();

		$output .= "<li class='logo'>{$logo}</li>";
	}

	public function walk( $elements, $max_depth ) {


		$args   = array_slice( func_get_args(), 2 );
		$output = '';

		//invalid parameter or nothing to walk
		if ( $max_depth < - 1 || empty( $elements ) ) {
			return $output;
		}

		$parent_field = $this->db_fields['parent'];

		// flat display
		if ( - 1 == $max_depth ) {
			$empty_array = array();
			foreach ( $elements as $e ) {
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			}

			return $output;
		}

		/*
		 * Need to display in hierarchical order.
		 * Separate elements into two buckets: top level and children elements.
		 * Children_elements is two dimensional array, eg.
		 * Children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e ) {
			if ( empty( $e->$parent_field ) ) {
				$top_level_elements[] = $e;
			} else {
				$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		/*
		 * When none of the elements is top level.
		 * Assume the first one must be root of the sub elements.
		 */
		if ( empty( $top_level_elements ) ) {

			$first = array_slice( $elements, 0, 1 );
			$root  = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e ) {
				if ( $root->$parent_field == $e->$parent_field ) {
					$top_level_elements[] = $e;
				} else {
					$children_elements[ $e->$parent_field ][] = $e;
				}
			}
		}


		$display_logo_after = ( count( $top_level_elements ) / 2 );

		foreach ( $top_level_elements as $index => $e ) {

			if ( $index + 1 > $display_logo_after && $index <= $display_logo_after ) {
				$this->display_logo( $output );
			}

			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
		}

		/*
		 * If we are displaying all levels, and remaining children_elements is not empty,
		 * then we got orphans, which should be displayed regardless.
		 */
		if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans ) {
				foreach ( $orphans as $op ) {
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
				}
			}
		}

		return $output;
	}

}