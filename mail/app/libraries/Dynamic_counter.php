<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * @package     Dynamic Counter
 * @author      Surajit Mondal
 * @copyright           Copyright (c) 2017, Infotech Systems.
 * @license     
 * @link        http://www.infotechsystems.in
 * @since       Version 1.0
 * @filesource
 */
 class Dynamic_counter
 {
	 private $ci;
	    function __construct()
		{
			$this->ci =& get_instance();    
		}
	 public function build_no()
	 {
		 $query=$this->ci->db->get('hit_counter');
		// echo $this->ci->db->last_query();    
		 if ($query->num_rows() > 0)
        {
			foreach ($query->result() as $row)
            {
				$menu[$row->id]['counter_no']            = $row->id;
			}
		}

			
			foreach ($query->result() as $count)
			{
				$html_out= str_pad($count->counter_no,5,"0",STR_PAD_LEFT); 
			}
        
        return $html_out;
    }  
 }
 ?>