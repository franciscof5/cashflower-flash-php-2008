<?php
session_start();
$_SESSION["primeiroLogin"]=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cash Flower - Painel Principal</title>
<!-- CSS GERAL -->
<link href="include/cash_flower_estilo.css" rel="stylesheet" type="text/css">

<!-- CALENDARIO JS -->
<link type="text/css" rel="stylesheet" href="include/calendario/dhtmlgoodies_calendar.css" media="screen">
<script type="text/javascript" src="include/calendario/dhtmlgoodies_calendar.js"></script>

<!-- MOOTOOLS -->
<script type="text/javascript" src="include/mootools.js"></script>

<!-- FLASH JAVASCRIPT -->
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<!-- JAVASCRIPTS -->
<script language="javascript">
function lancar() {
	window.alert("lancando");
}
// somador pelos links ao lado dos campos de mais e menos
function maisValor (valorValor) {
	
	var novoValorValor = new Number(document.forms[0].valor.value);
	novoValorValor+=valorValor;
	document.forms[0].valor.value=novoValorValor;
}
function maisQtd (valorQtd) {
	var novoValorQtd = new Number(document.forms[0].quantidade.value);
	novoValorQtd+=valorQtd;
	document.forms[0].quantidade.value=novoValorQtd;
}

//Deslizador mootools, fx.slide
window.addEvent('domready', function() {
	var status = {
		'true': 'open',
		'false': 'close'
	};
	
	//-vertical
	var myVerticalSlide = new Fx.Slide('vertical_slide');
	//myVerticalSlide.open =false;
	//$('v_toggle').open =false;

	$('v_toggle').addEvent('click', function(e){
		e.stop();
		myVerticalSlide.toggle();
	});
	
	/*$('v_hide').addEvent('click', function(e){
		e.stop();
		myVerticalSlide.hide();
		$('vertical_status').set('html', status[myVerticalSlide.open]);
	});*/
	
	$('vertical_slide').slide('hide').slide('out');

	
	// When Vertical Slide ends its transition, we check for its status
	// note that complete will not affect 'hide' and 'show' methods
	myVerticalSlide.addEvent('complete', function() {
		$('vertical_status').set('html', status[myVerticalSlide.open]);
	});
	
});

//Carrega os dados das Contas 29 julho 2008
function carregarConta() {
	//nao vai servir pra porra nenhuma, preciso fazer o PHP o PHP MAN pegar o valor pra consultar no DB
	//alert(document.seletorConta.contaID.value);
	if(document.seletorConta.contaID.value=="registro") {
		document.location = "registrarConta.php";
	} else {
		document.seletorConta.submit();
	}
}
</script>

</head>

<body>
<?php
include_once("include/conectar.php");

$contaSQL = 'SELECT * FROM `contabancaria` WHERE `contaBancariaID`="'.$_POST['contaID'].'";';
$contaQuery = mysql_query($contaSQL, $conexao) or die(mysql_error());
$contaArray = mysql_fetch_assoc($contaQuery);

$bancoSQL = 'SELECT * FROM `banco` WHERE bancoID="'.$contaArray["bancoID"].'"';
$bancoQuery = mysql_query($bancoSQL, $conexao) or die(mysql_error());
$bancoArray = mysql_fetch_assoc($bancoQuery);

if($bancoArray["logo"]=="")
$bancoArray["logo"]="cashflower.jpg"; 

//echo $bancoArray["logo"];

$_SESSION["contaBancariaID"] = $contaArray["contaBancariaID"];

//echo $contaArray["contaBancariaID"];

