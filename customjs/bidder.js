$("#submit").click(function() 
{
    var hid_id = $('#hid_id').val();
    var bidder_name = $('#bidder_name').val();
    var state = $('#state').val();
    var address = $('#address').val();
    var pin = $('#pin').val();
    var pan_no = $('#pan_no').val();
    var gst_no = $('#gst_no').val();
    var cont_no1 = $('#cont_no1').val();
    var cont_no2 = $('#cont_no2').val();
    var email_id = $('#email_id').val();
    var bidder_type = $('#bidder_type').val();
    var status = $('#status').val();
    var hid_log_user = $('#hid_log_user').val();
    var hid_token = $('#hid_token').val();

    if (bidder_name == "") {
        alert('Please input Name');
        $('#bidder_name').focus();
        return false;
    }  
    if(cont_no1.length != 10) {
        alert('Please input Valid Mobile No');
        $('#cont_no1').focus();
        return false;
    } 
    if (email_id == "") {
        alert('Please input Email Id');
        $('#user_id').focus();
        return false;
    } 
    else
    {
        if (!isEmail(email_id)) {
            alert('Please input Valid Email Id');
            $('#email_id').focus();
            return false;
        }
    }
    if (bidder_type == "") {
        alert('Please select Bidder Type');
        $('#bidder_type').focus();
        return false;
    } 
    if (status == "") {
        alert('Please select Status');
        $('#status').focus();
        return false;
    } 
    
    var request = $.ajax({
        url: "./back/bidder-back.php",
        method: "POST",
        data: {
            hid_id: hid_id,
            bidder_name: bidder_name,
            state:state,
            address: address,
            pin: pin,
            pan_no:pan_no,
            gst_no: gst_no,
            cont_no1: cont_no1,
            cont_no2:cont_no2,
            email_id: email_id,
            bidder_type: bidder_type,
            status:status,
            hid_log_user:hid_log_user,
            hid_token:hid_token,
            tag: 'MODIFI'
        },
        dataType: "html",
        success: function(msg) {
            $("#otp_div").html(msg);           
        }
    });
});
function isEmail(email) { 
    return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
} 