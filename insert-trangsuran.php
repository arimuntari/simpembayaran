<?php
session_start();
include "global/config.php";
include "global/function.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$id_siswa = $_REQUEST['id_siswa'];
$id_pembayaran = $_REQUEST['id_pembayaran'];
$tgl = tglConvert($_REQUEST['tgl'], '/');
$bayar = $_REQUEST['bayar'];
$angsuran_sekarang = $_REQUEST['angsuran_sekarang'];
$total = $_REQUEST['total'];

$link = "index.php?option=$option&act=add";
if(empty($id_siswa)){
	echo "<script>alert('Anda Belum Memasukkan SISWA!!');document.location = '".$link."';</script>";
}elseif(empty($id_pembayaran)){
	echo "<script>alert('Anda Belum MEMiLIH PEMBAYARAN!!');document.location = '".$link."';</script>";
}else{
	$sisa_bayar = $angsuran_sekarang-$bayar;
	$insert = mysqli_query($con, "insert into $table ( id_siswa, id_pembayaran, tgl_pembayaran_angsuran, bayar ) values ('$id_siswa','$id_pembayaran','$tgl','$bayar')");
	if($insert){
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	}
}
?>