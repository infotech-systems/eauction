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

$('#committee').change(function(){
    var committee = $('#committee').val();
    if(committee=='Y')
    {
        $("#app_div").show();
    }
    else
    {
        $("#app_div").hide();
    }
});


$('#committee1').change(function(){
    var committee1 = $('#committee1').val();
    if(committee1=='Y')
    {
        $("#app_div1").show();
    }
    else
    {
        $("#app_div1").hide();
    }
});
$("#submit").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var user_name = $('#user_name').val();
    var user_id = $('#user_id').val();
    var password = $('#password').val();
    var cell_no = $('#cell_no').val();
    var user_type = $('#user_type').val();
    var committee = $('#committee').val();
    var designation = $('#designation').val();
    var seq_id = $('#seq_id').val();
    var sign = $('#sign').val();

    if (user_name == "") {
        alertify.error('Please input user name');
        $('#user_name').focus();
        return false;
    }
    if (user_id == "") {
        alertify.error('Please input user id');
        $('#user_id').focus();
        return false;
    }
    if (orgn == "") {
        alertify.error('Please select an organization');
        $('#orgn').focus();
        return false;
    }
  
    if(cell_no.length > 0) {

        if (cell_no.length != "10") {
            alertify.error('Please input a Valid Cell No');
            $('#cell_no').focus();
            return false;
        }
        if (!/^[0-9]+$/.test(cell_no)) {
            alertify.error('Special Character not allowed in Cell No');
            $('#cell_no').focus();
            return false;
        }
    }
    if(committee=='Y')
    {
        if (designation == "") {
            alertify.error('Please input Designation');
            $('#designation').focus();
            return false;
        }
        if (seq_id == "") {
            alertify.error('Please input Serial No');
            $('#seq_id').focus();
            return false;
        }
        if (sign == "") {
            alertify.error('Please Choose Signature Photo');
            $('#sign').focus();
            return false;
        } 
        if (sign != "") {
            var filearr = sign.split('.');
            if (filearr.length > 2) {
                alert('Double extension files are not allowed.');
                $('#sign').focus();
                return false;
            }
            if (sign != "") {
                var extension = sign.substr(sign.lastIndexOf('.') + 1).toLowerCase();
                var allowedExtensions = ["jpg", "jpeg","png"];
                if (sign.length > 0) {
                    if (allowedExtensions.indexOf(extension) === -1) {
                        alert('Invalid file Format. Only ' + allowedExtensions.join(', ') + ' are allowed.');
                        $('#sign').focus();
                        return false;
                    }
                }
            }
            
        }
    
    }
});

$("#edit").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var hid_uid = $('#hid_uid').val();
    var user_name = $('#user_name').val();
    var cell_no = $('#cell_no').val();
    var user_type = $('#user_type').val();
    var user_status = $('#status').val();
    var password = $('#password').val();
    var hid_idw = $('#hid_idw').val();
    var committee = $('#committee').val();
    var designation = $('#designation').val();
    var seq_id = $('#seq_id').val();
    var sign = $('#sign').val();
    if(cell_no.length > 0) {

        if (cell_no.length != "10") {
            alertify.error('Please input a Valid Cell No');
            $('#cell_no').focus();
            return false;
        }
        if (!/^[0-9]+$/.test(cell_no)) {
            alertify.error('Special Character not allowed in Cell No');
            $('#cell_no').focus();
            return false;
        }
    }
    if(committee=='Y')
    {
        if (designation == "") {
            alertify.error('Please input Designation');
            $('#designation').focus();
            return false;
        }
        if (seq_id == "") {
            alertify.error('Please input Serial No');
            $('#seq_id').focus();
            return false;
        }
        if (hid_idw == "") {
            if (sign == "") {
                alertify.error('Please Choose Signature Photo');
                $('#sign').focus();
                return false;
            } 
        }
        if (sign != "") {
            var filearr = sign.split('.');
            if (filearr.length > 2) {
                alert('Double extension files are not allowed.');
                $('#sign').focus();
                return false;
            }
            if (sign != "") {
                var extension = sign.substr(sign.lastIndexOf('.') + 1).toLowerCase();
                var allowedExtensions = ["jpg", "jpeg","png"];
                if (sign.length > 0) {
                    if (allowedExtensions.indexOf(extension) === -1) {
                        alert('Invalid file Format. Only ' + allowedExtensions.join(', ') + ' are allowed.');
                        $('#sign').focus();
                        return false;
                    }
                }
            }
            
        }
    
    }
    var request = $.ajax({
        url: "./back/user_back.php",
        method: "POST",
        data: {
            hid_token: hid_token,
            hid_log_user: hid_log_user,
            hid_uid: hid_uid,
            user_name: user_name,
            cell_no: cell_no,
            user_type: user_type,
            user_status: user_status,
            password: password,
            orgn: orgn,
            division: division,
        //    operation: operation,
            unit: unit,
            tag: 'UPDATE-USER'
        },
        dataType: "html",
        success: function(msg) {

            alert('User updated Successfully')
            window.location.href = './user-mas.php'
        }
    });
});


