<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$nama = $_REQUEST['nama'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$link = "index.php?option=$option&act=edit&id=$id";

if(empty($nama)){
	echo "<script>alert('Anda Belum Memasukkan NAMA!!');document.location = '".$link."';</script>";
}else if(empty($username)){
	echo "<script>alert('Anda Belum Memasukkan USERNAME!!');document.location = '".$link."';</script>";
}else if(empty($password)){
	echo "<script>alert('Anda Belum Memasukkan PASSWORD!!');document.location = '".$link."';</script>";
}else{
	$sql = "update $table set nama='$nama', username='$username', password='$password' where id='$id'";
	$update = mysqli_query($con, $sql);
	if($update){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}
?>