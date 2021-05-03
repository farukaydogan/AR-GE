<?php
$con=mysqli_connect('localhost','erkamtr1','Zftjp8jY');

if(!$con)
{
echo 'Not Connected To Server';
}
if(!mysqli_select_db($con,'erkamtr1'))
{
echo 'Database Not Selected';
}

$sql = "INSERT INTO kontak (port1open,port2open) VALUES ('".$_GET ["data1"]."','".$_GET["data2"]."')";

if(!mysqli_query($con,$sql))
{
echo 'not ınserted'
}

else 
{
echo 'ınserted'
}
?>