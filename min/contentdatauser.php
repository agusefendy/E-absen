<?php 
include "../include/config.php";
include "../asset.php";
?>
<table class="table">
<tr class="text-primary">
<th> Nama </th>
<th> Jenis Kelamin </th>
<th> Jabatan </th>
<th> Username </th>
<th> Pimpinan </th>
<th> Info </th>
<th class="text-center"> Aksi </th>
</tr>
<?php
if(isset($_POST['keyword'])){
  $keyword = $_POST['keyword'];
  $where = "WHERE namaguru LIKE '%$keyword%' OR jkguru LIKE '%$keyword%' OR jabatan LIKE '%$keyword%'";
}else{
  $where = '';
}

$page = (isset($_POST['page'])) ? $_POST['page'] : 1;
$limit = 10;
$no = (($page - 1) * $limit) + 1;
$limit_start = ($page - 1) * $limit;
$sql = mysqli_query($koneksi, "SELECT * from guru $where order by level asc LIMIT $limit_start, $limit");
$sq = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah from guru $where");
$get_jumlah = mysqli_fetch_array($sq);
$no = 0;
$cek = mysqli_num_rows($sql);
if($cek > 0){
while($data = mysqli_fetch_array($sql)){
?>
<tr>
  <td><?php echo ucwords("$data[namaguru]"); ?></td>
  <td><?php echo ucwords("$data[jkguru]"); ?></td>
  <td><?php echo ucwords("$data[jabatan]"); ?></td>
  <td class="barcode"><?php echo ucwords("$data[username]"); ?></td>
  <td>
  <?php
    if($data['level'] == 'admin'){
      echo "All Area";
    }else{
      $gu = mysqli_query($koneksi, "SELECT * FROM kelas WHERE idguru='$data[idguru]'");
      while($ru = mysqli_fetch_array($gu)){
        echo ucwords("$ru[kelas], ");
      }
    }
  ?>
  </td>
  <td><?php echo ucwords("$data[info]"); ?></td>
  <?php
    if($data['level'] == 'admin'){ ?>
      <td class="text-center"><h5> <a href="reset-datauser-<?php echo "$data[idguru]"; ?>" title="Reset Password"><i class="fa fa-refresh"></i></a> </h5></td>
    <?php }else{ ?>
      <td class="text-center"><h5>
        <a href="" title="Edit" data-toggle="modal" data-target="#edit<?php echo $no; ?>"><i class="fa fa-edit"></i></a>
        <a href="datauser-<?php echo "$data[idguru]"; ?>" title="Hapus"><i class="fa fa-trash"></i></a>
        <a href="reset-datauser-<?php echo "$data[idguru]"; ?>" title="Reset Password"><i class="fa fa-refresh"></i></a>
      </h5></td>
    <?php } ?>
</tr>
<form method="POST">
<div id="edit<?php echo $no; ?>" class="modal fade" role="dialog">
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
    <input type="hidden" name="idguru" value="<?php echo "$data[idguru]"; ?>">
     <label> Nama </label>
      <input type="text" name="namaguru" class="form-control" maxlength="50" value="<?php echo "$data[namaguru]"; ?>" required/><br>
      <label> Jenis Kelamin </label>
      <select name="jkguru" class="form-control">
        <?php
        if($data['jkguru'] == 'Laki Laki'){
            echo "<option>$data[jkguru]</option> ";
            echo "<option>Perempuan</option> ";
          }else{
            echo "<option>$data[jkguru]</option> ";
            echo "<option>Laki Laki</option>";
          } ?>                                                    
      </select><br>
      <label> Jabatan </label>
      <input type="text" name="jabatan" class="form-control" maxlength="25" value="<?php echo "$data[jabatan]"; ?>" required/><br>
       <label> Username </label>
      <input type="text" name="username" class="form-control" maxlength="50" value="<?php echo "$data[username]"; ?>" required/><br>
      <label>Info</label>
      <textarea class="form-control" name="info"><?php echo "$data[info]"; ?></textarea>
  </div>
  <!-- footer modal -->
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
    <input type="submit" name="edit" class="btn btn-primary" value="Simpan">
  </div>
</div>
 </div>
</div>
</form>
<?php $no++; } 
}else{ ?>
  <tr>
    <td colspan="7"><b>Data Tidak Tersedia</b></td>
  </tr>
<?php } ?>
</table>
<?php if($cek > 0){ ?>
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
  }
    ?>
  </ul>
