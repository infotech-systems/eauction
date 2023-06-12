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
$('#orgn').change(function(){
    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var orgn = $('#orgn').val();
 
    var request = $.ajax({
        url: "./back/emp_back.php",
        method: "POST",
        data: {
            hid_token: hid_token,
            hid_log_user: hid_log_user,
            orgn: orgn,
            tag: 'SELECT-DIVISION'
        },
        dataType: "html",
        success: function(msg) {
            console.log(msg);
            var msg1=msg.trim();
            $("#div_division").html(msg1);
            
         }
    });
});
$('#division').change(function(){
    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var orgn = $('#orgn').val();
    var division = $('#division').val();
 
    var request = $.ajax({
        url: "./back/emp_back.php",
        method: "POST",
        data: {
            hid_token: hid_token,
            hid_log_user: hid_log_user,
            orgn: orgn,
            division: division,
            tag: 'SELECT-OPERATION'
        },
        dataType: "html",
        success: function(msg) {
            console.log(msg);
            var msg1=msg.trim();
            $("#div_operation").html(msg1);
            
         }
    });
});
$('#operation').change(function(){
    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var orgn = $('#orgn').val();
    var operation = $('#operation').val();
 
    var request = $.ajax({
        url: "./back/emp_back.php",
        method: "POST",
        data: {
            hid_token: hid_token,
            hid_log_user: hid_log_user,
            orgn: orgn,
            operation: operation,
            tag: 'SELECT-UNIT'
        },
        dataType: "html",
        success: function(msg) {
            console.log(msg);
            var msg1=msg.trim();
            $("#div_unit").html(msg1);
            
         }
    });
});

$("#search").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var unit = $('#unit').val();
    var request = $.ajax({
        url: "./back/user_back.php",
        method: "POST",
        data: {
            hid_token: hid_token,
            hid_log_user: hid_log_user,
            unit: unit,
            tag: 'SEARCHUSER'
        },
        dataType: "html",
        success: function(msg) {
            //  alert(msg);
            $("#search_result").html(msg);
        }
    });
});


$("#service").change(function() {
    var hid_log_user = $('#hid_log_user').val();
    var hid_token = $('#hid_token').val();
    var service = $('#service').val();
    var request = $.ajax({
        url: "./back/user_back.php",
        method: "POST",
        data: {
            service: service,
            hid_log_user: hid_log_user,
            hid_token: hid_token,
            tag: 'SERVICE'
        },
        dataType: "html",
        success: function(msg) {
            $("#div_orgn").html(msg);
        }
    });
});

$("#edit").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var hid_uid = $('#hid_uid').val();
    var user_name = $('#user_name').val();
    var user_type = $('#user_type').val();
    var cell_no = $('#cell_no').val();
    var user_type = $('#user_type').val();
    var user_status = $('#status').val();
    var password = $('#password').val();
    var orgn = $('#orgn').val();
    var division = $('#division').val();
//   var operation = $('#operation').val();
    var unit = $('#unit').val();

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

$("#add").click(function() {

    var hid_token = $('#hid_token').val();
    var hid_log_user = $('#hid_log_user').val();
    var user_name = $('#user_name').val();
    var user_id = $('#user_id').val();
    var user_type = $('#user_type').val();
    var cell_no = $('#cell_no').val();
    var hid_pwd = $('#hid_pwd').val();
    var orgn = $('#orgn').val();
    var status = $('#status').val();

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
    var request = $.ajax({
        url: "./back/user_back.php",
        method: "POST",
        data: {
            hid_token: hid_token,
            hid_log_user: hid_log_user,
            user_id: user_id,
            user_name: user_name,
            cell_no: cell_no,
            user_type: user_type,
            status: status,
            hid_pwd: hid_pwd,
            orgn: orgn,
            tag: 'ADD-USER'
        },
        dataType: "html",
        success: function(msg) {
            console.log(msg);
            
            if(msg.trim()=="INSERT-SUCCESS")
            {
                alert('User inserted successfully')
                window.location.href = './user-mas.php';
            }
            if(msg.trim()=="ERROR-INSERT")
            {
                alertify.error('Cannot create user');
                return false;
            }

           
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

    if (!/^[0-9a-zA-Z]+$/.test(user_id)) {
        alertify.error('Special Character or Space not allowed in Contact No');
        $('#user_id').focus();
        return false;
    }
    if (user_id == "") {
        alertify.error('Please input a User ID');
        $('#user_id').focus();
        return false;
    }
    if (user_id.length > 15) {
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