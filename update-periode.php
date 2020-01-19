<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$nama_periode = $_REQUEST['nama_periode'];
$thn_mulai = $_REQUEST['thn_mulai'];
$thn_selesai = $_REQUEST['thn_selesai'];

$link = "index.php?option=$option&act=edit&id=$id";
if(empty($nama_periode)){
	echo "<script>alert('Anda Belum Memasukkan NAMA PERIODE!!');document.location = '".$link."';</script>";
}else if(empty($thn_mulai)){
	echo "<script>alert('Anda Belum Memasukkan TAHUN MULAI!!');document.location = '".$link."';</script>";
}else if(empty($thn_selesai)){
	echo "<script>alert('Anda Belum Memasukkan TAHUN SELESAI!!');document.location = '".$link."';</script>";
}else{
	$sql = "update $table set nama_periode='$nama_periode', thn_mulai='$thn_mulai', thn_selesai='$thn_selesai' where id='$id'";
	$update = mysqli_query($con, $sql);
	if($update){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>