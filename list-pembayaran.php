<?php 
session_start();
include "global/config.php";

$t = $_REQUEST['t'];

if(!empty($t)){
	include "global/function.php";
	$id = $_REQUEST['id'];
	$id_siswa = $_REQUEST['id_siswa'];
	$act = $_REQUEST['act'];

	if(!empty($id)){
		$_SESSION['data_pembayaran'][] = $id;
	}

	if($act!=''){
		unset($_SESSION['data_pembayaran'][$act]);
	}

}else{
	unset($_SESSION['data_pembayaran']);

}
$listdata = $_SESSION['data_pembayaran'];
?>
<table class="table table-bordered">
	<tr class="bg-blue">
		<td colspan="3">List Pembayaran</td>
	</tr>
	<tr class="bg-blue">
		<td width="75%">Nama Pembayaran</td>
		<td width="15%">Harga</td>
		<td width="10%"></td>
	</tr>
	<?php 
	if(!empty($listdata)){
	?>
	<?php 
		$total = 0;
		foreach($listdata as $key => $data){
			$sql = mysqli_query($con, "select * from ms_pembayaran where id='".$data."'");
			$row = mysqli_fetch_array($sql);
			if($row['tipe']==1){
				$bulan =   cekBulanBayar($id_siswa, $row['id'], $con);
				$row["nama_pembayaran"] .= " Bulan ". bulan($bulan);
			}
			$total +=$row['harga'];
	?>
			<tr>
				<td><?php echo $row['nama_pembayaran'];?></td>
				<td align="right"><?php echo cost($row['harga']);?></td>
				<td align="center"><button type="button" class="btn btn-danger btn-xs" onclick="$('#table-list').load('list-pembayaran.php?t=t&id_siswa=<?php echo $id_siswa;?>&act=<?php echo $key; ?>');"> X </button></td>
			</tr>
	<?php	
		}
		?>
		<tr>
			<td align="right">Total</td>
			<td align="right"><?php echo cost($total);?></td>
		</tr>
	<?php
	}
	?>
</table>
<input type="hidden" name="total" value="<?php echo $total?>">