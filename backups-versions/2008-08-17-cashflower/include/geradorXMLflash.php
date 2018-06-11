<?php
session_start();

include_once("conectar.php");

//declarando variaveis
$lancaSQL = 'SELECT `valor`,`quantidade`,`data`,`descricao` FROM `lancamento` WHERE `contaBancariaID`="'.$_SESSION['contaBancariaID'].'" ORDER BY `data`';
$lancaQuery = mysql_query($lancaSQL, $conexao) or die(mysql_error());
$lancaQuery2 = mysql_query($lancaSQL, $conexao) or die(mysql_error());

$array = array();
$valorXquantidade;
$anoConsulta = date("y");
$mesConsulta = date("m");
$mesAtual = date("m");
$diaConsulta = date("d");
$rodadaM=0;
$rodadaD=0;

$xml = '<?xml version=\"1.0\" encoding=\"UTF-8\" ?> <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">';
$xml.="<lancamentos>";

//defino data 1
$ano1 = date("Y");
$mes1 = date("m");
$dia1 = date("d");

/*while ($row=mysql_fetch_array($lancaQuery)) {
	echo DateDiff
}*/

$row=mysql_fetch_array($lancaQuery2);
$data = strtotime($row['data']);
//defino data 2
$ano2 = date("Y",$data);
$mes2 = date("m",$data);
$dia2 = date("d",$data);

//calculo timestam das duas datas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);

//diminuo a uma data a outra
$segundos_diferenca = $timestamp1 - $timestamp2;
//echo $segundos_diferenca;

//converto segundos em dias
$totalDias = $segundos_diferenca / (60 * 60 * 24);

//obtenho o valor absoluto dos dias (tiro o possível sinal negativo)
$totalDias = abs($totalDias);

//tiro os decimais aos dias de diferenca
$totalDias = floor($totalDias);

//echo "dias:".$totalDias."<br><br>"; 

$antigo_dias_diferenca = $totalDias;


while ($row=mysql_fetch_array($lancaQuery)) {
	$valorXquantidade=$row['valor']*$row['quantidade'];
	$data = strtotime($row['data']);
	/*$diaLanca = date("d",$data);
	echo $diaLanca." - ";*/
	//defino data 2
	$ano2 = date("Y",$data);
	$mes2 = date("m",$data);
	$dia2 = date("d",$data);
	
	//calculo timestam das duas datas
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);
	
	//diminuo a uma data a outra
	$segundos_diferenca = $timestamp1 - $timestamp2;
	//echo $segundos_diferenca;
	
	//converto segundos em dias
	$dias_diferenca = $segundos_diferenca / (60 * 60 * 24);
	
	//obtenho o valor absoluto dos dias (tiro o possível sinal negativo)
	$dias_diferenca = abs($dias_diferenca);
	
	//tiro os decimais aos dias de diferenca
	$dias_diferenca = floor($dias_diferenca);
	
	//echo " diferenca entre ultimo dia e o lancamento atual ".($dias_diferenca);
	//echo " vai precisar de ".($antigo_dias_diferenca-$dias_diferenca)." ciclos pra encher com sd<br>";
	
	for($i=1; $i<($antigo_dias_diferenca-$dias_diferenca); $i++) {
		array_push($array, "s/d");
	}
	
	if($antigo_dias_diferenca==$dias_diferenca) {
		//MESMO DIA
		$ultimoElemento = array_pop($array);
		//echo "foi pushado (msm dia): ".($ultimoElemento+$valorXquantidade);
		array_push($array, $ultimoElemento+$valorXquantidade);
	} else {
		//DIA DIFERENTE
		//echo "foi pushado (dif dia): ".$valorXquantidade;
		array_push($array, $valorXquantidade);
	}
	
	
	$antigo_dias_diferenca = $dias_diferenca;
}

//echo "<br><br><hr><br>";
for ($x=0;$x<count($array);$x++) {
	//echo " elemento$x: ".$array[$x]."<br>";
	$xml.="<valor>".$array[$x]."</valor>";
}

$xml.="</lancamentos>";

echo $xml;

//mysql_free_result($lancaArray);


/*while ($row=mysql_fetch_array($lancaQuery)) {

	//Utilização direta dos dados da consulta
	$valorXquantidade=$row['valor']*$row['quantidade'];
	$data = strtotime($row['data']);
	//echo "VALOR: ".$valorXquantidade." -- ";
	if($rodadaM==0) {
		$rodadaM++;
		$mesConsulta = date("m",$data);
	}
	if($rodadaD==0) {
		$rodadaD++;
		$diaConsulta = date("m",$data);
	}
	//A MATADINHA DO CÓDIGO, PREENCHER AS DATAS VAZIA COM 0
	///echo "a-".$mesConsulta."d".date("m",$data);
	//echo $mesConsulta;
	echo "ma:".date("m",$data)." mc:".$mesConsulta." da:".date("d",$data)." dc:".$diaConsulta."<br>";
	
	if(date("m",$data)==$mesAtual) {
		if(date("d",$data)!=$diaConsulta) {
			//echo " sobram: ".(date("d",$data)-$diaConsulta)." ->";
			//Isso se estiver no mesmo mes
			for($i=1; $i<(date("d",$data)-$diaConsulta); $i++) {
				//echo " enfiando".$i;
				array_push($array, "s/d");
			}
		}
	} else {
		if(date("m",$data)!=$mesConsulta) {
			echo " mudou o mes ";
		}
		$diaConsulta = 0;
		$rodadaM++;
	}
	
	if($diaConsulta==date("d",$data)) {
		//MESMO DIA
		$ultimoElemento = array_pop($array);
		//echo "foi pushado (msm dia): ".($ultimoElemento+$valorXquantidade);
		array_push($array, $ultimoElemento+$valorXquantidade);
	} else {
		//DIA DIFERENTE
		//echo "foi pushado (dif dia): ".$valorXquantidade;
		array_push($array, $valorXquantidade);
	}
	
	//echo " dia:".date("d",$data)."valor:".$valorXquantidade."<br>";
	
	//Serve para saber se o dia desta consulta será o igual o da próxima
	$mesConsulta = date("m",$data);
	$diaConsulta = date("d",$data);
}
//echo "<br><hr><br>";
for ($x=0;$x<count($array);$x++) {
	//echo " elemento$x: ".$array[$x];
	$xml.="<valor>".$array[$x]."</valor>";
}
$xml.="</lancamentos>";*/

//echo $xml;

//mysql_free_result($lancaArray);

?>