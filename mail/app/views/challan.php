<?php   $path=base_url();  ?>

<section class="content">
    Dear Sir,<br>
    Greetings  from ESKAY.<br>
    Please find the Challan copy of the items that are being sent to yours as per your order. <br>
    This is for your kind information.<br>
    <div class="page" style="margin-top:10px;">
        <div class="row" >
            <div class="col-md-12" style="float:left;  width:90%;">
                <div class="box" style="float:left; width:100%;  border:1px solid #000;">
                    <div class="box-1" style="float:left; width:25%;">
                        <?php $spath=substr($path,0,-5).''.$orgn->orgn_logo; ?> 
                        <img src="<?php echo "$spath"; ?>"style="width:100%;" />
                    </div>
                    <div class="box-2" style="float:left; width:60%; text-align:center; font-size:30px;  padding:12px;">
                        Challan
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="float:left;  width:90%; margin-top:10px;">
            <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                <tr class="box-9" style="border: 1px solid #000 !important; width: 100% !important; min-height: 20px !important;">
                    <td style="border-right: 1px solid #000 !important; width: 32% !important; padding: 5px !important;" valign="top">
                        <table>
                            <tr>
                                <td colspan="2" style="font-weight: bold; font-size: 13px; width: 100% !important;">From</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight: bold;  text-transform: uppercase; font-size: 13px; width: 100% !important;">
                                <?php echo $orgn->bill_nm; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;   width: 100% !important;">
                                    <?php echo $orgn->orgn_addr; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Phone No</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo $orgn->cont_no; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Email Id:</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo $orgn->email_id; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">PAN No</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo substr($orgn->gst_no,2,10); ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">GST No.</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo $orgn->gst_no; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">State</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo "$orgn->state_nm ($orgn->state_code)"; ?></td>
                            </tr>
                        </table>

                    </td>
                    <td style="border-right: 1px solid #000 !important; width: 32% !important; padding: 5px !important;" valign="top">
                        <table>
                            <tr>
                                <td colspan="2" style="font-weight: bold; font-size: 13px; width: 100% !important;">To</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-weight: bold;  text-transform: uppercase; font-size: 13px; width: 100% !important;">
                                <?php echo $challan->cust_nm; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;   width: 100% !important;">
                                    <?php echo $challan->addr; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Phone No</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo $challan->cont_no; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Email Id:</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo $challan->email_id; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">PAN No</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo substr($challan->gst_no,2,10); ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">GST No.</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo $challan->gst_no; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">State</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo "$challan->state_nm ($challan->state_code)"; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align:left !important; padding:5px;" valign="top">
                        <table width="100%">                           
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Chln No</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important; font-weight:bold;" valign="top">: <?php echo $challan->chl_no; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important"  valign="top">Chln Dt</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo $challan->chl_dt; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Ref. No</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo $challan->ref_chl; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important" valign="top">GST No.</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo $challan->gst_no; ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Created</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo "$challan->user_name"; ?></td>
                            </tr>
                                        
                            <?php
                            if($challan->orgn_id==1)
                            { 
                                ?>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important">Camera</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo "$driver->emp_nm"; ?></td>
                                </tr>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important" valign="top">In Charge</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;">: <?php echo "$challan->user_name"; ?></td>
                                </tr>
                                <?php
                            }
                            if($challan->orgn_id==2)
                            { 
                                ?>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important" valign="top">Out KM</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo "$challan->km_open"; ?></td>
                                </tr>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important" valign="top">Out Time</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo substr($challan->out_time,0,-3); ?></td>
                                </tr>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important">Driver</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo $driver->emp_nm; ?></td>
                                </tr>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important" valign="top">Helper</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo "$helper->emp_nm"; ?></td>
                                </tr>
                            <?php
                            }
                            if($challan->orgn_id==3)
                            { 
                                ?>
                                <tr>
                                    <td style="float: left; font-size: 13px;   width: 24.8% !important">Lightman</td>
                                    <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo "$driver->emp_nm"; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Call Time</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo substr($challan->call_time,0,5); ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Rental Type</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php if($rental){ echo $rental->rental_type_desc; } ?></td>
                            </tr>
                            <tr>
                                <td style="float: left; font-size: 13px;   width: 24.8% !important">Rental Date</td>
                                <td style="float: left; font-size: 13px; width: 70.2% !important;" valign="top">: <?php echo $challan->rental_date; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
           
            </table>
            
        </div>
        <div class="row" style="float:left; width:100%; margin-top:10px;">
            <div class="col-md-12" style="float:left; width:90%;">
                     <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                        <tr class="box-9" style="border: 1px solid #000 !important; width: 100% !important; min-height: 20px !important;">
                            <td style="border-right: 1px solid #000 !important; padding: 5px !important;" valign="top">
                                Project Name: <b><?php if($project){ echo $project->proj_nm; } ?></b>
                            <td>
                            <td style=" padding: 5px !important;" valign="top">
                                 Location: <b><?php echo $challan->location; ?></b>
                            <td>
                        </tr>
                     </table>
            </div>
        </div>
        <div class="row"  style="float:left; width:100%; margin-top:10px;">
            <div class="col-md-12" style="float:left; width:90%;">
                <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="3" class="box-8" style=" width: 100% !important; min-height: 20px !important;  text-align: center; text-transform: uppercase;  padding: 3px;
                            font-size: 14px; border: 1px solid #000 !important; border-bottom: none !important;">Item Information</th>
                        </tr>
                        <tr class="box-9" style="border: 1px solid #000 !important; width: 97% !important; min-height: 20px !important;">
                            <th class="cell1"  style="border-right: 1px solid #000 !important; width: 4% !important; padding-top: 2px !important; text-align: center; min-height: 22px !important;  font-size: 14px;">Sl</th>
                            <th class="cell2" style=" border-right: 1px solid #000 !important;
                            width: 86% !important;
                            padding-top: 2px !important;
                            text-align: center;
                            min-height: 20px !important;.
                            font-size: 14px;">Description</th>
                            <th class="cell4" style="width: 11% !important;
                            padding-top: 2px !important;
                            text-align: center;
                            min-height: 20px !important;
                            font-size: 14px;">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($challans):
                        foreach($challans as $chl):
                            ?>
                            <tr class="box-9" style="border-left: 1px solid #000 !important;
                    border-right: 1px solid #000 !important;
                    width: 100% !important;
                    min-height: 20px !important;">
                                <td class="cell5"style="border-right: 1px solid #000 !important;
                                    width: 4% !important;
                                    padding-top: 2px !important;
                                    text-align: center;
                                    min-height: 22px !important;
                                    font-size: 14px;"><?php echo $chl['sl']; ?></td>
                                <td class="cell6"style="border-right: 1px solid #000 !important;
                                    width: 54% !important;
                                    padding-top: 2px !important;
                                    padding-left: 1% !important;
                                    text-align: left;
                                    min-height: 23px !important;
                                    font-size: 14px;"><?php echo $chl['item_desc']; ?></td>
                                <td style="text-align:right !important;"><?php echo $chl['item_qty']; ?>&nbsp;</td>
                            </tr>
                            <?php
                            if($chl['details']!=null):
                                ?>
                                <tr class="box-9" style="border-left: 1px solid #000 !important;
                                border-right: 1px solid #000 !important;
                                width: 100% !important;
                                min-height: 20px !important;">
                                    <td class="cell5" style=" border-right: 1px solid #000 !important;
                                                width: 4% !important;
                                                padding-top: 2px !important;
                                                text-align: center;
                                                min-height: 22px !important;
                                                font-size: 14px;
                                            "></td>
                                                <td class="cell6" style=" border-right: 1px solid #000 !important;
                                                width: 54% !important;
                                                padding-top: 2px !important;
                                                padding-left: 1% !important;
                                                text-align: left;
                                                min-height: 22px !important;
                                                font-size: 14px;"><b><u>ACCESSORIES</u></b></td>
                                                <td class="cell8" style=" width: 10% !important;
                                                padding-top: 2px !important;
                                                text-align: right !important;
                                                min-height: 22px !important;
                                                font-size: 14px;"></td>
                                </tr>
                                <?php
                                foreach($chl['details'] as $acc):
                                  //  print_r($acc);
                                    ?>
                                    <tr class="box-9" style="border-left: 1px solid #000 !important;
                            border-right: 1px solid #000 !important;
                            width: 100% !important;
                            min-height: 20px !important;">
                                            <td class="cell5"  style=" border-right: 1px solid #000 !important;
                                            width: 4% !important;
                                            padding-top: 2px !important;
                                            text-align: center;
                                            min-height: 22px !important;
                                            font-size: 14px;
                                        "></td>
                                            <td class="cell6" style=" border-right: 1px solid #000 !important;
                                            width: 54% !important;
                                            padding-top: 2px !important;
                                            padding-left: 1% !important;
                                            text-align: left;
                                            min-height: 22px !important;
                                            font-size: 14px;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $acc['sl']; ?>)&nbsp;&nbsp;<?php echo $acc['acc_desc']; ?>
                                        </td>
                                        <td style="text-align:right !important;"><?php echo $acc['item_qty']; ?>&nbsp;</td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        endforeach;
                    endif;
                    ?>
                        <tr>
                            <td colspan="3" class="box10"style=" border: 1px solid #000;
                                    font-size: 14px;
                                    padding: 2px 4px;">
                                <b>Support Staff(s):</b>
                                <?php echo $support->support_staff; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        if($challan->orgn_id=='2'): 
        ?>
            <div class="row" style="width: 90% !important;">
                <div  style="float:left; width:100%; margin:10px 0px;">
                    <table style="float: right; width: 50% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                        <thead>
                            <tr class="box-9" style="border: 1px solid #000 !important; width: 97% !important; min-height: 20px !important;">
                                <th style="border-right: 1px solid #000 !important; width: 25% !important;  min-height: 22px !important;">Date</th>
                                <th style="border-right: 1px solid #000 !important; width: 25% !important;  min-height: 22px !important;">On Time</th>
                                <th style="border-right: 1px solid #000 !important; width: 25% !important;  min-height: 22px !important;">Off Time</th>
                                <th style="border-right: 1px solid #000 !important; width: 25% !important;  min-height: 22px !important;">Duration</th>
                            </tr>
                            <tr class="box-9" style="border: 1px solid #000 !important; width: 97% !important; min-height: 20px !important;">
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                            </tr>
                            <tr class="box-9" style="border: 1px solid #000 !important; width: 97% !important; min-height: 20px !important;">
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                            </tr>
                            <tr class="box-9" style="border: 1px solid #000 !important; width: 97% !important; min-height: 20px !important;">
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                            </tr>
                            <tr class="box-9" style="border: 1px solid #000 !important; width: 97% !important; min-height: 20px !important;">
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                                <th style="border-right: 1px solid #000 !important; height: 22px !important;"></th>
                            </tr>
                        </thead>
                    </table>           
                    
                   
                </div>
            </div>

            <?php
        endif;
        ?>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-12" style="float:left; width:90%">
                <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                    <tr class="box-9" style="border: 1px solid #000 !important; width: 100% !important; min-height: 20px !important;">
                        <td style="border-right: 1px solid #000 !important; padding: 5px !important;" valign="top">
                        <p style="margin-top: 75px !important;
                        width: 200px;
                        text-align: center;">Received the above items.<br>
                            Signature with Seal.</p>
                        <td>
                        <td style=" padding: 5px !important;" valign="top">
                            <p style="margin-top: 60px !important;
                            width: 100%;
                            text-align: center;
                        "> Signature & Seal<br>
                                <b><?php echo $orgn->bill_nm ?></b>
                            </p>
                        <td>
                    </tr>
                </table>
                
            </div>
        </div>
        <div  style="margin-top:0px; width:90%; position:relative; float:left;">
                <div class="col-md-12">
                <p  style="text-align: justify; margin-top:20px; position:relative;">Note:<br/></p>
                <?php
                if($challan->orgn_id==1)
                {
                    ?>    
                    <p>1. Production has to pay for any damage to equipment at shooting location.</p>  
                    <?php
                }
                if($challan->orgn_id==2)
                {
                    ?>    
                    <p>1. Production has to pay for any damage to equipment/Vehicle at shooting location.</p>  
                    <?php
                }
                if($challan->orgn_id==3)
                {
                    ?>    
                    <p>1. 100 % Lamp cutting charges to be borne by Production.</p>  
                    <p>2. Production has to pay for any damage to equipment at shooting location.</p>  
                    <?php
                }
                ?>
                </div>
            </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-12" style="float:left; width:90%">
                <table style="float: left; width: 100% !important; margin: 5px 0px !important;  border-collapse: collapse;">
                    <tr class="box-9" style="border: 1px solid #000 !important; width: 100% !important; min-height: 20px !important;">
                        <td style=" padding: 5px !important;" valign="top">
                        <p style=" text-align: left;">All disputes (if any) must be brought to the notice of the Rental Company within 24 hrs. After that Rental Company shall not be liable for any discrepancy.

</p>
                        <td>
                       
                    </tr>
                </table>
                
            </div>
        </div>

        <div style="margin-top:0px; width:90%; position:relative; float:left;">
            <p style="text-align: justify; margin-top:20px; position:relative;">This is a system generated e-mail please do reply to this email. This E-Mail (including any attachments) may contain Confidential and/or legally privileged Information and is meant for the intended recipient(s) only. If you have received this e-mail in error and are not the intended recipient/s, kindly delete this e-mail immediately from your system. You are also hereby notified that any use, any form of reproduction, dissemination, copying, disclosure, modification, distribution and/or publication of this e-mail, its contents or its attachment/s other than by its intended recipient/s is strictly prohibited and may be construed unlawful. Internet Communications cannot be guaranteed to be secure or error-free as information could be delayed, intercepted, corrupted, lost, or may contain viruses. ESKAY Group does not accept any liability for any errors, omissions, viruses or computer shutdown (s) or any kind of disruption/denial of services if any experienced by any recipient as a result of this e-mail.
            </p>
    </div>
</section>
