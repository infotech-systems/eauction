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

class Dynamic_email
{
	private $ci;
	function __construct()
	{
        $this->ci =& get_instance();    // get a reference to CodeIgniter.
    }
	public function send_email($to_nm,$to_email,$subject,$content,$attachments)
	{
        ini_set("include_path", '/home/ebsfoundation/php:' . ini_get("include_path") );
        require_once "Mail.php";
        include('Mail/mime.php');

        $from = "EBS Foundation  <contact@ebsfoundation.in>";
        $to = "$to_nm <$to_email>";
        $bcc =" EBS <foundationebs@gmail.com>";
        $host = "ssl://blynx7.cloudhostdns.net";
        $port = "465";
        $username = "contact@ebsfoundation.in";
        $password = 'ocZ!$Zu96lIY';        
        $headers = array ('From' => $from,
        'To' => $to,
        'Content-Type'  => 'text/html; charset=UTF-8',
        'Subject' => $subject);   
        $recipients = $to.", ".$bcc;     
        $text = $content;
        $crlf = "\n";
        $mime = new Mail_mime($crlf);
        $mime->setHTMLBody($text);
        
        if(is_array($attachments)):
            foreach($attachments as $attachment):
                    $mime->addAttachment($attachment, 'text/plain');
            endforeach;
        endif;
    $body = $mime->get();
    $headers = $mime->headers($headers);
        $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));
        $mail = $smtp->send($recipients, $headers, $body);
        
        if (PEAR::isError($mail)) {
        echo("<p>" . $mail->getMessage() . "</p>");
       return false;
        } else {
            return true;
        }
    } 
 }
 
  
 
 ?>