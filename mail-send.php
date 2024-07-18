<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
error_reporting(1);


$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$offersheet = isset($_POST['offersheet']) ? $_POST['offersheet'] : '';

if($submit=="Submit")
{
    $ss=file_get_contents('https://privatesale.andrewyule.in/mail/sending_mail/send/'.md5($offersheet));
    echo $ss;
    ?>
    <script>
    alertify.alert("Mail send Successfully.", function(){
        window.open('mail-send.php','_self');
    });
    </script> 
    <?php

}

?>
<div id="preloder">
  <div class="loader"></div>
</div>
<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
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
                                        $sqle= "select offer_srl,auc_id ";
                                        $sqle.="from final_auction_dtl where all_app='Y' group by offer_srl order by offer_srl";
                                        $sth = $conn->prepare($sqle);
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row = $sth->fetchAll();
                                        foreach ($row as $key => $value) 
                                        {
                                            $offer_srl=$value['offer_srl'];
                                            $auc_id=$value['auc_id'];
                                            ?>
                                            <option value="<?php echo $auc_id; ?>"><?php echo $offer_srl; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" name="submit" id="submit" class="btn btn-success pull-right" value="Submit" tabindex="13">
                    </div>
            </div>
        </div>
    </div>
</form>
<?php 

include('./footer.php'); ?>

