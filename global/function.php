<?php 

function tglWaktu($datetime){
	$tgl = new Datetime($datetime);
	return $tgl->format('d-m-Y H:i:s');
}
function tglIndo($tgl, $pemisah = " - "){
	$bulan = array ( 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus','September', 'Oktober', 'November', 'Desember');
	$ex = explode('-', $tgl);
	return $ex[2].$pemisah.$bulan[$ex[1]].$pemisah.$ex[0];
}

function tglIndo2($tgl, $pemisah = " - "){
	$bulan = array ( '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus','September', 'Oktober', 'November', 'Desember');
	$ex = explode('-', $tgl);
	return $ex[2].$pemisah.$bulan[(int)$ex[1]].$pemisah.$ex[0];
}
function tglConvert($tgl, $tanda = '-', $tanda2 = '-'){
	$ex = explode($tanda, $tgl);
	return $ex[2].$tanda2.$ex[1].$tanda2.$ex[0];
}
function cekAktif($aktif){
	if($aktif == '1'){
		return "<span class='label label-success'>Aktif</span>";
	}
	return "<span class='label label-danger'>Nonaktif</span>";
}
function pagination($jmldata, $link='index.php',   $batas=10, $hal=1){
	if($jmldata>$batas){
		$jmlhal = ceil($jmldata/$batas);
		$start = 1;
		$end = $jmlhal;

		if($hal>5){
			$start = $hal-5;
		}
		if($hal+5 <= $end){
			$end = $hal+5;
		}

		$page  = '<ul class="pagination pagination-sm no-margin pull-right">';
		if($hal>0){
			$first = $hal-1;
		}else{
			$first = 1;
		}
		$page .= "<li><a href='$link&hal=$first'>«</a></li>";
		for($i=$start;$i<=$end;$i++){
			$class ='';
			if($hal == $i){
				$class="active";
			}
			$page .="<li class='$class'><a href='$link&hal=$i'>$i</a></li>";
		}
		if($hal<$jmlhal){
			$last = $hal+1;
		}else{
			$last = $jmlhal;
		}
		$page .="<li><a href='$link&hal=$last'>»</a></li>";
		$page .="</ul>";
		echo $page;
	}
}
function HighLight($String, $Keyword){
	if($Keyword == null){
		return $String;
	}else{
		$chString	= str_split($String);
		$lenKey		= strlen($Keyword);
		$strResult	= $chString;
		
		for($i=0; $i<count($chString); $i++)
		{
			$strKey = "";
			for($a=$i; $a<($i+$lenKey); $a++)
			{
				$strKey .= $chString[$a];
			}
			
			if(strtolower($strKey) == strtolower($Keyword))
			{
				for($b=$i; $b<($i+$lenKey); $b++)
				{
					$strResult[$b] = "<b><font color='red'>".$chString[$b]."</font></b>";
				}
			}
		}
		
		return implode("", $strResult);
	}
}
function periodeAktif($con){
	$sql = mysqli_query($con, "select id from ms_periode where aktif='1'");
	$row = mysqli_fetch_array($sql);
	return $row['id'];
}
function kelasSiswa($id_siswa, $con){
	$id_periode = periodeAktif($con);
	$sql = mysqli_query($con, "select id_siswa, tingkat, singkatan, kelas from ms_siswa_kelas a inner join ms_kelas b on a.id_kelas = b.id inner join ms_tingkat c on a.id_tingkat = c.id inner join ms_jurusan d on a.id_jurusan = d.id where id_siswa='$id_siswa' and id_periode ='$id_periode'");
	$row = mysqli_fetch_array($sql);
	return $row['tingkat']." ".$row['singkatan']." ".$row['kelas'];
}
function tipePembayaran($tipe){
	if($tipe=='0'){
		return "Sekali Bayar";
	}else{
		return "Bulanan";
	}
}
function getPembayaranTingkat($id, $con){
	$sql = mysqli_query($con, "select b.tingkat from ms_pembayaran_tingkat a inner join ms_tingkat b on a.id_tingkat = b.id  where  id_pembayaran ='$id'");
	$jml = mysqli_num_rows($sql);
	if($jml>1){
		return "Semua";
	}else{
		$row = mysqli_fetch_array($sql);
		return $row["tingkat"];
	}
}
function getPembayaranJurusan($id, $con){
	$sql = mysqli_query($con, "select b.nama_jurusan from ms_pembayaran_jurusan a inner join ms_jurusan b on a.id_jurusan = b.id  where id_pembayaran ='$id'");
	$jml = mysqli_num_rows($sql);

	if($jml>1){
		return "Semua";
	}else{
		$row = mysqli_fetch_array($sql);
		return $row["nama_jurusan"];
	}
}

function getKelas($id_kelas, $con){
	if($id_kelas=='0'){
		return "Semua";
	}else{
		$sql = mysqli_query($con, "select kelas from ms_kelas where  id ='$id_kelas'");
		$row = mysqli_fetch_array($sql);
		return $row['kelas'];
	}
}
function getPeriode($id_periode, $con){
	if($id_periode=='0'){
		return "";
	}else{
		$sql = mysqli_query($con, "select nama_periode from ms_periode where  id ='$id_periode'");
		$row = mysqli_fetch_array($sql);
		return $row['nama_periode'];
	}
}
function cost($number, $pemisah = '.'){
	return number_format($number, 0, "", $pemisah );
}

function cekTipe($tipe, $jml){
	if($tipe==0){
		return "Sekali Bayar";
	}else if($tipe==1){
		return "Bulanan";
	}else{
		return "Angsuran ".$jml."X";
	}
}

function kodePembayaran($con){
	$sql = mysqli_query($con, "select id from tr_pembayaran order by id desc");
	$row = mysqli_fetch_array($sql);
	if($row['id']==''){
		return "TR".str_pad("1", 6, "0", STR_PAD_LEFT);
	}else{
		return "TR".str_pad($row['id']+1, 6, "0", STR_PAD_LEFT);
	}
}
function kodeSiswa($id, $con){
	$sql = mysqli_query($con, "select singkatan from ms_jurusan where id='$id'");
	$row = mysqli_fetch_array($sql);
	$kode = $row['singkatan'];

	$sqlkode = mysqli_query($con, "select b.nisn from ms_siswa_kelas a inner join ms_siswa b on a.id_siswa =b.id where a.id_jurusan='$id' order by id_siswa desc");
	$rowkode = mysqli_fetch_array($sqlkode);
	if(empty($rowkode['nisn'])){
		$nomer = 1;
	}else{
		$ex = explode('-', $rowkode['nisn']);
		$nomer = $ex[1]+1;
	}
	$kodesiswa = $kode."-".str_pad($nomer, 3, "0", STR_PAD_LEFT);
	return $kodesiswa;
}
function bulan($bulan){
	$listBulan = array ( '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus','September', 'Oktober', 'November', 'Desember');
	return $listBulan[$bulan];
}
function cekBulanBayar($id_siswa, $id_pembayaran, $con){
	$sqlbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '$id_pembayaran' and id_siswa='$id_siswa' order by a.id desc");
	$jmlbayar = mysqli_num_rows($sqlbayar);
	$rowbayar = mysqli_fetch_array($sqlbayar);
	if($jmlbayar == 0){
		$bulan = 7;
	}else if($jmlbayar<12){
		$bulan = ($rowbayar["bulan"]+1)%12;
	}
	return $bulan;
}
function totalTagihan ($id_siswa, $con){
	$sisa = 0;
	$query = mysqli_query($con, "select a.* from ms_pembayaran a inner join ms_pembayaran_tingkat b on b.id_pembayaran = a.id inner join ms_pembayaran_jurusan c on c.id_pembayaran = a.id where (b.id_tingkat, c.id_jurusan, a.id_periode) in (select id_tingkat, id_jurusan, id_periode from ms_siswa_kelas where id_siswa= '$id_siswa')");
	while($row = mysqli_fetch_array($query)){
		if($row["tipe"]=='0'){
			$cekbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '".$row['id']."' and id_siswa = '$id_siswa'");
			$jmlbayar =mysqli_num_rows($cekbayar);
			$rowbayar =mysqli_fetch_array($cekbayar);
			if($jmlbayar==0){
				$no++;
				$sisa+=$row['harga'];
			}
		}else if($row["tipe"]=='1'){
			$cek  =true;
			$cekbayar = mysqli_query($con, "select * from tr_pembayaran_detil a inner join tr_pembayaran b on a.id_trpembayaran = b.id where id_pembayaran = '".$row['id']."' and id_siswa = '$id_siswa' order by a.id desc");
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
				$sisa+=$rowcek["sisa_bayar"];	
			}
		}
	}
	return $sisa;
}
?>