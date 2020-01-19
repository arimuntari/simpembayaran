<?php 
include "global/config.php";
include "global/function.php";
$table = $_REQUEST['table'];
$option = $_REQUEST['option'];
$id = $_REQUEST['id'];

$nisn = $_REQUEST['nisn'];
$nama = $_REQUEST['nama'];
$alamat = $_REQUEST['alamat'];
$tmp_lahir = $_REQUEST['tmp_lahir'];
$tgl_lahir = $_REQUEST['tgl_lahir'];
$no_telp = $_REQUEST['no_telp'];
$id_tingkat = $_POST['id_tingkat'];
$id_jurusan = $_POST['id_jurusan'];
$id_kelas = $_POST['id_kelas'];

$link = "index.php?option=$option&act=edit&id=$id";
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

	$sql = "update $table set nisn = '$nisn', nama='$nama', alamat='$alamat', tmp_lahir='$tmp_lahir', tgl_lahir='".tglConvert($tgl_lahir,'/','-')."', no_telp='$no_telp' where id='$id'";
	$insert = mysqli_query($con, $sql);
	if($insert){
			$id_siswa = $id;
			$id_periode = periodeAktif($con);
			$cekkelas = mysqli_query($con, "Select * from ms_siswa_kelas where id_siswa='$id' and id_periode='$id_periode'");
			$jmlkelas = mysqli_num_rows($cekkelas);
			if($jmlkelas==0){
				$sqlkelas = "update ms_siswa_kelas set aktif='0' where id_siswa ='$id')";
				$insertkelas = mysqli_query($con, $sqlkelas);


				$sqlkelas = "insert into ms_siswa_kelas (id_siswa, id_tingkat, id_jurusan, id_kelas, id_periode)
							 values ('$id_siswa', '$id_tingkat','$id_jurusan', '$id_kelas','$id_periode')";
				$insertkelas = mysqli_query($con, $sqlkelas);
			}else{

				$sqlkelas = "update ms_siswa_kelas set id_tingkat='$id_tingkat', id_jurusan='$id_jurusan', id_kelas='$id_kelas' where id_periode='$id_periode' and id_siswa = '$id'";
				$insertkelas = mysqli_query($con, $sqlkelas);
			}

		header("Location: index.php?option=$option");
	}else{
		echo "<script>alert('Update Data Gagal!!');document.location = '".$link."';</script>";
	} 
}
?>