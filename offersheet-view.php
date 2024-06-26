<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
$curtime=date('H:i:s');

$sqle= "select auc_id,auc_start_time,auc_end_time,offer_srl,offer_nm,location,payment_type ";
$sqle.= " ,contract_type ";
$sqle.="from auction_mas ";
$sqle.="where md5(auc_id)=:param   ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
if($row)
{
    $auc_id=$row['auc_id'];
    $e_auc_start_time=$row['auc_start_time'];
    $e_auc_end_time=$row['auc_end_time'];
    $e_auc_start=ansi_to_british(substr($row['auc_start_time'],0,10));
    $e_auc_end=ansi_to_british(substr($row['auc_end_time'],0,10));

    $e_auc_end_time=$row['auc_end_time'];
    $e_offer_srl=$row['offer_srl'];
    $e_location=$row['location'];
    $e_payment_type=$row['payment_type'];
    $e_contract_type=$row['contract_type'];
    if(strlen($e_auc_end_time)>8){ $e_end_tm1=date("h:i A", strtotime($e_auc_end_time)); } else {{ $e_end_tm1=null; }}
    $e_sale_type='E';
    if($e_sale_type=='J')
    {
        $sqle= "select jap_id,jap_dt,jap_start,jap_end ";
        $sqle.="from japanese_mas ";
        $sqle.="where auc_id=:auc_id   ";
        $sth = $conn->prepare($sqle);
        $sth->bindParam(':auc_id', $auc_id);
        $sth->bindParam(':curtime', $curtime);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        if($row)
        {
            $jap_id=$row['jap_id'];
            $e_auc_dt=$row['jap_dt'];
            $e_auc_dt1=ansi_to_british($row['jap_dt']);
            $e_end_tm=$row['jap_end'];
            if(strlen($e_end_tm)==8){ $e_end_tm1=date("h:i A", strtotime($e_end_tm)); } else {{ $e_end_tm1=null; }}
        }
    }
    ?>
    <style>
        td a 
        {
            color:#000;
        }
        table.dd
        {
            margin-bottom:0px;
            color:red;
        }
    </style>

    

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body no-padding  table-responsive ">
                    <table class="table table-bordered">
                        <tr>
                            <th>Offersheet No</th>
                            <th>Expiry Date & Time</th>
                        </tr>
                        <tr>
                            <th><?php echo $e_offer_srl; ?></th>
                            <th><?php echo "$e_auc_end | $e_end_tm1"; ?></th>
                        </tr>
                    </table>
                </div>
            <div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fas fa-map-marked-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Location</span>
                <span class="info-box-number"><?php echo $e_location; ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fas fa-wallet"></i></span>
    <div class="info-box-content">
    <span class="info-box-text">Payment Type</span>
    <span class="info-box-number"><?php echo $e_payment_type; ?></span>
    </div>
    </div>
    </div>


    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fas fa-file-contract"></i></span>
    <div class="info-box-content">
    <span class="info-box-text">Contract Type</span>
    <span class="info-box-number"><?php echo $e_contract_type; ?></span>
    </div>

    </div>

    </div>
        
    </div>
    <?php
    $Aautobid_price=array();
    $Aautbid_maxprice=array();
    $sqle= "select acd_id,autobid_price,autbid_maxprice ";
    $sqle.="from autobid_mas ";
    $sqle.="where auc_id=:auc_id ";
    $sqle.=" and bidder_id=:ses_bidder_id ";
    $sth = $conn->prepare($sqle);
    $sth->bindParam(':auc_id', $auc_id);
    $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sth->fetchAll();
    foreach ($row as $key => $value) 
    {
        $acd_id=$value['acd_id'];
        $Aautobid_price[$acd_id]=$value['autobid_price'];
        $Aautbid_maxprice[$acd_id]=$value['autbid_maxprice'];
    }
    ?>

    <form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
    <input type="hidden" id="ses_bidder_id" value="<?php echo $ses_bidder_id; ?>" />
    <input type="hidden" id="auc_id" value="<?php echo $auc_id; ?>" />
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th>Lot No</th>
                                <th>Mark</th>
                                <th>Grade</th>
                                <th>Package</th>
                                <th>KG</th>
                                <th>Valuation</th>
                                <th>Invoice</th>
                                <th>Base Price</th>
                                <th>MSP</th>
                                <?php
                                if($ses_user_type=='B')
                                {
                                    ?>
                                    <th>Highest Bid</i></th>
                                    <th>Your Bid</i></th>
                                    <th>Auto-increment Price</i></th>
                                    <th>Maximum Auto Price</i></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>Highest Bid</i></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                            $sl=0;
                            $acds=array();
                            $current_time=date("H:i:s",time());
                            $sqle= "select acd_id,lot_no,garden_nm,grade,pkgs,net,invoice_no,msp,valu_kg,base_price ";
                            $sqle.="from auction_dtl ";
                            $sqle.="where auc_id=:auc_id ";
                            if($e_sale_type=='J')
                            {
                                $sqle.=" and jap_id=:jap_id ";
                            }
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':auc_id', $auc_id);
                            if($e_sale_type=='J')
                            {
                                $sth->bindParam(':jap_id', $jap_id);
                            }
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetchAll();
                            foreach ($row as $key => $value) 
                            {
                                $sl++;
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
                                array_push($acds,$acd_id);
                                
                                $sql2=" select max(bid_price) as bid_price from auc_bid_dtl ";
                                $sql2.=" where acd_id=:acd_id   ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':acd_id', $acd_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $bid_price=$row2['bid_price'];

                                $sql2=" select max(bid_price) as self_bid_price from auc_bid_dtl ";
                                $sql2.=" where acd_id=:acd_id  and bidder_id=:ses_bidder_id ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':acd_id', $acd_id);
                                $sth2->bindParam(':ses_bidder_id', $ses_bidder_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $self_bid_price=$row2['self_bid_price'];
                                ?>
                                <tr>
                                    <td><?php echo $lot_no; ?></td>
                                    <td><?php echo $garden_nm; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <td><?php echo $pkgs; ?></td>
                                    <td><?php echo $net; ?></td>
                                    <td><?php echo $valu_kg; ?></td>
                                    <td><?php echo $invoice_no; ?></td>
                                    <td>
                                        <input type="hidden" class="text-red" id="base_price<?php echo $acd_id; ?>" value="<?php echo $base_price; ?>">
                                        <?php echo $base_price; ?>
                                    </td>
                                    <td>
                                        <input type="hidden"  id="msp<?php echo $acd_id; ?>" value="<?php echo $msp; ?>">
                                        <?php echo $msp; ?>
                                    </td>
                                    <?php
                                    if($ses_user_type=='B')
                                    {
                                        
                                        
                                        ?>
                                        <td id="bid_info<?php echo $acd_id; ?>" class="<?php if($self_bid_price>0){ if($self_bid_price==$bid_price){ echo "bg-red tex-yellow"; }}?>">
                                            <?php echo $bid_price; ?>
                                        </td>
                                        <input type="hidden"  id="max_bid_price<?php echo $acd_id; ?>" value="<?php echo $bid_price; ?>">

                                        <td style="width:200px;">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" id="bidhis<?php echo $acd_id; ?>"><i class="fas fa-history"></i></button>
                                                </span>
                                                <input type="number" class="form-control" name="bid_price[<?php echo $acd_id; ?>]" id="bid_price<?php echo $acd_id; ?>" onkeypress="handle<?php echo $acd_id; ?>(event)">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success btn-flat" id="bid<?php echo $acd_id; ?>"><i class="fas fa-pen-alt"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="autobid_price[<?php echo $acd_id; ?>]"  value="<?php if(array_key_exists($acd_id,$Aautobid_price)){ echo $Aautobid_price[$acd_id]; }  ?>" id="autobid_price<?php echo $acd_id; ?>">
                                        </td>

                                        <td style="width:200px;">
                                            <div class="input-group input-group-sm">
                                                <input type="number" class="form-control" name="autbid_maxprice[<?php echo $acd_id; ?>]" value="<?php if(array_key_exists($acd_id,$Aautbid_maxprice)){ echo $Aautbid_maxprice[$acd_id]; }  ?>" id="autbid_maxprice<?php echo $acd_id; ?>" onkeypress="autohandle<?php echo $acd_id; ?>(event)">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success btn-flat" id="autobid<?php echo $acd_id; ?>"><i class="fas fa-car"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <td id="bid_info<?php echo $acd_id; ?>">
                                            <?php echo $bid_price; ?>                                            
                                        </td>
                                        <input type="hidden"  id="max_bid_price<?php echo $acd_id; ?>" value="<?php echo $bid_price; ?>">
                                        <?php
                                    }
                                    ?>
                                    
                                </tr>
                                <div id="info<?php echo $acd_id; ?>"></div>

                               
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div id="info"></div>
    </form>
<?php
}
else
{
    ?>
    <script>
		 alertify.alert("No data available", function(){
			window.location.href='./active-offersheet.php';
		  });
    </script>
    <?php
}
?>

<?php include('./footer.php'); ?>
