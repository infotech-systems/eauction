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


$("#add").click(function() {
    var hid_log_user = $('#hid_log_user').val();
    var hid_token = $('#hid_token').val();
    var newpassword = $('#newpassword').val();
    var confirmpassword = $('#confirmpassword').val();

    if (newpassword == "") {
        alertify.error('Please input  New Password');
        $('#newpassword').focus();
        return false;
    }
    if (confirmpassword == "") {
        alertify.error('Please input Confirm Password');
        $('#confirmpassword').focus();
        return false;
    }

    if (newpassword != "" || confirmpassword != "") {
        if (newpassword != confirmpassword) {
            alertify.error('new password and confirm password does not match');
            $('#confirmpassword').focus();
            return false;
        }

    }

    var request = $.ajax({
        url: "./back/changepassword-back.php",
        method: "POST",
        data: {
            hid_log_user: hid_log_user,
            hid_token: hid_token,
            newpassword: newpassword,
            tag: 'CHANGPWD'
        },
        dataType: "html",
        success: function(msg) {
            $("#info").html(msg);
        }
    });
});