<?php
include('./header.php');

?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Master</h3>
            </div>
            <!-- /.box-header -->
           <form name="form1" method="post" enctype="multipart/form-data" onSubmit="return validate()">
 
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
				<td align="center"><B>User Name</B></td>
                  <td align="center"><B>User ID</B></td>
                  <td align="center"><B>User Type</B></td>
                  <td align="center"><B>User Status</B></td>
                  <td align="center"><B>User Privilege</B></td>
                  <td align="center"><B>Committee</B></td>
                  <td align="center"><a href="./user-insert.php"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                </tr>
                </thead>
                <tbody>
                 <?php
			 
				 $sqle= "select uid,user_name,user_id,password,status,user_type,committee";
				 $sqle.=",cell_no,page_assign ";
				 $sqle.="from user_mas WHERE user_type!='A' ";
				 if($ses_user_type!='A')
				 $sqle.="and (user_type=:ses_user_type or user_type='D') ";
			//	 echo "$sqle<br>";
				 $sth = $conn->prepare($sqle);
				 if($ses_user_type!='A')
				 $sth->bindParam(':ses_user_type', $ses_user_type);
				 $sth->execute();
				 $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
				 $row = $sth->fetchAll();
				 foreach ($row as $key => $value) 
				 {
					$e_uid=$value['uid'];
					$e_user_nm=$value['user_name'];
					$e_user_id=$value['user_id'];
					$e_user_type=$value['user_type'];
					$e_user_status=$value['status'];
					$e_cell_no=$value['cell_no'];
					$e_committee=$value['committee'];
					if($e_committee=='Y')
					{
						$committee='Yes';
					}else{
						$committee='No'; 
					}
					?>
					<tr>
					<td><?php echo $e_user_nm; ?></td>
					<td><?php echo $e_user_id;	?></td>
					<td align="center"><?php
					if($e_user_type=='A'){
						$e_user_type='Admin';
					}else{
						$e_user_type='General'; 
					}
					echo $e_user_type; ?></td>
					<td align="center"><?php 
					if($e_user_status=='A'){
						$e_user_status='Active';
					}else{
						$e_user_status='De-active'; 
					}
					echo $e_user_status; ?></td>						
					<td align="center"><a href="user-permission.php?hr_id=<?php echo $e_uid; ?>"><i class="fa fa-key" aria-hidden="true"></i></a></td>					
					<td><?php echo $committee;	?></td>
					<td align="center"><a href="user-edit.php?hr_id=<?php echo $e_uid;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a></td>
					</tr>
					<?php
				}
				?>
                </tbody>                
              </table>
            </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<script>
		function reset () {
			$("#toggleCSS").attr("href", "./css/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
				buttonReverse : false,
				buttonFocus   : "ok"
			});
		}

		

		$("#confirm").on( 'click', function () {
			reset();
			alertify.confirm("This is a confirm dialog", function (e) {
				if (e) {
					alert('hbxcgfd');
					 document.form1.del_data.value="delete";
                      document.form1.submit();
					alertify.success("Delete Successfully");
				} else {
					alertify.error("You've clicked Cancel");
				}
			});
			return false;
		});

		
	</script>
<?php
include('./footer.php');
?> 
<script>
jQuery(function($) {

    $("#example1 #checkAll").click(function () {

        if ($("#example1 #checkAll").is(':checked') ) {
            $("#example1 input[type=checkbox]").each(function () {
                $(this).attr("checked", true);
            });

        } else {
            $("#example1 input[type=checkbox]").each(function () {
                $(this).attr("checked", false);
            });
        }
    });




});
</script>