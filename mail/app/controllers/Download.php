<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller
{
    function __construct()
     {

       parent::__construct();
       $this->load->helper('directory');
       $this->load->helper('file');
       $this->load->library('zip');
       $this->load->helper('download');
      
       ini_set('memory_limit', '-1');
       ini_set('max_execution_time', 3000);
     }
    public function index()
    {
        $DBUSER=$this->db->username;
        $DBPASSWD=$this->db->password;
        $DATABASE=$this->db->database;
    
        $filename = $DATABASE . "-" . date("D") . ".sql";
    
        $this->load->dbutil();
        $db_format=array('format'=>'zip','filename'=>$filename);
        $backup=$this->dbutil->backup($db_format);
        $dbname='backup-on-'.date('D').'.zip';
        $save='asset/backup/'.$dbname;
        write_file($save,$backup);
        force_download($dbname,$backup);
            
    }
    public function medias()
    {
          $this->zip->compression_level = 0;
          $this->zip->read_dir('../uploads/');
          $this->zip->read_dir('../legal/');
          $medianame='source-backup-on-'.date('Y-m-d').'.zip';
          $this->zip->download($medianame);  
        
    }
 }
