<?

class del_shortcode_manager {

   public function build_event_list () {

      $show_past_events = isset ($_REQUEST['past']);
      $event_list = '';
      $events = del_utilities::get_events ($show_past_events);

      // show message for no events if none found
      if (!$events && !$show_past_events) {
         return $this->build_no_upcoming_message ();
      }

      // display all upcoming events
      $last_month_title = ''; // used as control break to show month headings // TODO: Make this configurable for those that don't want it
      foreach ($events as $event) {

         $date = date ('l, M. jS', $event->meta['_date_start'][0]);
         $time_start = date ('g:ia', $event->meta['_date_start_time'][0]);
         $time_end = date ('g:ia', $event->meta['_date_start_time'][0] + $event->meta['_date_duration'][0]);

         // add the month title if changed
         $month_title = date ('F Y', $event->meta['_date_start'][0]);
         if ($month_title != $last_month_title) {
            if ($event_list) $event_list .= '</ul>';
            $event_list .= '<h2>' . $month_title . '</h2>';
            $event_list .= '<ul class="events">';
         }

         // add the event
         $event_list .= '<li>';
         if ($event->thumb) {
            $event_list .= '<div class="event-photo"><a href="' . $event->link . '">' . $event->thumb . '</a></div>';
         }
         $event_list .= '<h3 class="title">' . $event->post_title . '</h3>';
         $event_list .= '<div class="date">' . $date . ' ' . $time_start . ' - ' . $time_end . '</div>';
         $event_list .= '<div class="location">' . $event->meta['_del_name'][0] . ', ' . $event->meta['_del_city'][0] . '</div>';
         $event_list .= '<div class="description">' . $event->post_excerpt . '</div>';
         $event_list .= '<a class="details-link" href="' . $event->link . '"><span>Details</span></a>';
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