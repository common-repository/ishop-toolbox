<?php

/**
 * Metabox for the Projects custom post type
 *
 * @package    	Ishop_Toolbox
 * @link        http://ishop.com
 * Author:      ishop
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function ishop_toolbox_projects_metabox() {
    new Ishop_Toolbox_Projects();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'ishop_toolbox_projects_metabox' );
    add_action( 'load-post-new.php', 'ishop_toolbox_projects_metabox' );
}

class Ishop_Toolbox_Projects {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_projects_metabox'
			,__( 'Project info', 'ishop_toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'projects'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['ishop_toolbox_projects_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ishop_toolbox_projects_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ishop_toolbox_projects' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'projects' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$link 	= isset( $_POST['ishop_toolbox_projects_info'] ) ? esc_url_raw($_POST['ishop_toolbox_projects_info']) : false;
		update_post_meta( $post_id, 'wpcf-project-link', $link );

	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'ishop_toolbox_projects', 'ishop_toolbox_projects_nonce' );

		$link = get_post_meta( $post->ID, 'wpcf-project-link', true );

	?>
		<p><strong><label for="ishop_toolbox_projects_info"><?php _e( 'Project link', 'ishop_toolbox' ); ?></label></strong></p>
		<p><em><?php _e('Add an URL here to make this project link to another page (internal or external). Leave it empty and it will default to its own page.', 'sdyney_toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_projects_info" name="ishop_toolbox_projects_info" value="<?php echo esc_url($link); ?>"></p>	

	<?php
	}
}
