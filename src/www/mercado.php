<?php
require_once("system.php");?>

<script>
	var Tempo = 1;
	TempoReal(1);
	TempoReal(2);
	
	function TempoReal(Tipo){
		if(typeof ObjetoAjax["TempoReal" + Tipo] == "undefined"){
			try{
				ObjetoAjax["TempoReal" + Tipo] = new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e){
				try{
					ObjetoAjax["TempoReal" + Tipo] = new ActiveXObject("Microsoft.XMLHTTP");
				}catch(e){
					ObjetoAjax["TempoReal" + Tipo] = new XMLHttpRequest();
				}
			}
		}
		ObjetoAjax["TempoReal" + Tipo].onreadystatechange = function (){
			if(ObjetoAjax["TempoReal" + Tipo].readyState == 4 && (ObjetoAjax["TempoReal" + Tipo].status == 200 || ObjetoAjax["TempoReal" + Tipo].status == 500)){
				if(ObjetoAjax["TempoReal" + Tipo].responseText != ""){
					if(Tipo == 1){
						PovoarOrdens(JSON.parse(ObjetoAjax["TempoReal" + Tipo].responseText));
						console.log("Ordens atualizadas");
					}else{
						PovoarMercado(JSON.parse(ObjetoAjax["TempoReal" + Tipo].responseText));
						console.log("Mercado atualizado");
					}
				}
			}
		}
		if(Tipo == 1){
			ObjetoAjax["TempoReal" + Tipo].open("GET", "translate.php?tipo=Ordens&pair=<?php echo $_GET["pair"];?>", true);
		}else{
			ObjetoAjax["TempoReal" + Tipo].open("GET", "translate.php?tipo=Mercado&pair=<?php echo $_GET["pair"];?>", true);
		}
		ObjetoAjax["TempoReal" + Tipo].setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ObjetoAjax["TempoReal" + Tipo].send();
	}
	
	function PovoarOrdens(Dados){
		var soma1 = 0, soma2 = 0, conta1 = 0, conta2 = 0, temp;
		for(var i = 0; i < 40; i++){
			temp = parseFloat(Dados["bids"][i][1]);
			if("<?php echo $_GET["pair"];?>" == "btc"){
				if(temp >= 10 == true){
					document.getElementById("1ordem-" + i).style.backgroundColor = "#ff4500";
				}else if(temp >= 5 == true){
					document.getElementById("1ordem-" + i).style.backgroundColor = "#ffa500";
				}else if(temp >= 2 == true){
					document.getElementById("1ordem-" + i).style.backgroundColor = "#ffff66";
				}else{
					document.getElementById("1ordem-" + i).style.backgroundColor = "transparent";
				}
			}else{
				if(temp >= 300 == true){
					document.getElementById("1ordem-" + i).style.backgroundColor = "#ff4500";
				}else if(temp >= 100 == true){
					document.getElementById("1ordem-" + i).style.backgroundColor = "#ffa500";
				}else if(temp >= 10 == true){
					document.getElementById("1ordem-" + i).style.backgroundColor = "#ffff66";
				}else{
					document.getElementById("1ordem-" + i).style.backgroundColor = "transparent";
				}
			}
			document.getElementById("1ordem-" + i).style.transition = "background-color 0.5s linear";
			temp = Dados["bids"][i][0] * 1.01;
			document.getElementById("1ordem-" + i).title = "1% = " + temp.toFixed(5) + 
				"\nOrdens na frente: " + conta1 +
				"\nVolume na frente: " + soma1.toFixed(8);
			soma1 += Dados["bids"][i][1];
			conta1++;
			if(document.getElementById("1ordem-" + i + "-2").innerHTML > Dados["bids"][i][0]){
				document.getElementById("1ordem-" + i + "-0").innerHTML = "<img src=\"images/arrow_down_big.gif\" alt=\"\">";
			}else if(document.getElementById("1ordem-" + i + "-2").innerHTML < Dados["bids"][i][0]){
				document.getElementById("1ordem-" + i + "-0").innerHTML = "<img src=\"images/arrow_up_big.gif\" alt=\"\">";
			}
			document.getElementById("1ordem-" + i + "-1").innerHTML = Dados["bids"][i][1];
			document.getElementById("1ordem-" + i + "-2").innerHTML = Dados["bids"][i][0];
			
			temp = parseFloat(Dados["asks"][i][1]);
			if("<?php echo $_GET["pair"];?>" == "btc"){
				if(temp >= 10 == true){
					document.getElementById("2ordem-" + i).style.backgroundColor = "#ff4500";
				}else if(temp >= 5 == true){
					document.getElementById("2ordem-" + i).style.backgroundColor = "#ffa500";
				}else if(temp >= 2 == true){
					document.getElementById("2ordem-" + i).style.backgroundColor = "#ffff66";
				}else{
					document.getElementById("2ordem-" + i).style.backgroundColor = "transparent";
				}
			}else{
				if(temp >= 300 == true){
					document.getElementById("2ordem-" + i).style.backgroundColor = "#ff4500";
				}else if(temp >= 100 == true){
					document.getElementById("2ordem-" + i).style.backgroundColor = "#ffa500";
				}else if(temp >= 10 == true){
					document.getElementById("2ordem-" + i).style.backgroundColor = "#ffff66";
				}else{
					document.getElementById("2ordem-" + i).style.backgroundColor = "transparent";
				}
			}
			document.getElementById("2ordem-" + i).style.transition = "background-color 0.5s linear";
			temp = Dados["asks"][i][0] / 1.01;
			document.getElementById("2ordem-" + i).title = "1% = " + temp.toFixed(5) + 
				"\nOrdens na frente: " + conta2 +
				"\nVolume na frente: " + soma2.toFixed(8);
			soma2 += Dados["asks"][i][1];
			conta2++;
			if(document.getElementById("2ordem-" + i + "-2").innerHTML > Dados["asks"][i][0]){
				document.getElementById("2ordem-" + i + "-0").innerHTML = "<img src=\"images/arrow_down_big.gif\" alt=\"\">";
			}else if(document.getElementById("2ordem-" + i + "-2").innerHTML < Dados["asks"][i][0]){
				document.getElementById("2ordem-" + i + "-0").innerHTML = "<img src=\"images/arrow_up_big.gif\" alt=\"\">";
			}
			document.getElementById("2ordem-" + i + "-1").innerHTML = Dados["asks"][i][1];
			document.getElementById("2ordem-" + i + "-2").innerHTML = Dados["asks"][i][0];
		}
		if("<?php echo $_GET["pair"];?>" == "btc"){
			setTimeout(function (){
				TempoReal(1);
			}, Tempo * 1000);
		}
	}
	
	function PovoarMercado(Dados){
		var d;
		Dados = Dados.reverse();
		for(var i = 0; i < 40; i++){
			d = Date.now() / 1000;
			d -= Dados[i]["date"];
			d /= 60;
			if(d > 60){
				d /= 60;
				d = d.toFixed(2);
				document.getElementById("mercado-" + i).title = "Tempo: " + d + " horas";
			}else{
				d = d.toFixed(2);
				document.getElementById("mercado-" + i).title = "Tempo: " + d + " minutos";
			}
			d = new Date(Dados[i]["date"] * 1000);
			document.getElementById("mercado-" + i + "-0").innerHTML = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
			if(Dados[i]["type"] == "buy"){
				document.getElementById("mercado-" + i + "-1").innerHTML = "Compra";
				document.getElementById("mercado-" + i + "-1").style.color = "#0a0";
			}else{
				document.getElementById("mercado-" + i + "-1").innerHTML = "Venda";
				document.getElementById("mercado-" + i + "-1").style.color = "#c00";
			}
			document.getElementById("mercado-" + i + "-2").innerHTML = Dados[i]["amount"];
			document.getElementById("mercado-" + i + "-3").innerHTML = Dados[i]["price"];
		}
		if("<?php echo $_GET["pair"];?>" == "btc"){
			setTimeout(function (){
				TempoReal(2);
			}, Tempo * 1000);
		}
	}
