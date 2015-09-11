<?

class del_plugin_manager {

   // holds objects for querying post meta data
   private $location_manager;
   private $date_manager;

   // initialize query objects
   public function __construct () {

      $this->location_manager = new del_location_manager ();
      $this->date_manager = new del_date_manager ();

   }

   // run when activating the plugin
   function activate () {

      // flush the rewrite rules
      flush_rewrite_rules ();

   }

   // add the event post type - this is loaded on init
   function register_event_post_type () {

      register_post_type (
         DEL_POST_TYPE_NAME,
         array(
            'labels' => array (
               'name' => 'Events',
               'singular_name' => 'Event',
               'add_new' => 'Add New',
               'add_new_item' => 'Add New Event',
               'edit_item' => 'Edit Event'
            ),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array (
               'slug'=> 'events',
               'with_front'=> false,
               'feeds'=> true,
               'pages'=> true
            ),
            'has_archive' => false,
            'hierarchical' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'menu_position' => 20,
            'supports' => array (
               'thumbnail',
               'title',
               'editor'
            )
         )
      );

      // add columns to the edit form for this new post type
      add_filter (
         'manage_edit-' . DEL_POST_TYPE_NAME . '_columns',
         array ($this, 'set_custom_post_columns')
      );
      add_filter (
         'manage_edit-' . DEL_POST_TYPE_NAME . '_sortable_columns',
         array ($this, 'set_sortable_post_columns')
      );
      add_filter (
         'request',
         array ($this, 'sort_column')
      );
      add_action (
         'manage_' . DEL_POST_TYPE_NAME . '_posts_custom_column',
         array ($this, 'custom_post_column'),
         10,
         2
      );

   }

   function set_custom_post_columns ($columns) {

      $new_columns = array ();
      $new_columns['cb'] = $columns['cb'];
      $new_columns['title'] = $columns['title'];
      $new_columns['event_date'] = 'Event Date';
      $new_columns['address'] = 'Address';
      $new_columns['date'] = $columns['date'];

      return $new_columns;

   }

   function set_sortable_post_columns ($columns) {

      return array (
         'title' => 'title',
         'event_date' => 'del_date',
         'address' => 'del_address',
         'date' => 'date'
      );

   }

   function sort_column ($request) {

      if (! $request['orderby']) return $request;

      switch ($request['orderby']) {
         case 'del_date':
            $request = array_merge ($request, array (
               'meta_key' => '_date_start',
               'orderby' => 'meta_value_num'
            ));
            break;
         case 'del_address':
            $request = array_merge ($request, array (
               'meta_key' => '_del_address1',
               'orderby' => 'meta_value'
            ));
            break;
      }

      return $request;

   }

   function custom_post_column ($column, $post_id) {

      switch ($column) {
         case 'address':
            print $this->location_manager->get_formatted_address ($post_id);
            break;
         case 'event_date':
            print $this->date_manager->get_formatted_date ($post_id);
            break;
      }

   }

}