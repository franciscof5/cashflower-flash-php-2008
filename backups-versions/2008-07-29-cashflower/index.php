<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cash Flower - Administrador Financeiro</title>
<link href="include/cash_flower_estilo.css" rel="stylesheet" type="text/css">
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">

<?php
include_once('include/conectar.php');

$email = $_POST["email"];
$senha = $_POST["senha"];

$msg = "Informe o usuário e a senha";

$queryEmailString = 'SELECT `email` FROM `usuario` WHERE `email` = "'.$email.'";';

$queryEmail = mysql_query($queryEmailString, $conexao) or die(mysql_error());

$queryEmailArray = mysql_fetch_assoc($queryEmail);

if($email!=NULL and $senha!=NULL) {
	if($queryEmailArray["email"]!=$email) {
		$msg = "Email disponível, faça o cadastro!";
	} else {
		$querySenhaString = 'SELECT `senha` FROM `usuario` WHERE `senha` = "'.$senha.'";';
		$querySenha = mysql_query($querySenhaString, $conexao) or die(mysql_error());
		$querySenhaArray = mysql_fetch_assoc($querySenha);
		
		if($querySenhaArray["senha"]==$senha) {
			//FAZ BUSCA PARA VER SE O USUARIO TEM CONTA BANCARIA E PEGAR O NOME DELE, SE NAO TEM QUE CRIAR 27 de Julho 2008
			/*$queryContaIDString = 'SELECT `senha` FROM `usuario` WHERE `senha` = "'.$senha.'";';
			$queryContaID = mysql_query($querySenhaString, $conexao) or die(mysql_error());
			$queryContaIDArray = mysql_fetch_assoc($querySenha);
			$_SESSION['conta'] = $parceiro;*/
			//userID
			$queryUserIDString = 'SELECT `userID`,`nome`,`emailValidado_` FROM `usuario` WHERE `email` = "'.$email.'" AND `senha` = "'.$senha.'";';
			$queryUserID = mysql_query($queryUserIDString, $conexao) or die(mysql_error());
			$queryUserIDArray = mysql_fetch_assoc($queryUserID);
			/*echo "<script>alert('".$queryUserIDArray["userID"]."');</script>";
			echo "<script>alert('".$queryUserIDArray["nome"]."');</script>";*/
			$_SESSION['nome'] = $queryUserIDArray["nome"];
			$_SESSION['userID'] = $queryUserIDArray["userID"];
			$_SESSION['emailValidado_'] = $queryUserIDArray["emailValidado_"];
			//enfima pode procurar a conta
			$queryContaString = 'SELECT `userID` FROM `relUserCont` WHERE `userID` = "'.$queryUserIDArray["userID"].'";';
			$queryConta = mysql_query($queryContaString, $conexao) or die(mysql_error());
			$queryContaArray = mysql_fetch_assoc($queryConta);
			/*echo "<script>alert('".$queryUserIDArray["emailValidado_"]."');</script>";*/
			
			//muda de página - tem que verificar se o email está validado ou não 27 de julho 2008
			if(isset($queryContaArray["userID"])) {
				$msg = "Você está logado!";
				echo "<script>window.location='cashflower.php'</script>";
			} else {
				$msg = "Registre uma conta bancária!";
				$_SESSION["primeiroLogin"] = 1;
				echo "<script>window.location='registrarConta.php'</script>";
			}
		} else {
			$msg = "Senha errada!";
		}
		
	}
} else {
	$msg = "Forneça o email e a senha";
}
	
	
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
					<td colspan="3"><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','780','height','200','title','as','src','abertura','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','abertura' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="780" height="200" title="as">
						<param name="movie" value="abertura.swf" />
						<param name="quality" value="high" />
						<embed src="abertura.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="780" height="200"></embed>
					</object></noscript></td>
				</tr>
				<tr>
					<td>
						<!-- TABELA QUE TEM OS ITENS E TALS -->
						<table cellspacing="5" cellpadding="10">
							<tr valign="top">
								<td width="290" rowspan="2">
									<h2>Conheça o Cash Flower</h2>
									<p>É um novo sistema	de fluxo de caixa online, desenvolvido por <a href="http://www.franciscomatelli.com" target="_blank">Francisco Matelli</a>.</p>
								<p>Você não precisa instalar nada no seu computador para começar a usar, basta registrar uma conta, o sistema é online e gratuíto.</p></td>
								<td width="290" rowspan="2">
									<h2>Novidades (blog)</h2>
									<p>Sistema de cadastro em fase de testes, agora já é possível logar no sitema.</p>
									<p>Um formulário de cadastro simples é a primeira parte da interação com usuário, em breve a versão beta estará pronta.</p>
									</td>
								<td class="alertaLogin">
									<?php echo $msg; ?>								
								</td>
							</tr>
							<tr valign="top">
								<td class="login">
									<form method="post" action="index.php">
									Email:
									<input type="text" name="email" value=<?php echo $email; ?> ></input>
									Senha:
									<input type="password" name="senha" />
									<br />
									<br />
									<input type="submit" value="Logar" />
									<input type="button" value="Cadastrar" onclick="javascript:document.location='cadastrar.php';" />
									</form>
								</td>
							</tr>
							<tr height="50">
								<td>
									<img src="imagens/miniatura.jpg" alt="Miniatura do programa" width="218" height="113" />
								</td>
								<td colspan="2">
									<h2>Bastidores</h2>
									<p>Conheço tudo que está por trás deste projeto, fluxogramas, análises estruturadas de sistema, cronogramas, projeção de bancos e mais bancos de dados...</p>
								</td>
								
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
					<script type="text/javascript"><!--
					google_ad_client = "pub-4444527379438255";
					/* 728x90, criado 01/06/08, cash flower parte de baixo */
					google_ad_slot = "3755513128";
					google_ad_width = 728;
					google_ad_height = 90;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
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