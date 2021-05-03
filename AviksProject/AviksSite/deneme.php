<?php
$dbusername="erkamtr1";
$dbpassword="Zftjp8jY";
$server = "localhost";
$My_db= "sadd";

$dbconnect = mysql_pconnect($server,$dbusername,$dbpassword);
$dbselect = mysql_select_db("erkamtr1",$dbconnect);
$sql = "INSERT INTO kontak (port1open,port2open) VALUES ('",$_GET ["data1"]."','".$_GET["data2"]."')";
mysql_query($sql);
?>