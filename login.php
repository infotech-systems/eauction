<?php
header("X-XSS-Protection: 1;mode = block");
//header("X-Frame-Options content='SAMEORIGIN'");
include("./inc/operator_class.php");
include("./inc/dblib.inc.php");
include("./inc/datelib.inc.php");
$conn = OpenDB(); 
/*
$base_dir  = __DIR__; 
$doc_root  = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); 
$base_url  = preg_replace("!^${doc_root}!", '', $base_dir);
$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$port      = $_SERVER['SERVER_PORT'];
$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
$domain    = $_SERVER['SERVER_NAME'];
$full_url  = "${protocol}://${domain}${disp_port}${base_url}";*/
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
/*
if($protect>6)
{
	die('You Are Blocked! Contact Portal Admin');
}
*/
?>

<!DOCTYPE html>
<html>
<head>

 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <title>Login</title>
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
<!-- <script src="https://code.jquery.com/jquery-2.1.4.min.js" integrity="sha384-R4/ztc4ZlRqWjqIuvf6RX5yb/v90qNGx6fS48N0tRxiGkqveZETq72KgDVJCp2TC" crossorigin="anonymous"></script>  -->
 <script src="<?php echo $full_url; ?>/js/jquery-2.1.4.min.js" integrity="sha384-R4/ztc4ZlRqWjqIuvf6RX5yb/v90qNGx6fS48N0tRxiGkqveZETq72KgDVJCp2TC" crossorigin="anonymous"></script>
<script src="<?php echo $full_url; ?>/js/alertify.min.js"></script>
<link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.core.css" />
<link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.default.css" />
</head>

