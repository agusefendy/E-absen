<?php
	include "../include/config.php";
	$id = $_POST['enkripsi'];
	$sql = mysqli_query($koneksi, "SELECT * from siswa where enkripsi='$id'");
	$num = mysqli_num_rows($sql);
	
	if($num > 0){ 
$row = mysqli_fetch_array($sql);
	$idsiswa = $row['idsiswa'];
	$idkelas = $row['idkelas'];
	$namasiswa = $row['namasiswa'];

	//kelas
	$e = mysqli_query($koneksi, "SELECT * from kelas where idkelas='$idkelas'");
	$f =mysqli_fetch_array($e);
	$kelas = $f['kelas'];

		$a = mysqli_query($koneksi, "SELECT * from asset where idasset='1'");
		$b = mysqli_fetch_array($a);
		$istirahat = $b['istirahat'];
		$waktudatang = $b['waktudatang'];
		$tipekelompok = $b['tipekelompok'];

		//tgl now
		date_default_timezone_set('Asia/Jakarta');
		$now = date('Y-m-d');

		//time now
		$jamnow = date('H:i:s');

		//absen
		$c = mysqli_query($koneksi, "SELECT * from absen where idsiswa='$idsiswa' AND tglabsen='$now'");
		$e = mysqli_fetch_array($c);
		$jammasuk = $e['jammasuk'];
		$jamkeluar = $e['jamkeluar'];
		$jamistirahat = $e['jamistirahat'];
		$kembali = $e['kembali'];

		if($istirahat == 'Y'){
			//Cek absen
			$cekabsen = mysqli_num_rows($c);
			if($cekabsen > 0){

				if($jamistirahat == '' && isset($jammasuk)){
					$g = mysqli_query($koneksi, "UPDATE absen SET jamistirahat='$jamnow' where idsiswa='$idsiswa' AND tglabsen='$now'");

					if($g){
						echo "<h3><i class='fa fa-clock-o'></i> $jamnow </h3> Absen Berhasil! <br> Nama : $namasiswa <br> $tipekelompok : $kelas <br> Absen : Istirahat.";
					}else{
						echo "Kesalahan Server :( Silahkan Ulangi.";
					}	
				}else if($kembali == ''){
					$h = mysqli_query($koneksi, "UPDATE absen SET kembali='$jamnow' where idsiswa='$idsiswa' AND tglabsen='$now'");

					if($h){
						echo "<h3><i class='fa fa-clock-o'></i> $jamnow </h3> Absen Berhasil! <br> Nama : $namasiswa <br> $tipekelompok : $kelas <br> Absen : Kembali.";
					}else{
						echo "Kesalahan Server :( Silahkan Ulangi.";
					}
				}else if($jamkeluar == ''){
					$f = mysqli_query($koneksi, "UPDATE absen SET jamkeluar='$jamnow' where idsiswa='$idsiswa' AND tglabsen='$now'");

					if($f){
						echo "<h3><i class='fa fa-clock-o'></i> $jamnow </h3> Absen Berhasil! <br> Nama : $namasiswa <br> $tipekelompok : $kelas <br> Absen : Pulang.";
					}else{
						echo "Kesalahan Server :( Silahkan Ulangi.";
					}
				}else{
					echo "Anda Sudah Melakukan Absen Hari Ini!";
				}

			}else{
				$nowjam = strtotime(date('H:i:s'));
				$default = $waktudatang;
	          	$def = strtotime($default);
	          	if($nowjam >= $def){
	          	  $ket = "Terlambat";
	          	}else{
	          		$ket = "";
	          	}

				$d = mysqli_query($koneksi, "INSERT into absen(tglabsen,jammasuk,ket,idsiswa) values ('$now','$jamnow','$ket','$idsiswa')");

				if($d){
					echo "<h3><i class='fa fa-clock-o'></i> $jamnow </h3><br> Absen Berhasil! <br> Nama : $namasiswa <br> $tipekelompok : $kelas <br> Absen : Datang.";
				}else{
					echo "Kesalahan Server :( Silahkan Ulangi.";
				}
			}
			
		}else if($istirahat == 'N'){
			//Cek absen
			$cekabsen = mysqli_num_rows($c);
			if($cekabsen == 0){

				$nowjam = strtotime(date('H:i:s'));
				$default = $waktudatang;
	          	$def = strtotime($default);
	          	if($nowjam >= $def){
	          	  $ket = "Terlambat";
	          	}else{
	          		$ket = "";
	          	}

				$d = mysqli_query($koneksi, "INSERT into absen(tglabsen,jammasuk,ket,idsiswa) values ('$now','$jamnow','$ket','$idsiswa')");

				if($d){
					echo "<h3><i class='fa fa-clock-o'></i> $jamnow </h3> Absen Berhasil! <br> Nama : $namasiswa <br> $tipekelompok : $kelas <br> Absen : Datang.";
				}else{
					echo "Kesalahan Server :( Silahkan Ulangi.";
				}

			}else{
				if($jamkeluar == ''){
					$f = mysqli_query($koneksi, "UPDATE absen SET jamkeluar='$jamnow' where idsiswa='$idsiswa' AND tglabsen='$now'");

					if($f){
						echo "<h3><i class='fa fa-clock-o'></i> $jamnow </h3> Absen Berhasil! <br> Nama : $namasiswa <br> $tipekelompok : $kelas <br> Absen : Pulang.";
					}else{
						echo "Kesalahan Server :( Silahkan Ulangi.";
					}
				}else{
					echo "Anda Sudah Melakukan Absen Hari Ini!";
				}
			}
		}
	?>
		<script type="text/javascript">
			$('#idabsen').css('border', '1px #090 solid'); 
			var interval = 0;
			interval = setInterval('erase()',5000);
			function erase(){
				document.getElementById("idabsen").value = ""; 
				clearInterval(interval);
			}
		</script>
		<?php 
	}else{ ?>
		<script type="text/javascript"> $('#idabsen').css('border', '1px #C33 solid'); </script>
		<?php echo "<div class='text-danger'> ID Tidak Terdaftar! </div>";
	}
?>