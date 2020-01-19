<?php 
$table = "tr_pembayaran_angsuran";
$where = "  tgl_pembayaran_angsuran = '".tglConvert($tgl, '/')."'";
$id_periode = periodeAktif($con);

if(!empty($key)){
	$where .= " and nama_siswa like '%$key%'";
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
    <h1><i class="fa fa-money"></i> Transaksi Angsuran</h1>
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
		<form method="POST" autocomplete="off" action="insert-trangsuran.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
		              <label for="id_siswa">Nama Siswa </label>
		              <select class="form-control select2" name="id_siswa" id="id_siswa" onchange="$('#id_pembayaran').load('list-angsuran.php?id='+this.value);loadPage();" style="width: 100%;" Requidred>
		               </select>
		            </div>
	        	</div>
				<div class="col-md-4">
					<div class="form-group">
		              <label for="tgl">Pembayaran *</label>
		               <select class="form-control select2" name="id_pembayaran" onchange="loadPage(this.value);" id="id_pembayaran" style="width: 100%;" Requidred>
		                 <option value="">- Pilih Pembayaran-</option>
		               </select>
		            </div>
	        	</div>
				<div class="col-md-3">
					<div class="form-group">
		              <label for="tgl">Tanggal *</label>
		              <input type="text" class="form-control tgl" id="tgl" name="tgl" required placeholder="Masukkan Tanggal" value=<?php echo date("d/m/Y");?>>
		            </div>
	        	</div>
            </div>
            <div class="row">
            	<div class="col-md-12">
            		<div class="table-responsive"  id="table-list">
            			<?php 
            			 include "list-angsuranbayar.php";
            			?>
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
	$sql = "select a.*, b.nama, c.*, a.id, b.nisn from $table a inner join ms_siswa b on a.id_siswa = b.id inner join ms_pembayaran c on a.id_pembayaran =c.id where  $where  order by a.id desc limit $start, $batas";
	//echo $sql;
	$query = mysqli_query($con, $sql);

	$sql_total = mysqli_query($con, "select * from $table a inner join ms_siswa b on a.id_siswa = b.id where $where ");
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
					<p class="form-control-static"><b>Tanggal:</b></p>
				</div>
				<div class="col-sm-3">
					<div class="input-group input-group-md">
						<input type="text" name="tgl" value="<?php echo $tgl;?>" class="form-control tgl" autocomplete="off" placeholder="Masukkan Tanggal Angsuran">
				    </div>
		        </div>
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Pencarian:</b></p>
				</div>
				<div class="col-sm-5">
					<div class="input-group input-group-md">
						<input type="text" name="key" value="<?php echo $key;?>" class="form-control" placeholder="Masukkan Kode Angsuran">
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
					<td width="15%">Nama Pembayaran</td>
					<td width="6%">Harga</td>
					<td width="19%">Nama Siswa</td>
					<td width="9%">Tanggal Angsuran</td>
					<td width="6%">Bayar</td>
					<td width="6%">Total Bayar</td>
					<td width="10%" colspan="3"></td>
				</tr>
				<?php 
				$no = 0;
				while($row = mysqli_fetch_array($query)){
					$no++;
					$tgl = explode(' ', $row['tgl_pembayaran_angsuran']);
					$sqlbayar = mysqli_query($con, "select sum(bayar) as total from tr_pembayaran_angsuran where id_pembayaran ='".$row['id_pembayaran']."' and id_siswa = '".$row['id_siswa']."' and id <= '".$row['id']."'");
					$rowbayar = mysqli_fetch_array($sqlbayar);
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $row['nama_pembayaran'];?></td>
					<td  align="right"><?Php echo "Rp. ".cost($row['harga']);?></td>
					<td><?Php echo  $row['nisn']." ".$row['nama'];?></td>
					<td><?Php echo tglConvert($tgl[0], '-', '/');?></td>
					<td  align="right"><?Php echo cost($row['bayar']);?></td>
					<td align="right"><?php echo "Rp. ".cost($rowbayar['total']);?></td>
					<td align="center">
						<button onclick="window.open('cetak_trangsuran.php?id=<?php echo $row['id'];?>');" class="btn btn-default btn-xs" title="Print Data"><i class="fa fa-print"></i></button>
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
    <!-- /.modal -->
    <script>
    	function loadPage(){
    		id_siswa = $('#id_siswa').val();
    		id_bayar = $('#id_pembayaran').val();
    		$('#table-list').load('list-angsuranbayar.php?id_bayar='+id_bayar+'&id_siswa='+id_siswa);
    	}
    </script>