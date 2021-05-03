<?php include('data.php');
$kontaklar=$conn->query("Select * from kontak where id='1'")->fetch(PDO::FETCH_ASSOC);
$port1open=$kontaklar['port1open'];
$port2open=$kontaklar['port2open'];
$port3open=$kontaklar['port3open'];
$port4open=$kontaklar['port4open'];
$port5open=$kontaklar['port5open'];

 ?>
<?php if($port1open==1) {echo 'a';} else {echo 'b';}?>
<?php if($port2open==1) {echo 'a';} else {echo 'b';}?>
<?php if($port3open==1) {echo 'a';} else {echo 'b';}?>
<?php if($port4open==1) {echo 'a';} else {echo 'b';}?>
<?php if($port5open==1) {echo 'a';} else {echo 'b';}?>
