<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';

?>
<?php
if(($tag=='OTP'))
{
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $sql=" select uid,cell_no from user_mas  ";
    $sql.="  where uid=:hid_log_user ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':hid_log_user', $hid_log_user);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    $user_count=$row2['uid'];
    $cell_no=$row2['cell_no'];

    if($row2!=null):
        if(strlen($cell_no)==10)
        {
            $otp=generateRandomString();
        
            $sql=" update user_mas set otp=:otp  ";
            $sql.="  where uid=:hid_log_user ";

           // echo "$sql $hid_log_user";
            $sth = $conn->prepare($sql);
            $sth->bindParam(':otp', $otp);
            $sth->bindParam(':hid_log_user', $hid_log_user);
            $sth->execute();
        

            $template='1707171394925971073';
            $message="Your one-time passcode (OTP) is $otp for Private Tea Sale System. Andrew Yule & Company Limited, Kolkata";
            send_sms($cell_no,$message,$template);

            ?>
            <script src="./js/alertify.min.js"></script>
            <link rel="stylesheet" href="./css/alertify.core.css" />
            <link rel="stylesheet" href="./css/alertify.default.css" />
                
            <script>
                alertify.alert("OTP send to your mobile no.");           
            </script> 
            <?php
        }
        else
        {
            ?>
            <script src="./js/alertify.min.js"></script>
            <link rel="stylesheet" href="./css/alertify.core.css" />
            <link rel="stylesheet" href="./css/alertify.default.css" />
                
            <script>
                alertify.alert("Mobile no not registered.");           
            </script> 
            <?php 
        }
    endif;
}
?>

<?php
$conn=null;
?>