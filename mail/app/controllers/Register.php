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
    public function mailsend($uid,$password)
	{
        $otps=$this->otps->usershow($uid);

        $message="Dear Sir/Ma'am,<br> Thank you for registering yourself as a vendor/agent on the AYCL Private Sale Portal. We value your business and look forward to having a fruitful relationship with you. Your User Name is your registered <b><u>E-MAIL ID ($otps->user_id)</u></b> and password is <b><u> $password </u></b>. </br></br></br>Regards,<br><br>AYCL Marketing Team";
        $this->load->library('email'); // Note: no $config param needed
        $this->email->from('admin@andrewyule.in', 'Private Sale');
       // $this->email->cc($list);
        $this->email->to($otps->user_id,$otps->user_name);
        $this->email->subject('Register Confirmation');
        $this->email->message($message);
        $res_email=$this->email->send();
    }
}
?>
