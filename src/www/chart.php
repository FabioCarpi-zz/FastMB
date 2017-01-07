<?php require_once("system.php");?>

<html>
<head>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['line']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Hora');
			data.addColumn('number', 'Valor');
			data.addRows([<?php
				$dados = file_get_contents("https://www.mercadobitcoin.net/api/trades/");
				$dados = json_decode($dados, true);
				$dados = array_reverse($dados);
				foreach($dados as $dado){
					echo "['".date("H:i:s",$dado["date"])."',".$dado["price"]."],";
				}?>
			]);
			var formatter = new google.visualization.NumberFormat(
				{negativeColor: 'red', negativeParens: true, pattern: '$#,###.#####'}
			);
			formatter.format(data, 1);
			var options = {
				legend: {position: 'none'},
				width: 600,
				height: 600
			};
			var chart = new google.charts.Line(document.getElementById('line_top_x'));
			chart.draw(data, options);
		}
	</script>
</head>
<body>
	<div id="line_top_x"></div>
</body>
</html>