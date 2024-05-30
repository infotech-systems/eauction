<?php
include("./inc/dblib.inc.php");
include("./inc/datelib.inc.php");
$conn = OpenDB();

$ses_user_type = isset($_REQUEST['ses_user_type']) ? $_REQUEST['ses_user_type'] : '';
$e_sale_type= isset($_REQUEST['e_sale_type']) ? $_REQUEST['e_sale_type'] : '';
$auc_id  = isset($_REQUEST['auc_id']) ? $_REQUEST['auc_id'] : '';
$ses_bidder_id  = isset($_REQUEST['ses_bidder_id']) ? $_REQUEST['ses_bidder_id'] : '';

?>

<table class="table ">
    <thead>
        <tr>
            <th  style="position:sticky ">Lot No</th>
            <th  style="position:sticky ">Mark</th>
            <th  style="position:sticky ">Invoice</th>
            <th  style="position:sticky ">Grade</th>
            <th  style="position:sticky ">Package</th>
            <th style="position:sticky ">Valuation</th>
            <th  style="position:sticky ">Base Price</th>
            
            <?php
            if($ses_user_type=='B')
            {
                ?>
                <th style="position:sticky ">Highest Bid</i></th>
                <th class="sticky-header" style="position:sticky; min-width:100px;">Your Bid</th>
                <th wrap class="sticky-header" >Auto-increment Price</th>
                <th class="sticky-header">Maximum Auto Price</th>
                <th class="sticky-header"><i class="fa fa-eye text-green" aria-hidden="true" id="row-show"></i></th>
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
    </thead>
    <tbody>
    <?php
    $acd=array();
    $sqle= "select acd_id ";
    $sqle.="from show_hide_mas ";
    $sqle.="where auc_id=:auc_id ";
    $sqle.="and bidder_id=:ses_bidder_id ";
   // echo "$sqle $auc_id $ses_bidder_id";
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
    echo "$sqle $auc_id";
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
    
    </tbody>
</table>
<?php
$conn =null;
?>