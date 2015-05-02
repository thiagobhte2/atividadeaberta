<?php
	include_once("conexao.php");
	include_once("cabecalho.php");
	
	$conexao = con();
	
	$loginTela = "";
	if (isset($_GET['loginTela'])) $loginTela = $_GET['loginTela'];
	$nomeCompleto = "";
	$login = "";
	$senha = "";
	$email = "";
	$cidade = "";
	$descricao = "";
	$acao = "";
	
	if ($loginTela!=""){
		$qry = "select * from participantes p where login=".$loginTela;
		$query = mysqli_multi_query($conexao, $qry);
		if ($resultado = mysqli_use_result($conexao)) {
			while ($dados=mysqli_fetch_array($resultado)) {			
				$nomeCompleto = $dados["nomeCompleto"];
				$login = $dados["login"];
				$senha = $dados["senha"];
				$email = $dados["email"];
				$cidade = $dados["cidade"];
				$descricao = $dados["descricao"];
				break;
			}
			mysqli_free_result($resultado);    
		}
		$acao = "editar";
		setcookie("ultimoPerfilVisitado", $dados["nomeCompleto"]);
	}else {
		$acao = "inserir";
	}
	

echo "
	<section style=\"padding:10px\">
		<form name=\"form\" action=\"acaoParticipante.php\" method=\"post\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"acao\" value=\"$acao\">
			Nome:&nbsp;&nbsp;<input name=\"nomeCompleto\" type=\"text\" maxlength=\"50\" value=\"$nomeCompleto\" />*<br/><br/>
			Login:&nbsp;&nbsp;<input name=\"login\" type=\"text\" maxlength=\"20\" value=\"$login\" />*<br/><br/>
			Senha:&nbsp;&nbsp;<input name=\"senha\" type=\"password\" maxlength=\"50\" value=\"$senha\" />*<br/><br/>
			E-mail:&nbsp;&nbsp;<input name=\"email\" type=\"text\" maxlength=\"50\" value=\"$email\" />*<br/><br/>";
		
	$qry = "select c.idCidade, c.nomeCidade, e.sigaEstado from cidades c, estados e where c.idEstado=e.idEstado order by e.sigaEstado, c.nomeCidade";
	$query = mysqli_multi_query($conexao, $qry);
		
	echo "Cidade:&nbsp;&nbsp;<select name=\"cidade\"><option value=\"-1\"></option>";

	if ($resultado = mysqli_use_result($conexao)) {
		while ($dados=mysqli_fetch_array($resultado)) {
			$selected = "";
			if ($cidade==$dados["idCidade"]){
				$selected = " selected";
			}
            echo "<option ";				
			echo "value=\"".$dados["idCidade"]."\"".$selected.">".$dados["sigaEstado"]." - ".$dados["nomeCidade"];
			echo "</option>\n";
        }
		mysqli_free_result($resultado);    
	}

	echo "</select>*<br/><br/>";
	
	echo "
		Foto:&nbsp;&nbsp;<input name=\"arquivoFoto\" type=\"file\" />*<br/><br/>
		Descrição:&nbsp;&nbsp;<textarea name=\"descricao\" maxlength=\"50\" >$descricao</textarea>*<br/><br/>";
		echo "<a href=\"javascript:form.submit()\">Salvar</a>";
		echo "</section></form>";

	include_once("rodape.php");
?>