?>
<!--TABELA QUE SOMENTE POSICIONA NO CENTRO A TABELA CENTRAL -->
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<!-- BARRA LATERAL ESQUERDA -->
		<td>
			<table class="barraLateralEsquerda">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>
		</td>
		
		<!-- TABELA CENTRAL: NUCLEO DO SITE -->
		<td width="780">
			<table width="100%" cellpadding="10" cellspacing="0">
				<!-- BOAS VINDAS -->
				<tr>
					<td colspan="3">
					<center>
					Bem vindo, <?php echo $_SESSION['nome']?>.
					</center>
					</td>
					<td>
					<a href="http://localhost/cashflower">sair</a>
					</td>
				</tr>
				
				<!-- CONTAS BANCARIAS E O GRAFICO -->
				<tr>
					<td>
						<!-- TABELA PRINCIPAL, QUE TEM OS AS CONTAS E O GRAFICO -->
						<table cellspacing="5" cellpadding="10" width="100%">
							<tr height="50">
								<!-- GERENCIADOR DE CONTAs-->
								<td valign="top">
									Selecione a conta
									<br />
									<form name="seletorConta" action="cashflower.php" method="post">
									<select name="contaID" onchange="carregarConta();">
									<?php
									$buscaReferenciasSQL = 'SELECT `userID`,`contaID` FROM `relusercont` WHERE  `userID` = "'.$_SESSION['userID'].'";';
									$buscaReferenciasQuery = mysql_query($buscaReferenciasSQL, $conexao) or die(mysql_error());
									while ($row = mysql_fetch_assoc($buscaReferenciasQuery)) {
										$buscaContasSQL = 'SELECT `contaBancariaID`,`contaNome` FROM `contabancaria` WHERE `contaBancariaID` = "'.$row['contaID'].'";';
										$buscaContasQuery = mysql_query($buscaContasSQL, $conexao) or die(mysql_error());
										$buscaArray = mysql_fetch_assoc($buscaContasQuery);
										
										//Se a conta foi a que foi selecionada deve estar marcada
										if($contaArray["contaBancariaID"]==$buscaArray["contaBancariaID"])
										echo '<option value="'.$buscaArray["contaBancariaID"].'" selected="selected">'.$buscaArray["contaNome"].'</option>';
										else
										echo '<option value="'.$buscaArray["contaBancariaID"].'">'.$buscaArray["contaNome"].'</option>';
									}
									?>
									<option value="registro">Registrar outra conta</option>
									</select>
									</form>
									<!--INÍCIO DO PAINEL DE MANIPULAÇAO DE CONTAS -->
									<br />
									<?php
									echo '<img src="imagens/bancos/'.$bancoArray["logo"].'" />';
									echo '
									<br />
									<br />
									Disponível: <b>'.$contaArray['saldoInicial'].'</b>';
									?>
									
									<div class="marginbottom">
									<a id="v_toggle" href="#">Fazer um lançamento</a>
									<!--
									|
									<strong>status</strong>: <span id="vertical_status">open</span>
									-->
									</div>
									<!--<a href="registrarConta.php">Registrar Outra Conta</a>-->
									<a href="registrarConta.php">Excluir essa conta</a>
								</td>
								<td><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','550','height','280','title','Grafico, baixe o flash player','src','grafico','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','grafico' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="550" height="280" title="Grafico, baixe o flash player">
									<param name="movie" value="grafico.swf" />
									<param name="quality" value="high" />
									<param name="wmode" value="transparent" />
									<embed src="grafico.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="550" height="280"></embed>
								</object></noscript>								
								</td>
							</tr>
							
						</table>
					</td>
				</tr>
				
				<!-- LANCADOR -->
				<tr id="vertical_slide">
					<td width="100%">
						a
					</td>
				</tr>
				
				<!-- ADSENSE -->
				<tr>
					<!-- ADSENSE -->
					<td>
					adsense
					</td>
				</tr>
			</table>
		</td>
		
		<!-- BARRA LATERAL DIREITA -->
		<td bordercolor="#4E6694">
			<table class="barraLateralDireita">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>		
		</td>
	</tr>
	
	<!-- RODAPÉ DA PÁGINA -->
	<tr>
		<!-- BARRA LATERAL ESQUERDA -->
		<td>
			<table class="barraLateralEsquerda">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>
		</td>
		<!-- CONTEUDO DO RODAPE -->
		<td class="tdRodape" colspan="1">
		Desenvolvido por Francisco Matelli - www.franciscomatelli.com
		</td>
		<!-- BARRA LATERAL DIREITA -->
		<td>
			<table class="barraLateralDireita">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>		
		</td>
	</tr>
</table>

</body>
</html>
