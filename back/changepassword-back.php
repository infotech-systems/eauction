<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tz = (new DateTime('now', new DateTimeZone('Asia/Calcutta')))->format('P');
$conn->exec("SET time_zone='$tz';");

date_default_timezone_set("Asia/Calcutta");

$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
?>

<?php
if(($tag=='CHANGPWD'))
{
     $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
     $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
     $newpassword= isset($_POST['newpassword'])? $_POST['newpassword']: '';

     try{
        $sql=" select count(*) as log_count from user_mas ";
        $sql.=" where uid=:user_id and token=:token ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':token', $hid_token);
        $sth->bindParam(':user_id', $hid_log_user);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $log_count=$row['log_count'];
   // 	echo "Ct: $log_count--$hid_log_user--$hid_token";
        if($log_count>0)
        {
           // echo $newpassword;
            $password1=password_hash($newpassword,PASSWORD_BCRYPT);

            $sql_ins ="update user_mas set ";
            $sql_ins.="  password=:password1, token=null ";
            $sql_ins.=" where uid=:ses_uid ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':password1', $password1);
            $sthI->bindParam(':ses_uid', $hid_log_user);
            $sthI->execute();
           
            ?>
            <script src="./js/alertify.min.js"></script>
            <link rel="stylesheet" href="./css/alertify.core.css" />
            <link rel="stylesheet" href="./css/alertify.default.css" />
            <script>
            alertify.alert("User Password Changed Successfully.", function(){
                window.location.href='./login.php';
            });
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
                alertify.alert("unauthorised user access");
            </script>
            <?php
        }
    }catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
     }
     
}
?>
<?php
$conn=null;
?>