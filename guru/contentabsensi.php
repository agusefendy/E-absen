<?php
  include "../include/config.php";
  include "../asset.php";
  include "../license/key.php";
  $idkelas = $_GET['idkelas'];
  $sql = mysqli_query($koneksi, "SELECT * from kelas where idkelas='$idkelas'");
  $kelas = mysqli_fetch_array($sql);
  date_default_timezone_set('Asia/Jakarta');
  $page = (isset($_POST['page'])) ? $_POST['page'] : 1;
  $limit = 10;
  $no = (($page - 1) * $limit) + 1;
  $limit_start = ($page - 1) * $limit;
  $now = date('Y-m-d');
  if(isset($_POST['select'])){
    $select = $_POST['select'];
    if($select == $now){
      $where = $now;
      $label = 'Hari Ini';
    }else{
      $var = date('Y-m-');
      $where = $var.$select;
      $label = $where;
    }
  }else{
    $select = '';
    $where = $now; 
    $label = 'Hari Ini';
  }
  
      $q = mysqli_query($koneksi, "SELECT * from kelas natural join siswa natural join absen where idkelas='$idkelas' and tglabsen='$where' ORDER BY namasiswa LIMIT $limit_start, $limit");
      $cek = mysqli_num_rows($q);

      $xx = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas' AND idsiswa NOT IN (SELECT idsiswa from absen where tglabsen='$where')");
      $vv = mysqli_num_rows($xx);

      $qq = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah from kelas natural join siswa natural join absen where idkelas='$idkelas' and tglabsen='$where'");
      $get_jumlah = mysqli_fetch_array($qq);
      if($cek > 0){
      ?>
      <label><?php echo $label; ?></label>
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
            }else if($data['ket'] == 'Alpha'){
              $class = 'class="text-danger"';
            }else if($data['ket'] == 'Sakit'){
              $class = 'class="text-info"';
            }else if($data['ket'] == 'Izin'){
              $class = 'class="text-info"';
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
       <?php }else{ ?>
      <div class="col-md-12 text-center">
        <h2 class="text-center"><i>Data Tidak Ditemukan :(</i></h2>
      </div>
    <?php } ?> 
      <div style="float: right;">
        <div class="text-success"><?php echo "$cek $asset[tipeabsen]"; ?> Sudah Absen</div>
        <a href="" data-toggle="modal" data-target="#Modal" class="text-danger"><?php echo "$vv $asset[tipeabsen]"; ?> Belum Absen</a>
        <?php
          //total siswa
          $aa = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas'");
          $bb = mysqli_num_rows($aa);
        ?>
        <div class="text-info"><?php echo "Total $asset[tipeabsen] : $bb"; ?></div><br>
      </div>
      <form action="absensi-<?php echo $idkelas; ?>" method="POST">
      <!-- Siswa tidak hadir -->
      <div id="Modal" class="modal fade" role="dialog">
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
            <p>
              
              <input type="hidden" name="sel" value="<?php echo "$select"; ?>">
              <input type="hidden" name="val" value="<?php echo "$where"; ?>">
              <div class="table-responsive">
                <?php echo $label; ?>
                <table class="table" id="centang">
                  <thead>
                    <tr class="text-primary">
                      <td><input type="checkbox" id="semua" checked></td>
                      <td> Nama </td>
                      <td> Aksi </td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                    $x = mysqli_query($koneksi, "SELECT * from siswa where idkelas='$idkelas' AND idsiswa NOT IN (SELECT idsiswa from absen where tglabsen='$where')");
                    $y = mysqli_num_rows($x);
                    if($y > 0){ 
                      while($row = mysqli_fetch_array($x)){ ?>
                        <tr>
                          <td><input type="checkbox" name="post_id[]" value="<?php echo "$row[idsiswa]" ?>" checked></td>
                          <td><?php echo ucwords("$row[namasiswa]"); ?></td>
                          <td>
                            <select name="ket[]" class="form-control">
                              <option>Alpha</option>
                              <option>Sakit</option>
                              <option>Izin</option>
                            </select>
                          </td>
                        </tr>
                    <?php } }else{ ?>
                      <tr><td colspan="3"><b><i>Data Tidak Tersedia</i></b></td></tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </p>
          </div>
          <!-- footer modal -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <?php
              if($y > 0){ ?>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
              <?php }
            ?>
          </div>
        </div>
         </div>
      </div>
    </form>
    <?php if($cek > 0){ ?>
      <div class="text-success">
      <i> Ket. </i><br>
      D : Datang <br>
      I : Istirahat <br>
      K : Kembali <br>
      P : Pulang
      </div>
      <div style="float: right;">
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
      <div class="text-center">
        <button type="button" onclick="window.location.href='laporanharian?en=<?php echo $idkelas; ?>&kls=<?php echo "$kelas[kelas]"; ?>&tgl=<?php echo $where; ?>'" class="btn btn-warning btn-round"><i class="fa fa-file-excel-o"></i> Buat Laporan</button>
      </div>
    </div>
   <?php } ?>
    <script type="text/javascript">
      $(document).ready(function() { 
      // ketika checkbox dengan id semua diklik,  
      // maka semua checkbox akan tercentang. 
      $('#semua').click(function(){ 
         $(this).parents('#centang:eq(0)').
         find(':checkbox').attr('checked', this.checked); 
      });
    });   
    </script>