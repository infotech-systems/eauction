<?php
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);
include("./inc/operator_class.php");
include("./inc/dblib.inc.php");
include("./inc/datelib.inc.php");
$conn = OpenDB(); 

$Session = new Session('Script');
$ses_uid = $Session->Get('uid');
$ses_orgn_id= $Session->Get('orgn_id');
$ses_user_nm = $Session->Get('user_name');
$ses_user_id = $Session->Get('user_id');
$ses_user_type = $Session->Get('user_type');
$ses_page_per= $Session->Get('page_assign');
$ses_id= $Session->Get('id');
$ses_token= $Session->Get('token');
$ses_orgn_nm = $Session->Get('orgn_nm');
$ses_orgn_addr = $Session->Get('orgn_addr');
$ses_user_status= $Session->Get('status');
$full_url='.';
//echo "XXX:$ses_uid<br>";
if(empty($ses_uid))
{
header("Location: ./");
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $ses_orgn_nm; ?></title>

	    <meta name="keywords" content="school management software, school management software india, school management software online, software for school management system, school management software price list in india, school management software kolkata, school management software kolkata west bengal, school management software company in kolkata, infotechssystems.in">
  <meta name="description" content="The One Stop Solutions for all your Digital needs!
Starting from customized software,we make iVRS, Android/iOS applications,Web Hosting,Dynamic and responsive website development and many more!
We serve you the whole package you need to establish yourself as an independent business/organization. ">


  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon"  href="./images/favicon.ico">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/dist/css/skins/_all-skins.min.css">
 <!--  <script src = "<?php echo $full_url; ?>/js/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>-->
<script src="https://code.jquery.com/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>
  <script src="<?php echo $full_url; ?>/js/alertify.min.js"></script>
  <link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.core.css" />
  <link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.default.css" />
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/plugins/daterangepicker/daterangepicker-bs3.css">
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <script>
    
</script>
<style>
   body{
       font-size: 14px;
   }
.box .overlay>.fa, .overlay-wrapper .overlay>.fa
{
	font-size:100px;
}
select + span.select2:focus, select + span.select2 *:focus
 { 	
     outline-color: #7d3c8c; 	outline-width: 1px;
     border-color: #0089db !important;
 }
</style>
<!--<div id="load">Loading.............</div>-->
<section class="content" style="width:95% !important; margin-left:auto !important; margin-right:auto !important; margin-top:2.5%;">

  <div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
    <div class="box box-primary">
        <div id="loading">
        </div>
        <div class="box-header  with-border">
            <h3 class="box-title">Change Password for <?php echo $ses_user_nm; ?></h3>
            <div class="box-tools pull-right col-sm-3 text-danger">
              Password maximum 15 characters
            </div>
        </div>
        <form name="form1" id="form1"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" >
            <input type="hidden" id="hid_log_user" name="hid_log_user" value="<?php echo $ses_uid; ?>"/>
            <input type="hidden" id="hid_token" value="<?php echo $ses_token; ?>"/>

           <div class="box-body">
              <div class="col-md-6">
                  <div class="form-group  has-feedback">
                      <label for="New Password" class="col-sm-4">New Password <font color="#FF0000">*</font></label>
                      <div class="col-sm-8">
                          <input type="password" name="newpassword" id="newpassword" maxlength="15" class="form-control" placeholder="New Password" tabindex="1" required>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group  has-feedback">
                      <label for="New Password" class="col-sm-4">Confirm Password <font color="#FF0000">*</font></label>
                      <div class="col-sm-8">
                          <input type="password" name="confirmpassword" id="confirmpassword" maxlength="15" class="form-control" placeholder="New Password" tabindex="1" required>
                      </div>
                  </div>
              </div>

                <div id="info"></div>
            </div>
            <div class="box-footer" id="div_acc">
            <input type="button" name="add" id="add" class="btn btn-primary pull-right" value="Submit" tabindex="26">
            </div>
        </form>
    </div>
    </div>
</div> 
    <!-- /.row -->
  </div><!-- /.container-fluid -->
    </section>
<?php $conn=null; ?>
<script src="<?php echo $full_url; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="<?php echo $full_url; ?>/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $full_url; ?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $full_url; ?>/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $full_url; ?>/dist/js/adminlte.min.js"></script>
<script src="<?php echo $full_url; ?>/dist/js/demo.js"></script>
<script src="<?php echo $full_url; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $full_url; ?>/customjs/changepassword.js"></script>
<script>

  $(function () {
    $('.select2').select2()
	 $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    $('[data-mask]').inputmask()
	$('#reservation').daterangepicker({format: 'DD/MM/YYYY'});

	$('.datetimemask').inputmask({
        mask: "1/2/y h:s:s",
        placeholder: "mm/dd/yyyy hh:mm:ss",
        alias: "datetime",
        hourFormat: "24"
    });

	$('#example1').DataTable({
	 'autoWidth'   : false,	
	 'pageLength': 50
	})
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
	  'pageLength': 50
    })
  })
  
</script>
</body>
</html>
