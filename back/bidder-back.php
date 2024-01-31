<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';

?>
<?php
if(($tag=="MODIFI"))
{
    try
    {
        $hid_id= isset($_POST['hid_id'])? $_POST['hid_id']: '';
        $bidder_name= isset($_POST['bidder_name'])? $_POST['bidder_name']: '';
        $state= test_input(isset($_POST['state'])? $_POST['state']: '');
        $address= isset($_POST['address'])? $_POST['address']: '';
        $pin= test_input(isset($_POST['pin'])? $_POST['pin']: '');
        $pan_no = isset($_POST['pan_no']) ? $_POST['pan_no'] : '';
        $gst_no = isset($_POST['gst_no']) ? $_POST['gst_no'] : '';
        $cont_no1 = isset($_POST['cont_no1']) ? $_POST['cont_no1'] : '';
        $cont_no2 = isset($_POST['cont_no2']) ? $_POST['cont_no2'] : '';
        $email_id = isset($_POST['email_id']) ? $_POST['email_id'] : '';
        $bidder_type = isset($_POST['bidder_type']) ? $_POST['bidder_type'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $hid_log_user = isset($_POST['hid_log_user']) ? $_POST['hid_log_user'] : '';
        $hid_token = isset($_POST['hid_token']) ? $_POST['hid_token'] : '';
        $billing_nm = isset($_POST['billing_nm']) ? $_POST['billing_nm'] : '';
        if($bidder_type=='A')
        {
            $uploaddir="../legal/";
            $legal_letter= isset($_FILES['legal_letter'])? $_FILES['legal_letter']: '';
            if(!empty($legal_letter['name'][0]))
            {
                $file_f1=$uploaddir.fileCkecking_legal($legal_letter,0);;
                $legal_path=substr($file_f1,3);
            }
        }
        else
        {
            $legal_path=null;
        }

        $sql=" select count(*) as log_count from user_mas ";
        $sql.=" where uid=:hid_log_user and token=:token ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':token', $hid_token);
        $sth->bindParam(':hid_log_user', $hid_log_user);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $log_count=$row['log_count'];
        if($log_count>0)
        {
			
            $sql_ins =" update bidder_mas set name=trim(upper(:bidder_name)) ";
            $sql_ins.=" ,addr=trim(upper(:address)),state_code=:state,pin=:pin ";
            $sql_ins.=" ,pan_no=trim(upper(:pan_no)),gst_no=trim(upper(:gst_no))  ";
            $sql_ins.=" ,cont_no1=trim(:cont_no1),cont_no2=trim(:cont_no2),email_id=:email_id ";
            $sql_ins.=" ,bidder_type=:bidder_type,status=:status,billing_nm=trim(upper(:billing_nm)) ";
            if(strlen($legal_path)>5)
            {
                $sql_ins.=" ,legal_letter=:legal_path ";
            }
            $sql_ins.=" where bidder_id=:hid_id ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':hid_id', $hid_id);
            $sthI->bindParam(':bidder_name', $bidder_name);
            $sthI->bindParam(':address', $address);
            $sthI->bindParam(':state', $state);
            $sthI->bindParam(':pin', $pin);
            $sthI->bindParam(':pan_no', $pan_no);
            $sthI->bindParam(':gst_no', $gst_no);
            $sthI->bindParam(':cont_no1', $cont_no1);
            $sthI->bindParam(':cont_no2', $cont_no2);
            $sthI->bindParam(':email_id', $email_id);
            $sthI->bindParam(':bidder_type', $bidder_type);
            $sthI->bindParam(':billing_nm', $billing_nm);
            if(strlen($legal_path)>5)
            {
                $sthI->bindParam(':legal_path', $legal_path);
            }
            $sthI->bindParam(':status', $status);
            $sthI->execute();

            $sql_ins =" update user_mas set user_name=trim(upper(:bidder_name)) ";
            $sql_ins.=" ,cell_no=trim(:cont_no1),status=:status,user_id=trim(:email_id) ";
            $sql_ins.=" where bidder_id=:hid_id ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':hid_id', $hid_id);
            $sthI->bindParam(':bidder_name', $bidder_name);
            $sthI->bindParam(':cont_no1', $cont_no1);
            $sthI->bindParam(':email_id', $email_id);
            $sthI->bindParam(':status', $status);
            $sthI->execute();
            ?>
            <script src="./js/alertify.min.js"></script>
            <link rel="stylesheet" href="./css/alertify.core.css" />
            <link rel="stylesheet" href="./css/alertify.default.css" />		
            <script>
            alertify.alert("Bidder Modified.", function(){
                window.location.href='./bidder-master.php';
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
                alertify.alert("Unauthorized access");
            </script> 
            <?php	
        }
    }
    catch(PdoException $e)
    {
        echo "ERROR: " . $e->getMessage();
    }
}
?>

<?php
$conn=null;
?>