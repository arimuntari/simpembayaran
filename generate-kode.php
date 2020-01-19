<?php
include "global/config.php";
include "global/function.php";
$id = $_REQUEST['id'];

$kode = kodeSiswa($id, $con);
?>

<script>
	document.getElementById('nisn').value = "<?php echo $kode?>";
</script>