<a href="cikis.php"> Oturumu Kapat </a>
<?php
session_start();
if($_SESSION["tur"]=='admin')
{
	echo "<body><center><h2>	
	<a href='habersil.php'>Haber sil</a><br>
	<a href='haberekle.php'>Haber ekle</a><br>
	<a href='haberguncel.php'>Haber güncelle</a><br>
	<a href='haberliste.php'>Haber liste</a><br>
	</h2></center></body>";
}
else
{
	header('location: giris.php');
}

?>