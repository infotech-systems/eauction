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

}
?>