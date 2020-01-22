<?php 
session_start();
include "global/config.php";
include "global/function.php";
$id_usermanager = mysqli_escape_string($con, $_SESSION['ses_id']);
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
				<span style="font-size:26px;font-weight: bold;">List Total Tagihan Siswa</h1></span>
			</td>
		</tr>
	</table>
  <?php
	$sql = "select * from ms_siswa";
	$query = mysqli_query($con, $sql);
	$jmldata = mysqli_num_rows($query);
  ?>
	<table class="table table-bordered" width="100%" border="1">
			<tr class="bg-primary">
				<td width="3%">No</td>
				<td width="100px">Kode Siswa</td>
				<td width="100px">Nama Siswa</td>
				<td width="300px">Alamat</td>
				<td width="100px">No Telepon</td>
				<td width="100px">Total Tagihan(Rp.)</td>
			</tr>
			<?php 
			$sisa = 0;
			$no = 1;
			while($row = mysqli_fetch_array($query)){
				?>
				<tr>
					<td><?php echo $no++;?></td>
					<td><?php echo $row["nisn"];?></td>
					<td><?php echo $row["nama"];?></td>
					<td><?php echo $row["alamat"];?></td>
					<td><?php echo $row["no_telp"];?></td>
					<td><?php echo cost(totalTagihan($row['id'], $con));?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="3" align="right"> Total :</td>
				<td align="right"><?php echo "Rp. ".cost($sisa); ?></td>
				<td align="right">
					<form action="send-sms-all.php" method="POST" target="_blank">
						<input type="hidden" name="id_siswa" value="<?php echo $id_siswa;?>">
						<input type="hidden" name="nilai" value="<?php echo $sisa;?>">
						<button target="_blank" class="btn btn-default btn-sm">Kirim SMS</button>
					</form>
				</td>
			</tr>
		</table>
		<?php 
		$sqladmin = mysqli_query($con, "select * from usermanager where id = '".$id_usermanager."'");
		$row = mysqli_fetch_array($sqladmin);
		?>
		<table width="100%">
			<tr>
				<td width="70%"></td>
				<td width="30%" align="center">Surabaya, <?php echo tglIndo2(date("Y-m-d"), ' ');?></td>
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