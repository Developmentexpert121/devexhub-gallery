<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://devexhub.com/services/web-development/
 * @since      1.0.0
 *
 * @package    Devexhub_Gallery
 * @subpackage Devexhub_Gallery/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Devexhub_Gallery
 * @subpackage Devexhub_Gallery/includes
 * @author     Team Devexhub <info@devexhub.com>
 */
class Devexhub_Gallery_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $classis = new Devexhub_Gallery_Activator;
        $classis->DH_gallery_create_pages_for_frontend();
	}

    function DH_gallery_create_pages_for_frontend()
    {
        $pages = apply_filters(
            'devexhub-gallery',
            array(
                /** Array For Creating Register Page **/
                'register-customer'=> array(
                    'name'=> _x( 'my-gallery', 'Page slug', 'devexhub-gallery' ),
                    'title'=> _x( 'Gallery', 'Page title', 'devexhub-gallery' ),
                    'content' => '<!-- wp:shortcode -->[' . apply_filters( 'devexhub_gallery_page_shortcode_tag', 'devexhub_gallery_page' ) . ']<!-- /wp:shortcode -->',
                ),
            )
        );
        /** Call Pages Function In Loop For Creating Pages **/
        foreach ( $pages as $key => $page ) {
            Devexhub_Gallery_Activator::DH_gallery_create_pages( sanitize_text_field( $page['name'] ), 'dh-gallery-plugin' , $page['title'], $page['content'], ! empty( $page['parent'] ) ? get_page_ID( $page['parent'] ) : '' );
        }
        /** Loop Close **/
    }

    public function DH_gallery_create_pages( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ){
        global $wpdb;
        $page    = 'page';
        $trash   = 'trash';
        $closed  = 'closed';
        $publish = 'publish';
        $pending = 'pending';
        $future  = 'future';
        $auto_draft = 'auto-draft';
        $option_value = get_option( $option );

        if( $option_value > 0 ) {
            $page_object = get_post( $option_value );

            if( $page_object && 'page' === $page_object->post_type && ! in_array( $page_object->post_status, array( 'pending', 'trash', 'future', 'auto-draft' ), true ) ) {
                // Valid page is already in place.
                return $page_object->ID;
            }
        }

        if( strlen( $page_content ) > 0 ) {
            // Search for an existing page with the specified page content (typically a shortcode).
            $shortcode = str_replace( array( '<!-- devexhub_gallery_shortcodes -->', '<!-- /devexhub_gallery_shortcodes -->' ), '', $page_content );
            $valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type= $page AND post_status NOT IN ( $pending , $trash, $future, 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$shortcode}%" ) );
        }else{
            // Search for an existing page with the specified page slug.
            $valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type=$page AND post_status NOT IN ( $pending, $trash, $future, $auto_draft )AND post_name = %s LIMIT 1;", $slug ) );
        }

        $valid_page_found = apply_filters( 'dh_create_page_id', $valid_page_found, $slug, $page_content );

        if( $valid_page_found ) {
            if( $option ) {
                update_option( $option, $valid_page_found );
            }
            return $valid_page_found;
        }

        // Search for a matching valid trashed page.
        if( strlen( $page_content ) > 0 ) {
            // Search for an existing page with the specified page content (typically a shortcode).
            $trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type=$page AND post_status = $trash AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
        }else{
            // Search for an existing page with the specified page slug.
            $trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type=$page AND post_status = $trash AND post_name = %s LIMIT 1;", $slug ) );
        }

        if( $trashed_page_found ) {
            $page_id = $trashed_page_found;
            $page_data = array(
                'ID'=> $page_id,
                'post_status' => 'publish',
            );
            wp_update_post( $page_data );
        }else{
            $page_data = array(
                'post_status'=> $publish,
                'post_type'=> $page,
                'post_author'=> 1,
                'post_name'=> $slug,
                'post_title' => $page_title,
                // 'post_content' => $page_content,
                'post_parent'=> $post_parent,
                'comment_status' => $closed,
            );
            $page_id = wp_insert_post( $page_data );
            /** Return Page Id After Create Page **/
        }

        if( $option ) {
            update_option( $option, $page_id );
        }

        $template = plugin_dir_path( __FILE__ ).'gallery_page_template_first.php';
        update_post_meta($page_id, '_wp_page_template', $template);
        return $page_id;
    }
}