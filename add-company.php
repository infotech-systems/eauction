<?php
include('./header.php');

?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Company List</h3>
            </div>
            <!-- /.box-header -->
           <form name="form1" method="post" enctype="multipart/form-data" onSubmit="return validate()">
 
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
                    <td align="center"><B>Billing Name</B></td>
                    <td align="center"><B>Status</B></td>
                    <td align="center"><a href="./company-insert.php"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                </tr>
                </thead>
                <tbody>
                 <?php
			 
				 $sqle= "select bidder_id,billing_nm,legal_letter,status ";
				 $sqle.="from bidder_mas   ";
				 if($ses_user_type!='A')
				 $sqle.="WHERE uid=:ses_uid ";
			//	 echo "$sqle<br>";
				 $sth = $conn->prepare($sqle);
				 if($ses_user_type!='A')
				 $sth->bindParam(':ses_uid', $ses_uid);
				 $sth->execute();
				 $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
				 $row = $sth->fetchAll();
				 foreach ($row as $key => $value) 
				 {
					$e_bidder_id=$value['bidder_id'];
					$e_billing_nm=$value['billing_nm'];
					$e_user_status=$value['status'];
					?>
					<tr>
					<td><?php echo $e_billing_nm; ?></td>
					
					<td align="center">
                    <?php 
					if($e_user_status=='A'){
						$e_user_status='Active';
					}else{
						$e_user_status='De-active'; 
					}
					echo $e_user_status; 
                    ?>
                    </td>						
					<td align="center"><a href="company-edit.php?param=<?php echo md5($e_bidder_id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a></td>
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