<div class="col-md-12 text-center">
<button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#tuser">Tambah User</button>
<button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#tmin">Tambah Admin</button>     
</div>
<?php
  //reset password
  if(isset($_GET['reset'])){
    $reset = $_GET['reset'];
    $show = mysqli_query($koneksi, "SELECT * from guru where idguru='$reset'");
    $ro = mysqli_fetch_array($show);
    $username = $ro['username'];
    $password = mysqli_real_escape_string($koneksi, md5($username.'eabsen'));
    $sql = mysqli_query($koneksi, "UPDATE guru SET password='$password' where idguru='$reset'");

    if($sql){ ?>
       <script>
          swal({
            position: 'center',
            type: 'success',
            title: 'Reset Berhasil',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }else{ ?>
      <script>
          swal({
            position: 'center',
            type: 'error',
            title: 'Reset Gagal :(',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }
  }

?>
<?php
  if(isset($_POST['edit'])){
    $idguru = $_POST['idguru'];
    $namaguru = $_POST['namaguru'];
    $jkguru = $_POST['jkguru'];
    $jabatan = $_POST['jabatan'];
    $username = $_POST['username'];
    $info = $_POST['info'];
    $sql = mysqli_query($koneksi, "UPDATE guru SET namaguru='$namaguru', jkguru='$jkguru', jabatan='$jabatan', username='$username', info='$info' where idguru='$idguru'");
    if($sql){ ?>
       <script>
          swal({
            position: 'center',
            type: 'success',
            title: 'Edit Berhasil',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }else{ ?>
      <script>
          swal({
            position: 'center',
            type: 'error',
            title: 'Edit Gagal :(',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }
  }

  if(isset($_GET['idguru'])){
    $idguru = mysqli_real_escape_string($koneksi, $_GET['idguru']);

    $q = mysqli_query($koneksi, "UPDATE kelas SET idguru='0' where idguru='$idguru'");
    $sql = mysqli_query($koneksi, "DELETE from guru where idguru='$idguru'");

    if($sql){ ?>
       <script>
          swal({
            position: 'center',
            type: 'success',
            title: 'Data Berhasil Dihapus',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }else{ ?>
      <script>
          swal({
            position: 'center',
            type: 'error',
            title: 'Data Gagal Dihapus :(',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }
  }
?>
<!-- Modal Tambah User-->
<form method="POST">
<div id="tuser" class="modal fade" role="dialog">
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
        <label> Nama </label>
        <input type="text" name="namaguru" class="form-control" maxlength="50" required/><br>
        <label> Jenis Kelamin </label>
        <select name="jkguru" class="form-control">
          <option>Laki Laki</option>
          <option>Perempuan</option>  
        </select><br>
        <label> Jabatan </label>
        <input type="text" name="jabatan" class="form-control" maxlength="25" required/><br>
        <p class="text-primary">*Password Default : eabsen</p>              
      </div>
      <!-- footer modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <input type="submit" name="tuser" value="Simpan" class="btn btn-primary">
      </div>
    </div>
  </div>
</div>
</form>
<?php
  if(isset($_POST['tuser'])){
    $namaguru = $_POST['namaguru'];
    $jkguru = $_POST['jkguru'];
    $jabatan = $_POST['jabatan'];
    $qr = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY idguru DESC LIMIT 1");
    $rq = mysqli_fetch_array($qr);
    $di = $rq['idguru'];
    $tam = $di + 1;
    $username = "10019413".$tam;
    $password = md5('eabsen');
    $sql = mysqli_query($koneksi, "INSERT into guru(namaguru,jkguru,jabatan,info,username,password,level)
      VALUES ('$namaguru','$jkguru','$jabatan','Hey There! I Am Using E-absen','$username','$password','guru')");
    if($sql){ ?>
       <script>
          swal({
            position: 'center',
            type: 'success',
            title: 'User Berhasil Ditambahkan',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }else{ ?>
      <script>
          swal({
            position: 'center',
            type: 'error',
            title: 'Gagal Menambahkan User :(',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }
  }
?>
<!-- Modal Tambah Admin-->
<form method="POST">
<div id="tmin" class="modal fade" role="dialog">
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
        <label> Nama </label>
        <input type="text" name="namaguru" class="form-control" maxlength="50" required/><br>
        <label> Jenis Kelamin </label>
        <select name="jkguru" class="form-control">
          <option>Laki Laki</option>
          <option>Perempuan</option>  
        </select><br>
        <label> Jabatan </label>
        <input type="text" name="jabatan" class="form-control" maxlength="25" value="Admin E-Absen" required/><br>
        <p class="text-primary">*Password Default : admineabsen</p>  
      </div>
      <!-- footer modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <input type="submit" name="tmin" value="Simpan" class="btn btn-primary">
      </div>
    </div>
  </div>
</div>
</form>
 <?php
  if(isset($_POST['tmin'])){
    $namaguru = $_POST['namaguru'];
    $jkguru = $_POST['jkguru'];
    $jabatan = $_POST['jabatan'];
    $qr = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY idguru DESC LIMIT 1");
    $rq = mysqli_fetch_array($qr);
    $di = $rq['idguru'];
    $tam = $di + 1;
    $username = "10019413".$tam;
    $password = md5('admineabsen');
    $sql = mysqli_query($koneksi, "INSERT into guru(namaguru,jkguru,jabatan,info,username,password,level)
      VALUES ('$namaguru','$jkguru','$jabatan','Hey There! I Am Using E-absen','$username','$password','admin')");
    if($sql){ ?>
       <script>
          swal({
            position: 'center',
            type: 'success',
            title: 'Admin Berhasil Ditambahkan',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }else{ ?>
      <script>
          swal({
            position: 'center',
            type: 'error',
            title: 'Gagal Menambahkan Admin :(',
            showConfirmButton: false,
            timer: 4500
          })
          </script>
          <meta http-equiv="Refresh" content="3; URL=datauser">
    <?php }
  }
?>