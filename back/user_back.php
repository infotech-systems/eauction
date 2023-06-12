<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';

?>
<?php
if(($tag=='REFRESH'))
{
    $myid= isset($_POST['myid'])? $_POST['myid']: '';

    $sql=" update user_mas set token=null ";
	$sql.=" where uid=:myid ";
	$sth = $conn->prepare($sql);
	$sth->bindParam(':myid', $myid);
	$sth->execute();
	?>
	<script src="./js/alertify.min.js"></script>
	<link rel="stylesheet" href="./css/alertify.core.css" />
	<link rel="stylesheet" href="./css/alertify.default.css" />
		
	<script>
		alertify.alert("User token reset successfully.");           
	</script> 
	<?php
}
?>
<?php
if(($tag=='SEARCHUSER'))
{
    $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
    $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
    $unit= isset($_POST['unit'])? $_POST['unit']: '';
    
     ?>
	 
    <table id="example1" class="table table-bordered table-striped">
	<thead>
	<tr>
	<th>User ID</th>
	<th>User Name</th>
	<th>Unit Name</th>
<!--	<th>Operation</th>-->
	<th>Division</th>
	<th>Status</th>
	<th>Permission</th>
	<th>Reset</th>
	<th><a href="<?php echo $full_url; ?>/user-insert.php"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$sql=" select count(*) as log_count,orgn_id from user_mas ";
	$sql.=" where uid=:user_id and token=:token ";
	$sth = $conn->prepare($sql);
	$sth->bindParam(':token', $hid_token);
	$sth->bindParam(':user_id', $hid_log_user);
	$sth->execute();
	$ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
	$row = $sth->fetch();
	$log_count=$row['log_count'];

	// echo "Ct: $log_count";
	if($log_count>0)
	{
		$sl_no=0;
		$sqle ="select u.uid,u.user_id,u.user_name,u.status,n.unit_nm,u.unit_id,d.divn_nm,o.oprn_nmr ";
		$sqle.=" from user_mas u ";
		$sqle.=" left join bridge_efile.unit_mas n on (u.unit_id=n.unit_id) ";
		$sqle.=" left join bridge_efile.division_mas d on (u.divn_id=d.divn_id) ";
	//	$sqle.=" left join operation_mas o on (u.oprn_id=o.oprn_id) ";
		$sqle.= " WHERE 1=1 " ;
		if($unit>0)
		{
			$sqle.=" and u.unit_id=:ses_unit_id";
		}
	//	echo $sqle;
		$sthc = $conn->prepare($sqle);
		if($unit>0)
		{
			$sthc->bindParam(':ses_unit_id', $unit);
		}
		$sthc->execute();
		$ssc=$sthc->setFetchMode(PDO::FETCH_ASSOC);
		$rowc = $sthc->fetchAll();
		$status_desc='';
		foreach ($rowc as $keyc => $rowe) 
		{
			$uid=$rowe['uid'];
			$user_id=$rowe['user_id'];
			$user_name=$rowe['user_name'];
			$unit_nm=$rowe['unit_nm'];
			$divn_nm=$rowe['divn_nm'];
			$oprn_nm=$rowe['oprn_nmr'];
			$status=$rowe['status'];
			if($status=="A")
			$status_desc="Active";
			else	
			$status_desc="Deactive";
			?>		
			<tr>
			<td><?php echo $user_id; ?></td>
			<td><?php echo $user_name; ?></td>
			<td><?php echo $unit_nm; ?></td>
			<td><?php echo $divn_nm; ?></td>
		<!--	<td><?php echo $oprn_nm; ?></td>-->
			<td align="center"><?php echo $status_desc; ?></td>
			<td align="center">
			<a href="<?php echo $full_url; ?>/user-permission.php?hr_id=<?php echo md5($uid);?>">
			<i class="fa fa-unlock" aria-hidden="true"></i>
			</a>
			</td>	
			<td align="center">
			<i class="fa fa-refresh refresh<?php echo $uid; ?>" id="<?php echo $uid; ?>" aria-hidden="true"></i>
			<script>
				$( ".refresh<?php echo $uid; ?>").click(function() {
					
					var myid=$(this).attr("id");
					var request = $.ajax({
					url: "./back/user_back.php",
					method: "POST",
					data: { myid: myid,tag: 'REFRESH'  },
					dataType: "html",
					success:function(msg) {
					$("#info").html(msg);  

				},
				error: function(xhr, status, error) {
							alert(status);
							alert(xhr.responseText);
						},
				}); 
				});
			</script>
		
			</td>		
			<td>
			<a href="<?php echo $full_url; ?>/user-edit.php?hr_id=<?php echo md5($uid);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
			</td>
			</tr>
			<?php
		}
	
	}

	
	?>
	</tbody>
	</table>
	<?php

}
?>

