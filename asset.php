<?php 
	$as = mysqli_query($koneksi, "SELECT * FROM asset WHERE idasset='1'");
	$asset = mysqli_fetch_array($as);
?>