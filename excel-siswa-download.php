<?php
include "global/config.php";
include "global/function.php";
require 'vendor/autoload.php';
$id_periode = periodeAktif($con);
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$id_tingkat = $_REQUEST["id_tingkat"];
$id_jurusan = $_REQUEST["id_jurusan"];
$id_kelas = $_REQUEST["id_kelas"];
$where = '1 = 1';
if($id_tingkat != '' ){
	$where .= " and id_tingkat = '$id_tingkat'";
}
if($id_jurusan != '' ){
	$where .= " and id_jurusan = '$id_jurusan'";
}
if($id_kelas != '' ){
	$where .= " and id_kelas = '$id_kelas'";
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Keterangan:');
$sheet->setCellValue('A2', 'Tingkat');
$i = 2;
$sheet->getColumnDimension('A')->setautosize(true);
$sheet->getColumnDimension('D')->setautosize(true);
$sheet->getColumnDimension('E')->setautosize(true);
$sheet->getColumnDimension('F')->setautosize(true);
$sheet->getColumnDimension('G')->setautosize(true);
$sheet->getColumnDimension('H')->setautosize(true);
$sheet->getColumnDimension('I')->setautosize(true);
$sheet->getColumnDimension('J')->setautosize(true);
$sheet->getColumnDimension('K')->setautosize(true);
$sheet->getColumnDimension('L')->setautosize(true);
$sheet->getColumnDimension('M')->setautosize(true);
$sqltingkat = mysqli_query($con, "select * from ms_tingkat order by id asc");
while($rowtingkat = mysqli_fetch_array($sqltingkat)){
	$i++;
	$sheet->setCellValue('A'.$i, "Code ". $rowtingkat["id"].' = '.$rowtingkat["tingkat"]);
}

$i++;
$i++;
$sheet->setCellValue('A'.$i, 'Jurusan');
$sqljurusan = mysqli_query($con, "select * from ms_jurusan order by id asc");
while($rowjurusan = mysqli_fetch_array($sqljurusan)){
	$i++;
	$sheet->setCellValue('A'.$i, "Code ". $rowjurusan["id"].' = '.$rowjurusan["singkatan"]);
}

$i++;
$i++;
$sheet->setCellValue('A'.$i, 'Kelas');
$sqlkelas = mysqli_query($con, "select * from ms_kelas order by id asc");
while($rowkelas = mysqli_fetch_array($sqlkelas)){
	$i++;
	$sheet->setCellValue('A'.$i, "Code ". $rowkelas["id"].' = '.$rowkelas["kelas"]);
}

$sheet->setCellValue('D1', 'No. ');
$sheet->setCellValue('E1', 'Kode Siswa');
$sheet->setCellValue('F1', 'Nama Siswa');
$sheet->setCellValue('G1', 'Alamat');
$sheet->setCellValue('H1', 'Tempat Lahir');
$sheet->setCellValue('I1', 'Tanggal Lahir (YYYY-mm-dd)');
$sheet->setCellValue('J1', 'No. Telepon');
$sheet->setCellValue('K1', 'Kelas Siswa');
$sheet->setCellValue('L1', 'Tingkat');
$sheet->setCellValue('M1', 'Jurusan');
$sheet->setCellValue('N1', 'Kelas');
$j=1;
$no = 0;
$sqlsiswa = mysqli_query($con, "select * from ms_siswa a inner join ms_siswa_kelas b on b.id_siswa = a.id where $where and id_periode = '$id_periode' order by a.id asc");
while($row = mysqli_fetch_array($sqlsiswa)){
	$j++;
	$no++;
	$sheet->setCellValue('D'.$j, $no);
	$sheet->setCellValue('E'.$j, $row["nisn"]);
	$sheet->setCellValue('F'.$j, $row["nama"]);
	$sheet->setCellValue('G'.$j, $row["alamat"]);
	$sheet->setCellValue('H'.$j, $row["tmp_lahir"]);
	$sheet->setCellValue('I'.$j, $row["tgl_lahir"]);
	$sheet->setCellValue('J'.$j, $row["no_telp"]);
	$sheet->setCellValue('K'.$j, kelasSiswa($row["id"], $con));
	$sheet->setCellValue('L'.$j, $row["id_tingkat"]);
	$sheet->setCellValue('M'.$j, $row["id_jurusan"]);
	$sheet->setCellValue('N'.$j, $row["id_kelas"]);
}
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="format-siswa-update.xlsx"');
$writer->save('php://output');
?>