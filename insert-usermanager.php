<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$nama = $_REQUEST['nama'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$link = "index.php?option=$option&act=add";
if(empty($nama)){
	echo "<script>alert('Anda Belum Memasukkan NAMA!!');document.location = '".$link."';</script>";
}else if(empty($username)){
	echo "<script>alert('Anda Belum Memasukkan USERNAME!!');document.location = '".$link."';</script>";
}else if(empty($password)){
	echo "<script>alert('Anda Belum Memasukkan PASSWORD!!');document.location = '".$link."';</script>";
}else{
	$sql = "insert into $table (nama, username, password) values ('$nama','$username', '$password')";
	$insert = mysqli_query($con, $sql);
	if($insert){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>