<?php
	if(isset($_POST['enkripsi'])){
		$enkripsi = $_POST['enkripsi'];
		$type = '';
	}

	if(isset($_GET['en'])){
		$enkripsi = $_GET['en'];
		$type = 'manual';
	}

	$sql = mysqli_query($koneksi, "SELECT * from siswa where enkripsi='$enkripsi'");
	$data = mysqli_fetch_array($sql);
	$idsiswa = $data['idsiswa'];
	date_default_timezone_set('Asia/Jakarta');
	$tglnow = date('Y/m/d');
	$jamnow = date('H:i:s');
	$row = mysqli_num_rows($sql);

	$a = mysqli_query($koneksi, "SELECT * from absen where tglabsen='$tglnow' AND idsiswa='$idsiswa'");
	$b = mysqli_num_rows($a);
	$cc = mysqli_fetch_array($a);
	$kembali = $cc['kembali'];

	if($row > 0){
		$f = mysqli_query($koneksi, "SELECT * from asset where idasset='1'");
		$g = mysqli_fetch_array($f);
		
		if($b > 0){
			//$e = mysqli_fetch_array($a);
			$jamkeluar = $cc['jamkeluar'];

			
			$istirahat = $g['istirahat'];

			if($istirahat == 'Y'){
				$h = mysqli_query($koneksi, "SELECT * from absen where tglabsen='$tglnow' AND idsiswa='$idsiswa'");
				$i = mysqli_fetch_array($h);
				$jamistirahat = $i['jamistirahat'];
				$kmb = $i['kembali'];
				$jmluar = $i['jamkeluar'];

				if($jamistirahat == ''){
					$j = mysqli_query($koneksi, "UPDATE absen set jamistirahat='$jamnow' where tglabsen='$tglnow' AND idsiswa='$idsiswa'"); ?>

					<script>
						swal({
						  position: 'center',
						  type: 'success',
						  title: 'Absen Berhasil <br> <?php echo ucwords("Nama : $data[namasiswa] <br> Absen : Istirahat")?>',
						  showConfirmButton: false,
						  timer: 4500
						})
						</script>
						<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
				<?php }else if($kmb == ''){
					$k = mysqli_query($koneksi, "UPDATE absen set kembali='$jamnow' where tglabsen='$tglnow' AND idsiswa='$idsiswa'"); ?>

					<script>
						swal({
						  position: 'center',
						  type: 'success',
						  title: 'Absen Berhasil <br> <?php echo ucwords("Nama : $data[namasiswa] <br> Absen : Kembali")?>',
						  showConfirmButton: false,
						  timer: 4500
						})
						</script>
						<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
				<?php }else if($jmluar == ''){
					$d = mysqli_query($koneksi, "UPDATE absen set jamkeluar='$jamnow' where tglabsen='$tglnow' AND idsiswa='$idsiswa'"); ?>
				
					<script>
					swal({
					  position: 'center',
					  type: 'success',
					  title: 'Absen Berhasil <br> <?php echo ucwords("Nama : $data[namasiswa] <br> Absen : Pulang")?>',
					  showConfirmButton: false,
					  timer: 4500
					})
					</script>
					<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
				<?php }else if(isset($jmluar)){ ?>
				<script>
				swal({
				  position: 'center',
				  type: 'warning',
				  title: 'Anda Sudah Melakukan Absen Hari Ini <br> <?php echo ucwords("Nama : $data[namasiswa]")?>',
				  showConfirmButton: false,
				  timer: 6500
				})
				</script>
				<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
			<?php }

			}else if($jamkeluar == '' && $istirahat == 'N'){
				$d = mysqli_query($koneksi, "UPDATE absen set jamkeluar='$jamnow' where tglabsen='$tglnow' AND idsiswa='$idsiswa'"); ?>
				
				<script>
				swal({
				  position: 'center',
				  type: 'success',
				  title: 'Absen Berhasil <br> <?php echo ucwords("Nama : $data[namasiswa] <br> Absen : Pulang")?>',
				  showConfirmButton: false,
				  timer: 4500
				})
				</script>
				<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
			<?php }else if(isset($jamkeluar)){ ?>
				<script>
				swal({
				  position: 'center',
				  type: 'warning',
				  title: 'Anda Sudah Melakukan Absen Hari Ini <br> <?php echo ucwords("Nama : $data[namasiswa]")?>',
				  showConfirmButton: false,
				  timer: 6500
				})
				</script>
				<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
			<?php }

		}else{
			$nowjam = strtotime(date('H:i:s'));
			$default = $g['waktudatang'];
          	$def = strtotime($default);
          	if($nowjam >= $def){
          	  $ket = "Terlambat";
          	}else{
          		$ket = "";
          	}
			$c = mysqli_query($koneksi, "INSERT into absen(tglabsen,jammasuk,ket,idsiswa) values('$tglnow','$jamnow','$ket','$idsiswa')"); ?>
			
			<script>
			swal({
			  position: 'center',
			  type: 'success',
			  title: 'Absen Berhasil <br> <?php echo ucwords("Nama : $data[namasiswa] <br> Absen : Datang")?>',
			  showConfirmButton: false,
			  timer: 4500
			})
			</script>
			<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
		<?php }
	 ?>
	<?php }else{  ?>

		<script>
		swal({
			  position: 'center',
			  type: 'error',
			  title: 'Code QR Tidak Terdaftar :(',
			  showConfirmButton: false,
			  timer: 4500
			})

		</script>
		<meta http-equiv="Refresh" content="3; URL=absen/<?php echo $type; ?>">
	<?php 
	
	}
?>