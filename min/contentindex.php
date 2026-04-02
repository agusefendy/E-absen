<?php
include "../include/config.php";
include "../asset.php";
  $page = (isset($_POST['page'])) ? $_POST['page'] : 1;
  $limit = 12;
  $no = (($page - 1) * $limit) + 1;
  $limit_start = ($page - 1) * $limit; 
  if(isset($_POST['keyword'])){
    $keyword = $_POST['keyword'];
    $where = "WHERE kelas LIKE '%$keyword%'";
  }else{
    $where = "";
  }
    $sql = mysqli_query($koneksi, "SELECT * from kelas $where limit $limit_start, $limit");
    $cek = mysqli_num_rows($sql);
    $no = 0;
    if($cek > 0){
    while ($data = mysqli_fetch_array($sql)){
  ?>
<div class="col-lg-3 col-md-6 col-sm-6">
  <div class="card card-stats">
    <div class="card-body ">
      <div class="row">
        <div class="col-5 col-md-4">
          <div class="icon-big text-center icon-warning">
            <i class="nc-icon nc-shop text-warning"></i>
          </div>
        </div>
        <div class="col-7 col-md-8">
          <div class="numbers">
            <p class="card-category"><?php echo ucwords("$asset[tipekelompok]"); ?></p>
            <p class="card-title"><?php echo"$data[kelas]"; ?> 
              <p>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer ">
      <hr>
      <div class="stats">
        <a href="siswa-<?php echo "$data[idkelas]"; ?>"><i class="nc-icon nc-minimal-right"></i> view</a>
      </div>
      <hr>
      <div class="text-center">
        <a href="" data-toggle="modal" data-target="#detail<?php echo $no; ?>">Detail</a> -
        <a href="" data-toggle="modal" data-target="#edit<?php echo $no; ?>">Edit</a> -
        <a href="index-<?php echo "$data[idkelas]"; ?>">Hapus</a>
      </div>
      <!-- Modal Detail -->
      <div id="detail<?php echo $no; ?>" class="modal fade" role="dialog">
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
              <h5><?php echo ucwords("$data[kelas]"); ?></h5>
              <label>Dipimpin Oleh :</label>
              <?php

                $gu = mysqli_query($koneksi, "SELECT * FROM guru WHERE idguru='$data[idguru]'");
                $gr = mysqli_num_rows($gu);
                if($gr > 0){
                  $ru = mysqli_fetch_array($gu);
                    echo ucwords("$ru[namaguru]");
                }else{
                  echo "<i> Belum Ada Pimpinan </i>";
                }
              ?>
            </div>
            <!-- footer modal -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Edit -->
      <form action="index" method="POST">
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
              <label>Nama <?php echo ucwords("$asset[tipekelompok]"); ?></label>
              <input type="text" name="kelas" class="form-control" maxlength="50" value="<?php echo "$data[kelas]"; ?>" required/><br>
              <select name="pimpinan" class="form-control">
                <?php 
                  $dw = mysqli_query($koneksi, "SELECT * from guru natural join kelas where kelas.idkelas='$data[idkelas]'");
                  $wd = mysqli_fetch_array($dw); ?>
                    <option value="<?php echo "$wd[idguru]" ?>"><?php echo "$wd[namaguru]"; ?></option>
                  <?php $ad = mysqli_query($koneksi, "SELECT * from guru where not level='admin' and not namaguru='$wd[namaguru]'");
                  while($da = mysqli_fetch_array($ad)){ ?>
                    <option value="<?php echo "$da[idguru]"; ?>"><?php echo "$da[namaguru]" ?></option>
                  <?php }
                ?>
              </select>
              <input type="hidden" name="idkelasedit" value="<?php echo "$data[idkelas]"; ?>">
            </div>
            <!-- footer modal -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button> 
              <input type="submit" name="edit" class="btn btn-primary" value="Simpan">
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<?php $no++; } ?>
<div class="col-md-12">
 <!-- Pagination -->
  <ul class="pagination">
    <!-- LINK FIRST AND PREV -->
    <?php
    $aa = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM kelas");
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
<?php }else{ ?>
<div class="col-md-12">
  <h2 class="text-center"><i>Data Tidak Tersedia :(</i></h2>
</div>
<?php } ?>
<div class="col-md-12 text-center"><button type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#tambah">Tambah <?php echo ucwords("$asset[tipekelompok]"); ?></button></div>
<!-- tambah -->
<form action="index" method="POST">
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
      <label>Nama <?php echo ucwords("$asset[tipekelompok]"); ?></label>
      <input type="text" name="kelas" class="form-control" maxlength="50" required/><br>
      <label>Pimpinan</label>
      <select name="pimpinan" class="form-control">
        <?php 
          $ad = mysqli_query($koneksi, "SELECT * from guru where not level='admin'");
          while($da = mysqli_fetch_array($ad)){ ?>
            <option value="<?php echo "$da[idguru]"; ?>"><?php echo "$da[namaguru]" ?></option>
          <?php }
        ?>
      </select>
    </div>
    <!-- footer modal -->
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      <input type="submit" name="tambah" class="btn btn-primary" value="Simpan">
    </div>
  </div>
   </div>
</div>
</form>
