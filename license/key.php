<?php
	 $sql = mysqli_query($koneksi, "SELECT * from license where id='1'");
	 $data = mysqli_fetch_array($sql);
	 $file = $data['file'];
	 $cek = $data['content'].'19413';
	 $tgl = $data['tgl'];
	 $r = mysqli_query($koneksi, "DELETE FROM license WHERE DATEDIFF(CURRENT_DATE,'$tgl') >= 1");
	 if(password_verify($cek, $file)){
	 	//echo "OK";
	 }else{
	 	echo "
	 		<script> alert('License Anda Tidak Berlaku!'); window.location.href='../license/' </script>
	 	";
	 }
?>