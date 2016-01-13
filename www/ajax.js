var ObjetoAjax = [], Atualizacoes = [];

function Ajax(Url, Retorno, Dados, Atualizar){
    TimerStop(Retorno);
    if(typeof ObjetoAjax[Retorno] == "undefined"){
        try{
            ObjetoAjax[Retorno] = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try{
                ObjetoAjax[Retorno] = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(e){
                ObjetoAjax[Retorno] = new XMLHttpRequest();
            }
        }
    }
	ObjetoAjax[Retorno].onreadystatechange = function (){
		if(ObjetoAjax[Retorno].readyState == 1){
			document.getElementById(Retorno).innerHTML = "<img src=\"http://public-img.protocollive.com.br/carregando.gif\" alt=\"\">";
			document.body.style.cursor = "progress";
		}else if(ObjetoAjax[Retorno].readyState == 4 && ObjetoAjax[Retorno].status == 404){
			document.getElementById(Retorno).innerHTML = "Erro 404: Página não encontrada";
			document.body.style.cursor = "default";
		}else if(ObjetoAjax[Retorno].readyState == 4 && (ObjetoAjax[Retorno].status == 200 || ObjetoAjax[Retorno].status == 500)){
			document.getElementById(Retorno).innerHTML = ObjetoAjax[Retorno].responseText;
            if(Atualizar == true){
                Atualizacoes[Retorno] = setTimeout(function (){
                    Ajax(Url, Retorno, null, true);
                }, 30 * 1000);
            }
            Executar(Retorno);
			document.body.style.cursor = "default";
		}
	}
	if(Dados == null){
		ObjetoAjax[Retorno].open("GET", Url, true);
	}else{
		ObjetoAjax[Retorno].open("POST", Url, true);
		ObjetoAjax[Retorno].setRequestHeader("Content-type", "application/x-www-form-Urlencoded");
		ObjetoAjax[Retorno].setRequestHeader("Content-length", Dados.length);
		ObjetoAjax[Retorno].setRequestHeader("Connection", "close");
	}
	ObjetoAjax[Retorno].send(Dados);
}

function TimerStop(Id){
    clearTimeout(Atualizacoes[Id]);
}

function Executar(Local){
    var Comando, Texto = document.getElementById(Local).innerHTML;
    while(Texto.indexOf("<script") >= 0){
        Texto = Texto.substr(Texto.indexOf("<script") + 7);
        Texto = Texto.substr(Texto.indexOf(">") + 1);
        Comando = Texto.substr(0, Texto.indexOf("</script>"));
        if(Comando != ""){
            window.eval(Comando);
        }
        Texto = Texto.substr(Texto.indexOf("</script>") + 9);
    }
}