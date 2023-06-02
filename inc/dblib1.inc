<?php
error_reporting(0);
 $DBLink;
 $DBName;

 function OpenDB()
  {

   global $DBLink;
   $DBLink = mysqli_connect("localhost", "root", "", "eskay");

   if (!$DBLink) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
   }

//echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
//echo "Host information: " . mysqli_get_host_info($DBLink) . PHP_EOL;
}


 function execSelect($sql)
  {
  global $DBLink;
  $ret=mysqli_query($DBLink,$sql)
   or die(mysqli_errno().":".mysqli_error());
  return $ret;
  }

 function execUpdate($sql)
  {
  global $DBLink;
  $ret=mysqli_query($DBLink,$sql)
   or die(mysqli_errno().":".mysqli_error());
  return $ret;
  }

 function execDelete($sql)
  {
  global $DBLink;
  $ret=mysqli_query($DBLink,$sql)
   or die(mysqli_errno().":".mysqli_error());
  return $ret;
  }

 function execInsert($sql)
  {
  global $DBLink;
  $ret=mysqli_query($DBLink,$sql)
   or die(mysqli_errno().":".mysqli_error());
  return $ret;
  }


 function getRows($result)
  {
  global $DBLink;
  return mysqli_fetch_array($result);

  }

 function rowCount($result)
  {
  global $DBLink;
  $ret=mysqli_num_rows($result);
  //or die(mysqli_error()."<br>Error SQL ==>>$sql");
  return $ret;
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
    list($year, $month, $day) = explode('-', $date);
    $day = strlen($day) < 2 ? "0".$day : $day ;
    $month = strlen($month) < 2 ? "0".$month : $month ;
    $date = $day . "/" . $month . "/" . $year ;
    return $date ;
	
 }

 function CloseDB()
  {
  global $DBLink;
  mysqli_close($DBLink);
  }

?>
