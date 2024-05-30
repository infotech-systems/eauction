<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
$curtime=date('H:i:s');
//echo "XXXXXXXXXX: $ses_bidder_id<br>";
$sqle= "select auc_id,auc_start_time,auc_end_time,offer_srl,offer_nm,location,payment_type ";
$sqle.= " ,contract_type ";
$sqle.="from auction_mas ";
$sqle.="where md5(auc_id)=:param  and auc_start_time<=current_timestamp and auc_end_time>=current_timestamp ";
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
        
table {
  text-align: left;
  position: relative;
  border-collapse: collapse; 
}
th, td {
  padding: 0.25rem;
}
tr.red th {
  background: red;
  color: white;
}
tr.green th {
  background: green;
  color: white;
}
tr.purple th {
  background: purple;
  color: white;
}
th {
  background: white;
  position: sticky;
  top: 0; /* Don't forget this, required for the stickiness */
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}

    </style>

    <script>
    // Set the date we're counting down to
    var countDownDate = new Date('<?php echo "$e_auc_end_time"; ?>').getTime();

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
<style>
@media screen and (max-width: 767px) 
{
    .table-responsive>.table>tbody>tr>td, .table-responsive>.table>tbody>tr>th, .table-responsive>.table>tfoot>tr>td, .table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td, .table-responsive>.table>thead>tr>th
    {
      /*  white-space: normal;*/
    }
}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body no-padding  table-responsive ">
                  <!--  <table class="table table-bordered">
                        <tr>
                            <th>Offersheet No</th>
                            <th>Expiry Date & Time</th>
                            <th rowspan="2" style="width:200px;" id="demo"></i></th>
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
                    </table>-->
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
                        <table class="table">
                                <tr class="red">
                                    <th style="position:sticky;">Lot No</th>
                                    <th style="position:sticky;">Mark</th>
                                    <th style="position:sticky;">Invoice</th>
                                    <th style="position:sticky;">Grade</th>
                                    <th style="position:sticky;">Package</th>
                                    <th style="position:sticky;">Valuation</th>
                                    <th style="position:sticky;">Base Price</th>
                                   
                                    <?php
                                    if($ses_user_type=='B')
                                    {
                                        ?>
                                        <th style="position:sticky;">Highest Bid</i></th>
                                        <th style="position:sticky; min-width:100px;">Your Bid</th>
                                        <th style="position:sticky;">Auto-increment Price</th>
                                        <th style="position:sticky;">Maximum Auto Price</th>
                                        <th style="position:sticky;"><i class="fa fa-eye text-green" aria-hidden="true" id="row-show"></i></th>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <th style="position:sticky;">Highest Bid</th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            <?php
                            $acd=array();
                            $sqle= "select acd_id ";
                            $sqle.="from show_hide_mas ";
                            $sqle.="where auc_id=:auc_id ";
                            $sqle.="and bidder_id=:ses_bidder_id ";
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':auc_id', $auc_id);
                            $sth->bindParam(':ses_bidder_id', $ses_bidder_id);
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetchAll();
                            foreach ($row as $key => $value) 
                            {
                                $acd[]=$value['acd_id'];
                            }
                            $asd=implode(",",$acd);
                            $sl=0;
                            $acds=array();
                            $current_time=date("H:i:s",time());
                            $sqle= "select acd_id,lot_no,garden_nm,grade,pkgs,net,invoice_no,msp,valu_kg,base_price ";
                            $sqle.="from auction_dtl ";
                            $sqle.="where auc_id=:auc_id  ";
                            if(strlen($asd)>0)
                            {
                                $sqle.=" and acd_id not in(".$asd.") ";
                            }
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
                                    <td><?php echo $invoice_no; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <td><?php echo $pkgs; ?></td>
                                    <td><?php echo $valu_kg; ?></td>
                                    <td>
                                         <input type="hidden"  id="msp<?php echo $acd_id; ?>" value="<?php echo $msp; ?>">
                                        <input type="hidden" class="text-red" id="base_price<?php echo $acd_id; ?>" value="<?php echo $base_price; ?>">
                                        <?php echo $base_price; ?>
                                    </td>
                                    
                                    <?php
                                    if($ses_user_type=='B')
                                    {
                                        
                                        
                                        ?>
                                        <td id="bid_info<?php echo $acd_id; ?>" class="<?php if($self_bid_price>0){ if($self_bid_price==$bid_price){ echo "bg-red tex-yellow"; }}?>">
                                            <?php echo $bid_price; ?>
                                        </td>
                                        <input type="hidden"  id="max_bid_price<?php echo $acd_id; ?>" value="<?php echo $bid_price; ?>">

                                        <td style="width:100px;">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" id="bidhis<?php echo $acd_id; ?>"><i class="fas fa-history"></i></button>
                                                </span>
                                                <input type="number" class="form-control" style="width:80px !important;" size="10" name="bid_price[<?php echo $acd_id; ?>]" id="bid_price<?php echo $acd_id; ?>" onkeypress="handle<?php echo $acd_id; ?>(event)">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success btn-flat" id="bid<?php echo $acd_id; ?>"><i class="fas fa-pen-alt"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="autobid_price[<?php echo $acd_id; ?>]"  value="<?php if(array_key_exists($acd_id,$Aautobid_price)){ echo $Aautobid_price[$acd_id]; }  ?>" id="autobid_price<?php echo $acd_id; ?>">
                                        </td>

                                        <td  style="width:100px;">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger btn-flat" id="bideraser<?php echo $acd_id; ?>"><i class="fas fa-eraser"></i></button>
                                                </span>
                                                <input type="number" class="form-control" style="width:80px !important;" name="autbid_maxprice[<?php echo $acd_id; ?>]" value="<?php if(array_key_exists($acd_id,$Aautbid_maxprice)){ echo $Aautbid_maxprice[$acd_id]; }  ?>" id="autbid_maxprice<?php echo $acd_id; ?>" onkeypress="autohandle<?php echo $acd_id; ?>(event)">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success btn-flat" id="autobid<?php echo $acd_id; ?>"><i class="fas fa-car"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td><i class="fa fa-eye-slash text-danger" id="rhid<?php echo $acd_id; ?>" aria-hidden="true"></i></td>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <td style="width:150px;">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" id="bidrm<?php echo $acd_id; ?>"><i class="fas fa-history"></i></button>
                                                </span>
                                                <input type="number" class="form-control" size="10" value="<?php echo $bid_price; ?>" readonly>
                                            </div>
                                        </td>
                                        <input type="hidden"  id="max_bid_price<?php echo $acd_id; ?>" value="<?php echo $bid_price; ?>">
                                        <?php
                                    }
                                    ?>
                                    
                                </tr>
                                <div id="info<?php echo $acd_id; ?>"></div>

                                <script>
                                    function handle<?php echo $acd_id; ?>(e){
                                        if(e.keyCode === 13){
                                            e.preventDefault(); // Ensure it is only this code that runs
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
                                                //    alert(msg);
                                                    $("#bid_info<?php echo $acd_id; ?>").html(msg);
                                                    $('#bid_price<?php echo $acd_id; ?>').val(null);
                                                }
                                            });
                                        }
                                    }

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
                                    /********************************************* start auto */

                                    $('#autobid<?php echo $acd_id; ?>').click(function(){
                                        var autobid_price = $('#autobid_price<?php echo $acd_id; ?>').val();
                                        var autbid_maxprice = $('#autbid_maxprice<?php echo $acd_id; ?>').val();
                                        var hid_token = $('#hid_token').val();
                                        var hid_log_user = $('#hid_log_user').val();
                                        var ses_bidder_id = $('#ses_bidder_id').val();
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        var auc_id ='<?php echo $auc_id; ?>';
                                        if (autobid_price == "") 
                                        {
                                            alert('Please input Auto-increment Price');
                                            $('#autobid_price<?php echo $acd_id; ?>').focus();
                                            return false;
                                        }  
                                        if (autbid_maxprice == "") 
                                        {
                                            alert('Please input Maximum Auto Price');
                                            $('#autbid_maxprice<?php echo $acd_id; ?>').focus();
                                            return false;
                                        } 
                                        
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                hid_token: hid_token,
                                                hid_log_user: hid_log_user,
                                                ses_bidder_id:ses_bidder_id,
                                                autobid_price: autobid_price,
                                                autbid_maxprice:autbid_maxprice,
                                                acd_id: acd_id,
                                                auc_id: auc_id,
                                                tag: 'YOUR-AUTOBID'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                             //   alert(msg);
                                                $("#info").html(msg);
                                            }
                                        });
                                    });

                                    /********************************************* start auto bid erase */

                                    $('#bideraser<?php echo $acd_id; ?>').click(function(){
                                        var autobid_price = $('#autobid_price<?php echo $acd_id; ?>').val();
                                        var autbid_maxprice = $('#autbid_maxprice<?php echo $acd_id; ?>').val();
                                        var hid_token = $('#hid_token').val();
                                        var hid_log_user = $('#hid_log_user').val();
                                        var ses_bidder_id = $('#ses_bidder_id').val();
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        var auc_id ='<?php echo $auc_id; ?>';
                                        if (autobid_price == "") 
                                        {
                                            return false;
                                        }  
                                        if (autbid_maxprice == "") 
                                        {
                                            return false;
                                        } 
                                        
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                hid_token: hid_token,
                                                hid_log_user: hid_log_user,
                                                ses_bidder_id:ses_bidder_id,
                                                acd_id: acd_id,
                                                auc_id: auc_id,
                                                tag: 'YOUR-ERASE-AUTOBID'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                             //   alert(msg);
                                                $("#info").html(msg);
                                                $('#autobid_price<?php echo $acd_id; ?>').val('');
                                                $('#autbid_maxprice<?php echo $acd_id; ?>').val('');
                                            }
                                        });
                                    });
                                    /********************************************* start row hide */

                                    $('#rhid<?php echo $acd_id; ?>').click(function(){
                                        var hid_token = $('#hid_token').val();
                                        var hid_log_user = $('#hid_log_user').val();
                                        var ses_bidder_id = $('#ses_bidder_id').val();
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        var auc_id ='<?php echo $auc_id; ?>';

                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                hid_token: hid_token,
                                                hid_log_user: hid_log_user,
                                                ses_bidder_id:ses_bidder_id,
                                                acd_id: acd_id,
                                                auc_id: auc_id,
                                                tag: 'YOUR-ROW-HIDE'
                                            },
                                            dataType: "html",
                                            success: function(msg) {
                                             //   alert(msg);
                                                $("#info").html(msg);
                                            }
                                        });
                                    });
                                    $('#bidrm<?php echo $acd_id; ?>').click(function(){
                                        var acd_id ='<?php echo $acd_id; ?>';
                                        var request = $.ajax({
                                            url: "./back/bider-back.php",
                                            method: "POST",
                                            data: {
                                                acd_id: acd_id,
                                                tag: 'HIS-BID-DEL'
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
<script>
   setInterval(displayHello, 1000);
   function displayHello() {

        var auc_id = $('#auc_id').val();
        var ses_bidder_id = $('#ses_bidder_id').val();
        var request = $.ajax({
            url: "./back/bider-back.php",
            method: "POST",
            data: {
                auc_id:auc_id,
                ses_bidder_id:ses_bidder_id,
                tag: 'CHANGE-BID'
            },
            dataType: "json",
            success: function(msg) {
                console.log(msg);
                <?php
                foreach($acds as $ac) 
                {
                    ?>
                    $('#bid_info<?php echo $ac; ?>').removeClass('bg-red tex-yellow');
                     $("#bid_info<?php echo $ac; ?>").html(msg['bid_price'][<?php echo $ac; ?>]);
                     $("#max_bid_price<?php echo $ac; ?>").val(msg['bid_price'][<?php echo $ac; ?>]);
                     if((msg['bid_price'][<?php echo $ac; ?>]==msg['self_bid_price'][<?php echo $ac; ?>]) && (msg['bid_price'][<?php echo $ac; ?>]>0))
                     {
                        $('#bid_info<?php echo $ac; ?>').addClass('bg-red tex-yellow'); 
                     }

                     

                    <?php
                }
                ?>
            }
        })
    }

    /********************* show row */
    $('#row-show').click(function(){
        var auc_id = $('#auc_id').val();
        var hid_token = $('#hid_token').val();
        var hid_log_user = $('#hid_log_user').val();
        var ses_bidder_id = $('#ses_bidder_id').val();

        var request = $.ajax({
            url: "./back/bider-back.php",
            method: "POST",
            data: {
                ses_bidder_id:ses_bidder_id,
                hid_token: hid_token,
                hid_log_user: hid_log_user,
                auc_id: auc_id,
                tag: 'HID-ROW-VIEW'
            },
            dataType: "html",
            success: function(msg) {
                $("#info").html(msg);
            }
        });
    });
</script>
<?php include('./footer.php'); ?>
