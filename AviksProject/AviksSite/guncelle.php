<?php
include ('data.php');

include('replace.php');

$kontak1ad=sqli_filter($_POST['kontak1ad']);

$kontak2ad=sqli_filter($_POST['kontak2ad']);

$kontak3ad=sqli_filter($_POST['kontak3ad']);

$kontak4ad=sqli_filter($_POST['kontak4ad']);

$port1open=sqli_filter(isset($_POST['port1open']));
$port2open=sqli_filter(isset($_POST['port2open']));
$port3open=sqli_filter(isset($_POST['port3open']));
$port4open=sqli_filter(isset($_POST['port4open']));

$sql="UPDATE kontak SET port1open='$port1open' ";
$stmt=$conn->prepare($sql);
$stmt->execute();
echo $stmt->rowCount() . " Başarılı bir şekilde kaydedildi";
header("Location:index.php")

?>