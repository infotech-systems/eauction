<?php
include('./header.php');
$hr_id = isset($_REQUEST['hr_id']) ? $_REQUEST['hr_id'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$hid_id = isset($_POST['hid_id']) ? $_POST['hid_id'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$user_status = isset($_POST['user_status']) ? $_POST['user_status'] : '';
$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
$cell_no = isset($_POST['cell_no']) ? $_POST['cell_no'] : '';
$committee = isset($_POST['committee']) ? $_POST['committee'] : '';
$designation = isset($_POST['designation']) ? $_POST['designation'] : '';
$seq_id = isset($_POST['seq_id']) ? $_POST['seq_id'] : '';
$sign = isset($_FILES['sign']) ? $_FILES['sign'] : '';
$hid_idw = isset($_POST['hid_idw']) ? $_POST['hid_idw'] : '';
$otp_req = isset($_POST['otp_req']) ? $_POST['otp_req'] : '';


if($submit=="Submit")
{
  $uploaddir="./uploads/sign/";
  $sign_path=null;
    if(!empty($sign['name'][0]))
    {
      if(file_exists('./'.$hid_idw))
      {
        unlink('./'.$hid_idw);
      }
        $file_f1=$uploaddir.fileCkecking_sign($sign,0);;

        $sign_path=substr($file_f1,2);
    }
    if($seq_id==''){ $seq_id=null;}
	$sql =" update user_mas set user_name=trim(:user_name),status=trim(:user_status),otp_req=:otp_req";
	$sql.=",user_type=trim(:user_type),cell_no=:cell_no,committee=:committee,com_srl=:seq_id,design_nm=trim(upper(:designation))  ";//,dept_id=:department ";
	if(!empty($password))
	{
	  $sql.=",password=:password1 ";
	}
  if(!empty($sign['name'][0]))
	{
	  $sql.=",signature=:sign_path ";
	}
	$sql.="where uid=:hid_id ";
	$sth = $conn->prepare($sql);
	$sth->bindParam(':user_name', $user_name);
	$sth->bindParam(':user_status', $user_status);
	$sth->bindParam(':user_type', $user_type);
	$sth->bindParam(':cell_no', $cell_no);
	$sth->bindParam(':otp_req', $otp_req);
  if(!empty($sign['name'][0]))
	{
	  $sth->bindParam(':sign_path', $sign_path);
	}
  $sth->bindParam(':committee', $committee);
  $sth->bindParam(':seq_id', $seq_id);
  $sth->bindParam(':designation', $designation);

	if(!empty($password))
	{
    $password1=password_hash($password,PASSWORD_BCRYPT); 

	  $sth->bindParam(':password1', $password1);
	}
	$sth->bindParam(':hid_id', $hid_id);
	$sth->execute();

?>
<script language="javascript">
  alertify.alert("User Modification Successfully", function(){
    window.location.href="./user-mas.php";
  }); 
	</script>
<?php
}
?>

 <link rel="stylesheet" href="./plugins/select2/select2.min.css">
      <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Modify User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" id="form2" method="post" enctype="multipart/form-data">
              <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $hr_id; ?>" /> 

     <?php       
		$sqle=" select * ";
		$sqle.=" from user_mas  ";
		$sqle.=" where uid=:hr_id ";
		$sth = $conn->prepare($sqle);
		$sth->bindParam(':hr_id', $hr_id);
		$sth->execute();
		$rowe = $sth->fetch();
		$e_uid=$rowe['uid'];
		$e_user_nm=$rowe['user_name'];
		$e_user_id=$rowe['user_id'];
		$e_user_status=$rowe['status'];
		$e_orgn_id=$rowe['orgn_id'];
		$e_user_type=$rowe['user_type'];
		$e_cell_no=$rowe['cell_no'];
		$e_committee=$rowe['committee'];
		$e_com_srl=$rowe['com_srl'];
		$e_design_nm=$rowe['design_nm'];
		$e_signature=$rowe['signature'];
		$e_otp_req=$rowe['otp_req'];
		?>
        <div id="preloder">
    <div class="loader"></div>
</div>
<input type="hidden" name="hid_idw" id="hid_idw" value="<?php echo $e_signature; ?>" /> 

   
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="user_name" class="col-sm-4" >Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $e_user_nm; ?>"   placeholder="Enter Name" required tabindex="1">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="user_id" class="col-sm-4">User ID</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="user_id" tabindex="2" name="user_id" value="<?php echo $e_user_id; ?>" readonly="readonly"  placeholder="Enter User ID" required ><div id="status"></div>
              </div>
            </div>
          </div>  
          <div class="col-md-6">
            <div class="form-group">
              <label for="Password" class="col-sm-4" >Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="password" tabindex="3" name="password"  placeholder="Enter Password"  >
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="cell_no" class="col-sm-4" >Mobile No</label>
              <div class="col-sm-8">
                <input type="tect" class="form-control" id="cell_no" name="cell_no" tabindex="4" placeholder="Enter Mobile No" maxlength="10" value="<?php echo $e_cell_no;?>" >
              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label for="user_status" class="col-sm-4">Status</label>
              <div class="col-sm-8">
                <select class="form-control select2 " name="user_status" tabindex="6" id="user_status"style="width: 100%; padding-top:-3px;" required >
                  <option value="A" <?php if($e_user_status=="A") echo "SELECTED";?>>   Activate    </option>
                  <option value="D" <?php if($e_user_status=="D") echo "SELECTED";?>>   Deactivate    </option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="user_status" class="col-sm-4">User Type</label>
              <div class="col-sm-8">
              <select class="form-control select2" name="user_type" id="user_type" tabindex="7" require>
                  <option value="">--Select--</option>
                  <?php
                  $sqle= "select user_type,user_type_desc";
                  $sqle.=" from user_type_mas "; //WHERE user_type!='A' ";
                //	 echo "$sqle<br>";
                  $sth = $conn->prepare($sqle);
                  $sth->execute();
                  $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                  $row = $sth->fetchAll();
                  foreach ($row as $key => $value) 
                  {
                    $user_type=$value['user_type'];
                    $user_type_desc=$value['user_type_desc'];
                    ?>
                    <option value="<?php echo $user_type; ?>" <?php if($user_type==$e_user_type) { echo "SELECTED"; } ?>><?php echo $user_type_desc; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="Committee" class="col-sm-4">Committee</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="committee" id="committee" tabindex="5">
                  <option value="N" <?php if($e_committee=='N'){ echo "SELECTED"; } ?>>No</option>
                  <option value="Y"  <?php if($e_committee=='Y'){ echo "SELECTED"; } ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="Committee" class="col-sm-4">OTP Required</label>
                <div class="col-sm-8">
                  <select class="form-control select2" name="otp_req" id="otp_req" tabindex="5">
                    <option value="Y" <?php if($e_otp_req=='Y'){ echo "SELECTED"; } ?>>Yes</option>
                    <option value="N"  <?php if($e_otp_req=='N'){ echo "SELECTED"; } ?>>No</option>
                  </select>
                </div>
              </div>
            </div>
                <div id="app_div">
                
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-4" >Designation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  autocomplete="off" id="designation" name="designation" maxlength="50"  value="<?php echo $e_design_nm; ?>"   placeholder="Enter Designation" tabindex="4" style="height:32px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Serial No" class="col-sm-4" >Serial No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  autocomplete="off" id="seq_id" name="seq_id" maxlength="2" value="<?php echo $e_com_srl; ?>"   placeholder="Enter Serial No" tabindex="5" style="height:32px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Signature" class="col-sm-4" >Signature</label>
                            <?php
                            if(strlen($e_signature)>10)
                            {
                              ?>
                              <img src="<?php echo $e_signature; ?>" class="col-sm-2">
                              <?php
                            }
                            ?>
                            <div class="col-sm-6">
                                <input type="file"  id="sign" name="sign[]">
                            </div>
                        </div>
                    </div>
                    
                  
                  </div> 
          </div>
        
        
        <div class="box-footer">        
          <input type="submit" name="submit" id="edit" class="btn btn-primary pull-right" tabindex="8" value="Submit">
        </div>
        <div class="col-md-5" id="validity_label"></div>
      </form>
    </div>
  </div>
</div>

<?php
include('./footer.php');
?>   
<script src="<?php echo $full_url; ?>/customjs/user.js?v=<?php echo date('YmdHis'); ?>"></script>
  
<script>
$(document).ready(function(){
  var committee = $('#committee').val();
    if(committee=='Y')
    {
        $("#app_div").show();
    }
    else
    {
        $("#app_div").hide();
    }

});
</script> 