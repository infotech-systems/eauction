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
            <textarea name="addr" id="addr"  autocomplete="off" class="form-control" rows="3" placeholder="Address"></textarea>
        </div>
        <div class="form-group has-feedback">
            <select class="form-control select2" name="state_code"  id="state_code">
                <option value=""></option>
                <?php
                $sqle= "select state_code,state_nm ";
                $sqle.="from state_mas order by state_nm ";
                $sth = $conn->prepare($sqle);
                $sth->execute();
                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                $row = $sth->fetchAll();
                foreach ($row as $key => $value) 
                {
                   $e_state_code=$value['state_code'];
                   $e_state_nm=$value['state_nm'];
                   ?>
                    <option value="<?php echo $e_state_code; ?>"><?php echo $e_state_nm; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="pin" id="pin"  autocomplete="off" maxlength="6" class="form-control" placeholder="PIN">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="pan_no" id="pan_no"  autocomplete="off" maxlength="10" class="form-control" placeholder="Pan No">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="gst_no" id="gst_no"  autocomplete="off" maxlength="15" class="form-control" placeholder="GST No">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="cont_no1" id="cont_no1"  autocomplete="off" maxlength="10" class="form-control" placeholder="Contact No 1">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="cont_no2" id="cont_no2"  autocomplete="off" maxlength="10" class="form-control" placeholder="Contact No 2">
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
            var addr = $('#addr').val();
            var state_code = $('#state_code').val();
            var pin = $('#pin').val();
            var pan_no = $('#pan_no').val();
            var gst_no = $('#gst_no').val();
            var cont_no1 = $('#cont_no1').val();
            var cont_no2 = $('#cont_no2').val();
            var password = $('#password').val();
            var repassword = $('#repassword').val();
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
            if (addr == "") {
                alert('Please input Address');
                $('#addr').focus();
                return false;
            } 
            if (state_code == "") {
                alert('Please select State Code');
                $('#state_code').focus();
                return false;
            } 
            if (pin == "") {
                alert('Please input Pin Code');
                $('#pin').focus();
                return false;
            }  
            if (pan_no == "") {
                alert('Please input PAN No');
                $('#pan_no').focus();
                return false;
            }  
            if (gst_no == "") {
                alert('Please input GST No');
                $('#gst_no').focus();
                return false;
            }  
            if (cont_no1 == "") {
                alert('Please input Contact No 1');
                $('#cont_no1').focus();
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
                    addr:addr,
                    state_code:state_code,
                    pin:pin,
                    pan_no:pan_no,
                    gst_no:gst_no,
                    cont_no1:cont_no1,
                    cont_no2:cont_no2,
                    password:password,
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
    try{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $addr= isset($_POST['addr'])? $_POST['addr']: '';
    $state_code= isset($_POST['state_code'])? $_POST['state_code']: '';
    $pin= isset($_POST['pin'])? $_POST['pin']: '';
    $pan_no= isset($_POST['pan_no'])? $_POST['pan_no']: '';
    $gst_no= isset($_POST['gst_no'])? $_POST['gst_no']: '';
    $cont_no1= isset($_POST['cont_no1'])? $_POST['cont_no1']: '';
    $cont_no2= isset($_POST['cont_no2'])? $_POST['cont_no2']: '';
    $password2= isset($_POST['password'])? $_POST['password']: '';


    $sql_ins ="insert into bidder_mas(name,addr,state_code ";
    $sql_ins.=",pin,pan_no,gst_no,cont_no1,cont_no2,email_id ) ";
    $sql_ins.="values( trim(upper(:user_name)),trim(upper(:addr)),:state_code,:pin ";
    $sql_ins.=",trim(upper(:pan_no)),trim(upper(:gst_no)),trim(:cont_no1),trim(:cont_no2),:user_id) ";
    $sthI = $conn->prepare($sql_ins);
    $sthI->bindParam(':user_name', $user_name);
    $sthI->bindParam(':addr', $addr);
    $sthI->bindParam(':state_code', $state_code);
    $sthI->bindParam(':pin', $pin);
    $sthI->bindParam(':pan_no', $pan_no);
    $sthI->bindParam(':gst_no', $gst_no);
    $sthI->bindParam(':cont_no1', $cont_no1);
    $sthI->bindParam(':cont_no2', $cont_no2);
    $sthI->bindParam(':user_id', $user_id);
    $sthI->execute();
    $bidder_id=$conn->lastInsertId();
    $password=password_hash($password2,PASSWORD_BCRYPT);

    $sql2=" select assigned_page from user_type_mas  ";
    $sql2.=" where user_type='B' ";
    $sth2 = $conn->prepare($sql2);
    $sth2->execute();
    $sth2->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth2->fetch();
    $assigned_page=$row2['assigned_page'];

    $sql_ins ="insert into user_mas(user_name,user_id ";
    $sql_ins.=",password,cell_no,user_type,page_assign,orgn_id,bidder_id ) ";
    $sql_ins.="values( trim(upper(:user_name)),trim(:user_id),trim(:password) ";
    $sql_ins.=",trim(:cont_no1),'B',:assigned_page,'1',:bidder_id) ";

    $sthI = $conn->prepare($sql_ins);
    $sthI->bindParam(':user_name', $user_name);
    $sthI->bindParam(':user_id', $user_id);
    $sthI->bindParam(':password', $password);
    $sthI->bindParam(':cont_no1', $cont_no1);
    $sthI->bindParam(':assigned_page', $assigned_page);
    $sthI->bindParam(':bidder_id', $bidder_id);
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
    }catch(Exception $e)
    {
        echo $e-getMessage();
    }
}
?>

<?php
$conn=null;
?>