function Calcular(){
    num = document.simulador.reais.value / document.simulador.compra.value;
    document.simulador.bitcoins.value = num.toFixed(8);
    num = document.simulador.bitcoins.value * 0.003;
    document.simulador.taxac.value = num.toFixed(8);
    num = document.simulador.bitcoins.value - document.simulador.taxac.value;
    document.simulador.comprado.value = num.toFixed(8);
    num = document.simulador.compra.value * 1.01;
    document.simulador.venda.value = num.toFixed(5);
    num = document.simulador.comprado.value * 0.003;
    document.simulador.taxav.value = num.toFixed(8);
    num = document.simulador.comprado.value - document.simulador.taxav.value;
    document.simulador.vendido.value = num.toFixed(8);
    num = document.simulador.vendido.value * document.simulador.venda.value;
    document.simulador.saldo.value = num.toFixed(5);
    num = document.simulador.saldo.value - document.simulador.reais.value;
    document.simulador.ganho.value = num.toFixed(5);
    num = (document.simulador.saldo.value - document.simulador.reais.value) * 100 / document.simulador.reais.value;
    document.simulador.lucro.value = num.toFixed(2) + '%';
}

function Calcular2(){
    num = document.simulador.vendido.value * document.simulador.venda.value;
    document.simulador.saldo.value = num.toFixed(5);
    num = document.simulador.saldo.value - document.simulador.reais.value;
    document.simulador.ganho.value = num.toFixed(5);
    num = (document.simulador.saldo.value - document.simulador.reais.value) * 100 / document.simulador.reais.value;
    document.simulador.lucro.value = num.toFixed(2) + '%';
}