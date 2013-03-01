<?php
add_filter( 'show_admin_bar', '__return_false' );

add_action( 'init', 'create_services_page', 0 );

function create_services_page() {
	$labels = 	array(
		'name' => __( 'Scans' ),
		'singular_name' => __( 'Scan' ),
		'add_new' => 'Add Scan',
		'add_new_item' => 'Add Scan',
		'edit_item' => __('Edit Scan'),
		'new_item' => 'Scan',
		'view_item' => 'View Scan',
		'search_items' => 'Search Scans',
		'not_found' => 'No Scans found',
		'not_found_in_trash' => 'No Scans found in Trash'
	);

	// The arguments array for creating the service custom post type
	$args = 	array( 
		'labels' => $labels, 
		'public' => true, 
		'publicly_queryable' => true, 
		'show_ui' => true, 
		'query_var' => true, 
		'rewrite' => array('slug' => 'scan', 'with_front' => false),
		'capability_type' => 'post', 
		'hierarchical' => true, 
		'menu_position' => 5,
		'taxonomies' => array('category'),
		'has_archive' => false,
		'supports' => array('title', 'thumbnail', 'editor')
	); 
	register_post_type('pc_3dscan', $args);
}


add_action( 'admin_menu', 'pc_add_3dscans_email' );
add_action( 'save_post', 'pc_3dscan_email_save', 10, 2 );

function pc_add_3dscans_email() {
	add_meta_box('pc_3dscan_email', 'Email Address', 'pc_3dscan_email_metabox', 'pc_3dscan', 'normal', 'high' );
}


function pc_3dscan_email_metabox() { 
	global $post;
	$value = get_post_meta( $post->ID, 'pc_3dscan_email', true );
	?>
	<p>
		<input type="text" name="pc_3dscan_email" id="pc_3dscan_email" cols="60" rows="4" tabindex="30" style="width: 97%;" value="<?php  if(!empty($value)) echo $value; ?>"/>
		<input type="hidden" name="pc_3dscan_email_noonce" value="<?php echo wp_create_nonce( __FILE__ ); ?>" />
	</p>
<?php }


function pc_3dscan_email_save( $post_id ) {

	if ( !wp_verify_nonce( $_POST['pc_3dscan_email_noonce'], __FILE__ ) ){
		return $post_id;
	}

	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$meta_value = get_post_meta( $post_id, 'pc_3dscan_email', true );
	$new_meta_value = stripslashes( $_POST['pc_3dscan_email'] );

	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, 'pc_3dscan_email', $new_meta_value, true );
	}	elseif ( $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, 'pc_3dscan_email', $new_meta_value );
	} elseif ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, 'pc_3dscan_email', $meta_value );
	}
}



add_action( 'admin_menu', 'pc_add_3dscans_twitter' );
add_action( 'save_post', 'pc_3dscan_twitter_save', 10, 2 );

function pc_add_3dscans_twitter() {
	add_meta_box('pc_3dscan_twitter', 'Twitter Handle', 'pc_3dscan_twitter_metabox', 'pc_3dscan', 'normal', 'high' );
}


function pc_3dscan_twitter_metabox() { 
	global $post;
	$value = get_post_meta( $post->ID, 'pc_3dscan_twitter', true );
	?>
	<p>
		<input type="text" name="pc_3dscan_twitter" id="pc_3dscan_twitter" cols="60" rows="4" tabindex="30" style="width: 97%;" value="<?php  if(!empty($value)) echo $value; ?>"/>
		<input type="hidden" name="pc_3dscan_twitter_noonce" value="<?php echo wp_create_nonce( __FILE__ ); ?>" />
	</p>
<?php }


function pc_3dscan_twitter_save( $post_id ) {

	if ( !wp_verify_nonce( $_POST['pc_3dscan_twitter_noonce'], __FILE__ ) ) {
		return $post_id;
	}

	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$meta_value = get_post_meta( $post_id, 'pc_3dscan_twitter', true );
	$new_meta_value = stripslashes( $_POST['pc_3dscan_twitter'] );

	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, 'pc_3dscan_twitter', $new_meta_value, true );
	} elseif ( $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, 'pc_3dscan_twitter', $new_meta_value );
	} elseif ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, 'pc_3dscan_twitter', $meta_value );
	}
}


function get_3d_file_search() {
	$twitter_handle = $_GET['cr_scan1'];
	if ( empty($twitter_handle) ){
		$pc_twitter = array(null);
	} else {
		$twitter_handle = sanitize_text_field(trim($twitter_handle));
		$twitter_handle = validate_twitterHandle($twitter_handle);
		$pc_twitter = array(
			'key' => 'pc_3dscan_twitter',
			'value' => $twitter_handle
		);
	}

	if ( empty($_GET['cr_scan2']) ){
		$pc_email = array(null);
	} else {
		$pc_email = array(
			'key' => 'pc_3dscan_email',
			'value' => $_GET['cr_scan2']
		);
	}

	if ( !empty($_GET['cr_scan1']) || !empty($_GET['cr_scan2']) ) {
		$args = array(
			'post_type' => 'pc_3dscan',
			'meta_query' => array(
				'relation' => 'AND',
				$pc_email,
				$pc_twitter
			), 
		"posts_per_page" => -1,
		"order" => "ASC",
		"order_by" => "ID"
		);

		$searched_posts = new WP_Query( $args );
		return $searched_posts;
	} else {
		return null;
	}
}

