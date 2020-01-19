 <?php 

include "global/config.php";
include "global/function.php";
$id_periode = periodeAktif($con);
$id = $_REQUEST['id'];
?>
 <option value="">- Pilih Pembayaran-</option>
<?php 
$sqlbayar = mysqli_query($con, "select a.* from ms_pembayaran a inner join ms_pembayaran_tingkat b on b.id_pembayaran = a.id inner join ms_pembayaran_jurusan c on c.id_pembayaran = a.id where (b.id_tingkat, c.id_jurusan, a.id_periode) in (select id_tingkat, id_jurusan, id_periode from ms_siswa_kelas where id_siswa= '$id') and tipe='2'");
while($rowbayar = mysqli_fetch_array($sqlbayar)){
	$cek=false;
	$ceksqlbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran ='".$rowbayar['id']."' and id_siswa = '$id'");
	$jml = mysqli_num_rows($ceksqlbayar);
	echo $jml;
	if($jml==0){
		$sqlbayar2 = mysqli_query($con, "select b.harga-sum(bayar) as sisa_bayar from tr_pembayaran_angsuran a inner join ms_pembayaran b on a.id_pembayaran = b.id where id_pembayaran ='".$rowbayar['id']."' and id_siswa = '$id' group by id_pembayaran");
		echo  "select b.harga-sum(bayar) as sisa_bayar from tr_pembayaran_angsuran a inner join ms_pembayaran b on a.id_pembayaran = b.id where id_pembayaran ='".$rowbayar['id']."' and id_siswa = '$id' group by id_pembayaran";
		$jml2 = mysqli_num_rows($sqlbayar2);
		$row = mysqli_fetch_array($sqlbayar2);
		echo $rowp["sisa_bayar"];
		if($jml2 == 0){
			$cek = true;
			$row["sisa_bayar"] = $rowbayar["harga"];
		}else{
			if($row["sisa_bayar"]>0){
				$cek = true;
			}else{
				$cek = false;
			}
		}
	}
	echo $cek;
	if($cek){
?>
	<option value="<?php echo $rowbayar['id']?>">
		<?php echo $rowbayar['nama_pembayaran']." ".cost($rowbayar["harga"]);?>
	</option>
<?php 
	}
}
?>