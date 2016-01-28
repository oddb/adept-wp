<?php 
    /*
    Plugin Name: Lingu Plugin
    Plugin URI: http://www.orangecreative.net
    Description: Plugin for Lingu
    Author: Viral Sonawala
    Version: 1.0
    */


	class WP_Adept_LMS{

  // Constructor
    function __construct() {

        add_action( 'admin_menu', array( $this, 'wpa_add_menu' ));
        register_activation_hook( __FILE__, array( $this, 'wpa_install' ) );
        register_deactivation_hook( __FILE__, array( $this, 'wpa_uninstall' ) );
    }

    /*
      * Actions perform at loading of admin menu
      */
    function wpa_add_menu() {

        add_wmenu_page( 'plugins.php', 'Adept LMS', 'manage_options', 'adept_lms', array(
                          __CLASS__,
                         'wpa_page_file_path'
                        ), plugins_url('images/wp-logo.png', __FILE__),'2.2.9');

        add_submenu_page( 'adept_lms', 'Adept LMS' . ' Settings', '<b style="color:#f9845b">Settings</b>', 'manage_options', 'adept_lms_settings', array(
                              __CLASS__,
                             'wpa_page_file_path1'
                            ));
    }

    /*
     * Actions perform on loading of menu pages
     */
    function wpa_page_file_path() {

		foreach ( glob( plugin_dir_path( __FILE__ ) . "includes/adept_lms.php" ) as $file ) {
			include_once $file;
		}
    }
	
    /*
     * Actions perform on loading of menu pages
     */
    function wpa_page_file_path1(){

		foreach ( glob( plugin_dir_path( __FILE__ ) . "includes/adept_lms_settings.php" ) as $file ) {
			include_once $file;
		}
    }

    /*
     * Actions perform on activation of plugin
     */
    function wpa_install() {



    }

    /*
     * Actions perform on de-activation of plugin
     */
    function wpa_uninstall() {



    }

}

add_action( 'admin_menu', array( $this, 'wpa_add_menu' ));

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'courses',
	array(
	  'labels' => array(
		'name' => __( 'Courses' ),
		'singular_name' => __( 'Course' ),
		'menu_name'          => _x( 'Courses', 'admin menu', 'Course' ),
		'name_admin_bar'     => _x( 'Course', 'add new on admin bar', 'Course' ),
		'add_new'            => _x( 'Add New Course', 'Course', 'Course' ),
		'add_new_item'       => __( 'Add New Course', 'Course' ),
		'new_item'           => __( 'New Course', 'Course' ),
		'edit_item'          => __( 'Edit Course', 'Course' ),
		'view_item'          => __( 'View Course', 'Course' ),
		'all_items'          => __( 'All Course', 'Course' ),
		'search_items'       => __( 'Search Course', 'Course' ),
		'parent_item_colon'  => __( 'Parent Course:', 'Course' ),
		'not_found'          => __( 'No Course found.', 'Course' ),
		'not_found_in_trash' => __( 'No Course found in Trash.', 'Course' )
	  ),
	  'public' => true,
	  'has_archive' => true,
	  'supports' => array( 'title', 'editor', 'excerpt' ),
	  'register_meta_box_cb' => 'add_course_metaboxes'
	)
  );
}


add_action( 'add_meta_boxes', 'add_course_metaboxes' );

// Add the Course Meta Boxes

function add_course_metaboxes() {
	add_meta_box('wpt_course_fields', 'Course Other details', 'wpt_course_fields', 'courses', 'normal', 'high');
}

