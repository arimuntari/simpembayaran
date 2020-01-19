<?php
include "global/config.php";
include "global/function.php";
$id = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html>
<body>

<table class="table table-bordered">
	<tr class="bg-blue">
		<td colspan="3">List Pembayaran</td>
	</tr>
	<tr class="bg-blue">
		<td>Nama Pembayaran</td>
		<td>Harga</td>
	</tr>
	<?php 
	$sql = mysqli_query($con, "select a.* from ms_pembayaran a inner join ms_pembayaran_tingkat b on b.id_pembayaran = a.id inner join ms_pembayaran_jurusan c on c.id_pembayaran = a.id where (b.id_tingkat, c.id_jurusan, a.id_periode) in (select id_tingkat, id_jurusan, id_periode from ms_siswa_kelas where id_siswa= '$id')");
	while($row = mysqli_fetch_array($sql)){
		$cek = false;
		if($row['tipe']=='1'){
			$sqlbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran ='".$row['id']."' and id_siswa = '$id' order by a.id desc");
			$jml = mysqli_num_rows($sqlbayar);
			$rowcek = mysqli_fetch_array($sqlbayar);
			if($rowcek['bulan'] != 6){
				$cek = true;
				$bulan =  cekBulanBayar($id, $row['id'], $con);
				$row["nama_pembayaran"] .= " Bulan ". bulan($bulan);
			}
		}else{
			$sqlbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran ='".$row['id']."' and id_siswa = '$id'");
			$jml = mysqli_num_rows($sqlbayar);
			if($jml == 0){
				$cek = true;
				if($row['tipe']=='2'){
					$sqlbayar2 = mysqli_query($con, "select * from tr_pembayaran_angsuran a inner join ms_pembayaran b on a.id_pembayaran = b.id where id_pembayaran ='".$row['id']."' and id_siswa = '$id'");
					$jml2 = mysqli_num_rows($sqlbayar2);
					if($jml2 == 0){
						$cek = true;
					}else{
						$cek = false;
					}
				}
			}
		}
	if($cek){
	?>
	<tr class="list-data" data="<?php echo $row['id'];?>">
		<td><?php echo $row['nama_pembayaran'];?></td>
		<td><?php echo cost($row['harga']);?></td>
	</tr>
	<?php
	}	
	}
	?>
</table>
  <script>

	$('.list-data').click(function() {
	    var value = $(this).attr("data");
	    $('#table-list').load("list-pembayaran.php?t=t&id_siswa=<?php echo $id;?>&id="+value);
	    $('#modal-default').modal('hide');
	});
  </script>
</body>
</html>