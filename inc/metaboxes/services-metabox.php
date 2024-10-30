<?php

/**
 * Metabox for the Services custom post type
 *
 * @package    	Ishop_Toolbox
 * @link        http://ishop.com
 * Author:      ishop
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function ishop_toolbox_services_metabox() {
    new Ishop_Toolbox_Services();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'ishop_toolbox_services_metabox' );
    add_action( 'load-post-new.php', 'ishop_toolbox_services_metabox' );
}

class Ishop_Toolbox_Services {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_services_metabox'
			,__( 'Service info', 'ishop_toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'services'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['ishop_toolbox_services_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ishop_toolbox_services_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ishop_toolbox_services' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'services' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$icon = isset( $_POST['ishop_toolbox_service_icon'] ) ? sanitize_text_field($_POST['ishop_toolbox_service_icon']) : false;
		$link = isset( $_POST['ishop_toolbox_service_link'] ) ? esc_url_raw($_POST['ishop_toolbox_service_link']) : false;

		update_post_meta( $post_id, 'wpcf-service-icon', $icon );
		update_post_meta( $post_id, 'wpcf-service-link', $link );		
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'ishop_toolbox_services', 'ishop_toolbox_services_nonce' );
		$icon = get_post_meta( $post->ID, 'wpcf-service-icon', true ); //Types generated fields compatibility
		$link = get_post_meta( $post->ID, 'wpcf-service-link', true );		
	?>
		<p><strong><label for="ishop_toolbox_service_icon"><?php _e( 'Service icon', 'ishop_toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('Example: <strong>icon-mobile</strong>. Full list of icons is <a href="//ishop.com/documentation/et-icons/" target="_blank">here</a>'); ?></em></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_service_icon" name="ishop_toolbox_service_icon" value="<?php echo esc_html($icon); ?>"></p>
		<p><strong><label for="ishop_toolbox_service_link"><?php _e( 'Service link', 'ishop_toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('You can link your service to a page of your choice by entering the URL in this field'); ?></em></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_service_link" name="ishop_toolbox_service_link" value="<?php echo esc_url($link); ?>"></p>		
	<?php
	}
}
