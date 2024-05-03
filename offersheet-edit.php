<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
error_reporting(1);
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';

$update = isset($_POST['update']) ? $_POST['update'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';


$auc_id = isset($_POST['auc_id']) ? $_POST['auc_id'] : '';

$offer_period = isset($_POST['offer_period']) ? $_POST['offer_period'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
$contract_type = isset($_POST['contract_type']) ? $_POST['contract_type'] : '';
$knockdown_period = isset($_POST['knockdown_period']) ? $_POST['knockdown_period'] : '';

if($update=="Update")
{
    try
    {
        $offer_start_dt=british_to_ansi(substr($offer_period,0,10));
        $start_tm=substr($offer_period,11,5); 
        $offer_end_dt=british_to_ansi(substr($offer_period,19,10));
        $end_tm=substr($offer_period,30,5); 

        $offer_start_time=$offer_start_dt.' '.$start_tm.':00';
        $offer_end_time=$offer_end_dt.' '.$end_tm.':00';
        

        $knockdown_start_dt=british_to_ansi(substr($knockdown_period,0,10));
        $knockdown_start_tm=substr($knockdown_period,11,5); 
        $knockdown_end_dt=british_to_ansi(substr($knockdown_period,19,10));
        $knockdown_end_tm=substr($knockdown_period,30,5); 

        $knockdown_start_time=$knockdown_start_dt.' '.$knockdown_start_tm.':00';
        $knockdown_end_time=$knockdown_end_dt.' '.$knockdown_end_tm.':00';

        $sqlI="update auction_mas set ";
        $sqlI.=" auc_start_time=:offer_start_time,auc_end_time=:offer_end_time,location=:location,payment_type=:payment_type ";
        $sqlI.=" ,contract_type=:contract_type,knockdown_start=:knockdown_start_time,knockdown_end=:knockdown_end_time ";
        $sqlI.=" where auc_id=:auc_id ";
        $sthI = $conn->prepare($sqlI);
        $sthI->bindParam(':offer_start_time', $offer_start_time);
        $sthI->bindParam(':offer_end_time', $offer_end_time);
        $sthI->bindParam(':location', $location);
        $sthI->bindParam(':payment_type', $payment_type);
        $sthI->bindParam(':contract_type', $contract_type);
        $sthI->bindParam(':knockdown_start_time', $knockdown_start_time);
        $sthI->bindParam(':knockdown_end_time', $knockdown_end_time);
        $sthI->bindParam(':auc_id', $auc_id);
        $sthI->execute();
        ?>
        <script>
            alertify.alert("Offersheet updated", function(){
                window.location.href='./setting.php';
            });         
        </script>
        <?php
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        echo $e->getLine();
    }
    
}
  ?>
  
  <style>


    .text-error
    {
        background-color:red;
        color:#FFF;
        font-weight:bold;
    }
</style>
<?php
$sql=" select auc_id,auc_start_time,auc_end_time,knockdown_start,knockdown_end";
$sql.=" ,location,payment_type,contract_type,offer_nm,offer_srl,tea_place,sale_type ";
$sql.=" ,frequently,duration,offer_srl_id ";
$sql.=" from auction_mas where md5(auc_id)=:param ";
$sth = $conn->prepare($sql);
$sth->bindParam(':param', $param);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
$e_auc_id=$row['auc_id'];
$e_auc_start_time=$row['auc_start_time'];
$e_auc_end_time=$row['auc_end_time'];
$e_knockdown_start=$row['knockdown_start'];
$e_knockdown_end=$row['knockdown_end'];
$e_location=$row['location'];
$e_payment_type=$row['payment_type'];
$e_contract_type=$row['contract_type'];
$e_offer_nm=$row['offer_nm'];
$e_offer_srl=$row['offer_srl'];
$e_tea_place=$row['tea_place'];
$e_sale_type=$row['sale_type'];

$offer_period=ansi_to_british(substr($e_auc_start_time,0,10)).' '.substr($e_auc_start_time,11,5).' - '.ansi_to_british(substr($e_auc_end_time,0,10)).' '.substr($e_auc_end_time,11,5);
$knockdown_period=ansi_to_british(substr($e_knockdown_start,0,10)).' '.substr($e_knockdown_start,11,5).' - '.ansi_to_british(substr($e_knockdown_end,0,10)).' '.substr($e_knockdown_end,11,5);
?>

<div id="preloder">
  <div class="loader"></div>
</div>
<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header  with-border">
                    <h3 class="box-title">Offersheet Upload</h3>  
                    <div class="box-tools pull-right">
                       
                    </div>                  
                </div>
                    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
                    <input type="hidden" id="to_date" value="<?php echo date('d/m/Y'); ?>" />
                    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
                    <input type="hidden" id="hid_place" name="hid_place" value="<?php echo $e_place; ?>" />
                    <input type="hidden" id="offer_srl_no" name="offer_srl_no" value="<?php echo $offer_srl_no; ?>" />
                    <input type="hidden" id="auc_id" name="auc_id" value="<?php echo $e_auc_id; ?>" />
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="place" class="col-sm-4">Offsheet No</label>
                                <div class="col-sm-8">
                                    <input type="text" name="srl_no" id="srl_no" maxlength="50" class="form-control" readonly value="<?php echo $e_offer_srl; ?>"  tabindex="1" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Offer Period" class="col-sm-4">Offer Period</label>
                                <div class="col-sm-8">
                                    <input type="text" name="offer_period" id="offer_period"  class="form-control"  value="<?php echo $offer_period; ?>" readonly="readonly" tabindex="2">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="location" class="col-sm-4">Location</label>
                                <div class="col-sm-8">
                                    <select name="location" id="location" class="form-control select2">
                                        <option value=""></option>
                                        <?php
                                        $sqle= "select loc_id,loc_desc ";
                                        $sqle.="from location_mas order by loc_desc";
                                        $sth = $conn->prepare($sqle);
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row = $sth->fetchAll();
                                        foreach ($row as $key => $value) 
                                        {
                                            $loc_id=$value['loc_id'];
                                            $loc_desc=$value['loc_desc'];
                                            ?>
                                            <option value="<?php echo $loc_desc; ?>" <?php if($loc_desc==$e_location){ echo "SELECTED"; } ?>><?php echo $loc_desc; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="payment_type" class="col-sm-4">Payment Type</label>
                                <div class="col-sm-8">
                                    <select name="payment_type" id="payment_type" class="form-control select2">
                                        <option value=""></option>
                                        <?php
                                        $sqle= "select pt_id,pt_desc ";
                                        $sqle.="from payment_type_mas order by pt_desc";
                                        $sth = $conn->prepare($sqle);
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row = $sth->fetchAll();
                                        foreach ($row as $key => $value) 
                                        {
                                            $pt_id=$value['pt_id'];
                                            $pt_desc=$value['pt_desc'];
                                            ?>
                                            <option value="<?php echo $pt_desc; ?>" <?php if($pt_desc==$e_payment_type){ echo "SELECTED"; } ?>><?php echo $pt_desc; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="contract_type" class="col-sm-4">Contract Type</label>
                                <div class="col-sm-8">
                                    <select name="contract_type" id="contract_type" class="form-control select2">
                                        <option value=""></option>
                                        <?php
                                        $sqle= "select ct_id,ct_desc ";
                                        $sqle.="from contract_type_mas order by ct_desc";
                                        $sth = $conn->prepare($sqle);
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row = $sth->fetchAll();
                                        foreach ($row as $key => $value) 
                                        {
                                            $ct_id=$value['ct_id'];
                                            $ct_desc=$value['ct_desc'];
                                            ?>
                                            <option value="<?php echo $ct_desc; ?>" <?php if($ct_desc==$e_contract_type){ echo "SELECTED"; } ?>><?php echo $ct_desc; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                      
                        <input type="hidden" name="auct_type" id="auct_type" maxlength="25" class="form-control"  value="E"  tabindex="8" >

                        <div id="auct_type_div">

                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Knock Down Period" class="col-sm-4">Knock Down Period</label>
                                <div class="col-sm-8">
                                    <input type="text" name="knockdown_period" id="knockdown_period"  class="form-control"  value="<?php echo $knockdown_period; ?>" readonly="readonly" tabindex="2">
                                </div>
                            </div>
                        </div>
                        
                        <div id="info"></div>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo $full_url; ?>/index.php" class="btn btn-default">Cancel</a>
                        <input type="submit" name="update" id="update" class="btn btn-success pull-right" value="Update"
                            tabindex="13">
                    </div>
            </div>
        </div>
    </div>
    
<?php 

include('./footer.php'); ?>
<script src="<?php echo $full_url; ?>/customjs/excel-upload.js?v=<?php echo date('YmdHis'); ?>"></script>
<script type="text/javascript" src="./bower_components/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="./bower_components/daterangepicker/daterangepicker.css" />

<script>
$(document).ready(function(){
  $("#fileUploadForm").on("submit", function(){
    $("#preloder").fadeIn();
  });
});
var to_date = $('#to_date').val();

$('#offer_period').daterangepicker({
    timePicker: true,
    autoUpdateInput: true,
   // minDate: moment().startOf('hour').add(1, 'hour'),
    /*startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(24, 'hour'),*/
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    }
  });
  $('#knockdown_period').daterangepicker({
    timePicker: true,
    autoUpdateInput: true,
   // minDate: moment().startOf('hour').add(1, 'hour'),
   /* startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(1, 'hour'),*/
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    }
  });
</script>
