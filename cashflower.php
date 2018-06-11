<?php
session_start();
$_SESSION["primeiroLogin"]=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
	var novoValorValor = new Number(document.lancamento.valor.value);
	novoValorValor+=valorValor;
	document.lancamento.valor.value=novoValorValor;
}
function maisQtd (valorQtd) {
	var novoValorQtd = new Number(document.lancamento.quantidade.value);
	if((novoValorQtd+valorQtd)>0)
	novoValorQtd+=valorQtd;
	else
	alert("A quantidade tem que ser maior que 1");
	document.lancamento.quantidade.value=novoValorQtd;
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
	//alert(document.seletorConta.contaBancariaID.value);
	if(document.seletorConta.contaBancariaID.value=="registro") {
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

//BUSCA A CONTA BANCARIA
//echo "post: ".$_POST['contaBancariaID']." session era: ".$_SESSION['contaBancariaID']." --v---->";
//echo $_POST['lancando_'];

if(isset($_POST['contaBancariaID']))
$contaSQL = 'SELECT * FROM `contabancaria` WHERE `contaBancariaID`="'.$_POST['contaBancariaID'].'";';
else
$contaSQL = 'SELECT * FROM `contabancaria` WHERE `contaBancariaID`="'.$_SESSION['contaBancariaID'].'";';

$contaQuery = mysqli_query($conexao, $contaSQL) or die(mysql_error($conexao));
$contaArray = mysqli_fetch_assoc($contaQuery);
#$contaArray = $contaQuery->fetch_assoc();
#var_dump($_SESSION);die;
//BUSCA O BANCO CORRESPONDENTE A CONTA BANCARIA
$bancoSQL = 'SELECT * FROM `banco` WHERE bancoID="'.$contaArray["bancoID"].'"';
$bancoQuery = mysqli_query($conexao, $bancoSQL) or die(mysql_error($conexao));
$bancoArray = mysqli_fetch_assoc($bancoQuery);
#var_dump($bancoArray);die;
//CASO O BANCO NAO TENHA LOGO
if($bancoArray["logo"]=="")
$bancoArray["logo"]="cashflower.jpg";

//DADOS DA CONTA SALVO EM SESSAO
$_SESSION["contaBancariaID"] = $contaArray["contaBancariaID"];
$_SESSION["contaNome"] = $contaArray["contaNome"];
//DADOS DO BANCO SALVO EM SESSAO
$_SESSION["bancoID"] = $bancoArray["bancoID"];
$_SESSION["bancoLogo"] = $bancoArray["logo"];

//INSERT O LANÇAMENTO, ANETS LOGICO DE BUSCAR OS VALORES LANCADOS30 de Julho de 2008
if(isset($_POST["valor"]) AND isset($_POST["theDate3"])) {
	$valor = $_POST["valor"];
	$quantidade = $_POST["quantidade"];
	#$categoria = $_POST["categoria"];
	$categoria=1;
	$data = $_POST["theDate3"].":00";
	$comentario = $_POST["comentario"];
}

//SOMENTE CASO A PAGINA TENHA SIDO CARREGADA A PARTIR DA FUNCAO LANCAR
if(isset($_POST['lancando_']) AND isset($_POST["valor"]) AND isset($_POST["theDate3"])) {
	$queryLancamento = 'INSERT INTO `lancamento` (`lancamentoID`, `valor`, `quantidade`, `data`, `descricao`, `contaBancariaID`, `categoriaID`, `posicaoCategoriaXML`) VALUES (NULL, "'.$valor.'", "'.$quantidade.'", "'.$data.'", "'.$comentario.'", "'.$_SESSION["contaBancariaID"].'", \'1\', "'.$categoria.'");';
	$queryInsercao = mysqli_query($conexao, $queryLancamento) or die(mysql_error($conexao));
}

//BUSCA DE LANCAMENTO, DEPOIS DE SETAR AS SESSIONS CABEÇA
$lancaSQL = 'SELECT `valor`,`quantidade`,`data`,`descricao` FROM `lancamento` WHERE `contaBancariaID`="'.$_SESSION['contaBancariaID'].'"';
$lancaQuery = mysqli_query($conexao, $lancaSQL) or die(mysql_error($conexao));
$lancaArray = mysqli_fetch_assoc($lancaQuery);
#var_dump($lancaQuery);die;
$somaValores=0;
if($lancaArray) {
	while ($row=mysqli_fetch_assoc($lancaQuery)) {
	#foreach ($lancaArray as $row) {
	#while ($row = $lancaQuery->fetch_object()){
		#var_dump($row);die;
		#echo $row['valor']*$row['quantidade']."-";
		$somaValores+=$row['valor']*$row['quantidade'];
	}
	#die;
} /*else {
	$somaValores=0;
}*/

//echo $somaValores;
/*<center>
					<embed src="abertura.swf" width="780px" height="200px" style="margin:0 auto;">
					</center>*/
?>
<center>
	
</center>
<!--TABELA QUE SOMENTE POSICIONA NO CENTRO A TABELA CENTRAL -->
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		
		<!-- CELULA LATERAL ESQUERDA -->
		<tr valign="top">
		<td>
			<table class="barraLateralEsquerda">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>
		</td>
		
		<!-- CELULA CENTRAL -->
		<td width="780" height="380">
			
			<!--TABELA CENTRAL, A MAIS PRINCIPAL DE TODAS -->
			<table width="780" cellpadding="0" cellspacing="0">
				<tr>
					<td>
					<embed src="abertura.swf" width="780px" height="200px" style="margin:0 auto;">
					</td>
				</tr>
				<!-- LINHA DE CIMA, DE BOAS VINDAS -->
				<tr>
					<td background="imagens/fundoDegrade.jpg">
						<!-- 3 CELULAS, LOGO TIPO, WELCOME E SAIR -->
						<table width="780" height="50">
							<tr>
								<td>
								&#x00a0;&#x00a0;<a href="cashflower.php"><img src="imagens/cashflower/logo150x40.png" /></a>
								</td>
								<td>
								Bem vindo, <?php echo $_SESSION['nome']?>.
								</td>
								<td>

								<a href="<?php echo dirname($_SERVER['REQUEST_URI']); ?>/">sair</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<!-- LINHA CONTAS BANCARIAS E O GRAFICO -->
				<tr>
					<td>
						<!-- TABELA PRINCIPAL, QUE TEM OS AS CONTAS E O GRAFICO -->
						<table cellspacing="5" cellpadding="10" width="100%">
							<tr>
								<!-- GERENCIADOR DE CONTAs-->
								<td valign="top">
									<!-- SELECT PARA ESCOLHER CONTAS -->
									<br />
									<form name="seletorConta" action="cashflower.php" method="post">
									<select name="contaBancariaID" onchange="carregarConta();">
									<?php
									$buscaReferenciasSQL = 'SELECT `userID`,`contaBancariaID` FROM `relusercont` WHERE  `userID` = "'.$_SESSION['userID'].'";';
									$buscaReferenciasQuery = mysqli_query($conexao, $buscaReferenciasSQL) or die(mysql_error($conexao));
									while ($row = mysqli_fetch_assoc($buscaReferenciasQuery)) {
										$buscaContasSQL = 'SELECT `contaBancariaID`,`contaNome` FROM `contabancaria` WHERE `contaBancariaID` = "'.$row['contaBancariaID'].'";';
										$buscaContasQuery = mysqli_query($conexao, $buscaContasSQL) or die(mysql_error($conexao));
										$buscaArray = mysqli_fetch_assoc($buscaContasQuery);
										
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
									
									<!-- PAINEL DE MANIPULAÇAO DE CONTAS -->
									<br />
									<?php
									echo '<img src="imagens/bancos/'.$bancoArray["logo"].'" />';
									echo '
									<br />
									<br />
									Disponivel: <b>'.($contaArray['saldoInicial']-$somaValores).'</b>';
									?>
									<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<div class="marginbottom">
									<a id="v_toggle" href="#">Fazer um lancamento</a>
									<!--
									|
									<strong>status</strong>: <span id="vertical_status">open</span>
									-->
									</div>
									<!--<a href="registrarConta.php">Registrar Outra Conta</a>-->
									<a href="excluirConta.php">Excluir essa conta</a>
								</td>
								<!-- GRAFICO -->
								
								<td>
								<?php /*
								<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','550','height','280','title','Grafico, baixe o flash player','src','grafico','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','grafico' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="550" height="280" title="Grafico, baixe o flash player">
									<param name="movie" value="grafico.swf" />
									<param name="quality" value="high" />
									<param name="wmode" value="transparent" />
									<embed src="grafico.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="550" height="280"></embed>
								</object></noscript>	*/ ?>
								<embed src="grafico.swf" width="550px" height="280px">							
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<!-- LINHA LANCADOR -->
				<tr>
					<td width="780">
						<table width="780" id="vertical_slide">
							<tr>
							<form action="cashflower.php" method="post" name="lancamento">
								<td class="lancamentoTD">
									Data
									<br />
									<input name="theDate3" type="text" size="20" onfocus="displayCalendar(document.lancamento.theDate3, 'yyyy-mm-dd', this, true)" />
									<br />
									Categoria (desabilitado)
									<br />
									<input type="text" name="categoria" size="20" disabled="disabled" />
								</td>
								<td class="lancamentoTD">
									Valor
									<br />
									<a href="#" onclick="javascript:maisValor(-1);"><img src="imagens/botaoMenos.jpg" alt="Diminuir valor" width="16" height="16" /></a>
									<input type="text" name="valor" size="4" value="0.00"/>
									<a href="#" onclick="javascript:maisValor(1);"><img src="imagens/botaoMais.jpg" alt="Aumentar valor" width="16" height="16"/></a>
									<br />
									Quantidade
									<br />
									<a href="#" onclick="javascript:maisQtd(-1);"><img src="imagens/botaoMenos.jpg" alt="Diminuir quantidade" width="16" height="16" /></a>
									<input type="text" name="quantidade" size="4" value="1" />
									<a href="#" onclick="javascript:maisQtd(1);"><img src="imagens/botaoMais.jpg" alt="Aumentar quantidade" width="16" height="16"/></a>
								</td>
								<td class="lancamentoTD">
									Anotacoes (opcional)
									<br />
									<textarea name="comentario" rows="2" cols="25"></textarea>
								</td>
								<td class="lancamentoTD">
									<br />
									<br />
									<input type="hidden" name="lancando_" value="1" />
									<input type="submit" value="Lancar" />
								</td>
							</form>
							</tr>
						</table>
					</td>
				</tr>
				
				<!-- LINHA ADSENSE ??
				<tr>
					<td>
					a
					</td>
				</tr> -->
			</table>
		</td>
		
		<!-- CELULA LATERAL DIREITA -->
		<td>
			<table class="barraLateralDireita">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>		
		</td>
	</tr>
	
	<!-- RODAPÉ DA PÁGINA QUE TEM 3 CELULAS LOGICO -->
	<tr>
		<!-- CELULA LATERAL ESQUERDA continuação -->
		<td>
			<table class="barraLateralEsquerda">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>
		</td>
		<!-- CELULA CENTRAL, DO RODAPE -->
		<td class="tdRodape">
			<p>Desenvolvido por Francisco Matelli - <a href="https://www.franciscomat.com">www.franciscomat.com</a></p>

		</td>
		<!-- CELULA LATERAL DIREITA continuação -->
		<td>
			<table class="barraLateralDireita">
				<tr>
					<td>&#x00a0;</td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
<p><center><small>2018 review - grafico.swf was replaced by an sample, need maintence</small></center></p>
</body>
</html>
