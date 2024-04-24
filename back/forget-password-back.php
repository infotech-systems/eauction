<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
$tag1 = isset($_POST['tag1']) ? $_POST['tag1'] : '';
?>
<script>
    function isEmail(email) { 
        return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
    } 
</script>
<?php
if(($tag=="OTP"))
{
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';

    $sql=" select uid,cell_no from user_mas  ";
    $sql.="  where user_id=:user_id ";
   // echo "$sql--$otp--$email_id";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':user_id', $user_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    $user_count=$row2['uid'];
    $cell_no=$row2['cell_no'];

    if($row2!=null):
        $otp=generateRandomString();
        $motp=generateRandomString();
    
        $sql=" update reg_otp_mas set status='D'  ";
        $sql.="  where email_id=:user_id ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':user_id', $user_id);
        $sth->execute();
        $sql=" insert into reg_otp_mas (email_id,otp,mobile_no,motp,otp_time ";
        $sql.=" ) values ( ";
        $sql.=" :user_id,:otp,:cell_no,:motp,current_timestamp) ";
    // echo $sql;
        $sth = $conn->prepare($sql);
        $sth->bindParam(':user_id', $user_id);
        $sth->bindParam(':otp', $otp);
        $sth->bindParam(':cell_no', $cell_no);
        $sth->bindParam(':motp', $motp);
        $sth->execute();
        $otp_id=$conn->lastInsertId();

        $template='1707170685606657081';
        $message="Your one-time passcode (OTP) is $motp for eFile System. Andrew Yule & Company Limited, Kolkata";

        send_sms($cell_no,$message,$template);
        file_get_contents('https://privatesale.andrewyule.in/mail/register/send/'.$otp_id);
    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
    alertify.alert("OTP Send to Your eMail. Please check inbox and spam folder too.");
    </script>
    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Email OTP"  autocomplete="off" name="otp" id="otp" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Mobile OTP"  autocomplete="off" name="motp" id="motp" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-12 margin-bottom">
            <input type="button" name="verify_otp" id="verify_otp"  value="Verify OTP"  class="btn btn-success btn-block btn-flat">
        </div>
        <div class="col-xs-12">
            <input type="button" name="send_otp" id="send_otp" value="Re-send OTP"  class="btn btn-info btn-block btn-flat">
        </div>
    </div>
    <script>
        $("#send_otp").click(function() 
        {
            var user_id = $('#user_id').val();
            if (user_id == "") {
                alert('Please input Email Id');
                $('#user_id').focus();
                return false;
            } 
            else
            {
                if (!isEmail(user_id)) {
                    alert('Please input Valid Email Id');
                    $('#user_id').focus();
                    return false;
                }
            }
            var request = $.ajax({
                url: "./back/forget-password-back.php",
                method: "POST",
                data: {
                    user_id:user_id,
                    tag: 'OTP'
                },
                dataType: "html",
                success: function(msg) {
                    $("#otp_div").html(msg);           
                }
            });
        
        });
        $("#verify_otp").click(function() 
        {
            var user_id = $('#user_id').val();
            var otp = $('#otp').val();
            var motp = $('#motp').val();
            if (user_id == "") {
                alert('Please input Email Id');
                $('#user_id').focus();
                return false;
            } 
            else
            {
                if (!isEmail(user_id)) {
                    alert('Please input Valid Email Id');
                    $('#user_id').focus();
                    return false;
                }
            }
            if (otp == "") {
                alert('Please input Email OTP');
                $('#otp').focus();
                return false;
            } 
            if (motp == "") {
                alert('Please input Mobile OTP');
                $('#motp').focus();
                return false;
            } 
            var request = $.ajax({
                url: "./back/forget-password-back.php",
                method: "POST",
                data: {
                    user_id:user_id,
                    otp:otp,
                    motp:motp,
                    tag: 'OTPV'
                },
                dataType: "html",
                success: function(msg) {
                    $("#otp_div").html(msg);           
                }
            });
        
        });
        
        </script>
    <?php
    else:
    ?>
    <script>
        alertify.alert("Please input register Email ID");
    </script>
    <?php
    endif;
}
?>
<?php
if(($tag=="OTPV"))
{
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $otp= isset($_POST['otp'])? $_POST['otp']: '';
    $mobile_no= isset($_POST['mobile_no'])? $_POST['mobile_no']: '';
    $motp= isset($_POST['motp'])? $_POST['motp']: '';

    $sql=" select otp_id from reg_otp_mas  ";
    $sql.="  where otp=:otp and  email_id=:user_id and motp=:motp  and status='A' ";
   // echo "$sql--$otp--$email_id";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':otp', $otp);
    $sth->bindParam(':user_id', $user_id);
    $sth->bindParam(':motp', $motp);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    if($row2!=null):
    ?>
        <div class="form-group has-feedback">
            <input type="text" name="password" id="password" placeholder="New Password"  autocomplete="off" class="form-control">
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="repassword" id="repassword" placeholder="Confirm Password"  autocomplete="off" class="form-control">
        </div>
        <div class="row">
			<div class="col-xs-12">
				<input type="button" name="submit" id="submit" value="Change Password"  class="btn btn-success btn-block btn-flat">
			</div>
		</div>
       <script>
        $('.select2').select2()
        $('#user_id').prop('readonly', true);

        $("#submit").click(function() 
        {
            var password = $('#password').val();
            var repassword = $('#repassword').val();
            var user_id = $('#user_id').val();
            if (user_id == "") {
                alert('Please input Email Id');
                $('#user_id').focus();
                return false;
            } 
            else
            {
                if (!isEmail(user_id)) {
                    alert('Please input Valid Email Id');
                    $('#user_id').focus();
                    return false;
                }
            }
            if (password == "") {
                alert('Please input Password');
                $('#password').focus();
                return false;
            }
            if (repassword == "") {
                alert('Please input Retype password');
                $('#repassword').focus();
                return false;
            }

            if (password != "" || repassword != "") {
                if (password != repassword) {
                    alertify.error('Password and Confirm password does not match');
                    $('#repassword').focus();
                    return false;
                }

            }
            var formData = new FormData(document.getElementById("form1"));
            $("#loading").addClass('overlay');
            $("#loading").html('<i class="fa fa-spinner fa-pulse"></i>');
            var request = $.ajax({
                url: "./back/forget-password-back.php",
                method: "POST",
                data: formData,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                dataType: "html",
                success: function(msg) {
                    $("#loading").removeClass('overlay');
                    $("#loading").fadeOut();
                    $("#info").html(msg);
                },
                error: function(xhr, status, error) {
                    alert(status);
                    alert(xhr.responseText);
                },
            });
        });
        </script>
    <?php
    else:
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />
        <script>
        alertify.alert("Please input correct OTP.");
        </script>
        <div class="form-group has-feedback">
            <input type="text" class="form-control"  autocomplete="off" placeholder="Email OTP" name="otp" id="otp" value="<?php echo $otp; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control"  autocomplete="off" placeholder="Mobile OTP" name="motp" id="motp" value="<?php echo $motp; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-12 margin-bottom">
                <input type="button" name="verify_otp" id="verify_otp" value="Verify OTP"  class="btn btn-success btn-block btn-flat">
            </div>
            <div class="col-xs-12">
                <input type="button" name="send_otp" id="send_otp" value="Re-send OTP"  class="btn btn-info btn-block btn-flat">
            </div>
        </div>
        <script>        
        $("#send_otp").click(function() 
        {
            var user_id = $('#user_id').val();
            if (user_id == "") {
                alert('Please input Email Id');
                $('#user_id').focus();
                return false;
            } 
            else
            {
                if (!isEmail(user_id)) {
                    alert('Please input Valid Email Id');
                    $('#user_id').focus();
                    return false;
                }
            }
            var request = $.ajax({
                url: "./back/forget-password-back.php",
                method: "POST",
                data: {
                    user_id:user_id,
                    tag: 'OTP'
                },
                dataType: "html",
                success: function(msg) {
                    $("#otp_div").html(msg);           
                }
            });
        });
        $("#verify_otp").click(function() 
        {
            var user_id = $('#user_id').val();
            var otp = $('#otp').val();
            var motp = $('#motp').val();
            if (user_id == "") {
                alert('Please input Email Id');
                $('#user_id').focus();
                return false;
            } 
            else
            {
                if (!isEmail(user_id)) {
                    alert('Please input Valid Email Id');
                    $('#user_id').focus();
                    return false;
                }
            }
            if (otp == "") {
                alert('Please input Email OTP');
                $('#otp').focus();
                return false;
            } 
            if (motp == "") {
                alert('Please input Mobile OTP');
                $('#motp').focus();
                return false;
            } 
            var request = $.ajax({
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    user_id:user_id,
                    otp:otp,
                    motp:motp,
                    tag: 'OTPV'
                },
                dataType: "html",
                success: function(msg) {
                    $("#otp_div").html(msg);           
                }
            });        
        });        
        </script>
        <?php
    endif;
}
?>

<?php
if(($tag1=="FORGET"))
{
    try{
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $password2= isset($_POST['password'])? $_POST['password']: '';

    $password=password_hash($password2,PASSWORD_BCRYPT);

    $sql_ins ="update user_mas set password=:password ";
    $sql_ins.=" where user_id=:user_id ";

    $sthI = $conn->prepare($sql_ins);
    $sthI->bindParam(':user_id', $user_id);
    $sthI->bindParam(':password', $password);
    $sthI->execute();

    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
        alertify.alert("Password change done Successfully.", function(){
            window.location.href='./login.php';
        });          
    </script> 
    <?php
    }catch(Exception $e)
    {
        echo $e-getMessage();
    }
}
?>

<?php
$conn=null;
?>