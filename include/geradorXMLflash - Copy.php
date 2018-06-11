<?php
include_once("conectar.php");

//DEElanalsdn129u3p1jlk aqd91u2pejalkn do1i2ue onand q23 rohlsndfa werpyhq2nr0sw8rhoq23nr p2h rln
$_SESSION['contaBancariaID'] = 6;

//declarando variaveis
$lancaSQL = 'SELECT `valor`,`quantidade`,`data`,`descricao` FROM `lancamento` WHERE `contaBancariaID`="'.$_SESSION['contaBancariaID'].'" ORDER BY `data`';
$lancaQuery = mysql_query($lancaSQL, $conexao) or die(mysql_error());
$array = array();
$valorXquantidade;
//$somaValores;
$diaConsulta;

$xml = '<?xml version=\"1.0\" encoding=\"UTF-8\" ?> <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">';
$xml.="<lancamentos>";

while ($row=mysql_fetch_array($lancaQuery)) {
	//Utilização direta dos dados da consulta
	$valorXquantidade+=$row['valor']*$row['quantidade'];
	$data = strtotime($row['data']);
	//echo "VALOR: ".$valorXquantidade." -- ";
	//echo date("d",$data);
	//Se for o mesmo dia
	if($diaConsulta==date("d",$data)) {
		//MESMO DIA
		$ultimoElemento = array_pop($array);
		echo $ultimoElemento+$valorXquantidade;
		array_push($array, $ultimoElemento+$valorXquantidade);
		//$somaValores+=valorXquantidade;
		//adicionar ao numero final do array
	} else {
		//DIA DIFERENTE
		//echo " - GRAMPEOU TAG - ";
		
		//$xml.=somaValores."</valor><valor>";
		array_push($array, $valorXquantidade);
	}
	//Serve para saber se o dia desta consulta será o igual o da próxima
	$diaConsulta = date("d",$data);
	
	//echo $data;
	//$data = date("Y/m/d h:m:s",strtotime($row['data']);
	//echo " dps:".$data;
	//echo " tipo:".gettype($data);
	//$xml.="<valor>".$somaValores."</valor>";
}

for ($x=0;$x<count($array);$x++) {
	//echo " AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA ".$array[$x];
	$xml.="<valor>".$array[$x]."</valor>";
}
$xml.="</lancamentos>";

echo $xml;

//mysql_free_result($lancaArray);

?>