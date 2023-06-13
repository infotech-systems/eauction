<?php
include('./header.php');
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$user_name=ucwords($user_name);
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$orgn_id = isset($_POST['orgn_id']) ? $_POST['orgn_id'] : '';
$user_status = isset($_POST['user_status']) ? $_POST['user_status'] : '';
$dob_date = isset($_POST['dob_date']) ? $_POST['dob_date'] : '';
$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
$cell_no = isset($_POST['cell_no']) ? $_POST['cell_no'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';

//$dob_date1=british_to_ansi($dob_date);

if($submit=="Submit")
{
  $sql_ct="select count(uid) as ct from user_mas ";
  $sql_ct.="where user_id=:user_id ";//and orgn_id=:ses_orgn_id ";
  $sth_ct = $conn->prepare($sql_ct);
  $sth_ct->bindParam(':user_id', $user_id);
  //$sth_ct->bindParam(':ses_orgn_id', $ses_orgn_id);
  $sth_ct->execute();
  $ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
  $row_ct = $sth_ct->fetch();
  $total=$row_ct['ct'];

  if($total<=0)
  {	
      $sql="select assigned_page from user_type_mas WHERE user_type=:user_type ";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':user_type', $user_type);
      $sth->execute();
      $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
      $row = $sth->fetch();
      $assigned_page=$row['assigned_page'];  

      $password1=password_hash($password,PASSWORD_BCRYPT); 
      $sql ="insert into user_mas (user_name,user_id,password,status";
      $sql.=",user_type,cell_no,page_assign) ";
      $sql.="values ";
      $sql.="(trim(upper(:user_name)),trim(:user_id),trim(:password1),trim(:user_status)";
      $sql.=",:user_type,:cell_no,:assigned_page) ";
     // echo "$sql UN:$user_name ID:$user_id pw: $password1 ST: $user_status TP:$user_type CL:$cell_no PA:$assigned_page<br>";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':user_name', $user_name);
      $sth->bindParam(':user_id', $user_id);
      $sth->bindParam(':password1', $password1);
      $sth->bindParam(':user_status', $user_status);
      $sth->bindParam(':user_type', $user_type);
      $sth->bindParam(':assigned_page', $assigned_page);
      $sth->bindParam(':cell_no', $cell_no);
      $sth->execute();
      ?>
      <script language="javascript">
      alertify.success('User Add Successfully');
      window.location.href="./user-mas.php";
      </script>
      <?php
  }
  else
  {
      ?>
      <script language="javascript">
      alertify.error('User Allready Created');
      window.location.href="./user-mas.php";
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
                      <input type="text" class="form-control" id="user_name" name="user_name" value="" maxlength="45" tabindex="1" placeholder="Enter  Name" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="user_id" class="col-sm-4">User ID</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="user_id"  name="user_id" maxlength="75" tabindex="2" placeholder="Enter User ID"  onchange="user_change('status',this.value)" ><div id="status"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Password" class="col-sm-4" >Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="password" name="password" maxlength="15" tabindex="3" placeholder="Enter Password" required >
                    </div>
                  </div>  
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Password" class="col-sm-4" >Mobile No</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="cell_no" name="cell_no" maxlength="10" tabindex="4" placeholder="Enter Mobile No"  >
                    </div>
                  </div>  
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="user_status" class="col-sm-4">Status</label>
                    <div class="col-sm-8">
                      <select class="form-control select2" name="user_status"  id="user_status" tabindex="6"  >
                        <option value="A">   Activate    </option>
                        <option value="D">   Deactivate    </option>
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
               <!-- <div class="col-md-6">
                  <div class="form-group">
                    <label for="Department" class="col-sm-4">Department</label>
                    <div class="col-sm-8">
                      <select class="form-control select2" name="department" id="department" tabindex="5" require>
	                      <option value="">--Select--</option>
                        <?php
                        /*
                        $sqle= "select dept_id,dept_nm";
                        $sqle.=" from dept_mas order by dept_nm ";
                     //	 echo "$sqle<br>";
                        $sth = $conn->prepare($sqle);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                          $dept_id=$value['dept_id'];
                          $dept_nm=$value['dept_nm'];
                          ?>
                          <option value="<?php echo $dept_id; ?>"><?php echo $dept_nm; ?></option>
                          <?php
                        }*/
                        ?>
                      </select>
                    </div>
                  </div>
                </div>-->
              </div>
              <div class="box-footer">
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="Cancel">
                <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" value="Submit" tabindex="8" >
              </div>
            </form>
          </div>
        </div>
      </div>

<?php
include('./footer.php');
?>   

<script type="text/javascript">
		/*$.validator.setDefaults( {
			submitHandler: function () {
				alert( "submitted!" );
			}
		} );*/

		$( document ).ready( function () {
			$( "#signup_form1" ).validate( {
				rules: {
					user_name: {
						required: true,
						minlength: 4
					},
					user_id: {
						required: true,
						minlength: 4
					},
					password: {
						required: true,
						minlength: 5
					},
					orgn_id: {
						required: true,
					},
					user_status: {
						required: true,
					},
				/*	confirm_password1: {
						required: true,
						minlength: 5,
						equalTo: "#password1"
					},
					email1: {
						required: true,
						email: true
					},
					agree1: "required"*/
				},
				messages: {
					user_name: {
						required: "Please enter a Name",
						minlength: "Your Name must consist of at least 4 characters"
					},
					user_id: {
						required: "Please enter a User ID",
						minlength: "Your User ID must consist of at least 4 characters"
					},
					password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long"
					},
					orgn_id: "Please Select a valid Company",
					user_status: "Please Select a valid User Status",
					/*confirm_password1: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					},
					email1: "Please enter a valid email address",
					agree1: "Please accept our policy"*/
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					}else if (element.hasClass('select2')) {
						error.insertAfter(element.next('span'));
					}  else {
									error.insertAfter( element );
								}
							},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-4" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-4" ).addClass( "has-success" ).removeClass( "has-error" );

				}
			} );
		} );
		
	
$(document).ready(function () {

    $('.select2').on('change', function () {
        $(this).valid();
    });
   
});
		
		
		
		
	</script>
