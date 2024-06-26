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
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $mobile_no= isset($_POST['mobile_no'])? $_POST['mobile_no']: '';

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
    $motp=generateRandomString();

    $sql=" update reg_otp_mas set status='D'  ";
    $sql.="  where email_id=:user_id ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':user_id', $user_id);
    $sth->execute();

    $sql=" insert into reg_otp_mas (email_id,otp,mobile_no,motp,otp_time ";
    $sql.=" ) values ( ";
    $sql.=" :user_id,:otp,:mobile_no,:motp,current_timestamp) ";
   // echo $sql;
    $sth = $conn->prepare($sql);
    $sth->bindParam(':user_id', $user_id);
    $sth->bindParam(':otp', $otp);
    $sth->bindParam(':mobile_no', $mobile_no);
    $sth->bindParam(':motp', $motp);
    $sth->execute();
    $otp_id=$conn->lastInsertId();

    $template='1707171394925971073';
    $message="Your one-time passcode (OTP) is $motp for Private Tea Sale System. Andrew Yule & Company Limited, Kolkata";

    send_sms($mobile_no,$message,$template);
    file_get_contents('https://privatesale.andrewyule.in/mail/register/send/'.$otp_id);
    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
    alertify.alert("OTP Send to Your eMail. Please check inbox and spam folder too.");
    </script>
    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Email OTP  *"  autocomplete="off" name="otp" id="otp" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Mobile OTP  *"  autocomplete="off" name="motp" id="motp" >
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
            var mobile_no = $('#mobile_no').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
            if (mobile_no.length != 10) {
                alert('Please input Valid Mobile No');
                $('#mobile_no').focus();
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
                    mobile_no: mobile_no,
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
            var mobile_no = $('#mobile_no').val();
            var motp = $('#motp').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
            if (mobile_no.length != 10) {
                alert('Please input Valid Mobile No');
                $('#mobile_no').focus();
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
                    user_name: user_name,
                    user_id:user_id,
                    mobile_no:mobile_no,
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
if(($tag=="OTPV"))
{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $otp= isset($_POST['otp'])? $_POST['otp']: '';
    $mobile_no= isset($_POST['mobile_no'])? $_POST['mobile_no']: '';
    $motp= isset($_POST['motp'])? $_POST['motp']: '';

    $sql=" select otp_id from reg_otp_mas  ";
    $sql.="  where otp=:otp and  email_id=:user_id and motp=:motp and  mobile_no=:mobile_no and status='A' ";
   // echo "$sql--$otp--$email_id";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':otp', $otp);
    $sth->bindParam(':user_id', $user_id);
    $sth->bindParam(':motp', $motp);
    $sth->bindParam(':mobile_no', $mobile_no);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    if($row2!=null):
    ?>
        <div class="form-group has-feedback">
            <textarea name="addr" id="addr"  autocomplete="off" class="form-control" rows="3" placeholder="Address *"></textarea>
        </div>
        <div class="form-group has-feedback">
            <select class="form-control select2" name="state_code"  id="state_code">
                <option value=""> State  *</option>
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
            <input type="text" name="pin" id="pin"  autocomplete="off" maxlength="6" class="form-control" placeholder="PIN *">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="pan_no" id="pan_no"  autocomplete="off" maxlength="10" class="form-control" placeholder="Pan No *">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="gst_no" id="gst_no"  autocomplete="off" maxlength="15" class="form-control" placeholder="GST No">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="cont_no2" id="cont_no2"  autocomplete="off" maxlength="10" class="form-control" placeholder="Alternative Mobile No">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <select class="form-control select2" name="bid_type"  id="bid_type">
                <option value="">Bidder Type  *</option>
                <option value="V">Vendor</option>
                <option value="A">Agent</option>
            </select>
        </div>
        <div id="bid_div">
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control"  autocomplete="off" placeholder="Password  *" name="password" id="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control"  autocomplete="off" placeholder="Retype password  *"  name="repassword" id="repassword">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
			<div class="col-xs-12">
				<input type="button" name="register" id="register" value="Register"  class="btn btn-success btn-block btn-flat">
			</div>
		</div>
       <script>
        $('.select2').select2()
        $('#user_id').prop('readonly', true);
        $('#mobile_no').prop('readonly', true);
        $("#bid_type").change(function() 
        {
            var bid_type = $('#bid_type').val();
            if (bid_type == "") {
                alert('Please select Bidder Type');
                $('#bid_type').focus();
                return false;
            }  
            
            var request = $.ajax({
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    bid_type: bid_type,
                    tag: 'TYPE-CHANGE'
                },
                dataType: "html",
                success: function(msg) {
                    $("#bid_div").html(msg);           
                }
            });
        });
        $("#register").click(function() 
        {
            var user_name = $('#user_name').val();
            var user_id = $('#user_id').val();
            var addr = $('#addr').val();
            var state_code = $('#state_code').val();
            var pin = $('#pin').val();
            var pan_no = $('#pan_no').val();
            var gst_no = $('#gst_no').val();
            var mobile_no = $('#mobile_no').val();
            var cont_no2 = $('#cont_no2').val();
            var bid_type = $('#bid_type').val();
            
            var password = $('#password').val();
            var repassword = $('#repassword').val();
            var biiling_nm = $('#biiling_nm').val();
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
            if (mobile_no.length != 10) {
                alert('Please input Valid Mobile No');
                $('#mobile_no').focus();
                return false;
            } 
            if (addr == "") {
                alert('Please input Address');
                $('#addr').focus();
                return false;
            } 
            if (state_code == "") {
                alert('Please Select State Code');
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
              
            if (cont_no2 != "") {
                if (mobile_no.length != 10) {
                    alert('Please input Valid Mobile No');
                    $('#mobile_no').focus();
                    return false;
                } 
            }  
            if (bid_type == "") {
                alert('Please select Bidder Type');
                $('#bid_type').focus();
                return false;
            } 
            if(bid_type=='A')  
            {

                var no_vendor = $('#no_vendor').val();
                if (no_vendor == "") {
                    alert('Please input No Vendor');
                    $('#no_vendor').focus();
                    return false;
                }
                if(parseFloat(no_vendor)>0)
                {
                    for (let i = 1; i <= parseFloat(no_vendor); i++) {

                        var biiling_nm = $('#biiling_nm'+i).val();
                        var legal_letter = $('#legal_letter'+i).val();

                        if (biiling_nm == "") {
                            alert('Please input Business Name');
                            $('#biiling_nm'+i).focus();
                            return false;
                        }  
                        if (legal_letter == "") {
                            alert('Please input Legal Letter');
                            $('#legal_letter'+i).focus();
                            return false;
                        } 
                    }

                }

                
            }
            else
            {
                if (biiling_nm == "") {
                    alert('Please input Business Name');
                    $('#biiling_nm').focus();
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
                    alertify.error('Password and Retype password does not match');
                    $('#repassword').focus();
                    return false;
                }

            }
            var formData = new FormData(document.getElementById("form1"));
            $("#loading").addClass('overlay');
            $("#loading").html('<i class="fa fa-spinner fa-pulse"></i>');
            var request = $.ajax({
                url: "./back/register-back.php",
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
            <input type="text" class="form-control"  autocomplete="off" placeholder="Email OTP  *" name="otp" id="otp" value="<?php echo $otp; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control"  autocomplete="off" placeholder="Mobile OTP  *" name="motp" id="motp" value="<?php echo $motp; ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-12 margin-bottom">
                <input type="button" name="verify_otp" id="verify_otp" value="Verify OTP "  class="btn btn-success btn-block btn-flat">
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
            var mobile_no = $('#mobile_no').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
            if (mobile_no.length != 10) {
                alert('Please input Valid Mobile No');
                $('#mobile_no').focus();
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
                    mobile_no: mobile_no,
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
            var mobile_no = $('#mobile_no').val();
            var motp = $('#motp').val();
            if (user_name == "") {
                alert('Please input User Name');
                $('#user_name').focus();
                return false;
            }  
            if (mobile_no.length != 10) {
                alert('Please input Valid Mobile No');
                $('#mobile_no').focus();
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
                    user_name: user_name,
                    user_id:user_id,
                    mobile_no:mobile_no,
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
if(($tag=="TYPE-CHANGE"))
{
    $bid_type= isset($_POST['bid_type'])? $_POST['bid_type']: '';
    if($bid_type=='A')
    {
        ?>
        
        <div class="form-group has-feedback">
            <input type="text" class="form-control" autocomplete="off" placeholder="No of Vendor  *" name="no_vendor" id="no_vendor">
        </div>
        <div id="vendor_div">

        </div>
        <script>        
        $("#no_vendor").keyup(function() 
        {
            var no_vendor = $('#no_vendor').val();
            var request = $.ajax({
                url: "./back/register-back.php",
                method: "POST",
                data: {
                    no_vendor: no_vendor,
                    tag: 'VENDORV'
                },
                dataType: "html",
                success: function(msg) {
                    $("#vendor_div").html(msg);           
                }
            });        
        });        
        </script>
        <?php
    }
    else
    {
        ?>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" autocomplete="off" placeholder="Business Name  *" name="biiling_nm" id="biiling_nm">
        </div>
        <?php
    }

}
?>
<?php
if(($tag=="VENDORV"))
{
    $no_vendor= isset($_POST['no_vendor'])? $_POST['no_vendor']: '';
    if($no_vendor==''){ $no_vendor=0;}
    
    for($x=1; $x<=$no_vendor; $x++)
    {
        ?>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" autocomplete="off" placeholder="Business Name (<?php echo $x; ?>)  *" name="biiling_nm[<?php echo $x; ?>]" id="biiling_nm<?php echo $x; ?>">
        </div>
        <div class="form-group has-feedback">
            <input type="file" class="form-control" autocomplete="off" placeholder="Legal Letter (<?php echo $x; ?>)  *" name="legal_letter[<?php echo $x; ?>]" id="legal_letter<?php echo $x; ?>">
        </div>
        <?php
    }
}
?>
<?php
if(($tag1=="REGISTER"))
{
    try{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
    $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
    $addr= isset($_POST['addr'])? $_POST['addr']: '';
    $state_code= isset($_POST['state_code'])? $_POST['state_code']: '';
    $pin= isset($_POST['pin'])? $_POST['pin']: '';
    $pan_no= isset($_POST['pan_no'])? $_POST['pan_no']: '';
    $gst_no= isset($_POST['gst_no'])? $_POST['gst_no']: '';
    $mobile_no= isset($_POST['mobile_no'])? $_POST['mobile_no']: '';
    $bid_type= isset($_POST['bid_type'])? $_POST['bid_type']: '';
    $cont_no2= isset($_POST['cont_no2'])? $_POST['cont_no2']: '';
    $password2= isset($_POST['password'])? $_POST['password']: '';
    $biiling_nm= isset($_POST['biiling_nm'])? $_POST['biiling_nm']: '';

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
    $sql_ins.=",trim(:mobile_no),'B',:assigned_page,'1') ";

    $sthI = $conn->prepare($sql_ins);
    $sthI->bindParam(':user_name', $user_name);
    $sthI->bindParam(':user_id', $user_id);
    $sthI->bindParam(':password', $password);
    $sthI->bindParam(':mobile_no', $mobile_no);
    $sthI->bindParam(':assigned_page', $assigned_page);
    $sthI->execute();
    $uid=$conn->lastInsertId();

    if($bid_type=='A')
    {
        $no_vendor= isset($_POST['no_vendor'])? $_POST['no_vendor']: '';
        $legal_letter= isset($_FILES['legal_letter'])? $_FILES['legal_letter']: '';

        $uploaddir="../legal/";
        for($n=1; $n<=$no_vendor; $n++)
        {
            $legal_path=null;
            if(!empty($legal_letter['name'][$n]))
            {
                $file_f1=$uploaddir.fileCkecking_legal($legal_letter,$n);;
                $legal_path=substr($file_f1,3);
            };
            $sql_ins ="insert into bidder_mas(name,addr,state_code ";
            $sql_ins.=",pin,pan_no,gst_no,cont_no1,cont_no2,email_id,bidder_type,billing_nm,legal_letter,uid,status) ";
            $sql_ins.="values( trim(upper(:user_name)),trim(upper(:addr)),:state_code,:pin ";
            $sql_ins.=",trim(upper(:pan_no)),trim(upper(:gst_no)),trim(:mobile_no),trim(:cont_no2),:user_id,";
            $sql_ins.=":bid_type,trim(upper(:biiling_nm)),:legal_path,:uid,'D') ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':user_name', $user_name);
            $sthI->bindParam(':addr', $addr);
            $sthI->bindParam(':state_code', $state_code);
            $sthI->bindParam(':pin', $pin);
            $sthI->bindParam(':pan_no', $pan_no);
            $sthI->bindParam(':gst_no', $gst_no);
            $sthI->bindParam(':mobile_no', $mobile_no);
            $sthI->bindParam(':cont_no2', $cont_no2);
            $sthI->bindParam(':user_id', $user_id);
            $sthI->bindParam(':bid_type', $bid_type);
            $sthI->bindParam(':biiling_nm', $biiling_nm[$n]);
            $sthI->bindParam(':legal_path', $legal_path);
            $sthI->bindParam(':uid', $uid);
            $sthI->execute();
            $bidder_id=$conn->lastInsertId();
        }
        
    }
    else
    {
        $sql_ins ="insert into bidder_mas(name,addr,state_code ";
        $sql_ins.=",pin,pan_no,gst_no,cont_no1,cont_no2,email_id,bidder_type,billing_nm,uid) ";
        $sql_ins.="values( trim(upper(:user_name)),trim(upper(:addr)),:state_code,:pin ";
        $sql_ins.=",trim(upper(:pan_no)),trim(upper(:gst_no)),trim(:mobile_no),trim(:cont_no2),:user_id,:bid_type,trim(upper(:biiling_nm)),:uid) ";
        $sthI = $conn->prepare($sql_ins);
        $sthI->bindParam(':user_name', $user_name);
        $sthI->bindParam(':addr', $addr);
        $sthI->bindParam(':state_code', $state_code);
        $sthI->bindParam(':pin', $pin);
        $sthI->bindParam(':pan_no', $pan_no);
        $sthI->bindParam(':gst_no', $gst_no);
        $sthI->bindParam(':mobile_no', $mobile_no);
        $sthI->bindParam(':cont_no2', $cont_no2);
        $sthI->bindParam(':user_id', $user_id);
        $sthI->bindParam(':bid_type', $bid_type);
        $sthI->bindParam(':biiling_nm', $biiling_nm);
        $sthI->bindParam(':uid', $uid);
        $sthI->execute();
        $bidder_id=$conn->lastInsertId();
    }
   
    

    
    $template='1707170609007653722';
    $message="Dear Sir/Ma'am, Thank you for registering yourself as a vendor/agent on the AYCL Private Sale Portal. We value your business and look forward to having a fruitful relationship with you. Regards, AYCL Marketing Team Andrew Yule & Company Limited, Kolkata";
    send_sms($mobile_no,$message,$template);
    file_get_contents('https://privatesale.andrewyule.in/mail/register/mailsend/'.$uid.'/'.$password2);
    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
        alertify.alert("Registration done Successfully.", function(){
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