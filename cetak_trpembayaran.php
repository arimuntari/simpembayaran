<?php 
session_start();
include "global/config.php";
include "global/function.php";

$id = $_REQUEST['id'];

$sql = "select a.*, b.nama, b.nisn, b.no_telp from tr_pembayaran a inner join ms_siswa b on a.id_siswa = b.id where a.id='$id'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);

$tgl = explode(' ', $row['tgl_pembayaran']);
?>
<html>
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
				<span style="font-size:26px;font-weight: bold;">Tanda Bukti Pembayaran </span>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td> <b>Kode Pembayaran :</b><?php echo $row['kode_pembayaran']; ?></td>
		</tr>
	</table>
	<table width="100%" style="border:2px solid #000;padding:10px;">
		<tr>
			<td width="30%">Kode Siswa</td>
			<td width="5px">:</td>
			<td width="65%"><?php echo $row['nisn']?></td>
		</tr>
		<tr>
			<td>Nama Siswa</td>
			<td>:</td>
			<td><?php echo $row['nama']?></td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>:</td>
			<td><?php echo kelasSiswa($row['id_siswa'], $con)?></td>
		</tr>
		<tr>
			<td>No. Telp</td>
			<td>:</td>
			<td><?php echo $row['no_telp']?></td>
		</tr>
		<tr>
			<td colspan="3">
				<table class="table" border="1" style="" width="100%">
					<tr style="background: #ccc;">
						<td>Nama Pembayaran</td>
						<td>Harga</td>
					</tr>
					<?php 
					$total = 0;
					$sqldetil = mysqli_query($con, "select * from tr_pembayaran_detil a inner join ms_pembayaran b on a.id_pembayaran = b.id where id_trpembayaran = '$id'");
					while($rowdetil = mysqli_fetch_array($sqldetil)){
						if($rowdetil['tipe'] == '1'){
							$bulan = bulan($rowdetil['bulan']);
							$rowdetil["nama_pembayaran"] .= " Bulan ".$bulan;
						}
					?>
					<tr>
						<td><?php echo $rowdetil['nama_pembayaran'];?></td>
						<td align="right"><?php echo cost($rowdetil['harga']);?></td>
					</tr>
					<?php	
					$total +=$rowdetil['harga']; 
					}
					?>
					<tr>
						<td align="right">Total :</td>
						<td align="right"><?php echo cost($total);?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php 
		$sqladmin = mysqli_query($con, "select * from usermanager where id = '".$row['id_usermanager']."'");
		$row = mysqli_fetch_array($sqladmin);
	?>
	<table width="100%">
		<tr>
			<td width="70%"></td>
			<td width="30%" align="center">Surabaya, <?php echo tglIndo2($tgl[0], ' ');?></td>
		</tr>
		<tr>
			<td width="70%"></td>
			<td width="30%" align="center">Petugas Pembayaran </td>
		</tr>
		<tr>
			<td height="60px" width="70%"></td>
			<td width="30%"> </td>
		</tr>
		<tr>
			<td width="70%"></td>
			<td width="30%" align="center"><?php echo $row['nama'] ;?></td>
		</tr>
	</table>
</body>
</html>