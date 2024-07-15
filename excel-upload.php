<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
error_reporting(1);
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
$offer_excel = isset($_FILES['offer_excel']) ? $_FILES['offer_excel'] : '';
$update = isset($_POST['update']) ? $_POST['update'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';


$hid_place = isset($_POST['hid_place']) ? $_POST['hid_place'] : '';
$place = isset($_POST['place']) ? $_POST['place'] : '';
$offer_srl_no = isset($_POST['offer_srl_no']) ? $_POST['offer_srl_no'] : '';
$offer_period = isset($_POST['offer_period']) ? $_POST['offer_period'] : '';
$knockdown_period = isset($_POST['knockdown_period']) ? $_POST['knockdown_period'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
$contract_type = isset($_POST['contract_type']) ? $_POST['contract_type'] : '';


$auct_type = isset($_POST['auct_type']) ? $_POST['auct_type'] : '';
/*$frequently = isset($_POST['frequently']) ? $_POST['frequently'] : '';
$duration = isset($_POST['duration']) ? $_POST['duration'] : '';*/
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

      // if($frequently==''){ $frequently=0;}

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
            $sqlI.=" offer_srl_id=trim(:place),offer_start_time=:offer_start_time,offer_end_time=:offer_end_time ";
            $sqlI.=" ,location=:location,payment_type=:payment_type,contract_type=:contract_type ";
            $sqlI.=" ,knockdown_start=:knockdown_start_time,knockdown_end=:knockdown_end_time ";
            $sthI = $conn->prepare($sqlI);
            $sthI->bindParam(':place', $place);
            $sthI->bindParam(':offer_start_time', $offer_start_time);
            $sthI->bindParam(':offer_end_time', $offer_end_time);
            $sthI->bindParam(':location', $location);
            $sthI->bindParam(':payment_type', $payment_type);
            $sthI->bindParam(':contract_type', $contract_type);
            $sthI->bindParam(':knockdown_start_time', $knockdown_start_time);
            $sthI->bindParam(':knockdown_end_time', $knockdown_end_time);
            $sthI->execute();
        }
        else
        {
            $sqlI="insert into offer_mas ( ";
            $sqlI.=" offer_srl_id,offer_start_time,offer_end_time,location,payment_type,contract_type,knockdown_start,knockdown_end ";
            $sqlI.=" ) values ( ";
            $sqlI.=" :place,:offer_start_time,:offer_end_time,:location,:payment_type,:contract_type,:knockdown_start_time,:knockdown_end_time ";
            $sqlI.=" ) ";
            $sthI = $conn->prepare($sqlI);
            $sthI->bindParam(':place', $place);
            $sthI->bindParam(':offer_start_time', $offer_start_time);
            $sthI->bindParam(':offer_end_time', $offer_end_time);
            $sthI->bindParam(':location', $location);
            $sthI->bindParam(':payment_type', $payment_type);
            $sthI->bindParam(':contract_type', $contract_type);
            $sthI->bindParam(':knockdown_start_time', $knockdown_start_time);
            $sthI->bindParam(':knockdown_end_time', $knockdown_end_time);
            $sthI->execute();
        }
        $uploaddir="uploads/";
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
                        $sqlI.=" offer_no,offer_start_time,offer_end_time,location,payment_type,contract_type,offer_srl_id ";
                        $sqlI.=" ,lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price ";
                        $sqlI.=" ,excel_path,msp,knockdown_start,knockdown_end  ";
                        $sqlI.=" ) values ( ";
                        $sqlI.=" :offer_srl_no,:offer_start_time,:offer_end_time,:location,:payment_type,:contract_type,:place ";
                        $sqlI.=" ,:lot,trim(:garden),trim(:grade),:invoice,:gp_date,:chest,:net,:sold_pkgs,:valuation,:price ";
                        $sqlI.=" ,:file_f1,:msp,:knockdown_start_time,:knockdown_end_time ";
                        $sqlI.=" ) ";
                        $sthI = $conn->prepare($sqlI);
                        $sthI->bindParam(':knockdown_start_time', $knockdown_start_time);
                        $sthI->bindParam(':knockdown_end_time', $knockdown_end_time);
                        $sthI->bindParam(':offer_srl_no', $offer_srl_no);
                        $sthI->bindParam(':offer_start_time', $offer_start_time);
                        $sthI->bindParam(':offer_end_time', $offer_end_time);
                        $sthI->bindParam(':location', $location);
                        $sthI->bindParam(':payment_type', $payment_type);
                        $sthI->bindParam(':contract_type', $contract_type);
                        $sthI->bindParam(':place', $place);
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
        $sql=" select offer_nm,offer_no,offer_start_time,offer_end_time,location,payment_type ";
        $sql.=" ,contract_type,offer_srl_id,excel_path,knockdown_start,knockdown_end from temp_mas  limit 1";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $sth->fetch();
        $offer_nm=$row2['offer_nm'];
        $offer_no=$row2['offer_no'];
        $offer_start_time=$row2['offer_start_time'];
        $offer_end_time=$row2['offer_end_time'];
        $location=$row2['location'];
        $payment_type=$row2['payment_type'];
        $contract_type=$row2['contract_type'];
        $offer_srl_id=$row2['offer_srl_id'];
        $excel_path=$row2['excel_path'];
        $knockdown_start=$row2['knockdown_start'];
        $knockdown_end=$row2['knockdown_end'];

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
            $sale_type='E';
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
$sql=" select om.offer_srl_id,os.offer_srl,os.place,om.offer_start_time";
$sql.=" ,om.offer_end_time,om.location,om.payment_type,om.contract_type ";
$sql.=" ,om.knockdown_start,om.knockdown_end ";
$sql.=" from offer_mas om, offer_srl_mas os where om.offer_srl_id=os.offer_id ";
$sth = $conn->prepare($sql);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetch();
$e_offer_srl_id=$row['offer_srl_id'];
$e_offer_srl=$row['offer_srl'];
$e_place=$row['place'];
$e_offer_start_time1=$row['offer_start_time'];
$e_offer_end_time1=$row['offer_end_time'];
$e_end_tm=$row['end_tm'];
$e_location=$row['location'];
$e_payment_type=$row['payment_type'];
$e_contract_type=$row['contract_type'];
$e_prompt_days=$row['prompt_days'];
$offer_period=null;

if(strlen($e_offer_start_time1)>10)
{
    $e_offer_start_time=ansi_to_british(substr($e_offer_start_time1,0,10)).' '.substr($e_offer_start_time1,11,5); 
    $e_offer_end_time=ansi_to_british(substr($e_offer_end_time1,0,10)).' '.substr($e_offer_end_time1,11,5); 

    $offer_period=$e_offer_start_time.' - '.$e_offer_end_time;
}
if(strlen($e_start_tm)==8){ $e_start_tm=date("h:i A", strtotime($e_start_tm));  }
if(strlen($e_end_tm)==8){ $e_end_tm=date("h:i A", strtotime($e_end_tm)); }

$offer_no='/'.date('Y').'/'.str_pad($e_offer_srl,4,"0",STR_PAD_LEFT);
$offer_srl_no=$e_place.'/'.date('Y').'/'.str_pad($e_offer_srl,4,"0",STR_PAD_LEFT);

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
                       <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                            Sample Data Sheet
                        </button>-->
                        <a href="./images/sample-data-sale.xlsx" class="btn btn-info">Sample Data Sheet</a>
                    </div>                  
                </div>
                    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
                    <input type="hidden" id="to_date" value="<?php echo date('d/m/Y'); ?>" />
                    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
                    <input type="hidden" id="hid_place" name="hid_place" value="<?php echo $e_place; ?>" />
                    <input type="hidden" id="offer_srl_no" name="offer_srl_no" value="<?php echo $offer_srl_no; ?>" />
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="place" class="col-sm-4">Offsheet No</label>
                                <div class="col-sm-4">
                                    <select name="place" id="place" class="form-control select2">
                                        <option value=""></option>
                                        <?php
                                        $sqle= "select offer_id,place,offer_srl ";
                                        $sqle.="from offer_srl_mas order by place";
                                        $sth = $conn->prepare($sqle);
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row = $sth->fetchAll();
                                        foreach ($row as $key => $value) 
                                        {
                                            $offer_id=$value['offer_id'];
                                            $place=$value['place'];
                                            ?>
                                            <option value="<?php echo $offer_id; ?>" <?php if($e_offer_srl_id==$offer_id){ echo "SELECTED"; } ?>><?php echo $place; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="srl_no" id="srl_no" maxlength="50" class="form-control" readonly value="<?php echo $offer_no; ?>"  tabindex="1" >
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="offer_nm" class="col-sm-4">Offer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="offer_nm" id="offer_nm" maxlength="50" class="form-control"  value="<?php echo $e_offer_nm; ?>"  tabindex="1" >
                                </div>
                            </div>
                        </div>-->
                        <input type="hidden" name="offer_nm" id="offer_nm" maxlength="50" class="form-control"  value="<?php echo $e_offer_nm; ?>"  tabindex="1" >

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
                        
                        <!--<div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="auct_type" class="col-sm-4">Type Of Sale</label>
                                <div class="col-sm-8">
                                    <select name="auct_type" id="auct_type" class="form-control select2">
                                        <option value="E">ENGLISH</option>
                                        <option value="J">JAPANESE</option>
                                    </select>
                                </div>
                            </div>
                        </div>-->
                        <input type="hidden" name="auct_type" id="auct_type" maxlength="25" class="form-control"  value="E"  tabindex="8" >

                        <div id="auct_type_div">

                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Knock Down Period" class="col-sm-4">Knock Down Period</label>
                                <div class="col-sm-8">
                                    <input type="text" name="knockdown_period" id="knockdown_period"  class="form-control"  value="" readonly="readonly" tabindex="2">
                                </div>
                            </div>
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
                                 $garden_nm[]=trim($value['garden_nm']);
                             }
                             $sqle= "select grade ";
                             $sqle.="from grade_mas ";
                             $sth = $conn->prepare($sqle);
                             $sth->execute();
                             $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                             $row = $sth->fetchAll();
                             foreach ($row as $key => $value) 
                             {
                                 $grades[]=trim($value['grade']);
                             }
                            // print_r($garden_nm);
                            $sl=0;
                            $error=0;
                            $sqle= "select offer_nm,offer_start_time,offer_end_time,offer_no,location,payment_type,contract_type";
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
