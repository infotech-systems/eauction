<?php
Class Challans extends SM_Model
{
	
	public function show($chl_id)
	{

		$query=$this->db->select('*,c.orgn_id')
						->where('c.chl_id',$chl_id)
						->from('chl_mas c')
						->join('user_mas u','c.uid=u.uid','LEFT')
						->join('cutomer_mas cm','c.cust_id=cm.cust_id','LEFT')
						->join('state_mas sm','sm.state_code=cm.state_id','LEFT')
						->where('c.chl_id',$chl_id)
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
	public function show_orgn($id)
	{
		  $query= $this -> db ->where('o.orgn_id', $id)
		 					 ->from('orgn_mas o')
							  ->join('state_mas sm','sm.state_code=o.state_code','LEFT')
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
	public function show_driver($id)
	{
		  $query= $this -> db ->where('emp_id', $id)
		                      ->get('emp_mas');         
		                    
		 if($query->num_rows())
		 {
		 	return $query->row();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	public function show_rental($id)
	{
		  $query= $this -> db ->where('rental_type_id', $id)
		                      ->get('rental_type_mas');         
		  //  echo $this->db->last_query();                
		 if($query->num_rows())
		 {
		 	return $query->row();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	public function show_proj($id)
	{
		  $query= $this -> db ->where('proj_id', $id)
		                      ->get('project_mas');         
		//    echo $this->db->last_query();                
		 if($query->num_rows())
		 {
		 	return $query->row();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	

	public function show_items($chl_no)
	{
		$query=$this->db->select('id.chld_id,iv.model,iv.item_desc,iv.item_rate,iv.item_cat_desc,iv.mfg_nm')
						->select('sum(id.item_qty) as item_qty,iv.item_id')
		 				->from('chl_dtl id')
						->join('item_view iv','id.item_id=iv.item_id','LEFT')
						->where('id.chl_no',$chl_no) 
						->group_by('id.item_id')
						->order_by('id.chld_id')
		 				->get();
		 
		 if($query->row())
		 {
		 	return $query->result_array();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	public function show_acces($chl_no,$item_id)
	{
		$query=$this->db->select('sum(id.item_qty) as item_qty ,ie.acc_desc')
		 				->from('chl_acc_dtl id')
						->join('item_acc_mas ie','id.acc_id=ie.acc_id','LEFT')
						->where('id.chl_no',$chl_no) 
						->where('id.item_id',$item_id) 
						->where('ie.item_id',$item_id) 
						->group_by('id.item_id,id.acc_id')
						->order_by('ie.acc_id')
		 				->get();
		// echo $this->db->last_query();
		 if($query->row())
		 {
		 	return $query->result_array();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	public function show_support($id)
	{
		$ids=explode(',',$id);
		$query=$this->db->where_in('emp_id', $ids)
						->select('GROUP_CONCAT(emp_nm) as support_staff')
		                ->get('emp_mas');         
		//    echo $this->db->last_query();                
		 if($query->num_rows())
		 {
		 	return $query->row();
		 }
		 else
		 {
		 	return FALSE;
		 }
	}
	public function update_data($data,$hid)
	{
		return $this->db->where('chl_id', $hid)
                        ->update('chl_mas', $data);
	}
	
}
?>