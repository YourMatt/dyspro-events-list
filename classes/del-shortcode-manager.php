<?

class del_shortcode_manager {

   public function build_event_list () {

      $event_list = '';

      // load all events
      $events = get_posts (array (
         'post_type' => DEL_POST_TYPE_NAME,
         'posts_per_page' => -1,
         'meta_key' => '_date_start',
         'meta_compare' => '>',
         'meta_value' => time (), // skip events that have passed
         'orderby' => 'meta_value_num',
         'order' => 'ASC'
      ));

      // show message for no events if none found
      if (!$events) {
         return $this->build_no_upcoming_message ();
      }

      // display all upcoming events
      $last_month_title = ''; // used as control break to show month headings // TODO: Make this configurable for those that don't want it
      foreach ($events as $event) {

         $event_meta = get_post_meta ($event->ID);
         $event_thumb = get_the_post_thumbnail ($event->ID, 'large');
         $link = '/events/' . $event->post_name;
         $date = date ('l, M. jS', $event_meta['_date_start'][0]);
         $time_start = date ('g:ia', $event_meta['_date_start_time'][0]);
         $time_end = date ('g:ia', $event_meta['_date_start_time'][0] + $event_meta['_date_duration'][0]);

         // add the month title if changed
         $month_title = date ('F Y', $event_meta['_date_start'][0]);
         if ($month_title != $last_month_title) {
            if ($event_list) $event_list .= '</ul>';
            $event_list .= '<h2>' . $month_title . '</h2>';
            $event_list .= '<ul class="events">';
         }

         // add the event
         $event_list .= '<li><!-- compared ' . time() . ' to ' . $event_meta['_date_start'][0] . ' -->';
         if ($event_thumb) {
            $event_list .= '<div class="event-photo"><a href="' . $link . '">' . $event_thumb . '</a></div>';
         }
         $event_list .= '<h3 class="title">' . $event->post_title . '</h3>';
         $event_list .= '<div class="date">' . $date . ' ' . $time_start . ' - ' . $time_end . '</div>';
         $event_list .= '<div class="location">' . $event_meta['_del_name'][0] . ', ' . $event_meta['_del_city'][0] . '</div>';
         $event_list .= '<div class="description">' . $event->post_excerpt . '</div>';
         $event_list .= '<a class="details-link" href="' . $link . '"><span>Details</span></a>';
         $event_list .= '</li>';

         // set the previous month title
         $last_month_title = $month_title;

      }
      $event_list .= '</ul>';

      return $event_list;

   }

   private function build_no_upcoming_message () {

      $message = '<ul class="events">';
      $message .= '<li class="no-events"><p>There are no upcoming events.</p></li>';
      $message .= '</ul>';

      return $message;

   }

}