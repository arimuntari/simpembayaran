<?php 
$table = "ms_pembayaran";

$id_periode = $_REQUEST['id_periode'];
if(empty($id_periode)){
	$id_periode = periodeAktif($con);
}
$where = " id_periode = $id_periode";

if(!empty($key)){
	$where .= " and nama_pembayaran like '%$key%'";
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
	$query = mysqli_query($con, "delete from ms_pembayaran_jurusan where id_pembayaran = '$id'");
	$query = mysqli_query($con, "delete from ms_pembayaran_tingkat where id_pembayaran = '$id'");
	$query = mysqli_query($con, "delete from $table where id = '$id'");
}
?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-credit-card"></i> Pembayaran</h1>
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
		<form method="POST" autocomplete="off" action="insert-pembayaran.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<div class="form-group">
              <label for="nama_pembayaran">Nama Pembayaran *</label>
              <input type="text" class="form-control" id="nama_pembayaran" name="nama_pembayaran" required placeholder="Masukkan Nama Pembayaran">
            </div>
			<div class="form-group">
              <label for="harga">Harga *</label>
              <input type="text" class="form-control" id="harga" name="harga" required placeholder="Masukkan Harga">
            </div>
			<div class="form-group">
              <label for="tipe">Jenis Pembayaran </label>
              <div class="row">
                <div class="col-xs-8">
	              <select name="tipe" id="tipe" class="form-control" onchange="cekAngsuran();">
	              	<option value="0">Sekali Bayar</option>
	              	<option value="1">Bulanan</option>
	              	<option value="2">Angsuran</option>
	              </select>
          		</div>
                <div class="col-xs-4 jumlah_angsuran hide">
                  <input type="text" class="form-control" id="jumlah_angsuran" name="jumlah_angsuran"  placeholder="Masukkan Jumlah Angsuran">
                </div>
          	  </div>
            </div>
			<div class="form-group">
              <label for="id_tingkat">Tingkat Pendidikan*</label>
              <div class="row">
                <div class="col-xs-6">
                    <select class="form-control" id="id_tingkat" name="id_tingkat" required>
	              		<option value="0">Semua Tingkat</option>
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
                <div class="col-xs-6">
	              <select class="form-control" id="id_jurusan" name="id_jurusan" required>
	              		<option value="0">Semua Kompetensi Keahlian</option>
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
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="actBatal();" class="btn btn-danger">Batal</button>
		</form>
      </div>
    </div>
  </section>
  <?php 
  }else if($act == 'edit'){
  	$query = mysqli_query($con, "select * from ms_pembayaran where id = '$id'");
  	$row = mysqli_fetch_array($query);
  	//var_dump($row);
  ?>
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
		  <h3 class="box-title">Tambah Data</h3>
      </div>
      <div class="box-body">
		<form method="POST"  autocomplete="off" action="update-pembayaran.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<div class="form-group">
              <label for="nama_pembayaran">Nama Pembayaran *</label>
              <input type="text" class="form-control" id="nama_pembayaran" name="nama_pembayaran" required placeholder="Masukkan Nama Pembayaran" value="<?php echo $row['nama_pembayaran'];?>">
            </div>
			<div class="form-group">
              <label for="harga">Harga *</label>
              <input type="text" class="form-control" id="harga" name="harga" required placeholder="Masukkan Harga" value="<?php echo $row['harga'];?>">
            </div>
			<div class="form-group">
              <label for="tipe">Jenis Pembayaran </label>
              <div class="row">
                <div class="col-xs-8">
	              <select name="tipe" id="tipe" class="form-control" onchange="cekAngsuran();">
	              	<option value="0" <?php if($row["tipe"]==0){echo "selected";}?>>Sekali Bayar</option>
	              	<option value="1" <?php if($row["tipe"]==1){echo "selected";}?>>Bulanan</option>
	              	<option value="2" <?php if($row["tipe"]==2){echo "selected";}?>>Angsuran</option>
	              </select>
          		</div>
                <div class="col-xs-4 jumlah_angsuran <?php if($row['tipe']!=2){echo "hide";}?>">
                  <input type="text" class="form-control" id="jumlah_angsuran" name="jumlah_angsuran"  placeholder="Masukkan Jumlah Angsuran">
                </div>
          	  </div>
            </div>
			<div class="form-group">
              <label for="id_tingkat">Tingkat Pendidikan*</label>
              <div class="row">
                <div class="col-xs-6">
                    <select class="form-control" id="id_tingkat" name="id_tingkat" required>
	              		<option value="0">Semua Tingkat</option>
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
                <div class="col-xs-6">
	              <select class="form-control" id="id_jurusan" name="id_jurusan" required>
	              		<option value="0">Semua Keahlian</option>
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
	$sql = "select * from $table where $where  order by id asc limit $start, $batas";
	$query = mysqli_query($con, $sql);

	$sql_total = mysqli_query($con, "select * from $table where $where");
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
			<div class="col-md-8" style="text-align:right;font-size:16px;vertical-align:bottom;">
				<b>Total Data: <?php echo $jmldata;?></b>
			</div>
		  </div>
      </div>
      <div class="box-body">
      	<div class="row">
	      	<form method="post" class="form-horizontal" action="index.php?option=<?php echo $option;?>">
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Periode:</b></p>
				</div>
				<div class="col-sm-2">
					<select class="form-control" name="id_periode" onchange="submit();">
						<?php 
						$sqlperiode = mysqli_query($con, "select * from ms_periode order by id desc");
						while($rowperiode = mysqli_fetch_array($sqlperiode)){
						?>
						<option value="<?php echo $rowperiode['id'];?>" <?php if($id_periode==$rowperiode['id'] ){echo "selected";}?>><?php echo $rowperiode['nama_periode'];?></option>
					<?php }?>
					</select>
		        </div>
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Pencarian:</b></p>
				</div>
				<div class="col-sm-5">
					<div class="input-group input-group-md">
						<input type="text" name="key" value="<?php echo $key;?>" class="form-control" placeholder="Masukkan Nama Pembayaran">
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
					<td width="18%">Nama Pembayaran</td>
					<td width="9%">Harga</td>
					<td width="6%">Tipe</td>
					<td width="7%">Tingkat</td>
					<td width="6%">Jurusan</td>
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
					<td><?php echo Highlight($row['nama_pembayaran'], $key)." ".getPeriode($id_periode, $con);?></td>
					<td align="right"><?php echo "Rp. ".cost($row['harga']);?></td>
					<td><?php echo cekTipe($row['tipe'], $row['jumlah_angsuran']);?></td>
					<td><?php echo getPembayaranTingkat($row['id'], $con);?></td>
					<td><?php echo getPembayaranJurusan($row['id'], $con);?></td>
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
<script>
	function cekAngsuran(){
    	var tipe = $("#tipe").val();
       if(tipe==2){
       	  $("#jumlah_angsuran").val("");
       	  $(".jumlah_angsuran").removeClass("hide");
       }else{
       	  $("#jumlah_angsuran").val("");
       	  $(".jumlah_angsuran").addClass("hide");
       }
    }
</script>