<?php
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
if($submit=="Excel")
{
    $database='Committee-Approval';
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

$file_type = isset($_REQUEST['file_type']) ? $_REQUEST['file_type'] : '';
if($file_type=="U")
$file_desc="File uploaded";
if($file_type=="B")
$file_desc="Active Bids";
if($file_type=="K")
$file_desc="Knowckdown done successfully";
if($file_type=="A")
$file_desc="Committee Approval Done";
if($file_type=="P")
$file_desc="Committee Approval Pending";
if($file_type=="M")
$file_desc="Confirmation mail sent";

//echo "xxx$file_type -->$file_desc";

$sqlTK="SELECT count(uid) as tk from user_mas where token=:ses_token and uid=:ses_uid ";
//echo "$sqlTK $csrftoken ==> $ses_uid<br>";
$sthTK = $conn->prepare($sqlTK);
$sthTK->bindParam(':ses_token', $ses_token);
$sthTK->bindParam(':ses_uid', $ses_uid);
$sthTK->execute();
$ssTK=$sthTK->setFetchMode(PDO::FETCH_ASSOC);
$rowTK = $sthTK->fetch();
$tk=$rowTK['tk'];
$submit="Submit";
if($tk>0)
{

    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Dashboard Report</title>
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
                                            <td rowspan="3" align="center"><img src="<?php echo $full_url; ?>/images/logo.png" width="35" hight="45"/></td>
                                            <td  colspan="7" align="center" style=" border-bottom:none !important;">&nbsp;</td> 
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                        <tr>
                                            <td colspan="7" align="center"  style=" border-top:none !important;border-bottom:none !important;"><B><?php echo "<b>$ses_orgn_nm</b> <br /> $ses_orgn_addr";?></B></td>
                                        </tr>
                                        <tr> 
                                            <td colspan="4"><B><?php echo $file_desc;?></B></td>
                                            <td colspan="3" align="right"  style=" border-top:none !important;"><B>Print Date : <?php echo $print_date; ?> Time : <?php echo $print_dt[1]; ?></B></td>
                                        </tr>
                                    </thead> 
                                    <tr>
                                        <td><B>Sl.</B></td>
                                        <td><B>Offer Sheet No</B></td>
                                        <td><B>Bid Start On</B></td>
                                        <td><B>Bid End On</B></td>
                                        <td><B>Knowckdown Start</B></td>
                                        <td><B>Knowckdown End</B></td>
                                        <td><B>Location</B></td>
                                    </tr>
                                    <?php
                                    $sl=0;
                                    $Tbill_value=0;
                                    $Tkg=0;
                                    $sqle= "select a.auc_start_time,a.auc_end_time,a.knockdown_start,a.knockdown_end,a.offer_srl, ";
                                    $sqle.="a.location,a.auc_id ";
                                    $sqle.="from auction_mas a  ";
                                    if($file_type=="K")
                                    $sqle.=",fin_auc_bid_dtl f ";
                                    if($file_type=="A" OR $file_type=="P" OR $file_type=="M")
                                    $sqle.=",final_auction_dtl f ";
                                
                                    $sqle.="where 1=1 ";
                                    if($file_type=="B")
                                    {
                                        $sqle.="and substr(auc_start_time,1,10)>=CURRENT_DATE and auc_end_time<=CURRENT_TIMESTAMP ";
                                    }
                                    if($file_type=="K")
                                    {
                                        $sqle.="and a.auc_id=f.auc_id group by f.auc_id ";
                                    }
                                    if($file_type=="A")
                                    {
                                        $sqle.="and a.auc_id=f.auc_id and all_app='Y' group by f.auc_id ";
                                    }
                                    if($file_type=="P")
                                    {
                                        $sqle.="and a.auc_id=f.auc_id and b.auc_id=f.auc_id and all_app='N' group by f.auc_id ";
                                    }
                                    if($file_type=="M")
                                    {
                                        $sqle.="and a.auc_id=f.auc_id and mail_send='Y' group by f.auc_id,bidder_id  ";
                                    }

                                    $sth = $conn->prepare($sqle);
                                //    $sth->bindParam(':offersheet', $offersheet);
                                    $sth->execute();
                                    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                    $row = $sth->fetchAll();
                                    foreach ($row as $key => $value) 
                                    {
                                        $sl++;
                                        $auc_id=$value['auc_id'];
                                        $auc_start_date=substr($value['auc_start_time'],0,10);
                                        $auc_start_time=substr($value['auc_start_time'],11,5);
                                        $auc_end_date=substr($value['auc_end_time'],0,10);
                                        $auc_end_time=substr($value['auc_end_time'],11,5);
                                        $knockdown_start_date=substr($value['knockdown_start'],0,10);
                                        $knockdown_start_time=substr($value['knockdown_start'],11,5);
                                        $knockdown_end_date=substr($value['knockdown_end'],0,10);
                                        $knockdown_end_time=substr($value['knockdown_end'],11,5);
                                        $offer_srl=$value['offer_srl'];
                                        $location=$value['location'];
                                       
                                        $bid_start=ansi_to_british($auc_start_date)." ".$auc_start_time;
                                        $bid_end=ansi_to_british($auc_end_date)." ".$auc_end_time;
                                        $knowck_start=ansi_to_british($knockdown_start_date)." ".$knockdown_start_time;
                                        $knowck_end=ansi_to_british($knockdown_end_date)." ".$knockdown_end_time;

                                        /*
                                        $sql=" select bid_price from fin_auc_bid_dtl ";
                                        $sql.=" where bid_price < :bid_price ";
                                        $sql.=" and auc_id=:auc_id and acd_id=:acd_id ";
                                        $sql.=" order by bid_price desc limit 1 ";
                                        $sth = $conn->prepare($sql);
                                        $sth->bindParam(':bid_price', $bid_price);                                        
                                        $sth->bindParam(':auc_id', $auc_id);                                        
                                        $sth->bindParam(':acd_id', $acd_id);                                        
                                        $sth->execute();
                                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                                        $row2 = $sth->fetch();
                                        $bid_price1=null;
                                        if($row2)
                                        {
                                            $bid_price1=$row2['bid_price'];
                                        }
                                        */

                                        $bill_value=0;
                                        $bill_value=$net*$bid_price;
                                        $Tbill_value=$Tbill_value+$bill_value;
                                        $Tkg=$Tkg+$net;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $sl;?></td>
                                            <td align="center"><?php echo $offer_srl;?></td>
                                            <td align="center"><?php echo $bid_start;?></td>
                                            <td align="center"><?php echo $bid_end;?></td>
                                            <td align="center"><?php echo $knowck_start;?></td>
                                            <td align="center"><?php echo $knowck_end;?></td>
                                            <td align="center"><?php echo $location;?></td>
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