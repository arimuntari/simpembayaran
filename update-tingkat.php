<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$tingkat = $_REQUEST['tingkat'];

$link = "index.php?option=$option&act=edit&id=$id";
if(empty($tingkat)){
	echo "<script>alert('Anda Belum Memasukkan TINGKAT!!');document.location = '".$link."';</script>";
}else{
	$sql = "update $table set tingkat='$tingkat' where id='$id'";
	$update = mysqli_query($con, $sql);
	if($update){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>