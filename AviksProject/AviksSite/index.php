<?php include('data.php');

session_start();
if(!isset($_SESSION["login"])){


echo "<a href=index.php>Giriş Yap</a>";
header("Location:g.php");

}
else
{


$kontaklar=$conn->query("Select * from kontak where id='1'")->fetch(PDO::FETCH_ASSOC);
$port1open=$kontaklar['port1open'];
$kontak1ad=$kontaklar['port1ad'];
$port2open=$kontaklar['port2open'];
$kontak2ad=$kontaklar['port2ad'];
$port3open=$kontaklar['port3open'];
$kontak3ad=$kontaklar['port3ad'];
$port4open=$kontaklar['port4open'];
$kontak4ad=$kontaklar['port4ad'];
/* Database connection settings */
	$host = 'localhost';
	$user = 'erkamtr1';
	$pass = '';
	$db = 'kontrol';
	$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

	$port1ad = '';
	$port2ad  = '';

	//query to get data from the table
	$sql = "SELECT * FROM kontak ORDER BY id DESC";
    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {

		$port1ad= $port1ad. '"'. $row['port1ad'].'",';
		$port2ad= $port2ad . '"'. $row['port2ad'] .'",';
		$port3ad= $port3ad . '"'. $row['port3ad'] .'",';
		$port4ad= $port4ad . '"'. $row['port4ad'] .'",';
		$port5ad= $port5ad . '"'. $row['port5ad'] .'",';

	}

	$port1ad= trim($port1ad,",");
	$port2ad= trim($port2ad,",");
	$port3ad= trim($port3ad,",");
	$port4ad= trim($port4ad,",");
	$port5ad= trim($port5ad,",");
 ?>
 <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset= "utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<title>Aviks Projesi</title>
<style>

body {
	background:#444 url(img/art.png) repeat-x center top;
	font-family:  "Arial", Helvetica, sans-serif  ;	
	font-size:11px;
	line-height:22px;
	color:#fff;
  text-align: center;
}
.container {
				color: #E8E9EB;
				background: #222;
				border: #555652 1px solid;
				padding: 10px;
			}

  
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
button[type=button]
{
  width: 100%;
  background-color: red;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
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

  padding: 20px;
}
h3{ text-align: center;}
</style>
</head>

<body>

<h3>AVİKS Projesi Yönetim Paneli</h3>

<div class="container">	
	  	  <h1>USE CHART.JS WITH MYSQL DATASETS</h1>       
			<canvas id="chart" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
   
			<div>
<button type ="button" onclick="<a href="uye_cikis.php"</a>Çıkış Yap</button>
  <form action="guncelle.php" method="POST">
  <label for="fname">On/Off System  <input type="checkbox" name="port1open" <?php if($port1open==1) {echo 'checked value="1"';} else {echo 'value="0"';}?>> Açık olması için tıklayınız<br></label>
    <input type="Submit" value="Kaydet">
  </form>
</div>
			<script>
			var d=new Date();
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'line',
		        data: {
		            labels: [d.getMinutes()-8,d.getMinutes()-7,d.getMinutes()-6,d.getMinutes()-5,d.getMinutes()-4,d.getMinutes()-3,d.getMinutes()-2,d.getMinutes()-1,d.getMinutes()],
		            datasets: 
		            [{
		                label: 'Kontak 1',
		                data: [<?php echo $port1ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 3
		            },

		            {
		            	label: 'Kontak 2',
		                data: [<?php echo $port2ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(0,255,255)',
		                borderWidth: 3	
		            }
					,
					{
		            	label: 'Kontak 3',
		                data: [<?php echo $port3ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(170,255,255)',
		                borderWidth: 3	
		            }
					,
					{
		            	label: 'Kontak 4',
		                data: [<?php echo $port4ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,0,255)',
		                borderWidth: 3	
		            }
					,
					{
		            	label: 'Kontak 5',
		                data: [<?php echo $port5ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,255,0)',
		                borderWidth: 3	
		            }
					,
					]
		        },
		     
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    });
			</script>
	    </div>
	 

</body>
</html>
<?php
}		

