<?

class del_widget extends WP_Widget {

   function __construct () {
      parent::__construct (
         'del_widget',
         'Events',
         array (
            'description' => 'Displays upcoming events.'
         )
      );
   }

   function widget ($args, $instance) {

      $title = apply_filters ('widget_title', $instance['title']);

      print $args['before_widget'];
      print $args['before_title'] . $title . $args['after_title'];

      print 'There are no upcoming events.';

      print $args['after_widget'];

   }

   function update ($new_instance, $old_instance) {

      return $new_instance;

   }

   function form ($instance) {

      $title = $instance['title'];

      print '<p>';
      print '<label for="' . $this->get_field_id ('title') . '">Title:</label>';
      print '<input id="' . $this->get_field_id ('title') . '" name="' . $this->get_field_name ('title') . '" type="text" value="' . esc_attr ($title) . '"/>';
      print '</p>';

   }

}
