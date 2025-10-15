
<?php
session_start();
if(isset($_SESSION["oturum"])) //oturum açıldıysa
{
	if($_SESSION["yetki"]=="admin")
	{	
		echo"Buraya sadece admin yetkili girebilir.<br>
		<a href='kullaniciyonetim.php'>Kullanıcı Yönetim Paneli</a><br>
		<a href='oturumkapat.php'>Oturumu kapat</a><br>";
	}
}
else
{
	header("location:login.php");
}
?>