<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';

?>
<?php
if(($tag=="YOUR-BID"))
{
	 $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
	 $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
	 $ses_bidder_id= test_input(isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '');
	 $bid_price= isset($_POST['bid_price'])? $_POST['bid_price']: '';
	 $acd_id= test_input(isset($_POST['acd_id'])? $_POST['acd_id']: '');
	 $auc_id = isset($_POST['auc_id']) ? $_POST['auc_id'] : '';


	 $sql=" select count(*) as log_count from user_mas ";
	 $sql.=" where uid=:hid_log_user and token=:token ";
	 $sth = $conn->prepare($sql);
	 $sth->bindParam(':token', $hid_token);
	 $sth->bindParam(':hid_log_user', $hid_log_user);
	 $sth->execute();
	 $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
	 $row = $sth->fetch();
	 $log_count=$row['log_count'];
	//echo "M ps:$m_ps   Blro: $m_blro";
	 if($log_count>0)
	 {
		

		$sql2=" select count(*) as user_count from auc_bid_dtl ";
		$sql2.=" where acd_id=:acd_id and auc_id=:auc_id and bidder_id=:ses_bidder_id and bid_price>=:bid_price  ";
		$sth2 = $conn->prepare($sql2);
		$sth2->bindParam(':acd_id', $acd_id);
		$sth2->bindParam(':auc_id', $auc_id);
		$sth2->bindParam(':ses_bidder_id', $ses_bidder_id);
		$sth2->bindParam(':bid_price', $bid_price);
		$sth2->execute();
		$sth2->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $sth2->fetch();
		$user_count=$row2['user_count'];
	
		if($user_count<=0)
		{
			try{
				$sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
				$sql_ins.=",bidder_id,bid_price,bid_time";
				$sql_ins.=" ) values(  ";
				$sql_ins.=" :auc_id,:acd_id,:ses_bidder_id,:bid_price,current_timestamp) ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->bindParam(':bid_price', $bid_price);
				$sthI->execute();
                ?>
                <script src="./js/alertify.min.js"></script>
                <link rel="stylesheet" href="./css/alertify.core.css" />
                <link rel="stylesheet" href="./css/alertify.default.css" />		
                <script>
                    alertify.alert("Bid Entry Successfully");
                </script> 
                <?php			
			}catch(PdoException $e){
				echo "ERROR: " . $e->getMessage();
			}
			
			
		}
        else
		{
			
			?>
            <script src="./js/alertify.min.js"></script>
            <link rel="stylesheet" href="./css/alertify.core.css" />
            <link rel="stylesheet" href="./css/alertify.default.css" />		
            <script>
                alertify.alert("Already Entered");
            </script> 
            <?php	
		}
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
    $sql2=" select max(bid_price) as bid_price from auc_bid_dtl ";
    $sql2.=" where acd_id=:acd_id   ";
    $sth2 = $conn->prepare($sql2);
    $sth2->bindParam(':acd_id', $acd_id);
    $sth2->execute();
    $sth2->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth2->fetch();
    $bid_price=$row2['bid_price'];
    echo $bid_price.'<input type="hidden"  id="max_bid_price'.$acd_id.'" value="'.$bid_price.'">';
}
?>

<?php
if(($tag=='HIS-BID'))
{
    $ses_bidder_id= isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '';
    $acd_id= isset($_POST['acd_id'])? $_POST['acd_id']: '';
    
	?>
    <script type="text/javascript">
            $('#modal-default<?php echo $acd_id; ?>').modal('show');
    </script>

    <div class="modal modal-default fade" id="modal-default<?php echo $acd_id; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Bid Details</h4>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped">
                        <tr>
                            <th>Bid Time</th>
                            <th>Bid Price</th>
                        </tr>
                        <?php
                        $sqle= "select bid_price,bid_time ";
                        $sqle.="from auc_bid_dtl ";
                        $sqle.="where acd_id=:acd_id ";
                        $sqle.=" and bidder_id=:ses_bidder_id ";
                      //  echo "$sqle $acd_id $ses_bidder_id";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                            $bid_time=$value['bid_time'];
                            $bid_price=$value['bid_price'];
                            ?>
                            <tr>
                                <th><?php  echo date("h:i A", strtotime($bid_time)); ?></th>
                                <th><?php echo $bid_price; ?></th>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline">Save changes</button>
                </div>
            </div>

        </div>

    </div>


    <?php

}
?>
<?php
$conn=null;
?>