<?php include('data.php');

session_start();
ob_start;
session_destroy();
header ("location:g.php");
ob_end_flush();

?>