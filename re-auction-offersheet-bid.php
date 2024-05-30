<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';
$curtime=date('H:i:s');

$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$check = isset($_POST['check']) ? $_POST['check'] : '';
$auc_id = isset($_POST['auc_id']) ? $_POST['auc_id'] : '';

if($submit=='Submit')
{
    try{
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
        $sql=" select am.location,am.payment_type,am.contract_type,am.tea_place,am.sale_type ";
        $sql.=" ,am.frequently,am.duration,am.offer_srl_id,os.offer_srl,os.place,am. ";
        $sql.=" from auction_mas am,offer_srl_mas os ";
        $sql.=" where am.auc_id=:auc_id and am.offer_srl_id=os.offer_srl_id ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':auc_id', $auc_id);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $location=$row['location'];
        $payment_type=$row['payment_type'];
        $contract_type=$row['contract_type'];
        $tea_place=$row['tea_place'];
        $sale_type=$row['sale_type'];
        $frequently=$row['frequently'];
        $duration=$row['duration'];
        $offer_srl_id=$row['offer_srl_id'];
        $offer_srl=$row['offer_srl'];
        $place=$row['place'];

        $offer_srl_no=$place.'/'.date('Y').'/'.str_pad($offer_srl,4,"0",STR_PAD_LEFT);



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

        $sqlI="insert into auction_mas ( ";
        $sqlI.=" auc_start_time,auc_end_time,location,payment_type ";
        $sqlI.=" ,contract_type,offer_nm,offer_srl,offer_srl_id,knockdown_start,knockdown_end ";
        $sqlI.=" ) values ( ";
        $sqlI.=" :offer_start_time,:offer_end_time,:location,:payment_type,:contract_type ";
        $sqlI.=" ,:offer_nm,:offer_no,:offer_srl_id,:knockdown_start,:knockdown_end ";
        $sqlI.=" ) ";
        $sthI = $conn->prepare($sqlI);
        $sthI->bindParam(':offer_start_time', $offer_start_time);
        $sthI->bindParam(':offer_end_time', $offer_end_time);
        $sthI->bindParam(':location', $location);
        $sthI->bindParam(':payment_type', $payment_type);
        $sthI->bindParam(':contract_type', $contract_type);
        $sthI->bindParam(':offer_nm', $offer_nm);
        $sthI->bindParam(':offer_no', $offer_no);
        $sthI->bindParam(':offer_srl_id', $offer_srl_id);
        $sthI->bindParam(':knockdown_start', $knockdown_start);
        $sthI->bindParam(':knockdown_end', $knockdown_end);
        $sthI->execute();
        $auc_id=$conn->lastInsertId();

        $sqlI="update offer_srl_mas set ";
        $sqlI.=" offer_srl=offer_srl+1 where offer_id=:offer_srl_id ";
        $sthI = $conn->prepare($sqlI);
        $sthI->bindParam(':offer_srl_id', $offer_srl_id);
        $sthI->execute();

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
            $sthI->bindParam(':max_bid_price', $max_bid_price[$ck]);
            $sthI->bindParam(':bidder', $bidder[$ck]);
            $sthI->bindParam(':acd_id', $ck);
            $sthI->execute();
            $fad_id=$conn->lastInsertId();

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

            $sqle= "select uid,com_srl,design_nm ";
            $sqle.="from user_mas WHERE status='A' and committee='Y'  ";
            $sth = $conn->prepare($sqle);
            $sth->execute();
            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetchAll();
            foreach ($row as $key => $value) 
            {
              $uid=$value['uid'];
              $com_srl=$value['com_srl'];
              $design_nm=$value['design_nm'];

                $sql_ins =" insert into bid_app_dtl (auc_id,acd_id,uid,seq_id,fad_id) ";
                $sql_ins .=" values ";
                $sql_ins .=" (:auc_id,:acd_id,:uid,:com_srl,:fad_id)   ";
                $sthI = $conn->prepare($sql_ins);
                $sthI->bindParam(':auc_id', $auc_id);
                $sthI->bindParam(':acd_id', $ck);
                $sthI->bindParam(':uid', $uid);
                $sthI->bindParam(':com_srl', $com_srl);
                $sthI->bindParam(':fad_id', $fad_id);
                $sthI->execute();
            }
        }
        ?>
        <script>
        alertify.alert("Knock Down Successfully.", function(){
          //  window.open('knockdown-offersheet-bid.php?param=<?php echo md5($auc_id); ?>','_self');
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
    }catch(Exception $e)
    {
        echo $e->getMessage();
        echo $e->getLine();
    }
}


$sqle= "select auc_id,auc_start_time,auc_end_time,knockdown_end,knockdown_start,knockdown_end,offer_srl,offer_nm,location,payment_type ";
$sqle.= " ,contract_type ";
$sqle.="from auction_mas ";
$sqle.="where md5(auc_id)=:param  and knockdown_end<current_timestamp ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
if($row)
{
    $auc_id=$row['auc_id'];
    $e_auc_start_time=$row['auc_start_time'];
    $e_knockdown_end_time=$row['knockdown_end'];
    $e_auc_start=ansi_to_british(substr($row['auc_start_time'],0,10));
    $e_auc_end=ansi_to_british(substr($row['auc_end_time'],0,10));

    $e_knockdown_start_time=$row['knockdown_start'];
    $e_knockdown_end_time=$row['knockdown_end'];
    $e_knockdown_start=ansi_to_british(substr($row['knockdown_start'],0,10));
    $e_knockdown_end=ansi_to_british(substr($row['knockdown_end'],0,10));

    $e_offer_srl=$row['offer_srl'];
    $e_location=$row['location'];
    $e_payment_type=$row['payment_type'];
    $e_contract_type=$row['contract_type'];
    
    ?>

    


    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    
                </div>
                <div class="box-body no-padding  table-responsive ">
                    <table class="table table-bordered">
                        <tr>
                            <th>Offersheet No</th>
                            <th>Auction Time</th>
                            <th>Knockdown Time</th>
                            <th>Location</th>
                            <th>Payment Type</th>
                            <th>Contract Type</th>
                        </tr>
                        <tr>
                            <th><?php echo $e_offer_srl; ?></th>
                            <th><?php echo $e_auc_start.' '.substr($row['auc_start_time'],11,5).' '.$e_auc_end.' '.substr($row['auc_end_time'],11,5); ?></th>
                            <th><?php echo $e_knockdown_start.' '.substr($row['knockdown_start'],11,5).' '.$e_knockdown_end.' '.substr($row['knockdown_end'],11,5); ?></th>
                            <th><?php echo $e_location; ?></th>
                            <th><?php echo $e_payment_type; ?></th>
                            <th><?php echo $e_contract_type; ?></th>
                        </tr>
                    </table>
                </div>
            <div>
        </div>
    </div>
<div id="preloder">
  <div class="loader"></div>
</div>

<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
    <input type="hidden" id="auc_id" name="auc_id" value="<?php echo $auc_id; ?>" />
    <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <input type="button" class="btn btn-danger"  value="Re-Auction"  data-toggle="modal" data-target="#modal-default">
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
                            </tr>
                            <?php
                            $sl=0;
                            $acds=array();
                            $current_time=date("H:i:s",time());
                            $sqle= "select acd_id,lot_no,garden_nm,grade,pkgs,net,invoice_no,msp,valu_kg,base_price ";
                            $sqle.="from auction_dtl ";
                            $sqle.="where auc_status='P' and auc_id=:auc_id ";
                            $sth = $conn->prepare($sqle);
                            $sth->bindParam(':auc_id', $auc_id);
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
                               
                                ?>
                                <tr>
                                    <th><input type="checkbox" name="check[]" id="check" value="<?php echo $acd_id; ?>"> </th>
                                    <td><?php echo $lot_no; ?></td>
                                    <td><?php echo $garden_nm; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <td><?php echo $pkgs; ?></td>
                                    <td><?php echo $net; ?></td>
                                    <td><?php echo $valu_kg; ?></td>
                                    <td><?php echo $invoice_no; ?></td>
                                    <td><?php echo $base_price; ?></td>
                                    <td><?php echo $msp; ?></td>
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
    <input type="submit" name="submit" id="submit" class="btn btn-success pull-right" value="Submit"  tabindex="13">
</div>
</div>

</div>

</div>
</form>

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
    minDate: moment().startOf('hour').add(1, 'hour'),
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(24, 'hour'),
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    }
  });
  $('#knockdown_period').daterangepicker({
    timePicker: true,
    minDate: moment().startOf('hour').add(1, 'hour'),
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(1, 'hour'),
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    }
  });
</script>
