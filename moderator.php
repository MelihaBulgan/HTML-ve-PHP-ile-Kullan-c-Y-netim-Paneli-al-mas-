<?php
session_start();
if($_SESSION["tur"]=='moderator')
	echo "<body><center><h2>BURASI MODERATÖR SAYFASI</h2></center></body>";
else
	header('location: giris.php');
?>