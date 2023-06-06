<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
?>
<script>
    function isEmail(email) { 
        return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
    } 
</script>
<?php
if(($tag=="OTP"))
{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';

    $sql=" select uid from user_mas  ";
    $sql.="  where user_id=:user_id ";
   // echo "$sql--$otp--$email_id";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':user_id', $user_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    if($row2!=null):
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />
        <script>
        alertify.alert("Already Register this: <?php echo $user_id; ?>");
        </script>
        <?php
    else:
    $otp=generateRandomString();
echo $otp;
    $sql=" insert into reg_otp_mas (email_id,otp,otp_time ";
    $sql.=" ) values ( ";
    $sql.=" :user_id,:otp,current_timestamp) ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':user_id', $user_id);
    $sth->bindParam(':otp', $otp);
    $sth->execute();
    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
    alertify.alert("OTP Send Your Mail. Please check inbox or spam.");
    </script>
    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="OTP"  autocomplete="off" name="otp" id="otp" >
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
            var user_name = $('#user_name').val();
            var user_id = $('#user_id').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
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
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    user_name: user_name,
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
            var user_name = $('#user_name').val();
            var user_id = $('#user_id').val();
            var otp = $('#otp').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
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
                alert('Please input OTP');
                $('#otp').focus();
                return false;
            } 
            var request = $.ajax({
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    user_name: user_name,
                    user_id:user_id,
                    otp:otp,
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
if(($tag=="OTPV"))
{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $otp= isset($_POST['otp'])? $_POST['otp']: '';
    
    $sql=" select otp_id from reg_otp_mas  ";
    $sql.="  where otp=:otp and  email_id=:user_id ";
   // echo "$sql--$otp--$email_id";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':otp', $otp);
    $sth->bindParam(':user_id', $user_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    if($row2!=null):
    ?>
        <div class="form-group has-feedback">
            <input type="text" name="cell_no" id="cell_no"  autocomplete="off" maxlength="10" class="form-control" placeholder="Mobile No">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control"  autocomplete="off" placeholder="Password" name="password" id="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control"  autocomplete="off" placeholder="Retype password"  name="repassword" id="repassword">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
			<div class="col-xs-12">
				<input type="button" name="register" id="register" value="Register"  class="btn btn-success btn-block btn-flat">
			</div>
		</div>
       <script>
        $("#register").click(function() 
        {
            var user_name = $('#user_name').val();
            var user_id = $('#user_id').val();
            var password = $('#password').val();
            var repassword = $('#repassword').val();
            var cell_no = $('#cell_no').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
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
            if (cell_no == "") {
                alert('Please input Mobile No');
                $('#cell_no').focus();
                return false;
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
                    alertify.error('Password and Retype password does not match');
                    $('#repassword').focus();
                    return false;
                }

            }
            var request = $.ajax({
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    user_name: user_name,
                    user_id:user_id,
                    password:password,
                    cell_no:cell_no,
                    tag: 'REGISTER'
                },
                dataType: "html",
                success: function(msg) {
                    $("#info").html(msg);           
                }
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
        <input type="text" class="form-control"  autocomplete="off" placeholder="OTP" name="otp" id="otp" value="<?php echo $otp; ?>">
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
            var user_name = $('#user_name').val();
            var user_id = $('#user_id').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
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
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    user_name: user_name,
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
            var user_name = $('#user_name').val();
            var user_id = $('#user_id').val();
            var otp = $('#otp').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
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
                alert('Please input OTP');
                $('#otp').focus();
                return false;
            } 
            var request = $.ajax({
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    user_name: user_name,
                    user_id:user_id,
                    otp:otp,
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
if(($tag=="REGISTER"))
{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $password2= isset($_POST['password'])? $_POST['password']: '';
    $cell_no= isset($_POST['cell_no'])? $_POST['cell_no']: '';

    $password=password_hash($password2,PASSWORD_BCRYPT);

    $sql2=" select assigned_page from user_type_mas  ";
    $sql2.=" where user_type='B' ";
    $sth2 = $conn->prepare($sql2);
    $sth2->execute();
    $sth2->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth2->fetch();
    $assigned_page=$row2['assigned_page'];

    $sql_ins ="insert into user_mas(user_name,user_id ";
    $sql_ins.=",password,cell_no,user_type,page_assign,orgn_id ) ";
    $sql_ins.="values( trim(upper(:user_name)),trim(:user_id),trim(:password) ";
    $sql_ins.=",trim(:cell_no),'B',:assigned_page,'1') ";

    $sthI = $conn->prepare($sql_ins);
    $sthI->bindParam(':user_name', $user_name);
    $sthI->bindParam(':user_id', $user_id);
    $sthI->bindParam(':password', $password);
    $sthI->bindParam(':cell_no', $cell_no);
    $sthI->bindParam(':assigned_page', $assigned_page);
    $sthI->execute();
    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
        alertify.alert("Register Successfully.", function(){
            window.location.href='./login.php';
        });           
    </script> 
    <?php
}
?>

<?php
$conn=null;
?>