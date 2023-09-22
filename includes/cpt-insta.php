<?php 
	// add custom post type - Services
	function instagramRegister(){

		$singular = 'Instagram';
		$plural = 'Instagram';
		$posttype = 'instagram';

		$labels = array(
			'name' => _x($plural, 'post type general name'),
			'singular_name' => _x($singular, 'post type singular name'),
			'add_new' => _x('Add New', strtolower($singular)),
			'add_new_item' => __('Add New '.$singular),
			'edit_item' => __('Edit '.$singular),
			'new_item' => __('New '.$singular),
			'view_item' => __('View '.$singular),
			'search_items' => __('Search '.$plural),
			'not_found' => __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title', 'editor', 'thumbnail'),
			'rewrite' => true,
			'show_in_nav_menus' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-screenoptions'
		);

		register_post_type($posttype , $args);

	}
	add_action('init', 'instagramRegister');

?>