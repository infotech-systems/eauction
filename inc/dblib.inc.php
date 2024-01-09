<?php
 function OpenDB()
  {
   $DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
   $DBUser   = 'root';
   $DBPass   = '';
   $DBName   = 'eauction';
   $DBLink = new PDO('mysql:host='.$DBServer.';dbname='.$DBName, $DBUser, $DBPass, 
  array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  ));
   $DBLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
   return $DBLink;
  }

  function british_to_ansi($date)
  {
     list($day, $month, $year) = explode('/', $date);
     $day = strlen($day) < 2 ? "0".$day : $day ;
     $month = strlen($month) < 2 ? "0".$month : $month ;
     $date = $year . "-" . $month . "-" . $day ;
     return $date ;
  }
 
 
  function ansi_to_british($date)
  {
     list($year,$month,$day) = explode('-', $date);
     $day = strlen($day) < 2 ? "0".$day : $day ;
     $month = strlen($month) < 2 ? "0".$month : $month ;
     $date = $day."/".$month."/".$year ;
     return $date ;
  }  
  function generateRandomString($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
 function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

define("OTPSMS",     "1707161053976933841");
define("FILEGENSMS",     "1707161045016977857");

function send_sms($cell_no,$message,$template)
{
 /* $ch = curl_init();
  $msg= urlencode($message);

  curl_setopt($ch,CURLOPT_URL, "https://msg.myctrlbox.com/API/WebSMS/Http/v2.3.6/api.php?username=ANDREWT&api_key=eabccca3ad651591d0257de60adcf446&sender=AYCLHO&dlt_template=$template&dlt_principal=1701159360046571327&to=$cell_no&message=$msg");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, 0);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;*/
}

function fileCkecking($file,$idx)
{
$msg=array();
$error=array();
$msg['invalid']='';
$allowedExtensions = array("jpg","jpeg","gif","png","doc","docx","xls","xlsx","pdf","odt","ods");
//	print_r($FILES);
$remove_file =null; 
  if(!empty($file['name'][$idx]))
  {
  $bas_dir="../uploads/";
        $name_of_file = basename($file['name'][$idx]);
        $path_of_uploaded_file=$bas_dir.$name_of_file;
        $tmp_path = $file["tmp_name"][$idx];

    if ($file['tmp_name'][$idx] > '') {
      $file_name=explode(".",strtolower($file['name'][$idx]));

      $ddd=end($file_name);
    //  echo  $file_name;
      if (!in_array($ddd,$allowedExtensions)) {
        $msg['invalid']='<font color="red" size="3">This <b>('.$file['name'][$idx].')</b> is an invalid file type</font>';
        $error['errorfile']="Error";
      }
      else
      {
           if(file_exists($path_of_uploaded_file))
             {
             $name_of_file = basename($file['name'][$idx]);
             $ren_file=explode(".",$name_of_file);
             $r_file=$ren_file[0].date('d-m-i-s').'.'.$ren_file[1];
             $path_of_uploaded_file=$bas_dir.$r_file;

             $remove_file["$idx"]=$r_file;
             copy($tmp_path,$path_of_uploaded_file);
             }
             else
             {
              $remove_file["$idx"]=$file['name'][$idx];
              copy($tmp_path,$path_of_uploaded_file);
             }
      }
    }
  }
   echo $msg['invalid'];   
  return $remove_file["$idx"];
 
}

function fileCkecking_mail($file,$idx)
{
$msg=array();
$error=array();
$msg['invalid']='';
$allowedExtensions = array("jpg","jpeg","gif","png","doc","docx","xls","xlsx","pdf","odt","ods");
//	print_r($FILES);
$remove_file =null; 
  if(!empty($file['name'][$idx]))
  {
  $bas_dir="../uploads/mail/";
        $name_of_file = basename($file['name'][$idx]);
        $path_of_uploaded_file=$bas_dir.$name_of_file;
        $tmp_path = $file["tmp_name"][$idx];

    if ($file['tmp_name'][$idx] > '') {
      $file_name=explode(".",strtolower($file['name'][$idx]));

      $ddd=end($file_name);
    //  echo  $file_name;
      if (!in_array($ddd,$allowedExtensions)) {
        $msg['invalid']='<font color="red" size="3">This <b>('.$file['name'][$idx].')</b> is an invalid file type</font>';
        $error['errorfile']="Error";
      }
      else
      {
           if(file_exists($path_of_uploaded_file))
             {
             $name_of_file = basename($file['name'][$idx]);
             $ren_file=explode(".",$name_of_file);
             $r_file=$ren_file[0].date('d-m-i-s').'.'.$ren_file[1];
             $path_of_uploaded_file=$bas_dir.$r_file;

             $remove_file["$idx"]=$r_file;
             copy($tmp_path,$path_of_uploaded_file);
             }
             else
             {
              $remove_file["$idx"]=$file['name'][$idx];
              copy($tmp_path,$path_of_uploaded_file);
             }
      }
    }
  }
   echo $msg['invalid'];   
  return $remove_file["$idx"];
 
}
function fileCkecking2($file,$idx)
{
$msg=array();
$error=array();
$msg['invalid']='';
$allowedExtensions = array("xls","xlsx");
//	print_r($FILES);
$remove_file =null; 
  if(!empty($file['name'][$idx]))
  {
  $bas_dir="./uploads/";
        $name_of_file = basename($file['name'][$idx]);
        $path_of_uploaded_file=$bas_dir.$name_of_file;
        $tmp_path = $file["tmp_name"][$idx];

    if ($file['tmp_name'][$idx] > '') {
      $file_name=explode(".",strtolower($file['name'][$idx]));

      $ddd=end($file_name);
    //  echo  $file_name;
      if (!in_array($ddd,$allowedExtensions)) {
        $msg['invalid']='<font color="red" size="3">This <b>('.$file['name'][$idx].')</b> is an invalid file type</font>';
        $error['errorfile']="Error";
      }
      else
      {
           if(file_exists($path_of_uploaded_file))
             {
             $name_of_file = basename($file['name'][$idx]);
             $ren_file=explode(".",$name_of_file);
             $r_file=$ren_file[0].date('d-m-i-s').'.'.$ren_file[1];
             $path_of_uploaded_file=$bas_dir.$r_file;

             $remove_file["$idx"]=$r_file;
             copy($tmp_path,$path_of_uploaded_file);
             }
             else
             {
              $remove_file["$idx"]=$file['name'][$idx];
              copy($tmp_path,$path_of_uploaded_file);
             }
      }
    }
  }
   echo $msg['invalid'];   
  return $remove_file["$idx"];
 
}
function compressImage($source, $destination, $quality) {

  $info = getimagesize($source);

  if ($info['mime'] == 'image/jpeg') 
    $image = imagecreatefromjpeg($source);

  elseif ($info['mime'] == 'image/gif') 
    $image = imagecreatefromgif($source);

  elseif ($info['mime'] == 'image/png') 
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);

}

?>
