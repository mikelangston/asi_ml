<?php
/*
Plugin Name: Autoshop Multi-Location
Description: A plugin to easily manage multiple business locations.
Version: 1.0.0
Author: Mike Langston
Author URI: http://autoshopsolutions.com
License: GPL2
*/

///////////////////////////////////////////////////////////////////////////////
/* Activation & Deactivation Hooks */
//////////////////////////////////////////////////////////////////////////////

//plugin installation
function asi_ml_install(){
  //call the setup function
  asi_ml_setup_post_type();
  //flush permalinks
  flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'asi_ml_install');

function asi_ml_deactivate(){
  //flush permalinks
  flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'asi_ml_deactivate');

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

///////////////////////////////////////////////////////////////////////////////
/* Add Metaboxes */
//////////////////////////////////////////////////////////////////////////////

function asi_ml_add_custom_box(){
  add_meta_box('asi_ml_meta_box', 'Store Info', 'asi_ml_custom_box_html', 'stores', 'side');
}
add_action('add_meta_boxes', 'asi_ml_add_custom_box');

function asi_ml_custom_box_html($post){
  $street_address = get_post_meta($post->ID, 'street_address', true);
  $city = get_post_meta($post->ID, 'city', true);
  $state = get_post_meta($post->ID, 'state', true);
  $postal_code = get_post_meta($post->ID, 'postal_code', true);
  ?>
    <div>
      <label>Street Address</label>
      <input name="street_address" type="text" value="<?php echo $street_address ?>" class="postbox" />
    </div>
    <div>
      <label>City</label>
      <input name="city" type="text" value="<?php echo $city ?>" class="postbox" />
    </div>
    <div>
      <label>State</label>
      <input name="state" type="text" value="<?php echo $state ?>" class="postbox" />
    </div>
    <div>
      <label>Zip/Postal Code</label>
      <input name="postal_code" type="text" value="<?php echo $postal_code ?>" class="postbox" />
    </div>
  <?php
}

function asi_ml_save_postmeta($post_id){
  $fields = ["street_address", "city", "state", "postal_code"];
  foreach($fields as $field){
    if(array_key_exists($field, $_POST)){
      update_post_meta(
        $post_id,
        $field,
        $_POST[$field]
      );
    }
  }
}
add_action('save_post', 'asi_ml_save_postmeta');

///////////////////////////////////////////////////////////////////////////////
/* All things fall off the edge of the world after this. */
//////////////////////////////////////////////////////////////////////////////

 ?>
