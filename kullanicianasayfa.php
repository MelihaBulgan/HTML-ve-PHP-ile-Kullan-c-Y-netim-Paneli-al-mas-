

<?php
session_start();
if(isset($_SESSION["oturum"])) //oturum açıldıysa
{
	if($_SESSION["yetki"]=="kullanici")
	{	
		echo "Buraya sadece kullanıcı yetkili girebilir.
		<a href='oturumkapat.php'>Oturumu kapat</a>";
	}
}
else
{
	header("location:login.php");
}
?>