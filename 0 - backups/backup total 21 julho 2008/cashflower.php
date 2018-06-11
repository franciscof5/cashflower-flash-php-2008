<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cash Flower - Francisco Matelli</title>
<link href="include/cash_flower_estilo.css" rel="stylesheet" type="text/css">
<!-- CALENDARIO JS -->
<link type="text/css" rel="stylesheet" href="include/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
<SCRIPT type="text/javascript" src="include/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<!-- FLASH JAVASCRIPT -->
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<!-- LANCADOR -->
<script language="javascript">
function lancar() {
	window.alert("lancando");
}
</script>

</head>

<body>

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
				<!-- TABELA COM O FLASH -->
				<tr>
					<td colspan="3">
					<center>
					Bem vindo, <?php echo $nome?>.
					</center>
					</td>
				</tr>
				<tr>
					<td>
						<!-- TABELA PRINCIPAL, QUE TEM OS ITENS E TALS -->
						<table cellspacing="5" cellpadding="10" width="100%">
							<tr height="50">
								<td>
									(se nao tiver conta apenas essa opção)Adicionar conta
									<a href="#" onclick="javascript:lancar();">Fazer lançamento</a>
									<form action="cashflower.php">
										Valor
										<br />
										<input type="text" name="valor" size="10"/>
										<br />
										<br />
										Quantidade
										<br />
										<input type="text" name="quantidade" size="10" />
										<br />
										<br />
										Categoria (colocar numero)
										<br />
										<input type="text" name="quantidade" size="10" />
										<br />
										<br />
										<!-- 
										data-primeira vez a data de hoje, depois a data do último lançamento, e 
										lancar-assim que lançar não sair da tela, somente zerar o valor e quantidade e categoria
										categoria-alterar assim que colocar o valor, pra receita ou despesa
										qtdd-automáticamente é um, coloar botão + e - pq é uma merda ficar dando foco e alterando pelo teclado
										-->
										Data
										<br />
										<input type="text" name="" size="10" />
										<input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theDate,'yyyy/mm/dd',this)">
										<br />
										<br />
										Comentário (opcional)
										<br />
										<input type="text" name="" size="10" />
										<br />
										<br />
										<input type="submit" value="Lançar" />
									</form>
								</td>
								<td><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','550','height','280','title','Grafico, baixe o flash player','src','grafico','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','grafico' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="550" height="280" title="Grafico, baixe o flash player">
									<param name="movie" value="grafico.swf" />
									<param name="quality" value="high" />
									<embed src="grafico.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="550" height="280"></embed>
								</object></noscript>								
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<center>
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
						</center>
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
