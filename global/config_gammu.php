<?php
error_reporting(E_ALL ^ E_NOTICE);

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "db_gammu";

$con = mysqli_connect($host,$user,$pass, $db_name);


date_default_timezone_set("Asia/Jakarta");

?>