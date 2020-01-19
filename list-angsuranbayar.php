<?php 
include "global/config.php";
$id_siswa = $_REQUEST['id_siswa'];
$id_bayar = $_REQUEST['id_bayar'];
if(!empty($id_siswa)){
	include "global/function.php";
}
$sqlbayar = mysqli_query($con, "select * from ms_pembayaran where id = '$id_bayar'");
$rowbayar = mysqli_fetch_array($sqlbayar);
$totalbayar = $rowbayar['harga'];
?>
<table class="table table-bordered">
	<tr class="bg-blue">
		<td colspan="3">List Angsuran<b> <?php echo $rowbayar['nama_pembayaran']." - ".cost($rowbayar['harga']);?></b></td>
	</tr>
	<tr class="bg-blue">
		<td width="75%">Tanggal Bayar</td>
		<td width="15%">Harga</td>
	</tr>
	<?php 
		$sql = mysqli_query($con, "select * from tr_pembayaran_angsuran where id_siswa='".$id_siswa."' and id_pembayaran = '$id_bayar'");
		while($row = mysqli_fetch_array($sql)){
		$totalbayar -=$row['bayar'];
		$tgl = explode(" ", $row['tgl_pembayaran_angsuran']);
		?>
			<tr>
				<td><?php echo tglIndo2($tgl[0], " ");?></td>
				<td align="right"><?php echo cost($row['bayar']);?></td>
			</tr>
	<?php	
		}
	?>
		<tr>
			<td align="right">Sisa Pembayaran</td>
			<td align="right"><?php echo cost($totalbayar);?></td>
		</tr>
		<tr>
			<td align="right">Jumlah Bayar</td>
			<td align="right"><input type="text" name="bayar" style="text-align:right" value=""></td>
		</tr>
</table>
<input type="hidden" name="total" style="text-align:right" value="<?php echo $rowbayar['harga'];?>">
<input type="hidden" name="angsuran_sekarang" style="text-align:right" value="<?php echo $totalbayar;?>">