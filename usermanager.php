<?php 
$table = "usermanager";
$where = " 1 = 1";
if(!empty($key)){
	$where .= " and nama like '%$key%' or username like '%$key%'";
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
    <h1><i class="fa fa-user-plus"></i> Manajemen User</h1>
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
		<form method="POST" action="insert-usermanager.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<div class="form-group">
              <label for="nama">Nama *</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
            </div>
			<div class="form-group">
              <label for="username">Username *</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
            </div>
			<div class="form-group">
              <label for="password">Password *</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
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
		<form method="POST" action="update-usermanager.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<div class="form-group">
              <label for="nama">Nama *</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?php echo $row['nama'];?>">
            </div>
			<div class="form-group">
              <label for="username">Username *</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?php echo $row['username'];?>">
            </div>
			<div class="form-group">
              <label for="password">Password *</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" value="<?php echo $row['password'];?>">
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
	$sql = "select * from $table where $where limit $start, $batas";
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
						<input type="text" name="key" value="<?php echo $key;?>" class="form-control" placeholder="Masukkan Nama atau username">
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
					<td width="15%">Nama</td>
					<td width="15%">Username</td>
					<td width="15%">Password</td>
					<td width="7%">Status</td>
					<td width="15%">Terakhir Login</td>
					<td width="10%" colspan="3"></td>
				</tr>
				<?php 
				$no = 0;
				while($row = mysqli_fetch_array($query)){
					$no++;
					
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td>
						<a onclick="$('#hide<?php echo $no;?>').toggle(); $('#show<?php echo $no;?>').toggle();">
							<?php echo  Highlight($row['nama'], $key);?>
						</a>
					</td>
					<td><?php echo Highlight($row['username'], $key);?></td>
					<td>
						<span id="hide<?php echo $no;?>" style="display:none;"><?php echo $row['password'];?></span>
						<span id="show<?php echo $no;?>">•••••••••</span>
					</td>
					<td><?php echo cekAktif($row['aktif']);?></td>
					<td><?php echo tglWaktu($row['terakhir_login']);?></td>
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