<?php
Class Notices extends SM_Model
{
	
	public function Offers($auc_id)
	{

		$query=$this->db->select('auc_start_time,auc_end_time,offer_srl')
                         ->where('md5(auc_id)',$auc_id)
                      // ->where('auc_id',$auc_id)
						->from('auction_mas')
		 				->get();
                      //   echo $this->db->last_query();
		if($query->num_rows())
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
	}
	public function allmails()
	{
        $ids=array('3','15','16');

		$query=$this->db->select('name,email_id')
                        ->where('status','A')
                        ->where('email_id is NOT NULL', NULL, FALSE)
                       // ->where_in('bidder_id',$ids)
						->from('bidder_mas')
						->group_by('email_id')
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
   
	
}
?>