<?php
/** DH Gallery Start Function For Add Styles And Scripts In Frontend Pages**/
function DH_gallery_add_style_in_frontend() {
    $page_id = get_option('dh-gallery-plugin');
    if (is_page()) {
        $meta = get_post_meta(get_the_ID());
        if ($page_id == get_the_ID()) {
   wp_enqueue_script( 'jquery' ); /** Add default js into frontend pages **/
    wp_enqueue_style( 'dh-fronttend-bootstrap-style', plugins_url('devexhub-gallery') . '/public/css/bootstrap.min.css?time='.time() );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'DH_gallery_add_style_in_frontend' );
/** DH Gallery Close Function For Add Styles And Scripts In Frontend Pages**/

/*
* Creating a function to create our Custom post type for gallery
*/
function DH_gallery_custom_post_type() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Gallery', 'Post Type General Name', 'twentytwentyone' ),
        'singular_name'       => _x( 'Gallery', 'Post Type Singular Name', 'twentytwentyone' ),
        'menu_name'           => __( 'Gallery', 'twentytwentyone' ),
        'parent_item_colon'   => __( 'Parent Gallery', 'twentytwentyone' ),
        'all_items'           => __( 'All Galleries', 'twentytwentyone' ),
        'view_item'           => __( 'View Image', 'twentytwentyone' ),
        'add_new_item'        => __( 'Add New Image', 'twentytwentyone' ),
        'add_new'             => __( 'Add New', 'twentytwentyone' ),
        'edit_item'           => __( 'Edit Image', 'twentytwentyone' ),
        'update_item'         => __( 'Update Image', 'twentytwentyone' ),
        'search_items'        => __( 'Search Image', 'twentytwentyone' ),
        'not_found'           => __( 'Not Found', 'twentytwentyone' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentyone' ),
    );
    // Set other options for Custom Post Type
    $args = array(
        'category_name' => 'Page-Category',
        'label'               => __( 'Gallery', 'twentytwentyone' ),
        'description'         => __( 'Gallery news and reviews', 'twentytwentyone' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'thumbnail' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
  
    );
      
    register_taxonomy( 'dh_category', array('dh_gallery'), array(
        'hierarchical' => true, 
        'label' => 'Gallery Categories', 
        'singular_label' => 'Gallery Category', 
        'rewrite' => array( 'slug' => 'dh_categories', 'with_front'=> false )
        )
    );
    // Registering your Custom Post Type
    register_post_type( 'dh_gallery', $args );  
    add_action('admin_menu', 'add_gallery_submenu_page');

    function add_gallery_submenu_page() {
        add_submenu_page(
            'edit.php?post_type=dh_gallery',
            'Gallery Options',
            'Options',
            'manage_options',
            'gallery-options',
            'gallery_submenu_page_callback'
        );
    }

    function gallery_submenu_page_callback() {
        // Retrieve the currently saved layout value from the database
        $selected_layout = get_option('gallery_selected_layout', 'layout1');

        if (isset($_POST['gallery_layout'])) {
            // If the form is submitted, update the selected layout in the database
            $selected_layout = sanitize_text_field($_POST['gallery_layout']);
            update_option('gallery_selected_layout', $selected_layout);
        }

        // Get the path to the plugin directory
        $plugin_dir = plugin_dir_path(__FILE__);

        // Include the HTML file
        include($plugin_dir . 'gallery-options-form.php');
    }

    function gallery_layout_option($value, $label, $image, $selected_layout) {
        $image_url = plugins_url('devexhub-gallery/' . $image);
        $selected_class = checked($selected_layout, $value, false) ? 'selected' : '';
        ?>
        <div class="">
            <label class="devexhub-label <?php echo esc_attr($selected_class); ?>" style="width: 33%;">
                <input type="radio" name="gallery_layout" value="<?php echo esc_attr($value); ?>" style="display: none;">
                <div class="image-container mb-3 rounded border p-1 shadow">
                    <img class="layout-img" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($label); ?>">
                    <div class="overlay">
                       <img width="60" height="60" src="https://img.icons8.com/ios-glyphs/60/20C94B/checkmark--v1.png" alt="checkmark--v1"/>
                    </div>
                </div>
            </label>
        </div>
        <?php
    }

}
  
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
add_action( 'init', 'DH_gallery_custom_post_type', 0 );



add_filter( 'theme_page_templates', 'DH_gallery_add_page_template_to_dropdown' );
/**
 * Add page templates.
 *
 * @param  array  $templates  The list of page templates
 *
 * @return array  $templates  The modified list of page templates
 */
function DH_gallery_add_page_template_to_dropdown($template)
{
    $template[untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/gallery_page_template.php'] = __('DH Gallery Page Template', 'text-domain');
    return $template;
}

add_filter( 'template_include', 'DH_gallery_change_page_template', 99 );
/**
 * Change the page template to the selected template on the dropdown
 * 
 * @param $template
 *
 * @return mixed
 */
function DH_gallery_change_page_template($template)
{
    $page_id = get_option('dh-gallery-plugin');
    $selected_layout = get_option('gallery_selected_layout');
    if (is_page()) {
        $meta = get_post_meta(get_the_ID());
        if ($page_id == get_the_ID()) {
            if(!empty($meta['_wp_page_template'][0])){
                if($selected_layout == '' || $selected_layout == 'layout1'){
                    $template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/gallery_page_template_first.php';    
                }elseif($selected_layout == '' || $selected_layout == 'layout2'){
                    $template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/gallery_page_template_second.php';    
                }elseif($selected_layout == '' || $selected_layout == 'layout3'){
                    $template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/gallery_page_template_third.php';    
                }
            }
            
        }
    }
    return $template;
}

function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

// AJAX handler
function send_email_ajax_handler() {
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_text_field($_POST['message']);    
    
    // Example: 
    wp_mail('info@devexhub.com', 'Subject', $message);

    // Send a response
    wp_send_json_success('Email sent successfully!');
}
add_action('wp_ajax_send_email_ajax', 'send_email_ajax_handler');
add_action('wp_ajax_nopriv_send_email_ajax', 'send_email_ajax_handler');

function enqueue_admin_styles() {
    wp_enqueue_style( 'dh-admin-bootstrap-style', plugins_url( 'devexhub-gallery' ) . '/public/css/bootstrap.min.css?time=' . time() );
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_styles' );
function enqueue_admin_gallery_script() {
    wp_enqueue_script('admin-gallery-script', plugins_url( 'devexhub-gallery' ) . '/public/js/admin.js?time=' . time() );
}

add_action('admin_enqueue_scripts', 'enqueue_admin_gallery_script');
