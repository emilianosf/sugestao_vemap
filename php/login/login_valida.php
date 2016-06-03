<?php
	session_start();
	include("../functions.php");
	
	
	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$sql = "SELECT id, nome  FROM `usuarios` WHERE `login` ='$login' and `password` = '$senha'";
	//sprint $sql."<br />"; die;
	
	conectaMySql();
	$sqlAcesso = mysql_query($sql);
	$linha = mysql_fetch_array($sqlAcesso);
	if(mysql_num_rows($sqlAcesso)==1) {
		
		$_SESSION['idSession'] 		= $linha['id'];
		$_SESSION['nomeSession']	= $linha['nome'];
		
		geraLogAcessos($linha['nome']);
				
		redireciona("../../index.php?op=2");
	} else {

		exibeMensagem("Usuário ou senha digitados errados. Favor tente novamente!");
		redireciona("../../index.php?op=0");
		
		geraLogAcessos("Falha de login");

	}
	mysql_close();
	
?>