<?php
$servername="localhost";
$username="erkamtr1";
$password="";
try
{
$conn=new PDO("mysql:host=$servername;dbname=kontrol;charset=utf8",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
echo "Bağlantı hatası". $e->getMessage();
}
?>
