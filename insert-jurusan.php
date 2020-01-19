<?php 
include "global/config.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$nama_jurusan = $_REQUEST['nama_jurusan'];
$singkatan = $_REQUEST['singkatan'];

$link = "index.php?option=$option&act=add";
if(empty($nama_jurusan)){
	echo "<script>alert('Anda Belum Memasukkan NAMA JURUSAN!!');document.location = '".$link."';</script>";
}elseif(empty($nama_jurusan)){
	echo "<script>alert('Anda Belum Memasukkan NAMA SINGKATAN!!');document.location = '".$link."';</script>";
}else{
	$sql = "insert into $table (nama_jurusan, singkatan) values ('$nama_jurusan','$singkatan')";
	$insert = mysqli_query($con, $sql);
	if($insert){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	} 
}

?>