<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
$offer_excel = isset($_FILES['offer_excel']) ? $_FILES['offer_excel'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
error_reporting(0);
if($submit=="Submit")
{
    try
    {
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
                        $sqlI.=" lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price ";
                        $sqlI.=" ) values ( ";
                        $sqlI.=" :lot,:garden,:grade,:invoice,:gp_date,:chest,:net,:sold_pkgs,:valuation,:price ";
                        $sqlI.=" ) ";
                        $sthI = $conn->prepare($sqlI);
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
                                <label for="User Name" class="col-sm-4">Excel File</label>
                                <div class="col-sm-8">
                                    <input type="file" name="offer_excel[]" id="offer_excel" maxlength="50" class="form-control"
                                        value="" onchange="ValidateSize(this)" tabindex="1" style="padding-top:2px;">
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
                            $sqle= "select lot,garden,grade,invoice,gp_date,chest,net,sold_pkgs,valuation,price ";
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
