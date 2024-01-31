<?php
header("X-XSS-Protection: 1;mode = block");
//header("X-Frame-Options content='SAMEORIGIN'");
include("./inc/operator_class.php");
include("./inc/dblib.inc.php");
include("./inc/datelib.inc.php");
$conn = OpenDB(); 
$full_url=".";
$IP = $_SERVER['REMOTE_ADDR']; 

$login = isset($_POST['login']) ? $_POST['login'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$csrftoken = isset($_POST['csrftoken']) ? $_POST['csrftoken'] : '';
/**************** citizen login ************************/
$fin_year = isset($_POST['fin_year']) ? $_POST['fin_year'] : '';

$randomtoken = md5(uniqid(rand(), true));

$Session = new Session('Script');
$protect = $Session->Get('protect');
if(!$protect)
{
	$Session->Set('protect','0');
}

if($protect>6)
{
	die('You Are Blocked! Contact Portal Admin');
}
?>

<!DOCTYPE html>
<html>
<head>

 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <title>New Registration</title>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <meta http-equiv="Content-Security-Policy" content="default-src 'self';img-src * 'self' data: http:; connect-src 'self' 'unsafe-inline' 'unsafe-eval' *; child-src 'self' 'unsafe-inline' 'unsafe-eval' *; script-src 'self' 'unsafe-inline' 'unsafe-eval' *  ; style-src  'self' 'unsafe-inline' 'unsafe-eval' * data: http:">
 <link rel="icon"  href="./images/favicon.ico">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/select2/dist/css/select2.min.css">

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="./dist/html5shiv.min.js"></script>
  <script src="<?php echo $full_url; ?>/dist/respond.min.js"></script>
  <![endif]-->
<script src="https://code.jquery.com/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>
<script src="<?php echo $full_url; ?>/js/alertify.min.js"></script>
<link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.core.css" />
<link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.default.css" />
</head>

<body class="hold-transition login-page">

<?php // echo password_hash('password',PASSWORD_BCRYPT); ?>
<div class="login-box">
  <div id="loading"></div>
  <div class="login-box-body">
  <p class="login-box-msg"><img src="./images/logo.png" style="width: 30%;"/></p>

    <form name="form1" id="form1" method="post"  enctype="multipart/form-data" onSubmit="return validate()">
	    <input type="hidden" name="csrftoken" value="<?php echo $randomtoken; ?>" />
      <input type="hidden" name="tag1" value="REGISTER" />

    <div class="form-group has-feedback">
        <input type="text" name="user_name" id="user_name" maxlength="50" autocomplete="off" class="form-control" placeholder="Full name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Mobile No"  autocomplete="off" name="mobile_no" id="mobile_no" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" >
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email"   autocomplete="off" name="user_id" id="user_id" maxlength="100">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    
    <div id="otp_div">
        <div class="row">
			<div class="col-xs-12">
				<input type="button" name="send_otp" id="send_otp" value="Send OTP"  class="btn btn-success btn-block btn-flat">
			</div>
		</div>
    </div>
		
		<div class="social-auth-links text-center">
    <!--    <a href="./images/ANDREW YULE MANUAL.pdf" target="_blank">Download User Manual</a>-->
    </div>
		<a href="login.php" class="text-center text-blue">I already have a membership</a>

		</div>

	</form>
	
  </div>
</div>

<script src="<?php echo $full_url; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo $full_url; ?>/customjs/register.js"></script>

<style>
         .alertify-log-custom {
            background: blue;
         }
      </style>

<div id="info"></div>

</body>
</html>
<?php
$conn=null;
?>