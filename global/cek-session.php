<?php 
include "config.php";
$username = mysqli_escape_string($con, $_SESSION['ses_username']);
$password = mysqli_escape_string($con, $_SESSION['ses_password']);

$query = mysqli_query($con, "select * from usermanager where username = '$username' and password = '$password' and aktif='1'");
$jml = mysqli_num_rows($query);
$row = mysqli_fetch_array($query);
if($jml==0){
	echo "<script>alert('Anda Belum Login!!, Silahkan Login terlebih Dahulu!');document.location = 'login.php';</script>";
}
?>