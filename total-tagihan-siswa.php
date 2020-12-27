<?php 
$table = "ms_siswa";
$where = " 1=1 ";
$id_periode = periodeAktif($con);
$id_siswa = $_REQUEST['id_siswa']; 
$id_tingkat = $_REQUEST['id_tingkat'];
$id_jurusan = $_REQUEST['id_jurusan'];
$id_kelas = $_REQUEST['id_kelas'];
if(!empty($key)){
	$where .= " and a.nisn like '%$key%' or nama like '%$key%'";
}
if(!empty($id_tingkat)){
	$where .= " and id_tingkat = '$id_tingkat'";
}
if(!empty($id_jurusan)){
	$where .= " and id_jurusan = '$id_jurusan'";
}
if(!empty($id_kelas)){
	$where .= " and id_kelas = '$id_kelas'";
}
?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-file"></i> List Total Tagihan Siswa</h1>
  </section>
  <?php
	$sql = "select b.*, a.* from $table a inner join ms_siswa_kelas b on b.id_siswa  = a.id where $where order by a.id desc ";
	$query = mysqli_query($con, $sql);
	$jmldata = mysqli_num_rows($query);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <div class="row">
			<div class="col-md-2">
				<button onclick="window.open('excel-list-tagihan-siswa.php?id_tingkat=<?php echo $id_tingkat;?>&id_jurusan=<?php echo $id_jurusan;?>&id_kelas=<?php echo $id_kelas;?>');" class="btn btn-success btn-block"> <i class="fa fa-file-excel-o"></i> Export Excel </button>
			</div>
			<div class="col-md-2">
				<button onclick="window.open('cetak-list-tagihan-siswa.php?id_tingkat=<?php echo $id_tingkat;?>&id_jurusan=<?php echo $id_jurusan;?>&id_kelas=<?php echo $id_kelas;?>');" class="btn btn-primary btn-block"> <i class="fa fa-print"></i> Cetak </button>
			</div>
			<div class="col-md-2">
				<button onclick="document.location.reload();" class="btn btn-default  btn-block"> <i class="fa fa-refresh"></i> Refresh </button>
			</div>
			<div class="col-md-6" style="text-align:right;font-size:16px;vertical-align:bottom;">
				
			</div>
		  </div>
      </div>
      <div class="box-body">
      <form method="post" class="form-horizontal" action="index.php?option=<?php echo $option;?>">
      		<div class="row">
	      		
        	</div><br>
      		<div class="row">
      			<div class="col-sm-1">
					<p class="form-control-static"><b>Filter:</b></p>
				</div>
				<div class="col-sm-2">
                    <select class="form-control" id="id_tingkat" name="id_tingkat"  onchange="submit();">
	              		<option value="">-Pilih Tingkat-</option>
	              		<?php 
	              		$sqltingkat = mysqli_query($con, "select * from ms_tingkat where aktif='1'");
	              		while($rowtingkat = mysqli_fetch_array($sqltingkat)){
	              		?>
	              		<option <?php if($id_tingkat == $rowtingkat['id']){echo "selected";}?> value="<?php echo $rowtingkat['id'];?>"><?php echo $rowtingkat['tingkat'];?></option>
	              		<?php 	
	              		}
	              		?>
           		   </select>
		        </div>
				<div class="col-sm-2">
	              <select class="form-control" id="id_jurusan" name="id_jurusan"  onchange="submit();">
	              		<option value="">-Pilih Kompetensi Keahlian-</option>
	              		<?php 
	              		$sqljurusan = mysqli_query($con, "select * from ms_jurusan where aktif='1'");
	              		while($rowjurusan = mysqli_fetch_array($sqljurusan)){
	              		?>
	              		<option <?php if($id_jurusan== $rowjurusan['id']){echo "selected";}?> value="<?php echo $rowjurusan['id'];?>"><?php echo $rowjurusan['nama_jurusan'];?></option>
	              		<?php 	
	              		}
	              		?>
	              </select>
		        </div>
				<div class="col-sm-2">
	              <select class="form-control" id="id_kelas" name="id_kelas" onchange="submit();">
	              		<option value="">-Pilih Kelas-</option>
	              		<?php 
	              		$sqlkelas = mysqli_query($con, "select * from ms_kelas where aktif='1'");
	              		while($rowkelas = mysqli_fetch_array($sqlkelas)){
	              		?>
	              		<option <?php if($id_kelas == $rowkelas['id']){echo "selected";}?> value="<?php echo $rowkelas['id'];?>"><?php echo $rowkelas['kelas'];?></option>
	              		<?php 	
	              		}
	              		?>
	              </select>
		        </div>
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Pencarian:</b></p>
				</div>
				<div class="col-sm-3">
					<div class="input-group input-group-md">
						<input type="text" name="key" value="<?php echo $key;?>" class="form-control" placeholder="Masukkan Kode Siswa atau NAMA">
					  	<span class="input-group-btn">
			                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i> Tampil</button>
			            </span>
				    </div>
		        </div>
        	</div><br>
	      </form>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr class="bg-primary">
					<td width="3%">No</td>
					<td width="100px">Kode Siswa</td>
					<td width="100px">Nama Siswa</td>
					<td width="100px">Kelas</td>
					<td width="300px">Alamat</td>
					<td width="100px">No Telepon</td>
					<td width="100px">Total Tagihan(Rp.)</td>
				</tr>
				<?php 
				$sisa = 0;
				$no = 1;
				while($row = mysqli_fetch_array($query)){
					$tagihan= totalTagihan($row['id'], $con);
					$sisa +=$tagihan
				?>
				<tr>
					<td><?php echo $no++;?></td>
					<td><?php echo Highlight($row['nisn'], $key);?></td>
					<td><?php echo Highlight($row['nama'], $key);?></td>
					<td><?php echo kelasSiswa($row['id'], $con);?></td>
					<td><?php echo $row["alamat"];?></td>
					<td><?php echo $row["no_telp"];?></td>
					<td align="right"><?php echo cost($tagihan);?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="6" align="right"> Total :</td>
					<td align="right"><?php echo "Rp. ".cost($sisa); ?></td>
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