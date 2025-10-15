<?php
session_start();
if($_SESSION["tur"]=='kullanici')
	echo "<body><center><h2>BURASI KULLANICI SAYFASI</h2></center></body>";
else
	header('location: giris.php');
?>