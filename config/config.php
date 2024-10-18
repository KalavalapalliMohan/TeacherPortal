<?php
error_reporting(E_ERROR || E_WARNING);
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$database = "teacherportal";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
  
mysqli_select_db($conn, $database) or die(mysqli_error($conn));
  if(!$conn) {
    echo 'Connected failure<br>';
  } else {
    // echo 'Connected successfully<br>';
  }
//   date_default_timezone_set('Asia/Kolkata');
//   session_start();
//   $datetime = date('Y-m-d H:i:s');
?>