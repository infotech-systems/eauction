<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * @package     Dynamic Menu
 * @author      Surajit Mondal
 * @copyright           Copyright (c) 2017, Infotech Systems.
 * @license     
 * @link        http://www.infotechsystems.in
 * @since       Version 1.0
 * @filesource
 */
 class Dynamic_menu
 {
	 private $ci;
	    function __construct()
		{
			$this->ci =& get_instance();    
		}
	 public function build_menu($cur_id)
	 {
		 $page_per=explode(',',$this->ci->session->userdata('page_per'));
		 $type=$this->ci->session->userdata('user_type');
		 $this->ci->db->where(array('dyn_group_id'=>'2'));
		 if($type!='A')
		 {
			
			if($type=='M')
			{
			$this->ci->db->where_in('p_type','M');	
			}else{
			$this->ci->db->where_in('id',$page_per);	
			}	
		 }else{
			$this->ci->db->where_in('p_type','W');	 
		 }
		 $this->ci->db->order_by('position');
		 $query=$this->ci->db->get('dyn_menu');
		// echo $this->ci->db->last_query();    
		 if ($query->num_rows() > 0)
        {
			foreach ($query->result() as $row)
            {
				$menu[$row->id]['id']            = $row->id;
				$menu[$row->id]['title']        = $row->title;
				$menu[$row->id]['page']            = $row->page_id;
				$menu[$row->id]['url']            = $row->url;
				$menu[$row->id]['uri']            = $row->uri;
				$menu[$row->id]['dyn_group']    = $row->dyn_group_id;
				$menu[$row->id]['position']        = $row->position;
				$menu[$row->id]['target']        = $row->target;
				$menu[$row->id]['parent']        = $row->parent_id;
				$menu[$row->id]['is_parent']    = $row->is_parent;
				$menu[$row->id]['show']            = $row->show_menu;
			}
		}

			$query->free_result();    
			$html_out = "\t".'<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">'."\n";
			$menu_array=  $query->result();  
			foreach ($query->result() as $menu3)
			{
			//	print_r($menu_array);
				if (is_array($menu_array))    
				{
						if ($menu3->show_menu && $menu3->parent_id == 0)
						{
							if ($menu3->is_parent == TRUE)
							{
								if ($menu3->id == $cur_id)
								{
									 $html_out .= "\t\t".'<li class="nav-item has-treeview menu-open"><a href="#" class="nav-link  active"><i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'<i class="fa fa-angle-left right"></i></p></a>';
								}
								else
								{
									 $html_out .= "\t\t".'<li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'<i class="fa fa-angle-left right"></i></p></a>';
	
								}
								$parent_id=$menu3->id;
								$html_out .= $this->get_childs($menu_array,$parent_id);
							}
							else
							{
								if ($menu3->id == $cur_id)
								{
									 $html_out .= "\t\t\t".'<li class="nav-item menu-open">'.anchor($menu3->url, '<i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'</p>',array('class'=>'nav-link active'));
								}
								else
								{
									$html_out .= "\t\t\t".'<li class="nav-item">'.anchor($menu3->url, '<i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'</p>',array('class'=>'nav-link'));
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
	function get_childs($menu_array,$parent_id)
    {
		$has_subcats = FALSE;
        $html_out  = '';
        $html_out .= "\t\t\t\t".'<ul class="nav nav-treeview">'."\n";
        
       foreach ($menu_array as $menu3)
        {
			if ($menu3->show_menu && $menu3->parent_id == $parent_id)    // are we allowed to see this menu?
			{
				$has_subcats = TRUE;
				if ($menu3->is_parent == TRUE)
				{
					$html_out .= "\t\t\t\t\t".'<li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'</p>
					 <i class="fa fa-angle-left pull-right"></i></a>';
				}
				else
				{
					$html_out .= "\t\t\t\t\t".'<li class="nav-item">'.anchor($menu3->url, '<i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'</p>',array('class'=>'nav-link'));
				}
				$parent_id_2=$menu3->id;
			    $html_out .= $this->get_childs_2($menu_array,$parent_id_2);
				$html_out .= '</li>' . "\n";
			}
        }
        $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
        return ($has_subcats) ? $html_out : FALSE;
    }
	function get_childs_2($menu_array,$parent_id_2)
    {
		$page_per=explode(',',$this->ci->session->userdata('page_per'));
        $has_subcats = FALSE;
        $html_out  = '';
        $html_out .= "\t\t\t\t\t".'<ul class="nav nav-treeview">'."\n";
       foreach ($menu_array as $menu3)
        {
			if ($menu3->show_menu && $menu3->parent_id == $parent_id_2)    // are we allowed to see this menu?
			{
				$has_subcats = TRUE;

				if ($menu3->is_parent == TRUE)
				{
					$html_out .= "\t\t\t\t\t".'<li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'</p>
					 <i class="fa fa-angle-left pull-right"></i></a>';
				}
				else
				{
					$html_out .= "\t\t\t\t\t".'<li class="nav-item">'.anchor($menu3->url, '<i class="nav-icon '.$menu3->uri.'"></i><p>'.$menu3->title.'</p>',array('class'=>'nav-link'));
				}
				$parent_id_3=$menu3->id;
			    $html_out .= $this->get_childs_3($menu_array,$parent_id_3,$page_per);
				$html_out .= '</li>' . "\n";
			}
        }
        $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
        return ($has_subcats) ? $html_out : FALSE;
    }
	function get_childs_3($menu_array,$parent_id_3)
    {
		$page_per=explode(',',$this->ci->session->userdata('page_per'));
        $has_subcats = FALSE;
        $html_out  = '';
        $html_out .= "\t\t\t\t".'<ul class="treeview-menu">'."\n";
        
       foreach ($menu_array as $menu3)
        {
			if ($menu3->show_menu && $menu3->parent_id == $parent_id_3)    // are we allowed to see this menu?
			{
				$has_subcats = TRUE;

				if ($menu3->is_parent == TRUE)
				{
					$html_out .= "\t\t\t\t\t".'<li class="treeview"><a href="#"><i class="'.$menu3->uri.'"></i><span>'.$menu3->title.'</span>
					 <i class="fa fa-angle-left pull-right"></i></a>';
				}
				else
				{
					$html_out .= "\t\t\t\t\t\t".'<li>'.anchor($menu3->url, '<i class="'.$menu3->uri.'"></i><span>'.$menu3->title.'</span>');
				}
				$parent_id_2=$menu3->id;
				//echo $parent_id;
			 //   $html_out .= $this->get_childs_3($menu_array,$parent_id_2,$page_per);
				$html_out .= '</li>' . "\n";
			}
        }
        $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
        return ($has_subcats) ? $html_out : FALSE;
    }
 }
 ?>
