<?php 
/*include("/var/www/vhosts/bridgeroof.in/eoffice.bridgeroof.in/cps/inc/dblib.inc.php");
$filenameL = "/var/www/vhosts/bridgeroof.in/eoffice.bridgeroof.in/cps/autobid/*.txt";*/
include("./inc/dblib.inc.php");
$conn = OpenDB();
//("./inc/dblib.inc.php");

$filenameL = "autobid/*.txt";
foreach(glob($filenameL) as $txt_file_path)
{
    $dd=explode("/",$txt_file_path);
    $ss=explode(".",$dd[1]);
    $acd_id=$ss[0];

    $sqle= "select ab.bidder_id,ab.auc_id,ab.acd_id,ab.autobid_price,ab.autbid_maxprice,max(bid_price) as max_price,abd.bidder_id as max_bidder ";
    $sqle.="from autobid_mas ab,auc_bid_dtl abd WHERE ab.acd_id=:acd_id and ab.acd_id=abd.acd_id ";

    echo "$sqle $acd_id";
    $sth = $conn->prepare($sqle);
    $sth->bindParam(':acd_id', $acd_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sth->fetchAll();
    foreach ($row as $key => $value) 
    {
        print_r($value);
        $e_bidder_id=$value['bidder_id'];
        $e_auc_id=$value['auc_id'];
        $e_max_price=$value['max_price'];
        $e_autobid_price=$value['autobid_price'];
        $e_autbid_maxprice=$value['autbid_maxprice'];
        $e_max_bidder=$value['max_bidder'];
        $au_price=$e_autobid_price+$e_max_price;
        if(($au_price<=$e_autbid_maxprice) and ($e_bidder_id!=$e_max_bidder))
        {
            $sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
            $sql_ins.=",bidder_id,bid_price,bid_time";
            $sql_ins.=" ) values(  ";
            $sql_ins.=" :e_auc_id,:acd_id,:e_bidder_id,:au_price,current_timestamp) ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':e_auc_id', $e_auc_id);
            $sthI->bindParam(':acd_id', $acd_id);
            $sthI->bindParam(':e_bidder_id', $e_bidder_id);
            $sthI->bindParam(':au_price', $au_price);
            $sthI->execute();
        }
    }
}

 ?>
