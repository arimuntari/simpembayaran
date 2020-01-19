<?php 
include "global/config.php";
include "global/function.php";
$q = $_REQUEST["q"];
if(!empty($q)){
	$sql = mysqli_query($con, "select * from ms_siswa where nisn LIKE '%$q%' or nama LIKE '%$q%' limit 0, 10");
	while($row = mysqli_fetch_array($sql)){
		$row["kelas"] = kelasSiswa($row["id"], $con);
		$data[] =$row; 
	}
	echo json_encode($data);
}
?>