<body class="hold-transition login-page">
<?php
/*************** Department Login ****************/
if($login=='Login')
{
	
	$protect = $Session->Get('protect');	
	$protect++;
		
	$Session->Set('protect',$protect);
	if(!empty($randomtoken))
	{
	
		$sql_ct="select count(uid) as ct,password from user_mas ";
		$sql_ct.="where user_id=:user_name  group by user_id,password ";
		$sth_ct = $conn->prepare($sql_ct);
		$sth_ct->bindParam(':user_name', $user_name);
		$sth_ct->execute();
		$ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
		$row_ct = $sth_ct->fetch();
		$total=$row_ct['ct'];
		$user_password=$row_ct['password'];
		if($total>0)
	    {
			if(password_verify($password,$user_password))
			{
				$sql="select * ";
				$sql.="from user_mas u, orgn_mas o ";
				$sql.=" where u.user_id=:user_name and u.orgn_id=o.orgn_id ";
				$sth = $conn->prepare($sql);
				$sth->bindParam(':user_name',  $user_name);
				$sth->execute();
				$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
				$row2 = $sth->fetch();
				$uid=$row2['uid'];
				$user_name=$row2['user_name'];
				$user_id=$row2['user_id'];
				$user_type=$row2['user_type'];
				$status=$row2['status'];
				$page_assign=$row2['page_assign'];
				$orgn_id=$row2['orgn_id'];
				$orgn_nm=$row2['orgn_nm'];
				$orgn_addr=$row2['orgn_addr'];
				$cell_no=$row2['cell_no'];
				$otp_req=$row2['otp_req'];
				$mail_req=$row2['mail_req'];
				$token=$row2['token'];
				$bidder_id=$row2['bidder_id'];
					

				if($status=='A')
				{
					if(($token==null) or ($token=='')):
						$sql1 ="select current_timestamp as login_time ";
						$sth1 = $conn->prepare($sql1);;
						$sth1->execute();
						$ss1=$sth1->setFetchMode(PDO::FETCH_ASSOC);
						$rowt = $sth1->fetch();
						$login_time=$rowt['login_time'];
						
						$sqlI="insert into user_log (uid,date_fr,ip_addr) ";
						$sqlI.=" values (:uid,:login_time,:IP) ";
						$sthI = $conn->prepare($sqlI);
						$sthI->bindParam(':IP', $IP);
						$sthI->bindParam(':uid', $uid);
						$sthI->bindParam(':login_time', $login_time);
						$sthI->execute();
						
						$sqlC="select max(ulog_id) as id from user_log WHERE uid=:uid ";
						$sthr = $conn->prepare($sqlC);;
						$sthr->bindParam(':uid', $uid);
						$sthr->execute();
						$ssr=$sthr->setFetchMode(PDO::FETCH_ASSOC);
						$rowr = $sthr->fetch();
						$chk_id=$rowr['id'];
						
							// Clean setting of the session data
						$sql_upd="  update user_mas set token=:csrftoken ";
						$sql_upd.="  where uid=:uid";
						$sth_upd = $conn->prepare($sql_upd);
						$sth_upd->bindParam(':uid', $uid);
						$sth_upd->bindParam(':csrftoken', $csrftoken);
						$sth_upd->execute();
						//echo "$sql_upd  $uid=== $csrftoken<br>";
					
						
						$Session->Set('uid',$uid);
						$Session->Set('orgn_id',$orgn_id);
						$Session->Set('orgn_nm',$orgn_nm);
						$Session->Set('orgn_addr',$orgn_addr);
						$Session->Set('user_id',$user_id);
						$Session->Set('user_name',$user_name);
						$Session->Set('user_type',$user_type);
						$Session->Set('cell_no',$cell_no);
						$Session->Set('page_assign',$page_assign);
						$Session->Set('id',$chk_id);
						$Session->Set('token',$csrftoken);
						$Session->Set('full_url',$full_url);
						$Session->Set('otp_req',$otp_req);
						$Session->Set('mail_req',$mail_req);
						$Session->Set('bidder_id',$bidder_id);
						
						
						/************** new session data **********/
						
						$Session->Set('status',$status);
						//header("location:./index.php");
						//exit();
						$sql_ct="select count(uid) as clog from user_log ";
						$sql_ct.="where uid=:uid  ";
						$sth_ct = $conn->prepare($sql_ct);
						$sth_ct->bindParam(':uid', $uid);
						$sth_ct->execute();
						$ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
						$row_ct = $sth_ct->fetch();
						$clog=$row_ct['clog'];
					/*	if($clog<2)
						{
							?>
							<script>
								window.location.href='<?php echo $full_url; ?>/change-password.php';
							
							</script>
							<?php	
						}
						else
						{
							?>
							<script>
							window.location.href='<?php echo $full_url; ?>/index.php';
							</script>
						<?php	
						}*/
						?>
							<script>
							window.location.href='<?php echo $full_url; ?>/index.php';
							</script>
						<?php
					else:
						?>
						<script>

						if (confirm('User already logged in. Do you want to login with this Id?'))
						{
							<?php
							$sql1 ="select current_timestamp as login_time ";
							$sth1 = $conn->prepare($sql1);;
							$sth1->execute();
							$ss1=$sth1->setFetchMode(PDO::FETCH_ASSOC);
							$rowt = $sth1->fetch();
							$login_time=$rowt['login_time'];
							
							$sqlI="insert into user_log (uid,date_fr,ip_addr) ";
							$sqlI.=" values (:uid,:login_time,:IP) ";
							$sthI = $conn->prepare($sqlI);
							$sthI->bindParam(':IP', $IP);
							$sthI->bindParam(':uid', $uid);
							$sthI->bindParam(':login_time', $login_time);
							$sthI->execute();
							
							$sqlC="select max(ulog_id) as id from user_log WHERE uid=:uid ";
							$sthr = $conn->prepare($sqlC);;
							$sthr->bindParam(':uid', $uid);
							$sthr->execute();
							$ssr=$sthr->setFetchMode(PDO::FETCH_ASSOC);
							$rowr = $sthr->fetch();
							$chk_id=$rowr['id'];
							
								// Clean setting of the session data
							$sql_upd="  update user_mas set token=:csrftoken ";
							$sql_upd.="  where uid=:uid";
							$sth_upd = $conn->prepare($sql_upd);
							$sth_upd->bindParam(':uid', $uid);
							$sth_upd->bindParam(':csrftoken', $csrftoken);
							$sth_upd->execute();
							//echo "$sql_upd  $uid=== $csrftoken<br>";
						
							
							$Session->Set('uid',$uid);
							$Session->Set('orgn_id',$orgn_id);
							$Session->Set('orgn_nm',$orgn_nm);
							$Session->Set('orgn_addr',$orgn_addr);
							$Session->Set('user_id',$user_id);
							$Session->Set('user_name',$user_name);
							$Session->Set('user_type',$user_type);
							$Session->Set('cell_no',$cell_no);
							$Session->Set('page_assign',$page_assign);
							$Session->Set('id',$chk_id);
							$Session->Set('token',$csrftoken);
							$Session->Set('full_url',$full_url);
							$Session->Set('otp_req',$otp_req);
							$Session->Set('mail_req',$mail_req);
							
							
							/************** new session data **********/
							
							$Session->Set('status',$status);
							//header("location:./index.php");
							//exit();
						/*	$sql_ct="select count(uid) as clog from user_log ";
							$sql_ct.="where uid=:uid  ";
							$sth_ct = $conn->prepare($sql_ct);
							$sth_ct->bindParam(':uid', $uid);
							$sth_ct->execute();
							$ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
							$row_ct = $sth_ct->fetch();
							$clog=$row_ct['clog'];
							if($clog<2)
							{
								?>
									window.location.href='<?php echo $full_url; ?>/change-password.php';
								<?php	
							}
							else
							{
								?>
								window.location.href='<?php echo $full_url; ?>/index.php';
							<?php	
							}*/
							?>
							window.location.href='<?php echo $full_url; ?>/index.php';
						} 
						</script>
						<?php 
					endif;
						
				}
				else
				{
				  //  echo "XX:$status";	
				    ?>
					<script>
					alertify.error('User ID Not Active. Please contact Administrator ....');  
					</script>
					<?php 
				}
			}
			else
			{
				?>
				<script>
				alertify.error('Invalid password ....');  
				</script>
				<?php 
			}
		}
		else
		{
			?>
					<script>
					 alertify.error('Wrong User-Id ....');  
					</script>
					<?php   
		}
	}
}

