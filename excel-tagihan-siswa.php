<?php 
include "global/config.php";
include "global/function.php";
$table = "tr_pembayaran";
$id_siswa = $_REQUEST['id_siswa']; 

$sqldetil = mysqli_query($con, "select * from ms_siswa where id='$id_siswa'");
$rowdetil = mysqli_fetch_array($sqldetil);

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tagihan_siswa_$rowdetil[nama].xls");

?>
<?php
$sql = "select a.* from ms_pembayaran a inner join ms_pembayaran_tingkat b on b.id_pembayaran = a.id inner join ms_pembayaran_jurusan c on c.id_pembayaran = a.id where (b.id_tingkat, c.id_jurusan, a.id_periode) in (select id_tingkat, id_jurusan, id_periode from ms_siswa_kelas where id_siswa= '$id_siswa') ";
//echo $sql;
$query = mysqli_query($con, $sql);
$jmldata = mysqli_num_rows($query);
?>
  <table>
	<tr>
		<td width="150px">Kode Siswa</td>
		<td width="5px">:</td>
		<td width="65%"> &nbsp;<?php echo $rowdetil['nisn']?></td>
	</tr>
	<tr>
		<td>Nama Siswa</td>
		<td>:</td>
		<td> &nbsp;<?php echo $rowdetil['nama']?></td>
	</tr>
	<tr>
		<td>Kelas</td>
		<td>:</td>
		<td> &nbsp;<?php echo kelasSiswa($rowdetil['id'], $con)?></td>
	</tr>
	<tr>
		<td>No. Telp</td>
		<td>:</td>
		<td> &nbsp;<?php echo $rowdetil['no_telp']?></td>
	</tr>
</table>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr class="bg-primary">
			<td width="3%">No</td>
			<td width="9%">Periode</td>
			<td width="19%">Nama Pembayaran</td>
			<td width="9%">Harga</td>
		</tr>
		<?php 
		$sisa = 0;
		$no = 0;
		while($row = mysqli_fetch_array($query)){
			if($row["tipe"]=='0'){
				$cekbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '".$row['id']."' and id_siswa = '$id_siswa'");
				$jmlbayar =mysqli_num_rows($cekbayar);
				$rowbayar =mysqli_fetch_array($cekbayar);
				if($jmlbayar==0){
				$no++;
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?Php echo getPeriode($row['id_periode'], $con);?></td>
					<td><?php echo Highlight($row['nama_pembayaran'], $key);?></td>
					<td align="right"><?php echo cost($row['harga']);?></td>
				</tr>
				<?php 
				$sisa+=$row['harga'];
				}
			}else if($row["tipe"]=='1'){
				$cek  =true;
				$cekbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '".$row['id']."' and id_siswa = '$id_siswa'");
				$jmlbayar =mysqli_num_rows($cekbayar);
				$rowbayar =mysqli_fetch_array($cekbayar);
				if($jmlbayar==0){
					$bulan = 6;
				}else{
					$bulan = $rowbayar["bulan"];
				}
				while($bulan != 6 || $cek == true){
					$cek  =false;
					$bulan++;
				$no++;
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?Php echo getPeriode($row['id_periode'], $con);?></td>
					<td><?php echo $row['nama_pembayaran']." Bulan ".bulan($bulan);?></td>
					<td align="right"><?php echo cost($row['harga']);?></td>
				</tr>
				<?php
					$bulan = $bulan%12;
					$sisa+=$row['harga'];
				}
			}else{
				$cekbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '".$row['id']."' and id_siswa = '$id_siswa'");
				$jmlbayar =mysqli_num_rows($cekbayar);
				$rowbayar =mysqli_fetch_array($cekbayar);

				$sqlcek = mysqli_query($con, "select b.harga-sum(bayar) as sisa_bayar from tr_pembayaran_angsuran a inner join ms_pembayaran b on a.id_pembayaran = b.id where id_pembayaran ='".$row['id']."' and id_siswa = '$id_siswa' group by id_pembayaran");
				$rowcek = mysqli_fetch_array($sqlcek);
				if($jmlbayar == 0){
					$cek = true;
					$rowcek["sisa_bayar"] = $row["harga"];
				}else{
					if($rowcek["sisa_bayar"]>0){
						$cek = true;
					}else{
						$cek = false;
					}
				}
				if($cek){
				$no++;
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?Php echo getPeriode($row['id_periode'], $con);?></td>
					<td><?php echo $row['nama_pembayaran'];?></td>
					<td align="right"><?php echo $row["sisa_bayar"];?></td>
				</tr>
				<?php
				$sisa+=$row['harga'];	
				}
			}
		}
		?>
		<tr>
			<td colspan="3" align="right"> Total :</td>
			<td align="right"><?php echo "Rp. ".cost($sisa); ?></td>
		</tr>
	</table>