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
      $date_data = get_metadata ('post', $post->ID);
      if ($date_data['_date_start']) $date_data['_date_start'][0] = date ('m/d/Y', $date_data['_date_start'][0]);

      // set defaults if no date already set
      $date_data['_date_start'] || $date_data['_date_start'][0] = date ('m/d/Y');
      $date_data['_date_start_time'] || $date_data['_date_start_time'][0] = DEL_DATE_DEFAULT_START_TIME;
      $date_data['_date_duration'] || $date_data['_date_duration'][0] = DEL_DATE_DEFAULT_DURATION;

      // add the form contents
      include (DEL_BASE_PATH . '/content/meta-date.php');

   }

   function save_date_meta_form ($post_id) {

      // verify the nonce
      if (! wp_verify_nonce ($_POST['del_date_nonce'], $this->nonce_action)) return $post_id;

      // save the date data to meta fields
      del_utilities::save_meta_field ($post_id, 'date_start', '_date_start');
      del_utilities::save_meta_field ($post_id, 'date_start_time', '_date_start_time');
      del_utilities::save_meta_field ($post_id, 'date_duration', '_date_duration');

      return $post_id;

   }

   function get_formatted_date ($post_id) {

      $date = date ('M jS, Y \a\t g:ia', $this->get_event_time_since_epoch ($post_id));
      return $date;

   }

   function get_event_time_since_epoch ($post_id) {

      $date_data = get_metadata ('post', $post_id);

      $date = $date_data['_date_start'][0];
      $date += $date_data['_date_start_time'][0];

      return $date;

   }

}
