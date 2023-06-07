<?php
header("X-XSS-Protection: 1;mode = block");
header("X-Content-Type-Options: nosniff");
//header("Header set X-Frame-Options "allow-from https://example.com/"");
// **PREVENTING SESSION HIJACKING**
// Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);
include("./inc/operator_class.php");

function curPageName() 
{
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$current_page=curPageName(); 

include("./inc/dblib.inc.php");
include("./inc/datelib.inc.php");
$conn = OpenDB();
$tz = (new DateTime('now', new DateTimeZone('Asia/Calcutta')))->format('P');
$conn->exec("SET time_zone='$tz';");

date_default_timezone_set("Asia/Calcutta");

$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
$Session = new Session('Script');
$ses_uid = $Session->Get('uid');
$ses_orgn_id= $Session->Get('orgn_id');
$ses_user_nm = $Session->Get('user_name');
$ses_user_id = $Session->Get('user_id');					
$ses_year_id = $Session->Get('year_id');
$ses_year_desc= $Session->Get('year_desc');
$ses_st_dt = $Session->Get('st_dt');
$ses_end_dt = $Session->Get('end_dt');
$ses_user_type = $Session->Get('user_type');
$ses_page_per= $Session->Get('page_assign');
$ses_id= $Session->Get('id');
$ses_token= $Session->Get('token');
$full_url= $Session->Get('full_url');
$ses_orgn_nm = $Session->Get('orgn_nm');
$ses_orgn_addr = $Session->Get('orgn_addr');
$ses_user_status= $Session->Get('status');
$ses_divn_id= $Session->Get('divn_id');
$ses_oprn_id= $Session->Get('oprn_id');
$ses_unit_id= $Session->Get('unit_id');
$ses_signature= $Session->Get('signature');
$ses_desig_id= $Session->Get('desig_id');
$ses_desig_nm= $Session->Get('desig_nm');
$ses_otp_req= $Session->Get('otp_req');
$ses_mail_req= $Session->Get('mail_req');
if(!empty($ses_desig_nm))
{
	$ses_desig_nm="( ".$ses_desig_nm." )";
}
else
{
	$ses_desig_nm="";
}

if(empty($ses_uid))
{
	?>
    <script>
    window.location.href='./login.php'
	</script>
    <?php
}
//echo  "User: $ses_user_type<br>";
if($ses_user_type!="A")
{
if($current_page!='index.php' )
{
	if($current_page!='my-account.php')
	{		
		$sql="select menu_id from menu_mas ";
		$sql.="where murl=:current_page ";
		$sth = $conn->prepare($sql);
		$sth->bindParam(':current_page', $current_page);
		$sth->execute();
		$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $sth->fetch();
		$menu_id_p=$row2['menu_id'];
		
		//---------- search the current page if it has permission---------------------
		$arr_page_per=explode(",",$ses_page_per);
		$found=array_search($menu_id_p,$arr_page_per);
		
		if(strlen($found)<1)
		{
			?>
			<script language="javascript">
			window.location.href="./index.php";
			</script>	
			<?php
		}
	}
}
}
$sql="select soft_nm,soft_abbr from soft_mas ";
$sth = $conn->prepare($sql);
$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row2 = $sth->fetch();
$soft_nm=$row2['soft_nm'];
$soft_abbr=$row2['soft_abbr'];

$msg="";

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $soft_nm; ?></title>
	<meta name="keywords" content="school management software, school management software india, school management software online, software for school management system, school management software price list in india, school management software kolkata, school management software kolkata west bengal, school management software company in kolkata, infotechssystems.in">
  <meta name="description" content="The One Stop Solutions for all your Digital needs!
Starting from customized software,we make iVRS, Android/iOS applications,Web Hosting,Dynamic and responsive website development and many more!
We serve you the whole package you need to establish yourself as an independent business/organization. ">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <meta http-equiv="Content-Security-Policy" content="default-src 'self';img-src * 'self' data: http:; connect-src 'self' 'unsafe-inline' 'unsafe-eval' *; child-src 'self' 'unsafe-inline' 'unsafe-eval' *; script-src 'self' 'unsafe-inline' 'unsafe-eval' *  ; style-src  'self' 'unsafe-inline' 'unsafe-eval' * data: http:">
 <meta http-equiv='cache-control' content='no-cache'>
 <meta http-equiv='expires' content='0'>
 <meta http-equiv='pragma' content='no-cache'>

 <link rel="icon"  href="./images/favicon.ico">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/dist/css/skins/_all-skins.min.css">
 <!--  <script src = "<?php echo $full_url; ?>/js/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>-->
<script src="https://code.jquery.com/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>
<link rel="stylesheet" href="<?php echo $full_url; ?>/plugins/timepicker/bootstrap-timepicker.min.css">  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<script src="<?php echo $full_url; ?>/js/alertify.min.js"></script>
  <link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.core.css" />
  <link rel="stylesheet" href="<?php echo $full_url; ?>/css/alertify.default.css" />
  <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/plugins/daterangepicker/daterangepicker-bs3.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo $full_url; ?>/custom/css/breaking-news-ticker.css">


  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="./dist/html5shiv.min.js"></script>
  <script src="./dist/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
 <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
--></head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $full_url; ?>/index.php" class="logo">
     <img src="<?php echo $full_url; ?>/images/logo.png" alt="<?php echo $soft_nm; ?>" title="<?php echo $soft_nm; ?>" height="40px" width="45px" align="left" style="margin-top:8px;" />
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!--<span class="logo-mini"><b>T</b>P</span>
       logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $soft_abbr; ?></b></span>
    </a>
    
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
	  <div   style="float:left; width:70%;">
		<div class="breaking-news-ticker col-sm-12" id="newsTicker1">
			<div class="bn-label">News</div>
				<div class="bn-news col-sm-12">
					<ul>
						
							<li><a href="#"> <?php echo $msg;?></a></li>
							
						
					</ul>

				</div>
				<div class="bn-controls">
					<button><span class="bn-arrow bn-prev"></span></button>
					<button><span class="bn-action"></span></button>
					<button><span class="bn-arrow bn-next"></span></button>
				</div>
			</div>
			<script src="custom/js/breaking-news-ticker.min.js"></script>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#newsTicker1').breakingNews();
				});

			</script>
  	  </div>
      <div class="navbar-custom-menu">
	
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if(!empty($ses_photo_path))
			  {
				  ?>
                  <img src="<?php echo $ses_photo_path; ?>" class="user-image" alt="<?php echo $ses_user_nm; ?>">
                  <?php
			  }
			  else
			  {
				  ?>
				  <img src="<?php echo $full_url; ?>/images/user.png" class="user-image" alt="<?php echo $ses_user_nm; ?>">
                 <?php
			  }
			  ?>
              <span class="hidden-xs"><?php // echo $ses_user_nm; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if(!empty($ses_photo_path))
			   {
				    ?>
                    <img src="<?php echo $full_url; ?>/<?php echo $ses_photo_path; ?>" class="img-circle" alt="<?php echo $ses_user_nm; ?>" height="160px">
                    <?php
			  }
			  else
			  {
				  ?>
				  <img src="<?php echo $full_url; ?>/images/user.png" class="img-circle" alt="<?php echo $ses_user_nm; ?>"  height="160px">
                 <?php
			  }
			  ?>
              <p><?php echo $ses_user_nm; ?></p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $full_url; ?>/my-account.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $full_url; ?>/logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>        
          
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image" style="color:#FFF;">
          &nbsp;
        </div>
        <div class="pull-left info">
          <p>&nbsp;</p>
        </div>
      </div>
      <!-- search form -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo $full_url; ?>/index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php
	
			$sql_p="select menu_id,parent_id,mbody,icon_nm from menu_mas ";
			$sql_p.="where murl=:current_page ";
			$sth_p = $conn->prepare($sql_p);
			$sth_p->bindParam(':current_page', $current_page);
			$sth_p->execute();
			$sscurrent_page=$sth_p->setFetchMode(PDO::FETCH_ASSOC);
			$row_p = $sth_p->fetch();
			if ($sth_p->rowCount() > 0) {
				$menu_id_p=$row_p['menu_id'];
				$parent_id_p=$row_p['parent_id'];
				$mbody_p=$row_p['mbody'];
				$icon_nm_p=$row_p['icon_nm'];
			  } else {
				$menu_id_p='';
				$parent_id_p='';
				$mbody_p='';
				$icon_nm_p='';
			  }
			
			


