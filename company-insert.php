<?php
include('./header.php');
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$billing_nm = isset($_POST['billing_nm']) ? $_POST['billing_nm'] : '';
$legal_letter = isset($_FILES['legal_letter']) ? $_FILES['legal_letter'] : '';

if($submit=="Submit")
{
    $sql_ct="select count(bidder_id) as ct from bidder_mas ";
    $sql_ct.="where billing_nm=trim(upper(:billing_nm)) and uid=:ses_uid "; 
    $sth_ct = $conn->prepare($sql_ct);
    $sth_ct->bindParam(':billing_nm', $billing_nm);
    $sth_ct->bindParam(':ses_uid', $ses_uid);
    $sth_ct->execute();
    $ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
    $row_ct = $sth_ct->fetch();
    $total=$row_ct['ct'];
    if($total<=0)
    {	

        $uploaddir="./legal/";
            $legal_path=null;
            if(!empty($legal_letter['name'][0]))
            {
                $file_f1=$uploaddir.fileCkecking_legal($legal_letter,0);;
                $legal_path=substr($file_f1,3);
            };
        $sql_ct="select uid,name,addr,state_code,pin,pan_no,gst_no,cont_no1,cont_no2,email_id,bidder_type from bidder_mas ";
        $sql_ct.="where  uid=:ses_uid and status='A' limit 1"; 
        $sth_ct = $conn->prepare($sql_ct);
        $sth_ct->bindParam(':ses_uid', $ses_uid);
        $sth_ct->execute();
        $ss_ct=$sth_ct->setFetchMode(PDO::FETCH_ASSOC);
        $row_ct = $sth_ct->fetch();
        $uid=$row_ct['uid'];
        $name=$row_ct['name'];
        $addr=$row_ct['addr'];
        $state_code=$row_ct['state_code'];
        $pin=$row_ct['pin'];
        $pan_no=$row_ct['pan_no'];
        $gst_no=$row_ct['gst_no'];
        $cont_no1=$row_ct['cont_no1'];
        $cont_no2=$row_ct['cont_no2'];
        $email_id=$row_ct['email_id'];
        $bidder_type=$row_ct['bidder_type'];

        $sql ="insert into bidder_mas (uid,name,addr,state_code ";
        $sql.=",pin,pan_no,gst_no,cont_no1,cont_no2,email_id,bidder_type,billing_nm,legal_letter ";
        $sql.=" ) values ( ";
        $sql.=" :uid,trim(upper(:name)),trim(:addr),trim(:state_code),trim(:pin)";
        $sql.=",:pan_no,:gst_no,:cont_no1,:cont_no2,:email_id,:bidder_type,trim(upper(:billing_nm)),:legal_path) ";
        // echo "$sql UN:$user_name ID:$user_id pw: $password1 ST: $user_status TP:$user_type CL:$cell_no PA:$assigned_page<br>";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':uid', $uid);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':addr', $addr);
        $sth->bindParam(':state_code', $state_code);
        $sth->bindParam(':pin', $pin);
        $sth->bindParam(':pan_no', $pan_no);
        $sth->bindParam(':gst_no', $gst_no);
        $sth->bindParam(':cont_no1', $cont_no1);
        $sth->bindParam(':cont_no2', $cont_no2);
        $sth->bindParam(':email_id', $email_id);
        $sth->bindParam(':bidder_type', $bidder_type);
        $sth->bindParam(':billing_nm', $billing_nm);
        $sth->bindParam(':legal_path', $legal_path);
        $sth->execute();
        ?>
        <script language="javascript">
        alertify.alert("Company Add Successfully.", function(){
            window.location.href="./add-company.php";
        }); 
        </script>
        <?php
  }
  else
  {
      ?>
      <script language="javascript">
         alertify.alert("Company Allready Created.", function(){
            window.location.href="./add-company.php";
        }); 
      </script>
      <?php 
    }
}
	
?> 
<script type="text/javascript" src="./lib/jquery-1.11.1.js"></script>
<script type="text/javascript" src="./dist/jquery.validate.js"></script>
<link rel="stylesheet" href="./plugins/select2/select2.min.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Company Creation</h3>
                </div>
                <form name="form1" id="signup_form1" method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return validate()">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  for="Billing Name" class="col-sm-4" >Billing Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="billing_nm" name="billing_nm" value="" required maxlength="50" tabindex="1" placeholder="Enter Billing Name" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id" class="col-sm-4">Legal Letter</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" id="legal_letter"  name="legal_letter[]" required tabindex="2" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" value="Submit" tabindex="8" >
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
include('./footer.php');
?>   
