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

?>
 
<head>
	<title>Cetak Pembayaran</title>
	<style>
		.table{
			border-collapse:collapse;

		}
		.table td{
			padding:4px 8px;
		}
	</style>
</head>
<body>
	<table width="100%">
		<tr>
			<td width="25%" rowspan="3" align="center">
				<img src="images/logo.png" height=100px;>
			</td>
			<td width="50%" align="center"><span style="font-size:26px;font-weight: bold;">SMK PGRI 13 SURABAYA </span></td>
			<td width="25%" rowspan="3" align="center">
				<img src="images/logo.png" height=100px;>
			</td>
		</tr>
		<tr>
			<td width="50%" align="center"><span style="font-size:20px;">Jl. Sidosermo PDK IV E/2 Surabaya</span></td>
		</tr>
		<tr>
			<td width="50%" align="center"><span style="font-size:20px;">Telp. +6231-8471604, Email:smpkpgri13@yahoo.co.id</span></td>
		</tr>
		<tr>
			<td colspan="3"  align="center" style="border-bottom:2px solid #000;">
				<span style="font-size:14px;">
				Bisnis Daring & Pemasaran, Desain Komunikasi Visual, Otomisasi Tatakelola Perkantoran, Teknik Komputer & Jaringan
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="3"  align="center">
				<span style="font-size:26px;font-weight: bold;">Transaksi Pembayaran <?Php echo $tgl1." - ".$tgl2; ?></h1></span>
			</td>
		</tr>
	</table>
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