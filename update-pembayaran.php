<?php 
include "global/config.php";
include "global/function.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$nama_pembayaran = $_REQUEST['nama_pembayaran'];
$harga = $_REQUEST['harga'];
$tipe = $_REQUEST['tipe'];
$angsuran = $_POST['angsuran'];
$jumlah_angsuran = $_REQUEST['jumlah_angsuran'];
$id_tingkat = $_POST['id_tingkat'];
$id_jurusan = $_POST['id_jurusan'];
$id_kelas = $_POST['id_kelas'];

$link = "index.php?option=$option&act=edit&id=$id";
if(empty($nama_pembayaran)){
	echo "<script>alert('Anda Belum Memasukkan NAMA PEMBAYARAN!!');document.location = '".$link."';</script>";
}elseif(empty($harga)){
	echo "<script>alert('Anda Belum Memasukkan HARGA!!');document.location = '".$link."';</script>";
}elseif($tipe==''){
	echo "<script>alert('Anda Belum Memilih TIPE!!');document.location = '".$link."';</script>";
}elseif($id_tingkat==''){
	echo "<script>alert('Anda Belum Memilih TINGKAT!!');document.location = '".$link."';</script>";
}elseif($id_jurusan==''){
	echo "<script>alert('Anda Belum Memilih JURUSAN!!');document.location = '".$link."';</script>";
}else{
	$sql = "update $table set nama_pembayaran = '$nama_pembayaran', harga='$harga', tipe='$tipe', jumlah_angsuran='$jumlah_angsuran' where id='$id'";
	$insert = mysqli_query($con, $sql);
	if($insert){
		$id_pembayaran =$id;
		mysqli_query($con, "delete from ms_pembayaran_tingkat where id_pembayaran = '$id_pembayaran'");
		if($id_tingkat != 0){
			$sql = mysqli_query($con, "insert into ms_pembayaran_tingkat(id_pembayaran, id_tingkat) values ('$id_pembayaran', '$id_tingkat')");
		}else{
			$sql = mysqli_query($con, "insert into ms_pembayaran_tingkat(id_pembayaran, id_tingkat)
										select '$id_pembayaran', id from ms_tingkat");
		}

		mysqli_query($con, "delete from ms_pembayaran_jurusan where id_pembayaran = '$id_pembayaran'");
		if($id_jurusan !=0 ){
			$sql = mysqli_query($con, "insert into ms_pembayaran_jurusan(id_pembayaran, id_jurusan) values ('$id_pembayaran', '$id_jurusan')");
		}else{
			$sql = mysqli_query($con, "insert into ms_pembayaran_jurusan(id_pembayaran, id_jurusan)
										select '$id_pembayaran', id from ms_jurusan");
		}
		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}
?>