<?php
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
if($submit=="Excel")
{
    $database='Agency-Charge-Approval';
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
            <title>Agency Charge Report</title>
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

                                
                                ?>
                                <table class="table table-bordered" width="95%">
                                    <thead>
                                    <?php
                                    if($submit=="Submit")
                                    {
                                        ?>
                                        <tr>
                                            <td rowspan="2" align="left"><img src="<?php echo $full_url; ?>/images/logo.png" width="35" hight="45"/></td>
                                           
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                        <tr>
                                            <td colspan="3" align="center"  style=" border-top:none !important;"><B><?php echo "<b>$ses_orgn_nm</b> <br /> $ses_orgn_addr";?></B></td>
                                        </tr>
                                        <tr> 
                                            <td ><B>Offer Sheet No: <?php echo $offersheet;?></B></td>
                                            <td align="right" colspan="2" style=" border-top:none !important;"><B>Print Date : <?php echo $print_date; ?> Time : <?php echo $print_dt[1]; ?></B></td>
                                        </tr>
                                    </thead> 
                                    <?php
                                    $sl=0;
                                    $Tbill_value=0;
                                    $Tkg=0;
                                    $sqle= "select f.acd_id,f.auc_id,f.lot_no,f.garden_nm,f.grade,f.pkgs,f.net,f.invoice_no,f.msp,f.valu_kg ";
                                    $sqle.=",f.base_price,f.bid_price,b.billing_nm,b.name,b.bidder_type ";
                                    $sqle.="from final_auction_dtl f, bidder_mas b ";
                                    $sqle.="where  offer_srl=:offersheet and f.bidder_id=b.bidder_id and f.all_app='Y' ";
                                    $sth = $conn->prepare($sqle);
                                    $sth->bindParam(':offersheet', $offersheet);
                                    $sth->execute();
                                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                    $row = $sth->fetchAll();
                                    foreach ($row as $key => $value) 
                                    {
                                        $sl++;
                                        $acd_id=$value['acd_id'];
                                        $auc_id=$value['auc_id'];
                                        $lot_no=$value['lot_no'];
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
                                        $agency_name=$value['name'];
                                        $bidder_type=$value['bidder_type'];

                                        $bill_value=0;
                                        $bill_value=$net*$bid_price;
                                        $Tbill_value=$Tbill_value+$bill_value;
                                        $Tkg=$Tkg+$net;
                                        $agency_chrg=0;
                                        if($bidder_type=="A")
                                        {
                                            $agency_chrg=($Tbill_value*1)/100;
                                            $bNaMe="Agent's Name";
                                        }
                                        else
                                        {
                                            $bNaMe="Bidders's Name";
                                        }
                                    }
                                    ?>
                                    <tr><td><B>Buyer's Name</B></td><td><B><?php echo $billing_nm;?></B></td></tr>
                                    <tr><td><B><?php echo $bNaMe;?></B></td><td><B><?php echo $agency_name;?></B></td></tr>
                                    <tr><td><B>Total Qty Sold</B></td><td><B><?php echo $Tkg;?> Kg.</B></td></tr>
                                    <tr><td><B>No of Invoice</B></td><td><B><?php echo $sl;?> </B></td></tr>
                                    <tr><td><B>Total Invoice Value</B></td><td><B><?php echo number_format($Tbill_value,2);?></B> </td></tr>
                                    <tr><td><B>Agency Charge @ 1% of Bill Value</B></td><td><B><?php echo number_format($agency_chrg,2);?></B> </td></tr>                                       
                                    </table>
                                    <table style="margin-top:30px; width:100%;">
                                        <tr>
                                            <?php
                                            $sl=0;
                                            $sqle= "select u.design_nm,u.signature";
                                            $sqle.=" from user_mas u ";
                                            $sqle.="where u.uid=:ses_uid ";
                                            $sth = $conn->prepare($sqle);
                                            $sth->bindParam(':ses_uid', $ses_uid);
                                            $sth->execute();
                                            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                            $row = $sth->fetchAll();
                                            foreach ($row as $key => $value) 
                                            {
                                                $sl++;
                                                $design_nm=$value['design_nm'];
                                                $signature=$value['signature'];
                                                if(!empty($signature))
                                                {
                                                ?>
                                                <td>
                                                    <img src="./<?php echo $signature; ?>" style="height:50px;">
                                                    <br>
                                                    <p style="  text-decoration-line: overline; width:50%;"><?php echo $design_nm; ?></p>
                                                </td>
                                                <?php
                                                }
                                                
                                            }
                                            ?>
                                        </tr>
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