<?php
include('./header.php');
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$user_name=ucwords($user_name);
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$cell_no = isset($_POST['cell_no']) ? $_POST['cell_no'] : '';
$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
$committee = isset($_POST['committee']) ? $_POST['committee'] : '';
$designation = isset($_POST['designation']) ? $_POST['designation'] : '';
$seq_id = isset($_POST['seq_id']) ? $_POST['seq_id'] : '';
$otp_req = isset($_POST['otp_req']) ? $_POST['otp_req'] : '';
$sign = isset($_FILES['sign']) ? $_FILES['sign'] : '';

if($submit=="Submit")
{
  $sql_ct="select count(uid) as ct from user_mas ";
  $sql_ct.="where user_id=:user_id ";
  $sth_ct = $conn->prepare($sql_ct);
  $sth_ct->bindParam(':user_id', $user_id);
  $sth_ct->execute();
  $ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
  $row_ct = $sth_ct->fetch();
  $total=$row_ct['ct'];
  if($total<=0)
  {	
    $uploaddir="./uploads/sign/";
    $sign_path=null;
      if(!empty($sign['name'][0]))
      {
          $file_f1=$uploaddir.fileCkecking_sign($sign,0);;

          $sign_path=substr($file_f1,2);
      }
      $sql="select assigned_page from user_type_mas WHERE user_type=:user_type ";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':user_type', $user_type);
      $sth->execute();
      $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
      $row = $sth->fetch();
      $assigned_page=$row['assigned_page'];  

      $password1=password_hash($password,PASSWORD_BCRYPT); 
      $sql ="insert into user_mas (user_name,user_id,password";
      $sql.=",user_type,cell_no,page_assign,committee,com_srl,design_nm,signature,otp_req ";
      $sql.=" ) values ( ";
      $sql.="trim(upper(:user_name)),trim(:user_id),trim(:password1)";
      $sql.=",:user_type,:cell_no,:assigned_page,:committee,:seq_id,trim(upper(:designation)),:sign_path,:otp_req ";
      $sql.=") ";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':user_name', $user_name);
      $sth->bindParam(':user_id', $user_id);
      $sth->bindParam(':otp_req', $otp_req);
      $sth->bindParam(':password1', $password1);
      $sth->bindParam(':user_type', $user_type);
      $sth->bindParam(':assigned_page', $assigned_page);
      $sth->bindParam(':cell_no', $cell_no);
      $sth->bindParam(':committee', $committee);
      $sth->bindParam(':seq_id', $seq_id);
      $sth->bindParam(':designation', $designation);
      $sth->bindParam(':sign_path', $sign_path);
      $sth->execute();
      ?>
      <script language="javascript">
        alertify.alert("User Add Successfully", function(){
          window.location.href="./user-mas.php";
        }); 
      </script>
      <?php
  }
  else
  {
      ?>
      <script language="javascript">
        alertify.alert("'User Allready Created", function(){
          window.location.href="./user-mas.php";
        }); 
      </script>
      <?php 
    }
}
	
?> 


    <script type="text/javascript" src="./lib/jquery-1.11.1.js"></script>
<script type="text/javascript" src="./dist/jquery.validate.js"></script>

 <link rel="stylesheet" href="./plugins/select2/select2.min.css">
      <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Creation</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form name="form1" id="signup_form1" method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return validate()">
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label  for="user_name" class="col-sm-4" >Name</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" autocomplete="off" id="user_name" name="user_name" value="" maxlength="45" tabindex="1" placeholder="Enter  Name" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="user_id" class="col-sm-4">User ID</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control"  autocomplete="off" id="user_id"  name="user_id" maxlength="75" tabindex="2" placeholder="Enter User ID"  onchange="user_change('status',this.value)" ><div id="status"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Password" class="col-sm-4" >Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control"  autocomplete="off" id="password" name="password" maxlength="15" tabindex="3" placeholder="Enter Password" required >
                    </div>
                  </div>  
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Password" class="col-sm-4" >Mobile No</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control"  autocomplete="off" id="cell_no" name="cell_no" maxlength="10" tabindex="4" placeholder="Enter Mobile No"  >
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
                        $sqle.=" from user_type_mas WHERE user_type!='A' ";
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
                          <option value="<?php echo $user_type; ?>"><?php echo $user_type_desc; ?></option>
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
                        <option value="N">No</option>
                        <option value="Y">Yes</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="Committee" class="col-sm-4">OTP Required</label>
                      <div class="col-sm-8">
                        <select class="form-control select2" name="otp_req" id="otp_req" tabindex="5">
                          <option value="Y">Yes</option>
                          <option value="N">No</option>
                        </select>
                      </div>
                    </div>
                  </div>
                <div id="app_div">
                  <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-4" >Designation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  autocomplete="off" id="designation" name="designation" maxlength="50"  value=""   placeholder="Enter Designation" tabindex="4" style="height:32px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Serial No" class="col-sm-4" >Serial No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  autocomplete="off" id="seq_id" name="seq_id" maxlength="2" value=""   placeholder="Enter Serial No" tabindex="5" style="height:32px;">
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
<script>
$(document).ready(function(){
    $("#app_div").hide();

});
</script> 
<script src="<?php echo $full_url; ?>/customjs/user.js?v=<?php echo date('YmdHis'); ?>"></script>

