<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sending_notice extends SM_Controller
{
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('notices');
	   $this->load->helper('datebritish');
    }
    public function index()
    {}
    public function send($offer)
    {
        $notice=$this->notices->Offers($offer);
        if($notice)
        {
            $start_date= datebritish($notice->auc_start_time);

            $start_time= substr($notice->auc_start_time,11,5);
            $end_date= datebritish($notice->auc_end_time);
            $end_time= substr($notice->auc_end_time,11,5);

            $allmails=$this->notices->allmails();
            if($allmails)
            {
                foreach($allmails as $am)
                {
                    $data['start_date']=$start_date;
                    $data['start_time']=$start_time;
                    $data['end_date']=$end_date;
                    $data['end_time']=$end_time;
                    $data['am']=$am;
                    $message=$this->load->view('notice',$data,true);
                    $this->load->library('email'); // Note: no $config param needed
                    $this->email->from('admin@andrewyule.in', 'Private Sale');
                    $this->email->to($am['email_id']);
                    $this->email->subject('Offersheet Email Notification');
                    $this->email->message($message);
                    $res_email=$this->email->send();
                }
            }
        }
	}

}
?>
