<?php 
session_start();
include "global/cek-session.php";
include "global/function.php";
$option = $_REQUEST['option'];
$act = $_REQUEST['act'];
$id = $_REQUEST['id']; 
$hal = $_REQUEST['hal']; 
$tgl = $_REQUEST['tgl']; 
if(empty($tgl)){
  $tgl = date("d/m/Y");
}
$key = mysqli_escape_string($con, $_REQUEST['key']);
$batas = 10;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $header;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="dist/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
  <?php include "menu.inc.php";	?>
  <!-- Full Width Column -->
  <div class="content-wrapper">
	 <?php 
	 if($option=='usermanager'){
		 include "usermanager.php";
	 }elseif($option=='periode'){
     include "periode.php";
   }elseif($option=='tingkat'){
     include "tingkat.php";
   }elseif($option=='kelas'){
     include "kelas.php";
   }elseif($option=='jurusan'){
     include "jurusan.php";
   }elseif($option=='siswa'){
     include "siswa.php";
   }elseif($option=='pembayaran'){
     include "pembayaran.php";
   }elseif($option=='trpembayaran'){
     include "trpembayaran.php";
   }elseif($option=='trangsuran'){
     include "trangsuran.php";
   }elseif($option=='tagihan-siswa'){
     include "tagihan-siswa.php";
   }elseif($option=='lap-pembayaran'){
     include "lap-pembayaran.php";
   }else{
     include "welcome.php";  
   }
	 ?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
     <?php echo $footer; ?> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<form name="formHidden" action="index.php?option=<?php echo $option;?>" method="POST">
	<input type="hidden" name="act" value="<?php echo $act;?>">
	<input type="hidden" name="id"  value="<?php echo $id;?>">
  <input type="hidden" name="key" value="<?php echo $key;?>">
	<input type="hidden" name="hal" value="<?php echo $hal;?>">
</form
<!-- ./wrapper -->
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!--datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="global/script.js"></script>
</body>
<script>

  $('.daterange-btn').daterangepicker(
  {
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
  }
)

//Date picker
$('.tgl').datepicker({
  format: 'dd/mm/yyyy',
  autoclose: true
})

 $('#id_siswa').select2({
    placeholder: 'Cari Siswa...',
    ajax: {
      url: 'listsiswa.php',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.nisn +" | "+item.nama +" | "+item.kelas,
              nisn: item.nisn,
              kelas: item.kelas,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

</script>
</html>
