<?php

/**
 * Metabox for the Testimonials custom post type
 *
 * @package    	Ishop_Toolbox
 * @link        http://ishop.com
 * Author:      ishop
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function ishop_toolbox_testimonials_metabox() {
    new Ishop_Toolbox_Testimonials();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'ishop_toolbox_testimonials_metabox' );
    add_action( 'load-post-new.php', 'ishop_toolbox_testimonials_metabox' );
}

class Ishop_Toolbox_Testimonials {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_testimonials_metabox'
			,__( 'Client info', 'ishop_toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'testimonials'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['ishop_toolbox_testimonials_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ishop_toolbox_testimonials_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ishop_toolbox_testimonials' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'testimonials' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		$position 	= isset( $_POST['ishop_toolbox_client_info'] ) ? sanitize_text_field($_POST['ishop_toolbox_client_info']) : false;

		update_post_meta( $post_id, 'wpcf-client-function', $position );

	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'ishop_toolbox_testimonials', 'ishop_toolbox_testimonials_nonce' );

		$position = get_post_meta( $post->ID, 'wpcf-client-function', true );

	?>
		<p><strong><label for="ishop_toolbox_client_info"><?php _e( 'Client function/Company name', 'ishop_toolbox' ); ?></label></strong></p>
		<p><em><?php _e('Enter your client\'s function/company name', 'sdyney_toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_client_info" name="ishop_toolbox_client_info" value="<?php echo esc_html($position); ?>"></p>	

	<?php
	}
}
