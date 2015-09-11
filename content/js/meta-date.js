if (! $) var $ = jQuery;

$(document).ready (function () {

   if (! $("div.del-meta-date").length) return;

   del_date_meta.initialize_datepicker ();

});

var del_date_meta = {

   initialize_datepicker: function () {

      $('#date-event').datepicker ({
         onSelect: function () {
            $('input[name=date_start]').val (this.value);
         },
         defaultDate: new Date($('input[name=date_start]').val())
      });

   }

}