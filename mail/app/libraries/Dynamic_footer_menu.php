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

 class Dynamic_footer_menu
 {
	 private $ci;

	    function __construct()
		{
			$this->ci =& get_instance();    // get a reference to CodeIgniter.
		}
	 public function build_footer_page($cur_id1=null,$cur_id2=null,$hmenu=2)
	 {
	 	$cur_id='';
	
	 	$page = array();
		if(!empty($cur_id2))
		{
		$cur_id=$cur_id2;
		}
		else
		{
			$query2=$this->ci->db->select('page_id')
		                     ->where('page_link',$cur_id1)
		                      ->get('page_master');
		 if($query2->num_rows())
		 {
			 $cur_id=$query2->row('page_id');
			 
		 }
		}
		
		 $query=$this->ci->db->select('page_id,page_name,page_link,parent_id,show_tag,is_parent,page_slug')
		                     ->where('show_tag','T')
							//  ->like('dyn_group_id',$hmenu)
							 ->order_by('srl asc')
		                   ->get('page_master');
				//print_r($query->result());	   
							 
		 if ($query->num_rows() > 0)
        {
			
			foreach ($query->result() as $row)
            {
				$page[$row->page_id]['page_id']         = $row->page_id;
				$page[$row->page_id]['page_name']       = $row->page_name;
				$page[$row->page_id]['page_link']       = $row->page_link;
				$page[$row->page_id]['parent_id']       = $row->parent_id;
				$page[$row->page_id]['is_parent']       = $row->is_parent;
				$page[$row->page_id]['page_slug']       = $row->page_slug;
			}
		}
		$query->free_result();    
			$html_out = "\t".'<ul>'."\n";
			$menu_array=  $query->result();  
			foreach ($query->result() as $menu3)
			{
			//	print_r($menu_array);
				if (is_array($menu_array))    
				{
						if ($menu3->parent_id == 0)
						{

							if ($menu3->is_parent == TRUE)
							{
								if($menu3->page_link == '')
								 {
									 $id=$menu3->page_id;
									 $page_link='page/dtls/'.$menu3->page_slug;
								 }
								 else
								 {
									 $page_link=$menu3->page_link;
								 }
								if ($menu3->page_id == $cur_id)
								{
									
									 $html_out .= "\t\t".'<li><a href="#">'.$menu3->page_name.'</a>';
								}
								else
								{
									 $html_out .= "\t\t".'<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$menu3->page_name.'</a>';
	
								}
								$parent_id=$menu3->page_id;
								$html_out .= $this->get_childs($menu_array,$parent_id);
							}
							else
							{
								if($menu3->page_link == '')
								 {
									 $id=$menu3->page_id;
									 $page_link='page/dtls/'.$menu3->page_slug;
								 }
								 else
								 {
									 $page_link=$menu3->page_link;
								 }
								if ($menu3->page_id == $cur_id)
								{
									 $html_out .= "\t\t\t".'<li class="menu-active">'.anchor($page_link, $menu3->page_name,array('class'=>'page-scroll'));
								}
								else
								{
									//$html_out.="<i class='fa fa-angle-double-right' aria-hidden='true'></i>";
				
									$html_out .= "\t\t\t".'<li>'.anchor($page_link, '<i class="fa fa-angle-double-right" aria-hidden="true"></i><span>'.$menu3->page_name.'</span>');
								}
							}

							$html_out .= '</li>'."\n";
						}
				}
				else
				{
					exit (sprintf('menu nr %s must be an array', $i));
				}
			}
        $html_out .= "\t".'</ul>' . "\n";
        return $html_out;
    }  	
	
 }
 
  
 
 ?>