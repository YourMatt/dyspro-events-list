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

      // load the next upcoming event
      $event = del_utilities::get_events (false, true, 'medium');

      // write the widget contents
      $title = apply_filters ('widget_title', $instance['title']);
      print $args['before_widget'];
      print $args['before_title'] . $title . $args['after_title'];

      if ($event) $this->build_next_upcoming_event ($event);
      else $this->build_no_upcoming_message ($instance);

      print $args['after_widget'];

   }

   function build_no_upcoming_message ($instance) {

      $no_upcoming_custom_message = $instance['no_upcoming_custom_message'];

      print '<div class="eventwidget-empty">';
      print '<h3>There are currently no upcoming events.</h3>';
      if ($no_upcoming_custom_message) {
         print '<p>' . $instance['no_upcoming_custom_message'] . '</p>';
      }
      print '<a href="/events?past">View Past Events</a>';
      print '</div>';

   }

   function build_next_upcoming_event (&$event) {

      $date = date ('l, F jS', $event->meta['_date_start'][0]);

      print '<div class="eventwidget">';
      if ($event->thumb) {
         print $event->thumb;
      }
      print '<h3>' . $event->post_excerpt . '</h3>';
      print '<p>At ' . $event->meta['_del_name'][0] . ' in ' . $event->meta['_del_city'][0]  . ' on ' . $date . '.</p>';
      print '<a href="' . $event->link . '">Event Details</a>';
      print '</div>';

   }

   function update ($new_instance, $old_instance) {

      return $new_instance;

   }

   function form ($instance) {

      $title = $instance['title'];
      $no_upcoming_custom_message = $instance['no_upcoming_custom_message'];

      print '<p>';
      print '<label for="' . $this->get_field_id ('title') . '">Title:</label>';
      print '<input id="' . $this->get_field_id ('title') . '" name="' . $this->get_field_name ('title') . '" type="text" value="' . esc_attr ($title) . '"/>';
      print '</p>';

      print '<p>';
      print '<label for="' . $this->get_field_id ('no_upcoming_custom_message') . '">No Upcoming Events Custom Message:</label>';
      print '<textarea id="' . $this->get_field_id ('no_upcoming_custom_message') . '" name="' . $this->get_field_name ('no_upcoming_custom_message') . '">' . $no_upcoming_custom_message . '</textarea>';
      print '</p>';

   }

}