function pc_3d_scan_setup(){

	if ( function_exists('add_theme_support' ) ){
		add_theme_support('post-thumbnails');
	}

	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( '3d_thumb', 250, 250, true );
		add_image_size( 'featured_thumb', 1024, 498, true );
	}
}

add_action('init', 'pc_3d_scan_setup');

function my_attachment_gallery($postid=0, $size='thumbnail', $attributes='') {

	if ($postid<1) $postid = get_the_ID();

	$args = array(

		'post_parent' => $postid,

		'post_type' => 'attachment',

		'order' => 'ASC',

		'numberposts' => -1,

		'post_mime_type' => 'image');

		$images = get_children($args);

		if( empty($images)){
			return $thumnail = null;
		}

		$i = 0;
		foreach($images as $image){
			$thumbnail[$i] = wp_get_attachment_image_src($image->ID, $size);
			$i++;
		}
		
		return $thumbnail;
}

add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
	// add your extension to the array
	$existing_mimes['zip'] = 'application/zip';
	$existing_mimes['stl'] = 'application/stl';
	$existing_mimes['ply'] = 'application/ply';
	// add as many as you like
	// removing existing file types
	// unset( $existing_mimes['exe'] );
	// add as many as you like
	// and return the new full result
	return $existing_mimes;
}


function formatSizeUnits($bytes){
	if ($bytes >= 1073741824)
	{
	    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	}
	elseif ($bytes >= 1048576)
	{
	    $bytes = number_format($bytes / 1048576, 2) . ' MB';
	}
	elseif ($bytes >= 1024)
	{
	    $bytes = number_format($bytes / 1024, 2) . ' KB';
	}
	elseif ($bytes > 1)
	{
	    $bytes = $bytes . ' bytes';
	}
	elseif ($bytes == 1)
	{
	    $bytes = $bytes . ' byte';
	}
	else
	{
	    $bytes = '0 bytes';
	}

	return $bytes;
}

// Modifys the 'custom post type' list view 
add_filter('manage_edit-pc_3dscan_columns', 'add_pc_3dscan_columns');

function add_pc_3dscan_columns($scan_columns) {
	$new_columns['cb'] = '<input type="checkbox" />';
	$new_columns['id'] = _x('ID', 'column name');
	$new_columns['title'] = _x('Title', 'column name');
	$new_columns['pc_3dscan_twitter'] = _x('Twitter', 'column name');
	$new_columns['pc_3dscan_email'] = __('Email');
	return $new_columns;
}

add_filter( 'manage_pc_3dscan_posts_custom_column', 'manage_pc_3dscan_columns', 10, 2 );

function manage_pc_3dscan_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'price' column. */
		case 'id' :
			$meta = $post_id;
			if(empty($meta)) 
				echo __('Unknown');
			else
				echo __( $meta );
			break;

		case 'pc_3dscan_twitter' :

			/* Get the post meta. */
			$meta = get_post_meta( $post_id, $column, true );

			/* If no price is found, output a default message. */
			if ( empty( $meta ) )
				echo __( 'Unknown' );

			/* If there is a price, prepend 'minutes' to the text string. */
			else
				echo __( $meta );

			break;

		/* If displaying the 'genre' column. */
		case 'pc_3dscan_email' :

			/* Get the genres for the post. */
			$meta = get_post_meta( $post_id, $column, true );

			/* If no price is found, output a default message. */
			if ( empty( $meta ) )
				echo __( 'Unknown' );

			/* If there is a price, prepend 'minutes' to the text string. */
			else
				echo __( $meta );

			break;

		default :
			break;
	}
}


add_filter( 'manage_edit-pc_3dscan_sortable_columns', 'pc_3dscan_sortable_columns' );

function pc_3dscan_sortable_columns( $columns ) {
	$columns['id'] = 'ID';
	$columns['pc_3dscan_twitter'] = 'pc_3dscan_twitter';
	$columns['pc_3dscan_email'] = 'pc_3dscan_email';

	return $columns;
}


class pc_scan_emailer {
  function send($post_ID)  {
  	$email = get_post_meta($post_ID, 'pc_3dscan_email', true);
    $to = $email;
    
    $name = get_post_meta($post_ID, 'pc_3dscan_fname', true);

    $headers = 'From: My 3D Scan <info@my3dscan.ca>' . "\r\n" . 'Reply-To: info@my3dscan.ca';
    $subject = "$name, your 3D Scan is now ready!";
    $body = "Hey $name, \n\nYour 3D Scan is now ready to download.  Goto http://my3dscan.ca/download and enter your email address or twitter name (if you provided us one) to download your 3D Scan file.\n\n All the best,\n@My3DScan\n@DraftPrint3D\n@PeopleAndCode";
    wp_mail($to, $subject, $body, $headers);
    return $post_ID;
  }
}

$myEmailClass = new pc_scan_emailer();
add_action('publish_pc_3dscan', array($myEmailClass, 'send'));


	function validate_twitterHandle($handle) {
		if (preg_match('/^(@?)[A-Za-z0-9_]{1,15}$/', $handle)){
			if(substr($handle, 0, 1) == '@'){
				return substr($handle, 1);
			} else {
				return $handle;
			}
		} else {
			return false;
		}
	}


?>