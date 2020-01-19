<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$nama_jurusan = $_REQUEST['nama_jurusan'];
$singkatan = $_REQUEST['singkatan'];

$link = "index.php?option=$option&act=edit&id=$id";
if(empty($nama_jurusan)){
	echo "<script>alert('Anda Belum Memasukkan NAMA JURUSAN!!');document.location = '".$link."';</script>";
}else{
	$sql = "update $table set nama_jurusan='$nama_jurusan', singkatan='$singkatan' where id='$id'";
	$update = mysqli_query($con, $sql);
	if($update){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>