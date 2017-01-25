<?php
///////////////////////////////////////////////////////////////////////////////
/* Add General Info Metabox */
//////////////////////////////////////////////////////////////////////////////

function asi_ml_add_custom_box(){
  add_meta_box('asi_ml_meta_box', 'Store Info', 'asi_ml_custom_box_html', 'stores', 'side');
}
add_action('add_meta_boxes', 'asi_ml_add_custom_box');
//create the html
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
//save the fields
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
?>