?>
<?php // echo password_hash('password',PASSWORD_BCRYPT); ?>
<div class="login-box">
  <div class="login-logo">
  
    <!--<a href="#"><b>User Login</b></a>-->
  </div>
  <div class="login-box-body">
  <p class="login-box-msg"><img src="./images/logo.png" style="width: 30%;"/></p>

    <form name="form1" method="post"  enctype="multipart/form-data" onSubmit="return validate()">
	<input type="hidden" name="csrftoken" value="<?php echo $randomtoken; ?>" />
  
		<div class="form-group has-feedback">
			<input type="user_id" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" tabindex="1" autocomplete="off">
		</div>
		<div class="form-group has-feedback">
			<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" tabindex="1" autocomplete="off">
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<input type="submit" name="login" id="login" value="Login"  class="btn btn-success btn-block btn-flat">
			</div>
		</div>
		<div class="social-auth-links text-center">
    <!--    <a href="./images/ANDREW YULE MANUAL.pdf" target="_blank">Download User Manual</a>-->
    </div>
		<a href="#" class="text-blue">I forgot my password</a><br>
		<a href="register.php" class="text-center text-blue">Register a new membership</a>

		</div>

	</form>
	
  </div>
</div>


<script src="<?php echo $full_url; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<style>
         .alertify-log-custom {
            background: blue;
         }
      </style>
<script>
jQuery('#login').click( function() {
var user_name=$('#user_name').val();
var mobile=$('#mobile').val();

if(user_name=="")
{
	alertify.error("User Name cannot be Blank");
	$('#user_name').css("border-color","#FF0000");
	$('#user_name').focus();
      return false;								   
}
if(user_name!="")
{
   if(/^[/!()<>]+$/.test(user_name))
   {
	 
	alertify.error("Please check User Name ('/!()<>' character not allow)");
	$('#user_name').css("border-color","#FF0000");
	 $('#name').focus();
	 return false;
   }
}
if ($('#password').val() == "") {
   alertify.error(" Password  cannot be Blank");
	$('#password').css("border-color","#FF0000");
	$('#password').focus();
      return false;								   
}
if(password!="")
{
   if(/^[/!()<>]+$/.test(password))
   {
	 
	alertify.error("Please check Password ('/!()<>' character not allow)");
	$('#password').css("border-color","#FF0000");
	 $('#password').focus();
	 return false;
   }
}
 });

</script>


</body>
</html>
<?php
$conn=null;
?>