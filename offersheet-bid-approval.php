<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
$curtime=date('H:i:s');

$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$check = isset($_POST['check']) ? $_POST['check'] : '';
$otp = isset($_POST['otp']) ? $_POST['otp'] : '';
$act = isset($_POST['act']) ? $_POST['act'] : '';
$acd = isset($_POST['acd']) ? $_POST['acd'] : '';
$hid_otp_req = isset($_POST['hid_otp_req']) ? $_POST['hid_otp_req'] : '';
if($submit=='Update')
{
    try
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
            if($hid_otp_req=='Y')
            {
                $sql=" select count(*) as cnt from user_mas ";
                $sql.=" where uid=:ses_uid and otp=:otp ";
                $sth = $conn->prepare($sql);
                $sth->bindParam(':ses_uid', $ses_uid);
                $sth->bindParam(':otp', $otp);
                $sth->execute();
                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                $row = $sth->fetch();
                $cnt=$row['cnt'];
                if($cnt>0)
                {

                    foreach($check as $ck)
                    {
                        $act_feedback=$act[$ck];
                        $acd_id=$acd[$ck];

                        $sql=" update bid_app_dtl set status=:act_feedback,update_on=current_timestamp ";
                        $sql.=" where fad_id=:ck and uid=:ses_uid ";
                        $sth = $conn->prepare($sql);
                        $sth->bindParam(':ck', $ck);
                        $sth->bindParam(':ses_uid', $ses_uid);
                        $sth->bindParam(':act_feedback', $act_feedback);
                        $sth->execute();

                        $sql=" select count(*) as asd  ";
                        $sql.=" from bid_app_dtl ";
                        $sql.=" where acd_id=:acd_id and status!='A' ";
                        $sth = $conn->prepare($sql);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetch();
                        $asd=$row['asd'];
                        if($asd==0)
                        {
                            $sql=" update final_auction_dtl set all_app='Y' ";
                            $sql.=" where acd_id=:acd_id ";
                            $sth = $conn->prepare($sql);
                            $sth->bindParam(':acd_id', $acd_id);
                            $sth->execute();
                            file_get_contents('https://privatesale.andrewyule.in/mail/approval_mail/send');
                        }
                    }
                    
                    ?>
                    <script>
                    alertify.alert("Approve Successfully.", function(){
                        window.open('knockdown-approval.php','_self');
                    });
                    </script> 
                    <?php
                }
                else
                {
                    ?>
                    <script>
                    alertify.alert("OTP Invalid");
                    </script> 
                <?php	
                }
            }
            else
            {
                foreach($check as $ck)
                {
                    $act_feedback=$act[$ck];
                    $acd_id=$acd[$ck];

                    $sql=" update bid_app_dtl set status=:act_feedback,update_on=current_timestamp ";
                    $sql.=" where fad_id=:ck and uid=:ses_uid ";
                    $sth = $conn->prepare($sql);
                    $sth->bindParam(':ck', $ck);
                    $sth->bindParam(':ses_uid', $ses_uid);
                    $sth->bindParam(':act_feedback', $act_feedback);
                    $sth->execute();

                    $sql=" select count(*) as asd  ";
                    $sql.=" from bid_app_dtl ";
                    $sql.=" where acd_id=:acd_id and status!='A' ";
                    $sth = $conn->prepare($sql);
                    $sth->bindParam(':acd_id', $acd_id);
                    $sth->execute();
                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $sth->fetch();
                    $asd=$row['asd'];
                    if($asd==0)
                    {
                        $sql=" update final_auction_dtl set all_app='Y' ";
                        $sql.=" where acd_id=:acd_id ";
                        $sth = $conn->prepare($sql);
                        $sth->bindParam(':acd_id', $acd_id);
                        $sth->execute();
                        file_get_contents('https://privatesale.andrewyule.in/mail/approval_mail/send');
                    }
                }
                
                ?>
                <script>
                alertify.alert("Approve Successfully.", function(){
                    window.open('knockdown-approval.php','_self');
                });
                </script> 
                <?php
            }
        	
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
    catch(Exception $e)
    {
        echo $e->getMessage();
        echo $e->getLine();
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
    <?php
     $sql=" select otp_req  ";
     $sql.=" from user_mas ";
     $sql.=" where uid=:ses_uid ";
     $sth = $conn->prepare($sql);
     $sth->bindParam(':ses_uid', $ses_uid);
     $sth->execute();
     $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
     $row = $sth->fetch();
     $otp_req=$row['otp_req'];
     ?>
    <form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <input type="hidden" id="hid_log_user" name="hid_log_user" value="<?php echo $ses_uid; ?>" />
    <input type="hidden" id="hid_token" name="hid_token" value="<?php echo $ses_token; ?>" />
    <input type="hidden" id="auc_id" name="auc_id" value="<?php echo $auc_id; ?>" />
    <input type="hidden" id="hid_otp_req" name="hid_otp_req" value="<?php echo $otp_req; ?>" />
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body">
                        <?php
                        if($otp_req=='Y')
                        {
                            ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon bg-red" id="send_otp">
                                            Send OTP
                                        </div>
                                        <input type="text" class="form-control" name="otp" id="otp" placeholder="Pl. input OTP">
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <input type="submit" class="btn btn-primary pull-right" name="submit" id="submit" value="Update">
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
                                <th>Biiling Name</i></th>
                                <th>Action</i></th>
                                    
                            </tr>
                            <?php
                            $sl=0;
                            $acds=array();
                            $sqle= "select bd.acd_id,fad.lot_no,fad.garden_nm,fad.grade,fad.pkgs,fad.net,fad.invoice_no,";
                            $sqle.=" fad.msp,fad.valu_kg,fad.base_price,fad.fad_id,fad.bid_price,fad.bidder_id ";
                            $sqle.="from bid_app_dtl bd,final_auction_dtl fad ";//auction_dtl ";
                            $sqle.="where bd.status='P' and  md5(bd.auc_id)=:param  and bd.acd_id=fad.acd_id "; //
                            
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':param', $param);
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
                                $fad_id=$value['fad_id'];
                                $bid_price=$value['bid_price'];
                                $bidder_id=$value['bidder_id'];

                                $sql2=" select bm.billing_nm,bm.name ";
                                $sql2.="   from bidder_mas bm ";
                                $sql2.=" where bm.bidder_id=:bidder_id  ";
                                $sth2 = $conn->prepare($sql2);
                                $sth2->bindParam(':bidder_id', $bidder_id);
                                $sth2->execute();
                                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth2->fetch();
                                $billing_nm=$row2['billing_nm'];
                                $name=$row2['name'];
                                ?>
                                <tr>
                                    <th> 
                                        <input type="checkbox" name="check[]" id="check" value="<?php echo $fad_id; ?>">
                                        <input type="hidden" name="acd[<?php echo $fad_id; ?>]" value="<?php echo  $acd_id; ?>">
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
                                    </td>
                                    <td><?php echo $name; ?></td>  
                                    <td><?php echo $billing_nm; ?></td>  
                                    <td>
                                        <select name="act[<?php echo $fad_id; ?>]" id="act<?php echo $fad_id; ?>" class="form-control">
                                            <option value="A">Approve</option>
                                            <option value="R">Reject</option>
                                        </select>
                                    </td>
                                    
                                </tr>
                               
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

<script type="text/javascript" src="./bower_components/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="./bower_components/daterangepicker/daterangepicker.css" />

<script>
$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
 
 </script>
<?php include('./footer.php'); ?>
<script src="<?php echo $full_url; ?>/customjs/approval.js"></script>
