<?php
error_reporting(E_ALL ^ E_NOTICE);
//setting Title
$tittle ="<b>SMK PGRI 13 Surabaya</b>";
$header ="Sistem Informasi Pembayaran | SMK PGRI 13 Surabaya";
$footer =" <strong>Copyright &copy; 2019 Informatika <a href='https://itats.ac.id'>ITATS</a>.</strong>";


$host = "localhost";
$user = "root";
$pass = "";
$db_name = "db_simbayar";

$con = mysqli_connect($host,$user,$pass, $db_name);


//setting database
//$con = koneksiDB();

date_default_timezone_set("Asia/Jakarta");

//define("URL", "localhost/unipa");
?>