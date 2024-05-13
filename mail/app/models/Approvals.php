<?php
Class Approvals extends SM_Model
{
	
	public function pending_mail()
	{

		$query=$this->db->select('fd.auc_id,fd.bidder_id,fd.auc_start_time,fd.auc_end_time')
                        ->select('fd.payment_type,fd.contract_type,fd.offer_srl,fd.location')
                        ->select('bm.billing_nm,bm.bidder_type,bm.email_id,bm.name')
                        ->select('bm.addr,bm.state_code,bm.pin,bm.pan_no,gst_no')
                        ->where('fd.all_app','Y')
                        ->where('fd.mail_send','N')
                        ->where('bm.email_id is NOT NULL', NULL, FALSE)
						->from('final_auction_dtl fd')
						->join('bidder_mas bm','fd.bidder_id=bm.bidder_id','LEFT')
						->group_by('fd.auc_id,fd.bidder_id,fd.auc_start_time,fd.auc_end_time')
		 				->get();
		if($query->num_rows())
        {
        return $query->result_array();
        }
        else
        {
        return FALSE;
        }
	}
    public function show_item($auc_id,$bidder_id,$auc_start_time,$auc_end_time)
	{

		$query=$this->db->select('lot_no,garden_nm,grade,invoice_no,msp,bid_price')
                        ->select('gp_date,chest,net,pkgs,valu_kg,base_price,acd_id,bidder_id')
                        ->from('final_auction_dtl')
						->where('all_app','Y')
						->where('mail_send','N')
                        ->where(array('auc_id'=>$auc_id,'bidder_id'=>$bidder_id))
                        ->where(array('auc_start_time'=>$auc_start_time,'auc_end_time'=>$auc_end_time))
		 				->get();
		// echo $this->db->last_query();
		if($query->num_rows())
        {
        return $query->result_array();
        }
        else
        {
        return FALSE;
        }
	}
    public function show_bidprice($auc_id,$acd_id,$bid_price)
	{

		$query=$this->db->select('bid_price')
                        ->from('fin_auc_bid_dtl')
						->where('bid_price <',$bid_price)
                        ->where(array('auc_id'=>$auc_id,'acd_id'=>$acd_id))
                        ->order_by('bid_price desc')
                        ->limit('1')
		 				->get();
		// echo $this->db->last_query();
		if($query->num_rows())
        {
        return $query->row();
        }
        else
        {
        return FALSE;
        }
	}
	public function show_sign($auc_id,$auc_start_time,$auc_end_time)
	{

		$query=$this->db->select('u.design_nm,u.signature ')
                        ->from('final_auction_dtl fd')
						->where('fd.all_app','Y')
						->where('fd.mail_send','N')
						->join('bid_app_dtl b','fd.fad_id=b.fad_id')
						->join('user_mas u','u.uid=b.uid')
                        ->where(array('fd.auc_id'=>$auc_id,'fd.auc_start_time'=>$auc_start_time,'fd.auc_end_time'=>$auc_end_time))
                        ->group_by('u.uid')
		 				->get();
		// echo $this->db->last_query();
		if($query->num_rows())
        {
        return $query->result_array();
        }
        else
        {
        return FALSE;
        }
	}
	public function update_data($data,$auc_id,$bidder_id,$auc_start_time,$auc_end_time)
	{
		return $this->db->where(array('auc_id'=>$auc_id,'bidder_id'=>$bidder_id))
                        ->where(array('auc_start_time'=>$auc_start_time,'auc_end_time'=>$auc_end_time))
                        ->update('final_auction_dtl', $data);
	}
	
}
?>