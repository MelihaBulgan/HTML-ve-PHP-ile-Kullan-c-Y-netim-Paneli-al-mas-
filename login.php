<center><table border="0">
<form action="" method="post">
<tr><td>Kullanıcı Adı:</td><td><input type="text" name="kadi"></td></tr>
<tr><td>Şifre:</td><td><input type="password" name="sifre"></td></tr>
<tr><td colspan="2"><input type="submit" name="girisyap"></td></tr>
</form>
</table></center>
<?php
$var=0;
if(isset($_POST['girisyap']))
{
	//1. Textbox ve passsword alanına girilen verileri al
	$kullaniciadi=$_POST['kadi'];
	$sifre=$_POST['sifre'];
	
	//2. Veritabanından kullanıcı table tüm verileri çek
	$x=new PDO("mysql:host=localhost;dbname=e-ticaret",'root','');
	$vtverileri=$x->query("SELECT * FROM kullanici",PDO::FETCH_ASSOC);
	//3. Alınan ve çekilen verileri karşılaştır
	foreach($vtverileri as $teksatirdakiveri)
	{
		if($kullaniciadi==$teksatirdakiveri['kullaniciadi'] && $sifre==$teksatirdakiveri['sifre'])
		{
			$var=1;
			session_start();
			$_SESSION["oturum"]="on";
			$_SESSION["kullaniciadi"]=$kullaniciadi;
			$_SESSION["sifre"]=$sifre;
			$_SESSION["yetki"]=$teksatirdakiveri['yetki'];
			if($_SESSION["yetki"]=="admin")
				header('location:adminanasayfa.php');
			elseif ($_SESSION["yetki"]=="kullanici")
				header('location:kullanicianasayfa.php');
		}

	}
	if($var!=1)
		{
			echo "Kullanıcı adı veya şifre hatalı";
		}
	
	
	
}


?>