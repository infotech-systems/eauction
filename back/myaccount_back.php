<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
?>

<?php
if(($tag=='ACCOUNT-PROFILE'))
{	
	 $hid_uid=$_POST['hid_uid'];
	 $user_nm=test_input($_POST['user_nm']);
	 $password=test_input($_POST['password']);
	 $csrftoken=$_POST['csrftoken'];
	 $hid_id=test_input($_POST['hid_id']);
	 
	//$sqlTK=" SELECT count(uid) as tk from user_mas where token=:csrftoken and uid=:hid_id ";
	$sqlTK=" select count(*) as tk from user_mas where token=:csrftoken and uid=:hid_uid ";
	$sthTK = $conn->prepare($sqlTK);
	$sthTK->bindParam(':csrftoken', $csrftoken);
	$sthTK->bindParam(':hid_uid', $hid_uid);
	$sthTK->execute();
	$ssTK=$sthTK->setFetchMode(PDO::FETCH_ASSOC);
	$rowTK = $sthTK->fetch();
	$tk=$rowTK['tk'];
	//echo "$sqlTK  $csrftoken  $hid_id";
	if($tk>0)
	{
      
        $password=password_hash($password,PASSWORD_BCRYPT);
       
		$sql_ins=" update user_mas set ";
		$sql_ins.=" user_name=trim(upper(:user_nm)) ";
		if(!empty($password))
		{
			$sql_ins.=",password=:password ";
		}		
		$sql_ins.="where uid=:hid_uid ";
		//echo "<br>$sql_ins--$hid_uid--$password";
		$sthI = $conn->prepare($sql_ins);
		$sthI->bindParam(':user_nm', $user_nm);
		if(!empty($password))
		{
			$sthI->bindParam(':password', $password);
		}
		$sthI->bindParam(':hid_uid', $hid_uid);
		$sthI->execute();
		?>
        
		<script src="./js/alertify.min.js"></script>
		<link rel="stylesheet" href="./css/alertify.core.css" />
		<link rel="stylesheet" href="./css/alertify.default.css" />		
		<script>
		    alertify.alert("Profile Modified Successfully", function(){
			window.location.href='./my-account.php';
		  });
	   </script>        
	<?php
	}	
}
?>
<?php
$conn=null;
?>