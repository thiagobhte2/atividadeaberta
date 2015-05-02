<?php
	include_once("conexao.php");
	include_once("cabecalho.php");
		
	$acao = $_POST['acao'];
	
	if ($_POST['login']=="" || $_POST['senha']=="" || $_POST['nomeCompleto']=="" || ($acao=="inserir" && $_FILES["arquivoFoto"]["name"]=="") || $_POST['cidade']=="" || $_POST['email']=="" ||					$_POST['descricao']==""){
		$msg = "Todos os campos são obrigatórios";
		header("Location:./cadastroParticipante.php?msg=".$msg);
	}else {
		$conexao = con();
		$basenameFile = basename($_FILES["arquivoFoto"]["name"]);
		$login = $_POST['login'];
		
		if ($acao=="inserir"){
			$stmt = $conexao->prepare("insert into participantes(login, senha, nomeCompleto, arquivoFoto, cidade, email, descricao) values (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param('ssssiss', $login, $_POST['senha'], $_POST['nomeCompleto'], $basenameFile, $_POST['cidade'], $_POST['email'], $_POST['descricao']);
			$stmt->execute();
			$stmt->close();
		}else if ($acao=="editar"){
			if ($basenameFile!=""){
				$stmt = $conexao->prepare("update participantes set login=?, senha=?, nomeCompleto=?, arquivoFoto=?, cidade=?, email=?, descricao=? where login=?");
				$stmt->bind_param('ssssisss', $login, $_POST['senha'], $_POST['nomeCompleto'], $basenameFile, $_POST['cidade'], $_POST['email'], $_POST['descricao'], $_login);
			}else {
				$stmt = $conexao->prepare("update participantes set login=?, senha=?, nomeCompleto=?, cidade=?, email=?, descricao=? where login=?");
				$stmt->bind_param('ssssisss', $login, $_POST['senha'], $_POST['nomeCompleto'], $_POST['cidade'], $_POST['email'], $_POST['descricao'], $_login);
			}			
			$stmt->execute();
			$stmt->close();
			$_SESSION['nomeCompleto'] = $_POST['nomeCompleto'];
			$_SESSION['login'] = $login;
		}
		
		if (!file_exists("img/")){
			mkdir("img/");
		}

		if (!file_exists("img/")){
			mkdir("img/");
		}

		$dirUpload = "img/".$basenameFile;
		move_uploaded_file($_FILES["arquivoFoto"]["tmp_name"], $dirUpload);
		header("Location:./index.php");
	}	
?>