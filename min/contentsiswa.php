  <?php
include "../include/config.php";
include "../asset.php";
$idkelas = mysqli_real_escape_string($koneksi, $_GET['idkelas']);
$page = (isset($_POST['page'])) ? $_POST['page'] : 1;
$limit = 10;
$no = (($page - 1) * $limit) + 1;
$limit_start = ($page - 1) * $limit;
if(isset($_POST['keyword'])){
  $keyword = $_POST['keyword'];
  $q = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas' AND namasiswa LIKE '%$keyword%' ORDER BY namasiswa ASC LIMIT $limit_start, $limit");
  $cek = mysqli_num_rows($q);
  //paging setting
  $aa = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM siswa where idkelas='$idkelas' AND namasiswa LIKE '%$keyword%'");
  $get_jumlah = mysqli_fetch_array($aa);
}else{
  $q = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas' ORDER BY namasiswa ASC LIMIT $limit_start, $limit");
  $cek = mysqli_num_rows($q);
  //paging setting
  $aa = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM siswa where idkelas='$idkelas'");
  $get_jumlah = mysqli_fetch_array($aa);
}
if($cek > 0){
?>
<div class="table-responsive">
<button type="button" onclick="window.location.href='absensi-<?php echo "$idkelas"; ?>'" class="btn btn-info btn-round"> Absensi </button>
<button type="button" onclick="window.location.href='buatqr-<?php echo "$idkelas"; ?>'" class="btn btn-warning btn-round"> Buat Code Qr </button>
<table class="table">
  <thead class=" text-primary">
    <th> No Induk  </th>
    <th> Nama </th>
    <th> Jenis Kelasmin</th>
    <th> Alamat </th>
    <th> Opsi </th>
  </thead>
  <tbody>
   <?php
   $no = 0;
    while ($data = mysqli_fetch_array($q)){ ?>
      <tr>
        <td><?php echo ucwords("$data[noinduk]"); ?></td>
        <td><?php echo ucwords("$data[namasiswa]"); ?></td>
        <td><?php echo ucwords("$data[jksiswa]"); ?></td>
        <td><?php echo ucwords("$data[alamat]"); ?></td>
        <td>
          <form method="POST">
          <button type="button" class="btn btn-success" title="Edit" data-toggle="modal" data-target="#edit<?php echo $no; ?>"><i class="fa fa-edit"></i></button>
          
            <input type="hidden" name="idsiswa" value="<?php echo "$data[idsiswa]"; ?>">
            <button type="submit" name="hapus" class="btn btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
       <!-- Modal Edit-->
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
              <label> No Induk </label>
              <input type="number" name="noinduk" class="form-control" maxlength="11" value="<?php echo "$data[noinduk]"; ?>" required/><br>
              <label> Nama </label>
              <input type="text" name="namasiswa" class="form-control" maxlength="50" value="<?php echo "$data[namasiswa]"; ?>" required/><br>
              <label> Jenis Kelamin </label>
              <select name="jksiswa" class="form-control">
                <option><?php echo "$data[jksiswa]"; ?></option>
                <option>Laki Laki</option>
                <option>Perempuan</option>  
              </select><br>
              <label> Alamat </label>
              <textarea name="alamat" class="form-control"><?php echo "$data[alamat]"; ?></textarea> 
              <input type="hidden" name="idsiswa" value="<?php echo "$data[idsiswa]"; ?>">
            </div>
            <!-- footer modal -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <input type="submit" name="edit" value="Simpan" class="btn btn-primary">
            </div>
          </div>
        </div>
      </div>
      </form>
    <?php $no++; } ?>
  </tbody>
</table>
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
  <div class="text-center">
    <button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#tambah"> Tambah </button>
  </div>
</div>
<?php }else{ ?>
  <div class="col-md-12 text-center">
    <h2 class="text-center"><i>Data Tidak Ditemukan :(</i></h2>
     <button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#tambah"> Tambah Data</button>
  </div>
<?php } ?>
      <!-- Modal Tambah-->
      <form method="POST">
      <div id="tambah" class="modal fade" role="dialog">
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
              <label> No Induk </label>
              <input type="number" name="noinduk" class="form-control" maxlength="11" required/><br>
              <label> Nama </label>
              <input type="text" name="namasiswa" class="form-control" maxlength="50" required/><br>
              <label> Jenis Kelamin </label>
              <select name="jksiswa" class="form-control">
                <option>Laki Laki</option>
                <option>Perempuan</option>  
              </select><br>
              <label> Alamat </label>
              <textarea name="alamat" class="form-control"></textarea>                 
            </div>
            <!-- footer modal -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <input type="submit" name="tambah" value="Simpan" class="btn btn-primary">
            </div>
          </div>
        </div>
      </div>
      </form>
      <?php
        //Tambah Data
        if(isset($_POST['tambah'])){
          $noinduk = $_POST['noinduk'];
          $nama = $_POST['namasiswa'];
          $jk = $_POST['jksiswa'];
          $alamat = $_POST['alamat'];
          $aa = mysqli_query($koneksi, "SELECT MAX(idsiswa) as id from siswa");
          $bb = mysqli_fetch_array($aa);
          $res = $bb['id'];
          $plus = $res+1;
          $enkripsi = '8997008540367'.$plus;
          $aa = mysqli_query($koneksi, "INSERT INTO siswa(noinduk,namasiswa,enkripsi,jksiswa,alamat,idkelas) VALUES ('$noinduk','$nama','$enkripsi','$jk','$alamat','$idkelas')");
          if($aa){ ?>
            <script>
              swal({
                position: 'center',
                type: 'success',
                title: 'Berhasil Ditambahkan',
                showConfirmButton: false,
                timer: 2500
              })
            </script>
            <meta http-equiv="Refresh" content="3; URL=siswa-<?php echo "$idkelas"; ?>">
          <?php }else{ ?>
            <script>
              swal({
                position: 'center',
                type: 'error',
                title: 'Gagal Menambah Data :( , Silahkan Ulangi Kembali',
                showConfirmButton: false,
                timer: 2500
              })
            </script>
            <meta http-equiv="Refresh" content="3; URL=siswa-<?php echo "$idkelas"; ?>">
          <?php }
        }
        //Edit Data
        if(isset($_POST['edit'])){
          $idsiswa = $_POST['idsiswa'];
          $noinduk = $_POST['noinduk'];
          $nama = $_POST['namasiswa'];
          $jk = $_POST['jksiswa'];
          $alamat = $_POST['alamat'];
          $bb = mysqli_query($koneksi, "UPDATE siswa SET noinduk='$noinduk',namasiswa='$nama',jksiswa='$jk',alamat='$alamat' WHERE idsiswa='$idsiswa'");
          if($bb){ ?>
            <script>
              swal({
                position: 'center',
                type: 'success',
                title: 'Data Berhasil Diubah',
                showConfirmButton: false,
                timer: 2500
              })
            </script>
            <meta http-equiv="Refresh" content="3; URL=siswa-<?php echo "$idkelas"; ?>">
          <?php }else{ ?>
            <script>
              swal({
                position: 'center',
                type: 'error',
                title: 'Gagal Mengubah Data :( , Silahkan Ulangi Kembali',
                showConfirmButton: false,
                timer: 2500
              })
            </script>
            <meta http-equiv="Refresh" content="3; URL=siswa-<?php echo "$idkelas"; ?>">
          <?php }
        }
        //Hapus Data
        if(isset($_POST['hapus'])){
          $idsiswa = $_POST['idsiswa'];
          $ee = mysqli_query($koneksi, "SELECT * FROM siswa where idsiswa='$idsiswa'");
          $row = mysqli_fetch_array($ee);
          $en = substr($row['enkripsi'],2,4);
          $string = $row['namasiswa'].$en.".png";
          $file = str_replace(' ', "", $string);
          $namafile = "tmp/".$file;
          echo "<script> </script>";
          unlink($namafile);
          $dd = mysqli_query($koneksi, "DELETE FROM siswa where idsiswa='$idsiswa'");
          if($dd){ //echo "$namafile"; ?>
          <script>
              swal({
                position: 'center',
                type: 'success',
                title: 'Data Berhasil Dihapus',
                showConfirmButton: false,
                timer: 2500
              })
            </script>
            <meta http-equiv="Refresh" content="3; URL=siswa-<?php echo "$idkelas"; ?>">
          <?php }else{ ?>
            <script>
              swal({
                position: 'center',
                type: 'error',
                title: 'Gagal Menghapus :( , Silahkan Ulangi Kembali',
                showConfirmButton: false,
                timer: 2500
              })
            </script>
            <meta http-equiv="Refresh" content="3; URL=siswa-<?php echo "$idkelas"; ?>">
          <?php }
        }
      ?>