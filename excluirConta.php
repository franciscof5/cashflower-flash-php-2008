<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cash Flower - Administrador Financeiro</title>
<link href="include/cash_flower_estilo.css" rel="stylesheet" type="text/css">
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">

<?php
include_once("include/conectar.php");

if($_POST['deleta_']) {
	$deletaBancoSQL = 'DELETE FROM `contabancaria` WHERE `contaBancariaID` = "'.$_SESSION['contaBancariaID'].'";';
	mysql_query($deletaBancoSQL) or die(mysql_error());
	
	$deletaRelSQL = 'DELETE FROM `relusercont` WHERE `contaBancariaID` = "'.$_SESSION['contaBancariaID'].'" AND `userID` = "'.$_SESSION['userID'].'";';
	mysql_query($deletaRelSQL) or die(mysql_error());
	
	echo '<script>document.location="cashflower.php";</script>';
}
$msg = "Conta escolhida: ".$_SESSION["contaNome"];
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
								<td width="400" align="center">
									<?php
									echo '<br /><br />';
									echo 'Você tem certeza que quer deletar essa conta:';
									echo '<br />';
									echo '<br />';
									echo '<img src="imagens/bancos/'.$_SESSION["bancoLogo"].'" />';
									echo '<h3>'.$_SESSION["contaNome"] .'</h3>';
									echo '<br />';
									
									echo '<br /><br />';
									//echo $_SESSION['contaBancariaID'];
									?>
									<form action="excluirConta.php" method="post">
									<input type="hidden" name="deleta_" value="1" />
									<input type="submit" value="Excluir Conta"/>
									<input type="button" value="Cancelar" onclick="javascript:document.location='cashflower.php'" />
									</form>
														
								</td>
								<td>
									<h2>Excluindo uma conta:</h2>
									<p>-Cuidado ao excluir sua conta, pois todos os dados desta serão perdidos.</p>
									<p>-Você só pode utilizar o sistema se mantiver no mínimo uma conta ativa. Se essa for a sua única conta e voce a deletar, terá que criar outra.</p>
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