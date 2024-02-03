<?php
Class Knockdowns extends SM_Model
{
	
	public function pending_mail()
	{

		$query=$this->db->select('fd.auc_id,fd.bidder_id,fd.auc_start_time,fd.auc_end_time')
                        ->select('fd.payment_type,fd.contract_type,fd.offer_srl,fd.location')
                        ->select('bm.billing_nm,bm.bidder_type,bm.email_id,bm.name')
                        ->select('bm.addr,bm.state_code,bm.pin,bm.pan_no,gst_no')
                        ->where('fd.auc_status','P')
                        ->where('bm.email_id is NOT NULL', NULL, FALSE)
						->from('final_auction_dtl fd')
						->join('bidder_mas bm','fd.bidder_id=bm.bidder_id','LEFT')
						->group_by('fd.auc_id,fd.bidder_id')
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
    public function show_item($auc_id,$bidder_id)
	{

		$query=$this->db->select('lot_no,garden_nm,grade,invoice_no,msp,bid_price')
                        ->select('gp_date,chest,net,pkgs,valu_kg,base_price')
                        ->from('final_auction_dtl')
						->where('auc_status','P')
                        ->where(array('auc_id'=>$auc_id,'bidder_id'=>$bidder_id))
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
	
	public function update_data($data,$auc_id,$bidder_id)
	{
		return $this->db->where(array('auc_id'=>$auc_id,'bidder_id'=>$bidder_id))
                        ->update('final_auction_dtl', $data);
	}
	
}
?>