<?php 
$listmenu = array(
              "transaksi" => array("trpembayaran"),
              "laporan" => array("tagihan-siswa", "lap-pembayaran"),
              "master" => array("siswa","tingkat","jurusan","kelas","pembayaran"),
              "setting" => array("usermanager","periode"),
            );
?>
<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">    
  		<div class="navbar-header">   
  		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
  			 <i class="fa fa-bars"></i>
  		  </button>
  		</div>
        <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
        <li <?php if(empty($option)){ echo "class='active'";}?>><a href="index.php"><i class="fa fa-dashboard"></i>&nbsp; <span>Dashboard</span></a></li>
        <li class="dropdown <?php if(in_array($option, $listmenu['transaksi'])){ echo "active";}?>">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-dollar"></i><span> Transaksi</span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">    
            <li><a href="?option=trpembayaran"><i class="fa fa-money"></i>&nbsp; Pembayaran</a></li>
            <li><a href="?option=trangsuran"><i class="fa fa-money"></i>&nbsp; Angsuran</a></li>
          </ul>
        </li>
        <li class="dropdown <?php if(in_array($option, $listmenu['laporan'])){ echo "active";}?>">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-file"></i><span> Laporan</span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">    
            <li><a href="?option=tagihan-siswa"><i class="fa fa-file"></i>&nbsp; Tagihan Siswa</a></li>
            <li><a href="?option=lap-pembayaran"><i class="fa fa-file"></i>&nbsp; Laporan Pembayaran</a></li>
          </ul>
        </li>
  			<li class="dropdown <?php if(in_array($option, $listmenu['master'])){ echo "active";}?>">
  				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
  					<i class="fa fa-edit"></i><span> Master Data</span>
  					<span class="caret"></span>
  				</a>
  				<ul class="dropdown-menu">		
            <li><a href="?option=siswa"><i class="fa fa-group"></i>&nbsp; Siswa</a></li>
            <li class="dropdown-submenu">
              <a href="#"><i class="fa fa-graduation-cap"></i>&nbsp;Pendidikan</a>
              <ul class="dropdown-menu">
                <li><a href="?option=tingkat"><i class="fa fa-list-ol"></i>&nbsp; Tingkat</a></li>  
                <li><a href="?option=jurusan"><i class="fa fa-book"></i>&nbsp; Kompetensi Keahlian</a></li>
                <li><a href="?option=kelas"><i class="fa fa-home"></i>&nbsp; Kelas</a></li>
              </ul>
            </li>
            <li><a href="?option=pembayaran"><i class="fa fa-credit-card"></i>&nbsp; Pembayaran</a></li>
  				</ul>
  			</li>
        <li class="dropdown <?php if(in_array($option, $listmenu['setting'])){ echo "active";}?>">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-cog"></i><span> Settting</span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">    
            <li><a href="?option=usermanager"><i class="fa fa-user-plus"></i>&nbsp; Manajemen User</a></li> 
            <li><a href="?option=periode"><i class="fa fa-calendar"></i>&nbsp; Periode</a></li>
          </ul>
        </li>
  		  </ul>
      </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['ses_nama'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/avatar.png" class="img-circle" alt="User Image">
                <p>	<?php echo $_SESSION['ses_nama'];?> <small><i class="fa fa-circle text-success"></i> Online</small></p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                 <!-- <a href="?option=akun" class="btn btn-default btn-flat">Akun Saya</a>-->
                </div>
                <div class="pull-right">
                  <a href="global/logout.php" class="btn btn-default btn-flat">LogOut</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
        <!-- /.navbar-custom-menu -->
  	</div>
      <!-- /.container-fluid -->
  </nav>
</header>