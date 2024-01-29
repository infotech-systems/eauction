  <?php 
  include("../inc/dblib.inc.php");

   $template='1707170609007653722';
    $message="Dear Sir/Ma'am, Thank you for registering yourself as a vendor/agent on the AYCL Private Sale Portal. We value your business and look forward to having a fruitful relationship with you. Regards, AYCL Marketing Team Andrew Yule & Company Limited, Kolkata";
   // $ss=send_sms('9051530165',$message,$template);
   // print_r($ss);
    $user_id='surajitinfotechsystems.in';
    $ss=file_get_contents('https://privatesale.andrewyule.in/mail/register/send2/'.$user_id);
    print_r($ss);
    ?>