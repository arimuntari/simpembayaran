<?php 
$table = "tr_pembayaran";
$where = " tgl_pembayaran = '".tglConvert($tgl, '/')."'";
$id_periode = periodeAktif($con);
$id_siswa = $_REQUEST['id_siswa']; 

?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-file"></i> List Total Tagihan Siswa</h1>
  </section>
  <?php
	$sql = "select * from ms_siswa";
	$query = mysqli_query($con, $sql);
	$jmldata = mysqli_num_rows($query);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <div class="row">
			<div class="col-md-2">
				<button onclick="window.open('excel-list-tagihan-siswa.php');" class="btn btn-success btn-block"> <i class="fa fa-file-excel-o"></i> Export Excel </button>
			</div>
			<div class="col-md-2">
				<button onclick="window.open('cetak-list-tagihan-siswa.php');" class="btn btn-primary btn-block"> <i class="fa fa-print"></i> Cetak </button>
			</div>
			<div class="col-md-2">
				<button onclick="document.location.reload();" class="btn btn-default  btn-block"> <i class="fa fa-refresh"></i> Refresh </button>
			</div>
			<div class="col-md-6" style="text-align:right;font-size:16px;vertical-align:bottom;">
				
			</div>
		  </div>
      </div>
      <div class="box-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr class="bg-primary">
					<td width="3%">No</td>
					<td width="100px">Kode Siswa</td>
					<td width="100px">Nama Siswa</td>
					<td width="300px">Alamat</td>
					<td width="100px">No Telepon</td>
					<td width="100px">Total Tagihan(Rp.)</td>
				</tr>
				<?php 
				$sisa = 0;
				$no = 1;
				while($row = mysqli_fetch_array($query)){
				?>
				<tr>
					<td><?php echo $no++;?></td>
					<td><?php echo $row["nisn"];?></td>
					<td><?php echo $row["nama"];?></td>
					<td><?php echo $row["alamat"];?></td>
					<td><?php echo $row["no_telp"];?></td>
					<td><?php echo cost(totalTagihan($row['id'], $con));?></td>
				</tr>
				<?php
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