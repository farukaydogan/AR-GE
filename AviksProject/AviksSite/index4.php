<?php
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
		$time= $time . '"'. $row['time'] .'",';


	}

	$port1ad= trim($port1ad,",");
	$port2ad= trim($port2ad,",");
	$port3ad= trim($port3ad,",");
	$port4ad= trim($port4ad,",");
	$port5ad= trim($time,",");
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<title>Accelerometer data</title>

		<style type="text/css">			
			body{
				font-family: Arial;
			    margin: 80px 100px 10px 100px;
			    padding: 0;
			    color: black;
			    text-align: center;
			    background: white;

			}

		
		</style>

	</head>

	<body>	   

	    <div class="container">	
	  	  <h1>NİSA AYDOGAN <3</h1>       
				<div class="row">
					<div class="col-6">
							<div class="row-md-1">
								<canvas id="chart" style="width: 40%; height: 30%; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
							</div>
							<div class="row">
								<canvas id="chart3" style="width: 40%; height: 60%; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
							</div>
							<div class="row">
								<canvas id="chart5" style="width: 40%; height: 60%; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
							</div>
					</div>

					<div class="col-6">
					<div class="row-md-4 offset-md-1">
					<canvas id="chart2" style="width: 40%; height: 29%; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
					</div>
					<div class="row">
					<canvas id="chart4" style="width: 40%; height: 29%;border-radius:5px; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
					</div>
					</div>

				</div>
			<script>
			var d=new Date();
				var ctx = document.getElementById("chart").getContext('2d');
				var ctx2 = document.getElementById("chart2").getContext('2d');
				var ctx3 = document.getElementById("chart3").getContext('2d');
				var ctx4 = document.getElementById("chart4").getContext('2d');
				var ctx5 = document.getElementById("chart5").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'line',
		        data: {
		            labels: [d.getMinutes()-8,d.getMinutes()-7,d.getMinutes()-6,d.getMinutes()-5,d.getMinutes()-4,d.getMinutes()-3,d.getMinutes()-2,d.getMinutes()-1,d.getMinutes()],
		            datasets: 
		            [{
		                label: 'Kontak 1',
		                data: [<?php echo $port1ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,0,0)',
		                borderWidth: 3
		            },
					]
		        },
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    }
			);
			var myChart2 = new Chart(ctx2, {
        		type: 'line',
			
		        data:	{
		            labels: [d.getMinutes()-8,d.getMinutes()-7,d.getMinutes()-6,d.getMinutes()-5,d.getMinutes()-4,d.getMinutes()-3,d.getMinutes()-2,d.getMinutes()-1,d.getMinutes()],
		            datasets: 
		            [{
		                label: 'Kontak 2',
		                data: [<?php echo $port2ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,0,0)',	xValueType: "dateTime",
		xValueFormatString: "DD MMM hh:mm TT",
		                borderWidth: 3
		            },]
		        },
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    }
			);
			var myChart3 = new Chart(ctx3, {
        		type: 'line',
		        data:	{
		            labels: [d.getMinutes()-8,d.getMinutes()-7,d.getMinutes()-6,d.getMinutes()-5,d.getMinutes()-4,d.getMinutes()-3,d.getMinutes()-2,d.getMinutes()-1,d.getMinutes()],
		            datasets: 
		            [{
		                label: 'Kontak 3',
		                data: [<?php echo $port3ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,0,0)',
		                borderWidth: 3
		            },]
		        },
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    }
			);
			var myChart4 = new Chart(ctx4, {
        		type: 'line',
		        data:	{
		            labels: [d.getMinutes()-8,d.getMinutes()-7,d.getMinutes()-6,d.getMinutes()-5,d.getMinutes()-4,d.getMinutes()-3,d.getMinutes()-2,d.getMinutes()-1,d.getMinutes()],
		            datasets: 
		            [{
		                label: 'Kontak 4 ',
		                data: [<?php echo $port4ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,0,0)',
		                borderWidth: 3
		            },]
		        },
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    }
			);
			var myChart5 = new Chart(ctx5, {
        		type: 'line',
		        data:	{
		            labels: [d.getMinutes()-8,d.getMinutes()-7,d.getMinutes()-6,d.getMinutes()-5,d.getMinutes()-4,d.getMinutes()-3,d.getMinutes()-2,d.getMinutes()-1,d.getMinutes()],
		            datasets: 
		            [{
		                label: 'Kontak 5 ',
		                data: [<?php echo $port5ad; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,0,0)',
		                borderWidth: 3
		            },]
		        },
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    }
			);
			</script>
	    </div>
	    
	</body>
</html>