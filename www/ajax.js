var ObjetoAjax = [], Atualizar = [];

function Ajax(Url, Retorno, Dados, Refresh){
    var PageTarget;
    clearTimeout(Atualizar[Retorno]);
    if(typeof Refresh == "undefined"){
        clearTimeout(Atualizar[Retorno]);
    }else{
        if(Refresh == "self"){
            PageTarget = Url;
        }else{
            PageTarget = Refresh;
        }
        Atualizar[Retorno] = setTimeout(function(){
            Ajax(PageTarget, Retorno, Dados, Refresh);
        }, 30*1000);
    }
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