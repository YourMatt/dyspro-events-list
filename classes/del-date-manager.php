<?

class del_date_manager {

   private $nonce_action = 'del_date';

   public function __construct () {

      // add save callbacks
      add_action ('save_post', array ($this, 'save_date_meta_form'));

   }

   // Administration forms
   function add_meta_boxes () {

      // add scripts and styles for the meta boxes
      wp_enqueue_script ('jquery-ui-datepicker');
      wp_enqueue_script ('del_date_js', DEL_BASE_WEB_PATH . 'content/js/meta-date.js', array ('jquery'));
      wp_enqueue_style ('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

      // create the date meta box
      add_meta_box (
         'date',
         'Date',
         array ($this, 'build_date_meta_form'),
         DEL_POST_TYPE_NAME
      );

   }

   function build_date_meta_form ($post) {

      // create the nonce
      wp_nonce_field ($this->nonce_action, 'del_date_nonce');

      // load current values
      // TODO: Add functionality

      // set defaults if no date already set
      $date_start = date ('m/d/Y');
      $date_start_time = DEL_DATE_DEFAULT_START_TIME;
      $date_duration = DEL_DATE_DEFAULT_DURATION;

      // add the form contents
      include (DEL_BASE_PATH . '/content/meta-date.php');

   }

   function save_date_meta_form ($post_id) {

      // verify the nonce
      if (! wp_verify_nonce ($_POST['del_date_nonce'], $this->nonce_action)) return $post_id;

      // save the date data to meta fields
      // TODO: Add functionality
      // del_utilities::save_meta_field ($post_id, 'loc_address1', '_del_address1');

      return $post_id;

   }

   function get_formatted_date ($post_id) {

      $date_data = get_metadata ('post', $post_id);

      /*
      // set up the address lines
      $line1 = $loc_data['_del_address1'][0];
      $line2 = $loc_data['_del_address2'][0];
      $line3 = $loc_data['_del_city'][0];
      if ($line3) $line3 .= ', ';
      $line3 .= $loc_data['_del_state'][0];
      if ($loc_data['_del_postalcode']) $line3 .= ' ' . $loc_data['_del_postalcode'][0];

      // build the address
      $address = [];
      if ($line1) $address[] = $line1;
      if ($line2) $address[] = $line2;
      if ($line3) $address[] = $line3;

      return implode ('<br/>', $address);
      */

      return '';

   }

}