function wpt_course_fields() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="coursemeta_noncename" id="coursemeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the teaser data if its already been entered
	$teaser = get_post_meta($post->ID, '_teaser', true);
	// Echo out the field
	echo '<b>Teaser :</b> <input type="text" name="_teaser" value="' . $teaser  . '" class="widefat" /><br/><br/>';
	
	// Get the tags data if its already been entered
	$tags = get_post_meta($post->ID, '_tags', true);
	// Echo out the field
	echo '<b>Tags : </b><input type="text" name="_tags" value="' . $tags  . '" class="widefat" /><br/><br/>';
	
	// Get the is_featured data if its already been entered
	$is_featured = get_post_meta($post->ID, '_is_featured', true);
	// Echo out the field
	echo '<b>Is Featured :</b> <input type="radio" name="_is_featured" value="true" class="widefat" /> True ';
	echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="_is_featured" value="false" class="widefat" /> False <br/><br/>';
	
	// Get the course_fee data if its already been entered
	$course_fee = get_post_meta($post->ID, '_course_fee', true);
	// Echo out the field
	echo '<b>Course Fee :</b> <input type="text" name="_course_fee" value="' . $course_fee  . '" class="widefat" /><br/><br/>';
	
	// Get the sku data if its already been entered
	$sku = get_post_meta($post->ID, '_sku', true);
	// Echo out the field
	echo '<b>SKU :</b> <input type="text" name="_sku" value="' . $sku  . '" class="widefat" /><br/><br/>';
	
    // Get the tax_category data if its already been entered
	$tax_category = get_post_meta($post->ID, '_tax_category', true);
	// Echo out the field
	echo '<b>Tax Category :</b> <input type="text" name="_tax_category" value="' . $tax_category  . '" class="widefat" /><br/><br/>';
	
	// Get the allow_discounts data if its already been entered
	$allow_discounts = get_post_meta($post->ID, '_allow_discounts', true);
	// Echo out the field
	echo '<b>Allow Discounts : </b><input type="radio" name="_allow_discounts" value="true" class="widefat" /> True ';
	echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="_allow_discounts" value="false" class="widefat" /> False <br/><br/>';
	
	// Get the subscription data if its already been entered
	$subscription = get_post_meta($post->ID, '_subscription', true);
	// Echo out the field
	echo '<b>Subscription :</b> <input type="radio" name="_subscription" value="true" class="widefat" /> True';
	echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="_subscription" value="false" class="widefat" /> False  <br/><br/>';
	
	// Get the booking_count data if its already been entered
	$booking_count = get_post_meta($post->ID, '_booking_count', true);
	// Echo out the field
	echo '<b>Booking Count :</b> <input type="text" name="_booking_count" value="' . $booking_count  . '" class="widefat" /><br/><br/>';
	
	// Get the created_by data if its already been entered
	/*$created_by = get_post_meta($post->ID, '_created_by', true);
	// Echo out the field
	echo '<b>Created By :</b> <input type="text" name="_created_by" value="' . $created_by  . '" class="widefat" /><br/><br/>';
	
	// Get the modified_by data if its already been entered
	$modified_by = get_post_meta($post->ID, '_modified_by', true);
	// Echo out the field
	echo '<b>Modified By :</b> <input type="text" name="_modified_by" value="' . $modified_by  . '" class="widefat" /><br/><br/>';*/

}

