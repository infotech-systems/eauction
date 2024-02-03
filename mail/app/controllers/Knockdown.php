<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Knockdown extends SM_Controller
{
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('knockdowns');
    }
    public function index()
    {}
    public function send()
    {
        $pending=$this->knockdowns->pending_mail();
        if($pending)
        {
            foreach($pending as $pend)
            {
                
                $items=$this->knockdowns->show_item($pend['auc_id'],$pend['bidder_id']);
                if($items)
                {
                    $data['offersheet']=$pend;
                    $data['items']=$items;
                    $message=$this->load->view('letter',$data,true);
                  //  $message=$this->load->view('letter',$data);
                    $this->load->library('email'); // Note: no $config param needed
                    $this->email->from('admin@andrewyule.in', 'Private Sale');
                    $this->email->to($pend['email_id']);
                    $this->email->subject('Offersheet No: '.$pend['offer_srl']);
                    $this->email->message($message);
                    $res_email=$this->email->send();
                    if($res_email==true):
                      $data=array(
                        'auc_status'=>'M'
                      );
                    $res = $this->knockdowns->update_data($data,$pend['auc_id'],$pend['bidder_id']);	
                    endif;
                }
            }
        }
	}

}
?>
