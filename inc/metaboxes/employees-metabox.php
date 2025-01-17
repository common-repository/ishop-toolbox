<?php

/**
 * Metabox for the Employees custom post type
 *
 * @package    	Ishop_Toolbox
 * @link        http://ishop.com
 * Author:      ishop
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function ishop_toolbox_employees_metabox() {
    new Ishop_Toolbox_Employees();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'ishop_toolbox_employees_metabox' );
    add_action( 'load-post-new.php', 'ishop_toolbox_employees_metabox' );
}

class Ishop_Toolbox_Employees {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_employees_metabox'
			,__( 'Employee info', 'ishop_toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'employees'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['ishop_toolbox_employees_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ishop_toolbox_employees_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ishop_toolbox_employees' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'employees' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		$position 	= isset( $_POST['ishop_toolbox_emp_position'] ) ? sanitize_text_field($_POST['ishop_toolbox_emp_position']) : false;
		$facebook 	= isset( $_POST['ishop_toolbox_emp_facebook'] ) ? esc_url_raw($_POST['ishop_toolbox_emp_facebook']) : false;
		$twitter 	= isset( $_POST['ishop_toolbox_emp_twitter'] ) ? esc_url_raw($_POST['ishop_toolbox_emp_twitter']) : false;
		$linkedin 	= isset( $_POST['ishop_toolbox_emp_linkedin'] ) ? esc_url_raw($_POST['ishop_toolbox_emp_linkedin']) : false;
		$link 	= isset( $_POST['ishop_toolbox_emp_link'] ) ? esc_url_raw($_POST['ishop_toolbox_emp_link']) : false;
		
		update_post_meta( $post_id, 'wpcf-position', $position );
		update_post_meta( $post_id, 'wpcf-facebook', $facebook );
		update_post_meta( $post_id, 'wpcf-twitter', $twitter );
		update_post_meta( $post_id, 'wpcf-linkedin', $linkedin );
		update_post_meta( $post_id, 'wpcf-custom-link', $link );
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'ishop_toolbox_employees', 'ishop_toolbox_employees_nonce' );

		$position = get_post_meta( $post->ID, 'wpcf-position', true );
		$facebook = get_post_meta( $post->ID, 'wpcf-facebook', true );
		$twitter  = get_post_meta( $post->ID, 'wpcf-twitter', true );
		$linkedin   = get_post_meta( $post->ID, 'wpcf-linkedin', true );
		$link     = get_post_meta( $post->ID, 'wpcf-custom-link', true );

	?>
		<p><strong><label for="ishop_toolbox_emp_position"><?php _e( 'Employee position', 'ishop_toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_emp_position" name="ishop_toolbox_emp_position" value="<?php echo esc_html($position); ?>"></p>	
		<p><strong><label for="ishop_toolbox_emp_facebook"><?php _e( 'Employee Facebook', 'ishop_toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_emp_facebook" name="ishop_toolbox_emp_facebook" value="<?php echo esc_url($facebook); ?>"></p>				
		<p><strong><label for="ishop_toolbox_emp_twitter"><?php _e( 'Employee Twitter', 'ishop_toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_emp_twitter" name="ishop_toolbox_emp_twitter" value="<?php echo esc_url($twitter); ?>"></p>
		<p><strong><label for="ishop_toolbox_emp_linkedin"><?php _e( 'Employee Linkedin', 'ishop_toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_emp_linkedin" name="ishop_toolbox_emp_linkedin" value="<?php echo esc_url($linkedin); ?>"></p>
		<p><strong><label for="ishop_toolbox_emp_link"><?php _e( 'Employee Link', 'ishop_toolbox' ); ?></label></strong></p>
		<p><em><?php _e('Add a link here if you want the employee name to link somewhere.', 'sdyney_toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_emp_link" name="ishop_toolbox_emp_link" value="<?php echo esc_url($link); ?>"></p>

	<?php
	}
}
