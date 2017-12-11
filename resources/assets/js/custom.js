window.$ = window.jQuery = require('jquery');
window.select2 = require('select2');
$(function(){

  $('.select-absen').on('change', function(){
    var value = $(this).val()
    value += ' has-select'
    $(this).parent().attr('class', value)
  });

  $('.jam').timepicker({
    showSeconds: true,
    showMeridian: false,
    minuteStep: 5,
    secondStep: 5,
    icons: {
      up: 'fa fa-chevron-up',
      down: 'fa fa-chevron-down'
    }
  });

  $(document).ready(function() {
      $('.select2').select2();
  });
});
