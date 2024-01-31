<?php
include('./header.php');
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';

$sqle=" select bidder_id,name,addr,state_code,pin,pan_no,gst_no,cont_no1,cont_no2,email_id,bidder_type,status,billing_nm ";
$sqle.=" from bidder_mas  ";
$sqle.=" where md5(bidder_id)=:param ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->execute();
$rowe = $sth->fetch();
$e_bidder_id=$rowe['bidder_id'];
$e_name=$rowe['name'];
$e_addr=$rowe['addr'];
$e_state_code=$rowe['state_code'];
$e_pin=$rowe['pin'];
$e_pan_no=$rowe['pan_no'];
$e_gst_no=$rowe['gst_no'];
$e_cont_no1=$rowe['cont_no1'];
$e_cont_no2=$rowe['cont_no2'];
$e_email_id=$rowe['email_id'];
$e_bidder_type=$rowe['bidder_type'];
$e_status=$rowe['status'];
$e_billing_nm=$rowe['billing_nm'];
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
                            <label for="user_name" class="col-sm-4" >Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="bidder_name" name="bidder_name" value="<?php echo $e_name; ?>"   placeholder="Enter Name" required tabindex="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_name" class="col-sm-4" >State</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="state" id="state" tabindex="3">
                                    <option value="">--Select--</option>
                                    <?php
                                    $sqle= "select state_code,state_nm";
                                    $sqle.=" from state_mas "; //WHERE user_type!='A' ";
                                    //	 echo "$sqle<br>";
                                    $sth = $conn->prepare($sqle);
                                    $sth->execute();
                                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                    $row = $sth->fetchAll();
                                    foreach ($row as $key => $value) 
                                    {
                                        $state_code=$value['state_code'];
                                        $state_nm=$value['state_nm'];
                                        ?>
                                        <option value="<?php echo $state_code; ?>" <?php if($state_code==$e_state_code) { echo "SELECTED"; } ?>><?php echo $state_nm; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id" class="col-sm-4">Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="address" tabindex="2" name="address" value="<?php echo $e_addr; ?>" style="height:64px;"  placeholder="Enter Address"><?php echo $e_addr; ?></textarea>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-4" >Pin</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pin" name="pin" maxlength="6" value="<?php echo $e_pin; ?>"   placeholder="Enter PIN Code" tabindex="4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="PAN No" class="col-sm-4" >PAN No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pan_no" name="pan_no"  maxlength="10" value="<?php echo $e_pan_no; ?>"   placeholder="Enter PAN No" tabindex="5">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="GST No" class="col-sm-4" >GST No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="gst_no" name="gst_no"  maxlength="15" value="<?php echo $e_gst_no; ?>"   placeholder="Enter PAN No" tabindex="6">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mobile No" class="col-sm-4" >Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="cont_no1" name="cont_no1" value="<?php echo $e_cont_no1; ?>"  maxlength="10"  placeholder="Enter  Mobile No" tabindex="7">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Alternative Mobile No" class="col-sm-4" >Alternative Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="cont_no2" name="cont_no2" value="<?php echo $e_cont_no2; ?>"  maxlength="10"  placeholder="Enter Alternative Mobile No" tabindex="8">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Email ID" class="col-sm-4" >Email ID</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $e_email_id; ?>"  maxlength="100"  placeholder="Enter Email ID" tabindex="9">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Bidder Type" class="col-sm-4" >Bidder Type</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="bidder_type" id="bidder_type" tabindex="10">
                                    <option value="">--Select--</option>
                                    <option value="V" <?php if($e_bidder_type=='V') { echo "SELECTED"; } ?>>Vendor</option>
                                    <option value="A" <?php if($e_bidder_type=='A') { echo "SELECTED"; } ?>>Agent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Bidder Type" class="col-sm-4" >Status</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="status" id="status" tabindex="11">
                                    <option value="">--Select--</option>
                                    <option value="A" <?php if($e_status=='A') { echo "SELECTED"; } ?>>Active</option>
                                    <option value="D" <?php if($e_status=='D') { echo "SELECTED"; } ?>>Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($e_bidder_type=='A') 
                    {
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Buyer Name" class="col-sm-4">Buyer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="billing_nm" name="billing_nm" value="<?php echo $e_billing_nm; ?>"  maxlength="100"  placeholder="Enter Email ID" tabindex="9">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Legal Authorization Letter" class="col-sm-4">Legal Authorization Letter</label>
                                <div class="col-sm-8">
                                    <input type="file"  id="legal_letter" name="legal_letter[]" >
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Business Name" class="col-sm-4">Business Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="billing_nm" name="billing_nm" value="<?php echo $e_billing_nm; ?>"  maxlength="100"  placeholder="Enter Email ID" tabindex="9">
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
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
<script src="<?php echo $full_url; ?>/customjs/bidder.js"></script>
