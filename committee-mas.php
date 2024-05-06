<?php
include('./header.php');

?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Committee Master</h3>
            </div>
            <!-- /.box-header -->
           <form name="form1" method="post" enctype="multipart/form-data" onSubmit="return validate()">
 
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
				<td align="center"><B>Name</B></td>
                  <td align="center"><B>Designation</B></td>
                  <td align="center"><B>Mobile No</B></td>
                  <td align="center"><B>Serial</B></td>
                  <td align="center"><B>Signature</B></td>
                  <td align="center"><a href="./committee-insert.php"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                </tr>
                </thead>
                <tbody>
                 <?php
			 
				 $sqle= "select u.uid,u.user_name,u.cell_no,u.designation,c.seq_id ";
				 $sqle.="from user_mas u,committee_mas c WHERE u.uid=c.uid ";
				 $sth = $conn->prepare($sqle);
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