</script>

<table class="Center" style="border:none;">
	<tr>
		<td style="vertical-align:top;border:none;">
			<table id="OrdensCompra">
				<tr><th colspan="3">Ordens de compra</th></tr>
				<tr>
					<td onclick="TempoReal(1); TempoReal(2);"></td>
					<th>Quantia</th>
					<th>Valor</th>
				</tr><?php
				for($i = 0; $i < 40; $i++){?>
					<tr id="1ordem-<?php echo $i;?>" onclick="document.ordem.valor.value = document.getElementById('1ordem-<?php echo $i;?>-2').innerHTML;">
						<td id="1ordem-<?php echo $i;?>-0"></td>
						<td id="1ordem-<?php echo $i;?>-1"></td>
						<td id="1ordem-<?php echo $i;?>-2"></td>
					</tr><?php
				}?>
			</table>
		</td>
		<td style="vertical-align:top;border:none;">
			<table id="OrdensVenda">
				<tr><th colspan="3">Ordens de venda</th></tr>
				<tr>
					<td onclick="TempoReal(1); TempoReal(2);"></td>
					<th>Quantia</th>
					<th>Valor</th>
				</tr><?php
				for($i = 0; $i < 40; $i++){?>
					<tr id="2ordem-<?php echo $i;?>" onclick="document.ordem.valor.value = document.getElementById('2ordem-<?php echo $i;?>-2').innerHTML;">
						<td id="2ordem-<?php echo $i;?>-0"></td>
						<td id="2ordem-<?php echo $i;?>-1"></td>
						<td id="2ordem-<?php echo $i;?>-2"></td>
					</tr><?php
				}?>
			</table>
		</td>
		<td style="vertical-align:top;border:none;">
			<table id="Mercado">
				<tr><th colspan="4">Ordens executadas</th></tr>
				<tr><th>Hora</th><th>Tipo</th><th>Quantia</th><th>Valor</th></tr><?php
				for($i = 0; $i < 40; $i++){
					echo "<tr id=\"mercado-".$i."\">
					<td id=\"mercado-".$i."-0\"></td>
					<td id=\"mercado-".$i."-1\"></td>
					<td id=\"mercado-".$i."-2\"></td>
					<td id=\"mercado-".$i."-3\"></td>
					</tr>";
				}?>
			</table>
		</td>
	</tr>
</table>