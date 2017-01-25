<?php
///////////////////////////////////////////////////////////////////////////////
/* Register Post Type */
//////////////////////////////////////////////////////////////////////////////

function asi_ml_setup_post_type(){
  $labels = array(
    'name' => __('Stores', 'textdomain'),
    'singular_name' => __('Store', 'textdomain'),
    'menu_name' => __('Stores', 'textdomain'),
    'name_admin_bar' => __('Store', 'textdomain'),
    'add_new' => __('Add New', 'textdomain'),
    'add_new_item' => __('Add New Store', 'textdomain'),
    'new_item' => __('New Store', 'textdomain'),
    'edit_item' => __('Edit Store', 'textdomain'),
    'view_item' => __('View Store', 'textdomain'),
    'all_items' => __('All Stores', 'textdomain'),
    'search_items' => __('Search Stores', 'textdomain'),
    'not_found' => __('No Stores Found', 'textdomain'),
    'not_found_in_trash' => __('No Stores Found in Trash', 'textdomain'),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'store'),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
  );
  register_post_type('stores', $args);
}
//add the post type
add_action('init', 'asi_ml_setup_post_type');
?>
