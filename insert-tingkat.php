<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$tingkat = $_REQUEST['tingkat'];

$link = "index.php?option=$option&act=add";
if(empty($tingkat)){
	echo "<script>alert('Anda Belum Memasukkan TINGKAT!!');document.location = '".$link."';</script>";
}else{
	$sql = "insert into $table (tingkat) values ('$tingkat')";
	$insert = mysqli_query($con, $sql);
	if($insert){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>