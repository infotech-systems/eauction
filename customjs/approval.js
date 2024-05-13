// JavaScript Document
function validateEmail(txtEmail) {
    var a = document.getElementById(txtEmail).value;
    var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
    if (filter.test(a)) {
        return true;
    } else {
        return false;
    }
}

$('#send_otp').click(function(){
    var hid_log_user = $('#hid_log_user').val();
    var request = $.ajax({
        url: "./back/approval-back.php",
        method: "POST",
        data: {
            hid_log_user: hid_log_user,
            tag: 'OTP'
        },
        dataType: "html",
        success: function(msg) {
            $("#info").html(msg);
        }
    });
});


$("#submit").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var auc_id = $('#auc_id').val();
    var otp = $('#otp').val();
    var count_checked = $("[name='check[]']:checked").length;

    if (otp == "") {
        alertify.error('Please input OTP');
        $('#otp').focus();
        return false;
    }
    if (count_checked == "") {
        alertify.error('Please Please select any record to update.');
        return false;
    }
    
});
