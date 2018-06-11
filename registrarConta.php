<?php
session_start();
?>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cash Flower - Administrador Financeiro</title>
<link href="include/cash_flower_estilo.css" rel="stylesheet" type="text/css">
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<!-- MOOTOOLS -->
<script type="text/javascript" src="include/mootools.js"></script>

<!-- MINHAS FUNCOES -->
<script language="javascript">
//DESLIZADOR
window.addEvent('domready', function() {
	var status = {
		'true': 'open',
		'false': 'close'
	};
	
	//-vertical
	var myVerticalSlide = new Fx.Slide('vertical_slide');
	//myVerticalSlide.open =false;
	//$('v_toggle').open =false;

	/*$('v_toggle').addEvent('click', function(e){
		e.stop();
		myVerticalSlide.toggle();
	});
	
	$('v_hide').addEvent('click', function(e){
		e.stop();
		myVerticalSlide.hide();
		$('vertical_status').set('html', status[myVerticalSlide.open]);
	});*/
	
	$('vertical_slide').slide('hide').slide('out');
	//$('vertical_slide').slide('hide').slide('out');
	
	// When Vertical Slide ends its transition, we check for its status
	// note that complete will not affect 'hide' and 'show' methods
	myVerticalSlide.addEvent('complete', function() {
		$('vertical_status').set('html', status[myVerticalSlide.open]);
	});
	
});
function adicionarCampo() {
	//alert(document.forms[0].bancoID.value);
	if(document.forms[0].bancoID.value=="outro") {
		$('vertical_slide').slide('toggle').slide('in');
	} else {
		$('vertical_slide').slide('toggle').slide('out');
	}
}
</script>
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">

<?php
include_once("include/conectar.php");

if(isset($_POST["bancoNome"])) {
	$bancoNome = $_POST["bancoNome"];
	$contaNome = $_POST["contaNome"];
	$bancoID = $_POST["bancoID"];
	$numeroConta = $_POST["numeroConta"];
	$descricaoConta = $_POST["descricaoConta"];
	$saldoInicial = $_POST["saldoInicial"];
	$bandeira = $_POST["bandeira"];
} else {
	$bancoNome=NULL;
	$contaNome=NULL;
	$bancoID=NULL;
	$numeroConta=NULL;
	$descricaoConta=NULL;
	$saldoInicial=NULL;
	$bandeira=NULL;
}

$cadastramentoCorreto_ = true;