function readURL(input) {


    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#falseinput').attr('src', e.target.result);

            $('#base').val(e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ajaxStart(function() {
    $('body').addClass('wait');

}).ajaxComplete(function() {

    $('body').removeClass('wait');

});



function RemScript(data) {

    var content = $(data);
    content.find('script').remove();
    if (typeof content.html() === "undefined")
        return data;
    else
        return content.html();

}

$("#profile").click(function() {
    var hid_uid = $('#hid_uid').val();
    var user_nm = $('#user_nm').val();
    var user_id = $('#user_id').val();
    var password = $('#password').val();
    var addr = $('#addr').val();
    var contact_no = $('#contact_no').val();
    var email = $('#email').val();
    var base = $('#base').val();
    var fileinput = $('#fileinput').val();
    var filearr = fileinput.split('.');
    var csrftoken = $('#csrftoken').val();
    var hid_id = $('#hid_id').val();
    if (user_nm == "") {
        alertify.error('Please input a Name');
        $('#user_nm').focus();
        return false;
    }
    /*  if (!/^[0-9a-zA-Z]+$/.test(user_nm)) {
          alertify.error('Invalid Name');
          $('#user_nm').focus();
          return false;
      }*/
    if (user_id == "") {
        alertify.error('Please input a User ID');
        $('#user_id').focus();
        return false;
    }

    if (contact_no != "") {
        if (contact_no.length != "10") {
            alertify.error('Please input a Valid Contact No');
            $('#contact_no').focus();
            return false;
        }
        if (!/^[0-9]+$/.test(contact_no)) {
            alertify.error('Special Character not allowed in Contact No');
            $('#contact_no').focus();
            return false;
        }
    }

    if (addr != "") {
        if (!/^[A-Za-z0-9_@./#&+-,() ']*$/.test(addr)) {
            alertify.error("Please input valid Address");
            $('#addr').focus();
            return false;
        }
    }

    if (email == "") {
        alertify.error('Please input a Email ID');
        $('#email').focus();
        return false;
    }
    if (password == "") {
        alertify.error('Please input Password');
        $('#password').focus();
        return false;
    }
    if ($('#email').val() != "") {
        if (!validateEmail('email')) {
            alertify.error(" Invalid Email ID");
            $('#email').css("border-color", "#FF0000");
            $('#email').focus();
            return false;
        }
    }
    if (filearr.length > 2) {
        alert('Double extension files are not allowed.');
        $('#fileinput').focus();
        return false;
    }
    if (fileinput != "") {

        var extension = fileinput.substr(fileinput.lastIndexOf('.') + 1).toLowerCase();
        var allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (fileinput.length > 0) {
            if (allowedExtensions.indexOf(extension) === -1) {
                alert('Invalid file Format. Only ' + allowedExtensions.join(', ') + ' are allowed.');
                $('#fileinput').focus();
                return false;
            }
        }
    }

    var request = $.ajax({
        url: "./back/register.php",
        method: "POST",
        data: {
            user_nm: user_nm,
            user_id: user_id,
            password: password,
            contact_no: contact_no,
            email: email,
            hid_uid: hid_uid,
            addr: addr,
            base: base,
            csrftoken: csrftoken,
            hid_id: hid_id,
            tag: 'REGISTER-PROFILE'
        },
        dataType: "html",
        success: function(msg) {
            $("#info").html(msg);
        }
    });
});




$("#user_id").focusout(function() {
    var hid_log_user = $('#hid_log_user').val();
    var user_id = $('#user_id').val();
    var hid_token = $('#hid_token').val();

    if (user_id == "") {
        alertify.error('Please input a User ID');
        $('#user_id').focus();
        return false;
    }
    if (user_id.length > 100) {
        alertify.error('Please input a 15 character User ID');
        $('#user_id').focus();
        return false;
    }

    var request = $.ajax({
        url: "./back/user_back.php",
        method: "POST",
        data: {
            user_id: user_id,
            hid_log_user: hid_log_user,
            hid_token: hid_token,
            tag: 'USERAVAIL'
        },
        dataType: "html",
        success: function(msg) {
            var msg1=msg.trim();
            if(msg1=="USERID-AVAILABLE")
            {
                alertify.success('User id is available');
                $('#add').prop('disabled', false);
            }
            if(msg1=="USERID-UNAVAILABLE")
            {
                alertify.error('User id is not available');
                $('#user_id').focus();
                $('#add').prop('disabled', true);

            }
            
        }
    });
});