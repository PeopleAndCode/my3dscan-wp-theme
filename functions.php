<?php

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
		'supports' => array('title', 'editor', 'thumbnail')
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

	if ( !wp_verify_nonce( $_POST['pc_3dscan_email_noonce'], __FILE__ ) )
		return $post_id;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	$meta_value = get_post_meta( $post_id, 'pc_3dscan_email', true );
	$new_meta_value = stripslashes( $_POST['pc_3dscan_email'] );

	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, 'pc_3dscan_email', $new_meta_value, true );

	elseif ( $new_meta_value != $meta_value )
		update_post_meta( $post_id, 'pc_3dscan_email', $new_meta_value );

	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, 'pc_3dscan_email', $meta_value );
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

	if ( !wp_verify_nonce( $_POST['pc_3dscan_twitter_noonce'], __FILE__ ) )
		return $post_id;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	$meta_value = get_post_meta( $post_id, 'pc_3dscan_twitter', true );
	$new_meta_value = stripslashes( $_POST['pc_3dscan_twitter'] );

	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, 'pc_3dscan_twitter', $new_meta_value, true );

	elseif ( $new_meta_value != $meta_value )
		update_post_meta( $post_id, 'pc_3dscan_twitter', $new_meta_value );

	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, 'pc_3dscan_twitter', $meta_value );
}


?>