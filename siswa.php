<?php 
$table = "ms_siswa";
$id_periode = periodeAktif($con);
$where = "b.id_periode = '$id_periode'";
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

$link ="&id_tingkat=$id_tingkat&id_jurusan=$id_jurusan&id_kelas=$id_kelas&key=$key";
if($act == 'aktif'){
	$query = mysqli_query($con, "select * from $table where id = '$id'");
	$row = mysqli_fetch_array($query);
	if($row['aktif']=='1'){
		$aktif = 0;
	}else{
		$aktif = 1;
	}
	$queryaktif = mysqli_query($con, "update $table set aktif = '$aktif' where id = '$id'");
}

if($act == 'del'){
	//echo "delete from ms_siswa_kelas where id_siswa = '$id' and id_periode='$id_periode'";
	$query = mysqli_query($con, "delete from ms_siswa_kelas where id_siswa = '$id' and id_periode='$id_periode'");
	$query = mysqli_query($con, "delete from $table where id = '$id'");
	echo mysqli_errno($con);
}
?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-group"></i> Siswa</h1>
  </section>
  <?php 
  if($act == 'add'){
  	?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <h3 class="box-title">Tambah Data</h3>
      </div>
      <div class="box-body">
		<form method="POST" autocomplete="off" action="insert-siswa.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<div class="form-group">
              <label for="nisn">Kode Siswa *</label>
              <input type="text" class="form-control" id="nisn" name="nisn" readonly required placeholder="Masukkan Kode Siswa">
            </div>
			<div class="form-group">
              <label for="nama">Nama Siswa *</label>
              <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan Nama Siswa">
            </div>
			<div class="form-group">
              <label for="alamat">Alamat </label>
              <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat">
            </div>
			<div class="form-group">
              <label for="tmp_lahir">Tempat, Tgl Lahir</label>
              <div class="row">
                <div class="col-xs-3">
                  <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir"  placeholder="Tempat Lahir">
                </div>
                <div class="col-xs-4">
                  <input type="text" class="form-control tgl" id="tgl_lahir" name="tgl_lahir"  placeholder="Tanggal Lahir">
                </div>
              </div>
            </div>
			<div class="form-group">
              <label for="alamat">No. Telp </label>
              <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No. Telp">
            </div>
			<div class="form-group">
              <label for="id_tingkat">Tingkat Pendidikan*</label>
              <div class="row">
                <div class="col-xs-3">
                    <select class="form-control" id="id_tingkat" name="id_tingkat" required>
	              		<option value="">-Pilih Tingkat-</option>
	              		<?php 
	              		$sqltingkat = mysqli_query($con, "select * from ms_tingkat where aktif='1'");
	              		while($rowtingkat = mysqli_fetch_array($sqltingkat)){
	              		?>
	              		<option value="<?php echo $rowtingkat['id'];?>"><?php echo $rowtingkat['tingkat'];?></option>
	              		<?php 	
	              		}
	              		?>
           		   </select>
                </div>
                <div class="col-xs-4">
	              <select class="form-control" id="id_jurusan" name="id_jurusan" onchange="$('.xxx').load('generate-kode.php?id='+this.value)" required>
	              		<option value="">-Pilih Kompetensi Keahlian-</option>
	              		<?php 
	              		$sqljurusan = mysqli_query($con, "select * from ms_jurusan where aktif='1'");
	              		while($rowjurusan = mysqli_fetch_array($sqljurusan)){
	              		?>
	              		<option value="<?php echo $rowjurusan['id'];?>"><?php echo $rowjurusan['nama_jurusan'];?></option>
	              		<?php 	
	              		}
	              		?>
	              </select>
                </div>
                <div class="col-xs-4">
	              <select class="form-control" id="id_kelas" name="id_kelas" required>
	              		<option value="">-Pilih Kelas-</option>
	              		<?php 
	              		$sqlkelas = mysqli_query($con, "select * from ms_kelas where aktif='1'");
	              		while($rowkelas = mysqli_fetch_array($sqlkelas)){
	              		?>
	              		<option value="<?php echo $rowkelas['id'];?>"><?php echo $rowkelas['kelas'];?></option>
	              		<?php 	
	              		}
	              		?>
	              </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="actBatal();" class="btn btn-danger">Batal</button>
		</form>
      </div>
    </div>
  </section>
  <div class="xxx"></div>
  <?php 
  }else if($act == 'edit'){
  	$query = mysqli_query($con, "select b.*,a.* from $table a left join ms_siswa_kelas b on a.id = b.id_siswa  where a.id='$id' order by b.id_periode desc ");
  	$row = mysqli_fetch_array($query);
  	//var_dump($row);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <h3 class="box-title">Tambah Data</h3>
      </div>
      <div class="box-body">
		<form method="POST"  autocomplete="off" action="update-siswa.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<div class="form-group">
              <label for="nisn">Kode Siswa *</label>
              <input type="text" class="form-control" id="nisn" name="nisn" readonly required placeholder="Masukkan Kode Siswa" value="<?php echo $row['nisn'];?>">
            </div>
			<div class="form-group">
              <label for="nama">Nama Siswa *</label>
              <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan Nama Siswa" value="<?php echo $row['nama'];?>">
            </div>
			<div class="form-group">
              <label for="alamat">Alamat </label>
              <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" value="<?php echo $row['alamat'];?>">
            </div>
			<div class="form-group">
              <label for="tmp_lahir">Tempat, Tgl Lahir *</label>
              <div class="row">
                <div class="col-xs-3">
                  <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir"  placeholder="Tempat Lahir" value="<?php echo $row['tmp_lahir'];?>">
                </div>
                <div class="col-xs-4">
                  <input type="text" class="form-control tgl" id="tgl_lahir" name="tgl_lahir"  placeholder="Tanggal Lahir" value="<?php echo tglConvert($row['tgl_lahir']);?>">
                </div>
              </div>
            </div>
			<div class="form-group">
              <label for="alamat">No. Telp </label>
              <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No. Telp" value="<?php echo $row['no_telp'];?>">
            </div>
			<div class="form-group">
              <label for="id_tingkat">Tingkat Pendidikan*</label>
              <div class="row">
                <div class="col-xs-3">
                    <select class="form-control" id="id_tingkat" name="id_tingkat" required>
	              		<option value="">-Pilih Tingkat-</option>
	              		<?php 
	              		$sqltingkat = mysqli_query($con, "select * from ms_tingkat where aktif='1'");
	              		while($rowtingkat = mysqli_fetch_array($sqltingkat)){
	              		?>
	              		<option <?php if($row['id_tingkat'] == $rowtingkat['id']){echo "selected";}?> value="<?php echo $rowtingkat['id'];?>"><?php echo $rowtingkat['tingkat'];?></option>
	              		<?php 	
	              		}
	              		?>
           		   </select>
                </div>
                <div class="col-xs-4">
	              <select class="form-control" id="id_jurusan" name="id_jurusan" required >
	              		<option value="">-Pilih Kompetensi Keahlian-</option>
	              		<?php 
	              		$sqljurusan = mysqli_query($con, "select * from ms_jurusan where aktif='1'");
	              		while($rowjurusan = mysqli_fetch_array($sqljurusan)){
	              		?>
	              		<option <?php if($row['id_jurusan'] == $rowjurusan['id']){echo "selected";}?> value="<?php echo $rowjurusan['id'];?>"><?php echo $rowjurusan['nama_jurusan'];?></option>
	              		<?php 	
	              		}
	              		?>
	              </select>
                </div>
                <div class="col-xs-4">
	              <select class="form-control" id="id_kelas" name="id_kelas" required>
	              		<option value="">-Pilih Kelas-</option>
	              		<?php 
	              		$sqlkelas = mysqli_query($con, "select * from ms_kelas where aktif='1'");
	              		while($rowkelas = mysqli_fetch_array($sqlkelas)){
	              		?>
	              		<option <?php if($row['id_kelas'] == $rowkelas['id']){echo "selected";}?> value="<?php echo $rowkelas['id'];?>"><?php echo $rowkelas['kelas'];?></option>
	              		<?php 	
	              		}
	              		?>
	              </select>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="actBatal();" class="btn btn-danger">Batal</button>
		</form>
      </div>
    </div>
  </section>
  <?php
  }else {
	if(empty($hal)){
		$hal = 1;
		$start = 0;
	}else{
		$start = $batas * ($hal-1);
	}
	$sql = "select b.*, a.* from $table a inner join ms_siswa_kelas b on b.id_siswa  = a.id where $where order by a.id desc limit $start, $batas";
	//echo $sql;
	$query = mysqli_query($con, $sql);

	$sql_total = mysqli_query($con, "select * from $table a inner join ms_siswa_kelas b on b.id_siswa  = a.id where $where");
	$jmldata = mysqli_num_rows($sql_total);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <div class="row">
			<div class="col-md-2">
				<button onclick="actAdd();" class="btn btn-info btn-block"> <i class="fa fa-plus"></i> Tambah </button>
			</div>
			<div class="col-md-2">
				<button onclick="document.location.reload();" class="btn btn-default  btn-block"> <i class="fa fa-refresh"></i> Refresh </button>
			</div>
			<div class="col-md-2">
				<button onclick="window.open('excel-siswa.php?id_tingkat=<?php echo $id_tingkat;?>&id_jurusan=<?php echo $id_jurusan;?>&id_kelas=<?php echo $id_kelas;?>');" class="btn btn-success btn-block"> <i class="fa fa-file-excel-o"></i> Export Excel </button>
			</div>
			<div class="col-md-6" style="text-align:right;font-size:16px;vertical-align:bottom;">
				<b>Total Data: <?php echo $jmldata;?></b>
			</div>
		  </div>
      </div>
      <div class="box-body">
	      	<div class="panel box box-success">
	          <div class="box-header with-border">
	            <h4 class="box-title">
	              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="">
	                Format Input siswa dengan excel
	              </a>
	            </h4>
	          </div>
	          <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="">
	            <div class="box-body">
	            	<div class="row">
	            		<form action="excel-siswa-proses.php" method="POST" enctype="multipart/form-data">
		            		<div class="col-md-3">
		            			<button type="button" onclick="window.open('excel-siswa-download.php?id_tingkat=<?php echo $id_tingkat;?>&id_jurusan=<?php echo $id_jurusan;?>&id_kelas=<?php echo $id_kelas;?>');" class="btn btn-success btn-sm btn-block"> <i class="fa fa-file-excel-o"></i> Download Format Excel </button>
		            		</div>
		            		<div class="col-md-3">
		            		</div>
		            		<div class="col-md-4">
		            			<input type="file" name="file" style="float:right">
		            		</div>
		            		<div class="col-md-2">
		            			<button type="submit" class="btn btn-primary btn-sm btn-block">Submit</button>
		            		</div>
	            		</form>
	            	</div>
	            </div>
	          </div>
	        </div>
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
					<td width="10%">Kode Siswa</td>
					<td width="25%">Nama</td>
					<td width="10%">No. Tlp</td>
					<td width="10%">Kelas</td>
					<td width="7%">Status</td>
					<td width="10%" colspan="3"></td>
				</tr>
				<?php 
				$no = 0;
				while($row = mysqli_fetch_array($query)){
					$no++;
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo Highlight($row['nisn'], $key);?></td>
					<td><?php echo Highlight($row['nama'], $key);?></td>
					<td><?php echo $row['no_telp'];?></td>
					<td><?php echo kelasSiswa($row['id'], $con);?></td>
					<td><?php echo cekAktif($row['aktif']);?></td>
					<td align="center">
						<button onclick="actEdit(<?php echo $row['id'];?>);" class="btn btn-warning btn-xs" title="Mengedit Data"><i class="fa fa-pencil"></i></button>
							&nbsp;&nbsp;
						<button onclick="actAktif(<?php echo $row['id'];?>);" class="btn btn-success btn-xs" title="Aktif/Nonaktif Data"><i class="fa fa-check"></i></button>
							&nbsp;&nbsp;
						<button onclick="actDel(<?php echo $row['id'];?>);" class="btn btn-danger btn-xs" title="Menghapus Data"><i class="fa fa-trash"></i></button>
						</td>
				</tr>
				<?php 
				}
				?>
			</table>
			<?php pagination($jmldata, "index.php?option=$option$link",  $batas, $hal)?>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <?php }?>
  <!-- /.content -->
</div>
    <!-- /.container -->