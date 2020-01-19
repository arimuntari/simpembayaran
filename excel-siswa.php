<?php 
include "global/config.php";
include "global/function.php";
$id_periode = periodeAktif($con);
$where = "b.id_periode = '$id_periode'";
$id_tingkat = $_REQUEST['id_tingkat'];
$id_jurusan = $_REQUEST['id_jurusan'];
$id_kelas = $_REQUEST['id_kelas'];

if(!empty($id_tingkat)){
	$where .= " and id_tingkat = '$id_tingkat'";
}
if(!empty($id_jurusan)){
	$where .= " and id_jurusan = '$id_jurusan'";
}
if(!empty($id_kelas)){
	$where .= " and id_kelas = '$id_kelas'";
}

$sqldetil = mysqli_query($con, "select * from ms_siswa where id='$id_siswa'");
$rowdetil = mysqli_fetch_array($sqldetil);

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=excel_siswa.xls");


$sql = "select * from ms_siswa a inner join ms_siswa_kelas b on b.id_siswa  = a.id where $where  order by a.id desc ";
//echo $sql;
$query = mysqli_query($con, $sql);

  ?>
<table class="table table-bordered" width="100%">
	<tr>
		<td colspan="4">Tagihan Siswa <?php echo kelasSiswa($rowdetil['id'], $con)." | ".$rowdetil['nisn']." | ".$rowdetil['nama'];?></td>
	</tr>
	<tr class="bg-primary">
		<td width="3%">No</td>
		<td width="10%">Kode Siswa</td>
		<td width="25%">Nama</td>
		<td width="10%">No. Tlp</td>
		<td width="10%">Kelas</td>
		<td width="10%">Status</td>
	</tr>
	<?php 
	$no = 0;
	while($row = mysqli_fetch_array($query)){
		$no++;
	?>
	<tr>
		<td><?php echo $no;?></td>
		<td><?php echo $row['nisn'];?></td>
		<td><?php echo $row['nama'];?></td>
		<td><?php echo "'".$row['no_telp'];?></td>
		<td><?php echo kelasSiswa($row['id'], $con);?></td>
		<td><?php echo cekAktif($row['aktif']);?></td>
	</tr>
	<?php 
	}
	?>
</table>