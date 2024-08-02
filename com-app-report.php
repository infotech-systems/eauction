<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
error_reporting(1);
?>
<div id="preloder">
  <div class="loader"></div>
</div>
<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" action="com-app-report-out.php" target="_blank">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header  with-border">
                    <h3 class="box-title">Search Information</h3>  
                </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group  has-feedback">
                                <label for="place" class="col-sm-4">Offsheet No</label>
                                <div class="col-sm-8">
                                    <select name="offersheet" id="offersheet" class="form-control select2" required>
                                        <option value=""></option>
                                        <?php
                                        $sqle= "select offer_srl ";
                                        $sqle.="from final_auction_dtl group by offer_srl order by offer_srl DESC ";
                                        $sth = $conn->prepare($sqle);
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row = $sth->fetchAll();
                                        foreach ($row as $key => $value) 
                                        {
                                            $offer_srl=$value['offer_srl'];
                                            $place=$value['place'];
                                            ?>
                                            <option value="<?php echo $offer_srl; ?>"><?php echo $offer_srl; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" name="submit" id="submit" class="btn btn-danger" value="Excel" tabindex="13">
                        <input type="submit" name="submit" id="submit" class="btn btn-success pull-right" value="Submit" tabindex="13">
                    </div>
            </div>
        </div>
    </div>
</form>
<?php 

include('./footer.php'); ?>
<script src="<?php echo $full_url; ?>/customjs/excel-upload.js?v=<?php echo date('YmdHis'); ?>"></script>

