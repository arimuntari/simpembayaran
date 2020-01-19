<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$kelas = $_REQUEST['kelas'];

$link = "index.php?option=$option&act=add";
if(empty($kelas)){
	echo "<script>alert('Anda Belum Memasukkan KELAS!!');document.location = '".$link."';</script>";
}else{
	$sql = "insert into $table (kelas) values ('$kelas')";
	$insert = mysqli_query($con, $sql);
	if($insert){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>