<?php
if(($tag=='SERVICE'))
{
     $service= isset($_POST['service'])? $_POST['service']: '';
     $ses_orgn_id= isset($_POST['ses_orgn_id'])? $_POST['ses_orgn_id']: '';
     ?>
     <select class="form-control select2" name="orgn" id="orgn"
        style="width: 100%; padding-top:-3px;" tabindex="1"  >
        <option value="">--Select --</option>
        <?php
        $sql ="select orgn_id,orgn_nm from orgn_mas ";
        $sql.="WHERE orgn_id>1  and service_id=:service ";
        if($ses_orgn_id>1)
        {
            $sql.=" and orgn_id=:ses_orgn_id ";
        }
        $sql.=" order by orgn_nm ";
        $sth = $conn->prepare($sql);
        if($ses_orgn_id>1)
        {
            $sth->bindParam(':ses_orgn_id', $ses_orgn_id);
        }
        $sth->bindParam(':service', $service);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetchAll();
        foreach ($row as $key => $value) 
        {
            $orgn_id=$value['orgn_id'];
            $orgn_nm=$value['orgn_nm'];
            ?>
            <option value="<?php echo "$orgn_id"; ?>" <?php if($orgn_id==$ses_orgn_id){ echo "SELECTED";} ?>> <?php echo $orgn_nm; ?></option>
        <?php
        }
        ?>
    </select>
    <script>
      $('.select2').select2()
    </script>
     <?php
}
?>
<?php
if(($tag=='GP'))
{
	 $block= isset($_POST['block'])? $_POST['block']: '';
	 $hid_gp_id= isset($_POST['hid_gp_id'])? $_POST['hid_gp_id']: '';
	 $sql ="select gp_id,gp_nm from gp_mas ";
		$sql.="where block_id=:block ";
		if($hid_gp_id>0)
		{
		$sql.=" and gp_id=:hid_gp_id";
		}
		$sql.=" order by gp_nm ";
     ?>
     <select class="form-control select2" name="gp" id="gp"  style="width: 100%; padding-top:-3px;" tabindex="10">
        <option value="0">--Select--</option>
        <?php
      
        $sth = $conn->prepare($sql);
		$sth->bindParam(':block',$block);
		if($hid_gp_id>0)
		{
			$sth->bindParam(':hid_gp_id',$hid_gp_id);
		}
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetchAll();
        foreach ($row as $key => $value) 
        {
            $gp_id=$value['gp_id'];
            $gp_nm=$value['gp_nm'];
            ?>
            <option value="<?php echo "$gp_id"; ?>"><?php echo "$gp_nm"; ?></option>
        <?php
        }
        ?>
    </select>
    <script>
      $('.select2').select2()
    </script>
     <?php
}
?>
<?php
if(($tag=='USERAVAIL'))
{

	 $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
	 $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
	 $user_id= isset($_POST['user_id'])? $_POST['user_id']: '';
	 
	 $sql=" select count(*) as log_count from user_mas ";
	 $sql.=" where uid=:user_id and token=:token ";
	 $sth = $conn->prepare($sql);
	 $sth->bindParam(':token', $hid_token);
	 $sth->bindParam(':user_id', $hid_log_user);
	 $sth->execute();
	 $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
	 $row = $sth->fetch();
	 $log_count=$row['log_count'];
	//echo "Ct: $log_count--$hid_log_user--$csrftoken";
	if($log_count>0)
	{
		$sql_ins =" select count(*) as ct from user_mas  ";
		$sql_ins.=" where user_id=:user_id ";
		$sthI = $conn->prepare($sql_ins);
		$sthI->bindParam(':user_id', $user_id);
		$sthI->execute();
		$ssI=$sthI->setFetchMode(PDO::FETCH_ASSOC);
		$rowI = $sthI->fetch();
		$ct=$rowI['ct'];
		//echo $ct;
		if($ct>0)
		{
			echo "USERID-UNAVAILABLE";
		}
		else{
			echo "USERID-AVAILABLE";
		}
	}
}
?>

