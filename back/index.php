  <?php 
  include("../inc/dblib.inc.php");
try{
    $motp=1234;
    $template='1707161053976933841';
    $message="Your, one-time passcode (OTP) is $motp. AYCL";
   // $message="Your, one-time passcode (OTP) is $motp. AYCL";
   /*$template='1707170609007653722';
    $message="Dear Sir/Ma'am, Thank you for registering yourself as a vendor/agent on the AYCL Private Sale Portal. We value your business and look forward to having a fruitful relationship with you. Regards, AYCL Marketing Team Andrew Yule & Company Limited, Kolkata";*/
   // $ss=send_sms('9051530165',$message,$template);
    print_r($ss);
   
    $uid='14';
    file_get_contents('https://privatesale.andrewyule.in/mail/register/mailsend/'.$uid);
}
catch(Exception $e)
{
    echo $e->getMessage();
}
    ?>