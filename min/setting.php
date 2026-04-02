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
  }else if($level == 'guru'){
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
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
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
    <div class="sidebar" data-color="dark" data-active-color="danger">
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
          <li>
            <a href="index">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="datauser">
              <i class="nc-icon nc-single-02"></i>
              <p>Data User</p>
            </a>
          </li>
          <li>
            <a href="user">
              <i class="nc-icon nc-circle-10"></i>
              <p>User Profile</p>
            </a>
          </li>
           <li class="active ">
            <a href="setting">
              <i class="nc-icon nc-settings-gear-65"></i>
              <p>Setting</p>
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
            <a class="navbar-brand" href=""><i class="nc-icon nc-settings-gear-65"></i> Setting</a>
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
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title"></h5>
              </div>
              <div class="card-body">
                <h5 class="text-center"> *Sistem Absen </h5><hr>
                <?php
                  $c = mysqli_query($koneksi, "SELECT * from asset where idasset='1'");
                  $d = mysqli_fetch_array($c);
                ?>
                <form method="POST">
                  <div class="row">
                  <div class="col-md-4 pr-1">
                <label>Tipe Kelompok</label>
                <input type="text" name="tipekelompok" class="form-control" maxlength="25" value="<?php echo "$d[tipekelompok]"; ?>" required/><br></div>
                <div class="col-md-4 pr-1">
                <label>Tipe Absen</label>
                <input type="text" name="tipeabsen" class="form-control" maxlength="25" value="<?php echo "$d[tipeabsen]"; ?>" required/><br></div>
                <div class="col-md-4 pr-1">
                <label> Jam Datang </label>
                <input type="time" name="jd" class="form-control" value="<?php echo "$d[waktudatang]"; ?>" required/><br></div>
                </div>
                <div class="row">
                <div class="col-md-2 pr-1">
                <label>Istirahat</label><br>
                <?php 
                  if($d['istirahat'] == 'Y'){ ?>
                    <input type="radio" name="istirahat" value="Y" checked="">Y
                    <input type="radio" name="istirahat" value="N">N<br><br>
                  <?php }else{ ?>
                    <input type="radio" name="istirahat" value="Y">Y
                    <input type="radio" name="istirahat" value="N" checked="">N<br><br>
                  <?php }
                ?></div>
                 <div class="col-md-2 pr-1">
                <label>Live Preview</label><br>
                <?php 
                  if($d['live'] == 'Y'){ ?>
                    <input type="radio" name="live" value="Y" checked="">Y
                    <input type="radio" name="live" value="N">N<br><br>
                  <?php }else{ ?>
                    <input type="radio" name="live" value="Y">Y
                    <input type="radio" name="live" value="N" checked="">N<br><br>
                  <?php }
                ?></div>
                </div>
                <h5 class="text-center">*Personal</h5><hr>
                <div class="row">
                  <div class="col-md-4 pr-1">
                <label>Title</label>
                <input type="text" name="title" class="form-control" maxlength="100" value="<?php echo "$d[title]"; ?>" required/><br>
                </div>
                <div class="col-md-4 pr-1">
                <label>Title Website</label>
                <input type="text" name="titlewebsite" class="form-control" maxlength="25" value="<?php echo "$d[titlewebsite]"; ?>" required/><br></div>
                <div class="col-md-4 pr-1">
                <label>Footer</label>
                <input type="text" name="footer" class="form-control" maxlength="50" value="<?php echo "$d[footer]"; ?>" required/><br><br></div>
                </div>
                <input type="submit" class="btn btn-primary btn-round" name="submit" value="Simpan">
                </form>
                <?php
                if(isset($_POST['submit'])){
                  //sistem absen
                  $tipekelompok = $_POST['tipekelompok'];
                  $tipeabsen = $_POST['tipeabsen'];
                  $waktudatang = $_POST['jd'];
                  $istirahat = $_POST['istirahat'];
                  $live = $_POST['live'];
                  //personal
                  $title = $_POST['title'];
                  $titlewebsite = $_POST['titlewebsite'];
                  $footer = $_POST['footer'];
                  $sql = mysqli_query($koneksi, "UPDATE asset set tipekelompok='$tipekelompok', tipeabsen='$tipeabsen', waktudatang='$waktudatang', istirahat='$istirahat', live='$live', title='$title', titlewebsite='$titlewebsite', footer='$footer' where idasset='1'");
                  if($sql){ ?>
                     <script>
                        swal({
                          position: 'center',
                          type: 'success',
                          title: 'Berhasil Disimpan',
                          showConfirmButton: false,
                          timer: 4500
                        })
                        </script>
                        <meta http-equiv="Refresh" content="3; URL=setting">
                  <?php }else{ ?>
                     <script>
                        swal({
                          position: 'center',
                          type: 'error',
                          title: 'Gagal Disimpan :(',
                          showConfirmButton: false,
                          timer: 4500
                        })
                        </script>
                        <meta http-equiv="Refresh" content="3; URL=setting">
                  <?php }
                }
              ?>
              </div>
            </div>
          </div>
        </div>
      </div >
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
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
</body>

</html>
