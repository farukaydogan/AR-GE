<?php
include ("data.php");
include('replace.php');
ob_start();
session_start();

$admin = sqli_filter($_POST["admin"]);
$pass =sqli_filter($_POST["pass"]);

$sorgu=$conn->query("select * from uye where admin = '$admin' and pass ='$pass'",PDO::FETCH_ASSOC);
if($deg = $sorgu -> rowCount())
{

if($deg > 0 )
{
session_start();
$_SESSION['login']="true";
$_SESSION['admin']=$admin;
$_SESSION['pass']=$pass;
echo "<a href='index.php'>giriş yapıldı</a>";

echo "<b><a href='uye_cikis.php'>Çıkış Yap</a></b>";
header("Location:index.php");
}


}

else 
{

echo "Hatalı bir deneme yaptın !! <a href=javascript:history.back(-1)>Geri Dön</a>";

}
ob_end_flush();
?>