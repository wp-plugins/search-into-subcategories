<?php
/*
 Plugin Name: Bsearch-into-subcategories
Plugin URI: http://wordpress.org/extend/plugins/ TODO
Description: search-into-subcategories
Author: lion2486
Version: 0.1
Author URI: http://codescar.eu
Contributors: lion2486
Tags: search, subcategories
Requires at least: 3.0.1
Tested up to: 3.8.1
Text Domain: search-into-subcategories
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class SIS{
	public static $SIS_DATA;
	
	public function SIS_shortcode( $atts ) {
	
		SIS::$SIS_DATA = array();
	
		$text = '<form action="'. bloginfo('siteurl') .'" mathod="GET" name="SIS_form">';
		
		// Attributes
		extract( shortcode_atts(
			array(
				'parent_category' => '0',
				'max_depth' => '2',
				'search_input' => '1',
				'labels' => '',
				'search_text' => 'Search',
				'hide_empty' => 1,
				'exclude' => ''
			), $atts )
		);
	
		if( '' != $labels )
			$labels = explode( '|', $labels );
			
		$children = get_categories( array(
			'parent' => $parent_category,
		) );
		
		$walker = new My_Walker_CategoryDropdown;
		
		$args = array(
			'show_option_all'    => '',
			'show_option_none'   => '',
			'orderby'            => 'ID', 
			'order'              => 'ASC',
			'show_count'         => 0,
			'hide_empty'         => $hide_empty, 
			'child_of'           => $parent_category,
			'exclude'            => $exclude,
			'echo'               => 0,
			'selected'           => 0,
			'hierarchical'       => 1, 
			'name'               => 'level-0',
			'id'                 => 'level-0',
			'class'              => 'postform',
			'depth'              => $max_depth,
			'tab_index'          => 0,
			'taxonomy'           => 'category',
			'hide_if_empty'      => false,
			'walker'             => $walker
		); 

		if(count($labels) >= 0)
			$text .= "<label for=\"level-0\">{$labels[0]}: </label>";
		$text .= wp_dropdown_categories( $args );
		
		$text .= "<br/>";
		for($i=1;$i<$max_depth;$i++){
			if(count($labels) > $i)
				$text .= "<label for=\"level-$i\">{$labels[$i]}: </label>";
			$text .= "<select name=\"level-$i\" id=\"level-$i\" disabled=\"disabled\"><option>-- SELECT --</option></select>  <br/>";
		}
		
		$text .= '	<script type="text/javascript">
						var data = '. json_encode(SIS::$SIS_DATA) .';
					
						function LOAD_SIS_HANDLER(){';
							for($i=0;$i<$max_depth;$i++){
								$text .= 'add_SIS_level('. $i .');';
							}
						
		$text .=		'}
					</script>';
					
		if( 1 == $search_input ){
			if(count($labels) > $max_depth)
				$text .= "<label for=\"level-$i\">{$labels[$max_depth]}: </label>";
			$text .= '<input type="text" name="s" id="s" placeholder="Search..." /><br/>';
		}
			
		$text .= '<input type="hidden" name="cat" id="category" value="0" />';
		$text .= '<input class="button button-primary" type="submit" value="'. $search_text .'" /><br/>';
		$text .= '</form>';
		
		return $text;
	}
	function my_scripts() {
		wp_enqueue_script(
			'SIS_script',
			plugins_url( '/script.js', __FILE__ ),
			array( 'jquery' )
		);
	}
}
add_shortcode( 'search-into-subcategories', array( 'SIS', 'SIS_shortcode' ) );
add_action( 'wp_enqueue_scripts', array( 'SIS', 'my_scripts' ) );

class My_Walker_CategoryDropdown extends Walker {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
	
	//static var $data;

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int    $depth    Depth of category. Used for padding.
	 * @param array  $args     Uses 'selected' and 'show_count' keys, if they exist. @see wp_dropdown_categories()
	 */
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
			global $SIS_DATA;
			
			$pad = str_repeat('&nbsp;', $depth * 3);

			$cat_name = apply_filters('list_cats', $category->name, $category);
			if($depth != 0){
				SIS::$SIS_DATA[$category->parent] = array($category->term_id => $cat_name) ;
			}else{
				$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\"";
				if ( $category->term_id == $args['selected'] )
						$output .= ' selected="selected"';
				$output .= '>';
				$output .= $pad.$cat_name;
				if ( $args['show_count'] )
						$output .= '&nbsp;&nbsp;('. $category->count .')';
				$output .= "</option>\n";
			}
			
		}
		
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		


		//$output .= print_r($SELF::data, true);
	}
}