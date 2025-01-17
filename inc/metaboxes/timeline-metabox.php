<?php

/**
 * Metabox for the Timeline Events custom post type
 *
 * @package    	Ishop_Toolbox
 * @link        http://ishop.com
 * Author:      ishop
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function ishop_toolbox_timeline_events_metabox() {
    new Ishop_Toolbox_Timeline_Events();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'ishop_toolbox_timeline_events_metabox' );
    add_action( 'load-post-new.php', 'ishop_toolbox_timeline_events_metabox' );
}

class Ishop_Toolbox_Timeline_Events {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'color_picker' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_timeline_metabox'
			,__( 'Timeline info', 'ishop_toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'timeline-events'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['ishop_toolbox_timeline_events_nonce'] ) )
			return $post_id;

		$nonce = $_POST['ishop_toolbox_timeline_events_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ishop_toolbox_timeline_events' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'timeline-events' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$date 	= isset( $_POST['ishop_toolbox_event_date'] ) ? sanitize_text_field($_POST['ishop_toolbox_event_date']) : false;

		update_post_meta( $post_id, 'wpcf-event-date', $date );
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'ishop_toolbox_timeline_events', 'ishop_toolbox_timeline_events_nonce' );
		
		$date 	= get_post_meta( $post->ID, 'wpcf-event-date', true );
	?>

		<p><strong><label for="ishop_toolbox_event_date"><?php _e( 'Event icon', 'ishop_toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('Add the date when this timeline event happened.'); ?></em></p>
		<p><input type="text" class="widefat" id="ishop_toolbox_event_date" name="ishop_toolbox_event_date" value="<?php echo esc_html($date); ?>"></p>

	<?php
	}

	public function color_picker() {
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');		
	}

}
