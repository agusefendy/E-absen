<?php
  include "../include/config.php";
  include "../asset.php";
  include "../license/key.php";
  if($asset['live'] == 'N'){
    echo "<script> alert('Live Preview Tidak Diizinkan!'); window.location.href='../' </script>";
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
  <script type="text/javascript">
    
  </script>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
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
            <a href="../">
              <i class="nc-icon nc-key-25"></i>
              <p>Login</p>
            </a>
          </li>
          <li>
            <a href="../absen/">
              <i class="fa fa-video-camera"></i>
              <p>Absen Scanner</p>
            </a>
          </li>
          <li>
            <a href="../absen/manual">
              <i class="fa fa-pencil"></i>
              <p>Manual Absen</p>
            </a>
          </li>
        <?php if($asset['live'] == 'Y'){ ?>
          <li class="active ">
            <a href="#">
              <i class="fa fa-tv"></i>
              <p>Live Preview</p>
            </a>
          </li>
        <?php } ?>
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
            <a class="navbar-brand" href=""><i class="fa fa-tv"></i> Live Preview</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="">
                <select class="form-control" onchange="Pagination(1)" id="filter">
                  <option value="semua" selected>Semua</option>
                  <?php
                    $qs = mysqli_query($koneksi, "SELECT * from kelas");
                    while($r = mysqli_fetch_array($qs)){
                      echo "<option value='$r[idkelas]'>$r[kelas]</option>";
                    }
                   ?>
                   <option value="terlambat">Terlambat</option>
                </select>
              </div>
            </form>
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
              <h4><i class="fa fa-tv"></i> Live Preview Absensi</h4>
              <p class="card-category">E-Absen Application</p>
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <button id="play" class="btn btn-success" title="Mulai Preview"><i class="fa fa-play"></i></button>
              <button id="stop" style="display: none;" class="btn btn-danger" title="Stop Preview"><i class="fa fa-stop"></i></button>
              <div class="text-warning" id='pesan'><i class="fa fa-info-circle"></i> Live Preview Belum Dimulai</div>
                <div id="content">
                <?php include "content.php"; ?>
                </div>
              
            </div>
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
        var ter = $('#filter').val();
        $.ajax({
          url: 'content.php',
          type: 'POST',
          data: {page: page_number, filter: ter},
          success: function(response){
            $('#content').html(response);
          } 
        })
      }

      $('#play').click(function(){
        var auto_refresh = setInterval(
        function () {
           $('#content').load('content.php').fadeIn("slow");
        },5000);
        var gus = setInterval(function(){
          var ele = document.getElementById('pesan');
          ele.style.visibility = (ele.style.visibility == 'hidden' ? '' : 'hidden');
        }, 400);
        $('#play').css('display','none');
        $('#stop').css('display','block');
        $('#pesan').html('<i class="fa fa-info-circle"></i> Live Preview Berjalan');
        document.getElementById("filter").disabled = true;

        $('#stop').click(function(){
          clearInterval(auto_refresh);
          $('#play').css('display','block');
          $('#stop').css('display','none');
          $('#pesan').html('<i class="fa fa-info-circle"></i> Live Preview Belum Dimulai');
          document.getElementById("filter").disabled = false;
          clearInterval(gus);
        })
      })
  </script>
</body>

</html>
