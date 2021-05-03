<?php
$servername = "localhost";
$username = "erkamtr1";
$password = "Zftjp8jY";
$dbname = "erkamtr1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO kontak (port1ad,port2ad,port3ad,port4ad,port1open) VALUES ('".$_GET ["port1ad"]."','".$_GET["port2ad"]."','".$_GET["port3ad"]."','".$_GET["port4ad"]."','".$_GET["port4ad"]."')";
$sql2="UPDATE kontak SET port1ad='$kontak1ad'"

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>