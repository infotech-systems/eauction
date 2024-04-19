<?php
include('./header.php');
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$billing_nm = isset($_POST['billing_nm']) ? $_POST['billing_nm'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$letter = isset($_POST['letter']) ? $_POST['letter'] : '';
$bidder_id = isset($_POST['bidder_id']) ? $_POST['bidder_id'] : '';
$legal_letter = isset($_FILES['legal_letter']) ? $_FILES['legal_letter'] : '';

if($submit=="Submit")
{
    $uploaddir="./legal/";
    $legal_path=null;
    if(!empty($legal_letter['name'][0]))
    {
        $file_f1=$uploaddir.fileCkecking_legal($legal_letter,0);;
        $legal_path=substr($file_f1,3);
        if(file_exists('./'.$letter))
        {
            unlink('./'.$letter);
        }
    };
        

        $sql ="update bidder_mas set billing_nm=trim(upper(:billing_nm)),status=:status ";
        if(!empty($legal_letter['name'][0]))
        {
            $sql.=" ,legal_letter=:legal_path ";
        };
        $sql.=" where bidder_id=:bidder_id ";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':bidder_id', $bidder_id);
        $sth->bindParam(':billing_nm', $billing_nm);
        $sth->bindParam(':status', $status);
        if(!empty($legal_letter['name'][0]))
        {
            $sth->bindParam(':legal_path', $legal_path);
        };
        $sth->execute();
        ?>
        <script language="javascript">
        alertify.alert("Company Edit Successfully.", function(){
            window.location.href="./add-company.php";
        }); 
        </script>
        <?php
  
  
}
$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : '';

$sqle=" select bidder_id,status,billing_nm,legal_letter ";
$sqle.=" from bidder_mas  ";
$sqle.=" where md5(bidder_id)=:param ";
$sth = $conn->prepare($sqle);
$sth->bindParam(':param', $param);
$sth->execute();
$rowe = $sth->fetch();
$e_bidder_id=$rowe['bidder_id'];
$e_status=$rowe['status'];
$e_billing_nm=$rowe['billing_nm'];
$e_legal_letter=$rowe['legal_letter'];
	
?> 
<script type="text/javascript" src="./lib/jquery-1.11.1.js"></script>
<script type="text/javascript" src="./dist/jquery.validate.js"></script>
<link rel="stylesheet" href="./plugins/select2/select2.min.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Company Creation</h3>
                </div>
                <form name="form1" id="signup_form1" method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return validate()">
                <input type="hidden" id="bidder_id" name="bidder_id" value="<?php echo $e_bidder_id; ?>" >
                <input type="hidden" id="letter" name="letter" value="<?php echo $e_legal_letter; ?>" >
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  for="Billing Name" class="col-sm-4" >Billing Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="billing_nm" name="billing_nm" value="<?php echo $e_billing_nm; ?>" required maxlength="50" tabindex="1" placeholder="Enter Billing Name" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id" class="col-sm-4">Legal Letter</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" id="legal_letter"  name="legal_letter[]" tabindex="2" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="Bidder Type" class="col-sm-4" >Status</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="status" id="status" tabindex="11" >
                                    <option value="">--Select--</option>
                                    <option value="A" <?php if($e_status=='A') { echo "SELECTED"; } ?>>Active</option>
                                    <option value="D" <?php if($e_status=='D') { echo "SELECTED"; } ?>>Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                    <div class="box-footer">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" value="Submit" tabindex="8" >
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
include('./footer.php');
?>   
