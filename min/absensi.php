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
    //echo "<script> alert('admin'); </script>";
    header('location:logout');
  }else if($level == ''){
    //echo "<script> alert('level'); </script>";
   header('location:logout');
  }else{}
?>
 <?php 
    //insert keterangan tidak absen
    if(isset($_POST['submit'])){
      $id = $_POST['post'];
      $val = $_POST['val'];
      $ket = $_POST['ket'];
      $count = count($id);

      for($i=0; $i<$count; $i++){
        $qery = mysqli_query($koneksi, "INSERT into absen(tglabsen,jammasuk,jamkeluar,jamistirahat,kembali,ket,idsiswa) 
          Values ('$val','$ket[$i]','$ket[$i]','$ket[$i]','$ket[$i]','$ket[$i]','$id[$i]')");
      }
    }
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
  <style type="text/css">
  .pagination {
  display: inline-block;
  padding-left: 0;
  margin: 20px 0;
  border-radius: 4px;
}
.pagination > li {
  display: inline;
}
.pagination > li > a,
.pagination > li > span {
  position: relative;
  float: left;
  padding: 6px 12px;
  margin-left: -1px;
  line-height: 1.42857143;
  color: #337ab7;
  text-decoration: none;
  background-color: #fff;
  border: 1px solid #ddd;
}
.pagination > li:first-child > a,
.pagination > li:first-child > span {
  margin-left: 0;
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
}
.pagination > li:last-child > a,
.pagination > li:last-child > span {
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
}
.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
  z-index: 2;
  color: #23527c;
  background-color: #eee;
  border-color: #ddd;
}
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
  z-index: 3;
  color: #fff;
  cursor: default;
  background-color: #337ab7;
  border-color: #337ab7;
}
.pagination > .disabled > span,
.pagination > .disabled > span:hover,
.pagination > .disabled > span:focus,
.pagination > .disabled > a,
.pagination > .disabled > a:hover,
.pagination > .disabled > a:focus {
  color: #777;
  cursor: not-allowed;
  background-color: #fff;
  border-color: #ddd;
}
.pagination-lg > li > a,
.pagination-lg > li > span {
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.3333333;
}
.pagination-lg > li:first-child > a,
.pagination-lg > li:first-child > span {
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
}
.pagination-lg > li:last-child > a,
.pagination-lg > li:last-child > span {
  border-top-right-radius: 6px;
  border-bottom-right-radius: 6px;
}
.pagination-sm > li > a,
.pagination-sm > li > span {
  padding: 5px 10px;
  font-size: 12px;
  line-height: 1.5;
}
.pagination-sm > li:first-child > a,
.pagination-sm > li:first-child > span {
  border-top-left-radius: 3px;
  border-bottom-left-radius: 3px;
}
.pagination-sm > li:last-child > a,
.pagination-sm > li:last-child > span {
  border-top-right-radius: 3px;
  border-bottom-right-radius: 3px;
}
</style>
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
           <li>
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
                $idkelass = $idkelas;
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
                  <div style="float: right;">
                  <select id="select" class="form-control" onchange="Pagination(1)">
                    <?php $tg = date('Y-m-d'); 
                      if(isset($_POST['submit'])){
                        $sel = $_POST['sel'];
                        if($sel == $tg){ ?>
                          <option value="<?php echo $tg; ?>" selected>Hari Ini</option>
                        <?php }else{ ?>
                          <option value="<?php echo $sel; ?>" selected><?php echo $sel; ?></option>
                          <option value="<?php echo $tg; ?>">Hari Ini</option>
                        <?php }
                      }else{
                    ?>
                      <option value="<?php echo $tg; ?>" selected>Hari Ini</option>
                  <?php } ?>
                    <?php for($i=01; $i<=31; $i++){ 
                        if($i <= '9'){
                          $var = 0;
                        }else{
                          $var = '';
                        }
                      ?>
                      <option value="<?php echo $var.$i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                  </select>
                  </div>
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
                  <div id='content'><?php include "contentabsensi.php"; ?></div>
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
  <script type="text/javascript">

      $(document).ready(function(){
        Pagination(1);
      })

      function Pagination(page_number){    
        var tes = $('#select').val();
        $.ajax({
          type  : 'POST',
          url   : 'contentabsensi.php?idkelas=<?php echo $idkelass; ?>',
          data  : {page: page_number, select: tes},
          success : function(response){
              $('#content').html(response);
          }
        })
      
    }
  </script>
</body>

</html>
