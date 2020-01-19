<?php 
include "global/config.php";
include "global/function.php";
$table = "tr_pembayaran";
$id_periode = periodeAktif($con);
$tgl1 = $_REQUEST['tgl1']; 
if(empty($tgl1)){
	$tgl1 = date("d/m/Y");
}
$tgl2 = $_REQUEST['tgl2']; 
if(empty($tgl2)){
	$tgl2 = date("d/m/Y");
}
$where = " tgl_pembayaran between '".tglConvert($tgl1,"/")."' and '".tglConvert($tgl2,"/")."'";

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=excel_Pembayaran_$tgl1_$tgl2.xls");
?>
 
  <?php
	if(empty($hal)){
		$hal = 1;
		$start = 0;
	}else{
		$start = $batas * ($hal-1);
	}
	$sql = "select a.*, b.nama, b.nisn from $table a inner join ms_siswa b on a.id_siswa = b.id where $where  order by a.id desc";
	$query = mysqli_query($con, $sql);

	$sql_total = mysqli_query($con, "select * from $table a inner join ms_siswa b on a.id_siswa = b.id where $where ");
	$jmldata = mysqli_num_rows($sql_total);


  ?>

	<table class="table table-bordered" width="100%" border="1">
		<tr>
			<td colspan="7"> <h1>Transaksi Pembayaran <?Php echo $tgl1." - ".$tgl2; ?></h1></td>
		</tr>
		<tr class="bg-primary">
			<td width="3%">No</td>
			<td width="10%">Kode Pembayaran</td>
			<td width="6%">Kode Siswa</td>
			<td width="9%">Kelas Siswa</td>
			<td width="15%">Nama Siswa</td>
			<td width="12%">Tanggal Pembayaran</td>
			<td width="9%">Total</td>
		</tr>
		<?php 
		$no = 0;
		$total = 0;
		while($row = mysqli_fetch_array($query)){
			$no++;
			$tgl = explode(' ', $row['tgl_pembayaran']);
			$total += $row['total'];
		?>
		<tr>
			<td><?php echo $no;?></td>
			<td><?php echo Highlight($row['kode_pembayaran'], $key);?></td>
			<td><?Php echo $row['nisn'];?></td>
			<td><?Php echo kelasSiswa($row['id_siswa'], $con);?></td>
			<td><?Php echo $row['nama'];?></td>
			<td><?Php echo tglConvert($tgl[0], '-', '/');?></td>
			<td align="right"><?php echo "Rp. ".cost($row['total']);?></td>
		</tr>
		<?php 
		}
		?>
		<tr>
			<td colspan="6" align="right">Total :</td>
			<td align="right"><?php echo "Rp. ".cost($total);?></td>
		</tr>
	</table>