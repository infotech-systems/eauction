<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';

?>
<?php
if(($tag=="KNOCK-DOWN"))
{
    try
    {
        $auc_id= isset($_POST['auc_id'])? $_POST['auc_id']: '';
        $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
        $hid_token = isset($_POST['hid_token']) ? $_POST['hid_token'] : '';
        $max_bid_price = isset($_POST['max_bid_price']) ? $_POST['max_bid_price'] : '';
        $bidder = isset($_POST['bidder']) ? $_POST['bidder'] : '';
        $acd_id = isset($_POST['acd_id']) ? $_POST['acd_id'] : '';
       
        if($max_bid_price==''){ $max_bid_price=0;}
        if($bidder==''){ $bidder=0;}
        
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
			$sql=" select auc_start_time,auc_end_time,knockdown_start,knockdown_end,location ";
			$sql.=" ,payment_type,contract_type,offer_srl,offer_srl_id ";
            $sql.=" from auction_mas ";
            $sql.=" where auc_id=:auc_id ";
            $sth = $conn->prepare($sql);
            $sth->bindParam(':auc_id', $auc_id);
            $sth->execute();
            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetch();
            $auc_start_time=$row['auc_start_time'];
            $auc_end_time=$row['auc_end_time'];
            $knockdown_start=$row['knockdown_start'];
            $knockdown_end=$row['knockdown_end'];
            $location=$row['location'];
            $payment_type=$row['payment_type'];
            $contract_type=$row['contract_type'];
            $offer_srl=$row['offer_srl'];
            $offer_srl_id=$row['offer_srl_id'];

            $sql=" select jap_id,lot_no,garden_nm,grade,invoice_no ";
			$sql.=" ,gp_date,chest,net,pkgs,valu_kg,base_price,msp ";
            $sql.=" from auction_dtl ";
            $sql.=" where auc_id=:auc_id and acd_id=:acd_id ";
            $sth = $conn->prepare($sql);
            $sth->bindParam(':auc_id', $auc_id);
            $sth->bindParam(':acd_id', $acd_id);
            $sth->execute();
            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetch();
            $jap_id=$row['jap_id'];
            $lot_no=$row['lot_no'];
            $garden_nm=$row['garden_nm'];
            $grade=$row['grade'];
            $invoice_no=$row['invoice_no'];
            $gp_date=$row['gp_date'];
            $chest=$row['chest'];
            $net=$row['net'];
            $pkgs=$row['pkgs'];
            $valu_kg=$row['valu_kg'];
            $base_price=$row['base_price'];
            $msp=$row['msp'];
            
            $sql_ins =" insert into final_auction_dtl ( ";
            $sql_ins.=" auc_id,auc_start_time,auc_end_time,knockdown_start,knockdown_end,location ";
            $sql_ins.=" ,payment_type,contract_type,offer_srl,offer_srl_id,acd_id,jap_id,lot_no ";
            $sql_ins.=" ,garden_nm,grade,invoice_no,gp_date,chest,net,pkgs,valu_kg,base_price,msp ";
            $sql_ins.=" ,bid_price,bidder_id ";
            $sql_ins.=" ) values ( ";
            $sql_ins.=" :auc_id,:auc_start_time,:auc_end_time,:knockdown_start,:knockdown_end,:location ";
            $sql_ins.=" ,:payment_type,:contract_type,:offer_srl,:offer_srl_id,:acd_id,:jap_id,:lot_no ";
            $sql_ins.=" ,:garden_nm,:grade,:invoice_no,:gp_date,:chest,:net,:pkgs,:valu_kg,:base_price,:msp ";
            $sql_ins.=" ,:max_bid_price,:bidder ";
            $sql_ins.=" ) ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':auc_id', $auc_id);
            $sthI->bindParam(':auc_start_time', $auc_start_time);
            $sthI->bindParam(':auc_end_time', $auc_end_time);
            $sthI->bindParam(':knockdown_start', $knockdown_start);
            $sthI->bindParam(':knockdown_end', $knockdown_end);
            $sthI->bindParam(':location', $location);
            $sthI->bindParam(':payment_type', $payment_type);
            $sthI->bindParam(':contract_type', $contract_type);
            $sthI->bindParam(':offer_srl', $offer_srl);
            $sthI->bindParam(':offer_srl_id', $offer_srl_id);
            $sthI->bindParam(':jap_id', $jap_id);
            $sthI->bindParam(':lot_no', $lot_no);
            $sthI->bindParam(':garden_nm', $garden_nm);
            $sthI->bindParam(':grade', $grade);
            $sthI->bindParam(':invoice_no', $invoice_no);
            $sthI->bindParam(':gp_date', $gp_date);
            $sthI->bindParam(':chest', $chest);
            $sthI->bindParam(':net', $net);
            $sthI->bindParam(':pkgs', $pkgs);
            $sthI->bindParam(':valu_kg', $valu_kg);
            $sthI->bindParam(':base_price', $base_price);
            $sthI->bindParam(':msp', $msp);
            $sthI->bindParam(':max_bid_price', $max_bid_price);
            $sthI->bindParam(':bidder', $bidder);
            $sthI->bindParam(':acd_id', $acd_id);
            $sthI->execute();

            $sql_ins =" insert into fin_auc_bid_dtl (abd_id,auc_id,acd_id ";
            $sql_ins .=" ,bidder_id,bid_price,bid_time) SELECT abd_id,auc_id,acd_id ";
            $sql_ins .=" ,bidder_id,bid_price,bid_time FROM auc_bid_dtl where acd_id=:acd_id   ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':acd_id', $acd_id);
            $sthI->execute();

            $sql_ins =" delete from auction_dtl where auc_id=:auc_id and acd_id=:acd_id ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':auc_id', $auc_id);
            $sthI->bindParam(':acd_id', $acd_id);
            $sthI->execute();

            $sql_ins =" delete from auc_bid_dtl where acd_id=:acd_id ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':acd_id', $acd_id);
            $sthI->execute();
            ?>
            <script src="./js/alertify.min.js"></script>
            <link rel="stylesheet" href="./css/alertify.core.css" />
            <link rel="stylesheet" href="./css/alertify.default.css" />		
            <script>
            alertify.alert("Knock Down Successfully.", function(){
                window.open('knockdown-offersheet-bid.php?param=<?php echo md5($auc_id); ?>','_self');
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
        echo "<br>ERROR: " . $e->getLine();
    }
}
?>

<?php
$conn=null;
?>