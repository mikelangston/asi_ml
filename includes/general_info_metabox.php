<?php
///////////////////////////////////////////////////////////////////////////////
/* Add General Info Metabox */
//////////////////////////////////////////////////////////////////////////////

function asi_ml_add_custom_box(){
  add_meta_box('asi_ml_meta_box', 'Store Location Info', 'asi_ml_custom_box_html', 'stores', 'side');
}
add_action('add_meta_boxes', 'asi_ml_add_custom_box');
//create the html
function asi_ml_custom_box_html($post){
  $street_address = get_post_meta($post->ID, 'street_address', true);
  $city = get_post_meta($post->ID, 'city', true);
  $state = get_post_meta($post->ID, 'state', true);
  $postal_code = get_post_meta($post->ID, 'postal_code', true);
  $latitude = get_post_meta($post->ID, 'latitude', true);
  $longitude = get_post_meta($post->ID, 'longitude', true);

  ?>
    <div>
      <label>Street Address</label>
      <input name="street_address" type="text" value="<?php echo $street_address ?>" class="widefat" />
    </div>
    <div>
      <label>City</label>
      <input name="city" type="text" value="<?php echo $city ?>" class="widefat" />
    </div>
    <div>
      <label>State</label>
      <input name="state" type="text" value="<?php echo $state ?>" class="widefat" />
    </div>
    <div>
      <label>Zip/Postal Code</label>
      <input name="postal_code" type="text" value="<?php echo $postal_code ?>" class="widefat" />
    </div>
    <p>Latitude and longitude coordinates auto populated from address after post saved.</p>
    <div>
      <label>Latitude</label>
      <input name="latitude" type="text" value="<?php echo $latitude ?>" class="widefat" />
    </div>
    <div>
      <label>Longitude</label>
      <input name="longitude" type="text" value="<?php echo $longitude ?>" class="widefat" />
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
  $response = asi_ml_apicall($_POST['street_address'], $_POST['city'], $_POST['state']);
  $lat = $response->results[0]->geometry->location->lat;
  $lng = $response->results[0]->geometry->location->lng;
  if(array_key_exists("latitude", $_POST)){
    update_post_meta(
      $post_id,
      'latitude',
      $lat
    );
  }
  if(array_key_exists("longitude", $_POST)){
    update_post_meta(
      $post_id,
      'longitude',
      $lng
    );
  }
}
add_action('save_post', 'asi_ml_save_postmeta');

//Google Maps API Geocoding
function asi_ml_apicall($street, $city, $state, $api_key){
  $str = explode(" ", $street);
  $street_formatted = implode("+", $str);

  //google maps geocode api call
  $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$street_formatted.',+'.$city.',+'.$state.'&key='.$api_key;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $service_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);
  $decoded = json_decode($response);
  return $decoded;
}
?>
