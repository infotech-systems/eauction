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
                            <th>Location</th>
                            <th>Payment Type</th>
                            <th>Contract Type</th>

                        </tr>
                        <tr>
                            <th><?php echo $e_offer_srl; ?></th>
                            <th><?php echo "$e_auc_end | $e_end_tm1"; ?></th>
                            <th><?php echo $e_location; ?></th>
                            <th><?php echo $e_payment_type; ?></th>
                            <th><?php echo $e_contract_type; ?></th>
                        </tr>
                    </table>
                </div>
            <div>
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
                                <th>Valuation</th>
                                <th>Invoice</th>
                                <th>Base Price</th>
                                <th>Highest Bid</i></th>
                                <th>Bidder Name</i></th>
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
                                    <td><?php echo $valu_kg; ?></td>
                                    <td><?php echo $invoice_no; ?></td>
                                    <td><?php echo $base_price; ?></td>
                                    
                                        
                                        <td style="width:200px;">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" id="bidhis<?php echo $acd_id; ?>"><i class="fas fa-history"></i></button>
                                                </span>
                                                <input type="number" readonly="readonly" class="form-control" value="<?php echo $bid_price; ?>">
                                                
                                            </div>
                                        </td>
                                        <td> <?php echo $acd_id; ?></td>

                                        
                                      
                                    
                                </tr>
                                <script>
                                $('#bidhis<?php echo $acd_id; ?>').click(function(){
                                        var ses_bidder_id = $('#ses_bidder_id').val();
                                        var acd_id ='0';
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                ses_bidder_id:ses_bidder_id,
                                                acd_id: acd_id,
                                                tag: 'HIS-BID'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                                $("#info<?php echo $acd_id; ?>").html(msg);
                                            }
                                        });
                                    });
                                    </script>
                                <div id="info<?php echo $acd_id; ?>"></div>

                               
                                <?php
                            }
                            $current_time=date("H:i:s",time());
                            $sqle= "select acd_id,lot_no,garden_nm,grade,pkgs,net,invoice_no,msp,valu_kg,base_price,bid_price,bidder_id ";
                            $sqle.="from final_auction_dtl ";
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
                                $bid_price=$value['bid_price'];
                                $bidder_id=$value['bidder_id'];
                                array_push($acds,$acd_id);
                                
                                $sql2=" select max(bid_price) as bid_price from fin_auc_bid_dtl ";
                                $sql2.=" where acd_id=:acd_id   ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':acd_id', $acd_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $bid_price=$row2['bid_price'];

                                $sql2=" select billing_nm from bidder_mas ";
                                $sql2.=" where bidder_id=:bidder_id ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':bidder_id', $bidder_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $billing_nm=$row2['billing_nm'];
                                ?>
                                <tr>
                                    <td><?php echo $lot_no; ?></td>
                                    <td><?php echo $garden_nm; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <td><?php echo $pkgs; ?></td>
                                    <td><?php echo $valu_kg; ?></td>
                                    <td><?php echo $invoice_no; ?></td>
                                    <td><?php echo $base_price; ?></td>
                                    
                                        
                                        <td style="width:200px;">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" id="bidhis<?php echo $acd_id; ?>"><i class="fas fa-history"></i></button>
                                                </span>
                                                <input type="number" readonly="readonly" class="form-control" value="<?php echo $bid_price; ?>">
                                                
                                            </div>
                                        </td>
                                        <td> <?php echo $billing_nm; ?></td>

                                        
                                      
                                    
                                </tr>
                                <script>
                                    $('#bidhis<?php echo $acd_id; ?>').click(function(){
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                acd_id: acd_id,
                                                tag: 'FHIS-BID'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                                $("#info<?php echo $acd_id; ?>").html(msg);
                                            }
                                        });
                                    });
                                </script>
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
