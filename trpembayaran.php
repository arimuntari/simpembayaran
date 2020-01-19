<?php 
$table = "tr_pembayaran";
$where = "  tgl_pembayaran = '".tglConvert($tgl, '/')."'";
$id_periode = periodeAktif($con);

if(!empty($key)){
	$where .= " and kode_pembayaran like '%$key%' or nama like '%$key%'";
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
	$query = mysqli_query($con, "delete from tr_pembayaran_detil where id_trpembayaran = '$id'");
	$query = mysqli_query($con, "delete from $table where id = '$id'");
}
?>
 
<div class="container">
  <section class="content-header">
    <h1><i class="fa fa-money"></i> Transaksi Pembayaran</h1>
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
		<form method="POST" autocomplete="off" action="insert-trpembayaran.php" enctype="multipart/form-data">
			<input type="hidden" name="table" value="<?php echo $table;?>">
			<input type="hidden" name="option" value="<?php echo $option;?>">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
		              <label for="nama_pembayaran">Kode Pembayaran *</label>
		              <input type="text" class="form-control" id="nama_pembayaran" name="nama_pembayaran" required placeholder="Masukkan Kode Pembayaran" value="<?php echo kodePembayaran($con);?>">
		            </div>
					
	        	</div>
				<div class="col-md-6">
					<div class="form-group">
		              <label for="id_siswa">Nama Siswa </label>
		               <select class="form-control select2" name="id_siswa" id="id_siswa" onchange="loadPage(this.value);" style="width: 100%;" Requidred>
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
            		<button type="button" class="btn btn-xs btn-success" onclick="popUpModal($('#id_siswa').val());">Pembayaran...</button>
            		<div class="table-responsive"  id="table-list">
            			<?php 
            			 include "list-pembayaran.php";
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
	$sql = "select a.*, b.nama, b.nisn from $table a inner join ms_siswa b on a.id_siswa = b.id where $where  order by a.id desc limit $start, $batas";
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
						<input type="text" name="tgl" value="<?php echo $tgl;?>" class="form-control tgl" autocomplete="off" placeholder="Masukkan Tanggal Pembayaran">
				    </div>
		        </div>
	      		<div class="col-sm-1">
					<p class="form-control-static"><b>Pencarian:</b></p>
				</div>
				<div class="col-sm-5">
					<div class="input-group input-group-md">
						<input type="text" name="key" value="<?php echo $key;?>" class="form-control" placeholder="Masukkan Kode Pembayaran">
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
					<td width="8%">Kode Pembayaran</td>
					<td width="9%">Kode Siswa</td>
					<td width="19%">Nama Siswa</td>
					<td width="9%">Tanggal Pembayaran</td>
					<td width="9%">Total</td>
					<td width="10%" colspan="3"></td>
				</tr>
				<?php 
				$no = 0;
				while($row = mysqli_fetch_array($query)){
					$no++;
					$tgl = explode(' ', $row['tgl_pembayaran']);
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo Highlight($row['kode_pembayaran'], $key);?></td>
					<td><?Php echo $row['nisn'];?></td>
					<td><?Php echo $row['nama'];?></td>
					<td><?Php echo tglConvert($tgl[0], '-', '/');?></td>
					<td align="right"><?php echo "Rp. ".cost($row['total']);?></td>
					<td align="center">
						<button onclick="window.open('cetak_trpembayaran.php?id=<?php echo $row['id'];?>');" class="btn btn-default btn-xs" title="Print Data"><i class="fa fa-print"></i></button>
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
 <div class="modal fade" id="modal-default" style="width:100%">
      <div class="modal-dialog" style="width:900px;">
        <div class="modal-content" >
          <div class="modal-body" id="modal-page">
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<script>
	function popUpModal(val){
		//alert(val);
		if(val=='' || val ==null){
			alert("Anda Belum Memilih Siswa!!");
		}else{
			$('#modal-default').modal();
		}
	}  
	function loadPage(val){
		$('#modal-page').load('list-tagihan.php?id='+val);
		$('#table-list').load('list-pembayaran.php');
	}

</script>