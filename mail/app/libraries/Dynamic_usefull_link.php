<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**
 * CodeIgniter
 *
 * @package     Dynamic Page Menu
 * @author      Surajit Mondal
 * @copyright           Copyright (c) 2017, Infotech Systems.
 * @license     
 * @link        http://www.infotechsystems.in
 * @since       Version 1.0
 * @filesource
 */

 class Dynamic_usefull_link
 {
	 private $ci;

	    function __construct()
		{
			$this->ci =& get_instance();    // get a reference to CodeIgniter.
		}
	 public function build_page()
	 {
	 	$usefull = array();
		
		 $query=$this->ci->db->select('id,link_name,link,new_blink,target')
		                     ->where('show_tag','T')
							 ->order_by('srl')
		                     ->get('useful_link_mas');
				   
							 
		 if ($query->num_rows() > 0)
        {
			
			foreach ($query->result() as $row)
            {
				$usefull[$row->id]['id']         = $row->id;
				$usefull[$row->id]['link_name']       = $row->link_name;
				$usefull[$row->id]['link']       = $row->link;
				$usefull[$row->id]['new_blink']       = $row->new_blink;
				$usefull[$row->id]['target']       = $row->target;
			}
		}
		 $query->free_result();
		 $html_out = "";
		  $menu_array=  $query->result();  
		 foreach ($query->result() as $menu)
         {
			 $a ='';
			 if (is_array($menu_array))
             {
				 if($menu->link == '')
				 {
					 $id=$menu->id;
					 $usefull_link='usefull/dtls/'.md5($menu->id);
				 }
				 else
				 {
					 $usefull_link=$menu->link;
				 }
				
				 if($menu->target)
				 {
					  
				 	$html_out .= "\t\t\t".'<li>'.anchor($usefull_link, '<i class="fa fa-angle-double-right" aria-hidden="true"></i><span>'.$menu->link_name.'</span>',array('target'=>$menu->target));

					//  $html_out .= "\t".'<li>'.anchor($usefull_link,$a.$menu->link_name,array('target'=>$menu->target));
					 
				 }
				 else
				 {
					 $html_out .= "\t".'<li>'.anchor($usefull_link,$a.$menu->link_name);
				 }
				 
				
				  $html_out .='</li>'."\n";
			 }
		 }
		
        return $html_out;
    } 
	
	public function build_footer()
	 {
	 	$usefull = array();
		
		 $query=$this->ci->db->select('page_id,page_name,page_link,parent_id,show_tag')
		                     ->where('show_tag','T')
							 ->order_by('srl')
		                     ->get('page_master');
				   
							 
		 if ($query->num_rows() > 0)
        {
			
			foreach ($query->result() as $row)
            {
				$footer[$row->page_id]['page_id']         = $row->page_id;
				$footer[$row->page_id]['page_name']       = $row->page_name;
				$footer[$row->page_id]['page_link']       = $row->page_link;
				$footer[$row->page_id]['parent_id']       = $row->parent_id;
			}
		}
		 $query->free_result();
		 $html_out = "";
		  $menu_array=  $query->result();  
		 foreach ($query->result() as $menu)
         {
			 $a ='';
			 if (is_array($menu_array))
             {
				 if($menu->page_link == '')
				 {
					 $id=$menu->page_id;
					 $usefull_link='page/dtls/'.md5($menu->page_id);
				 }
				 else
				 {
					 $usefull_link=$menu->page_link;
				 }
				
					 $html_out .= "\t".'<li>'.anchor($usefull_link,$a.$menu->page_name);
				 
				
				  $html_out .='</li>'."\n";
			 }
		 }
		
        return $html_out;
    }  
 }
 
  
 
 ?>