if($_SESSION["primeiroLogin"]==1 and $numeroConta==NULL and $saldoInicial==NULL and $bandeira==NULL) {
	$msg = "Bem vindo <b>".$_SESSION["nome"]."</b>, antes de começar a utilizar o sistema, registre uma conta bancária ";
	$cadastramentoCorreto_ = false;
} else {
	$msg = "Preencher os campos: ";
	
	if($bancoID==NULL) {
		$msg .= ' Escolher o Banco,';
		$cadastramentoCorreto_ = false;
	}
	if($numeroConta==NULL) {
		$msg .= ' Número da Conta,';
		$cadastramentoCorreto_ = false;
	}
	if($saldoInicial==NULL) {
		$msg .= ' Saldo Inicial,';
		$cadastramentoCorreto_ = false;
	}
	if($bandeira==NULL) {
		$msg .= ' Bandeira,';
		$cadastramentoCorreto_ = false;
	}
	if($contaNome==NULL) {
		$msg .= ' Nome da Conta,';
		$cadastramentoCorreto_ = false;
	}
}
/*REGISTEO PREVIO DE BANCOS NOVOS*/
if($bancoNome!=NULL) {
	$queryBancoExistenteSQL = 'SELECT `bancoNome` FROM `banco` WHERE  `bancoNome` = "'.$bancoNome.'";';
	$queryBancoExistente = mysqli_query($conexao,$queryBancoExistenteSQL) or die(mysql_error());
	$queryBanco = mysqli_fetch_assoc($queryBancoExistente);
	
	if($queryBanco["nomeFantasia"]==$bancoNome) {
		$msg = "Este banco já está registrado";
	} else {
		$queryInserirBancoSQL2 = 'INSERT INTO `banco` (`bancoNome`) VALUES ("'.$bancoNome.'");';
		mysqli_query($conexao,$queryInserirBancoSQL2) or die(mysql_error());
		$msg = "Banco registrado com sucesso";
	}
	
}
/*ESSE EMAIL NOT NULL SERVE PARA SABER SE EH A PRIMEIRA VEZ QUE ELE ENTRA NA PAGINA*/
if($cadastramentoCorreto_==true) {
	//
	$queryRegistroString = 'INSERT INTO `contabancaria` (`contaBancariaID`, `contaNome`, `numeroConta`, `bancoID`, `bandeira`, `saldoInicial`, `descricao`) VALUES (\'\', "'.$contaNome.'", "'.$numeroConta.'", "'.$bancoID.'", "'.$bandeira.'", "'.$saldoInicial.'", "'.$descricaoConta.'");';	
	$queryRegistro = mysqli_query($conexao,$queryRegistroString) or die(mysql_error());
	//
	$queryContaString = 'SELECT `contaBancariaID` FROM `contabancaria` WHERE `numeroConta` = "'.$numeroConta.'";';
	$queryConta = mysqli_query($conexao,$queryContaString) or die(mysql_error());
	$queryContaArray = mysqli_fetch_assoc($queryConta);
	//
	$queryRelacionalString = 'INSERT INTO `relusercont` (`relUserContID`, `userID`, `contaBancariaID`) VALUES (\'\', "'.$_SESSION["userID"].'", "'.$queryContaArray["contaBancariaID"].'");';
	$queryConta = mysqli_query($conexao,$queryRelacionalString) or die(mysql_error());
	//
	$msg = 'Cadastro realizado com sucesso!';
	//$msg = $queryContaArray["contaBancariaID"];
	//$msg = $_SESSION["userID"];
	echo '<script>document.location="cashflower.php";</script>';
}
//Apenas para pegar os bancos
$queryBancosString = 'SELECT `bancoNome`,`bancoID` FROM `banco` ORDER BY `bancoNome`;';
$queryBancos = mysqli_query($conexao,$queryBancosString) or die(mysql_error());
?>

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
		
		<!-- INICIO DO NUCLEO CENTRAL DO SITE -->
		<td width="780">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<!-- A ANIMCAO, UMA LINHA DA TABELA COM O FLASH -->
					<td colspan="3">
						<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','780','height','200','title','Abertura em flash','src','abertura','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','bgcolor','#FFFFFF','movie','abertura' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="780" height="200" title="Abertura em flash">
						<param name="movie" value="abertura.swf" />
						<param name="quality" value="high" /><param name="BGCOLOR" value="#FFFFFF" />
						<embed src="abertura.swf" width="780" height="200" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" bgcolor="#FFFFFF"></embed>
						</object></noscript>
						</td>
					</tr>
				<tr>
					<td>
						<!-- TABELA QUE TEM OS ITENS E TALS -->
						<table cellspacing="5" cellpadding="10" width="100%">
							<tr valign="top">
								<td width="290" class="alertaLogin">
									<?php echo $msg; ?>									
								</td>
								<td class="alertaLogin">
									&#x00a0;							
								</td>
							</tr>
							<tr valign="top">
								<td width="400">
									<form method="post" action="registrarConta.php" name="formularioConta">
										<p>Nome do Banco<br />
											<select name="bancoID" onchange="javascript:adicionarCampo();">
											<option value="">Escolha o banco</option>
											
											<?php
											while ($row = mysqli_fetch_assoc($queryBancos)) {
												echo '<option value="'.$row["bancoID"].'">'.$row["bancoNome"].'</option>';
											}
											?>
											<option value="outro">Outro banco</option>
											</select>
											
											<br />	
											<div id="vertical_slide">									
												Caso seu banco não esteja listado, coloque o nome
												<br />
												<input name="bancoNome" type="text" size="20" value=<?php echo $bancoNome;?> >	
												</input>
												<br />
												<br />
											</div>
											Nome da conta (será exibido na tela)
											<br />
											<input name="contaNome" type="text" size="20" maxlength="20" value=<?php echo $numeroConta;?> >
											</input>				
											<br />
											<br />
											Número da Conta (com dígitos)
											<br />
											<input name="numeroConta" type="text" size="20" value=<?php echo $numeroConta;?> >
											</input>
											<br />
											<br />
											Saldo Inicial
											em R$ (reais)<br />
											<input name="saldoInicial" type="text" size="20" value=<?php echo $saldoInicial;?> >
											<br />
											<br />
											Selecione a bandeira se exister um Cartão de Crédito associado a conta
											<br />
											<select name="bandeira">
												<?php echo "<option value='$bandeira'>$bandeira</option>"; ?>
												<option value="Não há função crédito">Não há função crédito</option>
												<option value="Visa">Visa</option>
												<option value="Master">Master</option>
												<option value="American Express">American Express</option>
												<option value="Outra bandeira">Outra bandeira</option>
											</select>
											<br />
											<br />
											Descrição da conta (opcional)
											<br />
											<input name="descricaoConta" type="text" size="60" value=<?php echo $descricaoConta;?> >
											</input>
											<br />
											<br />
											<input type="submit" value="Registrar Conta" />
											<?php 
											//echo $_SESSION["primeiroLogin"];
											if($_SESSION["primeiroLogin"]==0)
											echo '<input type="button" value="Voltar" onclick="javascript:window.location=\'cashflower.php\'"/>';
											?>
										</p>
									</form>								
									</td>
								<td><h2>Exlcuindo uma conta:</h2>
								<p>-Cuidado ao excluir contas, pois todos os dados da conta serão perdidos.</p>
								<p>-Você só pode utilizar o sistema se mantiver uma conta ativa, se essa for sua última conta e voce a deletar, terá que criar mais uma.</p>
								</td>
							</tr>
						</table>
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