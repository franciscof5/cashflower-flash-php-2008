<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cash Flower - Login</title>
<link href="arquivos/cash_flower_estilo.css" rel="stylesheet" type="text/css">
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">

<?php
/*
session_start();
    $_SESSION["login_usuario"] = $login;
    $_SESSION["senha_usuario"] = $senha;
########alterar para a página que quer vizualizar depois do login ################  
    header("Location: loginaceite.php");
	*/
include_once('arquivos/conectar.php');

$email = $_POST["email"];
$senha = $_POST["senha"];
$msg = "Informe o usuário e a senha";

$queryEmailString = 'SELECT `email` FROM `usuario` WHERE `email` = "'.$email.'";';

$queryEmail = mysqli_query($conexao, $queryEmailString) or die(mysql_error($conexao));

$queryEmailArray = mysqli_fetch_assoc($queryEmail);

if($email!=NULL and $senha!=NULL) {
	if($queryEmailArray["email"]!=$email) {
		$msg = "Email disponível, faça o cadastro!";
	} else {
		$querySenhaString = 'SELECT `senha` FROM `usuario` WHERE `senha` = "'.$senha.'";';
		
		$querySenha = mysqli_query($conexao, $querySenhaString) or die(mysql_error($conexao));
		
		$querySenhaArray = mysqli_fetch_assoc($querySenha);
		
		if($querySenhaArray["senha"]==$senha) {
			$msg = "Você está logado!";
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
					<td colspan="3">
						<?php /*
						<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','780','height','200','title','Abertura em flash','src','abertura','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','bgcolor','#FFFFFF','movie','abertura' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="780" height="200" title="Abertura em flash">
						<param name="movie" value="abertura.swf" />
						<param name="quality" value="high" /><param name="BGCOLOR" value="#FFFFFF" />
						<embed src="abertura.swf" width="780" height="200" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" bgcolor="#FFFFFF"></embed>
						</object></noscript>
						*/ ?>
						<embed src="abertura.swf" width="780px" height="200px">
						</td>
					</tr>
				<tr>
					<td>
						<!-- TABELA QUE TEM OS ITENS E TALS -->
						<table cellspacing="5" cellpadding="10">
							<tr valign="top">
								<td width="290" rowspan="2">
									<h2>Conheça o Cash Flower</h2>
									<p>É um novo sistema	de fluxo de caixa, desenvolvido por <a href="http://www.franciscomatelli.com" target="_blank">Francisco Matelli</a>, em parceiria com <a href="http://www.pires.pro.br" target="_blank">Valdemir Pires</a>. </p>
									<p>Sempre pensando nas necessidades dos usuários, o programa tem como base a simplicidade, diferente de tudo que já foi pensado na área.</p></td>
								<td width="290" rowspan="2">
									<h2>Novidades</h2>
									<p>
									É o primeiro sistema de fluxo de caixa e orçamento online, por isso possui funcionalidades que nenhum outro tem.									</p>
									<p>Controle seus gastos aonde estiver, saia de férias mas tenha sempre controle de suas finanças.</p></td>
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