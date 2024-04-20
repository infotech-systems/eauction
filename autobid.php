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

    $i=0;
    $sqle= "select ab.bidder_id,ab.auc_id,ab.acd_id,ab.autobid_price,ab.autbid_maxprice ";
    $sqle.="from autobid_mas ab WHERE ab.acd_id=:acd_id order by ab.auto_id ";
    $sth = $conn->prepare($sqle);
    $sth->bindParam(':acd_id', $acd_id);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sth->fetchAll();
    foreach ($row as $key => $value) 
    {
        $e_bidder_id=$value['bidder_id'];
        $e_auc_id=$value['auc_id'];
        $e_autobid_price=$value['autobid_price'];
        $e_autbid_maxprice=$value['autbid_maxprice'];

        $sqle= "select max(bid_price) as max_abidder,bidder_id ";
        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id ";
        $sth = $conn->prepare($sqle);
        $sth->bindParam(':acd_id', $acd_id);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $e_max_abidder=$row['max_abidder'];

        $sqle= "select bidder_id ";
        $sqle.="from auc_bid_dtl WHERE acd_id=:acd_id and bid_price=:e_max_abidder ";
        $sth = $conn->prepare($sqle);
        $sth->bindParam(':acd_id', $acd_id);
        $sth->bindParam(':e_max_abidder', $e_max_abidder);
        $sth->execute();
        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
        $row = $sth->fetch();
        $e_mbidder_id=$row['bidder_id'];

        $ab=$e_autobid_price+$e_max_abidder;
        if(($ab<=$e_autbid_maxprice) and ($e_bidder_id!=$e_mbidder_id))
        {
            $i++;
            $sql_ins ="insert into auc_bid_dtl(auc_id,acd_id ";
            $sql_ins.=",bidder_id,bid_price,bid_time";
            $sql_ins.=" ) values(  ";
            $sql_ins.=" :e_auc_id,:acd_id,:e_bidder_id,:ab,current_timestamp) ";
            $sthI = $conn->prepare($sql_ins);
            $sthI->bindParam(':e_auc_id', $e_auc_id);
            $sthI->bindParam(':acd_id', $acd_id);
            $sthI->bindParam(':e_bidder_id', $e_bidder_id);
            $sthI->bindParam(':ab', $ab);
            $sthI->execute();
        }
    }   
    
    if($i==0)
    {
        unlink($txt_file_path);
    }
}

 ?>
