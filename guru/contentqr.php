 <?php 
 include "../include/config.php";
  include "../asset.php";
  include "../license/key.php";
  include "../phpqrcode/qrlib.php";
  $idkelas = $_GET['en'];
  $page = (isset($_POST['page'])) ? $_POST['page'] : 1;
  $limit = 12;
  $no = (($page - 1) * $limit) + 1;
  $limit_start = ($page - 1) * $limit;
  if(isset($_POST['keyword'])){
    $keyword = $_POST['keyword'];
    $sql = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas' AND namasiswa LIKE '%$keyword%' ORDER BY namasiswa LIMIT $limit_start, $limit"); 
    //paging setting
    $aa = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM siswa where idkelas='$idkelas' AND namasiswa LIKE '%$keyword%'");
    $get_jumlah = mysqli_fetch_array($aa);
  }else{
    $sql = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas' ORDER BY namasiswa LIMIT $limit_start, $limit"); 
    //paging setting
    $aa = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM siswa where idkelas='$idkelas'");
    $get_jumlah = mysqli_fetch_array($aa);
  }
  $cek = mysqli_num_rows($sql);
  if($cek > 0){
  while ($data = mysqli_fetch_array($sql)){ ?>
<div class="col-md-4">
  <div class="card card-user">
    <div class="card-header">
      <h5 class="card-title"></h5>
    </div>
    <div class="card-body">
      <div class="col-md-12 text-center">
        <?php 
          $en = substr($data['enkripsi'],2,4);
          $string = $data['namasiswa'].$en;
          $file = str_replace(' ', "", $string);
          QRcode::png("$data[enkripsi]", "tmp/$file.png","H",7,4);
        echo "<img src='tmp/$file.png'><br>";
        echo ucwords("<h3> $data[namasiswa]</h3>");  ?>
        <button onclick="window.location.href='unduh-<?php echo "$file"; ?>'" class="btn btn-primary btn-round"><i class="nc-icon nc-cloud-download-93"></i> Unduh </button>
      </div>
    </div>
  </div>
</div>
  <?php } ?>
<div class="col-md-12">
  <!-- Pagination -->
  <ul class="pagination">
    <!-- LINK FIRST AND PREV -->
    <?php
    if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
    ?>
      <li class="disabled"><a href="#">First</a></li>
      <li class="disabled"><a href="#">&laquo;</a></li>
    <?php
    }else{ // Jika page bukan page ke 1
      $link_prev = ($page > 1)? $page - 1 : 1;
    ?>
      <li><a href="javascript:void(0);" onclick="Pagination(1)">First</a></li>
      <li><a href="javascript:void(0);" onclick="Pagination(<?php echo $link_prev; ?>)">&laquo;</a></li>
    <?php
    }
    ?>
    
    <!-- LINK NUMBER -->
    <?php
    $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
    $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
    
    for($i = $start_number; $i <= $end_number; $i++){
      $link_active = ($page == $i)? ' class="active"' : '';
    ?>
      <li<?php echo $link_active; ?>><a href="javascript:void(0);" onclick="Pagination(<?php echo "$i"; ?>)"><?php echo $i; ?></a></li>
    <?php
    }
    ?>
    
    <!-- LINK NEXT AND LAST -->
    <?php
    // Jika page sama dengan jumlah page, maka disable link NEXT nya
    // Artinya page tersebut adalah page terakhir 
    if($page == $jumlah_page){ // Jika page terakhir
    ?>
      <li class="disabled"><a href="#">&raquo;</a></li>
      <li class="disabled"><a href="#">Last</a></li>
    <?php
    }else{ // Jika Bukan page terakhir
      $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
    ?>
      <li><a href="javascript:void(0);" onclick="Pagination(<?php echo $link_next; ?>)">&raquo;</a></li>
      <li><a href="javascript:void(0);" onclick="Pagination(<?php echo $jumlah_page; ?>)">Last</a></li>
    <?php
    }
    ?>
  </ul>
</div>
<?php }else{ ?>
 <div class="col-md-12 text-center">
    <h2 class="text-center"><i>Data Tidak Ditemukan :(</i></h2>
  </div>
<?php } ?>