<?php
if(($tag=='UPDATE-USER'))
{

	 $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
	 $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
	 $hid_uid= isset($_POST['hid_uid'])? $_POST['hid_uid']: '';
	 $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
	 $cell_no= isset($_POST['cell_no'])? $_POST['cell_no']: '';
	 $user_type= test_input(isset($_POST['user_type'])? $_POST['user_type']: '');
	 $user_status= test_input(isset($_POST['user_status'])? $_POST['user_status']: '');
	 $password= isset($_POST['password'])? $_POST['password']: '';
	 $orgn = isset($_POST['orgn']) ? $_POST['orgn'] : '';
	 $division = isset($_POST['division']) ? $_POST['division'] : '';
	 $operation = isset($_POST['operation']) ? $_POST['operation'] : '';
	 $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
	 $password1=password_hash($password,PASSWORD_BCRYPT);
	 if(empty($division)) $division=0;
	 if(empty($operation)) $operation=0;
	 if(empty($unit)) $unit=0;
 
	 $sql=" select count(*) as log_count from user_mas ";
	 $sql.=" where uid=:user_id and token=:token ";
	 $sth = $conn->prepare($sql);
	 $sth->bindParam(':token', $hid_token);
	 $sth->bindParam(':user_id', $hid_log_user);
	 $sth->execute();
	 $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
	 $row = $sth->fetch();
	 $log_count=$row['log_count'];
	// echo "Ct: $log_count";
	 if($log_count>0)
	 {
		$sql_ins ="update user_mas set ";
		$sql_ins.="user_name=upper(:user_name),status=:user_status,user_type=:user_type, ";
		$sql_ins.="cell_no=:cell_no,orgn_id=:orgn_id ";
		if(!empty($password))
		{
			$sql_ins.=" ,password=:password1 ";
		}
		$sql_ins.=" where md5(uid)=:hid_id ";
		$sthI = $conn->prepare($sql_ins);
		$sthI->bindParam(':user_name', $user_name);
		$sthI->bindParam(':user_status', $user_status);
		$sthI->bindParam(':user_type', $user_type);
		$sthI->bindParam(':cell_no', $cell_no);
		$sthI->bindParam(':hid_id', $hid_uid);
		$sthI->bindParam(':orgn_id', $orgn);
		if(!empty($password))
		{
			$sthI->bindParam(':password1', $password1);
		}
		$sthI->execute();
		
		
		?>
        
      <script src="./js/alertify.min.js"></script>
      <link rel="stylesheet" href="./css/alertify.core.css" />
      <link rel="stylesheet" href="./css/alertify.default.css" />
		
		<script>
	     alertify.success('User updated Successfully');
	   </script>
        
	<?php	
		 
	 }
	
}
?>
<?php
if(($tag=="ADD-USER"))
{
	 $hid_token= isset($_POST['hid_token'])? $_POST['hid_token']: '';
	 $hid_log_user= isset($_POST['hid_log_user'])? $_POST['hid_log_user']: '';
	 $user_id= test_input(isset($_POST['user_id'])? $_POST['user_id']: '');
	 $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
	 $cell_no= test_input(isset($_POST['cell_no'])? $_POST['cell_no']: '');
	 $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
	 $orgn = isset($_POST['orgn']) ? $_POST['orgn'] : '';
	 $hid_pwd = isset($_POST['hid_pwd']) ? $_POST['hid_pwd'] : '';
	 $orgn = isset($_POST['orgn']) ? $_POST['orgn'] : '';
	 $status = isset($_POST['status']) ? $_POST['status'] : '';

	 if(empty($division)) $division=0;
	 if(empty($operation)) $operation=0;
	 if(empty($unit)) $unit=0;

	 $sql=" select count(*) as log_count from user_mas ";
	 $sql.=" where uid=:hid_log_user and token=:token ";
	 $sth = $conn->prepare($sql);
	 $sth->bindParam(':token', $hid_token);
	 $sth->bindParam(':hid_log_user', $hid_log_user);
	 $sth->execute();
	 $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
	 $row = $sth->fetch();
	 $log_count=$row['log_count'];
	//echo "M ps:$m_ps   Blro: $m_blro";
	 if($log_count>0)
	 {
		

		$sql2=" select count(*) as user_count from user_mas ";
		$sql2.=" where user_id=:user_id  ";
		$sth2 = $conn->prepare($sql2);
		$sth2->bindParam(':user_id', $user_id);
		$sth2->execute();
		$sth2->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $sth2->fetch();
		$user_count=$row2['user_count'];
	
		if($user_count<=0)
		{
			$password=password_hash($hid_pwd,PASSWORD_BCRYPT);

			$sql2=" select assigned_page from user_type_mas  ";
			$sql2.=" where user_type=:user_type ";
			$sth2 = $conn->prepare($sql2);
			$sth2->bindParam(':user_type', $user_type);
			$sth2->execute();
			$sth2->setFetchMode(PDO::FETCH_ASSOC);
			$row2 = $sth2->fetch();
			$assigned_page=$row2['assigned_page'];
			try{
				$sql_ins ="insert into user_mas(user_name,user_id ";
				$sql_ins.=",password,cell_no,user_type,page_assign,orgn_id,status) ";
				$sql_ins.="values( trim(upper(:user_name)),trim(:user_id),trim(:password) ";
				$sql_ins.=",trim(:cell_no),:user_type,:assigned_page,:orgn_id,:status) ";
				$sthI = $conn->prepare($sql_ins);
				$sthI->bindParam(':user_name', $user_name);
				$sthI->bindParam(':user_id', $user_id);
				$sthI->bindParam(':password', $password);
				$sthI->bindParam(':cell_no', $cell_no);
				$sthI->bindParam(':user_type', $user_type);
				$sthI->bindParam(':assigned_page', $assigned_page);
				$sthI->bindParam(':status', $status);
				$sthI->bindParam(':orgn_id', $orgn);

				$sthI->execute();
			//	var_dump($sthI->debugDumpParams());
				
				echo "INSERT-SUCCESS";	
			}catch(PdoException $e){
				echo "ERROR: " . $e->getMessage();
			}
			
			
		}else
		{
			
			echo "ERROR-INSERT";
		}

		?>
        
      	
        
	<?php	
	 }
}
?>

