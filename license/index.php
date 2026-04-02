<?php
include '../include/config.php';
	$sql = mysqli_query($koneksi, "SELECT * from license where id='1'");
   $data = mysqli_fetch_array($sql);
   $file = $data['file'];
   $cek = $data['content'];
   if(password_verify($cek, $file)){
    header('location:../');
   }else{
  	$djn = mysqli_query($koneksi, "DELETE from license where id='1'");
   }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
  	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>License Key</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
	<script src="../assets/js/core/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(){
    		$(":input:first").focus();
		});
	</script>
</head>
<body><br><br>
<div class="login-card">
    <h1>License Key <i class="fa fa-key"></i></h1><br>
  <form method="POST" autocomplete="off">
  	<?php $keycontent = base_convert(microtime(false), 30, 36); ?>
    <input type="text" name="keycontent" placeholder="Key Content" value="<?php echo base64_encode($keycontent); ?>">
    <input type="text" name="key" placeholder="Key" required/>
    <input type="submit" name="submit" class="login login-submit" value="Submit">
  </form>
	<?php
		if(isset($_POST['submit'])){
			date_default_timezone_set('Asia/Jakarta');
			$now = date('Y-m-d');
			$key = mysqli_real_escape_string($koneksi, $_POST['key']);
			$tent = base64_decode($_POST['keycontent']);
			$content = $tent;
			$sql = mysqli_query($koneksi, "INSERT INTO license(id,content,file,tgl) VALUES ('1','$content','$key','$now')");
			if($sql){
				header('location:../');
			}else{
				echo "Gagal Generete Key, Silahkan Ulangi.";
			}
		}
	?>  
  <div class="login-help">
    *Copas Key Content Dan Kirim Ke No 083850057649(WA).
  </div>
</div>
<br><center>&copy; 2019, By Agus Efendi || <i> E-Absen Application. </i></center>
</body>
</html>