$sql="select * from menu_mas ";
$sql.="where parent_id='0' and show_tag='T' ";
if($ses_user_type!='A')
{
	if(!empty($ses_page_per))
	{
		$sql.="and menu_id in (".$ses_page_per.") ";
	}
}

$sql.="order by srl";
$sth = $conn->prepare($sql);

$sth->execute();
$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
$row = $sth->fetchAll();
foreach ($row as $key => $value) 
{
	$mbody=$value['mbody'];
	$murl=$value['murl']; 
	$menu_id=$value['menu_id']; 
	$icon_nm=$value['icon_nm'];  
	     
	$cnt=0;
	$right = isset($right) ? $right : '';
	//if(!empty($ses_page_per))
	//{
    $sqlc ="select count(menu_id) as cnt from menu_mas ";
	$sqlc.="where 1=1 ";
	$sqlc.="and parent_id=:menu_id ";
	$sqlc.="and show_tag='T' ";	
	//$sqlc.="and mid in(".$ses_page_per.") ";
	//echo "$sqlc-->$mid<br>";
	$sthc = $conn->prepare($sqlc);
	$sthc->bindParam(':menu_id', $menu_id);
	$sthc->execute();
	$sthc->setFetchMode(PDO::FETCH_ASSOC);
	$rowc = $sthc->fetch();
	$cnt=$rowc['cnt'];
	//}
	if($cnt>=1){
		$right="<i class='fa fa-angle-left pull-right'></i>";
	$gd=$parent_id_p;
	}
	else
	{
		$right='';
		$gd=$menu_id_p;
	}
	//echo "$ses_page_per-- $ses_user_type";
	?>
        <li class="<?php if($gd==$menu_id){?> active <?php  } if($cnt>=1){?> treeview <?php } ?>">
          <a href="<?php if(!empty($murl)){ echo $murl; } else{ echo "#";}?>">
            <i class="fa <?php echo $icon_nm; ?>"></i> <span><?php echo $mbody; ?></span> <?php echo $right; ?>
          </a>
          <?php
          if($cnt>=1){
			?>  
          <ul class="treeview-menu">
		  <?php
            $sql_sub ="select * from menu_mas ";
            $sql_sub.="where parent_id=:menu_id and show_tag='T' ";
			if($ses_user_type!="A")
			{
		  
				$sql_sub.=" and  find_in_set(cast(menu_mas.menu_id as char), :ses_page_per)";
			//	$sql_sub.="and menu_id in(".$ses_page_per.") ";
			}
            $sql_sub.="order by srl";
			//echo "$sql_sub--$menu_id<br>";
            $sth_sub = $conn->prepare($sql_sub);
			$sth_sub->bindParam(':menu_id', $menu_id);
			if($ses_user_type!="A")
			{
			$sth_sub->bindParam(':ses_page_per', $ses_page_per);
			}
			$sth_sub->execute();
			$ss_sub=$sth_sub->setFetchMode(PDO::FETCH_ASSOC);
			$row_sub = $sth_sub->fetchAll();
			foreach ($row_sub as $key_sub => $value_sub) 
			{
			   $mbody_sub=$value_sub['mbody'];
			   $murl_sub=$value_sub['murl']; 
			   $icon_nm_sub=$value_sub['icon_nm'];  
			   $menu_id_sub=$value_sub['menu_id'];  
				
				$sql_p="select mbody,parent_id from menu_mas ";
				$sql_p.="where murl=:current_page ";
				$sth_p = $conn->prepare($sql_p);
				$sth_p->bindParam(':current_page', $current_page);
				$sth_p->execute();
				$ss_p=$sth_p->setFetchMode(PDO::FETCH_ASSOC);
				$row_p = $sth_p->fetch();
				if ($sth_p->rowCount() > 0) {
					
					$parent_id_p=$row_p['parent_id'];
				  }
				
      	  ?> 
            <li <?php if(($menu_id_p==$menu_id_sub) or($menu_id_sub==$parent_id_p) ){?> class="active" <?php }?>><a href="<?php echo $full_url; ?>/<?php echo $murl_sub; ?>"><i class="fa <?php echo $icon_nm_sub; ?>"></i> <?php echo $mbody_sub; ?></a></li>
            <?php
			 }
			 ?>
          </ul>
          <?php
		  }
		  ?>
        </li>
   <?php
  }
  ?>      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <?php 
	   if($current_page!='index.php')
	   {
		    ?>
             <h1>
				 <i class="fa <?php echo $icon_nm_p; ?>"></i> <?php echo $mbody_p; ?>
				 <small><?php echo "$ses_user_nm  $ses_desig_nm "; ?></small>
            </h1>
            <?php
			$sql_1="select parent_id,mbody,icon_nm,murl from menu_mas ";
			$sql_1.="where menu_id=:parent_id_p ";
			$sth_1 = $conn->prepare($sql_1);
			$sth_1->bindParam(':parent_id_p', $parent_id_p);
			$sth_1->execute();
			$ss_1=$sth_1->setFetchMode(PDO::FETCH_ASSOC);
			$row_1 = $sth_1->fetch();
			if($row_1):
				$parent_id_1=$row_1['parent_id'];
				$mbody_1=$row_1['mbody'];
				$icon_nm_1=$row_1['icon_nm'];
				$murl_1=$row_1['murl'];
			else:
				$parent_id_1=null;
				$mbody_1=null;
				$icon_nm_1=null;
				$murl_1=null;
			endif;
			$sql_2="select parent_id,mbody,icon_nm,murl from menu_mas ";
			$sql_2.="where menu_id=:parent_id_1 ";
			$sth_2 = $conn->prepare($sql_2);
			$sth_2->bindParam(':parent_id_1', $parent_id_1);
			$sth_2->execute();
			$ss_2=$sth_2->setFetchMode(PDO::FETCH_ASSOC);
			$row_2 = $sth_2->fetch();
			if($row_2):
			$parent_id_2=$row_2['parent_id'];
			$mbody_2=$row_2['mbody'];
			$icon_nm_2=$row_2['icon_nm'];
			$murl_2=$row_2['murl'];
			else:
				$parent_id_2='';
				$mbody_2='';
				$icon_nm_2='';
				$murl_2='';
			endif;

			?>
            <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <?php if(!empty($mbody_2))
			{
				?>
                 <li><a href="<?php echo $murl_2; ?>"><i class="fa <?php echo $icon_nm_2; ?>"></i> <?php echo $mbody_2; ?></a></li>
                 <?php
			}
			if(!empty($mbody_1))
			{
			?>
            <li><a href="<?php echo $murl_1; ?>"><i class="fa <?php echo $icon_nm_1; ?>"></i> <?php echo $mbody_1; ?></a></li>
            <?php
			}
			?>
            <li class="active"><i class="fa <?php echo $icon_nm_p; ?>"></i> <?php echo $mbody_p; ?></li>
          </ol>
	        <?php
	   }
	   else
	   {
		   ?>
             <h1>
				 <i class="fa fa-dashboard"></i> Dashboard
				 <small><?php echo "$ses_user_nm  $ses_desig_nm "; ?></small>
            </h1>
	        <?php
	   }
	   ?>
    </section>
    <section class="content">
	<style>
	#preloder {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999999;
    /* background: #000; */
    background: rgb(144, 238, 144,0.6);
}

.loader {
    width: 200px;
    height: 200px;
    position: absolute;
    top: 45%;
    left: 45%;
    margin-top: -20px;
    margin-left: -20px;
    border-radius: 60px;
   /* animation: loader 0.8s linear infinite;
    -webkit-animation: loader 0.8s linear infinite;*/
    background-image: url("./images/tea.gif");
    background-size: 200px 200px;
    

}
</style>