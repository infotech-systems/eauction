<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';

if(($tag=="CHANGE-BID"))
{
   //  include('../autobid1.php');
    $auc_id= isset($_POST['auc_id'])? $_POST['auc_id']: '';
    $ses_bidder_id= isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '';
    $bid_price=array();
    $self_price=array();
    $sqle= "select max(bid_price) as bid_price,acd_id ";
    $sqle.="from auc_bid_dtl ";
    $sqle.="where auc_id=:auc_id group by acd_id ";
    $sth = $conn->prepare($sqle);
    $sth->bindParam(':auc_id', $auc_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sth->fetchAll();
    foreach ($row as $key => $value) 
    {
        $acd_id=$value['acd_id'];
        $bid_price[$acd_id]=$value['bid_price'];
    }
    $sqle= "select max(bid_price) as self_bid_price,acd_id ";
    $sqle.="from auc_bid_dtl ";
    $sqle.="where auc_id=:auc_id  and bidder_id=:ses_bidder_id group by acd_id ";
    $sth = $conn->prepare($sqle);
    $sth->bindParam(':auc_id', $auc_id);
    $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sth->fetchAll();
    foreach ($row as $key => $value) 
    {
        $acd_id=$value['acd_id'];
        $self_bid_price[$acd_id]=$value['self_bid_price'];
    }
    $ss=array(
        'bid_price'=>$bid_price,   
        'self_bid_price'=>$self_bid_price,   
    );
    $sss=json_encode($ss);
    echo $sss;
    
   
}
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

                $filename = '../autobid/'.$acd_id.'.txt';
                $fp = fopen($filename,"wb");
                fwrite($fp,$acd_id);
                fclose($fp);
                //include('../autobid1.php');

                /**************************** auto bid start */

                $sql2=" select max(autbid_maxprice) as autbid_maxprice from autobid_mas ";
                $sql2.=" where acd_id=:acd_id and autbid_maxprice> :bid_price  ";
                $sth2 = $conn->prepare($sql2);
                $sth2->bindParam(':acd_id', $acd_id);
                $sth2->bindParam(':bid_price', $bid_price);
                $sth2->execute();
                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                $row2 = $sth2->fetch();
                $autbid_maxprice=$row2['autbid_maxprice'];

                for($x=$bid_price; $x<=$autbid_maxprice; $x++)
                {
                    $sqle= "select ab.bidder_id,ab.auc_id,ab.acd_id,ab.autobid_price,ab.autbid_maxprice ";
                    $sqle.="from autobid_mas ab,auction_mas a WHERE ab.acd_id=:acd_id and ab.auc_id=a.auc_id ";
                    $sqle.=" and auc_start_time<=current_timestamp and auc_end_time>=current_timestamp order by ab.auto_id ";
                  //  echo "$sqle $acd_id";
                    $sth = $conn->prepare($sqle);
                    $sth->bindParam(':acd_id', $acd_id);
                    $sth->execute();
                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $sth->fetchAll();
                   // print_r($row);
                    foreach ($row as $key => $value) 
                    {
                        $e_bidder_id=$value['bidder_id'];
                        $e_auc_id=$value['auc_id'];
                        $e_autobid_price=$value['autobid_price'];
                        $e_autbid_maxprice=$value['autbid_maxprice'];

                        $sqle= "select max(bid_price) as max_abidder,bidder_id ";
                        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetch();
                        $e_max_abidder=$row['max_abidder'];

                        $sqle= "select bidder_id ";
                        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id and bid_price=:e_max_abidder ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->bindParam(':e_max_abidder', $e_max_abidder);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetch();
                        $e_mbidder_id=$row['bidder_id'];

                        $ab=$e_autobid_price+$e_max_abidder;
                        if(($ab<=$e_autbid_maxprice) and ($e_bidder_id!=$e_mbidder_id))
                        {
                            $sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
                            $sql_ins.=",bidder_id,bid_price,bid_time";
                            $sql_ins.=" ) values(  ";
                            $sql_ins.=" :e_auc_id,:acd_id,:e_bidder_id,:ab,current_timestamp) ";
                            $sthI = $conn->prepare($sql_ins);
                            $sthI->bindParam(':e_auc_id', $e_auc_id);
                            $sthI->bindParam(':acd_id', $acd_id);
                            $sthI->bindParam(':e_bidder_id', $e_bidder_id);
                            $sthI->bindParam(':ab', $ab);
                            $sthI->execute();
                        }
                    }
                }         
            



                /************************** auto bid end */


                ?>
                <script src="./js/alertify.min.js"></script>
                <link rel="stylesheet" href="./css/alertify.core.css" />
                <link rel="stylesheet" href="./css/alertify.default.css" />		
                <script>
                   // alertify.alert("Bid Entry Successfully");
                </script> 
                <?php			
			}catch(PdoException $e){
				echo "ERROR: " . $e->getMessage();
				echo "ERROR: " . $e->getLine();
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
                    //    $sqle.=" and bidder_id=:ses_bidder_id ";
                      //  echo "$sqle $acd_id $ses_bidder_id";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                  //      $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
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
if(($tag=="YOUR-AUTOBID"))
{
	 $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
	 $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
	 $ses_bidder_id= test_input(isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '');
	 $autobid_price= isset($_POST['autobid_price'])? $_POST['autobid_price']: '';
	 $autbid_maxprice= isset($_POST['autbid_maxprice'])? $_POST['autbid_maxprice']: '';
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
		

		$sql2=" select count(*) as user_count,auto_id from autobid_mas ";
		$sql2.=" where acd_id=:acd_id and auc_id=:auc_id and bidder_id=:ses_bidder_id ";
		$sth2 = $conn->prepare($sql2);
		$sth2->bindParam(':acd_id', $acd_id);
		$sth2->bindParam(':auc_id', $auc_id);
		$sth2->bindParam(':ses_bidder_id', $ses_bidder_id);
		$sth2->execute();
		$sth2->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $sth2->fetch();
		$user_count=$row2['user_count'];
		$auto_id=$row2['auto_id'];
		if($user_count<=0)
		{
			try
            {
				$sql_ins ="insert into autobid_mas(auc_id,acd_id ";
				$sql_ins.=",bidder_id,autobid_price,autbid_maxprice,autobid_on";
				$sql_ins.=" ) values(  ";
				$sql_ins.=" :auc_id,:acd_id,:ses_bidder_id,:autobid_price,:autbid_maxprice,current_timestamp) ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->bindParam(':autobid_price', $autobid_price);
				$sthI->bindParam(':autbid_maxprice', $autbid_maxprice);
				$sthI->execute();
                $auto_id=$conn->lastInsertId();

                $sql_ins ="insert into autobid_dtl(auto_id,auc_id,acd_id ";
				$sql_ins.=",bidder_id,autobid_price,autbid_maxprice,autobid_on";
				$sql_ins.=" ) values(  ";
				$sql_ins.=" :auto_id,:auc_id,:acd_id,:ses_bidder_id,:autobid_price,:autbid_maxprice,current_timestamp) ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auto_id', $auto_id);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->bindParam(':autobid_price', $autobid_price);
				$sthI->bindParam(':autbid_maxprice', $autbid_maxprice);
				$sthI->execute();

                $filename = '../autobid/'.$acd_id.'.txt';
                $fp = fopen($filename,"wb");
                fwrite($fp,$acd_id);
                fclose($fp);
                
                //--------------------- Auto BID
                
                try{
                /**************************** auto bid start */
                $sqle= "select max(bid_price) as bid_price ";
                $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";

                $sth = $conn->prepare($sqle);
                $sth->bindParam(':acd_id', $acd_id);
                $sth->execute();
                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                $row = $sth->fetch();
                if($row['bid_price']>0)
                {
                    $bid_price=$row['bid_price'];
                }
                else
                {
                    $sqle= "select base_price as bid_price ";
                    $sqle.="from auction_dtl WHERE acd_id=:acd_id ";
                    $sth = $conn->prepare($sqle);
                    $sth->bindParam(':acd_id', $acd_id);
                    $sth->execute();
                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $sth->fetch();  
                    $bid_price=$row['bid_price'];
                }

                $sql2=" select max(autbid_maxprice) as autbid_maxprice  from autobid_mas ";
                $sql2.=" where acd_id=:acd_id and autbid_maxprice> :bid_price  ";
                $sth2 = $conn->prepare($sql2);
                $sth2->bindParam(':acd_id', $acd_id);
                $sth2->bindParam(':bid_price', $bid_price);
                $sth2->execute();
                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                $row2 = $sth2->fetch();
                $autbid_maxprice=$row2['autbid_maxprice'];
                for($x=$bid_price; $x<=$autbid_maxprice; $x++)
                {
                    $sqle= "select ab.bidder_id,ab.auc_id,ab.acd_id,ab.autobid_price,ab.autbid_maxprice ";
                    $sqle.="from autobid_mas ab,auction_mas a WHERE ab.acd_id=:acd_id and ab.auc_id=a.auc_id ";
                    $sqle.=" and auc_start_time<=current_timestamp and auc_end_time>=current_timestamp order by ab.auto_id ";
                  //  echo "$sqle $acd_id";
                    $sth = $conn->prepare($sqle);
                    $sth->bindParam(':acd_id', $acd_id);
                    $sth->execute();
                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $sth->fetchAll();
                   // print_r($row);
                    foreach ($row as $key => $value) 
                    {
                        $e_bidder_id=$value['bidder_id'];
                        $e_auc_id=$value['auc_id'];
                        $e_autobid_price=$value['autobid_price'];
                        $e_autbid_maxprice=$value['autbid_maxprice'];

                        $sqle= "select max(bid_price) as max_abidder,bidder_id ";
                        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetch();
                        
                        if($row['max_abidder']>0)
                        {
                            $e_max_abidder=$row['max_abidder'];
                        }
                        else
                        {
                            $sqle= "select base_price as max_abidder ";
                            $sqle.="from auction_dtl WHERE acd_id=:acd_id ";
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':acd_id', $acd_id);
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetch();  
                            $e_max_abidder=$row['max_abidder'];
                        }

                        //echo $e_max_abidder;
                        $sqle= "select bidder_id ";
                        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id and bid_price=:e_max_abidder ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->bindParam(':e_max_abidder', $e_max_abidder);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetch();
                        if($row)
                        {
                            $e_mbidder_id=$row['bidder_id'];
                        }
                        else
                        {
                            $e_mbidder_id=0; 
                        }

                        $ab=$e_autobid_price+$e_max_abidder;
                        if(($ab<=$e_autbid_maxprice) and ($e_bidder_id!=$e_mbidder_id))
                        {
                            $sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
                            $sql_ins.=",bidder_id,bid_price,bid_time";
                            $sql_ins.=" ) values(  ";
                            $sql_ins.=" :e_auc_id,:acd_id,:e_bidder_id,:ab,current_timestamp) ";
                            $sthI = $conn->prepare($sql_ins);
                            $sthI->bindParam(':e_auc_id', $e_auc_id);
                            $sthI->bindParam(':acd_id', $acd_id);
                            $sthI->bindParam(':e_bidder_id', $e_bidder_id);
                            $sthI->bindParam(':ab', $ab);
                            $sthI->execute();
                        }
                    }
                }         
            



                /************************** auto bid end */
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                }

                
                
                
                
                
                ?>
                <script src="./js/alertify.min.js"></script>
                <link rel="stylesheet" href="./css/alertify.core.css" />
                <link rel="stylesheet" href="./css/alertify.default.css" />		
                <script>
                    alertify.alert("Auto Bid Entry Successfully");
                </script> 
                <?php			
			}catch(PdoException $e){
				echo "ERROR: " . $e->getMessage();
			}
			
			
		}
        else
		{
			
			try
            {
				$sql_ins ="update autobid_mas set ";
				$sql_ins.=" autobid_price=:autobid_price,autbid_maxprice=:autbid_maxprice,update_on=current_timestamp";
				$sql_ins.=" where acd_id=:acd_id and auc_id=:auc_id and bidder_id=:ses_bidder_id  ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->bindParam(':autobid_price', $autobid_price);
				$sthI->bindParam(':autbid_maxprice', $autbid_maxprice);
				$sthI->execute();

                $sql_ins ="insert into autobid_dtl(auto_id,auc_id,acd_id ";
				$sql_ins.=",bidder_id,autobid_price,autbid_maxprice,autobid_on";
				$sql_ins.=" ) values(  ";
				$sql_ins.=" :auto_id,:auc_id,:acd_id,:ses_bidder_id,:autobid_price,:autbid_maxprice,current_timestamp) ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auto_id', $auto_id);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->bindParam(':autobid_price', $autobid_price);
				$sthI->bindParam(':autbid_maxprice', $autbid_maxprice);
				$sthI->execute();
                $filename = '../autobid/'.$acd_id.'.txt';
                $fp = fopen($filename,"wb");
                fwrite($fp,$acd_id);
                fclose($fp);

                
                    /**************************** auto bid start */
                    $sqle= "select max(bid_price) as bid_price ";
                    $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";
    
                    $sth = $conn->prepare($sqle);
                    $sth->bindParam(':acd_id', $acd_id);
                    $sth->execute();
                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $sth->fetch();
                    if($row['bid_price']>0)
                    {
                        $bid_price=$row['bid_price'];
                    }
                    else
                    {
                        $sqle= "select base_price as bid_price ";
                        $sqle.="from auction_dtl WHERE acd_id=:acd_id ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetch();  
                        $bid_price=$row['bid_price'];
                    }
    
                    $sql2=" select max(autbid_maxprice) as autbid_maxprice  from autobid_mas ";
                    $sql2.=" where acd_id=:acd_id and autbid_maxprice> :bid_price  ";
                    $sth2 = $conn->prepare($sql2);
                    $sth2->bindParam(':acd_id', $acd_id);
                    $sth2->bindParam(':bid_price', $bid_price);
                    $sth2->execute();
                    $sth2->setFetchMode(PDO::FETCH_ASSOC);
                    $row2 = $sth2->fetch();
                    $autbid_maxprice=$row2['autbid_maxprice'];
                    for($x=$bid_price; $x<=$autbid_maxprice; $x++)
                    {
                        $sqle= "select ab.bidder_id,ab.auc_id,ab.acd_id,ab.autobid_price,ab.autbid_maxprice ";
                        $sqle.="from autobid_mas ab,auction_mas a WHERE ab.acd_id=:acd_id and ab.auc_id=a.auc_id ";
                        $sqle.=" and auc_start_time<=current_timestamp and auc_end_time>=current_timestamp order by ab.auto_id ";
                      //  echo "$sqle $acd_id";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                       // print_r($row);
                        foreach ($row as $key => $value) 
                        {
                            $e_bidder_id=$value['bidder_id'];
                            $e_auc_id=$value['auc_id'];
                            $e_autobid_price=$value['autobid_price'];
                            $e_autbid_maxprice=$value['autbid_maxprice'];
    
                            $sqle= "select max(bid_price) as max_abidder,bidder_id ";
                            $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':acd_id', $acd_id);
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetch();
                            
                            if($row['max_abidder']>0)
                            {
                                $e_max_abidder=$row['max_abidder'];
                            }
                            else
                            {
                                $sqle= "select base_price as max_abidder ";
                                $sqle.="from auction_dtl WHERE acd_id=:acd_id ";
                                $sth = $conn->prepare($sqle);
                                $sth->bindParam(':acd_id', $acd_id);
                                $sth->execute();
                                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                $row = $sth->fetch();  
                                $e_max_abidder=$row['max_abidder'];
                            }
    
                            //echo $e_max_abidder;
                            $sqle= "select bidder_id ";
                            $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id and bid_price=:e_max_abidder ";
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':acd_id', $acd_id);
                            $sth->bindParam(':e_max_abidder', $e_max_abidder);
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetch();
                            if($row)
                            {
                                $e_mbidder_id=$row['bidder_id'];
                            }
                            else
                            {
                                $e_mbidder_id=0; 
                            }
    
                            $ab=$e_autobid_price+$e_max_abidder;
                            if(($ab<=$e_autbid_maxprice) and ($e_bidder_id!=$e_mbidder_id))
                            {
                                $sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
                                $sql_ins.=",bidder_id,bid_price,bid_time";
                                $sql_ins.=" ) values(  ";
                                $sql_ins.=" :e_auc_id,:acd_id,:e_bidder_id,:ab,current_timestamp) ";
                                $sthI = $conn->prepare($sql_ins);
                                $sthI->bindParam(':e_auc_id', $e_auc_id);
                                $sthI->bindParam(':acd_id', $acd_id);
                                $sthI->bindParam(':e_bidder_id', $e_bidder_id);
                                $sthI->bindParam(':ab', $ab);
                                $sthI->execute();
                            }
                        }
                    }     
                ?>
                <script src="./js/alertify.min.js"></script>
                <link rel="stylesheet" href="./css/alertify.core.css" />
                <link rel="stylesheet" href="./css/alertify.default.css" />		
                <script>
                    alertify.alert("Auto Bid Entry Successfully");
                </script> 
                <?php			
			}
            catch(PdoException $e){
				echo "ERROR: " . $e->getMessage();
			}
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
  
}
?>
<?php
if(($tag=="YOUR-ERASE-AUTOBID"))
{
	 $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
	 $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
	 $ses_bidder_id= test_input(isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '');
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
		

		$sql2=" select count(*) as user_count,auto_id from autobid_mas ";
		$sql2.=" where acd_id=:acd_id and auc_id=:auc_id and bidder_id=:ses_bidder_id ";
		$sth2 = $conn->prepare($sql2);
		$sth2->bindParam(':acd_id', $acd_id);
		$sth2->bindParam(':auc_id', $auc_id);
		$sth2->bindParam(':ses_bidder_id', $ses_bidder_id);
		$sth2->execute();
		$sth2->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $sth2->fetch();
		$user_count=$row2['user_count'];
		$auto_id=$row2['auto_id'];
		if($user_count>0)
		{
			try
            {
				$sql_ins ="update autobid_mas set ";
				$sql_ins.=" autobid_price=null,autbid_maxprice=null,update_on=current_timestamp";
				$sql_ins.=" where acd_id=:acd_id and auc_id=:auc_id and bidder_id=:ses_bidder_id  ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->execute();

                $sql_ins ="insert into autobid_dtl(auto_id,auc_id,acd_id ";
				$sql_ins.=",bidder_id,autobid_price,autbid_maxprice,autobid_on";
				$sql_ins.=" ) values(  ";
				$sql_ins.=" :auto_id,:auc_id,:acd_id,:ses_bidder_id,null,null,current_timestamp) ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':auto_id', $auto_id);
				$sthI->bindParam(':auc_id', $auc_id);
				$sthI->bindParam(':acd_id', $acd_id);
				$sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
				$sthI->execute();
                ?>
                <script src="./js/alertify.min.js"></script>
                <link rel="stylesheet" href="./css/alertify.core.css" />
                <link rel="stylesheet" href="./css/alertify.default.css" />		
                <script>
                    alertify.alert("Auto Bid Erase Successfully");
                </script> 
                <?php			
			}
            catch(PdoException $e){
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
                alertify.alert("Auto Bid Erase Successfully");
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
  
}
?>


<?php
if(($tag=="YOUR-ROW-HIDE"))
{
    $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $ses_bidder_id= test_input(isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '');
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
    if($log_count>0)
    {
        $sql_ins ="insert into show_hide_mas ( ";
        $sql_ins.=" auc_id,acd_id,bidder_id ";
        $sql_ins.=" ) values(  ";
        $sql_ins.=" :auc_id,:acd_id,:ses_bidder_id) ";
        $sthI = $conn->prepare($sql_ins);
        $sthI->bindParam(':auc_id', $auc_id);
        $sthI->bindParam(':acd_id', $acd_id);
        $sthI->bindParam(':ses_bidder_id', $ses_bidder_id);
        $sthI->execute();
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />		
        <script>
        alertify.alert("Item hide successfully.", function(){
            window.location.href='./acive-offersheet-bid.php?param=<?php echo md5($auc_id); ?>';
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
?>


<?php
if(($tag=='HID-ROW-VIEW'))
{
    $ses_bidder_id= isset($_POST['ses_bidder_id'])? $_POST['ses_bidder_id']: '';
    $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $auc_id= isset($_POST['auc_id'])? $_POST['auc_id']: '';
	?>
    <script type="text/javascript">
            $('#modal-default<?php echo $auc_id; ?>').modal('show');
    </script>

    <div class="modal modal-default fade" id="modal-default<?php echo $auc_id; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hide Information</h4>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped">
                        <tr>
                            <th>Lot No</th>
                            <th>Mark</th>
                            <th>Invoice</th>
                            <th>Grade</th>
                            <th>Package</th>
                            <th>Valuation</th>
                            <th>Base Price</th>
                            <th>Show</th>
                        </tr>
                        <?php
                        
                        $sqle= "select sh.sh_id,ad.acd_id,ad.lot_no,ad.garden_nm,ad.grade,ad.pkgs,ad.net,ad.invoice_no,ad.msp,ad.valu_kg,ad.base_price ";
                        $sqle.="from auction_dtl ad, show_hide_mas sh ";
                        $sqle.="where ad.auc_id=:auc_id and ad.acd_id=sh.acd_id and sh.bidder_id=:ses_bidder_id and sh.auc_id=:auc_id ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':auc_id', $auc_id);
                        $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                            $sh_id=$value['sh_id'];
                            $acd_id=$value['acd_id'];
                            $lot_no=$value['lot_no'];
                            $garden_nm=$value['garden_nm'];
                            $grade=$value['grade'];
                            $pkgs=$value['pkgs'];
                            $net=$value['net'];
                            $invoice_no=$value['invoice_no'];
                            $valu_kg=$value['valu_kg'];
                            $msp=$value['msp'];
                            $base_price=$value['base_price'];
                            ?>
                            <tr>
                                <td><?php echo $lot_no; ?></td>
                                <td><?php echo $garden_nm; ?></td>
                                <td><?php echo $invoice_no; ?></td>
                                <td><?php echo $grade; ?></td>
                                <td><?php echo $pkgs; ?></td>
                                <td><?php echo $valu_kg; ?></td>
                                <td><?php echo $base_price; ?></td>
                                <td><i class="fa fa-eye text-green" id="rshow<?php echo $sh_id; ?>" aria-hidden="true"></i></td>
                            </tr>
                            <script>
                                /********************************************* start row hide */

                                $('#rshow<?php echo $sh_id; ?>').click(function(){
                                        var hid_token = $('#hid_token').val();
                                        var hid_log_user = $('#hid_log_user').val();
                                        var sh_id ='<?php echo $sh_id; ?>';
                                        var auc_id ='<?php echo $auc_id; ?>';

                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: 
                                            {
                                                hid_token: hid_token,
                                                hid_log_user: hid_log_user,
                                                sh_id: sh_id,
                                                auc_id: auc_id,
                                                tag: 'YOUR-ROW-SHOW'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                             //   alert(msg);
                                                $("#info").html(msg);
                                            }
                                        });
                                    });
                                    
                                </script>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>

    </div>
    <?php
}
?>


<?php
if(($tag=="YOUR-ROW-SHOW"))
{
    $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $sh_id= test_input(isset($_POST['sh_id'])? $_POST['sh_id']: '');
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
    if($log_count>0)
    {
        $sql_ins ="delete from show_hide_mas where sh_id=:sh_id ";
        $sthI = $conn->prepare($sql_ins);
        $sthI->bindParam(':sh_id', $sh_id);
        $sthI->execute();
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />		
        <script>
        alertify.alert("Item show successfully.", function(){
            window.location.href='./acive-offersheet-bid.php?param=<?php echo md5($auc_id); ?>';
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
?>

<?php
if(($tag=='HIS-BID-DEL'))
{
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
                <div class="modal-body p-0 table-responsive ">
                    <table class="table table-striped">
                        <tr>
                            <th>Bid Time</th>
                            <th>Bid Price</th>
                            <th>Bidder Name</th>
                            <th>Billing Name</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $sqle= "select ab.abd_id,ab.auc_id,ab.bid_price,ab.bid_time,bd.name,bd.billing_nm ";
                        $sqle.="from auc_bid_dtl ab,bidder_mas bd ";
                        $sqle.="where ab.acd_id=:acd_id  and ab.bidder_id=bd.bidder_id ";
                    //    $sqle.=" and bidder_id=:ses_bidder_id ";
                      //  echo "$sqle $acd_id $ses_bidder_id";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':acd_id', $acd_id);
                  //      $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                            $auc_id=$value['auc_id'];
                            $abd_id=$value['abd_id'];
                            $bid_time=$value['bid_time'];
                            $bid_price=$value['bid_price'];
                            $name=$value['name'];
                            $billing_nm=$value['billing_nm'];
                            ?>
                            <tr>
                                <th><?php  echo date("h:i A", strtotime($bid_time)); ?></th>
                                <th><?php echo $bid_price; ?></th>
                                <th><?php echo $name; ?></th>
                                <th><?php echo $billing_nm; ?></th>
                                <th>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" style="min-width:100px !important;" size="10" name="remk[<?php echo $abd_id; ?>]" id="remk<?php echo $abd_id; ?>">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" id="rdel<?php echo $abd_id; ?>"><i class="fa fa-trash"></i></button>
                                        </span>
                                    </div> 
                                
                                </th>
                            </tr>
                            <script>                 
                                /********************************************* start row hide */

                                $('#rdel<?php echo $abd_id; ?>').click(function(){
                                        var hid_token = $('#hid_token').val();
                                        var hid_log_user = $('#hid_log_user').val();
                                        var remk = $('#remk<?php echo $abd_id; ?>').val();
                                        var abd_id ='<?php echo $abd_id; ?>';
                                        var auc_id ='<?php echo $auc_id; ?>';
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        if (remk == "") 
                                        {
                                            alert('Please input Remarks');
                                            $('#remk<?php echo $abd_id; ?>').focus();
                                            return false;
                                        } 
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: 
                                            {
                                                hid_token: hid_token,
                                                hid_log_user: hid_log_user,
                                                remk: remk,
                                                abd_id: abd_id,
                                                auc_id: auc_id,
                                                acd_id:acd_id,
                                                tag: 'BID-DEL'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                                alert(msg);
                                                $("#info").html(msg);
                                            }
                                        });
                                    });
                                    
                                </script>
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
if(($tag=="BID-DEL"))
{
    $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $auc_id = isset($_POST['auc_id']) ? $_POST['auc_id'] : '';
    $acd_id = isset($_POST['acd_id']) ? $_POST['acd_id'] : '';
    $abd_id = isset($_POST['abd_id']) ? $_POST['abd_id'] : '';
    $remk = isset($_POST['remk']) ? $_POST['remk'] : '';


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
        $sql=" select abd_id,auc_id,acd_id,bidder_id,bid_price,bid_time from auc_bid_dtl ";
        $sql.=" where abd_id=:abd_id ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':abd_id', $abd_id);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $abd_id=$row['abd_id'];
        $auc_id=$row['auc_id'];
        $acd_id=$row['acd_id'];
        $bidder_id=$row['bidder_id'];
        $bid_price=$row['bid_price'];
        $bid_time=$row['bid_time'];


        $sql_ins ="insert into auc_bid_dtl_del ( ";
        $sql_ins.=" abd_id,auc_id,acd_id,bidder_id,bid_price,bid_time,remk ";
        $sql_ins.=" ) values(  ";
        $sql_ins.=" :abd_id,:auc_id,:acd_id,:bidder_id,:bid_price,:bid_time,:remk) ";
        $sthI = $conn->prepare($sql_ins);
        $sthI->bindParam(':abd_id', $abd_id);
        $sthI->bindParam(':auc_id', $auc_id);
        $sthI->bindParam(':acd_id', $acd_id);
        $sthI->bindParam(':bidder_id', $bidder_id);
        $sthI->bindParam(':bid_price', $bid_price);
        $sthI->bindParam(':bid_time', $bid_time);
        $sthI->bindParam(':remk', $remk);
        $sthI->execute();
        

        $sql_ins ="delete from auc_bid_dtl where abd_id=:abd_id ";
        $sthI = $conn->prepare($sql_ins);
        $sthI->bindParam(':abd_id', $abd_id);
        $sthI->execute();

        /**************************** auto bid start */
        $sqle= "select max(bid_price) as bid_price ";
        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";

        $sth = $conn->prepare($sqle);
        $sth->bindParam(':acd_id', $acd_id);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        if($row['bid_price']>0)
        {
            $bid_price=$row['bid_price'];
        }
        else
        {
            $sqle= "select base_price as bid_price ";
            $sqle.="from auction_dtl WHERE acd_id=:acd_id ";
            $sth = $conn->prepare($sqle);
            $sth->bindParam(':acd_id', $acd_id);
            $sth->execute();
            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetch();  
            $bid_price=$row['bid_price'];
        }

        $sql2=" select max(autbid_maxprice) as autbid_maxprice  from autobid_mas ";
        $sql2.=" where acd_id=:acd_id and autbid_maxprice> :bid_price  ";
        $sth2 = $conn->prepare($sql2);
        $sth2->bindParam(':acd_id', $acd_id);
        $sth2->bindParam(':bid_price', $bid_price);
        $sth2->execute();
        $sth2->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $sth2->fetch();
        $autbid_maxprice=$row2['autbid_maxprice'];
        for($x=$bid_price; $x<=$autbid_maxprice; $x++)
        {
            $sqle= "select ab.bidder_id,ab.auc_id,ab.acd_id,ab.autobid_price,ab.autbid_maxprice ";
            $sqle.="from autobid_mas ab,auction_mas a WHERE ab.acd_id=:acd_id and ab.auc_id=a.auc_id ";
            $sqle.=" and auc_start_time<=current_timestamp and auc_end_time>=current_timestamp order by ab.auto_id ";
          //  echo "$sqle $acd_id";
            $sth = $conn->prepare($sqle);
            $sth->bindParam(':acd_id', $acd_id);
            $sth->execute();
            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetchAll();
           // print_r($row);
            foreach ($row as $key => $value) 
            {
                $e_bidder_id=$value['bidder_id'];
                $e_auc_id=$value['auc_id'];
                $e_autobid_price=$value['autobid_price'];
                $e_autbid_maxprice=$value['autbid_maxprice'];

                $sqle= "select max(bid_price) as max_abidder,bidder_id ";
                $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";
                $sth = $conn->prepare($sqle);
                $sth->bindParam(':acd_id', $acd_id);
                $sth->execute();
                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                $row = $sth->fetch();
                
                if($row['max_abidder']>0)
                {
                    $e_max_abidder=$row['max_abidder'];
                }
                else
                {
                    $sqle= "select base_price as max_abidder ";
                    $sqle.="from auction_dtl WHERE acd_id=:acd_id ";
                    $sth = $conn->prepare($sqle);
                    $sth->bindParam(':acd_id', $acd_id);
                    $sth->execute();
                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $sth->fetch();  
                    $e_max_abidder=$row['max_abidder'];
                }

                //echo $e_max_abidder;
                $sqle= "select bidder_id ";
                $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id and bid_price=:e_max_abidder ";
                $sth = $conn->prepare($sqle);
                $sth->bindParam(':acd_id', $acd_id);
                $sth->bindParam(':e_max_abidder', $e_max_abidder);
                $sth->execute();
                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                $row = $sth->fetch();
                if($row)
                {
                    $e_mbidder_id=$row['bidder_id'];
                }
                else
                {
                    $e_mbidder_id=0; 
                }

                $ab=$e_autobid_price+$e_max_abidder;
                if(($ab<=$e_autbid_maxprice) and ($e_bidder_id!=$e_mbidder_id))
                {
                    $sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
                    $sql_ins.=",bidder_id,bid_price,bid_time";
                    $sql_ins.=" ) values(  ";
                    $sql_ins.=" :e_auc_id,:acd_id,:e_bidder_id,:ab,current_timestamp) ";
                    $sthI = $conn->prepare($sql_ins);
                    $sthI->bindParam(':e_auc_id', $e_auc_id);
                    $sthI->bindParam(':acd_id', $acd_id);
                    $sthI->bindParam(':e_bidder_id', $e_bidder_id);
                    $sthI->bindParam(':ab', $ab);
                    $sthI->execute();
                }
            }
        }  
        ?>
        <script src="./js/alertify.min.js"></script>
        <link rel="stylesheet" href="./css/alertify.core.css" />
        <link rel="stylesheet" href="./css/alertify.default.css" />		
        <script>
        alertify.alert("Item show successfully.", function(){
            window.location.href='./acive-offersheet-bid.php?param=<?php echo md5($auc_id); ?>';
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
?>
<?php
$conn=null;
?>