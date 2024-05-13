<?php
include('./header.php');

?>
<link rel="stylesheet" href="./plugins/select2/select2.min.css">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">View Bidder Information</h3>
            </div>
            
            <div id="preloder">
                <div class="loader"></div>
            </div>
            <form role="form" class="form-horizontal" id="form2" method="post" enctype="multipart/form-data">
            <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $e_bidder_id; ?>" /> 
            <input type="hidden" id="hid_log_user" name="hid_log_user" value="<?php echo $ses_uid; ?>" /> 
            <input type="hidden" id="hid_token" name="hid_token" value="<?php echo $ses_token; ?>" /> 
            <input type="hidden" id="tag" name="tag" value="MODIFI" /> 
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-4" >User Name</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="user" id="user" tabindex="1" >
                                    <option value="">--Select--</option>
                                    <?php
                                    $sqle= "select uid,user_name";
                                    $sqle.=" from user_mas WHERE user_type not  in ('B') ";
                                    $sth = $conn->prepare($sqle);
                                    $sth->execute();
                                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                    $row = $sth->fetchAll();
                                    foreach ($row as $key => $value) 
                                    {
                                        $uid=$value['uid'];
                                        $user_name=$value['user_name'];
                                        ?>
                                        <option value="<?php echo $uid; ?>"><?php echo $user_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-4" >Designation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="designation" name="designation" maxlength="50"  value=""   placeholder="Enter Designation" tabindex="4" style="height:32px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Serial No" class="col-sm-4" >Serial No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seq_id" name="seq_id" maxlength="2" value=""   placeholder="Enter Serial No" tabindex="5" style="height:32px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mobile No" class="col-sm-4" >Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" value=""  maxlength="10"  placeholder="Enter  Mobile No" tabindex="7" style="height:32px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Signature" class="col-sm-4" >Signature</label>
                            <div class="col-sm-8">
                                <input type="file"  id="sign" name="sign[]">
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="box-footer">        
                    <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" tabindex="12" value="Submit">
                </div>
                <div class="col-md-5" id="validity_label"></div>
            </form>
        </div>
    </div>
</div>

<?php
include('./footer.php');
?>  
<script src="<?php echo $full_url; ?>/customjs/committee.js"></script>
