<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';

$sqle= "select auc_id,auc_dt,auc_tm,end_tm,offer_srl,offer_nm,location,payment_type,contract_type,prompt_days ";
$sqle.="from auction_mas ";
$sqle.="where md5(auc_id)=:param ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
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
if(strlen($e_end_tm)==8){ $e_end_tm1=date("h:i A", strtotime($e_end_tm)); } else {{ $e_end_tm1=null; }}

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
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-body no-padding">
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
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tr>
                        <th>Location</th>
                        <th>Payment Type</th>
                        <th>Contact Type</th>
                        <th>Prompt Days</th>
                    </tr>
                    <tr>
                        <th><?php echo $e_location; ?></th>
                        <th><?php echo $e_payment_type; ?></th>
                        <th><?php echo "$e_contract_type"; ?></th>
                        <th><?php echo "$e_prompt_days"; ?></th>
                    </tr>
                </table>
            </div>
        <div>
    </div>
</div>
<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped">
                        <tr>
                            <th>Lot No</th>
                            <th>Garden</th>
                            <th>Invoice</th>
                            <th>Grade</th>
                            <th>Package</th>
                            <th>Bid</i></th>
                            <th>#</i></th>
                        </tr>
                        <?php
                        $sl=0;
                        $current_time=date("H:i:s",time());
                        $sqle= "select lot_no,garden_nm,grade,invoice_no ";
                        $sqle.="from auction_dtl ";
                        $sqle.="where auc_id=:auc_id ";
                        $sth = $conn->prepare($sqle);
                        $sth->bindParam(':auc_id', $auc_id);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                            $sl++;
                            $lot_no=$value['lot_no'];
                            $garden_nm=$value['garden_nm'];
                            $grade=$value['grade'];
                            $invoice_no=$value['invoice_no'];
                            ?>
                            <tr>
                                <td><?php echo $lot_no; ?></td>
                                <td><?php echo $garden_nm; ?></td>
                                <td><?php echo $invoice_no; ?></td>
                                <td><?php echo $grade; ?></td>
                                <td><?php echo $grade; ?></td>
                                <td><input type="text" value="" class="form-control" size="3"></td>
                                <td><input type="button" class="btb btn-success" value="Bid"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
       
    
</form>


<?php include('./footer.php'); ?>
