<?php session_start();
  include "../include/config.php";
  include "../asset.php";
  include "../license/key.php";
  $idguru = mysqli_real_escape_string($koneksi, $_SESSION['idguru']);
  $a = mysqli_query($koneksi, "SELECT * from guru where idguru='$idguru'");
  $b = mysqli_fetch_array($a);
  $level = $b['level'];
  if($idguru == ''){
    //echo "<script> alert('session'); </script>";
    header('location:logout');
  }else if($level == 'admin'){
    //echo "<script> alert('admin'); </script>";
    header('location:logout');
  }else if($level == ''){
    //echo "<script> alert('level'); </script>";
   header('location:logout');
  }else{}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    <?php echo "$asset[title]"; ?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/sweetalert2.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
   <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/sweetalert2.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="blue" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
          </div>
        </a>
        <a href="" class="simple-text logo-normal">
          <?php echo ucwords("$asset[titlewebsite]"); ?>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="index">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="user">
              <i class="nc-icon nc-single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
           <li>
            <a href="logout">
              <i class="nc-icon nc-button-power"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href=""><i class="nc-icon nc-bank"></i> Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <i class="nc-icon nc-circle-10"> <?php echo ucwords("$b[namaguru]"); ?></i>
          </div>
      </nav>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-lg">

  <canvas id="bigDashboardChart"></canvas>


</div> -->
     <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <?php
                $idkelas = $_GET['idkelas'];
                date_default_timezone_set('Asia/Jakarta');
                $now = date("Y-m-d");
                $sql = mysqli_query($koneksi, "SELECT * from kelas where idkelas='$idkelas'");
                $kelas = mysqli_fetch_array($sql);
              ?>
                <h4 class="card-title"> <i class="nc-icon nc-single-copy-04"></i> Absensi <?php echo ucwords("$asset[tipeabsen]"); ?></h4>
                <p class="card-category"><?php echo "$kelas[kelas]" ?></p>
              </div>
              <div class="card-body">
                
                <div class="table-responsive">
                  <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#myModal">Filter</button>
                  <form action="absensifilter" method="GET">
                  <div id="myModal" class="modal fade" role="dialog">
                     <div class="modal-dialog">
                    <!-- konten modal-->
                    <div class="modal-content">
                      <!-- heading modal -->
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                      </div>
                      <!-- body modal -->
                      <div class="modal-body">
                      <input type="hidden" name="en" value="<?php echo $idkelas; ?>">
                       <select name="bln" class="form-control">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="12">November</option>
                        <option value="12">Desember</option>
                        </select><br>
                        <select name="thn" class="form-control">
                        <?php
                        $mulai= date('Y') - 50;
                        for($i = $mulai;$i<$mulai + 100;$i++){
                            $sel = $i == date('Y') ? ' selected="selected"' : '';
                            echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                        }
                        ?>
                        </select>
                      </div>
                      <!-- footer modal -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="SET">
                      </div>
                    </div>
                     </div>
                  </div>
                  <?php
                  $q = mysqli_query($koneksi, "SELECT * from kelas natural join siswa natural join absen where idkelas='$idkelas' and tglabsen='$now'");
                  $cek = mysqli_num_rows($q);
                  if($cek > 0){
                  ?>
                  <label>Hari Ini</label>
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="text-primary"> No Induk </th>
                        <th class="text-primary"> Nama</th>
                        <th class="text-center text-primary"> D </th>
                        <th class="text-center text-primary"> I </th>
                        <th class="text-center text-primary"> K </th>
                        <th class="text-center text-primary"> P </th>
                        <th class="text-primary">Ket</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php
                      while ($data = mysqli_fetch_array($q)){
                        if($data['ket'] == 'Terlambat'){
                          $class = 'class="text-danger"';
                        }else{
                          $class = '';
                        }
                       ?>
                        <tr <?php echo $class; ?>>
                          <td><?php echo "$data[noinduk]"; ?></td>
                          <td><?php echo ucwords("$data[namasiswa]"); ?></td>
                          <td class="text-center"><?php echo "$data[jammasuk]"; ?></td>
                          <td class="text-center"><?php echo "$data[jamistirahat]"; ?></td>
                          <td class="text-center"><?php echo "$data[kembali]"; ?></td>
                          <td class="text-center"><?php echo "$data[jamkeluar]"; ?></td>
                          <td><?php echo "$data[ket]"; ?></td>                          
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <div class="text-success">
                  <i> Ket. </i><br>
                  D : Datang <br>
                  I : Istirahat <br>
                  K : Kembali <br>
                  P : Pulang
                  </div>
                  <div class="text-center">
                    <button type="button" onclick="window.location.href='laporanharian?en=<?php echo $idkelas; ?>&kls=<?php echo "$kelas[kelas]"; ?>'" class="btn btn-warning btn-round"><i class="fa fa-file-excel-o"></i> Buat Laporan</button>
                  </div>
                </div>
                <?php }else{ ?>
                  <div class="col-md-12 text-center">
                    <h2 class="text-center"><i>Data Tidak Ditemukan :(</i></h2>
                  </div>
                <?php } ?> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                2019, made with <i class="fa fa-heart heart"></i> by <?php echo ucwords("$asset[footer]"); ?> || <i>Version 1.0</i>
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
 
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
</body>

</html>
