<?php require_once("system.php");?>

<html>
	<head>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type='text/javascript'>
			google.charts.load('current', {'packages':['annotationchart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart(){
				var data = google.visualization.arrayToDataTable([
				['Hora','Valor'],<?php
				$dados = file_get_contents("https://www.mercadobitcoin.net/api/trades/");
				$dados = json_decode($dados, true);
				foreach($dados as $dado){
					echo "[new Date(".
					date("Y", $dado["date"]).",".
					date("m", $dado["date"]).",".
					date("d", $dado["date"]).",".
					date("H", $dado["date"]).",".
					date("i", $dado["date"]).",".
					date("s", $dado["date"])."),".$dado["price"]."],";
				}?>
				]);
				var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));
				var options = {
					displayAnnotations: true
				};
				chart.draw(data, options);
			}
		</script>
	</head>
	<body>
		<div id='chart_div' style='width: 610px; height: 620px;'></div>
		<br>
		<center><a href="#" onclick="location.reload()">Atualizar</a></center>
	</body>
</html>