<?php  
include "../include/config.php";
include "../asset.php"; ?>
<table class="table">
  <tr class="text-primary">
    <th> QR Code </th>
    <th> INFO </th>
    <th> Datang </th>
    <?php if($asset['istirahat'] == 'Y'){ ?>
    <th> Istirahat </th>
    <th> Kembali </th>
    <?php } ?>
    <th> Pulang </th>
    <th> Ket </th>
  </tr>
<?php
  $page = (isset($_POST['page'])) ? $_POST['page'] : 1;
  $limit = 15;
  $no = (($page - 1) * $limit) + 1;
  $limit_start = ($page - 1) * $limit;
  date_default_timezone_set('Asia/Jakarta');
  $now = date('Y-m-d'); 
  //filter
  if(isset($_POST['filter'])){
    $filter = $_POST['filter'];
    if($filter == 'semua'){
      $where = '';
    }else if($filter == 'terlambat'){
      $where = "AND absen.ket='terlambat' ";
    }else{
      $where = "AND kelas.idkelas='$filter' ";
    }

  }else{
    $where = '';
  }
  $sql = mysqli_query($koneksi, "SELECT * from kelas natural join siswa natural join absen where tglabsen='$now' $where order by jammasuk desc LIMIT $limit_start, $limit");
  $cek = mysqli_num_rows($sql);
  if($cek > 0){
  while($data = mysqli_fetch_array($sql)){
    $ket = $data['ket'];
    if($ket == 'Terlambat'){
      $class = 'class="text-danger"';
    }else{
      $class = '';
    }
      $en = substr($data['enkripsi'],2,4);
      $string = $data['namasiswa'].$en;
      $file = str_replace(' ', "", $string);
?>
  <tr <?php echo $class; ?>>
    <td><?php echo "<img src='../min/tmp/$file.png' width='80px' height='80px'><br>"; ?></td>
    <td><?php echo ucwords("<br>Nama : <b>$data[namasiswa]</b><br> $asset[tipekelompok] : <b>$data[kelas]</b>"); ?></td>
    <td><br><?php echo ucwords("$data[jammasuk]"); ?></td>
    <?php if($asset['istirahat'] == 'Y'){ ?>
    <td><br><?php echo ucwords("$data[jamistirahat]"); ?></td>
    <td><br><?php echo ucwords("$data[kembali]"); ?></td>
    <?php } ?>
    <td><br><?php echo ucwords("$data[jamkeluar]"); ?></td>
    <td><br><?php echo ucwords("$data[ket]"); ?></td>
  </tr>
<?php } ?>
 
<?php }else{ ?>
  <tr><td colspan="7"><i>Belum Ada Absen Hari Ini </i></td></tr>
<?php } ?>
</table>
<?php
  $hi = date("Y-m-d");
  $zz = mysqli_query($koneksi, "SELECT * from absen where tglabsen='$hi'");
  $yy = mysqli_num_rows($zz);
?>
<div class="text-success"><?php echo "$yy $asset[tipeabsen]"; ?> Sudah Absen</div>
<?php
  $xx = mysqli_query($koneksi, "SELECT * from siswa where idsiswa NOT IN (SELECT idsiswa from absen where tglabsen='$hi')");
  $vv = mysqli_num_rows($xx);
?>
<div class="text-danger"><?php echo "$vv $asset[tipeabsen]"; ?> Belum Absen</div>
<?php 
  $w = mysqli_query($koneksi, "SELECT * from siswa");
  $x = mysqli_num_rows($w);
?>
<div class="text-info"><?php echo "Total $asset[tipeabsen] : $x"; ?></div>
<?php if($cek > 0){ ?>
<div style="float: right;">
 <!-- Pagination -->
  <ul class="pagination">
    <!-- LINK FIRST AND PREV -->
    <?php
    $aa = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM kelas natural join siswa natural join absen where tglabsen='$now' $where");
    $get_jumlah = mysqli_fetch_array($aa);
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
      <li<?php echo $link_active; ?>><a href="javascript:void(0);" onclick="Pagination(<?php echo $i; ?>)"><?php echo $i; ?></a></li>
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
<?php } ?>