// JavaScript Document
$('#offer_period1').daterangepicker({
    timePicker: true,
    minDate: moment().startOf('hour').add(1, 'hour'),
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(24, 'hour'),
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    }
  });
  $('#knockdown_period1').daterangepicker({
    timePicker: true,
    minDate: moment().startOf('hour').add(1, 'hour'),
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(1, 'hour'),
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    }
  });
$("#submit").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var auc_id = $('#auc_id').val();
    var offer_period = $('#offer_period').val();
    var knockdown_period = $('#knockdown_period').val();
    var count_checked = $("[name='check[]']:checked").length;

    if (offer_period == "") {
        alertify.error('Please input Offer Period');
        $('#offer_period').focus();
        return false;
    }
    if (knockdown_period == "") {
        alertify.error('Please input Knock Down Period');
        $('#knockdown_period').focus();
        return false;
    }
    if (count_checked == "") {
        alertify.error('Please Please select any record to update.');
        return false;
    }
    
});