function wpt_save_course_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['coursemeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$course_meta['_teaser'] = $_POST['_teaser'];
	$course_meta['_tags'] = $_POST['_tags'];
	$course_meta['_is_featured'] = $_POST['_is_featured'];
	$course_meta['_course_fee'] = $_POST['_course_fee'];
	$course_meta['_sku'] = $_POST['_sku'];
	$course_meta['_tax_category'] = $_POST['_tax_category'];
	$course_meta['_allow_discounts'] = $_POST['_allow_discounts'];
	$course_meta['_subscription'] = $_POST['_subscription'];
	$course_meta['_booking_count'] = $_POST['_booking_count'];
	//$course_meta['_created_by'] = $_POST['_created_by'];
	//$course_meta['_modified_by'] = $_POST['_modified_by'];
	
	// Add values of $course_meta as custom fields
	
	foreach ($course_meta as $key => $value) { // Cycle through the $course_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

add_action('save_post', 'wpt_save_course_meta', 1, 2); // save the custom fields

add_action( 'init', 'create_course_category' );
function create_course_category() {
	$labels = array(
		'name'              => _x( 'Course Category', 'Course Category' ),
		'singular_name'     => _x( 'Course Category', 'Course Category' ),
		'search_items'      => __( 'Search Course Category' ),
		'all_items'         => __( 'All Course Category' ),
		'parent_item'       => __( 'Parent Course Category' ),
		'parent_item_colon' => __( 'Parent Course Category:' ),
		'edit_item'         => __( 'Edit Course Category' ),
		'update_item'       => __( 'Update Course Category' ),
		'add_new_item'      => __( 'Add New Course Category' ),
		'new_item_name'     => __( 'New Course Category Name' ),
		'menu_name'         => __( 'Course Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);
	register_taxonomy( 'genre', array( 'courses' ), $args );
}

add_action( 'init', 'create_meetings' );
function create_meetings() {
  register_post_type( 'meetings',
	array(
	  'labels' => array(
		'name' => __( 'Meetings' ),
		'singular_name' => __( 'Meeting' ),
		'menu_name'          => _x( 'Meetings', 'admin menu', 'Meeting' ),
		'name_admin_bar'     => _x( 'Meeting', 'add new on admin bar', 'Meeting' ),
		'add_new'            => _x( 'Add New Meeting', 'Meeting', 'Meeting' ),
		'add_new_item'       => __( 'Add New Meeting', 'Meeting' ),
		'new_item'           => __( 'New Meeting', 'Meeting' ),
		'edit_item'          => __( 'Edit Meeting', 'Meeting' ),
		'view_item'          => __( 'View Meeting', 'Meeting' ),
		'all_items'          => __( 'All Meeting', 'Meeting' ),
		'search_items'       => __( 'Search Meeting', 'Meeting' ),
		'parent_item_colon'  => __( 'Parent Meeting:', 'Meeting' ),
		'not_found'          => __( 'No Meeting found.', 'Meeting' ),
		'not_found_in_trash' => __( 'No Meeting found in Trash.', 'Meeting' )
	  ),
	  'public' => true,
	  'has_archive' => true,
	  'supports' => array( 'title', 'editor'),
	  'register_meta_box_cb' => 'add_meeting_metaboxes'
	)
  );
}

add_action( 'add_meta_boxes', 'add_meeting_metaboxes' );

// Add the Course Meta Boxes

function add_meeting_metaboxes() {
	add_meta_box('wpt_meeting_fields', 'Meetings Other details', 'wpt_meeting_fields', 'meetings', 'normal', 'high');
}

function wpt_meeting_fields() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="meetingmeta_noncename" id="meetingmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the date data if its already been entered
	$date = get_post_meta($post->ID, '_date', true);
	// Echo out the field
	echo '<b>Date :</b> <input type="text" name="_date" value="' . $date  . '" class="widefat" /><br/><br/>';
	
	// Get the start_time data if its already been entered
	$start_time = get_post_meta($post->ID, '_start_time', true);
	// Echo out the field
	echo '<b>Start Time : </b><input type="text" name="_start_time" value="' . $start_time  . '" class="widefat" /><br/><br/>';
	
	// Get the duration data if its already been entered
	$duration = get_post_meta($post->ID, '_duration', true);
	// Echo out the field
	echo '<b>Duration :</b> <input type="text" name="_duration" value="' . $duration  . '" class="widefat" /> <br/><br/>';
	
	// Get the status data if its already been entered
	$status = get_post_meta($post->ID, '_status', true);
	// Echo out the field
	echo '<b>Status :</b> <input type="text" name="_status" value="' . $status  . '" class="widefat" /><br/><br/>';
	
	// Get the instructor data if its already been entered
	$instructor = get_post_meta($post->ID, '_instructor', true);
	// Echo out the field
	echo '<b>Instructor :</b> <input type="text" name="_instructor" value="' . $instructor  . '" class="widefat" /><br/><br/>';
	
    // Get the instructor_desc data if its already been entered
	$instructor_desc = get_post_meta($post->ID, '_instructor_desc', true);
	// Echo out the field
	echo '<b>Instructor Description :</b><br/> <textarea  cols="53" name="_instructor_desc" class="widefat"> ' . $instructor_desc  . ' </textarea ><br/><br/>';

}

function wpt_save_meeting_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['meetingmeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$course_meta['_date'] = $_POST['_date'];
	$course_meta['_start_time'] = $_POST['_start_time'];
	$course_meta['_duration'] = $_POST['_duration'];
	$course_meta['_status'] = $_POST['_status'];
	$course_meta['_instructor'] = $_POST['_instructor'];
	$course_meta['_instructor_desc'] = $_POST['_instructor_desc'];

	
	// Add values of $course_meta as custom fields
	
	foreach ($course_meta as $key => $value) { // Cycle through the $course_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

add_action('save_post', 'wpt_save_meeting_meta', 1, 2); // save the custom fields

function wp_meetings_shortcode(){
	$args = array(
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'meetings',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$meetings_array = get_posts( $args ); 
	echo "<div class='meeting-loop'>";
	foreach($meetings_array as $meeting){
		echo '<ul class="meeting">
		<li class="title"> Meeting title</li>
		<li class="content"> Content </li>
		<li class="date">Date</li>
		<li class="start_time">Start_time</li>
		<li class="duration">Duration </li>
		<li class="status">Status</li>
		<li class="instructor">Instructor </li>
		<li class="instructor_desc">Instructor description </li>
				</ul>
		';	
	}
	echo "</div>";
}
add_shortcode('meetings', 'wp_meetings_shortcode');

function add_wmenu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null ) {
    global $menu, $admin_page_hooks, $_registered_pages, $_parent_pages;
 
    $menu_slug = plugin_basename( $menu_slug );
 
    $admin_page_hooks[$menu_slug] = sanitize_title( $menu_title );
 
    $hookname = get_plugin_page_hookname( $menu_slug, '' );
 
    if ( !empty( $function ) && !empty( $hookname ) && current_user_can( $capability ) )
        add_action( $hookname, $function );
 
    if ( empty($icon_url) ) {
        $icon_url = 'dashicons-admin-generic';
        $icon_class = 'menu-icon-generic ';
    } else {
        $icon_url = set_url_scheme( $icon_url );
        $icon_class = '';
    }
 
    $new_menu = array( $menu_title, $capability, $menu_slug, $page_title, 'menu-top ' . $icon_class . $hookname, $hookname, $icon_url );
 
    if ( null === $position ) {
        $menu[] = $new_menu;
    } elseif ( isset( $menu[ "$position" ] ) ) {
        $position = $position + substr( base_convert( md5( $menu_slug . $menu_title ), 16, 10 ) , -5 ) * 0.00001;
        $menu[ "$position" ] = $new_menu;
    } else {
        $menu[ $position ] = $new_menu;
    }
 
    $_registered_pages[$hookname] = true;
 
    // No parent as top level
    $_parent_pages[$menu_slug] = false;
 
    return $hookname;
}

new WP_Adept_LMS();

global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

$table_name = 'api_crendential';

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  email varchar(55) DEFAULT '' NOT NULL,
  password varchar(55) DEFAULT '' NOT NULL,
  access_token varchar(255) DEFAULT '' NOT NULL,
  addeddatetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  UNIQUE KEY id (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

?>