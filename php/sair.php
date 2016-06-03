<?php
	session_start();
	
	unset($_SESSION['idSession']);
	unset($_SESSION['nomeSession']);
	unset($_SESSION['loginSession']);
	unset($_SESSION['senhaSession']);
	unset($_SESSION['rcaSession']);
	
	header("Location: index.php");
	
	exit;
?>