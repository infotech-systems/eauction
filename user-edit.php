<?php
include('./header.php');
$hr_id = isset($_REQUEST['hr_id']) ? $_REQUEST['hr_id'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$hid_id = isset($_POST['hid_id']) ? $_POST['hid_id'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$orgn_id = isset($_POST['orgn_id']) ? $_POST['orgn_id'] : '';
$user_status = isset($_POST['user_status']) ? $_POST['user_status'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';
$designation = isset($_POST['designation']) ? $_POST['designation'] : '';
$dob_date = isset($_POST['dob_date']) ? $_POST['dob_date'] : '';
$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
$cell_no = isset($_POST['cell_no']) ? $_POST['cell_no'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';

//$dob_date1=british_to_ansi($dob_date);

if($submit=="Submit")
{
	$sql =" update user_mas set user_name=trim(:user_name),status=trim(:user_status)";
	$sql.=",user_type=trim(:user_type),cell_no=:cell_no  ";//,dept_id=:department ";
	if(!empty($password))
	{

	$sql.=",password=:password1 ";
	}
	$sql.="where uid=:hid_id ";
//	echo "$sql ->UN: $user_name US: $user_status UT: $user_type  hid:$hid_id <br>";
	$sth = $conn->prepare($sql);
	$sth->bindParam(':user_name', $user_name);
	$sth->bindParam(':user_status', $user_status);
	$sth->bindParam(':user_type', $user_type);
	$sth->bindParam(':cell_no', $cell_no);
	if(!empty($password))
	{
    $password1=password_hash($password,PASSWORD_BCRYPT); 

	  $sth->bindParam(':password1', $password1);
	}
	$sth->bindParam(':hid_id', $hid_id);
	$sth->execute();

?>
<script language="javascript">
	alertify.success('User Modification Successfully');
//	window.location.href="./user-mas.php";
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
		
		?>
        <div id="preloder">
    <div class="loader"></div>
</div>

   
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
        </div>
        
        
        <div class="box-footer">        
          <input type="submit" name="submit" id="submit" class="btn btn-default" value="Cancel">          
          <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" tabindex="8" value="Submit">
        </div>
        <div class="col-md-5" id="validity_label"></div>
      </form>
    </div>
  </div>
</div>

<?php
include('./footer.php');
?>   
<script language="javascript">
/*--------------- email id verification function-------------*/
 function validateEmail(txtEmail){
   var a = document.getElementById(txtEmail).value;
   var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
    if(filter.test(a)){
        return true;
    }
    else{
        return false;
    }
}

/*------------- if false then click to write----*/
jQuery("input:text").click( function() {
	$(this).css("border-color","#D6E4F5"); 
	
 });
 jQuery("select").click( function() {
	$(this).css("border-color","#D6E4F5"); 
 });
 jQuery("textarea").click( function() {
	$(this).css("border-color","#D6E4F5"); 
 });

/*-------------- submit function----------*/
jQuery('#submit').click( function() {

if ($('#user_name').val() == "") {
	alertify.error(" Name cannot be Blank");
	$('#user_name').css("border-color","#FF0000");
	$('#user_name').focus();
      return false;								   
}
	 });
</script>
<script src="./plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="./bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="./plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="./plugins/input-mask/jquery.inputmask.js"></script>
<script src="./plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="./plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="./plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="./plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="./plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="./plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="./plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="./plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });


    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
  $(document).ready(function(){
  $("#form2").on("submit", function(){
    $("#preloder").fadeIn();
  });//submit
});//document ready

</script>
</body>
</html>
