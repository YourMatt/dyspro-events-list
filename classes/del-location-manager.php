<?

class del_location_manager {

   private $nonce_action = 'del_location';

   public function __construct () {

      // add save callbacks
      add_action ('save_post', array ($this, 'save_location_meta_form'));

   }

   // Administration forms
   function add_meta_boxes () {

      // add scripts and styles for the meta boxes
      wp_enqueue_script ('del_location_js', DEL_BASE_WEB_PATH . 'content/js/meta-location.js', array ('jquery'));
      wp_enqueue_script ('google_maps_js', 'https://maps.googleapis.com/maps/api/js?key=' . get_option ('del_google_maps_api_key'));
      wp_enqueue_style ('del_location_css', DEL_BASE_WEB_PATH . 'content/css/meta.css');

      // create the location meta box
      add_meta_box (
         'location',
         'Location',
         array ($this, 'build_location_meta_form'),
         DEL_POST_TYPE_NAME
      );

   }

   function build_location_meta_form ($post) {

      // create the nonce
      wp_nonce_field ($this->nonce_action, 'del_loc_nonce');

      // load current values
      $loc_data = get_metadata ('post', $post->ID);
      $forced_state = get_option ('del_forced_state_name');
      if ($forced_state) $loc_data['_dbd_state'][0] = $forced_state;

      // load default map options
      $map_type = get_option ('del_google_maps_type');
      $map_default_location = get_option ('del_default_location');
      $map_default_zoom = get_option ('del_google_maps_default_zoom');
      $map_addressed_zoom = get_option ('del_google_maps_addressed_zoom');

      // add the form contents
      include (DEL_BASE_PATH . '/content/meta-location.php');

   }

   function save_location_meta_form ($post_id) {

      // verify the nonce
      if (! wp_verify_nonce ($_POST['del_loc_nonce'], $this->nonce_action)) return $post_id;

      // save the location data to meta fields
      del_utilities::save_meta_field ($post_id, 'loc_name', '_del_name');
      del_utilities::save_meta_field ($post_id, 'loc_address1', '_del_address1');
      del_utilities::save_meta_field ($post_id, 'loc_address2', '_del_address2');
      del_utilities::save_meta_field ($post_id, 'loc_city', '_del_city');
      del_utilities::save_meta_field ($post_id, 'loc_state', '_del_state');
      del_utilities::save_meta_field ($post_id, 'loc_postalcode', '_del_postalcode');
      del_utilities::save_meta_field ($post_id, 'loc_lat', '_del_lat');
      del_utilities::save_meta_field ($post_id, 'loc_lng', '_del_lng');

      return $post_id;

   }

   function get_formatted_address ($post_id) {

      $loc_data = get_metadata ('post', $post_id);

      // set up the address lines
      $line1 = $loc_data['_del_name'][0];
      $line2 = $loc_data['_del_address1'][0];
      $line3 = $loc_data['_del_address2'][0];
      $line4 = $loc_data['_del_city'][0];
      if ($line4) $line4 .= ', ';
      $line4 .= $loc_data['_del_state'][0];
      if ($loc_data['_del_postalcode']) $line4 .= ' ' . $loc_data['_del_postalcode'][0];

      // build the address
      $address = [];
      if ($line1) $address[] = $line1;
      if ($line2) $address[] = $line2;
      if ($line3) $address[] = $line3;
      if ($line4) $address[] = $line4;

      return implode ('<br/>', $address);

   }

}
