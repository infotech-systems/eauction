<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
error_reporting(0);
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
$offer_excel = isset($_FILES['offer_excel']) ? $_FILES['offer_excel'] : '';
$update = isset($_POST['update']) ? $_POST['update'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$offer_nm = isset($_POST['offer_nm']) ? $_POST['offer_nm'] : '';
$offer_dt = isset($_POST['offer_dt']) ? $_POST['offer_dt'] : '';
$start_tm = isset($_POST['start_tm']) ? $_POST['start_tm'] : '';
$end_tm = isset($_POST['end_tm']) ? $_POST['end_tm'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
$contract_type = isset($_POST['contract_type']) ? $_POST['contract_type'] : '';
$prompt_days = isset($_POST['prompt_days']) ? $_POST['prompt_days'] : '';
$tea_place = isset($_POST['tea_place']) ? $_POST['tea_place'] : '';
$auct_type = isset($_POST['auct_type']) ? $_POST['auct_type'] : '';
$frequently = isset($_POST['frequently']) ? $_POST['frequently'] : '';
$duration = isset($_POST['duration']) ? $_POST['duration'] : '';
if($update=="Update")
{
    $start_tm1=null;
    $end_tm1=null;
    if(strlen($offer_dt)==10){
        $offer_dt1=british_to_ansi($offer_dt);
    }
    else
    {
        $offer_dt1=null;
    }
    if(strlen($start_tm)==8)
    {
        
        $start_tm1=date("H:i:s", strtotime($start_tm)); 
    }
    if(strlen($end_tm)==8){
        $end_tm1=date("H:i:s", strtotime($end_tm)); 
    
    }
    if($frequently==''){ $frequently=0;}
    try
    {
        $sql=" select count(*) as cnt from offer_mas  ";
       // echo "$sql--$otp--$email_id";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $sth->fetch();
        $cnt=$row2['cnt'];
        if($cnt>0)
        {
            $sqlI="update offer_mas set ";
            $sqlI.=" offer_nm=trim(upper(:offer_nm)),offer_dt=:offer_dt1,start_tm=:start_tm1,end_tm=:end_tm1 ";
            $sqlI.=" ,location=:location,payment_type=:payment_type,contract_type=:contract_type,prompt_days=:prompt_days ";
            $sthI = $conn->prepare($sqlI);
            $sthI->bindParam(':offer_nm', $offer_nm);
            $sthI->bindParam(':offer_dt1', $offer_dt1);
            $sthI->bindParam(':start_tm1', $start_tm1);
            $sthI->bindParam(':end_tm1', $end_tm1);
            $sthI->bindParam(':location', $location);
            $sthI->bindParam(':payment_type', $payment_type);
            $sthI->bindParam(':contract_type', $contract_type);
            $sthI->bindParam(':prompt_days', $prompt_days);
            $sthI->execute();
        }
        else
        {
            $sqlI="insert into offer_mas ( ";
            $sqlI.=" offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type,prompt_days ";
            $sqlI.=" ) values ( ";
            $sqlI.=" trim(upper(:offer_nm)),:offer_dt1,:start_tm1,:end_tm1,:location,:payment_type,:contract_type,:prompt_days ";
            $sqlI.=" ) ";
            $sthI = $conn->prepare($sqlI);
            $sthI->bindParam(':offer_nm', $offer_nm);
            $sthI->bindParam(':offer_dt1', $offer_dt1);
            $sthI->bindParam(':start_tm1', $start_tm1);
            $sthI->bindParam(':end_tm1', $end_tm1);
            $sthI->bindParam(':location', $location);
            $sthI->bindParam(':payment_type', $payment_type);
            $sthI->bindParam(':contract_type', $contract_type);
            $sthI->bindParam(':prompt_days', $prompt_days);
            $sthI->execute();
        }
        $uploaddir="uploads/";
    // echo $offer_excel['name'][0];
        if(!empty($offer_excel['name'][0]))
        {
            $file_f1=$uploaddir.fileCkecking2($offer_excel,0);;

            $excel_path=substr($file_f1,2);
            $Reader = new SpreadsheetReader($file_f1);
            $totalSheet = count($Reader->sheets());

            $sqlI=" truncate temp_mas  ";
            $sthI = $conn->prepare($sqlI);
            $sthI->execute();
            for($i=0;$i<$totalSheet;$i++)
            {
                $Reader-> ChangeSheet($i);
                $i=0;
                foreach ($Reader as $Row)
                {
                    $i++;
                    if($i>1)
                    {
                        $lot=$Row[1];
                        $garden=$Row[2];
                        $grade=$Row[3];
                        $invoice=$Row[4];
                        $gp_date=$Row[5];
                        $chest=$Row[6];
                        $net=$Row[7];
                        $sold_pkgs=$Row[8];
                        $valuation=$Row[9];
                        $price=$Row[10];
                        $msp=$Row[11];
                      //  echo "$invoic </br>";
                        $gp_date1=date("Y-m-d", strtotime($gp_date));  
                        if($msp==''){ $msp=0;}
                        if($sold_pkgs==''){ $sold_pkgs=0;}
                        if($price==''){ $price=0;}
                        if($price=='OUT'){ $price=0;}

                        $sqlI="insert into temp_mas ( ";
                        $sqlI.=" offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type,prompt_days ";
                        $sqlI.=" ,lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price,tea_place ";
                        $sqlI.=" ,sale_type,frequently,duration,excel_path,msp ";
                        $sqlI.=" ) values ( ";
                        $sqlI.=" trim(upper(:offer_nm)),:offer_dt1,:start_tm1,:end_tm1,:location,:payment_type,:contract_type,:prompt_days ";
                        $sqlI.=" ,:lot,trim(:garden),trim(:grade),:invoice,:gp_date,:chest,:net,:sold_pkgs,:valuation,:price,trim(upper(:tea_place)) ";
                        $sqlI.=" ,:auct_type,:frequently,:duration,:file_f1,:msp ";
                        $sqlI.=" ) ";
                        $sthI = $conn->prepare($sqlI);
                        $sthI->bindParam(':offer_nm', $offer_nm);
                        $sthI->bindParam(':offer_dt1', $offer_dt1);
                        $sthI->bindParam(':start_tm1', $start_tm1);
                        $sthI->bindParam(':end_tm1', $end_tm1);
                        $sthI->bindParam(':location', $location);
                        $sthI->bindParam(':payment_type', $payment_type);
                        $sthI->bindParam(':contract_type', $contract_type);
                        $sthI->bindParam(':prompt_days', $prompt_days);
                        $sthI->bindParam(':lot', $lot);
                        $sthI->bindParam(':garden', $garden);
                        $sthI->bindParam(':grade', $grade);
                        $sthI->bindParam(':invoice', $invoice);
                        $sthI->bindParam(':gp_date', $gp_date1);
                        $sthI->bindParam(':chest', $chest);
                        $sthI->bindParam(':net', $net);
                        $sthI->bindParam(':sold_pkgs', $sold_pkgs);
                        $sthI->bindParam(':valuation', $valuation);
                        $sthI->bindParam(':price', $price);
                        $sthI->bindParam(':tea_place', $tea_place);
                        $sthI->bindParam(':auct_type', $auct_type);
                        $sthI->bindParam(':frequently', $frequently);
                        $sthI->bindParam(':duration', $duration);
                        $sthI->bindParam(':file_f1', $file_f1);
                        $sthI->bindParam(':msp', $msp);
                        $sthI->execute();
                    }
                }
            }
            
           // unlink($file_f1);
        }
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        echo $e->getLine();
    }
    
}
if($submit=="Submit")
{
    try
    {
        $sql=" select offer_srl from offer_srl_mas  ";
       // echo "$sql--$otp--$email_id";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $offer_srl=$row['offer_srl'];
        

        $sql=" select offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type ";
        $sql.=" ,prompt_days,tea_place,sale_type,frequently,duration,excel_path from temp_mas  limit 1";
       // echo "$sql--$otp--$email_id";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $sth->fetch();
        $offer_nm=$row2['offer_nm'];
        $offer_dt=$row2['offer_dt'];
        $start_tm=$row2['start_tm'];
        $end_tm=$row2['end_tm'];
        $location=$row2['location'];
        $payment_type=$row2['payment_type'];
        $contract_type=$row2['contract_type'];
        $prompt_days=$row2['prompt_days'];
        $tea_place=$row2['tea_place'];
        $sale_type=$row2['sale_type'];
        $frequently=$row2['frequently'];
        $duration=$row2['duration'];
        $excel_path=$row2['excel_path'];

        $teaplace=str_replace(' ', '_', $tea_place);

        $offersheet_no=$teaplace.'/'.date('Y').'/'.str_pad($offer_srl,4,0,STR_PAD_LEFT);

        $sqlI="insert into auction_mas ( ";
        $sqlI.=" auc_dt,auc_tm,end_tm,location,payment_type ";
        $sqlI.=" ,contract_type,prompt_days,offer_nm,offer_srl,tea_place,sale_type,frequently,duration ";
        $sqlI.=" ) values ( ";
        $sqlI.=" :offer_dt,:start_tm,:end_tm,:location,:payment_type,:contract_type ";
        $sqlI.=" ,:prompt_days,:offer_nm,:offersheet_no,:tea_place,:sale_type,:frequently,:duration ";
        $sqlI.=" ) ";
        $sthI = $conn->prepare($sqlI);
        $sthI->bindParam(':offer_dt', $offer_dt);
        $sthI->bindParam(':start_tm', $start_tm);
        $sthI->bindParam(':end_tm', $end_tm);
        $sthI->bindParam(':location', $location);
        $sthI->bindParam(':payment_type', $payment_type);
        $sthI->bindParam(':contract_type', $contract_type);
        $sthI->bindParam(':prompt_days', $prompt_days);
        $sthI->bindParam(':offer_nm', $offer_nm);
        $sthI->bindParam(':offersheet_no', $offersheet_no);
        $sthI->bindParam(':tea_place', $tea_place);
        $sthI->bindParam(':sale_type', $sale_type);
        $sthI->bindParam(':frequently', $frequently);
        $sthI->bindParam(':duration', $duration);
        $sthI->execute();
        $auc_id=$conn->lastInsertId();

        $sqlI="update offer_srl_mas set ";
        $sqlI.=" offer_srl=offer_srl+1 ";
        $sthI = $conn->prepare($sqlI);
        $sthI->execute();
        
        $temp=0;
        $sqlA=" select temp_id,lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price,msp ";
        $sqlA.=" from temp_mas ";
    // echo "$sql--$otp--$email_id";
        $sthA = $conn->prepare($sqlA);
        $sthA->execute();
        $ss=$sthA->setFetchMode(PDO::FETCH_ASSOC);
        $rowA = $sthA->fetchAll();
        foreach ($rowA as $key => $valueA) 
        {
            $temp_id=$valueA['temp_id'];
            $lot=$valueA['lot'];
            $garden=$valueA['garden'];
            $grade=$valueA['grade'];
            $invoice=$valueA['invoice'];
            $gp_date=$valueA['gp_date'];
            $chest=$valueA['chest'];
            $net=$valueA['net'];
            $sold_pkgs=$valueA['sold_pkgs'];
            $valuation=$valueA['valuation'];
            $price=$valueA['price'];
            $msp=$valueA['msp'];
            if($sale_type=='E')
            {
    
                $sqlI1=" insert into auction_dtl ( ";
                $sqlI1.=" auc_id,lot_no,garden_nm,grade,invoice_no ";
                $sqlI1.=" ,gp_date,chest,net,pkgs,valu_kg,base_price,msp ";
                $sqlI1.=" ) values ( ";
                $sqlI1.=" :auc_id,:lot,:garden,:grade,:invoice ";
                $sqlI1.=" ,:gp_date,:chest,:net,:sold_pkgs,:valuation,:price,:msp ";
                $sqlI1.=" ) ";
            // echo $sqlI1;
                $sthI1 = $conn->prepare($sqlI1);
                $sthI1->bindParam(':auc_id', $auc_id);
                $sthI1->bindParam(':lot', $lot);
                $sthI1->bindParam(':garden', $garden);
                $sthI1->bindParam(':grade', $grade);
                $sthI1->bindParam(':invoice', $invoice);
                $sthI1->bindParam(':gp_date', $gp_date);
                $sthI1->bindParam(':chest', $chest);
                $sthI1->bindParam(':net', $net);
                $sthI1->bindParam(':sold_pkgs', $sold_pkgs);
                $sthI1->bindParam(':valuation', $valuation);
                $sthI1->bindParam(':price', $price);
                $sthI1->bindParam(':msp', $msp);
                $sthI1->execute();
            }
            else
            {
                
                if(($temp%$frequently===0) or ($temp==0))
                {
                    
                    $addtime="+".$duration." minutes"; 
                    
                    $endtime=strtotime($addtime, strtotime($start_tm));
                    $endtimes=date('H:i:s', $endtime);                    

                    $sqlI1=" insert into japanese_mas ( ";
                    $sqlI1.=" auc_id,jap_dt,jap_start,jap_end ";
                    $sqlI1.=" ) values ( ";
                    $sqlI1.=" :auc_id,:offer_dt,:start_tm,:endtimes";
                    $sqlI1.=" ) ";
                // echo $sqlI1;
                    $sthI1 = $conn->prepare($sqlI1);
                    $sthI1->bindParam(':auc_id', $auc_id);
                    $sthI1->bindParam(':offer_dt', $offer_dt);
                    $sthI1->bindParam(':start_tm', $start_tm);
                    $sthI1->bindParam(':endtimes', $endtimes);
                    $sthI1->execute();
                    $jap_id=$conn->lastInsertId();

                    $start_tm = strtotime($addtime, strtotime($start_tm));
                    $start_tm=date('H:i:s', $start_tm);

                }
                $sqlI1=" insert into auction_dtl ( ";
                $sqlI1.=" auc_id,jap_id,lot_no,garden_nm,grade,invoice_no ";
                $sqlI1.=" ,gp_date,chest,net,pkgs,valu_kg,base_price,msp ";
                $sqlI1.=" ) values ( ";
                $sqlI1.=" :auc_id,:jap_id,:lot,:garden,:grade,:invoice ";
                $sqlI1.=" ,:gp_date,:chest,:net,:sold_pkgs,:valuation,:price,:msp ";
                $sqlI1.=" ) ";
            // echo $sqlI1;
                $sthI1 = $conn->prepare($sqlI1);
                $sthI1->bindParam(':auc_id', $auc_id);
                $sthI1->bindParam(':jap_id', $jap_id);
                $sthI1->bindParam(':lot', $lot);
                $sthI1->bindParam(':garden', $garden);
                $sthI1->bindParam(':grade', $grade);
                $sthI1->bindParam(':invoice', $invoice);
                $sthI1->bindParam(':gp_date', $gp_date);
                $sthI1->bindParam(':chest', $chest);
                $sthI1->bindParam(':net', $net);
                $sthI1->bindParam(':sold_pkgs', $sold_pkgs);
                $sthI1->bindParam(':valuation', $valuation);
                $sthI1->bindParam(':price', $price);
                $sthI1->bindParam(':msp', $msp);
                $sthI1->execute();
                $temp++;
            }
        }
        
        $sqlA=" select mail_nm,mail_id ";
        $sqlA.=" from mailer_mas ";
    // echo "$sql--$otp--$email_id";
        $sthA = $conn->prepare($sqlA);
        $sthA->execute();
        $ss=$sthA->setFetchMode(PDO::FETCH_ASSOC);
        $rowA = $sthA->fetchAll();
        foreach ($rowA as $key => $valueA) 
        {
            $mail_nm=$valueA['mail_nm'];
            $mail_id=$valueA['mail_id'];
               
            $sqlI1=" insert into file_send_mas ( ";
            $sqlI1.=" auc_id,mail_id,recv_nm,excel_path ";
            $sqlI1.=" ) values ( ";
            $sqlI1.=" :auc_id,:mail_id,:mail_nm,:excel_path ";
            $sqlI1.=" ) ";
        // echo $sqlI1;
            $sthI1 = $conn->prepare($sqlI1);
            $sthI1->bindParam(':auc_id', $auc_id);
            $sthI1->bindParam(':mail_id', $mail_id);
            $sthI1->bindParam(':mail_nm', $mail_nm);
            $sthI1->bindParam(':excel_path', $excel_path);
            $sthI1->execute();
        }
        $sqlI=" truncate temp_mas  ";
        $sthI = $conn->prepare($sqlI);
        $sthI->execute();
        ?>
        <script>
            alertify.alert("Offersheet upload successfully", function(){
                window.location.href='./index.php';
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
$sql=" select offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type,prompt_days ";
$sql.=" from offer_mas ";
$sth = $conn->prepare($sql);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
$e_offer_nm=$row['offer_nm'];
$e_offer_dt=$row['offer_dt'];
$e_start_tm=$row['start_tm'];
$e_end_tm=$row['end_tm'];
$e_location=$row['location'];
$e_payment_type=$row['payment_type'];
$e_contract_type=$row['contract_type'];
$e_prompt_days=$row['prompt_days'];
if(strlen($e_offer_dt)==10){ $e_offer_dt=ansi_to_british($e_offer_dt); }
if(strlen($e_start_tm)==8){ $e_start_tm=date("h:i A", strtotime($e_start_tm));  }
if(strlen($e_end_tm)==8){ $e_end_tm=date("h:i A", strtotime($e_end_tm)); }
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
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                            Sample Data Sheet
                        </button>
                    </div>                  
                </div>
                    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
                    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
                    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
                    <div class="box-body">
                    <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="offer_nm" class="col-sm-4">Offer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="offer_nm" id="offer_nm" maxlength="50" class="form-control"  value="<?php echo $e_offer_nm; ?>"  tabindex="1" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="offer_dt" class="col-sm-4">Offer Date</label>
                                <div class="col-sm-8">
                                    <input type="text" name="offer_dt" id="offer_dt" maxlength="10" class="form-control"  value="<?php echo $e_offer_dt; ?>" readonly="readonly" tabindex="2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="start_tm" class="col-sm-4">Start Time</label>
                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" name="start_tm" id="start_tm" maxlength="8" class="form-control timepicker"  value="<?php echo $e_start_tm; ?>" readonly="readonly" tabindex="3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="end_tm" class="col-sm-4">End Time</label>
                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" name="end_tm" id="end_tm" maxlength="8" class="form-control timepicker"  value="<?php echo $e_end_tm; ?>" readonly="readonly" tabindex="4">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="location" class="col-sm-4">Location</label>
                                <div class="col-sm-8">
                                    <input type="text" name="location" id="location" maxlength="50" class="form-control"  value="<?php echo $e_location; ?>"  tabindex="5" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="payment_type" class="col-sm-4">Payment Type</label>
                                <div class="col-sm-8">
                                    <input type="text" name="payment_type" id="payment_type" maxlength="25" class="form-control"  value="<?php echo $e_payment_type; ?>"  tabindex="6" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="contract_type" class="col-sm-4">Contract Type</label>
                                <div class="col-sm-8">
                                    <input type="text" name="contract_type" id="contract_type" maxlength="25" class="form-control"  value="<?php echo $e_contract_type; ?>"  tabindex="7" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="prompt_days" class="col-sm-4">Prompt Days</label>
                                <div class="col-sm-8">
                                    <input type="text" name="prompt_days" id="prompt_days" maxlength="25" class="form-control"  value="<?php echo $e_prompt_days; ?>"  tabindex="8" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="tea_place" class="col-sm-4">Place Of Tea</label>
                                <div class="col-sm-8">
                                    <input type="text" name="tea_place" id="tea_place" maxlength="25" class="form-control"  value=""  tabindex="8" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="auct_type" class="col-sm-4">Type Of Sale</label>
                                <div class="col-sm-8">
                                    <select name="auct_type" id="auct_type" class="form-control select2">
                                        <option value="E">ENGLISH</option>
                                        <option value="J">JAPANESE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="auct_type_div">

                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="offer_excel" class="col-sm-4">Excel File</label>
                                <div class="col-sm-8">
                                    <input type="file" name="offer_excel[]" id="offer_excel" class="form-control"
                                        value="" onchange="ValidateSize(this)" tabindex="9" style="padding-top:2px;">
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
    if($update=='Update')
    {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header  with-border">
                        <h3 class="box-title">Excel Data List</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th>Sl.</th>
                                <th>Lot</th>
                                <th>Garden</th>
                                <th>Grade</th>
                                <th>Invoice</th>
                                <th>GPDate</th>
                                <th>Chest</th>
                                <th>Net</th>
                                <th>Sold_Pkgs</th>
                                <th>Valuation</th>
                                <th>Price</th>
                                <th>MSP</th>
                            </tr>
                            <?php
                            $garden_nm=array();
                            $grades=array();
                             $sqle= "select garden_nm ";
                             $sqle.="from garden_mas ";
                             $sth = $conn->prepare($sqle);
                             $sth->execute();
                             $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                             $row = $sth->fetchAll();
                             foreach ($row as $key => $value) 
                             {
                                 $garden_nm[]=$value['garden_nm'];
                             }
                             $sqle= "select grade ";
                             $sqle.="from grade_mas ";
                             $sth = $conn->prepare($sqle);
                             $sth->execute();
                             $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                             $row = $sth->fetchAll();
                             foreach ($row as $key => $value) 
                             {
                                 $grades[]=$value['grade'];
                             }
                            $sl=0;
                            $error=0;
                            $sqle= "select offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type,prompt_days";
                            $sqle.= " ,lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price,msp ";
                            $sqle.="from temp_mas order by temp_id ";
                            $sth = $conn->prepare($sqle);
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetchAll();
                            foreach ($row as $key => $value) 
                            {
                                $sl++;
                                $e_lot=$value['lot'];
                                $e_msp=$value['msp'];
                                $e_garden=$value['garden'];
                                $gcolor=null;
                                if(!in_array($e_garden,$garden_nm))
                                {
                                    $gcolor='class="text-error"';
                                    $error++;
                                    $sqlI="insert into garden_mas (garden_nm) values (trim(upper(:e_garden))) ";
                                    $sthI = $conn->prepare($sqlI);
                                    $sthI->bindParam(':e_garden', $e_garden);
                                   // $sthI->execute();
                                }
                                
                                $e_grade=$value['grade'];
                                $grcolor=null;
                                if(!in_array($e_grade,$grades))
                                {
                                    $grcolor='class="text-error"';
                                    $error++;
                                    $sqlI="insert into grade_mas (grade) values (trim(upper(:e_grade))) ";
                                    $sthI = $conn->prepare($sqlI);
                                    $sthI->bindParam(':e_grade', $e_grade);
                                   // $sthI->execute();
                                }
                                $e_invoice=$value['invoice'];
                                $e_gp_date=$value['gp_date'];
                                $e_chest=$value['chest'];
                                $e_net=$value['net'];
                                $e_sold_pkgs=$value['sold_pkgs'];
                                $e_valuation=$value['valuation'];
                                $e_price=$value['price'];
                                if(strlen($e_gp_date)==10)
                                {
                                    $e_gp_date=date("d-M-Y", strtotime($e_gp_date));   
                                }
                                $e_offer_nm=$value['offer_nm'];
                                $e_offer_dt=$value['offer_dt'];
                                $e_start_tm=$value['start_tm'];
                                $e_end_tm=$value['end_tm'];
                                $e_location=$value['location'];
                                $e_payment_type=$value['payment_type'];
                                $e_contract_type=$value['contract_type'];
                                $e_prompt_days=$value['prompt_days'];
                                if(strlen($e_offer_dt)==10){ $e_offer_dt=ansi_to_british($e_offer_dt); }
                                if(strlen($e_offer_dt)==10){ $e_start_tm=date("H:i:s", strtotime($e_start_tm));  }
                                if(strlen($e_offer_dt)==10){ $e_end_tm=date("H:i:s", strtotime($e_end_tm)); }
                                ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $e_lot; ?></td>
                                    <td <?php echo $gcolor; ?>><?php echo $e_garden; ?></td>
                                    <td <?php echo $grcolor; ?>><?php echo $e_grade; ?></td>
                                    <td><?php echo $e_invoice; ?></td>
                                    <td><?php echo $e_gp_date; ?></td>
                                    <td><?php echo $e_chest; ?></td>
                                    <td><?php echo $e_net; ?></td>
                                    <td><?php echo $e_sold_pkgs; ?></td>
                                    <td><?php echo $e_valuation; ?></td>
                                    <td><?php echo $e_price; ?></td>
                                    <td><?php echo $e_msp; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo $full_url; ?>/emp-cat-mas.php" class="btn btn-default">Cancel</a>
                        <?php
                        if($error==0)
                        {
                            ?>
                            <input type="submit" name="submit" id="submit" class="btn btn-success pull-right" value="Submit"
                            tabindex="13">
                            <?php
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</form>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sample Excel File</h4>
            </div>
            <div class="modal-body">
                <ul>
                    <li><a href="./images/english-type-sale.xlsx" class="text-green">English Type</a></li>
                    <li><a href="./images/japanese-type-sale.xlsx"  class="text-green">Japanese Type</a></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php 

include('./footer.php'); ?>

<script src="<?php echo $full_url; ?>/customjs/excel-upload.js"></script>
-
<script>
$(document).ready(function(){
  $("#fileUploadForm").on("submit", function(){
    $("#preloder").fadeIn();
  });
});
</script>
