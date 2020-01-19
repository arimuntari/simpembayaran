<?php 
$table = "ms_jurusan";
$where = " 1 = 1";
if(!empty($key)){
	$where .= " and nama_jurusan like '%$key%'";
}

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
	$query = mysqli_query($con, "delete from $table where id = '$id'");
}
?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-book"></i> Kompetensi Keahlian</h1>
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
		<form method="POST" action="insert-jurusan.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<div class="form-group">
              <label for="nama_jurusan">Nama Kompentensi Keahlian *</label>
              <input type="text" class="form-control" id="nama_jurusan" required name="nama_jurusan" placeholder="Masukkan Nama Kompentensi Keahlian">
            </div>
			<div class="form-group">
              <label for="singkatan">Singkatan *</label>
              <input type="text" class="form-control" id="singkatan" required name="singkatan" placeholder="Masukkan Singkatan">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="actBatal();" class="btn btn-danger">Batal</button>
		</form>
      </div>
    </div>
  </section>
  <?php 
  }else if($act == 'edit'){
  	$query = mysqli_query($con, "select * from $table where id='$id'");
  	$row = mysqli_fetch_array($query);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <h3 class="box-title">Tambah Data</h3>
      </div>
      <div class="box-body">
		<form method="POST" action="update-jurusan.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<div class="form-group">
              <label for="nama_jurusan">Nama Kompentensi Keahlian *</label>
              <input type="text" class="form-control" id="nama_jurusan" required name="nama_jurusan" placeholder="Masukkan Nama Kompentensi Keahlian" value="<?php echo $row['nama_jurusan'];?>">
            </div>
			<div class="form-group">
              <label for="singkatan">Singkatan *</label>
              <input type="text" class="form-control" id="singkatan" required name="singkatan" placeholder="Masukkan Singkatan" value="<?php echo $row['singkatan'];?>">
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
	$sql = "select * from $table where $where  order by id desc limit $start, $batas";
	$query = mysqli_query($con, $sql);
	$jmldata = mysqli_num_rows($query);
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
			<div class="col-md-8" style="text-align:right;font-size:16px;vertical-align:bottom;">
				<b>Total Data: <?php echo $jmldata;?></b>
			</div>
		  </div>
      </div>
      <div class="box-body">
      	<div class="row">
	      	<form method="post" class="form-horizontal" action="index.php?option=<?php echo $option;?>">
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Pencarian:</b></p>
				</div>
				<div class="col-sm-5">
					<div class="input-group input-group-md">
						<input type="text" name="key" value="<?php echo $key;?>" class="form-control" placeholder="Masukkan Nama Kompentensi Keahlian">
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
					<td width="35%">Nama Kompentensi Keahlian</td>
					<td width="15%">Singkatan</td>
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
					<td><?php echo Highlight($row['nama_jurusan'], $key);?></td>
					<td><?php echo Highlight($row['singkatan'], $key);?></td>
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
			<?php pagination($jmldata, "index.php?option=$option",  $batas, $hal)?>
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