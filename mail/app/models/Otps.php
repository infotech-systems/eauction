<?php
Class Otps extends SM_Model
{
	
	public function show($otp_id)
	{

		$query=$this->db->select('email_id,otp')
						->where('otp_id',$otp_id)
						->from('reg_otp_mas')
		 				->get();
		 if($query->num_rows())
		 {
		 	return $query->row();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	public function usershow($uid)
	{

		$query=$this->db->select('user_id,user_name')
						->where('uid',$uid)
						->from('user_mas')
		 				->get();
		 if($query->num_rows())
		 {
		 	return $query->row();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
}
?>