<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
$curtime=date('H:i:s');

$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$check = isset($_POST['check']) ? $_POST['check'] : '';
$max_bid_price = isset($_POST['max_bid_price']) ? $_POST['max_bid_price'] : '';
$auc_id = isset($_POST['auc_id']) ? $_POST['auc_id'] : '';
$bidder = isset($_POST['bidder']) ? $_POST['bidder'] : '';

if($submit=='Knock Down')
{
    $sql=" select count(*) as log_count from user_mas ";
    $sql.=" where uid=:ses_uid and token=:ses_token ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':ses_token', $ses_token);
    $sth->bindParam(':ses_uid', $ses_uid);
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
        foreach($check as $ck)
        {
            $sql=" select jap_id,lot_no,garden_nm,grade,invoice_no ";
			$sql.=" ,gp_date,chest,net,pkgs,valu_kg,base_price,msp ";
            $sql.=" from auction_dtl ";
            $sql.=" where auc_id=:auc_id and acd_id=:acd_id ";
            $sth = $conn->prepare($sql);
            $sth->bindParam(':auc_id', $auc_id);
            $sth->bindParam(':acd_id', $ck);
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
            $sthI->bindParam(':acd_id', $ck);
            $sthI->execute();

            $sql_ins =" insert into fin_auc_bid_dtl (abd_id,auc_id,acd_id ";
            $sql_ins .=" ,bidder_id,bid_price,bid_time) SELECT abd_id,auc_id,acd_id ";
            $sql_ins .=" ,bidder_id,bid_price,bid_time FROM auc_bid_dtl where acd_id=:acd_id   ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':acd_id', $ck);
            $sthI->execute();

            $sql_ins =" delete from auction_dtl where auc_id=:auc_id and acd_id=:acd_id ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':auc_id', $auc_id);
            $sthI->bindParam(':acd_id', $ck);
            $sthI->execute();

            $sql_ins =" delete from auc_bid_dtl where acd_id=:acd_id ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':acd_id', $ck);
            $sthI->execute();
        }
        ?>
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
        <script>
            alertify.alert("Unauthorized access");
        </script> 
        <?php
    }
}
$sqle= "select auc_id,knockdown_start,knockdown_end,offer_srl,offer_nm,location,payment_type ";
$sqle.= " ,contract_type ";
$sqle.="from auction_mas ";
$sqle.="where md5(auc_id)=:param  and knockdown_start<=current_timestamp and knockdown_end>=current_timestamp ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
if($row)
{
    $auc_id=$row['auc_id'];
    $e_knockdown_start_time=$row['knockdown_start'];
    $e_knockdown_end_time=$row['knockdown_end'];
    $e_knockdown_start=ansi_to_british(substr($row['knockdown_start'],0,10));
    $e_knockdown_end=ansi_to_british(substr($row['knockdown_end'],0,10));

    $e_offer_srl=$row['offer_srl'];
    $e_location=$row['location'];
    $e_payment_type=$row['payment_type'];
    $e_contract_type=$row['contract_type'];
    if(strlen($e_knockdown_end_time)>8){ $e_end_tm1=date("h:i A", strtotime($e_knockdown_end_time)); } else {{ $e_end_tm1=null; }}
    $e_sale_type='E';
    if($e_sale_type=='J')
    {
        $sqle= "select jap_id,jap_dt,jap_start,jap_end ";
        $sqle.="from japanese_mas ";
        $sqle.="where auc_id=:auc_id  and jap_dt=current_date and jap_start<=:curtime and jap_end>=:curtime ";
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

    <script>
    // Set the date we're counting down to
    var countDownDate = new Date('<?php echo "$e_knockdown_end_time"; ?>'+'00').getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
        
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
        
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = "<table class='table table-bordered dd'><tr><td>Day</td><td>Hour</td><td>Minutes</td><td>Seconds</td></tr><tr><td>"+days + "</td><td> " + hours + "</td><td> "
    + minutes + "</td><td> " + seconds + "</td></tr> </table>";
        
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
       // document.getElementById("demo").innerHTML = "EXPIRED";
       alertify.alert("EXPIRED", function(){
			window.location.href='./knockdown-offersheet-bid.php?param=<?php echo $param; ?>';
		});
    }
    }, 1000);
    </script>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body no-padding  table-responsive ">
                    <table class="table table-bordered">
                        <tr>
                            <th>Offersheet No</th>
                            <th>Expiry Date & Time</th>
                            <th rowspan="2" style="width:200px;" id="demo"></i></th>
                        </tr>
                        <tr>
                            <th><?php echo $e_offer_srl; ?></th>
                            <th><?php echo "$e_knockdown_end | $e_end_tm1"; ?></th>
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
    <form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
    <input type="hidden" id="auc_id" name="auc_id" value="<?php echo $auc_id; ?>" />
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Knock Down">
                        <input type="button" class="btn btn-danger pull-right"  value="Re-Auction"  data-toggle="modal" data-target="#modal-default">
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th><input type="checkbox" id="checkAll" value="All" ></th>
                                <th>Lot No</th>
                                <th>Mark</th>
                                <th>Grade</th>
                                <th>Package</th>
                                <th>KG</th>
                                <th>Valuation</th>
                                <th>Invoice</th>
                                <th>Base Price</th>
                                <th>MSP</th>
                                <th>Highest Bid</i></th>
                                <th>Bidder Name</i></th>
                                <th>#</i></th>
                                    
                            </tr>
                            <?php
                            $sl=0;
                            $acds=array();
                            $current_time=date("H:i:s",time());
                            $sqle= "select acd_id,lot_no,garden_nm,grade,pkgs,net,invoice_no,msp,valu_kg,base_price ";
                            $sqle.="from auction_dtl ";
                            $sqle.="where auc_status='P' and auc_id=:auc_id ";
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
                                $sql2=" select max(ab.bid_price) as bid_price,bm.billing_nm,ab.bidder_id ";
                                $sql2.="   from auc_bid_dtl ab,bidder_mas bm ";
                                $sql2.=" where acd_id=:acd_id  and ab.bidder_id=bm.bidder_id  ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':acd_id', $acd_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $bid_price=$row2['bid_price'];
                                $billing_nm=$row2['billing_nm'];
                                $bidder_id=$row2['bidder_id'];
                                ?>
                                <tr>
                                    <th>
                                        <?php
                                        if($bid_price>0)
                                        {
                                            ?>
                                            <input type="checkbox" name="check[]" id="check" value="<?php echo $acd_id; ?>">
                                            <?php
                                        }
                                        ?>
                                    </th>
                                    <td><?php echo $lot_no; ?></td>
                                    <td><?php echo $garden_nm; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <td><?php echo $pkgs; ?></td>
                                    <td><?php echo $net; ?></td>
                                    <td><?php echo $valu_kg; ?></td>
                                    <td><?php echo $invoice_no; ?></td>
                                    <td><?php echo $base_price; ?></td>
                                    <td><?php echo $msp; ?></td>
                                    <td>
                                        <?php echo $bid_price; ?>
                                        <input type="hidden" name="max_bid_price[<?php echo $acd_id; ?>]" id="max_bid_price<?php echo $acd_id; ?>" value="<?php echo $bid_price; ?>">
                                        <input type="hidden" name="bidder[<?php echo $acd_id; ?>]" id="bidder<?php echo $acd_id; ?>" value="<?php echo $bidder_id; ?>">
                                    </td>
                                    <td><?php echo $billing_nm; ?></td>  
                                    <td>
                                        <?php
                                        if($bid_price>0)
                                        {
                                            ?>
                                            <button type="button" id="knock<?php echo $acd_id; ?>" class="btn btn-primary"><i class="fa fa-check"></i></button></td>  
                                            <?php
                                        }
                                        ?>
                                    
                                </tr>
                                <div id="info<?php echo $acd_id; ?>"></div>
                                <script>
                                $('#knock<?php echo $acd_id; ?>').click(function(){
                                    var auc_id = $('#auc_id').val();
                                    var hid_log_user = $('#hid_log_user').val();
                                    var hid_token = $('#hid_token').val();
                                    var max_bid_price = $('#max_bid_price<?php echo $acd_id; ?>').val();
                                    var bidder = $('#bidder<?php echo $acd_id; ?>').val();
                                    var acd_id ='<?php echo $acd_id; ?>';
                                    alert(acd_id);
                                    var request = $.ajax({
                                        url: "./back/knockdown-back.php",
                                        method: "POST",
                                        data: {
                                            auc_id:auc_id,
                                            hid_log_user:hid_log_user,
                                            hid_token:hid_token,
                                            max_bid_price:max_bid_price,
                                            bidder:bidder,
                                            acd_id: acd_id,
                                            tag: 'KNOCK-DOWN'
                                        },
                                        dataType: "html",
                                        success: function(msg) {
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
			window.location.href='./knockdown-offersheet.php';
		  });
    </script>
    <?php
}
?>
<div class="modal fade" id="modal-default">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Re-Auction Offersheet No: <?php echo $e_offer_srl; ?></h4>
</div>
<div class="modal-body" style="height:80px;">
    <div class="col-md-12" style="margin-bottom:5px;">
        <div class="form-group  has-feedback">
            <label for="Offer Period" class="col-sm-4">Offer Period</label>
            <div class="col-sm-8">
                <input type="text" name="offer_period" id="offer_period"  class="form-control"  value="" readonly="readonly" tabindex="2">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group  has-feedback">
            <label for="Knock Down Period" class="col-sm-4">Knock Down Period</label>
            <div class="col-sm-8">
                <input type="text" name="knockdown_period" id="knockdown_period"  class="form-control"  value="" readonly="readonly" tabindex="2">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>

</div>

</div>

<script>
$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
 </script>
<?php include('./footer.php'); ?>
