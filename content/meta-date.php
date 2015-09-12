<div class="del-meta-date">

   <table class="full-selection">
      <tr>
         <td rowspan="2">
            <div id="date-event"></div>
            <input type="hidden" name="date_start" value="<?= $date_data['_date_start'][0] ?>"/>
         </td>
         <td>
            <table class="time-selection">
               <tr>
                  <td>Time</td>
                  <td>
                     <select name="date_start_time">
                        <? $minutes_iteration = DEL_DATE_TIME_ITERATION_MINUTES * 60;
                           $day_end = 24 * 60 * 60;
                           for ($i = 0; $i < $day_end; $i += $minutes_iteration) :
                              $selected = ($i == $date_data['_date_start_time'][0]) ? ' selected' : ''; ?>
                        <option value="<?= $i ?>"<?= $selected ?>><?= date ('g:ia', $i) ?></option>
                        <? endfor; ?>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td>Duration</td>
                  <td>
                     <select name="date_duration">
                        <? $minutes_iteration = DEL_DATE_DURATION_ITERATION_MINUTES * 60;
                           $max_duration = 24 * 60 * 60;
                           for ($i = $minutes_iteration; $i <= $max_duration; $i += $minutes_iteration) :
                              // format the option as: x hours y minutes

                              $formatted_duration = '';
                              $current_hour = floor ($i / (60 * 60));
                              if ($current_hour) :
                                 $pluralization = ($current_hour == 1) ? '' : 's';
                                 $formatted_duration .= $current_hour . ' hour' . $pluralization . ' ';
                              endif;

                              $current_minutes = $i % (60 * 60);
                              if ($current_minutes > 0) :
                                 $formatted_duration .= ($current_minutes / 60) . ' minutes';
                              endif;

                              $selected = ($i == $date_data['_date_duration'][0]) ? ' selected' : '';

                              ?>
                        <option value="<?= $i ?>"<?= $selected ?>><?= $formatted_duration ?></option>
                        <? endfor; ?>
                     </select>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

</div>