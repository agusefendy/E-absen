<?php session_start();
  include "../include/config.php";
  include "../asset.php";
  include "../license/key.php";
  $idguru = mysqli_real_escape_string($koneksi, $_SESSION['idguru']);
  $a = mysqli_query($koneksi, "SELECT * from guru where idguru='$idguru'");
  $b = mysqli_fetch_array($a);
  $level = $b['level'];
  if($idguru == ''){
    //echo "<script> alert('session'); </script>";
    header('location:logout');
  }else if($level == 'guru'){
    //echo "<script> alert('admin'); </script>";
    header('location:logout');
  }else if($level == ''){
    //echo "<script> alert('level'); </script>";
   header('location:logout');
  }else{}
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
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	$idkelas = $_GET['en'];
	$kelas = $_GET['kls'];
	date_default_timezone_set('Asia/Jakarta');
	$now = $_GET['tgl'];
	$q = mysqli_query($koneksi, "SELECT * from kelas natural join siswa natural join absen where kelas.idkelas='$idkelas' and tglabsen='$now'");
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Absensi $kelas $now.xls");
	?>
 
	<center>
		<h1>Laporan Absensi <?php echo ucwords("$asset[tipeabsen]"); ?> <br> <?php echo ucwords("$asset[tipekelompok]"); ?> <?php echo $kelas; ?></h1>
		<h4><i> E-Absen Application </i></h4>
	</center>
 	<i><?php echo $now; ?></i>
	<table border="1">
		<tr>
			<th>No Induk</th>
			<th>Nama</th>
			<th>D</th>
			<th>I</th>
			<th>K</th>
			<th>P</th>
			<th>Ket</th>
		</tr>
		<?php
          while ($data = mysqli_fetch_array($q)){ ?>
            <tr>
              <td><?php echo "$data[noinduk]"; ?></td>
              <td><?php echo ucwords("$data[namasiswa]"); ?></td>
              <td><?php echo "$data[jammasuk]"; ?></td>
              <td><?php echo "$data[jamistirahat]"; ?></td>
              <td><?php echo "$data[kembali]"; ?></td>
              <td><?php echo "$data[jamkeluar]"; ?></td>
              <td><?php echo "$data[ket]"; ?></td> 
            </tr>
          <?php } ?>
	</table>
	<i> Ket. </i><br>
      D : Datang <br>
      I : Istirahat <br>
      K : Kembali <br>
      P : Pulang
	<br>
	<br>
	<center>&copy; Copyright <i>E-Absen</i></center>
	<br>
	<br>
</body>
</html>