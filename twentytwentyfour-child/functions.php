<?php

function my_child_theme_scripts() {
    wp_enqueue_style( 'my-child-style', get_stylesheet_uri() );

  
    wp_enqueue_script(
        'my-child-custom-js',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array(), 
        null,
        true 
    );
}


add_action( 'wp_enqueue_scripts', 'my_child_theme_scripts' );

class TwentyTwentyFour_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\" role=\"menu\">\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $has_children = in_array('menu-item-has-children', $classes) ? true : false;

        $aria_attrs = $has_children ? 'aria-haspopup="true" aria-expanded="false"' : '';

        $output .= $indent . '<li class="' . implode(' ', $classes) . '">';

        $attributes  = ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
        $attributes .= ' ' . $aria_attrs;

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

function twentytwentyfour_child_scripts() {
    wp_enqueue_script(
        'twentytwentyfour-child-navigation',
        get_stylesheet_directory_uri() . '/js/navigation.js',
        array(),
        null,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'twentytwentyfour_child_scripts' );


//Custom Post Type Extension
function create_projects_cpt() {

    $labels = array(
        'name' => _x('Projects', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Project', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Projects', 'textdomain'),
        'name_admin_bar' => __('Project', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'add_new_item' => __('Add New Project', 'textdomain'),
        'new_item' => __('New Project', 'textdomain'),
        'edit_item' => __('Edit Project', 'textdomain'),
        'view_item' => __('View Project', 'textdomain'),
        'all_items' => __('All Projects', 'textdomain'),
        'search_items' => __('Search Projects', 'textdomain'),
        'parent_item_colon' => __('Parent Projects:', 'textdomain'),
        'not_found' => __('No projects found.', 'textdomain'),
        'not_found_in_trash' => __('No projects found in Trash.', 'textdomain'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'projects'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-portfolio', // Dashicons icon
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true, // Enable for Gutenberg
    );

    register_post_type('project', $args);
}

add_action('init', 'create_projects_cpt');

function create_project_type_taxonomy() {

    $labels = array(
        'name'              => _x('Project Types', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Project Type', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Project Types', 'textdomain'),
        'all_items'         => __('All Project Types', 'textdomain'),
        'parent_item'       => __('Parent Project Type', 'textdomain'),
        'parent_item_colon' => __('Parent Project Type:', 'textdomain'),
        'edit_item'         => __('Edit Project Type', 'textdomain'),
        'update_item'       => __('Update Project Type', 'textdomain'),
        'add_new_item'      => __('Add New Project Type', 'textdomain'),
        'new_item_name'     => __('New Project Type Name', 'textdomain'),
        'menu_name'         => __('Project Types', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true, // true = behaves like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'project-type'),
        'show_in_rest'      => true, // enable for Gutenberg
    );

    register_taxonomy('project_type', array('project'), $args);
}
add_action('init', 'create_project_type_taxonomy');



// Add custom field to checkout
add_action( 'woocommerce_after_order_notes', 'ttf_add_custom_checkout_field' );

function ttf_add_custom_checkout_field( $checkout ) {

    woocommerce_form_field( 'how_hear_about_us', array(
        'type'        => 'text',
        'class'       => array('form-row-wide'),
        'label'       => __('How did you hear about us?'),
        'placeholder' => __('e.g. Google, Friend, Social Media'),
        'required'    => false,
    ), $checkout->get_value( 'how_hear_about_us' ) );

}
// Save custom field to order meta
add_action( 'woocommerce_checkout_update_order_meta', 'ttf_save_custom_checkout_field' );

function ttf_save_custom_checkout_field( $order_id ) {
    if ( ! empty( $_POST['how_hear_about_us'] ) ) {
        update_post_meta( $order_id, 'how_hear_about_us', sanitize_text_field( $_POST['how_hear_about_us'] ) );
    }
}
// Display field value in order admin
add_action( 'woocommerce_admin_order_data_after_billing_address', 'ttf_display_custom_checkout_field_in_admin', 10, 1 );

function ttf_display_custom_checkout_field_in_admin( $order ) {
    $how_hear = get_post_meta( $order->get_id(), 'how_hear_about_us', true );
    if ( $how_hear ) {
        echo '<p><strong>'.__('How did you hear about us?').':</strong> ' . esc_html( $how_hear ) . '</p>';
    }
}

//print all the existing crons
add_action( 'admin_notices', function() {
    if ( current_user_can( 'manage_options' ) ) {
        $cron = _get_cron_array();
        if ( ! empty( $cron ) ) {
            echo '<div class="notice notice-info"><h2>Scheduled Cron Events:</h2><ul>';
            foreach ( $cron as $timestamp => $events ) {
                foreach ( $events as $hook => $details ) {
                    echo '<li><strong>' . esc_html( $hook ) . '</strong> - ' . date( 'Y-m-d H:i:s', $timestamp ) . '</li>';
                }
            }
            echo '</ul></div>';
        } else {
            echo '<div class="notice notice-info"><p>No cron jobs scheduled.</p></div>';
        }
    }
});

//cron to check and set expired posts to draft
add_filter( 'cron_schedules', function( $schedules ) {
    $schedules['every_five_minutes'] = [
        'interval' => 300, // 5 minutes
        'display'  => __( 'Every 5 Minutes' ),
    ];
    return $schedules;
});

add_action( 'wp', function() {
    if ( ! wp_next_scheduled( 'set_expired_posts_to_draft' ) ) {
        wp_schedule_event( time(), 'hourly', 'set_expired_posts_to_draft' );
    }
});

add_action( 'set_expired_posts_to_draft', function() {
    $today = date( 'Y-m-d' );

    $expired_posts = new WP_Query([
        'post_type'      => 'post',
        'meta_query'     => [
            [
                'key'     => 'expiry_date',
                'value'   => $today,
                'compare' => '<=',
                'type'    => 'DATE'
            ],
        ],
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ]);

    if ( $expired_posts->have_posts() ) {
        foreach ( $expired_posts->posts as $post ) {
            wp_update_post([
                'ID'          => $post->ID,
                'post_status' => 'draft',
            ]);
        }
    }
});


//REST API endpoint to return the latest 5 posts

add_action( 'rest_api_init', function () {
    register_rest_route( 'custom/v1', '/latest-posts/', [
        'methods'  => 'GET',
        'callback' => 'custom_get_latest_posts',
        'permission_callback' => '__return_true', // public endpoint
    ]);
});

function custom_get_latest_posts( $request ) {

    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 5,
        'post_status'    => 'publish',
    ]);

    $posts_data = [];

    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post ) {
            
            // Get featured image URL (full size)
            $thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'full' );

            // Get categories
            $categories = wp_get_post_terms( $post->ID, 'category', [ 'fields' => 'names' ] );

            $posts_data[] = [
                'id'            => $post->ID,
                'title'         => get_the_title( $post->ID ),
                'excerpt'       => wp_strip_all_tags( get_the_excerpt( $post->ID ) ),
                'featured_image'=> $thumbnail_url ? $thumbnail_url : '',
                'categories'    => $categories,
                'permalink'     => get_permalink( $post->ID ),
            ];
        }
    }

    return rest_ensure_response( $posts_data );
}

//Disabling XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );
