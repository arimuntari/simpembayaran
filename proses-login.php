<?php 
session_start();
include "global/config.php";
$username = mysqli_escape_string($con, $_REQUEST['username']);
$password = mysqli_escape_string($con, $_REQUEST['password']);

if(empty($username)){
	echo "<script>alert('Anda Belum Memasukkan USERNAME!!');document.location = 'login.php';</script>";
}else if(empty($password)){
	echo "<script>alert('Anda Belum Memasukkan PASSWORD!!');document.location = 'login.php';</script>";
}else{
	//echo "select * from usermanager where username = '$username' and password = '$password'";
	$query = mysqli_query($con, "select * from usermanager where username = '$username' and password = '$password' and aktif='1'");
	$jml = mysqli_num_rows($query);
	$row = mysqli_fetch_array($query);
	if($jml > 0){
		$_SESSION['ses_id'] 	  = $row['id'];
		$_SESSION['ses_username'] = $row['username'];
		$_SESSION['ses_password'] = $row['password'];
		$_SESSION['ses_nama'] 	  = $row['nama'];
		$update = mysqli_query("update usermanager set terakhir_login = now() where id='".$row['id']."'");
		header('Location: index.php');
	}else{
		echo "<script>alert('Username dan Password Tidak Ditemukan!!');document.location = 'login.php';</script>";
	} 
}

?>