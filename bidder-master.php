<?php
include('./header.php');

?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bidder Information</h3>
            </div>
            <!-- /.box-header -->
           <form name="form1" method="post" enctype="multipart/form-data" onSubmit="return validate()">
 
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
				    <td align="center"><B>Name</B></td>
                    <td align="center"><B>State</B></td>
                    <td align="center"><B>Mobile No</B></td>
                    <td align="center"><B>Email Id</B></td>
                    <td align="center"><B>Bidder Type</B></td>
                    <td align="center">#</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $sqle= "select b.bidder_id,b.name,b.cont_no1,b.email_id,s.state_nm,s.state_code ";
                $sqle.=",b.bidder_type ";
                $sqle.="from bidder_mas b,state_mas s WHERE b.status='A' and b.state_code=s.state_code ";
                $sth = $conn->prepare($sqle);
                if($ses_user_type!='A')
                $sth->bindParam(':ses_user_type', $ses_user_type);
                $sth->execute();
                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                $row = $sth->fetchAll();
                foreach ($row as $key => $value) 
                {
					$e_bidder_id=$value['bidder_id'];
					$e_name=$value['name'];
					$e_state_nm=$value['state_nm'];
					$e_state_code=$value['state_code'];
					$e_bidder_type=$value['bidder_type'];
					$e_cont_no1=$value['cont_no1'];
					$e_email_id=$value['email_id'];
					?>
					<tr>
					<td><?php echo $e_name; ?></td>
					<td><?php echo "$e_state_nm ($e_state_code)";	?></td>
					<td><?php echo $e_cont_no1; ?></td>
					<td><?php echo $e_email_id; ?></td>
					<td align="center">
                        <?php 
                        if($e_bidder_type=='V'){
                            $e_bidder_type='Vendor';
                        }else{
                            $e_bidder_type='Agent'; 
                        }
					    echo $e_bidder_type; 
                        ?>
                    </td>						
					<td align="center"><a href="bidder-edit.php?param=<?php echo md5($e_bidder_id); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a></td>
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