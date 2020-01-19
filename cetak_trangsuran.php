<?php 
session_start();
include "global/config.php";
include "global/function.php";

$id = $_REQUEST['id'];

$sql = "select a.*, b.nama, c.*, a.id, b.nisn from tr_pembayaran_angsuran a inner join ms_siswa b on a.id_siswa = b.id inner join ms_pembayaran c on a.id_pembayaran =c.id where a.id='$id'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);

$tgl = explode(' ', $row['tgl_angsuran']);
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
			<td width="50%" align="center"><span style="font-size:35px;font-weight: bold;">SMK PGRI 13 SURABAYA </span></td>
			<td width="25%" rowspan="3" align="center">
				<img src="images/logo.png" height=100px;>
			</td>
		</tr>
		<tr>
			<td width="50%" align="center"><span style="font-size:25px;">Jl. Sidosermo PDK IV E/2 Surabaya</span></td>
		</tr>
		<tr>
			<td width="50%" align="center"><span style="font-size:20px;">Telp. +6231-8471604, Email:ppdb2019@smkpgri13sby.sch.id</span></td>
		</tr>
		<tr>
			<td colspan="3"  align="center" style="border-bottom:2px solid #000;">
				<span style="font-size:16px;">
				Jurusan: Bisnis Daring dan Pemasaran, Desain Komunikasi Visual, Otomisasi dan Tatakelola Perkantoran, Teknik Komputer dan Jaringan
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="3"  align="center">
				<span style="font-size:30px;font-weight: bold;">Tanda Bukti Pembayaran Angsuran</span>
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
						<td colspan="2">List Angsuran: </td>
					</tr>
					<tr style="background: #ccc;">
						<td>Tanggal Pembayaran</td>
						<td align="right">Harga  <?php echo $row['nama_pembayaran'];?> - <?php echo "Rp. ".cost($row['harga']);?></td>
					</tr>
					<?php 
					$totalbayar = $row['harga'];
					$sqlbayar = mysqli_query($con, "select * from tr_pembayaran_angsuran where id_siswa='".$row['id_siswa']."' and id_pembayaran = '".$row['id_pembayaran']."' and id < '".$row['id']."'");
						while($rowbayar = mysqli_fetch_array($sqlbayar)){
						$totalbayar -=$rowbayar['bayar'];
						$tgl = explode(" ", $rowbayar['tgl_pembayaran_angsuran']);
					?>
					<tr>
						<td><?php echo tglIndo2($tgl[0], " ");?></td>
						<td align="right"><?php echo "Rp. ".cost($rowbayar['bayar']);?></td>
					</tr>
					<?php }?>
					<tr>
						<td align="right">Sisa Pembayaran</td>
						<td align="right"><?php echo "Rp. ".cost($totalbayar);?></td>
					</tr>
					<tr>
						<td align="right">Bayar :</td>
						<td align="right"><?php echo "Rp. ".cost($row['bayar']);?></td>
					</tr>
					<tr>
						<td align="right">Sisa Sekarang :</td>
						<td align="right"><?php echo "Rp. ".cost($totalbayar-$row['bayar']);?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
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
			<td height="100px" width="70%"></td>
			<td width="30%"> </td>
		</tr>
		<tr>
			<td width="70%"></td>
			<td width="30%" align="center"><?php echo $_SESSION['ses_nama'] ;?></td>
		</tr>
	</table>
</body>
</html>