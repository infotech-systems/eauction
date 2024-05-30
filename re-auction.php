<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); 
?>
<style>
    td a 
    {
        color:#000;
    }
</style>
<form name="form1"  id="fileUploadForm"  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return validate()">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header  with-border">
                    <h3 class="box-title">Re-Auction Pending offersheet </h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped">
                        <tr>
                            <th>Sl.</th>
                            <th>Offersheet No</th>
                            <th>Location</th>
                            <th>Payment Type</th>
                            <th>Contact Type</th>
                            <th>End Time</th>
                            <th>#</i></th>
                        </tr>
                        <?php
                        $sl=0;
                        $current_time=date("H:i:s",time());
                        $sqle= "select am.auc_id,am.offer_srl,am.offer_nm,am.location,am.payment_type,am.contract_type,am.knockdown_end ";
                        $sqle.="from auction_mas am,auction_dtl ad ";
                        $sqle.="where am.auc_id=ad.auc_id and am.knockdown_end<current_timestamp ";
                        $sqle.="group by am.auc_id ";
                        $sth = $conn->prepare($sqle);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                            $sl++;
                            $e_auc_id=$value['auc_id'];
                            $e_offer_srl=$value['offer_srl'];
                            $e_offer_nm=$value['offer_nm'];
                            $e_location=$value['location'];
                            $e_payment_type=$value['payment_type'];
                            $e_contract_type=$value['contract_type'];
                            $e_knockdown_end=$value['knockdown_end'];
                            ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                                <td><?php echo $e_offer_srl; ?></td>
                                <td><?php echo $e_location; ?></td>
                                <td><?php echo $e_payment_type; ?></td>
                                <td><?php echo $e_contract_type; ?></td>
                                <td><?php echo ansi_to_british(substr($e_knockdown_end,0,10)).' '.substr($e_knockdown_end,11,5); ?></td>
                                <td><a href="re-auction-offersheet-bid.php?param=<?php echo md5($e_auc_id); ?>"><i class="fa fa-hand-o-right"></i></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
       
    
</form>


<?php include('./footer.php'); ?>
