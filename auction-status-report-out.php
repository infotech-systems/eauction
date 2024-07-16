<?php
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
if($submit=="Excel")
{
    $database='Knockdown-approval';
    header("Content-type: text/plan");  
    header("Content-Disposition: attachment; filename=" . $database . ".xls");   
}
header("X-XSS-Protection: 1;mode = block");
header("X-Content-Type-Options: nosniff");
include("./inc/operator_class.php");

function curPageName() 
{
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$current_page=curPageName(); 

include("./inc/dblib.inc.php");
include("./inc/datelib.inc.php");
$conn=OpenDB();
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
$ses_bidder_id= $Session->Get('bidder_id');
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


$offersheet = isset($_POST['offersheet']) ? $_POST['offersheet'] : '';

$sqlTK="SELECT count(uid) as tk from user_mas where token=:ses_token and uid=:ses_uid ";
//echo "$sqlTK $csrftoken ==> $ses_uid<br>";
$sthTK = $conn->prepare($sqlTK);
$sthTK->bindParam(':ses_token', $ses_token);
$sthTK->bindParam(':ses_uid', $ses_uid);
$sthTK->execute();
$ssTK=$sthTK->setFetchMode(PDO::FETCH_ASSOC);
$rowTK = $sthTK->fetch();
$tk=$rowTK['tk'];

if($tk>0)
{

    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Knockdown Approval Report</title>
            <?php
            if($submit=="Submit")
            {
                ?>
                <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                <meta http-equiv="Content-Security-Policy" content="default-src 'self';img-src * 'self' data: http:; connect-src 'self' 'unsafe-inline' 'unsafe-eval' *; child-src 'self' 'unsafe-inline' 'unsafe-eval' *; script-src 'self' 'unsafe-inline' 'unsafe-eval' *  ; style-src  'self' 'unsafe-inline' 'unsafe-eval' * data: http:">
                <link rel="stylesheet" href="<?php echo $full_url; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">

                </head>
                <link rel="stylesheet" href="<?php echo $full_url; ?>/css/report-print.css">
                <style>
                table.table td
                {
                    padding:4px !important;
                }
                </style>
                <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
                <section class="content" style="margin: 5px;">

                <?php
            }
            if($submit=="Submit" OR $submit=="Excel")
            { 
                if($submit=="Submit")
                {
                ?>
                    <div class="row"  id="print">
                        <div class="col-md-12">
                            <input type="submit" name="print" id="print" class="btn btn-info pull-left" value="Print" onclick="window.print();" style="margin-bottom:5px;">
                        </div>
                    </div>
                <?php
                }
                ?>      
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body" >
                                <?php
                                $sql="SELECT CURRENT_TIMESTAMP as print_dtl,current_date as cdt ";
                                $sth = $conn->prepare($sql);
                                $sth->execute();
                                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $sth->fetch();
                                $cdt=$row2['cdt'];
                                $print_dtl=$row2['print_dtl'];
                                $print_dt=explode(' ',$print_dtl);
                                $print_date=ansi_to_british($print_dt[0]);

                                $sqle= "select auc_id ";
                                $sqle.="from final_auction_dtl ";
                                $sqle.="where  offer_srl=:offersheet ";
                                $sth = $conn->prepare($sqle);
                                $sth->bindParam(':offersheet', $offersheet);
                                $sth->execute();
                                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                $row = $sth->fetch();
                                $auc_id=$row['auc_id'];
                                $sqle= "select u.design_nm,u.user_name";
                                $sqle.=" from bid_app_dtl b,user_mas u ";
                                $sqle.="where b.uid=u.uid and  acd_id=:auc_id group by b.auc_id order by b.seq_id";
                                $sth = $conn->prepare($sqle);
                                $sth->bindParam(':auc_id', $auc_id);
                                $sth->execute();
                                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                $row = $sth->fetchAll();
                                $cnt=$sth->rowCount();
                                ?>
                                <table class="table table-bordered" width="95%">
                                    <thead>
                                    <?php
                                    if($submit=="Submit")
                                    {
                                        ?>
                                        <tr>
                                            <td rowspan="3" align="center"><img src="<?php echo $full_url; ?>/images/logo.png" width="35" hight="45"/></td>
                                            <td  colspan="<?php if($ses_user_type!='B'){  echo $cnt+11;  } else { $cnt+9; } ?>" align="center" style=" border-bottom:none !important;">&nbsp;</td> 
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                        <tr>
                                            <td colspan="<?php if($ses_user_type!='B'){ echo $cnt+12; } else { echo $cnt+10; } ?>" align="center"  style=" border-top:none !important;border-bottom:none !important;"><B><?php echo "<b>$ses_orgn_nm</b> <br /> $ses_orgn_addr";?></B></td>
                                        </tr>
                                        <tr>
                                            <td colspan="<?php if($ses_user_type!='B'){ echo $cnt+12; } else { echo $cnt+10; } ?>" align="right"  style=" border-top:none !important;"><B>Print Date : <?php echo $print_date; ?> Time : <?php echo $print_dt[1]; ?></B></td>
                                        </tr>
                                    </thead> 
                                    <tr>
                                        <td align="center"><B>SL.</B></td>
                                        <td align="center"><B>GARDEN</B></td>
                                        <td align="center"><B>GRADE</B></td>
                                        <td align="center"><B>INV. NO.</B></td>
                                        <td align="center"><B>NET</B></td>
                                        <td align="center"><B>PKGS</B></td>
                                        <td align="center"><B>VALUATION</B></td>
                                        <td align="center"><B>BSP</B></td>
                                        <?php
                                        if($ses_user_type!='B')
                                        {
                                            ?>
                                            <td align="center"><B>MSP</B></td>
                                            <?php
                                        }
                                        ?>
                                        
                                        <td align="center"><B>BID VALUE</B></td>
                                        <td align="center"><B>PARTY NAME</B></td>
                                        <?php
                                        if($ses_user_type!='B')
                                        {
                                            ?>
                                            <td align="center"><B>STATUS</B></td>
                                            <?php
                                            $g=0;
                                            
                                            foreach ($row as $key => $value) 
                                            {
                                                $g++;
                                                ?>
                                                <td>APP. BY</td>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    $sl=0;
                                    $sqle= "select f.fad_id,f.acd_id,f.garden_nm,f.grade,f.pkgs,f.net,f.invoice_no,f.msp,f.valu_kg ";
                                    $sqle.=",f.base_price,f.bid_price,b.billing_nm ";
                                    $sqle.="from final_auction_dtl f, bidder_mas b ";
                                    $sqle.="where  offer_srl=:offersheet and f.bidder_id=b.bidder_id ";
                                    $sth = $conn->prepare($sqle);
                                    $sth->bindParam(':offersheet', $offersheet);
                                    $sth->execute();
                                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                    $row = $sth->fetchAll();
                                    foreach ($row as $key => $value) 
                                    {
                                        $sl++;
                                        $acd_id=$value['acd_id'];
                                        $garden_nm=$value['garden_nm'];
                                        $grade=$value['grade'];
                                        $pkgs=$value['pkgs'];
                                        $net=$value['net'];
                                        $invoice_no=$value['invoice_no'];
                                        $valu_kg=$value['valu_kg'];
                                        $msp=$value['msp'];
                                        $base_price=$value['base_price'];
                                        $bid_price=$value['bid_price'];
                                        $base_price=$value['base_price'];
                                        $billing_nm=$value['billing_nm'];
                                        $status="NO";
                                        if($bid_price>=$msp)
                                        {
                                            $status="YES";
                                        }
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $sl;?></td>
                                            <td align="center"><?php echo $garden_nm;?></td>
                                            <td align="center"><B><?php echo $grade;?></b></td>
                                            <td align="center"><?php echo $invoice_no;?></td>
                                            <td align="center"><?php echo $net;?></td>
                                            <td align="center"><?php echo $pkgs;?></td>
                                            <td align="center"><?php echo $valu_kg;?></td>
                                            <td align="center"><?php echo $base_price;?></td>
                                            <?php
                                            if($ses_user_type!='B')
                                            {
                                                ?>
                                                <td align="center"><?php echo $msp;?></td>
                                                <?php
                                            }
                                            ?>
                                            <td align="center"><?php echo $bid_price;?></td>
                                            <td align="center"><?php echo $billing_nm;?></td>
                                            <?php
                                            if($ses_user_type!='B')
                                            {
                                                ?>
                                                <td align="center"><?php echo $status;?></td>
                                                <?php
                                                $sqle= "select u.design_nm,u.user_name";
                                                $sqle.=" from bid_app_dtl b,user_mas u ";
                                                $sqle.="where b.uid=u.uid and  acd_id=:acd_id group by b.uid order by b.seq_id";

                                                $sth = $conn->prepare($sqle);
                                                $sth->bindParam(':acd_id', $acd_id);
                                                $sth->execute();
                                                $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                                $row = $sth->fetchAll();
                                                foreach ($row as $key => $value) 
                                                {
                                                    $sl++;
                                                    $design_nm=$value['design_nm'];
                                                    $user_name=$value['user_name'];
                                                    ?>
                                                    <td><?php echo "$design_nm"; ?>        </td>
                                                <?php
                                                }
                                                
                                            }
                                            ?>
                                        <tr>
                                        <?php            
                                    }
                                    ?>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php            
            }
            ?>
            </body>
   </html>
   <?php
}
$conn=null;
?>