<?php	
	include_once("conexao.php");
	include_once("cabecalho.php");

	$conexao = con();
	$qry = "select * from participantes p";
	$query = mysqli_multi_query($conexao, $qry);
	
	if ($resultado = mysqli_use_result($conexao)) {		
		echo "
			<div class=\"container-fluid\">
				<div>
					<a href=\"cadastroParticipante.php\"><u>CADASTRAR</u></a>
				</div>
				<div class=\"panel panel-default panel-primary\">
					<div class=\"panel-heading\">
						Alunos
					</div>
		";
	
		$i = 0;
		while ($dados=mysqli_fetch_array($resultado)) {
			if ($i%2==0){
				echo "<div class=\"row\" style=\"background-color:#CCC\">";
			}else {
				echo "<div class=\"row\" style=\"background-color:#FFF\">";
			}
			echo "
					<div class=\"col-xs-3\">
						<img src=\"img/".$dados["arquivoFoto"]."\" width=\"240px\" height=\"320px\">
					</div>
					<div class=\"col-xs-9\">
						<h3><a href=\"visualizar.php?login='".utf8_encode($dados["login"])."'\">".utf8_encode($dados["nomeCompleto"])."</a></h3>
					</div>
				</div>
			";
			$i++;
		}

		echo "
			</div></div>		
		";
	}

	include_once("rodape.php");
?>