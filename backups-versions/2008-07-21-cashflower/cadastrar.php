<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cash Flower - Login</title>
<link href="include/cash_flower_estilo.css" rel="stylesheet" type="text/css">
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">

<?php
include_once("include/conectar.php");

$email = $_POST["email"];
$senha = $_POST["senha"];
$nome = $_POST["nome"];
$sexo = $_POST["sexo"];
$nascimento = $_POST["ano_nasc"]."/".$_POST["mes_nasc"]."/".$_POST["dia_nasc"];
$pais = "Brasil";
$estado = $_POST["estado"];
$cidade = $_POST["cidade"];
$escolaridade = $_POST["escolaridade"];
$utilizacao = $_POST["utilizacao"];
$comentario = $_POST["comentario"];
$cadastramentoCorreto_ = true;
$msg = "Preencher os campos: ";


if($email==NULL) {
	$msg .= ' email,';
	$cadastramentoCorreto_ = false;
}
if($senha==NULL) {
	$msg .= ' senha,';
	$cadastramentoCorreto_ = false;
}
if($nome==NULL) {
	$msg .= ' nome,';
	$cadastramentoCorreto_ = false;
}
if($sexo=="") {
	$msg .= ' sexo,';
	$cadastramentoCorreto_ = false;
}
if($_POST["ano_nasc"]=="" or $_POST["mes_nasc"]=="" or $_POST["dia_nasc"]=="") {
	$msg .= ' data de nascimento,';
	$cadastramentoCorreto_ = false;
}
if($pais==NULL) {
	$msg .= ' país,';
	$cadastramentoCorreto_ = false;
}
if($estado=="") {
	$msg .= ' estado,';
	$cadastramentoCorreto_ = false;
}
if($cidade==NULL) {
	$msg .= ' cidade,';
	$cadastramentoCorreto_ = false;
}
if($escolaridade=="") {
	$msg .= ' escolaridade,';
	$cadastramentoCorreto_ = false;
}
if($utilizacao=="") {
	$msg .= ' utilização';
	$cadastramentoCorreto_ = false;
}

/*SE DEPOIS DESSA BATERIA DE TESTES O CADASTRO AINDA NAO TIVER ERRO, VERIFICA SE JA ESTA CADASTRADO O EMAIL*/
if(cadastramentoCorreto_==true and $email!=NULL) {
	$queryEmailString = 'SELECT `email` FROM `usuario` WHERE `email` = "'.$email.'";';
	
	$queryEmail = mysql_query($queryEmailString, $conexao) or die(mysql_error());
	
	$queryEmailArray = mysql_fetch_assoc($queryEmail);
	
	if($queryEmailArray["email"]==$email) {
		$msg = "Esta email já está sendo utilizado.";
		$cadastramentoCorreto_ = false;
	}
}

