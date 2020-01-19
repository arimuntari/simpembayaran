<?php
session_start();
include "global/config.php";
include "global/function.php";


$table = "tr_pembayaran";
$where = " tgl_pembayaran = '".tglConvert($tgl, '/')."'";
$id_periode = periodeAktif($con);
$id_siswa = $_REQUEST['id_siswa']; 

$sqlsiswa = mysqli_query($con, "select * from ms_siswa where id='$id_siswa'");
$row = mysqli_fetch_array($sqlsiswa);
	$sql = "select a.* from ms_pembayaran a inner join ms_pembayaran_tingkat b on b.id_pembayaran = a.id inner join ms_pembayaran_jurusan c on c.id_pembayaran = a.id where (b.id_tingkat, c.id_jurusan, a.id_periode) in (select id_tingkat, id_jurusan, id_periode from ms_siswa_kelas where id_siswa= '$id_siswa') ";
	//echo $sql;
	$query = mysqli_query($con, $sql);
	$jmldata = mysqli_num_rows($query);
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
				<span style="font-size:26px;font-weight: bold;">Surat Tagihan Pembayaran</span>
			</td>
		</tr>
	</table>
	<table>
    	<tr>
			<td width="150px">Kode Siswa</td>
			<td width="5px">:</td>
			<td width="65%"> &nbsp;<?php echo $row['nisn']?></td>
		</tr>
		<tr>
			<td>Nama Siswa</td>
			<td>:</td>
			<td> &nbsp;<?php echo $row['nama']?></td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>:</td>
			<td> &nbsp;<?php echo kelasSiswa($row['id'], $con)?></td>
		</tr>
		<tr>
			<td>No. Telp</td>
			<td>:</td>
			<td> &nbsp;<?php echo $row['no_telp']?></td>
		</tr>
    </table>
	<table class="table table-bordered" border="1" style="" width="100%">
				<tr class="bg-primary">
					<td width="3%">No</td>
					<td width="100px">Periode</td>
					<td width="300px">Nama Pembayaran</td>
					<td width="200px">Harga</td>
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
						$cek = false;
						$cekbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '".$row['id']."' and id_siswa = '$id_siswa'");
						$jmlbayar =mysqli_num_rows($cekbayar);
						$rowbayar =mysqli_fetch_array($cekbayar);

						if($jmlbayar == 0){
							$sqlcek = mysqli_query($con, "select b.harga-sum(bayar) as sisa_bayar from tr_pembayaran_angsuran a inner join ms_pembayaran b on a.id_pembayaran = b.id where id_pembayaran ='".$row['id']."' and id_siswa = '$id_siswa' group by id_pembayaran");

							$jmlbayar = mysqli_num_rows($sqlcek);
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
						}
						if($cek){
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?Php echo getPeriode($row['id_periode'], $con);?></td>
							<td><?php echo $row['nama_pembayaran']." Rp. ".cost($row["harga"]);?></td>
							<td align="right"><?php echo cost($rowcek["sisa_bayar"]);?></td>
						</tr>
						<?php
						$sisa+=$rowcek["sisa_bayar"];	
						}
					}
				}
				?>
				<tr>
					<td colspan="3" align="right"> Total :</td>
					<td align="right"><?php echo "Rp. ".cost($sisa); ?></td>
				</tr>
			</table>
</body>
</html>