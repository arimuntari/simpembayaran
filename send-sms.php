<?php 
include "global/config.php";
include "global/function.php";
$id_siswa = $_REQUEST['id_siswa'];
$bulan = $_REQUEST['bulan'];
$id_pembayaran = $_REQUEST['id_pembayaran'];


$sqldetil = "select * from ms_siswa where id='$id_siswa'";
$mysqldetil = mysqli_query($con, $sqldetil);
$rowdetil = mysqli_fetch_array($mysqldetil);
$no_telp = $rowdetil['no_telp'];
$sql = "select * from ms_pembayaran where id='$id_pembayaran'";
$mysql = mysqli_query($con, $sql);
$row = mysqli_fetch_array($mysql);
if($row["tipe"]=='0'){
	$text = "Anda memiliki tunggakan pembayaran ".$row['nama_pembayaran']." senilai Rp. ".cost($row['harga'])." \n\nKEUANGAN SMK PGRI 13 SURABAYA";
}else if($row["tipe"]=='1'){
	$text = "Anda memiliki tunggakan pembayaran ".$row['nama_pembayaran']." ".bulan($bulan)." senilai Rp. ".cost($row['harga'])." \n\nKEUANGAN SMK PGRI 13 SURABAYA";
}else{
	$sqlTunggakan = "select sum(bayar) as total from tr_pembayaran_angsuran where id_pembayaran='$id_pembayaran' and id_siswa='$id_siswa'";
	$mysqlTunggakan = mysqli_query($con, $sqlTunggakan);
	$rowTunggakan = mysqli_fetch_array($mysqlTunggakan);
	$tunggakan = $row['harga']-$rowTunggakan["total"];
	$text = "Anda memiliki tunggakan pembayaran ".$row['nama_pembayaran']." ".bulan($bulan)." senilai  Rp. ".cost($tunggakan)." \n\nKEUANGAN SMK PGRI 13 SURABAYA";
}
include "global/config_gammu.php";
//echo $text;
$sql = mysqli_query($con, "insert into outbox (DestinationNumber, TextDecoded, CreatorID) values ('".$no_telp."', '$text' ,'SMK PGRI 13')");

?>
<script>
alert("Pengiriman SMS Berhasil");
window.close();
</script>