<?php 
include "global/config.php";
include "global/function.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];

$nisn = $_REQUEST['nisn'];
$nama = $_REQUEST['nama'];
$alamat = $_REQUEST['alamat'];
$tmp_lahir = $_REQUEST['tmp_lahir'];
$tgl_lahir = $_REQUEST['tgl_lahir'];
$no_telp = $_REQUEST['no_telp'];
$id_tingkat = $_POST['id_tingkat'];
$id_jurusan = $_POST['id_jurusan'];
$id_kelas = $_POST['id_kelas'];
$id_periode = periodeAktif($con);

$link = "index.php?option=$option&act=add";
if(empty($nisn)){
	echo "<script>alert('Anda Belum Memasukkan NISN!!');document.location = '".$link."';</script>";
}elseif(empty($nama)){
	echo "<script>alert('Anda Belum Memasukkan NAMA!!');document.location = '".$link."';</script>";
}elseif(empty($id_tingkat)){
	echo "<script>alert('Anda Belum Memilih TINGKAT!!');document.location = '".$link."';</script>";
}elseif(empty($id_jurusan)){
	echo "<script>alert('Anda Belum Memilih JURUSAN!!');document.location = '".$link."';</script>";
}elseif(empty($id_kelas)){
	echo "<script>alert('Anda Belum Memilih KELAS!!');document.location = '".$link."';</script>";
}else{
	$nisn = kodeSiswa($id_jurusan, $con);
	$sql = "insert into $table (nisn, nama, alamat, tmp_lahir, tgl_lahir, no_telp, tgl_input, periode_masuk)
							 values ('$nisn','$nama','$alamat','$tmp_lahir','".tglConvert($tgl_lahir, '/','-')."','$no_telp', now(), '$id_periode')";
	$insert = mysqli_query($con, $sql);
	if($insert){
			$id_siswa = mysqli_insert_id($con);
			$sqlkelas = "insert into ms_siswa_kelas (id_siswa,  id_tingkat, id_jurusan, id_kelas, id_periode)
							 values ('$id_siswa','$id_tingkat','$id_jurusan', '$id_kelas','$id_periode')";
			$insertkelas = mysqli_query($con, $sqlkelas);

		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Tambah Data Gagal!!');document.location = '".$link."';</script>";
	} 
}
?>