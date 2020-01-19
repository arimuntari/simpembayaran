<?php 
include "global/config.php";
include "global/function.php";
$id_siswa = $_REQUEST['id_siswa'];
$nilai = $_REQUEST['nilai'];


$sqldetil = "select * from ms_siswa where id='$id_siswa'";
$mysqldetil = mysqli_query($con, $sqldetil);
$rowdetil = mysqli_fetch_array($mysqldetil);
$no_telp = $rowdetil['no_telp'];
$sql = "select * from ms_pembayaran where id='$id_pembayaran'";
$mysql = mysqli_query($con, $sql);
$row = mysqli_fetch_array($mysql);

$text = "Anda memiliki tunggakan pembayaran senilai Rp. ".cost($nilai)." untuk keterangan lebih lanjut hubungi sekolah \n\nKEUANGAN SMK PGRI 13 SURABAYA";
include "global/config_gammu.php";
//echo $text;
$sql = mysqli_query($con, "insert into outbox (DestinationNumber, TextDecoded, CreatorID) values ('".$no_telp."', '$text' ,'SMK PGRI 13')");

?>
<script>
alert("Pengiriman SMS Berhasil");
window.close();
</script>