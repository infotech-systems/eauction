<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
$curtime=date('H:i:s');

$sqle= "select auc_id,auc_dt,auc_tm,end_tm,offer_srl,offer_nm,location,payment_type ";
$sqle.= " ,contract_type,prompt_days,sale_type ";
$sqle.="from auction_mas ";
$sqle.="where md5(auc_id)=:param  and auc_dt=current_date and auc_tm<=:curtime and end_tm>=:curtime ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->bindParam(':curtime', $curtime);
$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
if($row)
{
    $auc_id=$row['auc_id'];
    $e_auc_dt=$row['auc_dt'];
    $e_auc_dt1=ansi_to_british($row['auc_dt']);
    $e_end_tm=$row['end_tm'];
    $e_offer_nm=$row['offer_nm'];
    $e_offer_srl=$row['offer_srl'];
    $e_location=$row['location'];
    $e_payment_type=$row['payment_type'];
    $e_contract_type=$row['contract_type'];
    $e_prompt_days=$row['prompt_days'];
    $e_sale_type=$row['sale_type'];
    if(strlen($e_end_tm)==8){ $e_end_tm1=date("h:i A", strtotime($e_end_tm)); } else {{ $e_end_tm1=null; }}
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
    var countDownDate = new Date('<?php echo "$e_auc_dt $e_end_tm"; ?>').getTime();

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
			window.location.href='./acive-offersheet-bid.php?param=<?php echo $param; ?>';
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
                            <th>Offer Name</th>
                            <th>Expiry Date & Time</th>
                            <th rowspan="2" style="width:200px;" id="demo"></i></th>
                        </tr>
                        <tr>
                            <th><?php echo $e_offer_srl; ?></th>
                            <th><?php echo $e_offer_nm; ?></th>
                            <th><?php echo "$e_auc_dt1 | $e_end_tm1"; ?></th>
                        </tr>
                    </table>
                </div>
            <div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fas fa-map-marked-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Location</span>
                <span class="info-box-number"><?php echo $e_location; ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fas fa-wallet"></i></span>
    <div class="info-box-content">
    <span class="info-box-text">Payment Type</span>
    <span class="info-box-number"><?php echo $e_payment_type; ?></span>
    </div>

    </div>

    </div>


    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fas fa-file-contract"></i></span>
    <div class="info-box-content">
    <span class="info-box-text">Contract Type</span>
    <span class="info-box-number"><?php echo $e_contract_type; ?></span>
    </div>

    </div>

    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fas fa-calendar-alt"></i></span>
    <div class="info-box-content">
    <span class="info-box-text">Prompt Days</span>
    <span class="info-box-number"><?php echo $e_prompt_days; ?></span>
    </div>

    </div>

    </div>
        
    </div>
    <form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
    <input type="hidden" id="ses_bidder_id" value="<?php echo $ses_bidder_id; ?>" />
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
                                <th>Bid</i></th>
                                <th>Your Bid</i></th>
                            </tr>
                            <?php
                            $sl=0;
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

                                $sql2=" select max(bid_price) as bid_price from auc_bid_dtl ";
                                $sql2.=" where acd_id=:acd_id   ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':acd_id', $acd_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $bid_price=$row2['bid_price'];
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
                                        <input type="hidden"  id="base_price<?php echo $acd_id; ?>" value="<?php echo $base_price; ?>">
                                        <?php echo $base_price; ?>
                                    </td>
                                    <td>
                                        <input type="hidden"  id="msp<?php echo $acd_id; ?>" value="<?php echo $msp; ?>">
                                        <?php echo $msp; ?>
                                    </td>
                                    <td id="bid_info<?php echo $acd_id; ?>">
                                        <?php echo $bid_price; ?>
                                        <input type="hidden"  id="max_bid_price<?php echo $acd_id; ?>" value="<?php echo $bid_price; ?>">
                                    </td>
                                    <td style="width:140px !important;">
                                        <?php
                                        if($ses_user_type=='B')
                                        {
                                            ?>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" id="bidhis<?php echo $acd_id; ?>"><i class="fas fa-history"></i></button>
                                                </span>
                                                <input type="number" class="form-control" name="bid_price[<?php echo $acd_id; ?>]" id="bid_price<?php echo $acd_id; ?>" style="width:60px;">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success btn-flat" id="bid<?php echo $acd_id; ?>"><i class="fas fa-pen-alt"></i></button>
                                                </span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <div id="info<?php echo $acd_id; ?>"></div>

                                <script>
                                    $('#bid<?php echo $acd_id; ?>').click(function(){
                                        var base_price = $('#base_price<?php echo $acd_id; ?>').val();
                                        var msp = $('#msp<?php echo $acd_id; ?>').val();
                                        var max_bid_price = $('#max_bid_price<?php echo $acd_id; ?>').val();
                                        var bid_price = $('#bid_price<?php echo $acd_id; ?>').val();
                                        var hid_token = $('#hid_token').val();
                                        var hid_log_user = $('#hid_log_user').val();
                                        var ses_bidder_id = $('#ses_bidder_id').val();
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        var auc_id ='<?php echo $auc_id; ?>';
                                        if(msp==''){msp=0;}
                                        if (bid_price == "") 
                                        {
                                            alert('Please input Bid Price');
                                            $('#bid_price<?php echo $acd_id; ?>').focus();
                                            return false;
                                        }  
                                        if(parseFloat(max_bid_price)>=parseFloat(bid_price))
                                        {
                                            alert('Please input Bid Price greater than Previous  Bid');
                                            $('#bid_price<?php echo $acd_id; ?>').focus();
                                            return false;
                                        }
                                        if(parseFloat(base_price)>=parseFloat(bid_price))
                                        {
                                            alert('Please input Bid Price greater than Base Price');
                                            $('#bid_price<?php echo $acd_id; ?>').focus();
                                            return false;
                                        }
                                        if(parseFloat(msp)>0)
                                        {
                                            if(parseFloat(msp)<parseFloat(bid_price))
                                            {
                                                alert('Please input Bid Price less than MSP Price');
                                                $('#bid_price<?php echo $acd_id; ?>').focus();
                                                return false;
                                            }
                                        }
                                        
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                hid_token: hid_token,
                                                hid_log_user: hid_log_user,
                                                ses_bidder_id:ses_bidder_id,
                                                bid_price: bid_price,
                                                acd_id: acd_id,
                                                auc_id: auc_id,
                                                tag: 'YOUR-BID'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                                $("#bid_info<?php echo $acd_id; ?>").html(msg);
                                                $('#bid_price<?php echo $acd_id; ?>').val(null);
                                            }
                                        });
                                    });
                                    $('#bidhis<?php echo $acd_id; ?>').click(function(){
                                        var ses_bidder_id = $('#ses_bidder_id').val();
                                        var acd_id ='<?php echo $acd_id; ?>';
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
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        
        
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
