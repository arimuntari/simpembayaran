<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$kelas = $_REQUEST['kelas'];

$link = "index.php?option=$option&act=edit&id=$id";
if(empty($kelas)){
	echo "<script>alert('Anda Belum Memasukkan KELAS!!');document.location = '".$link."';</script>";
}else{
	$sql = "update $table set kelas='$kelas' where id='$id'";
	$update = mysqli_query($con, $sql);
	if($update){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>