<?php 
include "global/config.php";
include "global/function.php";
$table = "tr_pembayaran";

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tagihan_siswa_$rowdetil[nama].xls");
?>
<div class="table-responsive">
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
</div>