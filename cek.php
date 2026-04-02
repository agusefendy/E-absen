<?php
	include "include/config.php";
	 $sql = mysqli_query($koneksi, "SELECT * from license where id='1'");
	 $data = mysqli_fetch_array($sql);
	 $file = $data['file'];
	 $cek = $data['content'].'19413';
	  $tgl = $data['tgl'];
	 $lama = 1;
	 $r = mysqli_query($koneksi, "UPDATE license SET content='', file='',tgl='0000-00-00' where DATEDIFF(CURDATE(), tgl) > $lama");
	 if(password_verify($cek, $file)){
	 	//echo "OK";
	 }else{
	 	echo "
	 		<script> alert('License Anda Tidak Berlaku!'); window.location.href='license/index' </script>
	 	";
	 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/sweetalert2.min.css" rel="stylesheet" />
  <link href="assets/css/animate.css" rel="stylesheet" />
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/sweetalert2.min.js"></script>
</head>
<body>
<?php
		$enkripsi = $_POST['enkripsi'];
		$type = '';

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
						setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
						</script>
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
						setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
						</script>
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
					setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
					</script>
				<?php }else if(isset($jmluar)){ ?>
				<script>
				swal({
				  position: 'center',
				  type: 'warning',
				  title: 'Anda Sudah Melakukan Absen Hari Ini <br> <?php echo ucwords("Nama : $data[namasiswa]")?>',
				  showConfirmButton: false,
				  timer: 6500
				})
				setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
				</script>
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
				setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
				</script>
			<?php }else if(isset($jamkeluar)){ ?>
				<script>
				swal({
				  position: 'center',
				  type: 'warning',
				  title: 'Anda Sudah Melakukan Absen Hari Ini <br> <?php echo ucwords("Nama : $data[namasiswa]")?>',
				  showConfirmButton: false,
				  timer: 6500
				})
				setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
				</script>
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
			setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
			</script>
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
			setTimeout("location.href='absen/<?php echo $type; ?>'", 4500);
		</script>
	<?php 
	
	}
?>
</body>
</html>