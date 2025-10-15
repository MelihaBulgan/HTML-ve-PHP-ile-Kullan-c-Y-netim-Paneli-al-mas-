<?php
session_start();
if(isset($_SESSION["oturum"])) //oturum açıldıysa
{
	if($_SESSION["yetki"]=="admin")
	{	

	
echo "<a href='oturumkapat.php'>Oturumu kapat</a><br><br>";
echo "<center>KULLANICI YÖNETİM PANELİ
<table border='0' width='600' height='250'>
<form action='' method='post'>
<tr>
<td>Adı Soyadı:</td>
<td><input type='text' name='ads'></td>
</tr>
<tr>
<td>Kullanıcı Adı:</td>
<td><input type='text' name='kadi'></td>
</tr>
<tr>
<td>Şifre:</td>
<td><input type='password' name='sifre'></td>
</tr>
<tr>
<td>Teelfon:</td>
<td><input type='text' name='tel'></td>
</tr>
<tr>
<td>Cinsiyet:</td>
<td>
<input type='radio' name='cins' value='K'>Kadın
<input type='radio' name='cins' value='E'>Erkek
</td>
</tr>
<tr>
<td>Kullanıcı yetkisi:</td>
<td>
<select name='yetki'>
<option value='admin'>Admin</option>
<option value='kullanici'>Kullanıcı</option>
<option value='moderator'>Moderatör</option>
</select>
</td>
</tr>
<tr>
<td colspan='2'>
<input type='submit' name='kayit' value='Kullanici Kaydet'>
<input type='submit' name='sil' value='Kullaniciyi Sil'>
<input type='submit' name='guncel' value='Güncelle/Değiştir'>
<input type='submit' name='listele' value='Kayıtlı Kullanıcıları Listele'>
</td>
</tr>
</form>
</table></center>";

$x=new PDO("mysql:host=localhost;dbname=e-ticaret",'root','');
if (isset($_POST['kayit']))
{
	$ads=$_POST['ads'];
	$kadi=$_POST['kadi'];
	$parola=$_POST['sifre'];
	$tel=$_POST['tel'];
	$cins=$_POST['cins'];
	$yetki=$_POST['yetki'];
	$kayitlar=$x->query("SELECT * FROM kullanici",PDO::FETCH_ASSOC);
	if($kayitlar->rowCount()) //veritabanından veri geliyorsa
	{
		foreach($kayitlar as $tekkullaniciadi)
			{
				if($kadi==$tekkullaniciadi['kullaniciadi'])
				{
					$varmi="var";
					break;
				}
				else
				{
					$varmi="yok";
				}
			}
		if($varmi=="yok")
			$kayit=$x->exec("INSERT INTO kullanici (adsoyad, kullaniciadi, sifre, telefon, cinsiyet, yetki,durum) VALUES ('$ads','$kadi','$parola','$tel','$cins','$yetki','aktif')");
		elseif($varmi=="var")
			echo "Kullanıcı adı daha önce alınmıştır";
		if($kayit)
			echo "Kullanıcı başarıyla kaydedildi";
		else
			echo "Kullanıcı kaydı başarısız.";
	}
	else
	{
		$kayit=$x->exec("INSERT INTO kullanici (adsoyad, kullaniciadi, sifre, telefon, cinsiyet, yetki,durum) VALUES ('$ads','$kadi','$parola','$tel','$cins','$yetki','aktif')");
		if($kayit)
			echo "Kullanıcı başarıyla kaydedildi";
		else
			echo "Kullanıcı kaydı başarısız.";
	}



}
if (isset($_POST['sil']))
{
	$kadi=$_POST['kadi'];
	$sil = $x->exec("DELETE FROM kullanici WHERE kullaniciadi='$kadi'");
	if($sil)
		echo "Veritabanından silme işlemi başarılı";
	else
		echo "Başarısız";
}
if (isset($_POST['guncel']))
{
	$ads=$_POST['ads'];
	$kadi=$_POST['kadi'];
	$parola=$_POST['sifre'];
	$tel=$_POST['tel'];
	$yetki=$_POST['yetki'];
	$guncelle=$x->exec("UPDATE kullanici SET sifre='$parola',telefon='$tel',yetki='$yetki' WHERE kullaniciadi='$kadi'");
	if($guncelle)
		echo "Değişiklikler gerçekleştirilmiştir.";
	else
		echo "Güncelleme başarısız";
}
if (isset($_POST['listele']))
{
	$kayitlar=$x->query("SELECT * FROM kullanici",PDO::FETCH_ASSOC);
	echo "<center><table border='0'>";
	echo "<tr><td>Adı Soyadı</td><td>Kullanıcı Adı</td><td>Şifre</td><td>Telefon</td><td>Cinsiyet</td><td>Yetki</td><td>İşlem</td></tr>";
	foreach($kayitlar as $tekkullanici)
	{
		$k_id=$tekkullanici['kullanici_id'];
		$durum=$tekkullanici['durum'];
		if($durum=="aktif")
		{
			$resim="ban.jfif";
			$islem="engelleme";
		}
		elseif($durum=="pasif")
		{
			$resim="aktif.png";
			$islem="aktiflestirme";
		}
		echo "<tr><td>".$tekkullanici['adsoyad']."</td><td>".$tekkullanici['kullaniciadi']."</td><td>".$tekkullanici['sifre']."</td><td>".$tekkullanici['telefon']."</td><td>".$tekkullanici['cinsiyet']."</td><td>".$tekkullanici['yetki']."</td><td>";
		echo "<a href='kullaniciyonetim.php?silinecekid=$k_id'><img src='silme.PNG' width='25' height='25'></a>";
		echo "<a href='kullaniciyonetim.php?islemid=$k_id&islem=$islem'><img src='$resim' width='25' height='25'></a></td></tr>";
	}
	echo "</table></center>";
}
if (isset($_GET['silinecekid'])) //eğer bu sayafaya silinecek id değeri gönderildiyse
{
	$s_id=$_GET['silinecekid'];
	$sil = $x->exec("DELETE FROM kullanici WHERE kullanici_id='$s_id'");
	$kayitlar=$x->query("SELECT * FROM kullanici",PDO::FETCH_ASSOC);
	echo "<center><table border='0'>";
	echo "<tr><td>Adı Soyadı</td><td>Kullanıcı Adı</td><td>Şifre</td><td>Telefon</td><td>Cinsiyet</td><td>Yetki</td><td>İşlem</td></tr>";
	foreach($kayitlar as $tekkullanici)
	{
		$k_id=$tekkullanici['kullanici_id'];
		$durum=$tekkullanici['durum'];
		if($durum=="aktif")
		{
			$resim="ban.jfif";
			$islem="engelleme";
		}
		elseif($durum=="pasif")
		{
			$resim="aktif.png";
			$islem="aktiflestirme";
		}
		echo "<tr><td>".$tekkullanici['adsoyad']."</td><td>".$tekkullanici['kullaniciadi']."</td><td>".$tekkullanici['sifre']."</td><td>".$tekkullanici['telefon']."</td><td>".$tekkullanici['cinsiyet']."</td><td>".$tekkullanici['yetki']."</td><td>";
		echo "<a href='kullaniciyonetim.php?silinecekid=$k_id'><img src='silme.PNG' width='25' height='25'></a>";
		echo "<a href='kullaniciyonetim.php?islemid=$k_id&islem=$islem'><img src='$resim' width='25' height='25'></a></td></tr>";
	}
	echo "</table></center>";
}	
if (isset($_GET['islemid']) && isset($_GET['islem'])) //eğer bu sayafaya silinecek id değeri gönderildiyse
{
	$e_id=$_GET['islemid'];
	$islem=$_GET['islem'];
	
	if($islem=="engelleme")
		$guncelle1=$x->exec("UPDATE kullanici SET durum='pasif' WHERE kullanici_id='$e_id'");
	elseif($islem=="aktiflestirme")
		$guncelle1=$x->exec("UPDATE kullanici SET durum='aktif' WHERE kullanici_id='$e_id'");
	$kayitlar=$x->query("SELECT * FROM kullanici",PDO::FETCH_ASSOC);
	echo "<center><table border='0'>";
	echo "<tr><td>Adı Soyadı</td><td>Kullanıcı Adı</td><td>Şifre</td><td>Telefon</td><td>Cinsiyet</td><td>Yetki</td><td>İşlem</td></tr>";
	foreach($kayitlar as $tekkullanici)
	{
		$k_id=$tekkullanici['kullanici_id'];
		$durum=$tekkullanici['durum'];
		if($durum=="aktif")
		{
			$resim="ban.jfif";
			$islem="engelleme";
		}
		elseif($durum=="pasif")
		{
			$resim="aktif.png";
			$islem="aktiflestirme";
		}
		echo "<tr><td>".$tekkullanici['adsoyad']."</td><td>".$tekkullanici['kullaniciadi']."</td><td>".$tekkullanici['sifre']."</td><td>".$tekkullanici['telefon']."</td><td>".$tekkullanici['cinsiyet']."</td><td>".$tekkullanici['yetki']."</td><td>";
		echo "<a href='kullaniciyonetim.php?silinecekid=$k_id'><img src='silme.PNG' width='25' height='25'></a>";
		echo "<a href='kullaniciyonetim.php?islemid=$k_id&islem=$islem'><img src='$resim' width='25' height='25'></a></td></tr>";
	}
	echo "</table></center>";
}


}
}
else
{
	header("location:login.php");
}
?>
