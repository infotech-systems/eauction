<?php   
$path=base_url(); 
?>


<section class="content">
    Dear Bidder,<br>
    <div class="page" style="margin-top:10px;">
        <div class="row" >
            <div class="col-md-12" style="float:left;  width:90%;">
                <div class="box" style="float:left; width:100%;">
                    <div class="box-2" style="float:left; width:100%; text-align:center; font-size:30px;  padding:12px;">
                        Offersheet Bid Confirmation
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row"  style="float:left; width:100%; margin-top:10px;">
        <div class="col-md-12" style="float:left; width:90%;">
            <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                <tr>
                   <td style=" padding:4px;   border:1px solid #000; ">Offersheer No</td>
                    <td style=" padding:4px;   border:1px solid #000; "><?php echo $offersheet['offer_srl']; ?></td>
                    <td style=" padding:4px;   border:1px solid #000; ">Auction Start Time</td>
                    <td style=" padding:4px;   border:1px solid #000; ">
                            <?php 
                            if(strlen($offersheet['auc_start_time'])>10)
                            {
                                $ss=explode("-",substr($offersheet['auc_start_time'],0,10));
                                echo $ss[2].'/'.$ss[1].'/'.$ss[0].' '.substr($offersheet['auc_start_time'],11,5);
                            }
                            ?>
                    </td style=" padding:4px;   border:1px solid #000; ">
                </tr>
                <tr>
                   <td style=" padding:4px;   border:1px solid #000; ">Auction End Time</td>
                    <td style=" padding:4px;   border:1px solid #000; ">
                        <?php 
                        if(strlen($offersheet['auc_end_time'])>10)
                        {
                            $ss=explode("-",substr($offersheet['auc_end_time'],0,10));
                            echo $ss[2].'/'.$ss[1].'/'.$ss[0].' '.substr($offersheet['auc_end_time'],11,5);
                        }
                        ?>
                    </td>
                    <td style=" padding:4px;   border:1px solid #000; ">Payment Type</td>
                    <td style="padding:4px; border:1px solid #000;"><?php echo $offersheet['payment_type']; ?></td>
                </tr>
                <tr>
                   <td style="padding:4px; border:1px solid #000;">Contract Type</td>
                    <td style="padding:4px; border:1px solid #000;"><?php echo $offersheet['contract_type']; ?></td>
                    <td style="padding:4px; border:1px solid #000;">Location</td>
                    <td style="padding:4px; border:1px solid #000;"><?php echo $offersheet['location']; ?></td>
                </tr>
                <tr>
                   <td style="padding:4px; border:1px solid #000;">Bidder Name</td>
                    <td style="padding:4px; border:1px solid #000;"><?php echo $offersheet['name']; ?></td>
                    <td style="padding:4px; border:1px solid #000;">Billing Name</td>
                    <td style="padding:4px; border:1px solid #000;"><?php echo $offersheet['billing_nm']; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row"  style="float:left; width:100%; margin-top:10px;">
        <div class="col-md-12" style="float:left; width:90%;">
            <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                <thead style="background-color:green; color:#FFFFFF; font-weight:bold;">
                    <tr>
                        <td style="padding:4px; border:1px solid #000;">Sl.</td>
                        <td style="padding:4px; border:1px solid #000;">Lot No</td>
                        <td style="padding:4px; border:1px solid #000;">Garden</td>
                        <td style="padding:4px; border:1px solid #000;">Grade</td>
                        <td style="padding:4px; border:1px solid #000;">Invoice</td>
                        <td style="padding:4px; border:1px solid #000;">Pkgs</td>
                        <td style="padding:4px; border:1px solid #000;">Valuation</td>
                        <td style="padding:4px; border:1px solid #000;">HBP</td>
                        <td style="padding:4px; border:1px solid #000;">Billing Name</td>
                        <td style="padding:4px; border:1px solid #000;">Bid Price 1</td>
                        <td style="padding:4px; border:1px solid #000;">Bid price 2</td>
                        <td style="padding:4px; border:1px solid #000;">Bid price 3</td>
                    </tr>
                </thead>
                <?php
                $i=0;
                foreach($items as $item)
                {
                    $i++;
                    ?>
                    <tr>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $i; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['lot_no']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['garden_nm']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['grade']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['invoice_no']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['pkgs']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['valu_kg']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['bid_price']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $offersheet['billing_nm']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['bid_price1']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['bid_price2']; ?></td>
                        <td style="padding:4px; border:1px solid #000;"><?php echo $item['bid_price3']; ?></td>
                    </tr>
                    <?php
                }
                ?>
                
            </table>
            <table style="margin-top:30px; width:100%;">
                <tr>
                    <?php
                    if($signs)
                    {
                        foreach($signs as $sign)
                        {
                            ?>
                            <td>
                                <img src="<?php echo base_url('../'.$sign['signature']); ?>" style="height:50px;">
                                <br>
                                <p style="  text-decoration-line: overline; width:50%;"><?php echo $sign['design_nm']; ?></p>
                            </td>
                            <?php
                        }
                    }
                    ?>
                </tr>
            </table>
        </div>
    </div>   

        
</section>
