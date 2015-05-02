<?php	
	include_once("conexao.php");
	include_once("cabecalho.php");

	$conexao = con();
	$qry = "select * from participantes p, cidades c, estados e where p.cidade=c.idCidade and c.idEstado=e.idEstado and login=".$_GET["login"];
	$query = mysqli_multi_query($conexao, $qry);
	
	echo "<div class=\"container-fluid\">";

	if ($resultado = mysqli_use_result($conexao)) {
		while ($dados=mysqli_fetch_array($resultado)) {	
			echo "
				<div class=\"panel panel-default\">
					<div class=\"panel-heading\">
						<img src=\"img/".$dados["arquivoFoto"]."\" width=\"240px\" height=\"320px\">
					</div>				
					<div class=\"row\">
						<label class=\"col-xs-1 control-label\">Nome:</label>
						<div class=\"col-xs-11\">
							".utf8_encode($dados["nomeCompleto"])."
						</div>
					</div>
					<div class=\"row\">
						<label class=\"col-xs-1 control-label\">Login:</label>
						<div class=\"col-xs-11\">
							".utf8_encode($dados["login"])."
						</div>
					</div>
					<div class=\"row\">
						<label class=\"col-xs-1 control-label\">Cidade/Estado:</label>
						<div class=\"col-xs-11\">
							".utf8_encode($dados["nomeCidade"])."/".utf8_encode($dados["sigaEstado"])."
						</div>
					</div>
					<div class=\"row\">
						<label class=\"col-xs-1 control-label\">Email:</label>
						<div class=\"col-xs-11\">
							".utf8_encode($dados["email"])."
						</div>
					</div>
					<div class=\"row\">
						<label class=\"col-xs-1 control-label\">Descrição:</label>
						<div class=\"col-xs-11\">
							".utf8_encode($dados["descricao"])."
						</div>
					</div>
				</div>
			";
		}

		echo "
				<div>
					<a href=\"index.php\" class=\"btn\">Voltar</a>
				</div>
			</div>
		";
	}

	include_once("rodape.php");
?>