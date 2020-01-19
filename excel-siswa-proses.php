<?php

include "global/config.php";
include "global/function.php";
require 'vendor/autoload.php';
$id_periode = periodeAktif($con);
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$file = $_FILES['file']['tmp_name'];

$data = PhpOffice\PhpSpreadsheet\IOFactory::load($file)->getActiveSheet();
$hasildata = $data->toArray(null, true, true, true);

//var_dump($hasildata);
$jml  =count($hasildata);
for($i=2;$i<=$jml;$i++){
	$nisn = $data->getCell('E'.$i)->getValue(); 
	$nama = $data->getCell('F'.$i)->getValue(); 
	$alamat = $data->getCell('G'.$i)->getValue(); 
	$tmp_lahir = $data->getCell('H'.$i)->getValue(); 
	$tgl_lahir = $data->getCell('I'.$i)->getValue();
	$no_telp ="";	
	if($data->getCell('J'.$i)->getValue(); ){
		$no_telp = "0".$data->getCell('J'.$i)->getValue(); 
	}
	$id_tingkat = $data->getCell('L'.$i)->getValue(); 
	$id_jurusan = $data->getCell('M'.$i)->getValue(); 
	$id_kelas = $data->getCell('N'.$i)->getValue(); 
	
	$sqlcek = mysqli_query($con, "select * from ms_siswa where nisn = '$nisn'");
	$jmlcek = mysqli_num_rows($sqlcek);
	$row = mysqli_fetch_array($sqlcek);
	$id = $row['id'];

	if($jmlcek == 1 && $nama !=''){
		$sql = "update ms_siswa set  nama='$nama', alamat='$alamat', tmp_lahir='$tmp_lahir', tgl_lahir='$tgl_lahir', no_telp='$no_telp' where nisn='$nisn'";
					echo $sql;
		$insert = mysqli_query($con, $sql);
		if($insert){
				$id_siswa = $id;
				$id_periode = periodeAktif($con);
				$cekkelas = mysqli_query($con, "Select * from ms_siswa_kelas where id_siswa='$id' and id_periode='$id_periode'");
				$jmlkelas = mysqli_num_rows($cekkelas);
				if($jmlkelas==0){
					
					$sqlkelas = "insert into ms_siswa_kelas (id_siswa, id_tingkat, id_jurusan, id_kelas, id_periode)
								 values ('$id_siswa', '$id_tingkat','$id_jurusan', '$id_kelas','$id_periode')";
					$insertkelas = mysqli_query($con, $sqlkelas);
				}else{
					$sqlkelas = "update ms_siswa_kelas set id_tingkat='$id_tingkat', id_jurusan='$id_jurusan', id_kelas='$id_kelas' where id_periode='$id_periode' and id_siswa = '$id'";
					$insertkelas = mysqli_query($con, $sqlkelas);
				}
		}
	}else{
					
		$nisn = kodeSiswa($id_jurusan, $con);
		$sql = "insert into ms_siswa (nisn, nama, alamat, tmp_lahir, tgl_lahir, no_telp, tgl_input, periode_masuk)
								 values ('$nisn','$nama','$alamat','$tmp_lahir','$tgl_lahir','$no_telp', now(), '$id_periode')";
								 echo $sql;
		$insert = mysqli_query($con, $sql);
		if($insert){
				$id_siswa = mysqli_insert_id($con);
				$sqlkelas = "insert into ms_siswa_kelas (id_siswa,  id_tingkat, id_jurusan, id_kelas, id_periode)
								 values ('$id_siswa','$id_tingkat','$id_jurusan', '$id_kelas','$id_periode')";
				$insertkelas = mysqli_query($con, $sqlkelas);
		}
	}
}

header("Location: index.php?option=siswa");
?>