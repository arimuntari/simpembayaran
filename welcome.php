<?php
$id_periode = periodeAktif($con);
$tgl1 = $_REQUEST['tgl1']; 
if(empty($tgl1)){
	$tgl1 = date("01/m/Y");
}
$tgl2 = $_REQUEST['tgl2']; 
if(empty($tgl2)){
	$tgl2 = date("d/m/Y");
}


$sql = "select tgl, SUM(total) as total FROM (
SELECT tgl_pembayaran AS tgl, total FROM tr_pembayaran 
UNION 
SELECT tgl_pembayaran_angsuran AS tgl, bayar FROM tr_pembayaran_angsuran ) tb_temp where tgl between '".tglConvert($tgl1,"/")."' and '".tglConvert($tgl2,"/")."' group by tgl ";
	$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query)){
	$tgl = explode(' ',$row['tgl'] );

	$kat[] = tglConvert($tgl[0]); 
	$data[] = (double)$row['total']; 
}
//var_dump($data);
?>
<script src="plugins/highchart/highcharts.js"></script>
<script src="plugins/highchart/exporting.js"></script>
<div class="container">
    <section class="content-header">
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
    </section>
	<section class="content">
	    <div class="box box-default">
	      <div class="box-body">
	      	<div class="row">
		      	<form method="post" class="form-horizontal" action="index.php">
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
	        <div class="chart">
                <div id="pembayaran" style="height: 420px; width: 100%;" height="250" width="510"></div>
            </div>
		  </div>
	      <!-- /.box-body -->
	    </div>
	    <!-- /.box -->
	</section>
</div>
<script type="text/javascript">
	Highcharts.chart('pembayaran', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Pendapatan Harian'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: <?Php echo json_encode($kat)?>
    },
    yAxis: {
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value ;
            }
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Pembayaran',
        data: <?Php echo json_encode($data)?>

    }]
});
</script>