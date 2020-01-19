<?php 
$table = "tr_pembayaran";
$where = " tgl_pembayaran = '".tglConvert($tgl, '/')."'";
$id_periode = periodeAktif($con);
$id_siswa = $_REQUEST['id_siswa']; 

$sqlsiswa = mysqli_query($con, "select * from ms_siswa where id='$id_siswa'");
$row = mysqli_fetch_array($sqlsiswa);
?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-file"></i> Tagihan Siswa</h1>
  </section>
  <?php
	$sql = "select a.* from ms_pembayaran a inner join ms_pembayaran_tingkat b on b.id_pembayaran = a.id inner join ms_pembayaran_jurusan c on c.id_pembayaran = a.id where (b.id_tingkat, c.id_jurusan, a.id_periode) in (select id_tingkat, id_jurusan, id_periode from ms_siswa_kelas where id_siswa= '$id_siswa') ";
	//echo $sql;
	$query = mysqli_query($con, $sql);
	$jmldata = mysqli_num_rows($query);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <div class="row">
			<div class="col-md-2">
				<button onclick="window.open('excel-tagihan-siswa.php?id_siswa=<?php echo $id_siswa;?>');" class="btn btn-success btn-block"> <i class="fa fa-file-excel-o"></i> Export Excel </button>
			</div>
			<div class="col-md-2">
				<button onclick="window.open('cetak-tagihan-siswa.php?id_siswa=<?php echo $id_siswa;?>');" class="btn btn-primary btn-block"> <i class="fa fa-print"></i> Cetak </button>
			</div>
			<div class="col-md-2">
				<button onclick="document.location.reload();" class="btn btn-default  btn-block"> <i class="fa fa-refresh"></i> Refresh </button>
			</div>
			<div class="col-md-6" style="text-align:right;font-size:16px;vertical-align:bottom;">
				
			</div>
		  </div>
      </div>
      <div class="box-body">
      	<div class="row">
	      	<form method="post" class="form-horizontal" action="index.php?option=<?php echo $option;?>">
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Kelas:</b></p>
				</div>
				<div class="col-sm-5">
					<div class="input-group input-group-md">
						<select class="form-control select2" name="id_siswa" id="id_siswa" style="width: 100%;" Required>
		                </select>
		                <span class="input-group-btn">
				            <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i> Tampil</button>
				        </span>
		        	</div>
		        </div>
	        </form>
        </div><br>
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
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr class="bg-primary">
					<td width="3%">No</td>
					<td width="100px">Periode</td>
					<td width="300px">Nama Pembayaran</td>
					<td width="200px">Harga</td>
					<td width="10px">&nbsp;</td>
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
							<td align="right"><a target="_blank" href="send-sms.php?id_siswa=<?php echo $id_siswa;?>&id_pembayaran=<?php echo $row['id'];?>" class="btn btn-default btn-sm">Kirim SMS</a></td>
						</tr>
						<?php 
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
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?Php echo getPeriode($row['id_periode'], $con);?></td>
							<td><?php echo $row['nama_pembayaran']." Bulan ".bulan($bulan);?></td>
							<td align="right"><?php echo cost($row['harga']);?></td>
							<td align="right"><a target="_blank" href="send-sms.php?id_siswa=<?php echo $id_siswa;?>&id_pembayaran=<?php echo $row['id'];?>&bulan=<?php echo $bulan;?>" class="btn btn-default btn-sm">Kirim SMS</a></td>
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
							<td align="right"><a target="_blank" href="send-sms.php?id_siswa=<?php echo $id_siswa;?>&id_pembayaran=<?php echo $row['id'];?>" class="btn btn-default btn-sm">Kirim SMS</a></td>
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
					<td align="right">
						<form action="send-sms-all.php" method="POST" target="_blank">
							<input type="hidden" name="id_siswa" value="<?php echo $id_siswa;?>">
							<input type="hidden" name="nilai" value="<?php echo $sisa;?>">
							<button target="_blank" class="btn btn-default btn-sm">Kirim SMS</button>
						</form>
					</td>
				</tr>
			</table>
			<?php //pagination($jmldata, "index.php?option=$option",  $batas, $hal)?>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>