<?php include('data.php');

 ?>

<!DOCTYPE html>
<html lang="tr">
<title> Üye girişi</title>
<head>
    <meta charset= "utf-8"> 
</head>
<style>
  
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
h3{ text-align: center;}
</style>

<body>

<h3>AVİKS Projesi Yönetim Paneli Giriş Yap</h3>

<div>
  <form action="uye_kontrol.php" method="POST">
<label for="fname">Kullanıcı adı</label>
    <input type="text" id="admin" name ="admin" placeholder="Kullanıcı Adı">
    <label for="fname">Şifre</label>
    <input type="text" id="pass" name ="pass" placeholder="Şifre">

    <input type="submit" value="Giriş">
  </form>
</div>

</body>
</html>
