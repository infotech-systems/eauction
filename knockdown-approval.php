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
                    <h3 class="box-title">Approval Pending List</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped">
                        <tr>
                            <th>Sl.</th>
                            <th>Offersheet No</th>
                            <th>Auction Period</th>
                            <th>Knockdown Period</th>
                            <th>Location</th>
                            <th>Payment Type</th>
                            <th>Contact Type</th>
                            <th>#</i></th>
                        </tr>
                        <?php
                        $sl=0;
                        $sqle= "select bd.auc_id,fd.offer_srl,fd.location,fd.payment_type,fd.contract_type ";
                        $sqle.=" ,fd.auc_start_time,fd.auc_end_time,fd.knockdown_start,fd.knockdown_end ";
                        $sqle.="from bid_app_dtl bd,final_auction_dtl fd ";
                      //  $sqle.="where bd.uid=:ses_uid and bd.status='P' and bd.auc_id=fd.auc_id  ";
                        $sqle.="group by bd.auc_id  ";
                        $sth = $conn->prepare($sqle);
                     //   $sth->bindParam(':ses_uid', $ses_uid);
                        $sth->execute();
                        $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $sth->fetchAll();
                        foreach ($row as $key => $value) 
                        {
                            $sl++;
                            $e_auc_id=$value['auc_id'];
                            $e_offer_srl=$value['offer_srl'];
                            $e_location=$value['location'];
                            $e_payment_type=$value['payment_type'];
                            $e_contract_type=$value['contract_type'];
                            $e_auc_start_time=$value['auc_start_time'];
                            $e_auc_end_time=$value['auc_end_time'];
                            $e_knockdown_start=$value['knockdown_start'];
                            $e_knockdown_end=$value['knockdown_end'];
                            ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                                <td><?php echo $e_offer_srl; ?></td>
                                <td><?php echo ansi_to_british(substr($e_auc_start_time,0,10)).' '.substr($e_auc_start_time,11,5); ?> - <?php echo ansi_to_british(substr($e_auc_end_time,0,10)).' '.substr($e_auc_end_time,11,5); ?></td>
                                <td><?php echo ansi_to_british(substr($e_knockdown_start,0,10)).' '.substr($e_knockdown_start,11,5); ?> - <?php echo ansi_to_british(substr($e_knockdown_end,0,10)).' '.substr($e_knockdown_end,11,5); ?></td>
                                <td><?php echo $e_location; ?></td>
                                <td><?php echo $e_payment_type; ?></td>
                                <td><?php echo $e_contract_type; ?></td>

                                <td><a href="offersheet-bid-approval.php?param=<?php echo md5($e_auc_id); ?>"><i class="fa fa-hand-o-right"></i></a></td>
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
