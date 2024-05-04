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
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';

    $sql=" select cell_no from user_mas  ";
    $sql.="  where uid=:hid_log_user ";
   // echo "$sql--$otp--$email_id";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':hid_log_user', $hid_log_user);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    $cell_no=$row2['cell_no'];
    
    if(strlen($cell_no)!=10):
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />
        <script>
        alertify.alert("Invalid Mobile No., Please Contact System Administrator");
        </script>
        <?php
    else:
        $otp=generateRandomString();

        $sql=" update user_mas set otp=:otp  ";
        $sql.="  where uid=:hid_log_user ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':hid_log_user', $hid_log_user);
        $sth->bindParam(':otp', $otp);
        $sth->execute();

        $template='1707171394925971073';
        $message="Your one-time passcode (OTP) is $otp for Private Tea Sale System. Andrew Yule & Company Limited, Kolkata";

        send_sms($cell_no,$message,$template);
    ?>
    <script src="./js/alertify.min.js"></script>
    <link rel="stylesheet" href="./css/alertify.core.css" />
    <link rel="stylesheet" href="./css/alertify.default.css" />
    <script>
    alertify.alert("OTP Send to Your Register Mobile No.");
    </script>
    <div class="box-body">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user_name" class="col-sm-4" >OTP</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="otp" name="otp" value=""   placeholder="Enter OTP" required tabindex="1">
                        <div class="input-group-addon" id="send_otp">
                            <i class="fa fa-refresh"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user_name" class="col-sm-4" >Status</label>
                <div class="col-sm-8">
                    <select class="form-control select2" name="approve" id="approve" tabindex="3">
                        <option value="">--Select--</option>
                        <option value="Y">Approve</option>
                        <option value="R">Reject</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">        
        <input type="button" name="submit" id="submit" class="btn btn-primary pull-right" tabindex="12" value="Send OTP">
    </div>
    <script>
        $("#send_otp").click(function() 
        {
            var hid_log_user = $('#hid_log_user').val();

            var request = $.ajax({
                url: "./back/bidder-update-back.php",
                method: "POST",
                data: {
                    hid_log_user: hid_log_user,
                    tag: 'OTP'
                },
                dataType: "html",
                success: function(msg) {
                    $("#div_sub").html(msg);           
                }
            });
        
        });
        $("#submit").click(function() 
        {
            var hid_log_user = $('#hid_log_user').val();
            var hid_id = $('#hid_id').val();
            var otp = $('#otp').val();
            var approve = $('#approve').val();
            if (otp == "") {
                alert('Please input OTP');
                $('#otp').focus();
                return false;
            }  
            
            if (approve == "") {
                alert('Please input Approve');
                $('#approve').focus();
                return false;
            } 
           
            var request = $.ajax({
                url: "./back/bidder-update-back.php",
                method: "POST",
                data: {
                    hid_log_user: hid_log_user,
                    hid_id:hid_id,
                    otp:otp,
                    approve:approve,
                    tag: 'UP-STATUS'
                },
                dataType: "html",
                success: function(msg) {
                    $("#validity_label").html(msg);           
                }
            });
        
        });
        
        </script>
    <?php
    endif;
}
?>
<?php
if(($tag=="UP-STATUS"))
{
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $hid_id= isset($_POST['hid_id'])? $_POST['hid_id']: '';
    $otp= isset($_POST['otp'])? $_POST['otp']: '';
    $approve= isset($_POST['approve'])? $_POST['approve']: '';

    $sql=" select uid from user_mas  ";
    $sql.="  where otp=:otp and  uid=:hid_log_user ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':otp', $otp);
    $sth->bindParam(':hid_log_user', $hid_log_user);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    if($row2!=null):
        $sql=" update bidder_mas set letter_approve=:approve,approve_by=:hid_log_user,approve_on=current_timestamp  ";
        if($approve=='Y')
        {
            $sql.="  ,status='A' ";
        }
        $sql.="  where bidder_id=:hid_id ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':hid_log_user', $hid_log_user);
        $sth->bindParam(':approve', $approve);
        $sth->bindParam(':hid_id', $hid_id);
        $sth->execute();
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />
        <script>
            alertify.alert("LOI verification done Successfully.", function(){
                window.location.href='./loi-verification.php';
            });          
        </script> 
        <?php
    else:
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />
        <script>
            alertify.alert("Pl. input valid OTP.");          
        </script> 
        <?php
    endif;
}
?>

<?php
$conn=null;
?>