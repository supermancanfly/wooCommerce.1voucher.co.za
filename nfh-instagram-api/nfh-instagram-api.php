<?php
/*
 * @link              http://www.ninjasforhire.co.za
 * @since             1.0.0
 * @package           NFH_Instagram_API
 *
 * @wordpress-plugin
 * Plugin Name:       NFH Instagram API
 * Plugin URI:        nfh-instagram-api
 * Description:       Ninjas for Hire: Connecting to the NFH API for Instagram feed.
 * Version:           1.0.0
 * Author:            Ninjas for Hire
 * Author URI:        http://www.ninjasforhire.co.za
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nfh-instagram-api
 */

$path = $_SERVER['DOCUMENT_ROOT'];

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once( ABSPATH . "wp-includes/pluggable.php" );


// set globals
define('NFH_INSTA_SD', str_replace('/wp-content/themes', '', get_theme_root()));	// site directory
define('NFH_INSTA_PD', plugin_dir_url( __FILE__ ));									// plugin directory

// set client details
define('NFH_INSTA_FEED', 'https://api.apify.com/v2/datasets/JafX6RbnSiuXhLMvh/items?clean=true&format=json');  		// json feed url
define('NFH_INSTA_PTYP', 'instagram'); 										 // set this only once, more will cause lost content
define('NFH_INSTA_INIS', 'draft');										  // initial status of new posts (draft or publish)

// includes
include "functions.php";

// enable post thumbnail theme support
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
}


// add custom post type for instagram
function nfh_1612812067_regpost_nfhinsta(){

	$singular = 'Instagram';
	$plural = 'Instagram';
	$posttype = NFH_INSTA_PTYP;

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
		'menu_icon' => 'dashicons-format-gallery'
	);

	register_post_type($posttype , $args);

}
add_action('init', 'nfh_1612812067_regpost_nfhinsta');



function nfh_1612812067_savefeed() {

	global $wpdb;

	$feedarr = nfh_1612812067_getfeed();

	if ( isset($feedarr) && !empty($feedarr) ) {

		foreach ($feedarr as $fa) {

			$testq = $wpdb->query("SELECT * FROM wp_postmeta WHERE meta_key = '_nfhapi_shortcode' AND meta_value = '$fa->shortCode'");

			if ($testq == 0) {

				$post_type = NFH_INSTA_PTYP;

				$post_data = array(
					'post_title' => $fa->timestamp,
					'post_content' => strip_tags($fa->caption),
					'post_type' => $post_type,
				);
				$new_pid = wp_insert_post( $post_data );

				// add meta
				update_post_meta( $new_pid, '_nfhapi_shortcode', $fa->shortCode );
				update_post_meta( $new_pid, '_nfhapi_timestamp', $fa->timestamp );

				// upload image
				$fsrc = media_sideload_image( $fa->displayUrl, null, null, 'src' );
				$image_id = attachment_url_to_postid( $fsrc );
				if( $image_id ) {

					$image = get_post( $image_id );
					if( $image ) {

						wp_update_post( array (
							'ID'         => $image->ID,
							'post_title' => $fa->timestamp
						) );

						$setfeat = set_post_thumbnail( $new_pid, $image->ID );

    				}
				}

			}
		}
	}

}

register_activation_hook(__FILE__, 'nfh_1612812067_activation');
function nfh_1612812067_activation() {
    if (! wp_next_scheduled ( 'my_hourly_event' )) {
    	wp_schedule_event(time(), 'hourly', 'my_hourly_event');
    }
}

add_action('my_hourly_event', 'nfh_1612812067_do_this_hourly');
function nfh_1612812067_do_this_hourly() {
	// check every hour
	nfh_1612812067_savefeed();
}













