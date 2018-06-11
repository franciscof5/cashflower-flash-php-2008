<?php
session_start();

include_once("conectar.php");

$valor = $_POST["valor"];
$quantidade = $_POST["quantidade"];
$categoria = $_POST["categoria"];
$data = $_POST["theDate3"].":00";
$comentario = $_POST["comentario"];

//$queryInsercao = mysql_query($queryInsercaoString, $conexao) or die(mysql_error());
echo $valor." | ".$quantidade." | ".$categoria." | ".$data." | ".$comentario." na conta:".$_SESSION["contaBancariaID"];

$queryLancamento = 'INSERT INTO `lancamento` (`lancamentoID`, `valor`, `quantidade`, `data`, `descricao`, `contaID`, `categoriaID`, `posicaoCategoriaXML`) VALUES (NULL, "'.$valor.'", "'.$quantidade.'", "'.$data.'", "'.$comentario.'", "'.$_SESSION["contaBancariaID"].'", \'1\', "'.$categoria.'");';
$queryInsercao = mysql_query($queryLancamento, $conexao) or die(mysql_error());

//echo '<script>document.location="../cashflower.php";</script>';
?>