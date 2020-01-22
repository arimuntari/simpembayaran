<?php 
$table = "tr_pembayaran";
$id_periode = periodeAktif($con);
$tgl1 = $_REQUEST['tgl1']; 
if(empty($tgl1)){
	$tgl1 = date("d/m/Y");
}
$tgl2 = $_REQUEST['tgl2']; 
if(empty($tgl2)){
	$tgl2 = date("d/m/Y");
}
$where = " tgl_pembayaran between '".tglConvert($tgl1,"/")."' and '".tglConvert($tgl2,"/")."'";
if(!empty($key)){
	$where .= " and kode_pembayaran like '%$key%'";
}

?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-file"></i> Laporan Pembayaran</h1>
  </section>
  <?php
	if(empty($hal)){
		$hal = 1;
		$start = 0;
	}else{
		$start = $batas * ($hal-1);
	}
	$sql = "select a.*, b.nama, b.nisn from $table a inner join ms_siswa b on a.id_siswa = b.id where $where  order by a.id desc ";
	$query = mysqli_query($con, $sql);

	$sql_total = mysqli_query($con, "select * from $table a inner join ms_siswa b on a.id_siswa = b.id where $where ");
	$jmldata = mysqli_num_rows($sql_total);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <div class="row">
			<div class="col-md-2">
				<button onclick="window.open('excel-lap-pembayaran.php?tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>');" class="btn btn-success btn-block"> <i class="fa fa-file-excel-o"></i> Export Excel </button>
			</div>
			<div class="col-md-2">
				<button onclick="window.open('cetak-lap-pembayaran.php?tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>');" class="btn btn-primary btn-block"> <i class="fa fa-print"></i> Cetak </button>
			</div>
			<div class="col-md-2">
				<button onclick="document.location.reload();" class="btn btn-default  btn-block"> <i class="fa fa-refresh"></i> Refresh </button>
			</div>
			<div class="col-md-6" style="text-align:right;font-size:16px;vertical-align:bottom;">
				<b>Total Data: <?php echo $jmldata;?></b>
			</div>
		  </div>
      </div>
      <div class="box-body">
      	<div class="row">
	      	<form method="post" class="form-horizontal" action="index.php?option=<?php echo $option;?>">
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Tanggal:</b></p>
				</div>
				<div class="col-sm-2">
					<input type="text" name="tgl1" value="<?php echo $tgl1;?>" class="form-control tgl" autocomplete="off" placeholder="Masukkan Tanggal Pembayaran">
		        </div>
	      		<div class="col-sm-3">
					<div class="input-group input-group-md">
						<input type="text" name="tgl2" value="<?php echo $tgl2;?>" class="form-control tgl" autocomplete="off" placeholder="Masukkan Tanggal Pembayaran">
						<span class="input-group-btn">
			                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i> Tampil</button>
			            </span>
					</div>
				</div>
	        </form>
        </div><br>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr class="bg-primary">
					<td width="3%">No</td>
					<td width="10%">Kode Pembayaran</td>
					<td width="6%">Kode Siswa</td>
					<td width="9%">Kelas Siswa</td>
					<td width="18%">Nama Siswa</td>
					<td width="14%">Tanggal Pembayaran</td>
					<td width="9%">Total(Rp.)</td>
					<td width="5%" colspan="3"></td>
				</tr>
				<?php 
				$no = 0;
				$total = 0;
				while($row = mysqli_fetch_array($query)){
					$no++;
					$tgl = explode(' ', $row['tgl_pembayaran']);
					$total += $row['total'];
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo Highlight($row['kode_pembayaran'], $key);?></td>
					<td><?Php echo $row['nisn'];?></td>
					<td><?Php echo kelasSiswa($row['id_siswa'], $con);?></td>
					<td><?Php echo $row['nama'];?></td>
					<td><?Php echo tglConvert($tgl[0], '-', '/');?></td>
					<td align="right"><?php echo cost($row['total']);?></td>
					<td align="center">
						<button onclick="window.open('cetak_trpembayaran.php?id=<?php echo $row['id'];?>');" class="btn btn-default btn-xs" title="Print Data"><i class="fa fa-print"></i></button>
							
					</td>
				</tr>
				<?php 
				}
				?>
				<tr>
					<td colspan="6" align="right">Total :</td>
					<td align="right"><?php echo "Rp. ".cost($total);?></td>
				</tr>
			</table>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>