<?php
if(($tag=='REGISTER-PROFILE'))
{
	 $hid_uid=$_POST['hid_uid'];
	 $user_nm=test_input($_POST['user_nm']);
	 $contact_no=test_input($_POST['contact_no']);
	 $email=test_input($_POST['email']);
	 $addr=test_input(addslashes($_POST['addr']));
	 $base=test_input($_POST['base']);
	 $password=test_input($_POST['password']);
	 $csrftoken=test_input($_POST['csrftoken']);
	 $hid_id=test_input($_POST['hid_id']);
	 $addr = preg_replace("/<script.*?\/script>/s", "", $addr) ? : $addr;
	 
	$sqlTK="SELECT count(id) as tk from user_log_mas where token=:csrftoken and id=:hid_id ";
	$sthTK = $conn->prepare($sqlTK);
	$sthTK->bindParam(':csrftoken', $csrftoken);
	$sthTK->bindParam(':hid_id', $hid_id);
	$sthTK->execute();
	$ssTK=$sthTK->setFetchMode(PDO::FETCH_ASSOC);
	$rowTK = $sthTK->fetch();
	$tk=$rowTK['tk'];
	if($tk>0)
	{
	// $addr = htmlspecialchars($addr, ENT_QUOTES);
	 
		$sql_ins=" update user_mas set ";
		$sql_ins.=" user_nm=upper(:user_nm),user_addr=:addr, ";
		$sql_ins.="  user_cont_no=trim(:contact_no),mail_id=trim(:email) ";
		if(!empty($password))
		{
			$sql_ins.="  ,pwd=md5(:password) ";
		}
		if(!empty($base))
		{
			$sql_ins.="  ,user_photo= :base ";
		}
		
		$sql_ins.=" where uid=:hid_uid ";
		$sthI = $conn->prepare($sql_ins);
		$sthI->bindParam(':user_nm', $user_nm);
		$sthI->bindParam(':addr', $addr);
		$sthI->bindParam(':contact_no', $contact_no);
		$sthI->bindParam(':email', $email);
		if(!empty($base))
		{
		$sthI->bindParam(':base', $base);
		}
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
		 alertify.alert("Profile Modification Successfully", function(){
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