<?

class del_utilities {

   public static function save_meta_field ($post_id, $field_name, $meta_name) {

      $current_value = get_post_meta ($post_id, $meta_name, true);
      $new_value = $_POST[$field_name];

      // change date to seconds for start date
      if ($field_name == 'date_start') $new_value = strtotime ($new_value);

      if ($current_value) {
         if (! $new_value) delete_post_meta ($post_id, $meta_name);
         else update_post_meta ($post_id, $meta_name, $new_value);
      }
      elseif ($new_value) {
         add_post_meta ($post_id, $meta_name, $new_value, true);
      }

   }

   public static function get_formatted_address ($post_meta) {

      $address = $post_meta['_del_name'][0] . '<br/>';
      $address .= $post_meta['_del_address1'][0];
      if ($post_meta['_del_address2']) $address .= '; ' . $post_meta['_del_address2'][0];
      $address .= '<br/>';

      $address .= $post_meta['_del_city'][0] . ', ' . $post_meta['_del_state'][0] . ' ' . $post_meta['_del_postalcode'][0];

      return $address;

   }

   public static function get_formatted_date ($post_meta) {

      $date = date ('l, M. jS, Y', $post_meta['_date_start'][0]);
      $time_start = date ('g:ia', $post_meta['_date_start_time'][0]);
      $time_end = date ('g:ia', $post_meta['_date_start_time'][0] + $post_meta['_date_duration'][0]);

      return $date . '<br/>' . $time_start . ' - ' . $time_end;

   }

}