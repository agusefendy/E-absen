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
          <li>
            <a href="index">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="active ">
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
            <a class="navbar-brand" href=""><i class="nc-icon nc-single-02"></i> User Profile</a>
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
          <div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <img src="../assets/img/damir-bosnjak.jpg" alt="...">
              </div>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="../assets/img/logo-small.png" alt="...">
                    <h5 class="title"><?php echo ucwords("$b[namaguru]"); ?>
                    <?php if($b['jkguru'] == 'Laki Laki'){ ?>
                        <i class="fa fa-male"></i>
                      <?php }else{ ?>
                        <i class="fa fa-female"></i>
                      <?php } ?>
                    </h5>
                  </a>
                  <p class="description">
                    <?php echo ucwords("$b[jabatan]"); ?>
                  </p>
                </div>
                <p class="description text-center">
                  "<?php echo ucwords("$b[info]"); ?>"
                </p>
              </div>
              <div class="card-footer">
                <hr>
                <div class="button-container">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 ml-auto mr-auto">
                      <h5>E-Absen Application
                        <br>
                        <label>1.0</label>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit Profile</h5>
              </div>
              <div class="card-body">
                <form method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo "$b[namaguru]"; ?>" maxlength="50" required/>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" maxlength="25" value="<?php echo "$b[username]" ?>" maxlength="50">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jkguru" class="form-control">
                          <option><?php echo "$b[jkguru]"; ?></option>
                          <option>Laki Laki</option>
                          <option>Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" placeholder="Jabatan" value="<?php echo "$b[jabatan]"; ?>" disabled>
                      </div>
                    </div>
                  </div>                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Info</label>
                        <textarea name="info" class="form-control textarea"><?php echo "$b[info]"; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="upprofile" class="btn btn-primary btn-round">Update Profile</button>
                      <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#myModal">Ganti Password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        if(isset($_POST['upprofile'])){
          $nama = $_POST['nama'];
          $username = mysqli_real_escape_string($koneksi, $_POST['username']);
          $jkguru = $_POST['jkguru'];
          $info = $_POST['info'];

          $sql = mysqli_query($koneksi, "UPDATE guru SET namaguru='$nama', jkguru='$jkguru', username='$username', info='$info' where idguru='$idguru'");
          if($sql){ ?>
            <script>
              swal({
                position: 'center',
                type: 'success',
                title: 'Update Profile Berhasil',
                showConfirmButton: false,
                timer: 4500
              })
              </script>
              <meta http-equiv="Refresh" content="3; URL=user">
          <?php }else{ ?>
               <script>
                  swal({
                    position: 'center',
                    type: 'error',
                    title: 'Update Profile Gagal :(',
                    showConfirmButton: false,
                    timer: 4500
                  })
              </script>
              <meta http-equiv="Refresh" content="3; URL=user">
          <?php }
        }
      ?>
      <!-- Modal -->
      <form method="POST">
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
              <label>Password Lama</label>
              <input type="password" name="passlama" class="form-control" required/><br>
              <label>Password Baru</label>
              <input type="password" name="passbaru" class="form-control" required/>
            </div>
            <!-- footer modal -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <input type="submit" name="uppass" class="btn btn-primary" value="Simpan">
            </div>
          </div>
        </div>
      </div>
      </form>
      <?php
        if(isset($_POST['uppass'])){
          $passlama = mysqli_real_escape_string($koneksi, md5($_POST['passlama']));
          $passbaru = mysqli_real_escape_string($koneksi, md5($_POST['passbaru']));

          $sql = mysqli_query($koneksi, "SELECT * FROM guru where idguru='$idguru' and password='$passlama'");
          $cek = mysqli_num_rows($sql);
          if($cek == 1){
            $q = mysqli_query($koneksi, "UPDATE guru SET password='$passbaru' where idguru='$idguru'");
            if($q){ ?>
               <script>
                  swal({
                    position: 'center',
                    type: 'success',
                    title: 'Berhasil Mengubah Password',
                    showConfirmButton: false,
                    timer: 2500
                  })
              </script>
            <?php }else{ ?>
               <script>
                  swal({
                    position: 'center',
                    type: 'error',
                    title: 'Gagal Mengubah Password :(',
                    showConfirmButton: false,
                    timer: 2500
                  })
              </script>
            <?php }
          }else{ ?>
             <script>
                  swal({
                    position: 'center',
                    type: 'error',
                    title: 'Password Salah!',
                    showConfirmButton: false,
                    timer: 2500
                  })
              </script>
          <?php }
        }
      ?>
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
