<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
error_reporting(0);
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
$offer_excel = isset($_FILES['offer_excel']) ? $_FILES['offer_excel'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$offer_nm = isset($_POST['offer_nm']) ? $_POST['offer_nm'] : '';
$offer_dt = isset($_POST['offer_dt']) ? $_POST['offer_dt'] : '';
$start_tm = isset($_POST['start_tm']) ? $_POST['start_tm'] : '';
$end_tm = isset($_POST['end_tm']) ? $_POST['end_tm'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
$contract_type = isset($_POST['contract_type']) ? $_POST['contract_type'] : '';
$prompt_days = isset($_POST['prompt_days']) ? $_POST['prompt_days'] : '';
if($submit=="Submit")
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
                      //  echo "$invoic </br>";
                        $gp_date1=date("Y-m-d", strtotime($gp_date));  

                        $sqlI="insert into temp_mas ( ";
                        $sqlI.=" offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type,prompt_days ";
                        $sqlI.=" ,lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price ";
                        $sqlI.=" ) values ( ";
                        $sqlI.=" trim(upper(:offer_nm)),:offer_dt1,:start_tm1,:end_tm1,:location,:payment_type,:contract_type,:prompt_days ";
                        $sqlI.=" ,:lot,:garden,:grade,:invoice,:gp_date,:chest,:net,:sold_pkgs,:valuation,:price ";
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
                        $sthI->execute();
                    }
                }
            }
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
if(strlen($e_offer_dt)==10){ $e_start_tm=date("H:i:s", strtotime($e_start_tm));  }
if(strlen($e_offer_dt)==10){ $e_end_tm=date("H:i:s", strtotime($e_end_tm)); }
?>
<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header  with-border">
                    <h3 class="box-title">Excel Upload</h3>
                </div>

                    <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>" />
                    <input type="hidden" id="hid_emp_cat_id" value="<?php echo $s_emp_cat_id; ?>" />
                    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
                    <input type="hidden" id="hid_log_user" value="<?php echo $ses_uid; ?>" />
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="User Name" class="col-sm-4">Offer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="offer_nm" id="offer_nm" maxlength="50" class="form-control"  value="<?php echo $e_offer_nm; ?>"  tabindex="1" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Offer Date" class="col-sm-4">Offer Date</label>
                                <div class="col-sm-8">
                                    <input type="text" name="offer_dt" id="offer_dt" maxlength="10" class="form-control"  value="<?php echo $e_offer_dt; ?>" readonly="readonly" tabindex="2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Start Time" class="col-sm-4">Start Time</label>
                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" name="start_tm" id="start_tm" maxlength="8" class="form-control timepicker"  value="<?php echo $e_start_tm; ?>" readonly="readonly" tabindex="3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="End Time" class="col-sm-4">End Time</label>
                                <div class="col-sm-8 bootstrap-timepicker">
                                    <input type="text" name="end_tm" id="end_tm" maxlength="8" class="form-control timepicker"  value="<?php echo $e_end_tm; ?>" readonly="readonly" tabindex="4">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Location" class="col-sm-4">Location</label>
                                <div class="col-sm-8">
                                    <input type="text" name="location" id="location" maxlength="50" class="form-control"  value="<?php echo $e_location; ?>"  tabindex="5" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Payment Type" class="col-sm-4">Payment Type</label>
                                <div class="col-sm-8">
                                    <input type="text" name="payment_type" id="payment_type" maxlength="25" class="form-control"  value="<?php echo $e_payment_type; ?>"  tabindex="6" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Contact Type" class="col-sm-4">Contact Type</label>
                                <div class="col-sm-8">
                                    <input type="text" name="contract_type" id="contract_type" maxlength="25" class="form-control"  value="<?php echo $e_contract_type; ?>"  tabindex="7" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="Location" class="col-sm-4">Prompt Days</label>
                                <div class="col-sm-8">
                                    <input type="text" name="prompt_days" id="prompt_days" maxlength="25" class="form-control"  value="<?php echo $e_prompt_days; ?>"  tabindex="8" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="User Name" class="col-sm-4">Excel File</label>
                                <div class="col-sm-8">
                                    <input type="file" name="offer_excel[]" id="offer_excel" class="form-control"
                                        value="" onchange="ValidateSize(this)" tabindex="9" style="padding-top:2px;">
                                </div>
                            </div>
                        </div>


                        <div id="info"></div>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo $full_url; ?>/emp-cat-mas.php" class="btn btn-default">Cancel</a>
                        <input type="submit" name="submit" id="submit" class="btn btn-success pull-right" value="Submit"
                            tabindex="13">
                    </div>
            </div>
        </div>
    </div>
    <?php
    if($submit=='Submit')
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
                            <!--    <th>Offer Name</th>
                                <th>Offer Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Payment Type</th>
                                <th>Contact Type</th>
                                <th>Prompt Days</th>-->
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
                            $sqle= "select offer_nm,offer_dt,start_tm,end_tm,location,payment_type,contract_type,prompt_days,lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price ";
                            $sqle.="from temp_mas order by temp_id ";
                            $sth = $conn->prepare($sqle);
                            $sth->execute();
                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                            $row = $sth->fetchAll();
                            foreach ($row as $key => $value) 
                            {
                                $sl++;
                                $e_lot=$value['lot'];
                                $e_garden=$value['garden'];
                                $gcolor=null;
                                if(!in_array($e_garden,$garden_nm))
                                {
                                    $gcolor='class="text-error"';
                                    $error++;
                                }
                                
                                $e_grade=$value['grade'];
                                $grcolor=null;
                                if(!in_array($e_grade,$grades))
                                {
                                    $grcolor='class="text-error"';
                                    $error++;
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
                                 <!--   <td><?php echo $e_offer_nm; ?></td>
                                    <td><?php echo $e_offer_dt; ?></td>
                                    <td><?php echo $e_start_tm; ?></td>
                                    <td><?php echo $e_end_tm; ?></td>
                                    <td><?php echo $e_location; ?></td>
                                    <td><?php echo $e_payment_type; ?></td>
                                    <td><?php echo $e_contract_type; ?></td>
                                    <td><?php echo $e_prompt_days; ?></td>-->
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
                            <input type="submit" name="update" id="update" class="btn btn-success pull-right" value="Update"
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

<?php 

include('./footer.php'); ?>
<script src="<?php echo $full_url; ?>/customjs/excel-upload.js"></script>
