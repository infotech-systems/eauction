<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends SM_Controller
{
	function __construct()
	 {
	   parent::__construct();
       $this->load->model('otps');
    }
    public function index()
    {}
	public function send($otp_id)
	{
       $otps=$this->otps->show($otp_id);

        $message='Your, one-time passcode (OTP) is '.$otps->otp.'. AYCL';
        $this->load->library('email'); // Note: no $config param needed
        $this->email->from('admin@andrewyule.in', 'Private Sale');
       // $this->email->cc($list);
        $this->email->to($otps->email_id);
        $this->email->subject('OTP Verification');
        $this->email->message($message);
        $res_email=$this->email->send();
    }

}
?>
