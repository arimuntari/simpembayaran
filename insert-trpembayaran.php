<?php
session_start();
include "global/config.php";
include "global/function.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$kode_pembayaran = kodePembayaran($con);
$id_siswa = $_REQUEST['id_siswa'];
$tgl = tglConvert($_REQUEST['tgl'], '/');
$listdata = $_SESSION['data_pembayaran'];
$total = $_REQUEST['total'];
$bulan = "";
$link = "index.php?option=$option&act=add";
if(empty($id_siswa)){
	echo "<script>alert('Anda Belum Memasukkan SISWA!!');document.location = '".$link."';</script>";
}elseif(empty($listdata)){
	echo "<script>alert('Anda Belum Memasukkan PEMBAYARAN!!');document.location = '".$link."';</script>";
}else{
	$insert = mysqli_query($con, "insert into $table (kode_pembayaran, id_siswa, tgl_pembayaran, total, id_usermanager) values ('$kode_pembayaran','$id_siswa','$tgl','$total', '".$_SESSION['ses_id']."')");

	if($insert){
		$id_trpembayaran = mysqli_insert_id($con);
		foreach($listdata as $key => $data){
			$sql = mysqli_query($con, "select * from ms_pembayaran where id='".$data."'");
			$row = mysqli_fetch_array($sql);
			if($row['tipe']==1){
				$bulan =   cekBulanBayar($id_siswa, $row['id'], $con);
			}
			mysqli_query($con,  "insert into tr_pembayaran_detil (id_trpembayaran, id_pembayaran, harga, bulan) values ('$id_trpembayaran', '".$row['id']."','".$row['harga']."', '$bulan')");
		}
		unset($_SESSION['data_pembayaran']);
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	}
}
?>