/*ESSE EMAIL NOT NULL SERVE PARA SABER SE EH A PRIMEIRA VEZ QUE ELE ENTRA NA PAGINA*/
if($cadastramentoCorreto_==true and $email!=NULL) {

	$queryInsercaoString = 'INSERT INTO `usuario` (`userID`, `email`, `senha`, `nome`, `nascimento`, `sexo`, `pais`, `estado`, `cidade`, `escolaridade`, `utilizacao`, `cometario`, `dataCadastro`, `emailValidado_`) VALUES (NULL, "'.$email.'", "'.$senha.'", "'.$nome.'", "'.$nascimento.'", "'.$sexo.'", "'.$pais.'", "'.$estado.'", "'.$cidade.'", "'.$escolaridade.'", "'.$utilizacao.'", "'.$comentario.'", NOW(), \'0\');';
	
	$queryInsercao = mysql_query($queryInsercaoString, $conexao) or die(mysql_error());
	
	$msg = 'Cadastro realizado com sucesso!';
	
	echo '<script>document.location="sucesso.php";</script>';
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
									<form method="post" action="cadastrar.php" name="formularioCadastro">
									Email (precisa ser v&aacute;lido)
									<br />
									<input name="email" type="text" size="40" value=<?php echo $email;?> ></input>
									<br />
									<br />
									Senha
									<br />
									<input name="senha" type="password" size="10" value=<?php echo $senha;?> ></input>
									<br />
									<br />
									Nome Completo
									<br />
									<input name="nome" type="text" size="40" value=<?php echo $nome;?> ></input>
									<br />
									<br />
									Sexo
									<br />
									<select name="sexo">
										<?php echo "<option value='$sexo'>$sexo</option>"; ?>
										<option value="Masculino">Masculino</option>
										<option value="Feminino">Feminino</option>
									</select>
									<br />
									<br />
									Nascimento
									<br />
									<select name="dia_nasc">
										<?php echo "<option value='$dia_nasc'>$dia_nasc</option>"; ?>
										<option value=01>01</option><option value=02>02</option><option value=03>03</option><option value=04>04</option><option value=05>05</option><option value=06>06</option><option value=07>07</option><option value=08>08</option><option value=09>09</option><option value=10>10</option><option value=11>11</option><option value=12>12</option><option value=13>13</option><option value=14>14</option><option value=15>15</option><option value=16>16</option><option value=17>17</option><option value=18>18</option><option value=19>19</option><option value=20>20</option><option value=21>21</option><option value=22>22</option><option value=23>23</option><option value=24>24</option><option value=25>25</option><option value=26>26</option><option value=27>27</option><option value=28>28</option><option value=29>29</option><option value=30>30</option><option value=31>31</option>	
									</select>
									/
									<select name="mes_nasc">
										<?php echo "<option value='$mes_nasc'>$mes_nasc</option>"; ?>
										<option value=01>01</option><option value=02>02</option><option value=03>03</option><option value=04>04</option><option value=05>05</option><option value=06>06</option><option value=07>07</option><option value=08>08</option><option value=09>09</option><option value=10>10</option><option value=11>11</option><option value=12>12</option>	
									</select>
									/
									<select name="ano_nasc">
										<?php echo "<option value='$ano_nasc'>$ano_nasc</option>"; ?>
										<option value=1900>1900</option><option value=1901>1901</option><option value=1902>1902</option><option value=1903>1903</option><option value=1904>1904</option><option value=1905>1905</option><option value=1906>1906</option><option value=1907>1907</option><option value=1908>1908</option><option value=1909>1909</option><option value=1910>1910</option><option value=1911>1911</option><option value=1912>1912</option><option value=1913>1913</option><option value=1914>1914</option><option value=1915>1915</option><option value=1916>1916</option><option value=1917>1917</option><option value=1918>1918</option><option value=1919>1919</option><option value=1920>1920</option><option value=1921>1921</option><option value=1922>1922</option><option value=1923>1923</option><option value=1924>1924</option><option value=1925>1925</option><option value=1926>1926</option><option value=1927>1927</option><option value=1928>1928</option><option value=1929>1929</option><option value=1930>1930</option><option value=1931>1931</option><option value=1932>1932</option><option value=1933>1933</option><option value=1934>1934</option><option value=1935>1935</option><option value=1936>1936</option><option value=1937>1937</option><option value=1938>1938</option><option value=1939>1939</option><option value=1940>1940</option><option value=1941>1941</option><option value=1942>1942</option><option value=1943>1943</option><option value=1944>1944</option><option value=1945>1945</option><option value=1946>1946</option><option value=1947>1947</option><option value=1948>1948</option><option value=1949>1949</option><option value=1950>1950</option><option value=1951>1951</option><option value=1952>1952</option><option value=1953>1953</option><option value=1954>1954</option><option value=1955>1955</option><option value=1956>1956</option><option value=1957>1957</option><option value=1958>1958</option><option value=1959>1959</option><option value=1960>1960</option><option value=1961>1961</option><option value=1962>1962</option><option value=1963>1963</option><option value=1964>1964</option><option value=1965>1965</option><option value=1966>1966</option><option value=1967>1967</option><option value=1968>1968</option><option value=1969>1969</option><option value=1970>1970</option><option value=1971>1971</option><option value=1972>1972</option><option value=1973>1973</option><option value=1974>1974</option><option value=1975>1975</option><option value=1976>1976</option><option value=1977>1977</option><option value=1978>1978</option><option value=1979>1979</option><option value=1980>1980</option><option value=1981>1981</option><option value=1982>1982</option><option value=1983>1983</option><option value=1984>1984</option><option value=1985>1985</option><option value=1986>1986</option><option value=1987>1987</option><option value=1988>1988</option><option value=1989>1989</option><option value=1990>1990</option><option value=1991>1991</option><option value=1992>1992</option><option value=1993>1993</option><option value=1994>1994</option><option value=1995>1995</option><option value=1996>1996</option><option value=1997>1997</option><option value=1998>1998</option><option value=1999>1999</option><option value=2000>2000</option><option value=2001>2001</option><option value=2002>2002</option>	
									</select>
									<br />
									<br />
									Estado
									<br />
									<select name="estado">
										<?php echo "<option value='$estado'>$estado</option>"; ?>
										<option value="AC" >AC</option>
										<option value="AL" >AL</option>
										<option value="AP" >AP</option>
										<option value="AM" >AM</option>
										<option value="BA" >BA</option>
										<option value="CE" >CE</option>
										<option value="DF" >DF</option>
										<option value="ES" >ES</option>
										<option value="GO" >GO</option>
										<option value="MA" >MA</option>
										<option value="MT" >MT</option>
										<option value="MS" >MS</option>
										<option value="MG" >MG</option>
										<option value="PA" >PA</option>
										<option value="PB" >PB</option>
										<option value="PR" >PR</option>
										<option value="PE" >PE</option>
										<option value="PI" >PI</option>
										<option value="RJ" >RJ</option>
										<option value="RN" >RN</option>
										<option value="RS" >RS</option>
										<option value="RO" >RO</option>
										<option value="RR" >RR</option>
										<option value="SC" >SC</option>
										<option value="SP" >SP</option>
										<option value="SE" >SE</option>
										<option value="TO" >TO</option>
									</select>
									<br />
									<br />
									Cidade
									<br />
									<input name="cidade" type="text" size="40" value=<?php echo $cidade;?> ></input>
									<br />
									<br />
									Voc&ecirc; est&aacute; cursando
									<br />
									<select name="escolaridade">
										<?php echo "<option value='$escolaridade'>$escolaridade</option>"; ?>
										<option value="Ensino Médio">Ensino M&eacute;dio</option>
										<option value="Graduação">Gradua&ccedil;&atilde;o</option>
										<option value="Pós-Graduação">P&oacute;s-Gradua&ccedil;&atilde;o</option>
										<option value="MBA">MBA</option>
										<option value="Pós-Graduação e MBA">P&oacute;s-Gradua&ccedil;&atilde;o e MBA</option>
										<option value="Nada, sem Ensino Médio">Nada, sem Ensino M&eacute;dio</option>
										<option value="Nada, mas com Ensino Médio">Nada, mas com Ensino M&eacute;dio</option>
										<option value="Nada, mas com Ensino Superior">Nada, mas com Ensino Superior</option>
										<option value="Nada, mas com Pós">Nada, mas com P&oacute;s</option>
										<option value="Nada, mas com MBA">Nada, mas com MBA</option>
										<option value="Nada, mas com Pós e MBA">Nada, mas com P&oacute;s e MBA</option>
									</select>
									<br />
									<br />
									Qual utiliza&ccedil;&atilde;o pretendida do Cash Flower
									<br />
									<select name="utilizacao">
										<?php echo "<option value='$utilizacao'>$utilizacao</option>"; ?>
										<option value="Administrar finanças pessoais">Administrar finan&ccedil;as pessoais</option>
										<option value="Fluxo de caixa da minha empresa">Fluxo de caixa da minha empresa</option>
										<option value="Controlar os gastos de dependentes">Controlar os gastos de dependentes</option>
										<option value="Outra finalidade, favor colocar em comentários">Outra finalidade, favor colocar em coment&aacute;rios</option>
									</select>
									<br />
									<br />
									Coment&aacute;rios
									<br />
									<textarea name="comentario" rows="6" cols="40" ><?php echo $comentario;?></textarea>
									<br />
									<br />
									<input type="submit" value="Cadastrar" />
									<input type="button" value="Voltar" onclick="javascript:document.location='index.php';" />
									</form>								
									</td>
								<td><h2>Vantagens em fazer o cadastro:</h2>
								<p>-Com o Cash Flower voc&ecirc; nunca mais depender&aacute; de papel e caneta, automatize suas finan&ccedil;as e descubra para onde est&aacute; indo seu dinheiro.</p>
								<p>-O programa &eacute; totalmente online, ou seja, aonde voc&ecirc; estiver voc&ecirc; pode administrar suas fina&ccedil;as, viajens sem controle de despesas nunca mais.</p>
								<p>-O fluxo de caixa &eacute; essencial para conhecer a sa&uacute;de financeira da sua empresa, aplica essa ferramente e controle suas receitas.</p></td>
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